<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        if(request('urut') === 'Terlama') {
            $sortBy = 'ASC';
        } else {
            $sortBy = 'DESC';
        }

        $pasien_lama = Pasien::filter($search, $sortBy, $status)
                                ->where('status_pendaftaran', 'Pasien Lama')
                                ->paginate(12);

        return view('pasien.pasien-lama', compact('pasien_lama'));
    }

    public function getPrapasien(Request $request)
    {
        $search = $request->input('search');
        $status = '';

        if(request('urut') === 'Terlama') {
            $sortBy = 'ASC';
        } else {
            $sortBy = 'DESC';
        }

        $pasien_baru = Pasien::filter($search, $sortBy, $status)
                                ->where('status_pendaftaran', 'Prapasien')
                                ->paginate(12);

        return view('pasien.pasien-baru', compact('pasien_baru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pasien.tambah', [
            'pasien' => ''
        ]);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function show(Pasien $pasien)
    {
        $rekamMedis = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();

        if($rekamMedis->count() < 1) {
            $rmDetected = 0;
        }elseif ($rekamMedis->count() == 1) {
            $rmDetected = 1;
        }else{
            $rmDetected = 2;
        }
        
        return view('rekam-medis.detail', [
            'pasien' => $pasien,
            'rmDetected' => $rmDetected,
            'rm' =>$rekamMedis->first(),
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', [
            'pasien' => $pasien,
            'rm'=> ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pasien $pasien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasien $pasien)
    {
        if ($pasien->foto) {
            Storage::delete($pasien->foto);
        }
        Pasien::destroy($pasien->id_pasien);

        return redirect()->route('pasien.lama')
                            ->with('success', 'Pasien berhasil dihapus.')
                            ->with('delete', true);
    }
}
