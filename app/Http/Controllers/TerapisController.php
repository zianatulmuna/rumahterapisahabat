<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Terapis;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TerapisController extends Controller
{
    public function index(Request $request)
    {
        $terapis = Terapis::latest()->filter(request(['search', 'tingkatan']))->paginate(20);
        $tingkatan = ['Utama', 'Madya', 'Muda', 'Pratama', 'Latihan'];

        return view('pages.terapis.terapis', compact('terapis', 'tingkatan'));
    }

    public function add()
    {
        return view('pages.terapis.tambah-terapis');
    }

    public function detail(Terapis $terapis, Request $request)
    {
        $query = $queryRecap = RekamTerapi::query()->where('id_terapis', $terapis->id_terapis);

        $request = false;

        if (request('filter') === "tahun-ini") {
            $m = date('Y');
            $query->where('tanggal', 'like', $m . '%');
            $queryRecap->where('tanggal', 'like', $m . '%');
            $caption = $captionFilter = $m;
            $request = true;
        } elseif (request('tanggal')) {
            $query->where('tanggal', request('tanggal'));
            $queryRecap->where('tanggal', request('tanggal'));
            $caption = $captionFilter = Carbon::parse(request('tanggal'))->formatLocalized('%d %B %Y');
            $request = true;
        } elseif (request('awal')) {
            $query->whereBetween('tanggal', [request('awal'), request('akhir')]);
            $queryRecap->whereBetween('tanggal', [request('awal'), request('akhir')]);
            $awal = Carbon::parse(request('awal'))->formatLocalized('%d %B %Y');
            $akhir = Carbon::parse(request('akhir'))->formatLocalized('%d %B %Y');
            $caption = $awal . " - " . $akhir;
            $captionFilter = Carbon::parse(request('awal'))->format('d/m/Y') . " - " . Carbon::parse(request('akhir'))->format('d/m/Y');
            $request = true;
        } else {
            $m = date('Y-m');
            $query->where('tanggal', 'like', $m . '%');
            $caption = $captionFilter = Carbon::today()->formatLocalized('%B %Y');
        }

        $jumlah_terapi = $query->count() . ' Terapi';

        if (request('tab')) {
            $rekap_terapi = $query->selectRaw('id_sub, COUNT(*) as total')
                ->groupBy('id_sub')
                ->paginate(10);
            $histori_terapi = [];
        } else {
            $histori_terapi = $query->orderBy('tanggal', 'DESC')->paginate(10);
            $rekap_terapi = [];
        }

        $tanggal_lahir = $terapis->tanggal_lahir = '' ? '' : Carbon::parse($terapis->tanggal_lahir)->formatLocalized('%d %B %Y');

        return view('pages.terapis.detail-terapis', compact(
            'terapis',
            'histori_terapi',
            'caption',
            'captionFilter',
            'jumlah_terapi',
            'tanggal_lahir',
            'request',
            'rekap_terapi'
        )
        );
    }

    public function edit(Terapis $terapis)
    {
        return view('pages.terapis.edit-terapis', compact('terapis'));
    }

    public function delete(Terapis $terapis)
    {
        if ($terapis->foto) {
            Storage::delete($terapis->foto);
        }

        Terapis::destroy($terapis->id_terapis);

        return redirect(route('terapis'))
            ->with('success', 'Data Terapis berhasil dihapus')
            ->with('delete', true);
    }

    public function setReady(Request $request)
    {
        Terapis::where('id_terapis', $request->id)->update([
            'is_ready' => $request->status,
        ]);
    }

    public function sesiTerapi()
    {
        $terapis = Auth::guard('terapis')->user();
        $tanggal_lahir = $terapis->tanggal_lahir = '' ? '' : Carbon::parse($terapis->tanggal_lahir)->formatLocalized('%d %B %Y');

        $query = RekamTerapi::query();

        $request = false;

        if (request('filter') === "tahun-ini") {
            $query->where('tanggal', 'like', date('Y') . '%');
            $caption = date('Y');
            $request = true;
        } elseif (request('tanggal')) {
            $query->where('tanggal', request('tanggal'));
            $caption = Carbon::parse(request('tanggal'))->formatLocalized('%d %B %Y');
            $request = true;
        } elseif (request('awal')) {
            $query->whereBetween('tanggal', [request('awal'), request('akhir')]);
            $awal = Carbon::parse(request('awal'))->formatLocalized('%d %B %Y');
            $akhir = Carbon::parse(request('akhir'))->formatLocalized('%d %B %Y');
            $caption = $awal . " - " . $akhir;
            $request = true;
        } else {
            $query->where('tanggal', 'like', date('Y-m') . '%');
            $caption = Carbon::today()->formatLocalized('%B %Y');
        }

        $jumlah_terapi = $query->where('id_terapis', $terapis->id_terapis)->count();

        $tanggal_caption = $jumlah_terapi . " Terapi (" . $caption . ")";

        $histori_terapi = $query->where('id_terapis', $terapis->id_terapis)
            ->orderBy('tanggal', 'DESC')
            ->paginate(10);

        return view('pages.terapis.terapi-terapis', compact(
            'terapis',
            'histori_terapi',
            'tanggal_caption',
            'tanggal_lahir',
            'request'
        )
        );
    }


}