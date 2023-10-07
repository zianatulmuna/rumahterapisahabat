<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use App\Models\SubRekamMedis;
use Illuminate\Support\Facades\Auth;

class GrafikDashboard extends Component
{
    public $id_terapis, $nama_terapis, $nama_penyakit;
    public $menu = 'Pasien Selesai';    
    public $grafik = 'Sesi Terapi';
    public $filter = 'tahun ini';
    public $dataGrafik, $listTerapis, $listPenyakit, $totalDataGrafik, $maxChart = 10, $tahun;

    public $userTerapis, $userAdmin;
    protected $listeners = ['setTahun', 'setTerapis', 'setPenyakit'];
    
    public function mount(){
        $this->grafik;
        $this->filter;
        $this->id_terapis;
        $this->tahun;
        
        $this->listTerapis = Terapis::orderBy('nama', 'ASC')->get();

        $this->userTerapis = Auth::guard('terapis')->user();
        $this->userAdmin = Auth::guard('admin')->user();

        if($this->userAdmin || $this->userTerapis->is_kepala) {
            $this->dataGrafik = $this->grafikPerTahun($this->grafik, date('Y'), '', '');$this->listPenyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');      
            $this->setFilterAction($this->filter);      
        } else {            
            $this->id_terapis = $this->userTerapis->id_terapis;
            $this->nama_terapis = $this->userTerapis->nama;  
            $this->setFilterAction($this->filter);           
            $this->listPenyakit = SubRekamMedis::penyakitByTerapis($this->id_terapis);
            $this->dataGrafik = $this->grafikPerTahun($this->grafik, date('Y'), $this->id_terapis, '');
        }

        $this->totalDataGrafik = array_sum(array_values($this->dataGrafik));
        $max = (!empty($this->dataGrafik)) ? $max = max($this->dataGrafik) : 0;
        $this->maxChart = ($max <= 10) ? 10 : ceil($max / 10) * 10;
    }
    
    public function render()
    {
        if($this->userAdmin || $this->userTerapis->is_kepala) {
            $terapis = $this->listTerapis;
            $penyakit = $this->listPenyakit;
    
            return view('livewire.grafik-dashboard', compact(
                'terapis',
                'penyakit',
            ));
        } else {
            $penyakit = $this->listPenyakit;
    
            return view('livewire.grafik-terapis', compact('penyakit'));
        }
    }

    public function setFilterAction($filter) {
        if($filter == 'minggu ini') {
            $this->dataGrafik = $this->grafikMingguIni($this->grafik, $this->id_terapis, $this->nama_penyakit);
        } elseif($filter == 'bulan ini') {
            $this->dataGrafik = $this->grafikBulanIni($this->grafik, $this->id_terapis, $this->nama_penyakit);
        } elseif($filter == 'tahun ini') {
            $this->dataGrafik = $this->grafikPerTahun($this->grafik, date('Y'), $this->id_terapis, $this->nama_penyakit);
        } elseif($filter == 'semua tahun') {
            $this->dataGrafik = $this->grafikSemuaTahun($this->grafik, $this->id_terapis, $this->nama_penyakit);
        } else {
            $this->dataGrafik = $this->grafikPerTahun($this->grafik, $this->tahun, $this->id_terapis, $this->nama_penyakit);         
        }

        $this->totalDataGrafik = array_sum(array_values($this->dataGrafik));

        $max = (!empty($this->dataGrafik)) ? $max = max($this->dataGrafik) : 0;
        $this->maxChart = ($max <= 10) ? 10 : ceil($max / 10) * 10;

        $scopeTerapis = $this->nama_penyakit == null ? $this->listTerapis : 
                        Terapis::terapisByPenyakit($this->nama_penyakit);

        $scopePenyakit = $this->id_terapis == null ? $this->listPenyakit :          
                        SubRekamMedis::penyakitByTerapis($this->id_terapis);

        $grafik = [
            'dataGrafik' => $this->dataGrafik,
            'maxChart' => $this->maxChart,
            'scopeTerapis' => $scopeTerapis,
            'scopePenyakit' => $scopePenyakit,
        ];

        $this->emit('chartUpdated', $grafik);
    }

    public function setMenu($current) {
        $this->grafik = $current;
        if($this->grafik != 'sesi terapi') {
            $this->id_terapis = '';
            $this->nama_terapis = '';
        }
        $this->setFilterAction($this->filter);
    }
    public function setFilter($current) {
        $this->filter = $current;
        $this->setFilterAction($this->filter);
    }
    public function setTahun($tahun) {
        $this->tahun = $tahun;
        $this->filter = 'tahun';
        $this->setFilterAction($this->filter);
    }
    public function setTerapis($terapis) {
        $this->id_terapis = $terapis['id'];
        $this->nama_terapis = $terapis['nama'];
        $this->setFilterAction($this->filter);
    }
    public function setPenyakit($nama) {
        $this->nama_penyakit = $nama;
        $this->setFilterAction($this->filter);
    }

    public function grafikMingguIni($menu, $terapis, $penyakit)
    {
        if ($menu == 'Pasien Baru') {
            $dataMingguIni = Pasien::dataMingguIni($penyakit);
        } elseif ($menu == 'Pasien Selesai') {
            $dataMingguIni = RekamMedis::dataMingguIni($penyakit);
        } else {
            $dataMingguIni = RekamTerapi::dataMingguIni($terapis, $penyakit);            
        }

        $namaHari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        $totalPerHari = [];

        foreach ($namaHari as $nama) {
            $totalPerHari[$nama] = 0; 
        }

        foreach ($dataMingguIni as $data) {
            $day = Carbon::parse($data->tanggal)->formatLocalized('%A');
            $total = $data->total;
            
            $totalPerHari[$day] = $total;
        }

        return $totalPerHari;        
    }
    
    public function grafikBulanIni($menu, $terapis, $penyakit)
    {
        
        if ($menu == 'Pasien Baru') {
            $dataBulanIni = Pasien::dataMingguIni($penyakit);
        } elseif ($menu == 'Pasien Selesai') {
            $dataBulanIni = RekamMedis::dataMingguIni($penyakit);
        } else {
            $dataBulanIni = RekamTerapi::dataMingguIni($terapis, $penyakit);
        }

        $currentDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $dataPerTanggal = $formattedData = [];
        
        while ($currentDate <= $endDate) {
            $dataPerTanggal[$currentDate->toDateString()] = 0;
            $currentDate->addDay();
        }

        foreach ($dataBulanIni as $data) {
            $total = $data->total;            
            $dataPerTanggal[$data->tanggal] = $total;
        }
        
        foreach ($dataPerTanggal as $tanggal => $total) {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $tanggal);
            $formattedDate = $carbonDate->day;
            $formattedData[$formattedDate] = $total;
        }

        return $formattedData;        
    }

    public function grafikPerTahun($menu, $tahun, $terapis, $penyakit)
    {
        if ($menu == 'Pasien Baru') {
            $dataPerBulan = Pasien::dataPerTahun($penyakit, $tahun);
        } elseif ($menu == 'Pasien Selesai') {
            $dataPerBulan = RekamMedis::dataPerTahun($penyakit, $tahun);
        } else {
            $dataPerBulan = RekamTerapi::dataPerTahun($terapis, $penyakit, $tahun);
        }

        $bulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $jumlahPerbulan = [];

        foreach ($bulan as $index => $namaBulan) {
            $dataBulan = $dataPerBulan->firstWhere('bulan', $index);
            $total = $dataBulan ? $dataBulan->total : 0;
            
            $jumlahPerbulan[$namaBulan] = $total;
        }

        return $jumlahPerbulan;
    }

    function grafikSemuaTahun($menu, $terapis, $penyakit) {
        if ($menu == 'Pasien Baru') {
            $dataPerTahun = Pasien::dataSemuaTahun($penyakit);
        } elseif ($menu == 'Pasien Selesai') {
            $dataPerTahun = RekamMedis::dataSemuaTahun($penyakit);
        } else {
            $dataPerTahun = RekamTerapi::dataSemuaTahun($terapis, $penyakit);
        }

        $tahun = []; 
        $jumlahPerTahun = []; 

        foreach ($dataPerTahun as $data) {
            $tahun[] = $data->tahun; 
            $jumlahPerTahun[$data->tahun] = $data->total; 
        }

        if (!empty($tahun)) {
            $allYears = range(min($tahun), max($tahun));
            foreach ($allYears as $year) {
                if (!isset($jumlahPerTahun[$year])) {
                    $jumlahPerTahun[$year] = 0;
                }
            }
        } else {
            $jumlahPerTahun = [];
        }

        ksort($jumlahPerTahun);

        return $jumlahPerTahun;        
    }
}
