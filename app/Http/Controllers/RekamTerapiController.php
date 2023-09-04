<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Terapis;
use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Illuminate\Validation\Rule;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RekamTerapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pasien $pasien, SubRekamMedis $subRM)
    {
        // $terapis = $subRM->terapis;
        // $rekamTerapi = $subRM->rekamTerapi;

        // $combined = $rekamTerapi->zip($terapis);
        $rekam = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();

        return view('rekam-terapi.rekam-terapi', [
            'rekam_terapi' => $rekam,
            'sub' => $subRM,
            'rmDetected' => 1,
            'rm' => $subRM->rekamMedis,
            // 'rekam_terapi' => $subRM->rekamTerapi,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    public function histori(Pasien $pasien) 
    {
        $rmTerkini = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();
        $rmTerdahulu = $pasien->rekamMedis()->where('status_pasien', '!=', 'Rawat Jalan')->get();

        if(count($rmTerkini) > 0 || count($rmTerdahulu) > 0) {
            $rmDetected = 1;
        } else {
            $rmDetected = 0;
        }

        // dd($rmTerdahulu);

        return view('rekam-terapi.histori', [
            'rmDetected' => $rmDetected,
            'rm' => $rmTerkini->first(),
            'rm_terkini' => $rmTerkini,
            'rm_terdahulu' => $rmTerdahulu,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    public function create(Pasien $pasien, SubRekamMedis $subRM)
    {
        $jadwal = '';
        $id_sub = $subRM->id_sub;
        $aksiDari = 'pasien';
        return view('rekam-terapi.tambah', compact('pasien', 'id_sub', 'jadwal', 'aksiDari'));
    }

    public function show(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi) 
    {
        $rekamTerapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $index = $rekamTerapi->search($terapi) + 1;
        // dd($index);
        return view('rekam-terapi.harian', [
            'rmDetected' => 1,
            'terapi' => $terapi,
            'index' => $index,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);

    }

    public function edit(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        return view('rekam-terapi.edit', [
            'terapi' => $terapi,
            'pasien' => $pasien,
        ]);
    }

    public function destroy(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        RekamTerapi::destroy($terapi->id_terapi);

        $totalTerapiSub = RekamTerapi::totalTerapiSub($subRM->id_sub);
        SubRekamMedis::where('id_sub', $subRM->id_sub)->update(['total_terapi' => $totalTerapiSub]);

        return redirect(route('terapi.rekam', [$pasien->slug, $subRM->id_sub, $terapi->id_terapi]))
                            ->with('success', 'Terapi Harian berhasil dihapus.')
                            ->with('delete', true);
    }

    public function deleteSub(Pasien $pasien, SubRekamMedis $subRM)
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
                                ->paginate(16);

        return view('rekam-terapi.tagging', compact('sub_penyakit'));
    }
}
