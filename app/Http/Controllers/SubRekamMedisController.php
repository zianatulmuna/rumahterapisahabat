<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Terapis;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Illuminate\Support\Facades\Auth;

class SubRekamMedisController extends Controller
{
    public function histori(Pasien $pasien) 
    {
        $rm = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->first();
        $rm_terdahulu = $pasien->rekamMedis()->where('status_pasien', '!=', 'Rawat Jalan')->get();
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;
        $rmDetected = 0;

        if( $rm || count($rm_terdahulu) > 0) {
            $rmDetected = 1;
        }

        $userTerapis = Auth::guard('terapis')->user();
        $isTerkiniAllowed = $isTerdahuluAllowed = 1;

        if(($rm && $rm->is_private) && $userTerapis && !$userTerapis->is_kepala) {
            $isTerkiniAllowed = $rm->id_terapis == $userTerapis->id_terapis ? 1 : 0;
        }

        return view('pages.rekam-terapi.histori-rekam-terapi', compact(
            'rmDetected',
            'isTerkiniAllowed',
            'isTerdahuluAllowed',
            'rm',
            'rm_terdahulu',
            'pasien',
            'umur'
        ));
    }

    public function detail(Pasien $pasien, SubRekamMedis $subRM)
    {
        $sub = $subRM;
        $rm = $subRM->rekamMedis;
        $rekam_terapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;

        return view('pages.rekam-terapi.rekam-terapi', compact(
            'rekam_terapi',
            'sub',
            'rm',
            'pasien',
            'umur'
        ));
    }

    public function delete(Pasien $pasien, SubRekamMedis $subRM)
    {
        $penyakitWithoutSpaces = str_replace(', ', ',', $subRM->rekamMedis->penyakit);        
        $penyakitArray = explode(",", $penyakitWithoutSpaces);
        $resultArray = array_diff($penyakitArray, [$subRM->penyakit]);

        $dataRM['penyakit'] = implode(",", $resultArray);

        Terapis::whereIn('id_terapis', $subRM->rekamTerapi->pluck('id_terapis'))
            ->decrement('total_terapi', 1);
        
        SubRekamMedis::destroy($subRM->id_sub);
        RekamMedis::where('id_rekam_medis', $subRM->rekamMedis->id_rekam_medis)->update($dataRM);        

        return redirect(route('sub.histori', [$pasien->slug, $subRM->id_sub]))
                            ->with('success', 'Rekam Terapi berhasil dihapus.')
                            ->with('delete', true);
    }

    public function tagPenyakit(Request $request) 
    {
        $search = $request->input('search');
        $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

        $sub_penyakit = SubRekamMedis::filter($search, $sortBy)->paginate(12);

        return view('pages.rekam-terapi.tagging-penyakit', compact('sub_penyakit'));
    }

    public function printRekam(Pasien $pasien, SubRekamMedis $subRM)
    {
        $list_terapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $sub = $subRM;
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;

        return view('pages.unduh.unduh-rekam-terapi', compact(
            'sub', 'pasien', 'list_terapi', 'umur'
        ));
    }
    public function printHarian(Pasien $pasien, SubRekamMedis $subRM)
    {
        $list_terapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $sub = $subRM;

        foreach ($list_terapi as $terapi) {
            $terapi->tanggal = Carbon::createFromFormat('Y-m-d', $terapi->tanggal)->formatLocalized('%d %B %Y');
        }
        
        return view('pages.unduh.unduh-terapi-loop', compact(
            'sub', 'pasien', 'list_terapi' 
        ));
    }
}
