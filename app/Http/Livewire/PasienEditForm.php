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

class PasienEditForm extends Component
{
    use WithFileUploads;

    public $nama, $no_telp, $jenis_kelamin, $email, $tanggal_lahir, $pekerjaan, $agama, $alamat;
    public $tipe_pembayaran, $penanggungjawab, $biaya_pembayaran, $link_rm, $foto, $tanggal_pendaftaran, $tanggal_ditambahkan; 
    public $tempat_layanan, $jadwal_layanan, $sistem_layanan, $jumlah_layanan, $status_pasien, $status_terapi, $ket_status, $tanggal_selesai;

    public $k_bsni, $provId, $jalan, $provinsi, $kabupaten;

    public $penyakit, $keluhan, $catatan_psikologis, $catatan_bioplasmatik, $catatan_rohani, $catatan_fisik, $data_deteksi;
    public $kondisi_awal, $target_akhir, $link_perkembangan, $kesimpulan;

    public $totalStep = 5, $currentStep = 1;

    public $pasien, $rm, $id_pasien, $id_rekam_medis, $slug, $dbNama, $dbFoto, $pathFoto, $dbTahun_pendaftaran, $dbTanggal_ditambahkan, $id_rm_baru;

    public $tag = [], $dataTag = [], $newTag, $dbPenyakit, $stringPenyakit, $deletedTag = [], $checkDuplikat = false;

    protected $listeners = ['addTagPenyakit', 'editExistPenyakit', 'setAlamatKode'];

    public function mount($pasien, $rm){
        $this->id_pasien = $pasien->id_pasien;
        $this->nama = $pasien->nama;
        $this->dbNama = $pasien->nama;
        $this->no_telp = $pasien->no_telp;
        $this->jenis_kelamin = $pasien->jenis_kelamin;
        $this->tanggal_lahir = $pasien->tanggal_lahir;
        $this->tanggal_pendaftaran = Carbon::parse($pasien->tanggal_pendaftaran)->format('Y-m-d');
        $this->dbTahun_pendaftaran = Carbon::parse($pasien->tanggal_pendaftaran)->format('Y');
        $this->email = $pasien->email;
        $this->pekerjaan = $pasien->pekerjaan;
        $this->agama = $pasien->agama;
        $this->alamat = $pasien->alamat;
        $this->dbFoto = $pasien->foto;
        $this->pathFoto = $pasien->foto;
        $this->slug = $pasien->slug;
        $this->tag;

        $this->rm = $rm;

        if($rm) {
            $this->id_rekam_medis = $rm->id_rekam_medis;
            $this->keluhan = $rm->keluhan;
            // $this->link_rm = $rm->link_rm;
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
            $this->kondisi_awal = $rm->kondisi_awal;
            $this->target_akhir = $rm->target_akhir;
            $this->kesimpulan = $rm->kesimpulan;
            $this->link_perkembangan = $rm->link_perkembangan;
            $this->tanggal_selesai = $rm->tanggal_selesai;
            $this->tanggal_ditambahkan = $rm->tanggal_ditambahkan;
            $this->dbTanggal_ditambahkan = $rm->tanggal_ditambahkan;
            $this->id_rm_baru = $rm->id_rekam_medis;

            $this->currentStep = 1;

            $alamatParts = explode(', ', $this->tempat_layanan);
            $this->provinsi = $alamatParts[count($alamatParts)-1];
            $this->kabupaten = $alamatParts[count($alamatParts)-2];

            $potonganAlamat = array_slice($alamatParts, 0, -2);
            $this->jalan = implode(', ', $potonganAlamat);            

            $this->stringPenyakit = $rm->penyakit;
            $this->dbPenyakit = explode(",", $rm->penyakit);

            for ($i = 0; $i < count($this->dbPenyakit); $i++) {   
                $this->dataTag[] = ['current' => $this->dbPenyakit[$i], 'db' => $this->dbPenyakit[$i]];
            }

            $this->deletedTag;
        }        
    }
    public function render()
    {
        $listPenyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');

        return view('livewire.pasien-edit-form', [
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
        $this->dbFoto = null; //menghapus foto yang ada dari db
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
                'email' => 'nullable|max:35',
                'alamat' => 'max:100',
                'no_telp' => 'required|min_digits:10',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'required',
                'agama' => 'max:20',
                'pekerjaan' => 'max:30',
            ], $message);
        }elseif($this->currentStep == 2){
            $this->validate([                
                'biaya_pembayaran' => 'max:20',
                'penanggungjawab' => 'max:50',
                'link_rm' => 'nullable|url|max:100',
                'foto' => 'nullable|file|image|max:1024',
                'tanggal_pendaftaran' => 'required|date',                
                'tanggal_ditambahkan' => [
                    Rule::requiredIf(empty($this->id_rekam_medis))
                ],                
            ], $message);
            
        }elseif($this->currentStep == 3){
            $this->validate([
                'tempat_layanan' => [
                    'max:100',
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
            $tagPenyakit = 1;
            if(empty($this->dataTag[0]['db']) && empty($this->dataTag[0]['current'])) {
                if(count($this->tag) == 0) {
                    $tagPenyakit = 0;
                }
            }
            $this->validate([
                'penyakit' => [
                    'required_if:tagPenyakit,0',
                    Rule::requiredIf($tagPenyakit == 0),
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
            'pekerjaan' => $this->pekerjaan,            
            'tanggal_pendaftaran' => $this->tanggal_pendaftaran,
        );        

        $dataRM = array(
            // 'penyakit' => $this->penyakit,
            'keluhan' => $this->keluhan,
            // 'link_rm' => $this->link_rm,
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
            'kondisi_awal' => $this->kondisi_awal,
            'target_akhir' => $this->target_akhir,
            'kesimpulan' => $this->kesimpulan,
            'link_perkembangan' => $this->link_perkembangan,
            'tanggal_ditambahkan' => $this->tanggal_ditambahkan,
        );

        $dateYForIdPasien = Carbon::parse($this->tanggal_pendaftaran)->format('Y');

        if($dateYForIdPasien != $this->dbTahun_pendaftaran) {
            $dateYPasien = substr($dateYForIdPasien, 2);
            $dataDiri['id_pasien'] = IdGenerator::generate(['table' => 'pasien', 'field' => 'id_pasien', 'length' => 8, 'prefix' => 'P'.$dateYPasien, 'reset_on_prefix_change' => true]);
        }

        if($this->nama != $this->dbNama) {
            $this->slug = SlugService::createSlug(Pasien::class, 'slug', $this->nama);
            $dataDiri['slug'] = $this->slug;
        }

        if ($this->foto) {
            //jika foto ada dari db tapi tidak tekan delete
            if ($this->pathFoto) {
                // Storage::delete($this->dbFoto);
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
        // if ($this->pathFoto && $this->dbFoto == null && $this->foto == null) {
        //     $dataDiri['foto'] = '';
        //     Storage::delete($this->pathFoto);
        // }

        if($this->rm) {   
            $idRM = $this->id_rekam_medis;
            $this->k_bsni = $this->provId ? $this->k_bsni : substr($this->id_rekam_medis, 0, 3);
            
            // $this->k_bsni = substr($this->id_rekam_medis, 0, 3);
            
            $date = substr($this->id_rekam_medis, 3, 4);
            $isTanggalRMChanged = $isPenyakitChanged = false;
            $updatePenyakit = [];

            // cek tanggal RM berubah
            if(substr($this->tanggal_ditambahkan, 0, 7) != substr($this->dbTanggal_ditambahkan, 0, 7)) {
                $dateM = Carbon::parse($this->tanggal_ditambahkan)->format('m');
                $dateY = substr(Carbon::parse($this->tanggal_ditambahkan)->format('Y'), 2);
                $date = $dateY.$dateM;
                $isTanggalRMChanged = true;
            }

            // jika penyakit tidak kosong
            if($this->stringPenyakit !== "") {
                $currentArrayPenyakit = array_column($this->dataTag, 'current');
                $tagUpdate = implode(',', $currentArrayPenyakit);

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
                    $updatePenyakit = $currentArrayPenyakit;
                }
                
            }
            // jika tag ditambahkan
            if(!empty($this->tag)){
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
                $updatePenyakit = array_merge($updatePenyakit, $this->tag);
            } 

            if(!empty($this->tag) || $isPenyakitChanged) {
                $dataRM['penyakit'] = implode(',', $updatePenyakit);
            }

            // ubah id
            if($this->provId || $isTanggalRMChanged) {
                $idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 10, 'prefix' => $this->k_bsni . $date, 'reset_on_prefix_change' => true]);
                
                $dataRM['id_rekam_medis'] = $idRM;

                if($isTanggalRMChanged) {
                    for ($i = 0; $i < count($this->dataTag); $i++) {    
                        $current = $this->dataTag[$i]['current'];
                        $idSub = IdGenerator::generate([
                            'table' => 'sub_rekam_medis', 
                            'field' => 'id_sub',
                            'length' => 10, 
                            'prefix' => 'SP' . $date,
                            'reset_on_prefix_change' => true
                        ]);
    
                        $dataId['id_sub'] = $idSub;

                        SubRekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->where('penyakit', $current)->update($dataId);
                    }
                }
            }

            RekamMedis::where('id_rekam_medis', $this->id_rekam_medis)->update($dataRM);
        } else {           
            $dateM = Carbon::parse($this->tanggal_pendaftaran)->format('m');
            $dateY = substr(Carbon::parse($this->tanggal_pendaftaran)->format('Y'), 2);            
            
            $idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 10, 'prefix' => $this->k_bsni . $dateY.$dateM, 'reset_on_prefix_change' => true]);

            $dataRM['id_rekam_medis'] = $idRM;
            $dataRM['id_pasien'] = $this->id_pasien;
            $dataRM['penyakit'] = implode(',', $this->tag);
            $dataDiri['status_pendaftaran'] = 'Pasien Lama';

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
        }

        Pasien::where('id_pasien', $this->id_pasien)->update($dataDiri);

        $path = $this->slug;

        $rmCheck = $this->rm ? true : false;
        
        $this->reset();
        $this->currentStep = 1;
        Storage::deleteDirectory('livewire-tmp');

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
