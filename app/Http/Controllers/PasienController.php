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
    public function allPasien(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $sortBy = request('urut') === 'Terlama' ? 'ASC' : 'DESC';

        $pasien_lama = Pasien::filter($search, $sortBy, $status)
                                ->where('status_pendaftaran', 'Pasien')
                                ->paginate(12);

        return view('pages.pasien.pasien-lama', compact('pasien_lama'));
    }

    public function allPrapasien(Request $request)
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

        return view('pages.pasien.pasien-baru', compact('pasien_baru'));
    }

    public function addPrapasien()
    {
        $jenisKelamin = ['Perempuan','Laki-Laki'];

        return view('pages.landing-page.form-pendaftaran', compact('jenisKelamin'));
    }

    public function addPasien()
    {
        $pasien = '';

        return view('pasien.tambah', compact('pasien'));
    }

    public function store(Request $request)
    {
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digits angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.'
        ];

        $dataDiri = $request->validate([            
            'nama' => 'required|max:50',
            'email' => 'nullable|max:35',
            'alamat' => 'max:100',
            'no_telp' => 'required|min_digits:10',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required',
            'agama' => 'max:20',
            'pekerjaan' => 'max:30',
            'foto' => 'nullable|file|image|max:1024',
        ], $message);

        $dataRM = $request->validate([
            'penanggungjawab' => 'max:50',
            'keluhan' => 'required|max:100'
        ], $message);

        // dd($dataRM);

        $dateY = substr(Carbon::parse($request->date)->format('Y'), 2);
        $idPasien = IdGenerator::generate(['table' => 'pasien', 'field' => 'id_pasien', 'length' => 8, 'prefix' => 'P'.$dateY, 'reset_on_prefix_change' => true]);
        $slug = SlugService::createSlug(Pasien::class, 'slug', $request->nama);

        if ($request->file('foto')) {
            $ext = $request->file('foto')->getClientOriginalExtension();
            $dataDiri['foto'] = $request->file('foto')->storeAs('pasien', $slug . '.' . $ext);
        }
        
        $dataDiri['id_pasien'] = $idPasien;
        $dataDiri['status_pendaftaran'] = 'Prapasien';
        $dataDiri['slug'] = $slug;
        $dataDiri['tanggal_pendaftaran'] = Carbon::now()->format('Y-m-d H:i:s');

        $pasien = Pasien::create($dataDiri);

        if($pasien) {
            $idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 10, 'prefix' => 'PRA', 'reset_on_prefix_change' => true]);
            $dataRM['id_rekam_medis'] = $idRM;
            $dataRM['id_pasien'] = $idPasien;
            
            RekamMedis::create($dataRM);
        }

        return redirect()->back()->with('success', $idPasien);        
    }

    public function detail(Pasien $pasien)
    {
        $rekamMedis = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();
        $rm = $rekamMedis->first();
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;

        if($rekamMedis->count() < 1) {
            $rmDetected = 0;
        } elseif ($rekamMedis->count() == 1) {
            $rmDetected = 1;
        } else {
            $rmDetected = 2;
        }
        
        return view('pages.rekam-medis.detail', compact(
            'pasien',
            'rmDetected',
            'rm',
            'umur'
        ));
    }

    public function edit(Pasien $pasien)
    {
        $rm = RekamMedis::where('id_pasien', $pasien->id_pasien)->where('tanggal_ditambahkan', null)->first();
        
        return view('pages.pasien.edit', compact('pasien', 'rm'));
    }

    public function delete(Pasien $pasien)
    {
        if ($pasien->foto) {
            Storage::delete($pasien->foto);
        }
        
        Pasien::destroy($pasien->id_pasien);

        $route = $pasien->status_pendaftaran == "Prapasien" ? 'pasien.baru' : 'pasien.lama';

        return redirect()->route($route)
                            ->with('success', 'Pasien berhasil dihapus.')
                            ->with('delete', true);
    }
}
