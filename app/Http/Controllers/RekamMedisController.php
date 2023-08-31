<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    public function histori(Pasien $pasien) 
    {
        $rmTerkini = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();
        $rmTerdahulu = $pasien->rekamMedis()->where('status_pasien', '!=', 'Rawat Jalan')->get();
        $rmDetected = 0;
        
        if(count($rmTerkini) > 0 || count($rmTerdahulu) > 0) {
            $rmDetected = 1;
        }

        return view('admin.rekam-medis.histori', [
            'rmDetected' => $rmDetected,
            'rm_terkini' => $rmTerkini,
            'rm_terdahulu' => $rmTerdahulu,
            // 'rm' =>$rekamMedis->first(),
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pasien $pasien)
    {
        return view('admin.pasien.tambah', [
            'pasien' => $pasien
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function show(Pasien $pasien, RekamMedis $rekamMedis)
    {
        // $arrayPenyakit = collect(explode(",", $rekamMedis->penyakit));

        return view('admin.rekam-medis.detail', [
            'rmDetected' => 1,
            'rm' => $rekamMedis,
            'pasien' => $pasien,
            // 'penyakit' => $arrayPenyakit,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasien $pasien, RekamMedis $rekamMedis)
    {
        return view('admin.pasien.edit', [
            'rm' => $rekamMedis,
            'pasien' => $pasien
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekamMedis  $rekamMedis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasien $pasien, RekamMedis $rekamMedis)
    {
        RekamMedis::destroy($rekamMedis->id_rekam_medis);

        return redirect()->route('pasien.rm', $pasien->slug)
                            ->with('success', 'Rekam Medis berhasil dihapus.')
                            ->with('delete', true);
    }
}
