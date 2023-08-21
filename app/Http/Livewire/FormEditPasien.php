<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pasien;
use Livewire\Component;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class FormEditPasien extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $email, $tanggal_lahir, $pekerjaan, $agama, $alamat;
    public $tipe_pembayaran, $penanggungjawab, $biaya_pembayaran, $link_rm, $foto, $tanggal_pendaftaran; 
    public $tempat_layanan, $jadwal_layanan, $sistem_layanan, $jumlah_layanan, $status_pasien, $status_terapi, $ket_status, $tanggal_selesai;
    public $penyakit, $keluhan, $catatan_psikologis, $catatan_bioplasmatik, $catatan_rohani, $catatan_fisik, $data_deteksi;

    public $totalStep = 4, $currentStep = 1;

    public $pasien, $rm, $id_pasien, $id_rekam_medis, $slug, $dbNama, $dbFoto, $pathFoto;

    public $tag = [], $dataTag = [], $newTag, $dbPenyakit, $deletedTag = [], $checkDuplikat = false;

    protected $listeners = ['addTagPenyakit', 'editExistPenyakit'];

    public function mount($pasien, $rm){
        $this->id_pasien = $pasien->id_pasien;
        $this->nama = $pasien->nama;
        $this->dbNama = $pasien->nama;
        $this->no_telp = $pasien->no_telp;
        $this->jenis_kelamin = $pasien->jenis_kelamin;
        $this->tanggal_lahir = $pasien->tanggal_lahir;
        $this->tanggal_pendaftaran = Carbon::parse($pasien->tanggal_pendaftaran)->format('Y-m-d');
        $this->email = $pasien->email;
        $this->pekerjaan = $pasien->pekerjaan;
        $this->agama = $pasien->agama;
        $this->alamat = $pasien->alamat;
        $this->dbFoto = $pasien->foto;
        $this->pathFoto = $pasien->foto;
        $this->slug = $pasien->slug;
        $this->tag;

        if($rm) {
            $this->id_rekam_medis = $rm->id_rekam_medis;
            $this->keluhan = $rm->keluhan;
            $this->link_rm = $rm->link_rm;
            $this->tipe_pembayaran = $rm->tipe_pembayaran;
            $this->biaya_pembayaran = $rm->biaya_pembayaran;
            $this->penanggungjawab = $rm->penanggungjawab;
            $this->tempat_layanan = $rm->tempat_layanan;
            $this->sistem_layanan = $rm->sistem_layanan;
            $this->jumlah_layanan = $rm->jumlah_layanan;
            $this->jadwal_layanan = $rm->jadwal_layanan;
            $this->status_terapi = $rm->status_terapi;
            $this->status_pasien = $rm->status_pasien;
            $this->catatan_fisik = $rm->catatan_fisik;
            $this->catatan_psikologis = $rm->catatan_psikologis;
            $this->catatan_bioplasmatik = $rm->catatan_bioplasmatik;
            $this->catatan_rohani = $rm->catatan_rohani;
            $this->data_deteksi = $rm->data_deteksi;
            $this->currentStep = 1;

            $this->dbPenyakit = explode(",", $rm->penyakit);

            for ($i = 0; $i < count($this->dbPenyakit); $i++) {   
                $this->dataTag[] = ['current' => $this->dbPenyakit[$i], 'db' => $this->dbPenyakit[$i]];
            }

            $this->deletedTag;
        }        
    }
    public function render()
    {
        return view('livewire.form-edit-pasien', [
            'jenisKelamin' => ['Perempuan','Laki-Laki'],
            'tipePembayaran' => [
                ['value' => 'Profesional', 'id' => 'profesional'], 
                ['value' => 'Kesepakatan', 'id' => 'kesepakatan'], 
                ['value' => 'Tidak Mampu', 'id' => 'tidak_mampu']
            ],
            'statusPasien' => [
                ['value' => 'Rawat Jalan', 'name' => 'rawat_jalan'], 
                ['value' => 'Jeda', 'name' => 'jeda'], 
                ['value' => 'Selesai', 'name' => 'selesai']
            ],
            'statusTerapi' => [
                ['value' => 'Terapi Baru', 'name' => 'terapi_baru'], 
                ['value' => 'Terapi Lanjutan', 'name' => 'terapi_lanjutan']
            ]
        ]);
    }    
    public function toNext() {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if($this->currentStep == 2) {
            $this->emit('runScriptPenyakit');
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

    public function checkDuplicateTag($value) {
        for ($i = 0; $i < count($this->dataTag); $i++) {
            if($value == $this->dataTag[$i]['db']) {
                $this->checkDuplikat = true;
                break;
            }             
        }
    }

    public function addTagPenyakit($value)
    {
        $this->checkDuplicateTag($value);

        if (!$this->checkDuplikat) {
            if (!empty($this->newTag)) {
                $this->tag[] = $value;
            }
        } else {
            return redirect()->back()->with('duplicate', 'Nama penyakit sudah ada.');
        }        
    }

    public function enterTagPenyakit()
    {
        $this->checkDuplicateTag($this->newTag);

        if (!$this->checkDuplikat) {
            if (!empty($this->newTag)) {
                $this->tag[] = $this->newTag;
                $this->newTag = '';
            }
        } else {
            return redirect()->back()->with('duplicate', 'Nama penyakit sudah ada.');
        }  
    }

    public function editExistPenyakit($data) {
        $dbValue = $data['dbValue'];
        $currentValue = $data['inputValue'];
        
        $this->checkDuplicateTag($currentValue);

        if (!$this->checkDuplikat) {
            $index = array_search($dbValue, array_column($this->dataTag, 'db'));
            $this->dataTag[$index]['current'] = $currentValue;
        } else {
            return redirect()->back()->with('duplicate', 'Nama penyakit sudah ada.');
        }
    }

    public function deleteTagPenyakit($value)
    {
        $index = array_search($value, array_column($this->dataTag, 'db'));
        if ($index !== false) {
            unset($this->dataTag[$index]);
            $this->deletedTag[] = $value;
            // dd(count($this->tag));
        } else {
            return redirect()->back()->with('duplicate', 'Gagal hapus.');
        }
    }

    public function deleteTagBaru($value)
    {
        $index = array_search($value, $this->tag);
        if ($index !== false) {
            unset($this->tag[$index]);
        }
    }

    public function validateData(){
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'foto.max' => 'Kolom :attribute harus diisi maksimal :max KB (1 MB).',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digits angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.'
        ];

        if($this->currentStep == 1){
            $this->validate([
                'nama' => 'required|max:50',
                'email' => 'required|max:35',
                'alamat' => 'max:100',
                'no_telp' => 'required|min_digits:10',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'required',
                'agama' => 'max:20',
                'pekerjaan' => 'max:30'
            ], $message);
        }elseif($this->currentStep == 2){
            if(empty($this->dataTag[0]['db']) && empty($this->dataTag[0]['current'])) {
                if(count($this->tag) == 0) {
                    $tagPenyakit = 0;
                }
            } else {
                $tagPenyakit = 1;
            }
            $this->validate([
                'keluhan' => 'required|max:100',
                'foto' => 'nullable|file|image|max:1024',
                'link_rm' => 'nullable|url|max:100',
                'tanggal_pendaftaran' => 'required|date',
                'penyakit' => [
                    'required_if:tagPenyakit,0',
                    Rule::requiredIf($tagPenyakit == 0),
                ],
            ], $message);      
        }elseif($this->currentStep == 3){
            $this->validate([
                'biaya_pembayaran' => 'max:20',
                'penanggungjawab' => 'max:50',
                'tempat_layanan' => 'max:50',
                'jadwal_layanan' => 'max:50',
                'sistem_layanan' => 'max:50',
                'jumlah_layanan' => 'max:50',
                'status_pasien' => 'required',
                'tanggal_selesai' => [
                    Rule::requiredIf($this->status_pasien == 'Selesai')
                ]
            ], $message);
        }else{
            $this->validate([
                'catatan_fisik' => 'max:50',
                'catatan_psikologis' => 'max:50',
                'catatan_bioplasmatik' => 'max:50',
                'catatan_rohani' => 'max:50',
                'data_deteksi' => 'max:50',
            ], $message);    
        }
    }
    public function update(Request $request, Pasien $pasien) {
        $this->validateData();

        $dataDiri = array(
            'nama' => $this->nama,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'pekerjaan' => $this->pekerjaan
        );        

        $dataRM = array(
            // 'penyakit' => $this->penyakit,
            'keluhan' => $this->keluhan,
            'link_rm' => $this->link_rm,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'biaya_pembayaran' => $this->biaya_pembayaran,
            'penanggungjawab' => $this->penanggungjawab,
            'tempat_layanan' => $this->tempat_layanan,
            'jadwal_layanan' => $this->jadwal_layanan,
            'sistem_layanan' => $this->sistem_layanan,
            'jumlah_layanan' => $this->jumlah_layanan,
            'status_terapi' => $this->status_terapi,
            'status_pasien' => $this->status_pasien,
            'catatan_fisik' => $this->catatan_fisik,
            'catatan_psikologis' => $this->catatan_psikologis,
            'catatan_bioplasmatik' => $this->catatan_bioplasmatik,
            'catatan_rohani' => $this->catatan_rohani,
            'data_deteksi' => $this->data_deteksi,
        );

        if($this->nama != $this->dbNama) {
            $this->slug = SlugService::createSlug(Pasien::class, 'slug', $this->nama);
            $dataDiri['slug'] = $this->slug;
        }

        if ($this->foto) {
            if ($this->dbFoto) {
                Storage::delete($this->dbFoto);
            }
            $dataDiri['foto'] = $this->foto->store('pasien');
        } 
        
        if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
            $dataDiri['foto'] = '';
            Storage::delete($this->pathFoto);
        }

        

        if($this->rm) {            
            $currentArray = array_column($this->dataTag, 'current');
            $tagUpdate = implode(',', $currentArray);

            if($tagUpdate != implode(',', $this->dbPenyakit) || !empty($this->tag)) { //jika susunan string penyakit beda
                if(count($this->deletedTag) > 0) { //jika ada yang dihapus
                    foreach ($this->deletedTag as $tag) {
                        SubRekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->where('penyakit', $tag)->delete();                           
                    }
                } 
                for ($i = 0; $i < count($this->dataTag); $i++) {    
                    $current = $this->dataTag[$i]['current'];
                    $db = $this->dataTag[$i]['db'];
                                      
                    if($current != $db){
                        $dataSub['penyakit'] = $current;
                        SubRekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->where('penyakit', $db)->update($dataSub);
                    }
                }
                if(!empty($this->tag)){
                    foreach ($this->tag as $newTag) {
                        $idSub = IdGenerator::generate(['table' => 'sub_rekam_medis', 'field' => 'id_sub', 'length' => 7, 'prefix' => 'SRM', 'reset_on_prefix_change' => true]);

                        $dataSub['id_sub'] = $idSub;
                        $dataSub['id_rekam_medis'] = $this->id_rekam_medis;
                        $dataSub['penyakit'] = $newTag;

                        SubRekamMedis::create($dataSub);
                    }
                }
                $updatePenyakit = array_merge($currentArray, $this->tag);
                $dataRM['penyakit'] = implode(',', $updatePenyakit);
            }
            RekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->update($dataRM);
        } else {
            $dateM = Carbon::parse($request->date)->format('m');
            $dateY = substr(Carbon::parse($request->date)->format('Y'), 2);
            
            $idRM = $idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 7, 'prefix' => $dateY.$dateM, 'reset_on_prefix_change' => true]);

            $dataRM['id_rekam_medis'] = $idRM;
            $dataRM['id_pasien'] = $this->id_pasien;
            $dataRM['penyakit'] = implode(',', $this->tag);
            $dataDiri['status_pendaftaran'] = 'Pasien Lama';

            // dd($this->tag);

            $createRM = RekamMedis::create($dataRM);

            if($createRM) {
                foreach ($this->tag as $penyakit) {
                    $idSub = IdGenerator::generate([
                        'table' => 'sub_rekam_medis', 
                        'field' => 'id_sub',
                        'length' => 10, 
                        'prefix' => $idRM . 'S',
                        'reset_on_prefix_change' => true
                    ]);
    
                    $dataSub['id_sub'] = $idSub;
                    $dataSub['id_rekam_medis'] = $idRM;
                    $dataSub['penyakit'] = $penyakit;
    
                    SubRekamMedis::create($dataSub);
                }
            }
        }

        Pasien::where('id_pasien', $this->id_pasien)->update($dataDiri);

        $path = $this->slug;
        

        if($this->rm) {
            $rmCheck = true;
        } else {
            $rmCheck = false;
        }

        $this->reset();
        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        return redirect('/admin/pasien/' . $path )->with('success', 'Pasien berhasil ditambahkan ke data Pasien Lama.');

        if($rmCheck) {
            return redirect(route('pasien.rm', $path))
                            ->with('success', 'Pasien berhasil diupdate.')   
                            ->with('update', true);   
        } else {
            return redirect(route('pasien.rm', $path))
                            ->with('success', 'Pasien berhasil ditambahkan ke data Pasien Lama.')   
                            ->with('create', true);     
        }
    }
}
