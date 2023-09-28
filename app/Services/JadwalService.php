<?php

namespace App\Services;
 
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class JadwalService
{
    public function getJadwal(Request $request): Jadwal
    {
        $query = Jadwal::query();

        if(Auth::guard('terapis')->user()) {
            $idTerapis = Auth::guard('terapis')->user()->id_terapis;
            $query->where('id_terapis', $idTerapis);
            $view = 'pages.terapis.jadwal-terapi';
        } else {
            $view = 'pages.jadwal.jadwal';
        }

        if($request['filter']) {
            $m = $request['filter'] == "tahun-ini" ? date('Y') : date('Y-m');
            $query->where('tanggal', 'like', $m . '%');
            $caption = $request['filter'] == "tahun-ini" ? date('Y') : Carbon::today()->formatLocalized('%B %Y');
            $request = true;
        } elseif($request['tanggal']) {
            $tanggal = $request['tanggal'];
            $caption = Carbon::createFromFormat('Y-m-d', $tanggal)->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', $tanggal)->paginate(10);
        } elseif ($request['awal']) {
            $awal = Carbon::createFromFormat('Y-m-d', $request['awal'])->formatLocalized('%d %B %Y');
            $akhir = Carbon::createFromFormat('Y-m-d', request('akhir'))->formatLocalized('%d %B %Y');

            $caption = $awal . ' - ' . $akhir;
            $query->whereBetween('tanggal', [$request['awal'], request('akhir')])->paginate(10);
        } else {
            $caption = Carbon::today()->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', Carbon::today()->format('Y-m-d'))->paginate(10);
        }

        $jadwal_terapi = $query->paginate(10);
 
        return $jadwal_terapi;
    }
}