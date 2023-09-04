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
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $terapiBulanIni = $this->dataCardTerapi();
        $prapasienBulanIni = $this->dataCardPasienBaru();
        $rawatJalanBulanIni = $this->dataCardPasienRawat();
        $selesaiBulanIni = $this->dataCardPasienSelesai();

        // $tahunTersedia = $this->selectTahun();

        if(Auth::guard('admin')->user() || Auth::guard('kepala_terapis')->user()) {
            $view = 'admin.beranda';
        } elseif(Auth::guard('terapis')->user()) {
            $view = 'terapis.beranda';
        }
        return view($view, compact(
            // 'tahunTersedia', 
            'terapiBulanIni', 
            'prapasienBulanIni', 
            'rawatJalanBulanIni', 
            'selesaiBulanIni'
        ));
    }

    // function selectTahun() {
    //     $tahunTersedia = RekamTerapi::selectRaw('YEAR(tanggal) as tahun')
    //         ->groupBy('tahun')
    //         ->orderBy('tahun', 'desc')
    //         ->pluck('tahun');
    //     return ($tahunTersedia);
    // }

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

    // public function setReady(Request $request)
    // {
    //     Terapis::where('username', $request->username)->update([
    //         'is_ready' => $request->status,
    //     ]);
    //     $totalReady = Terapis::where('is_ready', 1)->count();
    //     return response()->json(['total' => $totalReady]);
    // }
}
