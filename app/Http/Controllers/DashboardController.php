<?php

namespace App\Http\Controllers;

use App\Models\Terapis;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun = date('Y');

        $pasienTotal = Pasien::count();
        $prapasienTahunIni = Pasien::whereYear('tanggal_pendaftaran', $tahun)->count();
        $terapiTahunIni = RekamTerapi::whereYear('tanggal', $tahun)->count();
        $rekamMedisTahunIni = RekamMedis::whereYear('tanggal_registrasi', $tahun)->count();
        $rawatJalanTahunIni = RekamMedis::whereYear('tanggal_registrasi', $tahun)
            ->where('status_pasien', 'Rawat Jalan')
            ->count();
        $jedaTahunIni = RekamMedis::whereYear('tanggal_registrasi', $tahun)
            ->where('status_pasien', 'Jeda ')->count();
        $selesaiTahunIni = RekamMedis::whereYear('tanggal_registrasi', $tahun)
            ->where('status_pasien', 'Selesai')->count();

        if (Auth::guard('admin')->check()) {
            $view = 'pages.dashboard.dashboard-admin';
        } elseif (Auth::guard('terapis')->user()->is_kepala) {
            $view = 'pages.dashboard.dashboard-kepala-terapis';
        } elseif (Auth::guard('terapis')->user()) {
            $view = 'pages.dashboard.dashboard-terapis';
        }

        return view($view, compact(
            'terapiTahunIni',
            'prapasienTahunIni',
            'pasienTotal',
            'rekamMedisTahunIni',
            'jedaTahunIni',
            'rawatJalanTahunIni',
            'selesaiTahunIni'
        ));
    }

    function landingPage() {
        $terapis_ready = Terapis::where('is_ready', 1)->get();

        return view('pages.landing-page.landing-page', compact('terapis_ready'));
    }
}
