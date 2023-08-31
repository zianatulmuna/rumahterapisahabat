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

        return view('admin.rekam-terapi.rekam-terapi', [
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

        return view('admin.rekam-terapi.histori', [
            'rmDetected' => $rmDetected,
            'rm' => $rmTerkini->first(),
            'rm_terkini' => $rmTerkini,
            'rm_terdahulu' => $rmTerdahulu,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pasien $pasien, SubRekamMedis $subRM)
    {
        return view('admin.rekam-terapi.tambah', [
            'pasien' => $pasien,
            // 'terapis' => Terapis::orderBy('nama', 'ASC')->get(),
            'id_sub' => $subRM->id_sub
        ]);
    }

    public function show(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi) 
    {
        $rekamTerapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $index = $rekamTerapi->search($terapi) + 1;
        // dd($index);
        return view('admin.rekam-terapi.harian', [
            'rmDetected' => 1,
            'terapi' => $terapi,
            'index' => $index,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);

    }

    public function edit(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        return view('admin.rekam-terapi.edit', [
            'terapi' => $terapi,
            'pasien' => $pasien,
            'terapis' => Terapis::orderBy('nama', 'ASC')->get(),
            'sub' => $subRM
        ]);
    }
    public function update(Request $request, $pasien, $subRM, RekamTerapi $terapi)
    {
        $tanggalTerapi = $terapi->tanggal;
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal sudah ada'
        ];

        $dataTerapi = $request->validate([
            'id_terapis' => 'required',
            'keluhan' => 'required|max:100',
            'deteksi' => 'required|max:100',
            'tindakan' => 'required|max:100',
            'saran' => 'max:100',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('rekam_terapi', 'tanggal')->where(function ($query) use ($subRM, $tanggalTerapi) {
                    return $query->where('id_sub', $subRM)->where('tanggal', '!=', $tanggalTerapi);
                }),
            ]
        ], $message);

        RekamTerapi::where('tanggal', $tanggalTerapi)->update($dataTerapi);

        // if($terapi->id_terapis !== $request->id_terapis) {
        //     $totalTerapiTerapisBaru = RekamTerapi::totalTerapi($request->id_terapis);
        //     $totalTerapiTerapisLama = RekamTerapi::totalTerapi($terapi->id_terapis);

        //     Terapis::where('id_terapis', $request->id_terapis)
        //             ->update(['total_terapi' => $totalTerapiTerapisBaru]);
        //     Terapis::where('id_terapis', $terapi->id_terapis)
        //             ->update(['total_terapi' => $totalTerapiTerapisLama]);
        // }

        return redirect(route('terapi.rekam', [$pasien, $subRM]))
                            ->with('success', 'Terapi Harian berhasil diupdate.')
                            ->with('update', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekamTerapi  $rekam_terapi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        RekamTerapi::destroy($terapi->id_terapi);

        // $totalTerapiTerapis = RekamTerapi::totalTerapi($terapi->id_terapis);
        // Terapis::where('id_terapis', $terapi->id_terapis)->update(['total_terapi' => $totalTerapiTerapis]);

        return redirect(route('terapi.rekam', [$pasien->slug, $subRM->id_sub, $terapi->tanggal]))
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
}
