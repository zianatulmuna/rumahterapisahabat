<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Services\PasienService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PrapasienRequest;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    public function allPasien(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $sortBy = $request->urut === 'Terlama' ? 'ASC' : 'DESC';

        $query = Pasien::query();

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

    public function storePrapasien(PrapasienRequest $request, PasienService $pasienService)
    {
        $idPasien = $pasienService->createPasien($request);
        $pasienService->createRekamMedisPrapasien($request, $idPasien);

        return redirect()->back()->with('success', true);
    }

    public function detail(Pasien $pasien)
    {
        $rm = $pasien->rekamMedis()->where('status_pasien', 'Rawat Jalan')->first();
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;
        
        $userTerapis = Auth::guard('terapis')->user();
        $isAllowed = 1;

        if(($rm && $rm->is_private) && $userTerapis && !$userTerapis->is_kepala ) {
            $isAllowed = $rm->id_terapis == $userTerapis->id_terapis ? 1 : 0;
        }

        return view('pages.rekam-medis.rekam-medis', compact(
            'pasien',
            'rm',
            'umur',
            'isAllowed'
        ));
    }

    public function edit(Pasien $pasien)
    {
        $rm = RekamMedis::where('id_pasien', $pasien->id_pasien)->first();

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
