<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalRequest;
use App\Models\SubRekamMedis;
use App\Services\JadwalService;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Terapis;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class JadwalController extends Controller
{
    public function index(Request $request)
    {    
        $query = Jadwal::query();

        if(Auth::guard('terapis')->check()) {
            $query->where('id_terapis', Auth::guard('terapis')->user()->id_terapis);
            $view = 'pages.terapis.jadwal-terapis';
        } else {
            $view = 'pages.jadwal.jadwal';
        }

        if($request['filter']) {
            $m = $request['filter'] == "tahun-ini" ? date('Y') : date('Y-m');
            $query->where('tanggal', 'like', $m . '%');
            $caption = $request['filter'] == "tahun-ini" ? date('Y') : Carbon::today()->formatLocalized('%B %Y');
            $request = true;
        } elseif($request['tanggal']) {
            $tanggal = $request['tanggal'];
            $caption = Carbon::createFromFormat('Y-m-d', $tanggal)->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', $tanggal);
        } elseif ($request['awal']) {
            $awal = Carbon::createFromFormat('Y-m-d', $request['awal'])->formatLocalized('%d %B %Y');
            $akhir = Carbon::createFromFormat('Y-m-d', request('akhir'))->formatLocalized('%d %B %Y');

            $caption = $awal . ' - ' . $akhir;
            $query->whereBetween('tanggal', [$request['awal'], request('akhir')]);
        } else {
            $caption = Carbon::today()->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', Carbon::today()->format('Y-m-d'));
        }

        $jadwal_terapi = $query->paginate(10);  

        return view($view, compact('jadwal_terapi', 'caption'));
    }

    public function add()
    {
        $pasien = Pasien::whereHas('rekamMedis', function ($query) {
            $query->where('status_pasien', 'Rawat Jalan')
                  ->where('penyakit', '!=', '');
        })
        ->orderBy('nama', 'ASC')
        ->get();
        
        $listTerapis = Terapis::where('status', 'Aktif')->orderBy('nama', 'ASC')->get(['id_terapis', 'nama', 'tingkatan']);

        return view('pages.jadwal.tambah-jadwal', compact('pasien', 'listTerapis',));
    }

    public function jadwalDummy() {
        $t = 19;

        for ($i = 0; $i < 5; $i++) {
            $id = IdGenerator::generate([
                'table' => 'jadwal', 
                'field' => 'id_jadwal', 
                'length' => 10, 
                'prefix' => 'JDW2309',
                'reset_on_prefix_change' => true
            ]);
            
            $jam_acak = rand(9, 22);        // Nilai acak untuk jam (0-23)
            $menit_acak = rand(0, 59);      // Nilai acak untuk menit (0-59)
            $detik_acak = rand(0, 59);      // Nilai acak untuk detik (0-59)

            // Membuat waktu acak
            $waktu_acak = sprintf("%02d:%02d:%02d", $jam_acak, $menit_acak, $detik_acak);

            $sub = SubRekamMedis::all()->random();

            $dataTerapi = array(
                'id_jadwal' => $id,
                'id_pasien' => $sub->rekamMedis->id_pasien,
                'id_terapis' => Terapis::all()->random()->id_terapis,
                'id_sub' => $sub->id_sub,
                'tanggal' => '2023-09-' . $t,
                'waktu' => $waktu_acak,
            ); 
            Jadwal::create($dataTerapi);
        }
        return redirect()->back();
    }

    public function addTerapiFromJadwal(Pasien $pasien, Jadwal $jadwal)
    {  
        $id_sub = $jadwal->id_sub;
        $aksiDari = "jadwal";

        return view('pages.rekam-terapi.tambah-terapi', compact(
            'pasien', 'id_sub', 'jadwal', 'aksiDari'
        ));
    }

    public function store(JadwalRequest $request, JadwalService $jadwalService)
    {
        $jadwalService->storeJadwal($request);

        return redirect(route('jadwal'))
                            ->with('success', 'Jadwal Terapi berhasil ditambahkan')
                            ->with('create', true);
    }

    public function edit(Pasien $pasien, Jadwal $jadwal)
    {
        $list_pasien = Pasien::orderBy('nama', 'ASC')->get();
        $list_terapis = Terapis::orderBy('nama', 'ASC')->get();
        
        return view('pages.jadwal.edit-jadwal', compact(
            'list_pasien', 'list_terapis', 'pasien', 'jadwal'
        ));
    }

    public function update(JadwalRequest $request, JadwalService $jadwalService, Jadwal $jadwal)
    {        
        $jadwalService->updateJadwal($request, $jadwal->id_jadwal);

        return redirect(route('jadwal'))
                            ->with('success', 'Jadwal Terapi berhasil diedit.')
                            ->with('update', true);
    }

    public function delete($jadwal)
    {
        Jadwal::where('id_jadwal', $jadwal)->delete();

        return redirect(route('jadwal'))
                ->with('success', 'Jadwal Terapi berhasil dihapus.')
                ->with('delete', true);
    }

    public function getSubRekamMedis(Request $request) {
        $rm = RekamMedis::where('id_pasien', $request->id)->where('status_pasien', 'Rawat Jalan')->first();

        $dataSub = [];
        
        foreach ($rm->subRekamMedis as $sub) {
            $dataSub[] = ['id_rm' => $rm->id_rekam_medis,'id_sub' => $sub->id_sub, 'penyakit' => $sub->penyakit];
        }

        return response()->json($dataSub);
    }

    public function terapisDefaultCheck(Request $request) {
        $rm = RekamMedis::where('id_pasien', $request->id)->where('status_pasien', 'Rawat Jalan')->first();

        $dataTerapisDefault = [];

        if($rm->is_private) {
            $dataTerapisDefault[] = ['id_terapis' => $rm->terapis->id_terapis,'nama' => $rm->terapis->nama, 'tingkatan' => $rm->terapis->tingkatan];
        }

        return response()->json($dataTerapisDefault);
    }

    public function cancelJadwal(Pasien $pasien, Jadwal $jadwal)
    {        
        Jadwal::where('id_jadwal', $jadwal->id_jadwal)->update(['id_terapis' => null]);

        return redirect()->back();
    }

    public function print(Request $request)
    {
        $query = Jadwal::query();

        if($request['filter']) {
            $m = $request['filter'] == "tahun-ini" ? date('Y') : date('Y-m');
            $query->where('tanggal', 'like', $m . '%');
            $caption = $request['filter'] == "tahun-ini" ? date('Y') : Carbon::today()->formatLocalized('%B %Y');
        } elseif($request['awal'] == 'null') {
            $today = Carbon::today();
            $query->where('tanggal', $today->format('Y-m-d'));
            $caption = $today->format('d-m-Y');
        } elseif (request('akhir') == 'null') {
            $query->where('tanggal', $request['awal']);   
            $caption = Carbon::parse($request['awal'])->format('d-m-Y');         
        } else {
            $query->whereBetween('tanggal', [$request['awal'], request('akhir')])->orderBy('tanggal', 'ASC');  
            $caption = Carbon::parse($request['awal'])->format('d-m-Y') . ' sd ' . Carbon::parse(request('akhir'))->format('d-m-Y');          
        }

        if(Auth::guard('terapis')->check()) {
            $query->where('id_terapis', Auth::guard('terapis')->user()->id_terapis);
        }

        $list_jadwal = $query->get();
        
        return view('pages.unduh.unduh-jadwal', compact(
            'list_jadwal', 'caption'
        ));
    }
}
