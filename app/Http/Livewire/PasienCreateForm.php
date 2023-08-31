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
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PasienCreateForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $email, $tanggal_lahir, $pekerjaan, $agama, $alamat;
    public $tipe_pembayaran, $penanggungjawab, $biaya_pembayaran, $link_rm, $foto, $tanggal_pendaftaran, $tanggal_ditambahkan; 
    public $tempat_layanan, $jadwal_layanan, $sistem_layanan, $jumlah_layanan, $status_pasien, $status_terapi, $ket_status, $tanggal_selesai;

    public $k_bsni, $provId, $jalan, $provinsi, $kabupaten;

    public $penyakit, $keluhan, $catatan_psikologis, $catatan_bioplasmatik, $catatan_rohani, $catatan_fisik, $data_deteksi;
    public $kondisi_awal, $target_akhir, $link_perkembangan, $kesimpulan;

    public $pasien, $id_pasien, $slug, $dbNama, $dbFoto, $pathFoto;

    public $totalStep = 5, $currentStep = 1;

    public $tag = [], $newTag;

    protected $listeners = ['addTagPenyakit', 'setAlamatKode'];

    public function mount($pasien){
        $this->currentStep;
        $this->tag;
        $this->tempat_layanan;

        if($pasien) {
            $this->pasien = $pasien;
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
            // $this->tanggal_ditambahkan = $pasien->tanggal_pendaftaran;                        
        }   else {
            $this->id_pasien = '';
        }     
    }

    public function render()
    {
        $listPenyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');

        return view('livewire.pasien-create-form', [
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
            ],
            'listPenyakit' => $listPenyakit
            
        ]);
    }

    public function toNext() {
        $this->resetErrorBag();
        
        $this->validateData();
        $this->currentStep++;
        if($this->currentStep == 3) {
            $this->runEmitAlamat();
        }
        if($this->currentStep == 4) {
            $this->emit('runScriptPenyakit');
        }
        if($this->currentStep > $this->totalStep) {
            $this->currentStep = $this->totalStep;
        }
    }
    public function toPrev() {
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep == 3) {
            $this->runEmitAlamat();
        }
        if($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }
    public function deleteFoto() {
        $this->foto = null;
    }

    public function addTagPenyakit($value)
    {
        $this->tag[] = $value;
    }

    public function deleteTagPenyakit($value)
    {
        $index = array_search($value, $this->tag);
        if ($index !== false) {
            unset($this->tag[$index]);
        }
    }

    public function runEmitAlamat() {
        $kab_prov = [
            'provId' => $this->provId,
            'jalan' => $this->jalan,
            'provinsi' => $this->provinsi,
            'kabupaten' => $this->kabupaten,
        ];
        $this->emit('runScriptAlamat', $kab_prov);
    }

    public function setAlamatKode($data) {
        $this->tempat_layanan = $data['tempat'];
        $this->k_bsni = $data['kode'];
        $this->provId = $data['provId'];
        $this->jalan = $data['jalan'];
        $this->provinsi = $data['provinsi'];
        $this->kabupaten = $data['kabupaten'];
        
        $this->runEmitAlamat();
    }

    public function validateData(){
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
            'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
            'min_digits' => 'Kolom :attribute harus diisi minimal :min digits angka.',
            'numeric' => 'Kolom :attribute harus diisi angka.',
            'url' => 'Kolom :attribute harus berupa link URL valid',
            'file' => 'Kolom :attribute harus diisi file.',
            'image' => 'Kolom :attribute harus diisi file gambar.',
            'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.'
        ];

        if($this->currentStep == 1){
            if(empty($this->id_pasien)) {
                $this->validate([
                    'nama' => 'required|max:50',
                    'email' => 'nullable|max:35',
                    'alamat' => 'max:100',
                    'no_telp' => 'required|min_digits:10',
                    'tanggal_lahir' => 'nullable|date',
                    'jenis_kelamin' => 'required',
                    'agama' => 'max:20',
                    'pekerjaan' => 'max:30'
                ], $message);
            }
        }elseif($this->currentStep == 2){
            $this->validate([                
                'biaya_pembayaran' => 'max:20',
                'penanggungjawab' => 'max:50',
                'foto' => 'nullable|file|image|max:1024',
                'link_rm' => 'nullable|url|max:100',
                'tanggal_pendaftaran' => 'required|date', 
                'tanggal_ditambahkan' => [
                    Rule::requiredIf(!empty($this->id_pasien))
                ],                
            ], $message);
            
        }elseif($this->currentStep == 3){
            $this->validate([
                'tempat_layanan' => [
                    'max:50',
                    Rule::requiredIf($this->tempat_layanan == "")
                ],
                'jadwal_layanan' => 'max:50',
                'sistem_layanan' => 'max:50',
                'jumlah_layanan' => 'max:50',
                'status_pasien' => 'required',
                'status_terapi' => 'required',
                'tanggal_selesai' => [
                    Rule::requiredIf($this->status_pasien == 'Selesai' || $this->status_pasien == 'Jeda')
                ]
            ], $message);
        }elseif($this->currentStep == 4){
            $this->validate([
                'penyakit' => [
                    'required_if:tag,0',
                    Rule::requiredIf(count($this->tag) == 0),
                ],
                'keluhan' => 'max:100',
                'catatan_fisik' => 'max:50',
                'catatan_psikologis' => 'max:50',
                'catatan_bioplasmatik' => 'max:50',
                'catatan_rohani' => 'max:50',
                'data_deteksi' => 'max:50',
            ], $message);    
        }else{
            $this->validate([
                'link_perkembangan' => 'nullable|url|max:100',
                'kondisi_awal' => 'max:100',
                'target_akhir' => 'max:100',
                'kesimpulan' => 'max:100',
            ]);
        }
    }

    public function create(Request $request) {
        
        $this->validateData();

        $dateY = substr(Carbon::parse($this->tanggal_pendaftaran)->format('Y'), 2);
        $dateM = Carbon::parse($this->tanggal_pendaftaran)->format('m');
        $waktuDaftar = Carbon::now()->format('H:i:s');

        if(empty($this->id_pasien)) {
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

            $this->id_pasien = IdGenerator::generate(['table' => 'pasien', 'field' => 'id_pasien', 'length' => 8, 'prefix' => 'P'.$dateY, 'reset_on_prefix_change' => true]);
         
            $this->slug = SlugService::createSlug(Pasien::class, 'slug', $this->nama);

            if ($this->foto) {
                $ext = $this->foto->getClientOriginalExtension();
                $dataDiri['foto'] = $this->foto->storeAs('pasien', $this->slug . '.' . $ext);
            }

            $dataDiri['id_pasien'] = $this->id_pasien;
            $dataDiri['status_pendaftaran'] = 'Pasien Lama';
            $dataDiri['slug'] = $this->slug;
            $dataDiri['tanggal_pendaftaran'] = $this->tanggal_pendaftaran . ' ' . $waktuDaftar;
            $this->tanggal_ditambahkan = $this->tanggal_pendaftaran . ' ' . $waktuDaftar;

            Pasien::create($dataDiri);

        }

        $dataRM = array(
            'penyakit' => $this->penyakit,
            'keluhan' => $this->keluhan,
            // 'link_rm' => $this->link_rm,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'biaya_pembayaran' => $this->biaya_pembayaran,
            'penanggungjawab' => $this->penanggungjawab,
            'tempat_layanan' => $this->tempat_layanan,
            'jadwal_layanan' => $this->jadwal_layanan,
            'sistem_layanan' => $this->sistem_layanan,            
            'status_terapi' => $this->status_terapi,
            'status_pasien' => $this->status_pasien,
            'catatan_fisik' => $this->catatan_fisik,
            'catatan_psikologis' => $this->catatan_psikologis,
            'catatan_bioplasmatik' => $this->catatan_bioplasmatik,
            'catatan_rohani' => $this->catatan_rohani,
            'data_deteksi' => $this->data_deteksi,
            'kondisi_awal' => $this->kondisi_awal,
            'target_akhir' => $this->target_akhir,
            'kesimpulan' => $this->kesimpulan,
            'link_perkembangan' => $this->link_perkembangan,
            'tanggal_ditambahkan' => $this->tanggal_ditambahkan,
        );              

        $idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 10, 'prefix' => $this->k_bsni . $dateY.$dateM, 'reset_on_prefix_change' => true]);

        $penyakit = implode(',', $this->tag);
        $dataRM['id_rekam_medis'] = $idRM;
        $dataRM['id_pasien'] = $this->id_pasien;
        $dataRM['penyakit'] = $penyakit;     
        if($this->jumlah_layanan) {
            $dataRM['jumlah_layanan'] = $this->jumlah_layanan;
        }   
        
        $createRM = RekamMedis::create($dataRM);

        if($createRM) {
            foreach ($this->tag as $penyakit) {
                $idSub = IdGenerator::generate([
                    'table' => 'sub_rekam_medis', 
                    'field' => 'id_sub',
                    'length' => 10, 
                    'prefix' => 'SP' . $dateY.$dateM,
                    'reset_on_prefix_change' => true
                ]);

                $dataSub['id_sub'] = $idSub;
                $dataSub['id_rekam_medis'] = $idRM;
                $dataSub['penyakit'] = $penyakit;

                SubRekamMedis::create($dataSub);
            }
        }
        
        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

        if(empty($this->pasien)) {
            return redirect(route('pasien.create'))
                            ->with('success', 'Pasien berhasil ditambahkan. ')   
                            ->with('createPasien', $this->slug);   
        } else {
            return redirect()->route('rm.histori', $this->slug)->with('success', 'Rekam Medis berhasil ditambahkan.');       
        }     
    }
}
