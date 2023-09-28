<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasienCreateRequest;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Services\PasienService;
use App\Services\RekamMedisService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    public function allPasien(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

        $query = Pasien::query();

        if ($status == 'Selesai') {
            $query->whereDoesntHave('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Rawat Jalan');
            });
        } elseif ($status == 'Jeda') {
            $query->whereHas('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Jeda');
            });
        } else {
            $query->whereHas('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Rawat Jalan');
            });
        }

        $pasien_lama = $query->where('status_pendaftaran', 'Pasien')
            ->where('nama', 'like', '%' . $search . '%')
            ->orWhere('id_pasien', 'like', '%' . $search . '%')
            ->orWhereHas('rekamMedis', function ($query) use ($search) {
                $query->where('penyakit', 'like', '%' . $search . '%')
                    ->orWhere('id_rekam_medis', 'like', '%' . $search . '%');
            })
            ->orderBy('tanggal_pendaftaran', $sortBy)
            ->paginate(12);

        return view('pages.pasien.pasien-lama', compact('pasien_lama'));
    }
    // public function allPasien(Request $request)
    // {
    //     $search = $request->input('search');
    //     $status = $request->input('status');

    //     $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

    //     $pasien_lama = Pasien::filter($search, $sortBy, $status)
    //                             ->where('status_pendaftaran', 'Pasien')
    //                             ->paginate(12);

    //     return view('pages.pasien.pasien-lama', compact('pasien_lama'));
    // }

    public function allPrapasien(Request $request)
    {
        $search = $request->input('search');
        $status = '';

        if (request('urut') === 'Terlama') {
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

    public function store(PasienCreateRequest $request)
    {
        $pasienService = new PasienService;
        $rmService = new RekamMedisService;

        $idPasien = $pasienService->createPasien($request);

        $rmService->createRekamMedisPrapasien($request, $idPasien);

        return redirect()->back()->with('success', $idPasien);
    }

    public function detail(Pasien $pasien)
    {
        $rekamMedis = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->get();
        $rm = $rekamMedis->first();
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
        $rm = RekamMedis::where('id_pasien', $pasien->id_pasien)->where('tanggal_ditambahkan', null)->first();

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
