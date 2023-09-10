<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('pasien.pasien-lama', compact('pasien_lama'));
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

        return view('pasien.pasien-baru', compact('pasien_baru'));
    }

    public function add()
    {
        $pasien = '';

        return view('pasien.tambah', compact('pasien'));
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
        
        return view('rekam-medis.detail', compact(
            'pasien',
            'rmDetected',
            'rm',
            'umur'
        ));
    }

    public function edit(Pasien $pasien)
    {
        $rm = '';
        return view('pasien.edit', compact('pasien', 'rm'));
    }

    public function delete(Pasien $pasien)
    {
        if ($pasien->foto) {
            Storage::delete($pasien->foto);
        }
        
        Pasien::destroy($pasien->id_pasien);

        return redirect()->route('pasien.lama')
                            ->with('success', 'Pasien berhasil dihapus.')
                            ->with('delete', true);
    }
}
