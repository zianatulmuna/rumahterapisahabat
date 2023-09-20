<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TerapiCreateForm extends Component
{
    public $pasien, $id_terapis, $nama_terapis, $keluhan, $deteksi, $tindakan, $saran, $pra_terapi, $post_terapi, $waktu, $tanggal;
    public $id_sub, $aksiDari;

    public $selectedTerapis, $id_jadwal;

    public $totalStep = 2, $currentStep = 1;

    protected $listeners = ['setTerapis'];

    public function mount($pasien, $id_sub, $jadwal, $aksiDari) {
        $this->id_sub = $id_sub;
        $this->pasien = $pasien;
        $this->aksiDari = $aksiDari;
        $this->currentStep;
        $this->nama_terapis;

        if(Auth::guard('terapis')->user()) {
            $this->id_terapis = Auth::guard('terapis')->user()->id_terapis;
        }

        if($this->aksiDari === 'jadwal') {            
            $this->id_jadwal = $jadwal->id_jadwal;
            $this->id_terapis = $jadwal->id_terapis;
            $this->tanggal = $jadwal->tanggal;
            $this->waktu = $jadwal->waktu;
        }
    }
    public function render()
    {
        if($this->aksiDari === 'pasien') {
            $list_terapis = Terapis::orderBy('nama', 'ASC')->get();
            return view('livewire.terapi-create-form', compact('list_terapis'));
        } elseif ($this->aksiDari === 'jadwal') {
            return view('livewire.terapi-fill-form');
        }
    }

    public function toNext() {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if($this->currentStep > $this->totalStep) {
            $this->currentStep = $this->totalStep;
        }
    }
    public function toPrev() {
        $this->resetErrorBag();
        $this->currentStep--;
        $this->emit('runScriptTerapis');
        if($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function setTerapis($terapis) {
        $this->id_terapis = $terapis['id'];
        $this->nama_terapis = $terapis['nama'];
    }

    public function validateData(){
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Kolom terapis harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal sudah ada.'
        ];

        if($this->currentStep == 1){
            $id_sub = $this->id_sub;
            $id_terapis = $this->id_terapis;
            $this->validate([
                'id_terapis' => [
                    Rule::requiredIf(empty($this->id_terapis)),
                ],
                'pra_terapi' => 'max:100',
                'post_terapi' => 'max:100',
                'tanggal' => [
                    'required',
                    'date',
                    Rule::unique('rekam_terapi', 'tanggal')->where(function ($query) use ($id_sub, $id_terapis) {
                        return $query->where('id_sub', $id_sub)->where('id_terapis', $id_terapis);
                    }),
                ]
            ], $message);
        } else {
            $this->validate([
                'keluhan' => 'required|max:100',
                'deteksi' => 'required|max:100',
                'tindakan' => 'required|max:100',
                'saran' => 'max:100',
            ], $message);
        }
    }

    public function create(Request $request) {
        $this->validateData();

        $dataTerapi = array(
            'id_terapis' => $this->id_terapis,
            'id_sub' => $this->id_sub,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'keluhan' => nl2br($this->keluhan),
            'deteksi' => nl2br($this->deteksi),
            'tindakan' => nl2br($this->tindakan),
            'saran' => nl2br($this->saran),
            'pra_terapi' => nl2br($this->pra_terapi),
            'post_terapi' => nl2br($this->post_terapi)
        ); 

        $dateY = substr(Carbon::parse($request->tanggal)->format('Y'), 2);
        $dateM = Carbon::parse($request->tanggal)->format('m');

        $id = IdGenerator::generate([
            'table' => 'rekam_terapi', 
            'field' => 'id_terapi', 
            'length' => 8, 
            'prefix' => 'T'.$dateY.$dateM,
            'reset_on_prefix_change' => true
        ]);

        $dataTerapi['id_terapi'] = $id;

        $isTerapiSuccess = RekamTerapi::create($dataTerapi);

        if($isTerapiSuccess) {
            $totalTerapiSub = RekamTerapi::totalTerapiSub($this->id_sub);
            SubRekamMedis::where('id_sub', $this->id_sub)->update(['total_terapi' => $totalTerapiSub]);
            Jadwal::where('id_sub', $this->id_sub)
                    ->where('id_terapis', $this->id_terapis)
                    ->update(['status' => 'Terlaksana']);
            if($this->aksiDari === 'pasien') {
                return redirect(route('terapi.rekam', [$this->pasien, $this->id_sub]))
                                ->with('success', 'Terapi Harian berhasil ditambahkan.')
                                ->with('create', true);
            } elseif ($this->aksiDari === 'jadwal') {
                Jadwal::where('id_jadwal', $this->id_jadwal)->update(['status' => 'Terlaksana']);
                return redirect(route('jadwal'))
                                ->with('success', 'Data terapi berhasil ditambahkan.')
                                ->with('create', true);
                
            }
        }    

        
    }
}
