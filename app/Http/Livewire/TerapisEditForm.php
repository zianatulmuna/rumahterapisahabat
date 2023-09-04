<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Terapis;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
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
                                Rule::unique('terapis')->ignore($this->id_terapis, 'id_terapis'),
                                Rule::unique('admin')->ignore($this->id_terapis, 'id_admin'),
                                Rule::unique('kepala_terapis')->ignore($this->id_user, 'id_kepala')],
                'password' => 'nullable|min:3|max:10',
                'tingkatan' => 'required',
                // 'status' => 'required',                
                'total_terapi' => 'numeric|max_digits:10',
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
            'tingkatan' => $this->tingkatan,
            'status' => $this->status,
            'total_terapi' => $this->total_terapi,
            'username' => $this->username,
            'password' => $this->password,
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

        $dataDiri['password'] = $this->password ? $this->password : $this->dbPassword;

        Terapis::where('id_terapis', $this->id_terapis)->update($dataDiri);

        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('terapis.detail', $this->username))
                            ->with('success', 'Data Terapis berhasil diupdate')   
                            ->with('update', true);   
    }
}
