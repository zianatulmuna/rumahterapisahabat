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

        return view('admin.rekam-terapi.rekam', [
            'rekam_terapi' => $rekam,
            'sub' => $subRM,
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
            'terapis' => Terapis::orderBy('nama', 'ASC')->get(),
            'sub' => $subRM
        ]);
    }
    
    public function store(Request $request, $pasien, $subRM)
    {       

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
                Rule::unique('rekam_terapi', 'tanggal')->where(function ($query) use ($subRM) {
                    return $query->where('id_sub', $subRM);
                }),
            ]
        ], $message);

        // dd($dataTerapi);

        $dateY = substr(Carbon::parse($request->tanggal)->format('Y'), 2);
        $dateM = Carbon::parse($request->tanggal)->format('m');

        $id = IdGenerator::generate([
            'table' => 'rekam_terapi', 
            'field' => 'id_terapi', 
            'length' => 8, 
            'prefix' => 'T'.$dateY.$dateM,
            'reset_on_prefix_change' => true
        ]);
        

        $dataTerapi['id_terapi'] = $id;
        $dataTerapi['id_sub'] = $subRM;
        
        

        RekamTerapi::create($dataTerapi);

        return redirect(route('terapi.rekam', [$pasien, $subRM]))
                            ->with('success', 'Terapi Harian berhasil ditambahkan.')
                            ->with('create', true);
    }

    public function show(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi) 
    {
        $rekamTerapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $index = $rekamTerapi->search($terapi) + 1;
        // dd($index);
        return view('admin.rekam-terapi.harian', [
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
    public function update(Request $request, $pasien, $subRM, $terapi)
    {
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
                Rule::unique('rekam_terapi', 'tanggal')->where(function ($query) use ($subRM, $terapi) {
                    return $query->where('id_sub', $subRM)->where('tanggal', '!=', $terapi);
                }),
            ]
        ], $message);

        RekamTerapi::where('tanggal', $terapi)->update($dataTerapi);

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

        return redirect(route('terapi.rekam', [$pasien->slug, $subRM->id_sub, $terapi->tanggal]))
                            ->with('success', 'Terapi Harian berhasil dihapus.')
                            ->with('delete', true);
    }

    public function deleteSub(Pasien $pasien, SubRekamMedis $subRM)
    {
        SubRekamMedis::destroy($subRM->id_sub);

        return redirect(route('sub.histori', [$pasien->slug, $subRM->id_sub]))
                            ->with('success', 'Terapi Harian berhasil dihapus.')
                            ->with('delete', true);
    }
}
