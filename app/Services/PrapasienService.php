<?php

namespace App\Services;
 
use App\Models\Pasien;
use App\Models\RekamMedis;
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

        $idPasien = IdGenerator::generate(['table' => 'pasien', 'field' => 'id_pasien', 'length' => 10, 'prefix' => 'PRA'.date('ym'), 'reset_on_prefix_change' => true]);
        
        $slug = SlugService::createSlug(Pasien::class, 'slug', $request->nama);

        if ($request->file('foto')) {
            $ext = $request->file('foto')->getClientOriginalExtension();
            $dataDiri['foto'] = $request->file('foto')->storeAs('pasien', $slug . '.' . $ext);
        }
        
        $dataDiri['id_pasien'] = $idPasien;
        $dataDiri['status_pendaftaran'] = 'Prapasien';
        $dataDiri['slug'] = $slug;
        $dataDiri['tanggal_pendaftaran'] = date('Y-m-d');

        Pasien::create($dataDiri);
 
        return $idPasien;
    }

    public function createRekamMedisPrapasien(Request $request, $idPasien)
    {
        $idRM = IdGenerator::generate([
            'table' => 'rekam_medis', 
            'field' => 'id_rekam_medis', 
            'length' => 12, 
            'prefix' => 'RMPRA', 
            'reset_on_prefix_change' => true
        ]);

        $dataRM = [
            'id_rekam_medis' => $idRM,
            'id_pasien' => $idPasien,
            'penanggungjawab' => $request->penanggungjawab,
            'tipe_pembayaran' => $request->tipe_pembayaran,
            'keluhan' => nl2br($request->keluhan),
            'tanggal_registrasi' => date('Y-m-d')
        ];
        
        RekamMedis::create($dataRM);
    }
}