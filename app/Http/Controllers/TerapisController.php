<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Terapis;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TerapisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $terapis = Terapis::latest()->filter(request(['search', 'tingkatan']))->paginate(20);
        $tingkatan = ['Utama', 'Madya', 'Muda', 'Pratama', 'Latihan'];

        return view('admin.terapis.terapis', compact('terapis', 'tingkatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.terapis.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Terapis  $terapis
     * @return \Illuminate\Http\Response
     */
    public function show(Terapis $terapis)
    {
        $histori_terapi = RekamTerapi::where('id_terapis', $terapis->id_terapis)->orderBy('tanggal', 'DESC')->paginate(10);
        $tanggal_lahir = Carbon::parse($terapis->tanggal_lahir)->formatLocalized('%d %B %Y');

        return view('admin.terapis.detail', compact('terapis', 'histori_terapi', 'tanggal_lahir'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Terapis  $terapis
     * @return \Illuminate\Http\Response
     */
    public function edit(Terapis $terapis)
    {
        
        return view('admin.terapis.edit', compact('terapis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Terapis  $terapis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terapis $terapis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Terapis  $terapis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terapis $terapis)
    {
        if ($terapis->foto) {
            Storage::delete($terapis->foto);
        }

        Terapis::destroy($terapis->id_terapis);

        return redirect(route('terapis'))
                            ->with('success', 'Data Terapis berhasil dihapus')   
                            ->with('delete', true); 
    }
}
