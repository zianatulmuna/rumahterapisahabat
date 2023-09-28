<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Terapis;;
use App\Models\RekamTerapi;
use App\Models\SubRekamMedis;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RekamTerapiController extends Controller
{  

    public function terapiDummy($id_sub) {
        $json_file = 'database/terapi-stroke.json';
        $json_data = file_get_contents($json_file);
        $data = json_decode($json_data, true);

        $t = 4;

        for ($i = 0; $i < 4; $i++) {
            $id = IdGenerator::generate([
                'table' => 'rekam_terapi', 
                'field' => 'id_terapi', 
                'length' => 8, 
                'prefix' => 'T2306',
                'reset_on_prefix_change' => true
            ]);
            
            $jam_acak = rand(0, 22);
            $menit_acak = rand(0, 59);
            $detik_acak = rand(0, 59);

            $waktu_acak = sprintf("%02d:%02d:%02d", $jam_acak, $menit_acak, $detik_acak);
            
            $item = $data[$i];
            $dataTerapi = array(
                'id_terapi' => $id,
                'id_terapis' => Terapis::all()->random()->id_terapis,
                'id_sub' => $id_sub,
                'tanggal' => '2023-06-' . $t,
                'waktu' => $waktu_acak,
                'keluhan' => $item['keluhan'],
                'deteksi' => $item['deteksi'],
                'tindakan' => $item['tindakan_terapi'],
                'saran' => $item['saran'],
                'pra_terapi' => $item['kondisi_sebelum_terapi'],
                'post_terapi' => $item['kondisi_setelah_terapi']
            ); 
            $t = $t+7;
            RekamTerapi::create($dataTerapi);
        }
        return redirect()->back();
    }

    public function add(Pasien $pasien, SubRekamMedis $subRM)
    {        
        // $this->terapiDummy($subRM->id_sub);

        $jadwal = '';
        $id_sub = $subRM->id_sub;
        $aksiDari = 'pasien';
        return view('pages.rekam-terapi.tambah-terapi', compact('pasien', 'id_sub', 'jadwal', 'aksiDari'));
    }

    public function detail(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi) 
    {
        $rekamTerapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $index = $rekamTerapi->search($terapi) + 1;
     
        return view('pages.rekam-terapi.detail-terapi', [
            'rmDetected' => 1,
            'terapi' => $terapi,
            'index' => $index,
            'pasien' => $pasien,
            'umur' => Carbon::parse($pasien->tanggal_lahir)->age
        ]);

    }

    public function edit(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        return view('pages.rekam-terapi.edit-terapi', [
            'terapi' => $terapi,
            'pasien' => $pasien,
        ]);
    }

    public function delete(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        RekamTerapi::destroy($terapi->id_terapi);

        $totalTerapiSub = RekamTerapi::totalTerapiSub($subRM->id_sub);
        SubRekamMedis::where('id_sub', $subRM->id_sub)->update(['total_terapi' => $totalTerapiSub]);

        return redirect(route('terapi.rekam', [$pasien->slug, $subRM->id_sub, $terapi->id_terapi]))
                            ->with('success', 'Terapi Harian berhasil dihapus.')
                            ->with('delete', true);
    }

    public function print(Pasien $pasien, SubRekamMedis $subRM, RekamTerapi $terapi)
    {
        $rekamTerapi = $subRM->rekamTerapi()->orderBy('tanggal', 'ASC')->get();
        $index = $rekamTerapi->search($terapi) + 1;
        $tanggal = Carbon::createFromFormat('Y-m-d', $terapi->tanggal)->formatLocalized('%d %B %Y');
        $sub = $subRM;
        
        return view('pages.unduh.unduh-terapi-harian', compact(
            'sub', 'pasien', 'terapi', 'tanggal', 'index' 
        ));
    }
    
}
