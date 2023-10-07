<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function histori(Pasien $pasien) 
    {
        $rm = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->first();
        $rm_terdahulu = $pasien->rekamMedis()->where('status_pasien', '!=', 'Rawat Jalan')->get();
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;
        $rmDetected = 0;

        if($rm || count($rm_terdahulu) > 0) {
            $rmDetected = 1;
        }

        $userTerapis = Auth::guard('terapis')->user();
        $isTerkiniAllowed = $isTerdahuluAllowed = 1;

        if(($rm && $rm->is_private) && $userTerapis && !$userTerapis->is_kepala) {
            $isTerkiniAllowed = $rm->id_terapis == $userTerapis->id_terapis ? 1 : 0;
        }

        return view('pages.rekam-medis.histori-rekam-medis', compact(
            'rmDetected',
            'isTerkiniAllowed',
            'isTerdahuluAllowed',
            'rm',
            'rm_terdahulu',
            'pasien',
            'umur'
        ));
    }

    public function add(Pasien $pasien)
    {
        return view('pages.pasien.tambah-pasien', [
            'pasien' => $pasien
        ]);
    }

    public function detail(Pasien $pasien, RekamMedis $rekamMedis)
    {
        $rm = $rekamMedis;
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;

        $userTerapis = Auth::guard('terapis')->user();
        $isAllowed = 1;

        if($userTerapis && !$userTerapis->is_kepala && $rm->is_private) {
            $isAllowed = $rm->id_terapis == $userTerapis->id_terapis ? 1 : 0;
        }

        return view('pages.rekam-medis.rekam-medis', compact(
            'pasien',
            'rm',
            'umur',
            'isAllowed'
        ));
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
