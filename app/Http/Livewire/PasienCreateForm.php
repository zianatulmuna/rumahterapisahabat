<?php

namespace App\Http\Livewire;

use App\Http\Requests\PasienRequest;
use App\Models\Terapis;
use App\Models\Pasien;
use Livewire\Component;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PasienCreateForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $email, $tanggal_lahir, $pekerjaan, $agama, $alamat;
    public $tipe_pembayaran, $penanggungjawab, $biaya_pembayaran, $link_rm, $foto, $tanggal_pendaftaran, $tanggal_registrasi, $jumlah_bayar; 
    public $tempat_layanan, $jadwal_layanan, $sistem_layanan, $jumlah_layanan, $status_pasien, $status_terapi, $ket_status, $tanggal_selesai;
    public $penyakit, $keluhan, $catatan_psikologis, $catatan_bioplasmatik, $catatan_rohani, $catatan_fisik, $data_deteksi;
    public $kondisi_awal, $target_akhir, $link_perkembangan, $kesimpulan;
    public $is_private = 0, $id_terapis;

    public $id_pasien, $slug;

    public $k_bsni, $provId, $jalan, $provinsi, $kabupaten;
    public $pasien, $dbFoto, $pathFoto, $sistemOption, $tempatOption, $idRM, $id_rekam_medis, $isPasienLama;

    public $totalStep = 6, $currentStep = 1;

    public $tag = [], $enterTag;

    protected $listeners = ['addTagPenyakit', 'setAlamatKode'];

    public function mount($pasien){
        $this->currentStep;
        $this->tag;
        $this->tempat_layanan;
        $this->sistemOption;
        $this->tempatOption;
        $this->is_private;
        $this->id_rekam_medis;

        if($pasien) {            
            $this->id_pasien = $pasien->id_pasien;
            $this->nama = $pasien->nama;
            $this->no_telp = $pasien->no_telp;
            $this->jenis_kelamin = $pasien->jenis_kelamin;
            $this->tanggal_lahir = $pasien->tanggal_lahir;
            $this->tanggal_pendaftaran = $pasien->tanggal_pendaftaran;
            $this->email = $pasien->email;
            $this->pekerjaan = $pasien->pekerjaan;
            $this->agama = $pasien->agama;
            $this->alamat = $pasien->alamat;
            $this->slug = $pasien->slug;  
            
            $this->pasien = $pasien;            
            $this->dbFoto = $pasien->foto;
            $this->pathFoto = $pasien->foto;
            $this->isPasienLama = true;
        }   else {
            $this->id_pasien = '';
        }     
    }

    public function render()
    {
        $listPenyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');
        $listTerapis = Terapis::orderBy('nama', 'ASC')->get();

        return view('livewire.pasien-create-form', [
            'jenisKelamin' => ['Perempuan','Laki-Laki'],
            'tipePembayaran' => [
                ['value' => 'Profesional', 'id' => 'profesional'], 
                ['value' => 'Kesepakatan', 'id' => 'kesepakatan'], 
                ['value' => 'Kontrak', 'id' => 'kontrak'], 
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
            'listPenyakit' => $listPenyakit,
            'listTerapis' => $listTerapis
            
        ]);
    }

    public function validateData() {
        $dataRequest = new PasienRequest();
        
        match ($this->currentStep) {
            1 => $this->validate(
                $dataRequest->rules1(), 
                $dataRequest->messages()
            ),
            2 => $this->validate(
                $dataRequest->rules2($this->id_pasien), 
                $dataRequest->messages()
            ),
            3 => $this->validate(
                $dataRequest->rules3($this->id_pasien,'',$this->tempat_layanan,$this->status_pasien,$this->tempatOption), 
                $dataRequest->messages()
            ),
            4 => $this->validate(
                $dataRequest->rules4(count($this->tag)), 
                $dataRequest->messages()
            ),
            5 => $this->validate(
                $dataRequest->rules5(), 
                $dataRequest->messages()
            ),
            6 => $this->validate(
                $dataRequest->rules6($this->is_private), 
                $dataRequest->messages()
            )
        };
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
    public function enterTagPenyakit()
    {
        if (!empty($this->enterTag)) {
            $this->tag[] = $this->enterTag;
            $this->enterTag = '';
        }
    }

    public function deleteTagBaru($value)
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
    
    public function storePasien() {
        $this->id_pasien = IdGenerator::generate([
            'table' => 'pasien', 
            'field' => 'id_pasien', 
            'length' => 10, 
            'prefix' => $this->k_bsni.date('ym'), 
            'reset_on_prefix_change' => true
        ]);
     
        $this->slug = SlugService::createSlug(Pasien::class, 'slug', $this->nama);

        if ($this->foto) {
            $ext = $this->foto->getClientOriginalExtension();
            $dataDiri['foto'] = $this->foto->storeAs('pasien', $this->slug . '.' . $ext);
        }

        $dataDiri = array(
            'id_pasien' => $this->id_pasien,
            'nama' => $this->nama,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'pekerjaan' => $this->pekerjaan,            
            'status_pendaftaran' => 'Pasien',
            'tanggal_pendaftaran' => $this->tanggal_pendaftaran,
            'slug' => $this->slug
        );            

        Pasien::create($dataDiri);
    }
    
    public function storeRekamMedis() {
        $this->idRM = IdGenerator::generate([
            'table' => 'rekam_medis', 
            'field' => 'id_rekam_medis', 
            'length' => 12, 'prefix' => 'RM'.date('ym').$this->k_bsni, 
            'reset_on_prefix_change' => true
        ]);
        
        $this->sistemOption = $this->sistemOption == '' ? 'Paket' : $this->sistemOption;

        $klinik = 'Jl. Meninting Raya No.18, Pagesangan Barat, Kota Mataram, Nusa Tenggara Barat';

        $dataRM = array(
            'id_rekam_medis' => $this->idRM,
            'id_pasien' => $this->id_pasien,
            'penyakit' => implode(',', $this->tag),
            'keluhan' => nl2br($this->keluhan),
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'biaya_pembayaran' => $this->biaya_pembayaran,
            'jumlah_bayar' => $this->jumlah_bayar,
            'penanggungjawab' => $this->penanggungjawab,
            'jadwal_layanan' => $this->jadwal_layanan,        
            'status_terapi' => $this->status_terapi,
            'status_pasien' => $this->status_pasien,
            'ket_status' => nl2br($this->ket_status),
            'catatan_fisik' => nl2br($this->catatan_fisik),
            'catatan_psikologis' => nl2br($this->catatan_psikologis),
            'catatan_bioplasmatik' => nl2br($this->catatan_bioplasmatik),
            'catatan_rohani' => $this->catatan_rohani,
            'data_deteksi' => nl2br($this->data_deteksi),
            'kondisi_awal' => nl2br($this->kondisi_awal),
            'target_akhir' => nl2br($this->target_akhir),
            'kesimpulan' => nl2br($this->kesimpulan),
            'link_perkembangan' => $this->link_perkembangan,
            'tanggal_registrasi' => $this->tanggal_pendaftaran,            
            'tempat_layanan' => $this->tempatOption == 'klinik' ? $klinik : $this->tempat_layanan,
            'sistem_layanan' => $this->sistem_layanan == '' ? $this->sistemOption : $this->sistem_layanan. ' ' . $this->sistemOption,
            'jumlah_layanan' => $this->jumlah_layanan == null ? 0 : $this->jumlah_layanan,
            'id_terapis' => $this->id_terapis,
            'is_private' => $this->is_private
        ); 
        
        RekamMedis::create($dataRM);
    }

    public function storeSubRekamMedis() {
        foreach ($this->tag as $penyakit) {
            $idSub = IdGenerator::generate([
                'table' => 'sub_rekam_medis', 
                'field' => 'id_sub',
                'length' => 10, 
                'prefix' => 'SP' . date('ym'),
                'reset_on_prefix_change' => true
            ]);

            $dataSub = array(
                'id_sub' => $idSub,
                'id_rekam_medis' => $this->idRM,
                'penyakit' => $penyakit
            );

            SubRekamMedis::create($dataSub);
        }
    }

    public function create() {
        
        $this->validateData();

        $this->k_bsni = $this->tempatOption == 'klinik' ? 'MTR' : $this->k_bsni;

        $this->storePasien();
        $this->storeRekamMedis();
        $this->storeSubRekamMedis();
        
        $alertMessage = empty($this->pasien) ? 'Pasien berhasil ditambahkan.' : 'Rekam Medis berhasil ditambahkan.';

        Storage::deleteDirectory('livewire-tmp');

        if(empty($this->pasien)) {
            return redirect(route('pasien.baru'))
                            ->with('success', $alertMessage)   
                            ->with('createPasien', $this->slug);   
        } else {
            return redirect()->route('rm.histori', $this->slug)->with('success', $alertMessage);       
        }     
    }
}
