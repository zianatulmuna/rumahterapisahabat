<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TerapiCreateForm extends Component
{
    public $pasien, $id_terapis, $nama_terapis, $keluhan, $deteksi, $tindakan, $saran, $pra_terapi, $post_terapi, $waktu, $tanggal;
    public $id_sub;

    public $totalStep = 2, $currentStep = 1;

    protected $listeners = ['setTerapis'];

    public function mount($pasien, $id_sub) {
        $this->id_sub = $id_sub;
        $this->pasien = $pasien;
        $this->currentStep;
        $this->nama_terapis;
    }
    public function render()
    {
        $terapis = Terapis::orderBy('nama', 'ASC')->get();

        return view('livewire.terapi-create-form', compact('terapis'));
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
        if($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function setTerapis($terapis) {
        $this->id_terapis = $terapis['id'];
        $this->nama_terapis = $terapis['nama'];
        // dd($this->nama_terapis);
    }

    public function validateData(){
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'id_terapis.required' => 'Kolom terapis harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'tanggal.unique' => 'Tanggal sudah ada'
        ];

        if($this->currentStep == 1){
            $id = $this->id_sub;
            $this->validate([
                'id_terapis' => 'required',
                'pra_terapi' => 'max:100',
                'post_terapi' => 'max:100',
                'tanggal' => [
                    'required',
                    'date',
                    Rule::unique('rekam_terapi', 'tanggal')->where(function ($query) use ($id) {
                        return $query->where('id_sub', $id);
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
            'keluhan' => $this->keluhan,
            'deteksi' => $this->deteksi,
            'tindakan' => $this->tindakan,
            'saran' => $this->saran,
            'pra_terapi' => $this->pra_terapi,
            'post_terapi' => $this->post_terapi
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

        RekamTerapi::create($dataTerapi);

        return redirect(route('terapi.rekam', [$this->pasien, $this->id_sub]))
                            ->with('success', 'Terapi Harian berhasil ditambahkan.')
                            ->with('create', true);
    }
}
