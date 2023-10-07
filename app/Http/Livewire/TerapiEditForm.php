<?php

namespace App\Http\Livewire;

use App\Models\Jadwal;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use App\Http\Requests\TerapiRequest;

class TerapiEditForm extends Component
{
    public $pasien, $id_terapis, $nama_terapis, $keluhan, $deteksi, $tindakan, $saran, $pra_terapi, $post_terapi, $waktu, $tanggal;
    public $id_terapi, $id_sub;

    public $totalStep = 2, $currentStep = 1, $oldIdTerapis;
    protected $listeners = ['setTerapis'];

    public function mount($pasien, $terapi) {
        $this->id_terapi = $terapi->id_terapi;
        $this->id_sub = $terapi->id_sub;
        $this->id_terapis = $terapi->id_terapis;
        $this->nama_terapis = $terapi->terapis->nama;
        $this->keluhan = str_replace('<br />', '', $terapi->keluhan);
        $this->deteksi = str_replace('<br />', '', $terapi->deteksi);
        $this->tindakan = str_replace('<br />', '', $terapi->tindakan);
        $this->saran = str_replace('<br />', '', $terapi->saran);
        $this->pra_terapi = str_replace('<br />', '', $terapi->pra_terapi);
        $this->post_terapi = str_replace('<br />', '', $terapi->post_terapi);
        $this->tanggal = $terapi->tanggal;
        $this->waktu = $terapi->waktu;
        $this->currentStep;
        $this->pasien = $pasien;
        
        $this->oldIdTerapis = $terapi->id_terapis;
        $this->oldIdSub = $terapi->id_sub;
        $this->oldTanggal = $terapi->tanggal;
    }
    public function render()
    {
        $terapis = Terapis::orderBy('nama', 'ASC')->get();

        return view('livewire.terapi-edit-form', compact('terapis'));
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

    public function updateTerapi() {
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

        $isTerapiSuccess = RekamTerapi::where('id_terapi', $this->id_terapi)->update($dataTerapi);

        return $isTerapiSuccess;
    }

    public function updateJadwalSub() {
        $totalTerapiSub = RekamTerapi::totalTerapiSub($this->id_sub);
        
        SubRekamMedis::where('id_sub', $this->id_sub)->update(['total_terapi' => $totalTerapiSub]);
        
        if($this->id_terapis != $this->oldIdTerapis) {
            Terapis::where('id_terapis', $this->id_terapis)->increment('total_terapi', 1);
            Terapis::where('id_terapis', $this->oldIdTerapis)->decrement('total_terapi', 1);
        }
        
        if($this->id_terapis != $this->oldIdTerapis || $this->tanggal != $this->oldTanggal) {

        Jadwal::where('id_sub', $this->id_sub)
                ->where('id_terapis', $this->id_terapis)
                ->where('tanggal', $this->tanggal)
                ->update(['status' => 'Terlaksana']);

        Jadwal::where('id_sub', $this->oldIdSub)
                ->where('id_terapis', $this->oldIdTerapis)
                ->where('tanggal', $this->oldTanggal)
                ->update(['status' => 'Tertunda']);
        }
    }

    public function update() {
        $this->validateData();

        $isTerapiSuccess = $this->updateTerapi();

        if($isTerapiSuccess) {
            $this->updateJadwalSub();
        }  

        return redirect(route('terapi.rekam', [$this->pasien, $this->id_sub]))
                            ->with('success', 'Terapi Harian berhasil diedit.')
                            ->with('update', true);
    }
}
