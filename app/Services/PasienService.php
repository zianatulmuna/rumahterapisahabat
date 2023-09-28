<?php

namespace App\Services;
 
use Carbon\Carbon;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Cviebrock\EloquentSluggable\Services\SlugService;
 
class PasienService
{
    public function createPasien(Request $request)
    {
        $dataDiri = [            
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan
        ];

        $idPasien = IdGenerator::generate(['table' => 'pasien', 'field' => 'id_pasien', 'length' => 8, 'prefix' => 'P'.date('ym'), 'reset_on_prefix_change' => true]);
        
        $slug = SlugService::createSlug(Pasien::class, 'slug', $request->nama);

        if ($request->file('foto')) {
            $ext = $request->file('foto')->getClientOriginalExtension();
            $dataDiri['foto'] = $request->file('foto')->storeAs('pasien', $slug . '.' . $ext);
        }
        
        $dataDiri['id_pasien'] = $idPasien;
        $dataDiri['status_pendaftaran'] = 'Prapasien';
        $dataDiri['slug'] = $slug;
        $dataDiri['tanggal_pendaftaran'] = Carbon::now()->format('Y-m-d H:i:s');

        Pasien::create($dataDiri);
 
        return $idPasien;
    }
}