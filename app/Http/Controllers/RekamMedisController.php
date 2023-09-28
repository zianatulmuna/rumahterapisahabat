<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    public function histori(Pasien $pasien) 
    {
        $rmTerkini = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();
        $rmTerdahulu = $pasien->rekamMedis()->where('status_pasien', '!=', 'Rawat Jalan')->get();
        $rmDetected = 0;
        
        if(count($rmTerkini) > 0 || count($rmTerdahulu) > 0) {
            $rmDetected = 1;
        }

        return view('pages.rekam-medis.histori-rekam-medis', [
            'rmDetected' => $rmDetected,
            'rm_terkini' => $rmTerkini,
            'rm_terdahulu' => $rmTerdahulu,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    public function add(Pasien $pasien)
    {
        return view('pages.pasien.tambah-pasien', [
            'pasien' => $pasien
        ]);
    }

    public function detail(Pasien $pasien, RekamMedis $rekamMedis)
    {
        return view('pages.rekam-medis.rekam-medis', [
            'rmDetected' => 1,
            'rm' => $rekamMedis,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }
    
    public function edit(Pasien $pasien, RekamMedis $rekamMedis)
    {
        $rm = $rekamMedis;
        return view('pages.pasien.edit-pasien', compact('pasien', 'rm'));
    }

    public function delete(Pasien $pasien, RekamMedis $rekamMedis)
    {
        RekamMedis::destroy($rekamMedis->id_rekam_medis);

        return redirect()->route('pasien.rm', $pasien->slug)
                            ->with('success', 'Rekam Medis berhasil dihapus.')
                            ->with('delete', true);
    }

    public function print(Pasien $pasien, RekamMedis $rekamMedis)
    {
        return view('pages.unduh.unduh-rekam-medis', [
            'rm' => $rekamMedis,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }
}
