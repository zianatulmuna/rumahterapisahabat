<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use App\Models\SubRekamMedis;
use Illuminate\Support\Facades\Request;

class GrafikDashboard extends Component
{
    public $id_terapis, $penyakit;
    public $menu = 'Pasien Selesai';
    public $grafik = 'Sesi Terapi';
    public $filter = 'tahun ini';

    public $tahun, $filterTahun;
    public $dataGrafik;
    public $maxChart = 0;

    protected $listeners = ['setTahun'];
    
    public function mount(){
        $this->grafik;
        $this->filter;
        $this->tahun = Carbon::now()->year;
        $this->dataGrafik = $this->grafikPerTahun($this->grafik, $this->tahun,'', '');
        $this->maxChart = ceil(max($this->dataGrafik) / 10) * 10;
    }
    public function render()
    {
        $terapis = Terapis::orderBy('nama', 'ASC')->get();
        $penyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');

        return view('livewire.grafik-dashboard', compact(
            'terapis',
            'penyakit',
        ));
    }

    public function setFilterAction($filter) {
        if($filter == 'minggu ini') {
            $data = $this->grafikMingguIni($this->grafik, $this->id_terapis, $this->penyakit);
        } elseif($filter == 'tahun ini') {
            $data = $this->grafikPerTahun($this->grafik, $this->tahun, $this->id_terapis, $this->penyakit);
        } else {
            $data = $this->grafikSemuaTahun($this->grafik, $this->id_terapis, $this->penyakit);
        }

        $max = max($data);
        $newMax = ($max <= 10) ? 10 : ceil($max / 10) * 10;
        $this->maxChart = $newMax;

        $grafik = [
            'dataGrafik' => $data,
            'maxChart' => $newMax,
        ];

        $this->emit('chartUpdated', $grafik);
    }

    public function setMenu($current) {
        $this->grafik = $current;
        $this->setFilterAction($this->filter);
    }
    public function setFilter($current) {
        $this->filter = $current;
        $this->setFilterAction($this->filter);
    }
    public function setTahun($tahun) {
        $this->tahun = $tahun;
        $this->filterTahun = $tahun;
        $this->setFilterAction($this->filter);
    }

    public function grafikMingguIni($menu, $terapis, $penyakit)
    {
        if ($menu == 'Pasien Baru') {
            if(!empty($penyakit)) { 
                $model = Pasien::selectRaw('tanggal_pendaftaran as tanggal, COUNT(*) as total')
                                ->whereHas('rekamMedis', function ($query) use ($penyakit) {
                                    $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                });
            } else {
                $model = Pasien::selectRaw('tanggal_pendaftaran as tanggal, COUNT(*) as total');
            }
            $tanggal = 'tanggal_pendaftaran';
        } elseif ($menu == 'Pasien Selesai') {
            if(!empty($penyakit)) { 
                $model = RekamMedis::where('status_pasien', 'Selesai')
                                ->where('penyakit', 'like', '%' . $penyakit . '%')
                                ->selectRaw('tanggal_selesai as tanggal, COUNT(*) as total');
            } else {
                $model = RekamMedis::where('status_pasien', 'Selesai')
                                    ->selectRaw('tanggal_selesai as tanggal, COUNT(*) as total');
            }
            $tanggal = 'tanggal_selesai';
        } else {
            if(!empty($terapis) && !empty($penyakit)) {
                $model = RekamTerapi::where('id_terapis', $terapis)
                                    ->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                                        $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                    })
                                    ->selectRaw('tanggal, COUNT(*) as total');
            } else {
                if(!empty($terapis)) {
                    $model = RekamTerapi::where('id_terapis', $terapis)
                                        ->selectRaw('tanggal, COUNT(*) as total');
                } elseif(!empty($penyakit)) {
                    $model = RekamTerapi::whereHas('subRekamMedis', function ($query) use ($penyakit) {
                                            $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                        })
                                        ->selectRaw('tanggal, COUNT(*) as total');
                } else {
                    $model = RekamTerapi::selectRaw('tanggal, COUNT(*) as total');
                }
            }
            $tanggal = 'tanggal';
        }
        
        $year = Carbon::now()->year;
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $dataMingguIni = $model->whereYear($tanggal, $year)
            ->where($tanggal, '>=', $startOfWeek->format('Y-m-d'))
            ->where($tanggal, '<=', $endOfWeek->format('Y-m-d'))
            ->groupBy($tanggal)
            ->get();

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
            $namaHariData = Carbon::parse($data->tanggal)->formatLocalized('%A');
            $totalHariData = $data->total;
            
            $totalPerHari[$namaHariData] = $totalHariData;
        }

        return $totalPerHari;
        
    }

    public function grafikPerTahun($menu, $tahun, $terapis, $penyakit)
    {
        if ($menu == 'Pasien Baru') {
            // dd($menu);
            if(!empty($penyakit)) { 
                $model = Pasien::selectRaw('MONTH(tanggal_pendaftaran) as bulan, COUNT(*) as total')
                                ->whereHas('rekamMedis', function ($query) use ($penyakit) {
                                    $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                });
            } else {
                $model = Pasien::selectRaw('MONTH(tanggal_pendaftaran) as bulan, COUNT(*) as total');
            }
            $tanggal = 'tanggal_pendaftaran';
        } 
        elseif ($menu == 'Pasien Selesai') { 
            if(!empty($penyakit)) { 
                $model = RekamMedis::where('status_pasien', 'Selesai')
                                ->where('penyakit', 'like', '%' . $penyakit . '%')
                                ->selectRaw('MONTH(tanggal_selesai) as bulan, COUNT(*) as total');
            } else {
                $model = RekamMedis::where('status_pasien', 'Selesai')
                                ->selectRaw('MONTH(tanggal_selesai) as bulan, COUNT(*) as total');
            }
            
            $tanggal = 'tanggal_selesai';
        } 
        else {
            if(!empty($terapis) && !empty($penyakit)) {
                $model = RekamTerapi::where('id_terapis', $terapis)
                                    ->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                                        $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                    })
                                    ->selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total');
            } else {
                if(!empty($terapis)) {
                    $model = RekamTerapi::where('id_terapis', $terapis)
                                        ->selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total');
                } else if(!empty($penyakit)) {                
                    $model = RekamTerapi::whereHas('subRekamMedis', function ($query) use ($penyakit) {
                                            $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                        })
                                        ->selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total');
                } else {
                    $model = RekamTerapi::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total');
                }
            }
            $tanggal = 'tanggal';
        }

        $dataPerbulan = $model->whereYear($tanggal, $tahun)->groupBy('bulan')->get();
        // dd($dataPerbulan);
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
            $dataBulan = $dataPerbulan->firstWhere('bulan', $index);
            $total = $dataBulan ? $dataBulan->total : 0;
            
            $jumlahPerbulan[$namaBulan] = $total;
        }
        return $jumlahPerbulan;
    }

    function grafikSemuaTahun($menu, $terapis, $penyakit) {
        if ($menu == 'Pasien Baru') {
            if(!empty($penyakit)) { 
                $model = Pasien::whereHas('rekamMedis', function ($query) use ($penyakit) {
                                    $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                })
                                ->selectRaw('YEAR(tanggal_pendaftaran) as tahun, COUNT(*) as total');
            } else {
                $model = Pasien::selectRaw('YEAR(tanggal_pendaftaran) as tahun, COUNT(*) as total');
            }
        } 
        elseif ($menu == 'Pasien Selesai') { 
            if(!empty($penyakit)) { 
                $model = RekamMedis::where('status_pasien', 'Selesai')
                                ->where('penyakit', 'like', '%' . $penyakit . '%')
                                ->selectRaw('YEAR(tanggal_selesai) as tahun, COUNT(*) as total');
            } else {
                $model = RekamMedis::where('status_pasien', 'Selesai')
                                ->selectRaw('YEAR(tanggal_selesai) as tahun, COUNT(*) as total');
            }
        } 
        else {
            if(!empty($terapis) && !empty($penyakit)) {
                $model = RekamTerapi::where('id_terapis', $terapis)
                                    ->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                                        $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                    })
                                    ->selectRaw('YEAR(tanggal) as tahun, COUNT(*) as total');
            } else {
                if(!empty($terapis)) {
                    $model = RekamTerapi::where('id_terapis', $terapis)
                                        ->selectRaw('YEAR(tanggal) as tahun, COUNT(*) as total');
                } elseif(!empty($penyakit)) {                
                    $model = RekamTerapi::whereHas('subRekamMedis', function ($query) use ($penyakit) {
                                            $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                        })
                                        ->selectRaw('YEAR(tanggal) as tahun, COUNT(*) as total');
                } else {
                    $model = RekamTerapi::selectRaw('YEAR(tanggal) as tahun, COUNT(*) as total');
                }
            }
        }

        $dataPerTahun = $model->groupBy('tahun')->orderBy('tahun', 'ASC')->get();

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