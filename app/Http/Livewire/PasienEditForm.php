<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Terapis;
use Livewire\Component;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Models\SubRekamMedis;
use Livewire\WithFileUploads;
use App\Http\Requests\PasienRequest;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PasienEditForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $email, $tanggal_lahir, $pekerjaan, $agama, $alamat;
    public $foto, $tanggal_pendaftaran, $tanggal_registrasi, $tipe_pembayaran, $penanggungjawab, $biaya_pembayaran, $jumlah_bayar; 
    public $tempat_layanan, $jadwal_layanan, $sistem_layanan, $jumlah_layanan, $status_pasien, $status_terapi, $ket_status, $tanggal_selesai;
    public $penyakit, $keluhan, $catatan_psikologis, $catatan_bioplasmatik, $catatan_rohani,            $catatan_fisik, $data_deteksi;
    public $kondisi_awal, $target_akhir, $link_perkembangan, $kesimpulan;
    public $is_private = 0, $id_terapis;

    public $k_bsni, $provId, $jalan, $provinsi, $kabupaten;


    public $totalStep = 6, $currentStep = 1;

    public $pasien, $rm, $id_pasien, $id_rekam_medis, $slug, $dbNama, $dbFoto, $pathFoto, $dbTahun_pendaftaran, $dbTanggal_ditambahkan, $id_rm_baru, $isPasienLama, $sistemOption, $tempatOption, $updatePenyakit, $dataRM, $idPasienBaru;

    public $tag = [], $dataTag = [], $newTag, $dbPenyakit, $stringPenyakit, $deletedTag = [], $checkDuplikat = false;

    public $klinik = 'Jl. Meninting Raya No.18, Pagesangan Barat, Kota Mataram, Nusa Tenggara Barat';

    protected $listeners = ['addTagPenyakit', 'editExistPenyakit', 'setAlamatKode'];

    public function mount($pasien, $rm){
        // variabel data pasien
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
        
        // variabel pembantu
        $this->dbNama = $pasien->nama;
        $this->dbTahun_pendaftaran = Carbon::parse($pasien->tanggal_pendaftaran)->format('Y');
        $this->dbFoto = $pasien->foto;
        $this->pathFoto = $pasien->foto;
        $this->tag;
        $this->currentStep = 1;
        
        $this->isPasienLama = $pasien->status_pendaftaran == "Pasien" ? true : false;
        
        // variabel data rekam medis
        $this->id_rekam_medis = $rm->id_rekam_medis;
        $this->keluhan = str_replace('<br />', '', $rm->keluhan);
        $this->penanggungjawab = $rm->penanggungjawab;
        $this->tipe_pembayaran = $rm->tipe_pembayaran;        
        $this->tanggal_registrasi = $rm->tanggal_registrasi;

        if($this->isPasienLama) {
            // variabel data rekam medis
            $this->biaya_pembayaran = $rm->biaya_pembayaran;
            $this->jumlah_bayar = $rm->jumlah_bayar;
            $this->tempat_layanan = $rm->tempat_layanan;
            $this->jumlah_layanan = $rm->jumlah_layanan;
            $this->jadwal_layanan = $rm->jadwal_layanan;
            $this->status_terapi = $rm->status_terapi;
            $this->status_pasien = $rm->status_pasien;
            $this->catatan_fisik = str_replace('<br />', '', $rm->catatan_fisik);
            $this->catatan_psikologis = str_replace('<br />', '', $rm->catatan_psikologis);
            $this->catatan_bioplasmatik = str_replace('<br />', '', $rm->catatan_bioplasmatik);
            $this->catatan_rohani = str_replace('<br />', '', $rm->catatan_rohani);
            $this->data_deteksi = str_replace('<br />', '', $rm->data_deteksi);
            $this->kondisi_awal = str_replace('<br />', '', $rm->kondisi_awal);
            $this->target_akhir = str_replace('<br />', '', $rm->target_akhir);
            $this->kesimpulan = str_replace('<br />', '', $rm->kesimpulan);
            $this->link_perkembangan = $rm->link_perkembangan;
            $this->tanggal_selesai = $rm->tanggal_selesai;

            // variabel pembantu
            $this->dbTanggal_ditambahkan = $rm->tanggal_registrasi;            
            $this->sistemOption;
            $this->tempatOption = $this->tempat_layanan == $this->klinik ? 'klinik' : 'lainnya';

            // varibael sistem layanan
            $sistemParts = explode(' ', $rm->sistem_layanan);
            $this->sistemOption = $sistemParts[count($sistemParts)-1];

            $potonganSistem = array_slice($sistemParts, 0, -1);
            $this->sistem_layanan = implode(' ', $potonganSistem); 

            // variabel alamat
            $alamatParts = explode(', ', $this->tempat_layanan);
            $this->provinsi = $alamatParts[count($alamatParts)-1];
            $this->kabupaten = $alamatParts[count($alamatParts)-2];

            $potonganAlamat = array_slice($alamatParts, 0, -2);
            $this->jalan = implode(', ', $potonganAlamat);            

            // variabel penyakit
            $this->deletedTag;
            $this->stringPenyakit = $rm->penyakit;
            $this->dbPenyakit = explode(",", $rm->penyakit);

            for ($i = 0; $i < count($this->dbPenyakit); $i++) {   
                $this->dataTag[] = ['current' => $this->dbPenyakit[$i], 'db' => $this->dbPenyakit[$i]];
            }
        }        
    }
    public function render()
    {
        $listPenyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');
        $listTerapis = Terapis::orderBy('nama', 'ASC')->get();

        return view('livewire.pasien-edit-form', [
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

        if($this->currentStep == 4) {
            $tagPenyakit = 1;
            if(empty($this->dataTag[0]['db']) && empty($this->dataTag[0]['current'])) {
                if(count($this->tag) == 0) {
                    $tagPenyakit = 0;
                }
            }
        }
        
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
                $dataRequest->rules3($this->id_pasien,$this->id_rekam_medis,$this->tempat_layanan,$this->status_pasien, $this->tempatOption), 
                $dataRequest->messages()
            ),
            4 => $this->validate(
                $dataRequest->rules4($tagPenyakit), 
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
        if($this->currentStep == 4) {
            $this->emit('runScriptPenyakit');
        }
        if($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function deleteFoto() {
        $this->foto = null;        
        $this->dbFoto = null;
    }

    public function checkDuplicateTag($value) {
        $newValue = strtolower(str_replace([',', '+', '-', ' '], '', $value));
        
        $this->checkDuplikat = false;

        for ($i = 0; $i < count($this->dataTag); $i++) {
            $dbValue = strtolower(str_replace([',', '+', '-'], '', $this->dataTag[$i]['db']));
            $currentDbValue = strtolower(str_replace([',', '+', '-'], '', $this->dataTag[$i]['current']));

            if($newValue == $dbValue || $newValue == $currentDbValue ) {
                $this->checkDuplikat = true;
                break;
            }             
        }

        if(count($this->tag) > 0) {
            for ($i = 0; $i < count($this->tag); $i++) {
                $tagValue = $this->tag[$i] ? 
                            strtolower(str_replace([',', '+', '-', ' '], '', $this->tag[$i])) :
                            '';
                if($newValue == $tagValue ) {
                    $this->checkDuplikat = true;
                    break;
                }             
            }
        }

        if ($this->checkDuplikat) {
            $this->emit('runScriptPenyakit');
            return redirect()->back()->with('duplicate', $value. ' sudah ada.');
        }
    }

    public function addTagPenyakit($value)
    {
        $this->checkDuplicateTag($value);
        
        if (!$this->checkDuplikat) {
            $this->tag[] = $value;
        } 
             
    }

    public function editExistPenyakit($data) {
        $dbValue = $data['dbValue'];
        $currentValue = $data['inputValue'];
        
        $this->checkDuplicateTag($currentValue);

        if (!$this->checkDuplikat) {
            $index = array_search($dbValue, array_column($this->dataTag, 'db'));
            $this->dataTag[$index]['current'] = $currentValue;
        }
    }

    public function deleteTagPenyakit($value)
    {
        $index = array_search($value, array_column($this->dataTag, 'db'));

        if ($index !== false) {
            array_splice($this->dataTag, $index, 1);
            $this->deletedTag[] = $value;
            $this->emit('runScriptPenyakit');
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

    public function updatePasien() {
        $dataDiri = array(
            'nama' => $this->nama,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'agama' => $this->agama,
            'pekerjaan' => $this->pekerjaan,     
            'status_pendaftaran' => 'Pasien'
        );

        if(!$this->isPasienLama) {         
            $kode = $this->tempatOption == 'klinik' ? 'MTR' : $this->k_bsni;   
            $this->idPasienBaru = IdGenerator::generate([
                'table' => 'pasien', 
                'field' => 'id_pasien', 
                'length' => 10, 
                'prefix' => $kode.date('ym'), 
                'reset_on_prefix_change' => true
            ]);
            $dataDiri['id_pasien'] = $this->idPasienBaru;
        }

        if($this->nama != $this->dbNama) {
            $this->slug = SlugService::createSlug(Pasien::class, 'slug', $this->nama);
            $dataDiri['slug'] = $this->slug;
        }

        if ($this->foto) {
            //jika foto ada dari db tapi tidak tekan delete
            if ($this->pathFoto) {
                Storage::delete($this->pathFoto);
            } 
            $ext = $this->foto->getClientOriginalExtension();
            $dataDiri['foto'] = $this->foto->storeAs('pasien', $this->slug . '.' . $ext);
        } 
        
        //jika foto ada && dihapus && tidak diganti
        if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
            $dataDiri['foto'] = null;
            Storage::delete($this->pathFoto);
        }

        Pasien::where('id_pasien', $this->id_pasien)->update($dataDiri);
    }
    
    public function updateRekamMedis() {
        $this->sistemOption = $this->sistemOption == '' ? 'Paket' : $this->sistemOption;

        $klinik = 'Jl. Meninting Raya No.18, Pagesangan Barat, Kota Mataram, Nusa Tenggara Barat';

        $this->dataRM = array(
            // 'penyakit' => $this->penyakit,
            'keluhan' => nl2br($this->keluhan),
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'biaya_pembayaran' => $this->biaya_pembayaran,
            'jumlah_bayar' => $this->jumlah_bayar,
            'penanggungjawab' => $this->penanggungjawab,
            'jadwal_layanan' => $this->jadwal_layanan,        
            'status_terapi' => nl2br($this->status_terapi),
            'status_pasien' => nl2br($this->status_pasien),
            'catatan_fisik' => nl2br($this->catatan_fisik),
            'catatan_psikologis' => nl2br($this->catatan_psikologis),
            'catatan_bioplasmatik' => nl2br($this->catatan_bioplasmatik),
            'catatan_rohani' => $this->catatan_rohani,
            'data_deteksi' => nl2br($this->data_deteksi),
            'kondisi_awal' => nl2br($this->kondisi_awal),
            'target_akhir' => nl2br($this->target_akhir),
            'kesimpulan' => nl2br($this->kesimpulan),
            'link_perkembangan' => $this->link_perkembangan,      
            'tempat_layanan' => $this->tempatOption == 'klinik' ? $klinik : $this->tempat_layanan,
            'sistem_layanan' => $this->sistem_layanan == '' ? $this->sistemOption : $this->sistem_layanan. ' ' . $this->sistemOption,
            'jumlah_layanan' => $this->jumlah_layanan,
            'id_terapis' => $this->id_terapis,
            'is_private' => $this->is_private
        );

        if($this->isPasienLama) {   
            $this->dataRM['penyakit'] = $this->updateSubRekamMedis();
            RekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->update($this->dataRM);
        } else {
            $this->updatePraRekamMedis();
        }
    }

    public function updatePraRekamMedis() {
        $kode = $this->tempatOption == 'klinik' ? 'MTR' : $this->k_bsni; 
        $idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 12, 'prefix' => 'RM'.date('ym').$kode, 'reset_on_prefix_change' => true]);

        $this->dataRM['id_rekam_medis'] = $idRM;
        $this->dataRM['id_pasien'] = $this->idPasienBaru;
        $this->dataRM['penyakit'] = implode(',', $this->tag);

        $rmStored = RekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->update($this->dataRM);

        if($rmStored) {
            $this->storeSubRekamMedis($idRM);
        }
    }

    public function updateSubRekamMedis() {
        $isPenyakitChanged = false;
        $this->updatePenyakit = $this->dbPenyakit;

        // jika penyakit tidak kosong
        if($this->stringPenyakit !== "") {
            $currentArrayPenyakit = array_column($this->dataTag, 'current');
            $tagUpdate = implode(',', $currentArrayPenyakit);
            $dataRMSubPenyakit = $this->stringPenyakit;

            //jika susunan string penyakit beda
            if($tagUpdate != implode(',', $this->dbPenyakit)) { 
                //jika ada yang dihapus
                if(count($this->deletedTag) > 0) { 
                    foreach ($this->deletedTag as $tag) {
                        SubRekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->where('penyakit', $tag)->delete();                           
                    }
                } 
                for ($i = 0; $i < count($this->dataTag); $i++) {    
                    $current = $this->dataTag[$i]['current'];
                    $db = $this->dataTag[$i]['db'];
                    // jika ada yang diedit
                    if($current != $db){
                        $dataPenyakit['penyakit'] = $current;
                        
                        SubRekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->where('penyakit', $db)->update($dataPenyakit);
                    }
                }
                $isPenyakitChanged = true;
                $this->updatePenyakit = $currentArrayPenyakit;
            }

            // jika tag ditambahkan
            if(!empty($this->tag)){
                $this->storeSubRekamMedis($this->id_rekam_medis);
            } 

            // jika penyakit dihapus dari rekam terapi
            if(!empty($this->tag) || $isPenyakitChanged) {
                $dataRMSubPenyakit = implode(',', $this->updatePenyakit);
            }
            
        } else {
            $dataRMSubPenyakit = implode(',', $this->tag);
            $this->storeSubRekamMedis($this->id_rekam_medis);
        }
        return $dataRMSubPenyakit;
    }

    public function storeSubRekamMedis($idRM) {
        $date = substr($idRM, 3, 4);

        foreach ($this->tag as $newTag) {
            $idSub = IdGenerator::generate([
                'table' => 'sub_rekam_medis', 
                'field' => 'id_sub',
                'length' => 10, 
                'prefix' => 'SP' . $date,
                'reset_on_prefix_change' => true
            ]);

            $dataSub['id_sub'] = $idSub;
            $dataSub['id_rekam_medis'] = $idRM;
            $dataSub['penyakit'] = $newTag;

            SubRekamMedis::create($dataSub);
        }
        if($this->isPasienLama) {
            $this->updatePenyakit = array_merge($this->updatePenyakit, $this->tag);
        }
    }

    public function update(Pasien $pasien) {
        $this->validateData();     
        
        $this->updatePasien();
        $this->updateRekamMedis();

        // $this->reset();
        Storage::deleteDirectory('livewire-tmp');

        if($this->isPasienLama) {
            return redirect(route('pasien.rm', $this->slug))
                            ->with('success', 'Rekam Medis Pasien berhasil diupdate.')   
                            ->with('update', true);   
        } else {
            return redirect(route('pasien.baru'))
                            ->with('success', 'Pasien berhasil ditambahkan ke data Pasien Lama.')   
                            ->with('createPasien', $this->slug);     
        }
    }
}
