<?php

namespace App\Services;
 
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
 
class JadwalService
{
    public function storeJadwal(Request $request)
    {
        $dataJadwal = $request->validated();

        $id = IdGenerator::generate([
            'table' => 'jadwal', 
            'field' => 'id_jadwal', 
            'length' => 10, 
            'prefix' => 'JDW'. date('ym'),
            'reset_on_prefix_change' => true
        ]);

        $dataJadwal['id_jadwal'] = $id;

        Jadwal::create($dataJadwal);
        
    }

    public function updateJadwal(Request $request, $idJadwal)
    {
        $dataJadwal = $request->validated();

        Jadwal::where('id_jadwal', $idJadwal)->update($dataJadwal);
    }
}