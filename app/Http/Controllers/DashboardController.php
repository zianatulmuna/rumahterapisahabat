<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Terapis;
use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $max = 0; 
        // $idTerapis = '';

        // if(request('terapis')) {            
        //     $idTerapis = Terapis::where('nama', request('terapis'))->value('id_terapis');
        // }

        // if (!request('grafik') && !request('filter')) {
        //     request()->merge(['filter' => 'tahun-ini', 'grafik' => 'sesi terapi']);
        //     $dataGrafik = $this->grafikPerTahun(request('grafik'), Carbon::now()->year, $idTerapis, request('penyakit'));
        //     $max = max($dataGrafik);
        // } elseif(request('filter') === 'tahun-ini'){
        //     $dataGrafik = $this->grafikPerTahun(request('grafik'), Carbon::now()->year, $idTerapis, request('penyakit'));
        //     $max = max($dataGrafik);
        // } elseif (request('filter') === 'semua-tahun') {
        //     $dataGrafik = $this->grafikSemuaTahun(request('grafik'), $idTerapis, request('penyakit')); 
        //     if(!empty($dataGrafik))  {
        //         $max = max($dataGrafik);
        //     } 
        // } elseif (request('filter') === 'minggu') {
        //     $dataGrafik = $this->grafikMingguIni(request('grafik'), $idTerapis, request('penyakit'));
        //     $max = max($dataGrafik);
        // } else {
        //     $dataGrafik = $this->grafikPerTahun(request('grafik'), request('filter'), $idTerapis, request('penyakit'));
        //     $max = max($dataGrafik);
        // }

        // if($max <= 10) {
        //     $maxChart = 10;
        // } else {
        //     $maxChart = ceil($max / 10) * 10;
        // }

        $terapiBulanIni = $this->dataCardTerapi();
        $prapasienBulanIni = $this->dataCardPasienBaru();
        $rawatJalanBulanIni = $this->dataCardPasienRawat();
        $selesaiBulanIni = $this->dataCardPasienSelesai();

        $tahunTersedia = $this->selectTahun();

        // $terapis = Terapis::orderBy('nama', 'ASC')->get();
        // $terapisReady = $terapis->where('is_ready', 1)->count();
        // $terapisForReady = Terapis::orderBy('is_ready', 'DESC')->orderBy('nama', 'ASC')->get();
        // $penyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');

        // $today = Carbon::today()->formatLocalized('%A, %d %B %Y');
        // $jadwal_terapi = Jadwal::where('tanggal', Carbon::today()->format('Y-m-d'))->paginate(10);

        // if(request('tanggal')) {
        //     $tanggal = request('tanggal');
        //     $today = Carbon::createFromFormat('Y-m-d', $tanggal)->formatLocalized('%A, %d %B %Y');
        //     $jadwal_terapi = Jadwal::where('tanggal', $tanggal)->paginate(10);
        // } elseif (request('mulai')) {
        //     $awal = Carbon::createFromFormat('Y-m-d', request('mulai'))->formatLocalized('%d %B %Y');
        //     $akhir = Carbon::createFromFormat('Y-m-d', request('akhir'))->formatLocalized('%d %B %Y');

        //     $today = $awal . ' - ' . $akhir;
        //     $jadwal_terapi = Jadwal::whereBetween('tanggal', [request('mulai'), request('akhir')])->paginate(10);
        // }

        return view('admin.beranda', compact(
            // 'jadwal_terapi', 
            // 'today', 
            'tahunTersedia', 
            'terapiBulanIni', 
            'prapasienBulanIni', 
            'rawatJalanBulanIni', 
            'selesaiBulanIni'
        ));

        // return view('admin.dashboard', compact(
        //     'terapis', 'penyakit', 'dataGrafik', 'maxChart'
        // ));
    }

    public function grafikMingguIni($menu, $terapis, $penyakit)
    {
        if ($menu == 'pasien-baru') {
            if(!empty($penyakit)) { 
                $model = Pasien::selectRaw('tanggal_pendaftaran as tanggal, COUNT(*) as total')
                                ->whereHas('rekamMedis', function ($query) use ($penyakit) {
                                    $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                });
            } else {
                $model = Pasien::selectRaw('tanggal_pendaftaran as tanggal, COUNT(*) as total');
            }
            $tanggal = 'tanggal_pendaftaran';
        } elseif ($menu == 'pasien-selesai') {
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
        if ($menu == 'pasien-baru') {
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
        elseif ($menu == 'pasien-selesai') { 
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
        if ($menu == 'pasien-baru') {
            if(!empty($penyakit)) { 
                $model = Pasien::whereHas('rekamMedis', function ($query) use ($penyakit) {
                                    $query->where('penyakit', 'like', '%' . $penyakit . '%');
                                })
                                ->selectRaw('YEAR(tanggal_pendaftaran) as tahun, COUNT(*) as total');
            } else {
                $model = Pasien::selectRaw('YEAR(tanggal_pendaftaran) as tahun, COUNT(*) as total');
            }
        } 
        elseif ($menu == 'pasien-selesai') { 
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

    function selectTahun() {
        $tahunTersedia = RekamTerapi::selectRaw('YEAR(tanggal) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        return ($tahunTersedia);
    }

    function dataCardTerapi() {
        $bulanIni = Carbon::now()->format('n');

        $dataPerbulan = RekamTerapi::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $dataBulanIni = $dataPerbulan->firstWhere('bulan', $bulanIni);

        $jumlahDataBulanIni = $dataBulanIni ? $dataBulanIni->total : 0;

        return ($jumlahDataBulanIni);

    }
    function dataCardPasienBaru() {
        $bulanIni = Carbon::now()->format('n');

        $dataPerbulan = Pasien::selectRaw('MONTH(tanggal_pendaftaran) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pendaftaran', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $dataBulanIni = $dataPerbulan->firstWhere('bulan', $bulanIni);

        $jumlahDataBulanIni = $dataBulanIni ? $dataBulanIni->total : 0;

        return ($jumlahDataBulanIni);
    }
    function dataCardPasienRawat() {
        $totalRawatJalan = RekamMedis::where('status_pasien', 'Rawat Jalan')->count();

        return ($totalRawatJalan);
    }
    function dataCardPasienSelesai() {

        $totalSelesai = RekamMedis::where('status_pasien', 'selesai')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', Carbon::now()->month)
            ->count();
        
        return $totalSelesai;
    }

    public function setReady(Request $request)
    {
        Terapis::where('username', $request->username)->update([
            'is_ready' => $request->status,
        ]);
        $totalReady = Terapis::where('is_ready', 1)->count();
        return response()->json(['total' => $totalReady]);
    }
}
