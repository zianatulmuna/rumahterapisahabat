<?php

namespace App\Http\Controllers;

// use Livewire\Kernel;
use Carbon\Carbon;
use App\Models\Terapis;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use App\Http\Livewire\TerapisReady;
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
        return view('pages.terapis.tambah');
    }

    public function detail(Terapis $terapis)
    {
        $query = RekamTerapi::query();

        $request = false;
        
        if(request('filter') === "tahun-ini") {
            $m = date('Y');
            $query->where('tanggal', 'like', $m . '%');
            $caption = $m;
            $request = true;
        } elseif(request('tanggal')) {
            $query->where('tanggal', request('tanggal'));
            $caption = Carbon::parse(request('tanggal'))->formatLocalized('%d %B %Y');
            $request = true;
        } elseif(request('awal')) {
            $query->whereBetween('tanggal', [request('awal'), request('akhir')]);
            $awal = Carbon::parse(request('awal'))->formatLocalized('%d %B %Y');
            $akhir = Carbon::parse(request('akhir'))->formatLocalized('%d %B %Y');
            $caption = $awal . " - " . $akhir;
            $request = true;
        } else {
            $m = date('Y-m');
            $query->where('tanggal', 'like', $m . '%');
            $caption = Carbon::today()->formatLocalized('%B %Y'); 
        }
        
        $jumlah_terapi = $query->where('id_terapis', $terapis->id_terapis)->count();
        
        $tanggal_caption = $jumlah_terapi . " Terapi (" . $caption . ")";

        $histori_terapi = $query->where('id_terapis', $terapis->id_terapis)
                            ->orderBy('tanggal', 'DESC')
                            ->paginate(10);

        $tanggal_lahir = Carbon::parse($terapis->tanggal_lahir)->formatLocalized('%d %B %Y'); 

        if(Auth::guard('admin')->user() || Auth::guard('kepala_terapis')->user()) {
            $view = 'pages.terapis.detail';
        } elseif(Auth::guard('terapis')->user()) {
            $view = 'pages.terapis.sesi-terapi';
        }

        return view($view, compact(
            'terapis', 
            'histori_terapi', 
            'tanggal_caption',
            'tanggal_lahir', 
            'request'
        ));
    }

    public function edit(Terapis $terapis)
    {        
        return view('pages.terapis.edit', compact('terapis'));
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

    
}
