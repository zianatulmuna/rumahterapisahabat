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
            'username.regex' => 'Username tidak boleh mengandung spasi.',
        ];

        if($this->currentStep == 1) {
            if(empty($this->id_pasien)) {
                $this->validate([
                    'nama' => 'required|max:50',
                    'no_telp' => 'required|min_digits:8',
                    'tanggal_lahir' => 'nullable|date',
                    'jenis_kelamin' => 'required',
                    'agama' => 'max:20',
                    'foto' => 'nullable|file|image|max:1024',
                    
                ], $message);
            }
        } else {
            $this->validate([
                'username' => ['required', 'min:3', 'max:30', 'unique:terapis', 'unique:admin', 'unique:kepala_terapis','regex:/^\S*$/u'],
                'password' => 'required|min:3|max:60',
                'tingkatan' => 'required',
                'total_terapi' => 'nullable|numeric|max_digits:10',
            ], $message);

        }
    }

    public function create(Request $request) {

        $this->validateData();

        $dataDiri = array(
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'tingkatan' => $this->tingkatan,
            'total_terapi' => $this->total_terapi,
            // 'status' => $this->status,
            'username' => $this->username,
            'password' => bcrypt($this->password),
        ); 

        $this->username = strtolower($this->username);

        $idTerapis = IdGenerator::generate(['table' => 'terapis', 'field' => 'id_terapis', 'length' => 6, 'prefix' => 'TRP', 'reset_on_prefix_change' => true]);

        if ($this->foto) {
            // $imageName = $this->username . '.' . $this->foto->getClientOriginalExtension();

            // $resizedImage = Image::make($request->file('photo'))->resize(115, null);

            $ext = $this->foto->getClientOriginalExtension();
            $dataDiri['foto'] = $this->foto->storeAs('terapis', $this->username . '.' . $ext);
        }
        
        $dataDiri['id_terapis'] = $idTerapis;
        $dataDiri['status'] = $this->status == '' ? 'Aktif' : $this->status;

        Terapis::create($dataDiri);

        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect(route('terapis'))
                            ->with('success', 'Terapis berhasil ditambahkan')   
                            ->with('create', true);   
    }
}
