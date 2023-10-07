<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Services\PasienService;
use App\Services\RekamMedisService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PrapasienRequest;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    // public function allPasien(Request $request)
    // {
    //     $search = $request->input('search');
    //     $status = $request->input('status');

    //     $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

    //     $query = Pasien::query();

    //     if ($status == 'Selesai') {
    //         $query->whereDoesntHave('rekamMedis', function ($query) {
    //             $query->where('status_pasien', 'Rawat Jalan');
    //         });
    //     } elseif ($status == 'Jeda') {
    //         $query->whereHas('rekamMedis', function ($query) {
    //             $query->where('status_pasien', 'Jeda');
    //         });
    //     } else {
    //         $query->whereHas('rekamMedis', function ($query) {
    //             $query->where('status_pasien', 'Rawat Jalan');
    //         });
    //     }

    //     $pasien_lama = $query->where('status_pendaftaran', 'Pasien')
    //         ->where('nama', 'like', '%' . $search . '%')
    //         ->orWhere('id_pasien', 'like', '%' . $search . '%')
    //         ->orWhereHas('rekamMedis', function ($query) use ($search) {
    //             $query->where('penyakit', 'like', '%' . $search . '%')
    //                 ->orWhere('id_rekam_medis', 'like', '%' . $search . '%');
    //         })
    //         ->orderBy('tanggal_pendaftaran', $sortBy)
    //         ->paginate(12);

    //     return view('pages.pasien.pasien-lama', compact('pasien_lama'));
    // }
    public function allPasien(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

        $query = Pasien::query();

        // if (Auth::guard('terapis')->check() && Auth::guard('terapis')->user()->id_terapis != 'KTR001') {
        //     $idTerapis = Auth::guard('terapis')->user()->id_terapis;
        // } else {
        //     $idTerapis = null;
        // }

        $pasien_lama = $query->filter($search, $sortBy, $status)
            ->where('status_pendaftaran', 'Pasien')
            ->paginate(12);

        return view('pages.pasien.pasien-lama', compact('pasien_lama'));
    }

    public function allPrapasien(Request $request)
    {
        $search = $request->input('search');
        $status = '';

        $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

        $query = Pasien::query();

        // if (Auth::guard('terapis')->check() && Auth::guard('terapis')->user()->id_terapis != 'KTR001') {
        //     $idTerapis = Auth::guard('terapis')->user()->id_terapis;
        // } else {
        //     $idTerapis = null;
        // }

        $pasien_baru = $query->filter($search, $sortBy, $status)
            ->where('status_pendaftaran', 'Prapasien')
            ->paginate(12);

        return view('pages.pasien.pasien-baru', compact('pasien_baru'));
    }

    public function addPrapasien()
    {
        $jenisKelamin = ['Perempuan', 'Laki-Laki'];
        $tipePembayaran = [
            ['value' => 'Profesional', 'id' => 'profesional'],
            ['value' => 'Kesepakatan', 'id' => 'kesepakatan'],
            ['value' => 'Kontrak', 'id' => 'kontrak'],
            ['value' => 'Tidak Mampu', 'id' => 'tidak_mampu'],
        ];

        return view('pages.landing-page.form-pendaftaran', compact('jenisKelamin', 'tipePembayaran'));
    }

    public function addPasien()
    {
        $pasien = '';

        return view('pages.pasien.tambah-pasien', compact('pasien'));
    }

public function storePrapasien(Request $request)
{
  $message = [
    'required' => 'Kolom :attribute harus diisi.',
    'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
    'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
    'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
    'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',
    'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
    'numeric' => 'Kolom :attribute harus diisi angka.',
    'file' => 'Kolom :attribute harus diisi file.',
    'image' => 'Kolom :attribute harus diisi file gambar.',
    'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.'
  ];

  $dataDiri = $request->validate([
    'nama' => 'required|max:50',
    'email' => 'nullable|max:50',
    'alamat' => 'max:150',
    'no_telp' => 'required|numeric|min_digits:8|max_digits:14',
    'tanggal_lahir' => 'nullable|date',
    'jenis_kelamin' => 'required',
    'agama' => 'max:20',
    'pekerjaan' => 'max:30',
    'foto' => 'nullable|file|image|max:1024',
  ], $message);

  $dataRM = $request->validate([
    'penanggungjawab' => 'max:50',
    'tipe_pembayaran' => 'nullable',
    'keluhan' => 'required|max:200'
    ], $message);

  $idPasien = IdGenerator::generate([
    'table' => 'pasien', 
    'field' => 'id_pasien', 
    'length' => 10, 
    'prefix' => 'PRA'.date('ym'), 
    'reset_on_prefix_change' => true
  ]);
  
  $slug = SlugService::createSlug(Pasien::class, 'slug', $request->nama);

  if ($request->file('foto')) {
    $ext = $request->file('foto')->getClientOriginalExtension();
    $dataDiri['foto'] = $request->file('foto')->storeAs('pasien', $slug.'.'.$ext);
  }

  $dataDiri['id_pasien'] = $idPasien;
  $dataDiri['status_pendaftaran'] = 'Prapasien';
  $dataDiri['slug'] = $slug;
  $dataDiri['tanggal_pendaftaran'] = Carbon::now()->format('Y-m-d H:i:s');

  $pasien = Pasien::create($dataDiri);

  if($pasien) {
    $idRM = IdGenerator::generate([
      'table' => 'rekam_medis', 
      'field' => 'id_rekam_medis', 
      'length' => 12, 'prefix' => 'RMPRA', 
      'reset_on_prefix_change' => true
    ]);
    $dataRM['id_rekam_medis'] = $idRM;
    $dataRM['id_pasien'] = $idPasien;
    $dataRM['keluhan'] = nl2br($request->keluhan);

    RekamMedis::create($dataRM);
  }

  return redirect()->back()->with('success', $idPasien);
}

    public function storePrapasien(PrapasienRequest $request)
    {
        $pasienService = new PasienService;
        $rmService = new RekamMedisService;

        $idPasien = $pasienService->createPasien($request);

        $rmService->createRekamMedisPrapasien($request, $idPasien);

        return redirect()->back()->with('success', $idPasien);
    }

    public function detail(Pasien $pasien)
    {
        $rekamMedis = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->first();
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;

        if ($rekamMedis->count() < 1) {
            $rmDetected = 0;
        } elseif ($rekamMedis->count() == 1) {
            $rmDetected = 1;
        } else {
            $rmDetected = 2;
        }

        return view('pages.rekam-medis.rekam-medis', compact(
            'pasien',
            'rmDetected',
            'rm',
            'umur'
        ));
    }

    public function edit(Pasien $pasien)
    {
        $rm = RekamMedis::where('id_pasien', $pasien->id_pasien)->where('tanggal_registrasi', null)->first();

        return view('pages.pasien.edit-pasien', compact('pasien', 'rm'));
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
