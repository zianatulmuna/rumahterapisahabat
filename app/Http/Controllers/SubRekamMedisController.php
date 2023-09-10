<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\SubRekamMedis;
use Illuminate\Http\Request;

class SubRekamMedisController extends Controller
{
    public function histori(Pasien $pasien) 
    {
        $rmTerkini = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();
        $rmTerdahulu = $pasien->rekamMedis()->where('status_pasien', '!=', 'Rawat Jalan')->get();

        if(count($rmTerkini) > 0 || count($rmTerdahulu) > 0) {
            $rmDetected = 1;
        } else {
            $rmDetected = 0;
        }

        return view('rekam-terapi.histori', [
            'rmDetected' => $rmDetected,
            'rm' => $rmTerkini->first(),
            'rm_terkini' => $rmTerkini,
            'rm_terdahulu' => $rmTerdahulu,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    public function detail(Pasien $pasien, SubRekamMedis $subRM)
    {
        $rekam = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();

        return view('rekam-terapi.rekam-terapi', [
            'rekam_terapi' => $rekam,
            'sub' => $subRM,
            'rmDetected' => 1,
            'rm' => $subRM->rekamMedis,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    public function delete(Pasien $pasien, SubRekamMedis $subRM)
    {

        $stringWithoutSpaces = str_replace(', ', ',', $subRM->rekamMedis->penyakit);
        
        $penyakitArray = explode(",", $stringWithoutSpaces);

        $remove = $subRM->penyakit;
        $resultArray = array_diff($penyakitArray, [$remove]);

        $dataRM['penyakit'] = implode(",", $resultArray);
        
        SubRekamMedis::destroy($subRM->id_sub);
        RekamMedis::where('id_rekam_medis', $subRM->rekamMedis->id_rekam_medis)->update($dataRM);

        return redirect(route('sub.histori', [$pasien->slug, $subRM->id_sub]))
                            ->with('success', 'Terapi Harian berhasil dihapus.')
                            ->with('delete', true);
    }

    public function tagPenyakit(Request $request) 
    {
        $search = $request->input('search');

        if(request('urut') === 'Terlama') {
            $sortBy = 'ASC';
        } else {
            $sortBy = 'DESC';
        }

        $sub_penyakit = SubRekamMedis::filter($search, $sortBy)
                                ->paginate(12);

        return view('rekam-terapi.tagging', compact('sub_penyakit'));
    }
}
