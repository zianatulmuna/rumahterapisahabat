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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                                ->paginate(24);

        return view('admin.pasien.pasien-lama', compact('pasien_lama'));
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
                                ->paginate(20);

        return view('admin.pasien.pasien-baru', compact('pasien_baru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pasien.tambah', [
            'pasien' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataDiri = $request->validate([            
            'nama' => 'max:50',
            'email' => 'max:35',
            'alamat' => 'required|max:100',
            'no_telp' => 'numeric',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required'
        ]);
        
        $dateY = substr(Carbon::parse($request->date)->format('Y'), 2);
        $idPasien = IdGenerator::generate(['table' => 'pasien', 'field' => 'id_pasien', 'length' => 7, 'prefix' => 'P'.$dateY]);
        
        $dataDiri['id_pasien'] = $idPasien;
        $dataDiri['status_pendaftaran'] = 'Pasien Lama';
        $dataDiri['slug'] = SlugService::createSlug(Pasien::class, 'slug', $request->nama);

        Pasien::create($dataDiri);

        return redirect('/admin/pasien-baru')->with('success', '');        
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
        
        return view('admin.rekam-medis.detail', [
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
        return view('admin.pasien.edit', [
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
