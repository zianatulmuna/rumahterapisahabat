<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Terapis;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Http\Requests\TerapisRequest;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TerapisEditForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $tanggal_lahir, $agama, $alamat, $foto, $tingkatan, $status, $total_terapi;
    public $username, $password;

    public $terapis, $id_terapis, $dbUsername, $dbPassword, $dbFoto, $pathFoto;

    public $totalStep = 2, $currentStep = 1;

    public function mount($terapis){
        $this->currentStep = 1;
        $this->id_terapis = $terapis->id_terapis;
        $this->nama = $terapis->nama;
        $this->username = $terapis->username;
        $this->dbUsername = $terapis->username;
        $this->dbPassword = $terapis->password;
        $this->tingkatan = $terapis->tingkatan;
        $this->status = $terapis->status;
        $this->total_terapi = $terapis->total_terapi;
        $this->no_telp = $terapis->no_telp;
        $this->jenis_kelamin = $terapis->jenis_kelamin;
        $this->tanggal_lahir = $terapis->tanggal_lahir;
        $this->agama = $terapis->agama;
        $this->alamat = $terapis->alamat;
        $this->dbFoto = $terapis->foto;
        $this->pathFoto = $terapis->foto;
    }

    public function render()
    {
        return view('livewire.terapis-edit-form', [
            'jenisKelamin' => ['Perempuan','Laki-Laki'],
            'statusTerapis' => ['Aktif','Non Aktif'],
            'tingkatanTerapis' => ['Utama', 'Madya', 'Muda', 'Pratama', 'Latihan']
        ]);
    }

    public function toNext() {
        $this->resetErrorBag();
        
        $this->validateData();
        $this->currentStep++;
        if($this->currentStep == 2) {
            $this->emit('runScript');
        }
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
        $this->dbFoto = null;
    }


    public function validateData(){
        $dataRequest = new TerapisRequest();
        
        match ($this->currentStep) {
            1 => $this->validate(
                $dataRequest->rules1(), 
                $dataRequest->messages()
            ),
            2 => $this->validate(
                $dataRequest->rules2($this->id_terapis), 
                $dataRequest->messages()
            )
        };
    }
    
    public function updateTerapis() {
        $this->username = strtolower($this->username);

        $dataDiri = array(
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'tingkatan' => $this->tingkatan,
            'status' => $this->status,
            'total_terapi' => $this->total_terapi,
            'username' => $this->username,
            'password' => $this->password ? bcrypt($this->password) : $this->dbPassword
        ); 

        if ($this->foto) {
            if ($this->dbFoto) {
                Storage::delete($this->dbFoto);
            }
            $ext = $this->foto->getClientOriginalExtension();
            $dataDiri['foto'] = $this->foto->storeAs('terapis', $this->username . '.' . $ext);
        } 
        
        if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
            $dataDiri['foto'] = '';
            Storage::delete($this->pathFoto);
        }

        Terapis::where('id_terapis', $this->id_terapis)->update($dataDiri);
    }

    public function update() {

        $this->validateData();
        $this->updateTerapis();        

        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('terapis.detail', $this->username))
                            ->with('success', 'Data Terapis berhasil diupdate')   
                            ->with('update', true);   
    }
}
