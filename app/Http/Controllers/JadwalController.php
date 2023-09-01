<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Terapis;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $today = Carbon::today()->formatLocalized('%A, %d %B %Y');
        $jadwal_terapi = Jadwal::where('tanggal', Carbon::today()->format('Y-m-d'))->paginate(10);

        if(request('tanggal')) {
            $tanggal = request('tanggal');
            $today = Carbon::createFromFormat('Y-m-d', $tanggal)->formatLocalized('%A, %d %B %Y');
            $jadwal_terapi = Jadwal::where('tanggal', $tanggal)->paginate(10);
        } elseif (request('mulai')) {
            $awal = Carbon::createFromFormat('Y-m-d', request('mulai'))->formatLocalized('%d %B %Y');
            $akhir = Carbon::createFromFormat('Y-m-d', request('akhir'))->formatLocalized('%d %B %Y');

            $today = $awal . ' - ' . $akhir;
            $jadwal_terapi = Jadwal::whereBetween('tanggal', [request('mulai'), request('akhir')])->paginate(10);
        }

        return view('jadwal.jadwal', compact('jadwal_terapi', 'today'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pasien = Pasien::orderBy('nama', 'ASC')->get();
        $terapis = Terapis::where('status', 'Aktif')->orderBy('nama', 'ASC')->get(['id_terapis', 'nama', 'tingkatan']);

        return view('jadwal.tambah', compact('pasien', 'terapis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        Jadwal::create($dataJadwal);

        return redirect(route('jadwal'))
                            ->with('success', 'Jadwal Terapi berhasil ditambahkan')
                            ->with('create', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasien $pasien, Terapis $terapis, Jadwal $tanggal)
    {
        return view('jadwal.edit', [
            'pasien' => Pasien::orderBy('nama', 'ASC')->get(),
            'terapis' => Terapis::orderBy('nama', 'ASC')->get(),
            'old_pasien' => $pasien,
            'old_terapis' => $terapis,
            'old_tanggal' => $tanggal,
        ]);
    }
    public function update(Request $request, Pasien $pasien, Terapis $terapis, Jadwal $tanggal)
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

        Jadwal::where('tanggal', $tanggal->tanggal)
                ->where('id_pasien', $pasien->id_pasien)
                ->where('id_terapis', $terapis->id_terapis)
                ->update($dataJadwal);

        return redirect(route('jadwal'))
                            ->with('success', 'Jadwal Terapi berhasil diedit.')
                            ->with('update', true);
    }
    public function destroy(Pasien $pasien, Terapis $terapis, Jadwal $tanggal)
    {
        Jadwal::where('tanggal', $tanggal->tanggal)
                ->where('id_pasien', $pasien->id_pasien)
                ->where('id_terapis', $terapis->id_terapis)
                ->delete();

        return redirect(route('jadwal'))
                ->with('success', 'Jadwal Terapi berhasil dihapus.')
                ->with('delete', true);
    }
}
