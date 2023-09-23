<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Terapis;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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

        if(Auth::guard('admin')->user()) {
            $this->id_user = $user->id_admin;
        }elseif(Auth::guard('terapis')->user()) {
            $this->id_user = $user->id_terapis;
        }elseif(Auth::guard('kepala_terapis')->user()) {
            $this->id_user = $user->id_kepala;
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
        $message = [
            'username.unique' => 'Username sudah dipakai.',
            'required' => 'Kolom :attribute harus diisi.',
            'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',            
            'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
            'username.regex' => 'Username tidak boleh mengandung spasi.'
        ];

        if($this->currentStep == 1) {
            $this->validate([
                'nama' => 'required|max:50',
                'no_telp' => 'required|min_digits:8|max_digits:15',
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
                                'regex:/^\S*$/u',
                                Rule::unique('admin')->ignore($this->id_user, 'id_admin'),
                                Rule::unique('terapis')->ignore($this->id_user, 'id_terapis'),
                                Rule::unique('kepala_terapis')->ignore($this->id_user, 'id_kepala')],
                'password' => 'nullable|min:3|max:60'
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
            // 'password' => Hash::make($this->password),
        ); 

        $this->username = strtolower($this->username);

        if ($this->foto) {
            if ($this->dbFoto) {
                Storage::delete($this->dbFoto);
            }
            $ext = $this->foto->getClientOriginalExtension();

            $folder = (Auth::guard('admin')->user()) ? 'admin' : 'terapis';
            // $folder = (Auth::guard('terapis')->user()) ? 'terapis' : (Auth::guard('admin')->user() ? 'admin' : 'kepala_terapis');

            $dataDiri['foto'] = $this->foto->storeAs($folder, $this->username . '.' . $ext);
        } 
        
        if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
            $dataDiri['foto'] = '';
            Storage::delete($this->pathFoto);
        }

        $dataDiri['password'] = $this->password ? bcrypt($this->password) : $this->dbPassword;

        if(Auth::guard('admin')->user()) {
            Admin::where('id_admin', $this->id_user)->update($dataDiri);
        } elseif (Auth::guard('terapis')->user()) {
            Terapis::where('id_terapis', $this->id_user)->update($dataDiri);
        }


        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('profil', $this->username))
                            ->with('success', 'Profil berhasil diupdate')   
                            ->with('update', true);   
    }
}
