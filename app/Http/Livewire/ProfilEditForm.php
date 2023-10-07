<?php

namespace App\Http\Livewire;

use App\Http\Requests\ProfilRequest;
use App\Models\Admin;
use App\Models\Terapis;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilEditForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $tanggal_lahir, $agama, $alamat, $foto, $tingkatan, $status;
    public $username, $password;

    public $user, $id_user, $dbUsername, $dbPassword, $dbFoto, $pathFoto;

    public $totalStep = 2, $currentStep = 1;

    public function mount($user){
        $this->currentStep = 1;
        $this->nama = $user->nama;
        $this->username = $user->username;
        $this->dbUsername = $user->username;
        $this->dbPassword = $user->password;
        $this->no_telp = $user->no_telp;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->tanggal_lahir = $user->tanggal_lahir;
        $this->agama = $user->agama;
        $this->alamat = $user->alamat;
        $this->dbFoto = $user->foto;
        $this->pathFoto = $user->foto;

        if(Auth::guard('admin')->check()) {
            $this->id_user = $user->id_admin;
        }elseif(Auth::guard('terapis')->check()) {
            $this->id_user = $user->id_terapis;
        }
        
    }
    public function render()
    {
        return view('livewire.profil-edit-form',[
            'jenisKelamin' => ['Perempuan','Laki-Laki']
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
        $this->dbFoto = null;
    }

    public function validateData(){
        $dataRequest = new ProfilRequest();
        
        match ($this->currentStep) {
            1 => $this->validate(
                $dataRequest->rules1(), 
                $dataRequest->messages()
            ),
            2 => $this->validate(
                $dataRequest->rules2($this->id_user), 
                $dataRequest->messages()
            )
        };
    }

    public function update() {

        $this->validateData();

        $this->username = strtolower($this->username);

        $dataDiri = array(
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'username' => $this->username,
            'password' => $this->password ? bcrypt($this->password) : $this->dbPassword
        );

        if ($this->foto) {
            if ($this->dbFoto) {
                Storage::delete($this->dbFoto);
            }
            $ext = $this->foto->getClientOriginalExtension();
            $folder = (Auth::guard('admin')->user()) ? 'admin' : 'terapis';
            $dataDiri['foto'] = $this->foto->storeAs($folder, $this->username . '.' . $ext);
        } 
        
        if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
            $dataDiri['foto'] = '';
            Storage::delete($this->pathFoto);
        }

        if(Auth::guard('admin')->check()) {
            Admin::where('id_admin', $this->id_user)->update($dataDiri);
        } elseif (Auth::guard('terapis')->check()) {
            Terapis::where('id_terapis', $this->id_user)->update($dataDiri);
        }
        
        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('profil', $this->username))
                            ->with('success', 'Profil berhasil diupdate')   
                            ->with('update', true);   
    }
}
