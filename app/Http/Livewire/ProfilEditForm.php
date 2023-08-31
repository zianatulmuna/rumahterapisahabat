<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use Carbon\Carbon;
use App\Models\Terapis;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProfilEditForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $tanggal_lahir, $agama, $alamat, $foto, $tingkatan, $status;
    public $username, $password;

    public $user, $id_user, $dbUsername, $dbFoto, $pathFoto;

    public $totalStep = 2, $currentStep = 1;

    public function mount($user){
        $this->currentStep = 1;
        $this->id_user = $user->id_admin;
        $this->nama = $user->nama;
        $this->username = $user->username;
        $this->dbUsername = $user->username;
        $this->password = $user->password;
        // $this->tingkatan = $user->tingkatan;
        // $this->status = $user->status;
        $this->no_telp = $user->no_telp;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->tanggal_lahir = $user->tanggal_lahir;
        $this->agama = $user->agama;
        $this->alamat = $user->alamat;
        $this->dbFoto = $user->foto;
        $this->pathFoto = $user->foto;
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
        $message = [
            'username.unique' => 'Username sudah dipakai.',
            'required' => 'Kolom :attribute harus diisi.',
            'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digits angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.'
        ];

        if($this->currentStep == 1) {
            $this->validate([
                'nama' => 'required|max:50',
                'no_telp' => 'required|min_digits:10',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'required',
                'agama' => 'max:20',
                'foto' => 'nullable|file|image|max:1024',
            ], $message);            
        } else {
            $this->validate([
                'username' => ['required', 
                                'min:3', 
                                'max:30', 
                                'unique:terapis',
                                Rule::unique('admin')->ignore($this->id_user, 'id_admin')],
                'password' => 'required|min:3|max:60'
            ], $message);

        }
    }

    public function update(Request $request) {

        $this->validateData();

        $dataDiri = array(
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'username' => $this->username,
            'password' => $this->password,
        ); 

        if ($this->foto) {
            if ($this->dbFoto) {
                Storage::delete($this->dbFoto);
            }
            $ext = $this->foto->getClientOriginalExtension();
            $dataDiri['foto'] = $this->foto->storeAs('admin', $this->username . '.' . $ext);
        } 
        
        if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
            $dataDiri['foto'] = '';
            Storage::delete($this->pathFoto);
        }

        Admin::where('id_admin', $this->id_user)->update($dataDiri);

        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('profil', $this->username))
                            ->with('success', 'Profil berhasil diupdate')   
                            ->with('update', true);   
    }
}
