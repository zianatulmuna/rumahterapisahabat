<?php

namespace App\Http\Controllers;

use App\Models\SubRekamMedis;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Terapis;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class JadwalController extends Controller
{
    public function index(Request $request)
    {    
        $query = Jadwal::query();

        if(Auth::guard('terapis')->user()) {
            $idTerapis = Auth::guard('terapis')->user()->id_terapis;
            $query->where('id_terapis', $idTerapis);
            $view = 'pages.terapis.jadwal-terapi';
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
            $query->where('tanggal', $tanggal)->paginate(10);
        } elseif ($request['awal']) {
            $awal = Carbon::createFromFormat('Y-m-d', $request['awal'])->formatLocalized('%d %B %Y');
            $akhir = Carbon::createFromFormat('Y-m-d', request('akhir'))->formatLocalized('%d %B %Y');

            $caption = $awal . ' - ' . $akhir;
            $query->whereBetween('tanggal', [$request['awal'], request('akhir')])->paginate(10);
        } else {
            $caption = Carbon::today()->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', Carbon::today()->format('Y-m-d'))->paginate(10);
        }

        $jadwal_terapi = $query->paginate(10);  

        return view($view, compact('jadwal_terapi', 'caption'));
    }

    public function add()
    {
        // $this->jadwalDummy();
        $pasien = Pasien::whereHas('rekamMedis', function ($query) {
            $query->where('status_pasien', 'Rawat Jalan')
                  ->where('penyakit', '!=', '');
        })
        ->orderBy('nama', 'ASC')
        ->get();
        
        $terapis = Terapis::where('status', 'Aktif')->orderBy('nama', 'ASC')->get(['id_terapis', 'nama', 'tingkatan']);

        return view('pages.jadwal.tambah-jadwal', compact('pasien', 'terapis'));
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

        return view('pages.rekam-terapi.tambah-terapi', compact('pasien', 'id_sub', 'jadwal', 'aksiDari'));
    }

    public function store(Request $request)
    {
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Terapis harus diisi.',
            'id_pasien.required' => 'Pasien harus diisi.',
            'id_sub.required' => 'Penyakit harus dipilih.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal untuk pasien dan terapis ini sudah ada'
        ];

        $dataJadwal = $request->validate([
            'id_terapis' => 'nullable',
            'id_pasien' => 'required',
            'id_sub' => 'required',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('jadwal', 'tanggal')->where(function ($query) use ($request) {
                    return $query->where('id_pasien', $request->id_pasien)
                                 ->where('id_terapis', $request->id_terapis);
                }),
            ]
        ], $message);

        $dateY = substr(Carbon::parse($request->tanggal)->format('Y'), 2);
        $dateM = Carbon::parse($request->tanggal)->format('m');

        $id = IdGenerator::generate([
            'table' => 'jadwal', 
            'field' => 'id_jadwal', 
            'length' => 10, 
            'prefix' => 'JDW'.$dateY.$dateM,
            'reset_on_prefix_change' => true
        ]);

        $dataJadwal['id_jadwal'] = $id;

        Jadwal::create($dataJadwal);

        return redirect(route('jadwal'))
                            ->with('success', 'Jadwal Terapi berhasil ditambahkan')
                            ->with('create', true);
    }

    public function edit(Pasien $pasien, Jadwal $jadwal)
    {
        $list_pasien = Pasien::orderBy('nama', 'ASC')->get();
        $list_terapis = Terapis::orderBy('nama', 'ASC')->get();
        $id_terapis = $jadwal->id_terapis;
        
        return view('pages.jadwal.edit-jadwal', compact(
            'list_pasien', 'list_terapis', 'pasien', 'id_terapis', 'jadwal'
        ));
    }

    public function update(Request $request, Pasien $pasien, Terapis $terapis, Jadwal $jadwal)
    {
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Terapis harus diisi.',
            'id_pasien.required' => 'Pasien harus diisi.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal untuk pasien dan terapis ini sudah ada'
        ];

        $dataJadwal = $request->validate([
            'id_terapis' => 'required',
            'id_pasien' => 'required',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('jadwal', 'tanggal')->where(function ($query) use ($request) {
                    return $query->where('id_pasien', $request->id_pasien)
                                 ->where('id_terapis', $request->id_terapis);
                }),
            ]
        ], $message);

        Jadwal::where('id_jadwal', $jadwal->id_jadwal)
                ->update($dataJadwal);

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
        $rm = RekamMedis::where('id_pasien', $request->id)->where('status_pasien', 'Rawat Jalan')->get();

        $dataSub = [];

        foreach ($rm as $r) {
            foreach ($r->subRekamMedis as $sub) {
                $dataSub[] = ['id_rm' => $r->id_rekam_medis,'id_sub' => $sub->id_sub, 'penyakit' => $sub->penyakit];
            }
        }

        return response()->json($dataSub);
    }

    public function cancelJadwal(Pasien $pasien, Jadwal $jadwal)
    {        
        Jadwal::where('id_jadwal', $jadwal->id_jadwal)->update(['id_terapis' => null]);

        return redirect()->back();
    }

    public function print(Request $request)
    {
        if($request['filter']) {
            $m = $request['filter'] == "tahun-ini" ? date('Y') : date('Y-m');
            $list_jadwal = Jadwal::where('tanggal', 'like', $m . '%')->get();
            $caption = $request['filter'] == "tahun-ini" ? date('Y') : Carbon::today()->formatLocalized('%B %Y');
        } elseif($request['awal'] == 'null') {
            $today = Carbon::today();
            $list_jadwal = Jadwal::where('tanggal', $today->format('Y-m-d'))->get();
            $caption = $today->format('d-m-Y');
        } elseif (request('akhir') == 'null') {
            $list_jadwal = Jadwal::where('tanggal', $request['awal'])->get();   
            $caption = Carbon::parse($request['awal'])->format('d-m-Y');         
        } else {
            $list_jadwal = Jadwal::whereBetween('tanggal', [$request['awal'], request('akhir')])->orderBy('tanggal', 'ASC')->get();  
            $caption = Carbon::parse($request['awal'])->format('d-m-Y') . ' sd ' . Carbon::parse(request('akhir'))->format('d-m-Y');          
        }
        
        return view('pages.unduh.unduh-jadwal', compact(
            'list_jadwal', 'caption'
        ));
    }
}
