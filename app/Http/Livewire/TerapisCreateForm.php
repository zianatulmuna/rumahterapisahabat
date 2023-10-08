<?php

namespace App\Http\Livewire;

use App\Http\Requests\TerapisRequest;
use App\Models\Terapis;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TerapisCreateForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $tanggal_lahir, $agama, $alamat, $foto, $tingkatan, $status, $total_terapi;
    public $username, $password;

    public $totalStep = 2, $currentStep = 1;

    public function mount(){
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.terapis-create-form', [
            'jenisKelamin' => ['Perempuan','Laki-Laki'],
            'statusTerapis' => ['Aktif','Non Aktif'],
            'tingkatanTerapis' => ['Utama', 'Madya', 'Muda', 'Pratama', 'Latihan']
        ]);
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
    public function deleteFoto() {
        $this->foto = null;
    }

    public function validateData(){
        $dataRequest = new TerapisRequest();
        
        match ($this->currentStep) {
            1 => $this->validate(
                $dataRequest->rules1(), 
                $dataRequest->messages()
            ),
            2 => $this->validate(
                $dataRequest->rules2(''), 
                $dataRequest->messages()
            )
        };
    }

    public function storeTerapis() {
        $this->username = strtolower($this->username);

        $idTerapis = IdGenerator::generate(['table' => 'terapis', 'field' => 'id_terapis', 'length' => 6, 'prefix' => 'TRP', 'reset_on_prefix_change' => true]);

        $dataDiri = array(
            'id_terapis' => $idTerapis,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'tingkatan' => $this->tingkatan,
            'total_terapi' => $this->total_terapi ? $this->total_terapi : 0,
            'status' => $this->status == '' ? 'Aktif' : $this->status,
            'username' => $this->username,
            'password' => bcrypt($this->password),
        ); 

        if ($this->foto) {
            $ext = $this->foto->getClientOriginalExtension();
            $dataDiri['foto'] = $this->foto->storeAs('terapis', $this->username . '.' . $ext);
        }

        Terapis::create($dataDiri);
    }

    public function create() {

        $this->validateData();
        $this->storeTerapis();        

        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('terapis'))
                            ->with('success', 'Terapis berhasil ditambahkan')   
                            ->with('create', true);   
    }
}
