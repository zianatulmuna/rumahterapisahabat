<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = Carbon::now()->format('Y');

        $terapiTahunIni = RekamTerapi::whereYear('tanggal', $tahun)->count();

        $prapasienTahunIni = Pasien::whereYear('tanggal_pendaftaran', $tahun)->count();

        $pasienTotal = Pasien::count();

        $rekamMedisTahunIni = RekamMedis::whereYear('tanggal_ditambahkan', $tahun)->count();

        $rawatJalanTahunIni = RekamMedis::whereYear('tanggal_ditambahkan', $tahun)
                                ->where('status_pasien', 'Rawat Jalan')
                                ->count();

        $jedaTahunIni = RekamMedis::whereYear('tanggal_ditambahkan', $tahun)
                            ->where('status_pasien', 'Jeda ')->count();

        $selesaiTahunIni = RekamMedis::whereYear('tanggal_ditambahkan', $tahun)
                            ->where('status_pasien', 'Selesai')->count();

        if(Auth::guard('admin')->user() || Auth::guard('kepala_terapis')->user()) {
            $view = 'admin.beranda';
        } elseif(Auth::guard('terapis')->user()) {
            $view = 'terapis.beranda';
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
}
