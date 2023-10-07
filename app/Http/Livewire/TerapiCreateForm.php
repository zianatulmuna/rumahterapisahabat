<?php

namespace App\Http\Livewire;

use App\Http\Requests\TerapiRequest;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
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
        $dataRequest = new TerapiRequest();
        
        match ($this->currentStep) {
            1 => $this->validate(
                $dataRequest->rules1($this->id_sub, $this->id_terapis, $this->tanggal), 
                $dataRequest->messages()
            ),
            2 => $this->validate(
                $dataRequest->rules2(), 
                $dataRequest->messages()
            )
        };
    }

    public function storeTerapi() {
        $dateM = Carbon::parse($this->tanggal)->format('ym');

        $id = IdGenerator::generate([
            'table' => 'rekam_terapi', 
            'field' => 'id_terapi', 
            'length' => 8, 
            'prefix' => 'T'.$dateM,
            'reset_on_prefix_change' => true
        ]);

        $dataTerapi = array(
            'id_terapi' => $id,
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

        $isTerapiSuccess = RekamTerapi::create($dataTerapi);

        return $isTerapiSuccess;
    }

    public function updateJadwalSub() {
        $totalTerapiSub = RekamTerapi::totalTerapiSub($this->id_sub);

        SubRekamMedis::where('id_sub', $this->id_sub)->update(['total_terapi' => $totalTerapiSub]);

        $terapis = Terapis::find($this->id_terapis);
        $terapis->increment('total_terapi', 1);
        
        Jadwal::where('id_sub', $this->id_sub)
                ->where('id_terapis', $this->id_terapis)
                ->where('tanggal', $this->tanggal)
                ->update(['status' => 'Terlaksana']);
    }

    public function create() {
        $this->validateData();

        $isTerapiSuccess = $this->storeTerapi();

        if($isTerapiSuccess) {
            $this->updateJadwalSub();
        }  

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
