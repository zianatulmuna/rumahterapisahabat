<?php

namespace App\Http\Livewire;

use App\Http\Requests\RekamMedisRequest;
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
    public $tipe_pembayaran, $penanggungjawab, $biaya_pembayaran, $link_rm, $foto, $tanggal_pendaftaran, $tanggal_registrasi, $jumlah_bayar; 
    public $tempat_layanan, $jadwal_layanan, $sistem_layanan, $jumlah_layanan, $status_pasien, $status_terapi, $ket_status, $tanggal_selesai;
    public $penyakit, $keluhan, $catatan_psikologis, $catatan_bioplasmatik, $catatan_rohani, $catatan_fisik, $data_deteksi;
    public $kondisi_awal, $target_akhir, $link_perkembangan, $kesimpulan;

    public $k_bsni, $provId, $jalan, $provinsi, $kabupaten;
    public $pasien, $id_pasien, $slug, $dbNama, $dbFoto, $pathFoto, $sistemOption, $idRM;



    public $totalStep = 5, $currentStep = 1;

    public $tag = [], $newTag;

    protected $listeners = ['addTagPenyakit', 'setAlamatKode'];
    protected $rules = [
        'nama' => 'required|max:50',
        'email' => 'nullable|email|max:50',
        'alamat' => 'max:150',
        'no_telp' => 'required|min_digits:8|max_digits:14',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'required',
        'agama' => 'max:20',
        'pekerjaan' => 'max:35',
        'foto' => 'nullable|file|image|max:1024',
        'biaya_pembayaran' => 'max:100',
        'jumlah_bayar' => 'nullable|numeric|max:3',
        'penanggungjawab' => 'max:50',
        'tanggal_pendaftaran' => 'required|date', 
        // 'tempat_layanan' => 'max:50',
        'jadwal_layanan' => 'max:50',
        'sistem_layanan' => 'max:50',
        'jumlah_layanan' => 'max:50',
        // 'status_pasien' => 'required',
        'status_terapi' => 'required',
        'keluhan' => 'max:100',
        'catatan_fisik' => 'max:100',
        'catatan_psikologis' => 'max:100',
        'catatan_bioplasmatik' => 'max:100',
        'catatan_rohani' => 'max:100',
        'data_deteksi' => 'max:100',
        'link_perkembangan' => 'nullable|url|max:100',
        'kondisi_awal' => 'max:100',
        'target_akhir' => 'max:100',
        'kesimpulan' => 'max:100',
    ];

    protected $messages = [
        'required' => 'Kolom :attribute harus diisi.',
        'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
        'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
        'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
        'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',
        'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
        'numeric' => 'Kolom :attribute harus diisi angka.',
        'url' => 'Kolom :attribute harus berupa link URL valid',
        'file' => 'Kolom :attribute harus diisi file.',
        'image' => 'Kolom :attribute harus diisi file gambar.',
        'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
        'status_pasien.unique' => 'Masih ada Rekam Medis dengan status Rawat Jalan.'
    ];

    public function mount($pasien){
        $this->currentStep;
        $this->tag;
        $this->tempat_layanan;
        $this->sistemOption;

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
            'listPenyakit' => $listPenyakit
            
        ]);
    }

    public function updatedRules()
    {
        $rmActiveDetected = RekamMedis::where('id_pasien', $this->id_pasien)->where('status_pasien', 'Rawat Jalan')->count();

        $rules['tanggal_registrasi'] = !empty($this->id_pasien) ? 'required' : '';
        $rules['tempat_layanan'] = empty($this->tempat_layanan) ? 'required|max:50' : 'max:50';
        $rules['status_pasien'] = $rmActiveDetected > 1 ? 'required|unique' : 'required';
        $rules['tanggal_selesai'] = $this->status_pasien == 'Selesai' || $this->status_pasien == 'Jeda' > 1 ? 'required' : '';
        $rules['penyakit'] = count($this->tag) == 0 > 1 ? 'required' : ''; 
    }

    public function toNext() {
        $this->resetErrorBag();

        $customRequest = new RekamMedisRequest($this->id_pasien, $this->tempat_layanan, $this->status_pasien, $this->tag);

        $this->validate(
            $customRequest->rules(), 
            $customRequest->messages(), 
        );

        
        // $this->updatedRules();
        // $this->validate();
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

    protected function getRules()
    {
        $rules = [
            'nama' => 'required|max:50',
            'email' => 'nullable|email|max:50',
            'alamat' => 'max:150',
            'no_telp' => 'required|min_digits:8|max_digits:14',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required',
            'agama' => 'max:20',
            'pekerjaan' => 'max:35',
            'foto' => 'nullable|file|image|max:1024',
            'biaya_pembayaran' => 'max:100',
            'jumlah_bayar' => 'nullable|numeric|max:3',
            'penanggungjawab' => 'max:50',
            'tanggal_pendaftaran' => 'required|date', 
            // 'tanggal_registrasi' => [
            //     Rule::requiredIf(!empty($this->id_pasien))
            // ], 
            'tempat_layanan' => 'max:50',
                // Rule::requiredIf($this->tempat_layanan == "")
            // ],
            'jadwal_layanan' => 'max:50',
            'sistem_layanan' => 'max:50',
            'jumlah_layanan' => 'max:50',
            'status_pasien' => [
                'required',
                // Rule::unique('rekam_medis')->where(function ($query) {
                //     $query->where('id_pasien', $this->id_pasien)->where('status_pasien', 'Rawat Jalan');
                // }),
            ],
            'status_terapi' => 'required',
            // 'tanggal_selesai' => [
            //     Rule::requiredIf($this->status_pasien == 'Selesai' || $this->status_pasien == 'Jeda')
            // ],
            // 'penyakit' => [
            //     'required_if:tag,0',
            //     Rule::requiredIf(count($this->tag) == 0),
            // ],
            'keluhan' => 'max:100',
            'catatan_fisik' => 'max:100',
            'catatan_psikologis' => 'max:100',
            'catatan_bioplasmatik' => 'max:100',
            'catatan_rohani' => 'max:100',
            'data_deteksi' => 'max:100',
            'link_perkembangan' => 'nullable|url|max:100',
            'kondisi_awal' => 'max:100',
            'target_akhir' => 'max:100',
            'kesimpulan' => 'max:100',
        ];
        
        $rmActiveDetected = RekamMedis::where('id_pasien', $this->id_pasien)->where('status_pasien', 'Rawat Jalan')->count();

        $rules['tanggal_registrasi'] = !empty($this->id_pasien) ? 'required' : '';
        $rules['tempat_layanan'] = empty($this->tempat_layanan) ? 'required' : '';
        $rules['status_pasien'] = $rmActiveDetected > 1 ? 'unique' : '';
        $rules['tanggal_selesai'] = $this->status_pasien == 'Selesai' || $this->status_pasien == 'Jeda' > 1 ? 'required' : '';
        $rules['penyakit'] = count($this->tag) == 0 > 1 ? 'required' : '';

        return $rules;
    }

    public function validateData(){
        // $message = [
        //     'required' => 'Kolom :attribute harus diisi.',
        //     'max' => 'Kolom :attribute harus diisi maksimal :max karakter.',
        //     'foto.max' => 'Kolom :attribute harus diisi maksimal :max kb.',
        //     'min' => 'Kolom :attribute harus diisi minimal :min karakter.',
        //     'min_digits' => 'Kolom :attribute harus diisi minimal :min digit angka.',
        //     'max_digits' => 'Kolom :attribute harus diisi minimal :max digit angka.',
        //     'numeric' => 'Kolom :attribute harus diisi angka.',
        //     'url' => 'Kolom :attribute harus berupa link URL valid',
        //     'file' => 'Kolom :attribute harus diisi file.',
        //     'image' => 'Kolom :attribute harus diisi file gambar.',
        //     'date' => 'Data yang dimasukkan harus berupa tanggal dengan format Bulan/Tanggal/Tahun.',
        //     'status_pasien.unique' => 'Masih ada Rekam Medis dengan status Rawat Jalan.'
        // ];

        if($this->currentStep == 1){
            if(empty($this->id_pasien)) {
                $this->validate([
                    'nama' => 'required|max:50',
                    'email' => 'nullable|email|max:50',
                    'alamat' => 'max:150',
                    'no_telp' => 'required|min_digits:8|max_digits:14',
                    'tanggal_lahir' => 'nullable|date',
                    'jenis_kelamin' => 'required',
                    'agama' => 'max:20',
                    'pekerjaan' => 'max:35'
                ]);
            }
        }elseif($this->currentStep == 2){
            $this->validate([                
                'biaya_pembayaran' => 'max:100',
                'jumlah_bayar' => 'nullable|numeric|max:3',
                'penanggungjawab' => 'max:50',
                'foto' => 'nullable|file|image|max:1024',
                'link_rm' => 'nullable|url|max:100',
                'tanggal_pendaftaran' => 'required|date', 
                'tanggal_registrasi' => [
                    Rule::requiredIf(!empty($this->id_pasien))
                ],                
            ]);
            
        }elseif($this->currentStep == 3){
            $this->validate([
                'tempat_layanan' => [
                    'max:50',
                    Rule::requiredIf($this->tempat_layanan == "")
                ],
                'jadwal_layanan' => 'max:50',
                'sistem_layanan' => 'max:50',
                'jumlah_layanan' => 'max:50',
                'status_pasien' => [
                    'required',
                    Rule::unique('rekam_medis')->where(function ($query) {
                        $query->where('id_pasien', $this->id_pasien)->where('status_pasien', 'Rawat Jalan');
                    }),
                ],
                'status_terapi' => 'required',
                'tanggal_selesai' => [
                    Rule::requiredIf($this->status_pasien == 'Selesai' || $this->status_pasien == 'Jeda')
                ]
            ]);
        }elseif($this->currentStep == 4){
            $this->validate([
                'penyakit' => [
                    'required_if:tag,0',
                    Rule::requiredIf(count($this->tag) == 0),
                ],
                'keluhan' => 'max:100',
                'catatan_fisik' => 'max:100',
                'catatan_psikologis' => 'max:100',
                'catatan_bioplasmatik' => 'max:100',
                'catatan_rohani' => 'max:100',
                'data_deteksi' => 'max:100',
            ]);    
        }else{
            $this->validate([
                'link_perkembangan' => 'nullable|url|max:100',
                'kondisi_awal' => 'max:100',
                'target_akhir' => 'max:100',
                'kesimpulan' => 'max:100',
            ]);
        }
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
            'tanggal_pendaftaran' => $this->tanggal_pendaftaran . ' ' . date('H:i:s'),
            'slug' => $this->slug
        );            

        $pasienIsStored = Pasien::create($dataDiri);

        return $pasienIsStored;
    }
    
    public function storeRekamMedis() {
        $dataRM = array(
            'penyakit' => $this->penyakit,
            'keluhan' => nl2br($this->keluhan),
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'biaya_pembayaran' => $this->biaya_pembayaran,
            'jumlah_bayar' => $this->jumlah_bayar,
            'penanggungjawab' => $this->penanggungjawab,
            'tempat_layanan' => $this->tempat_layanan,
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
            'tanggal_registrasi' => $this->tanggal_registrasi,
        );              

        $this->idRM = IdGenerator::generate(['table' => 'rekam_medis', 'field' => 'id_rekam_medis', 'length' => 12, 'prefix' => 'RM'.date('ym').$this->k_bsni, 'reset_on_prefix_change' => true]);
        
        $this->sistemOption = $this->sistemOption == '' ? 'Paket' : $this->sistemOption;

        $penyakit = implode(',', $this->tag);
        $dataRM['id_rekam_medis'] = $this->idRM;
        $dataRM['id_pasien'] = $this->id_pasien;
        $dataRM['penyakit'] = $penyakit;     
        $dataRM['sistem_layanan'] = $this->sistem_layanan == '' ? $this->sistemOption : $this->sistem_layanan. ' ' . $this->sistemOption; 
        $this->tanggal_registrasi = $this->tanggal_pendaftaran . ' ' . date('H:i:s');
            
        if($this->jumlah_layanan) {
            $dataRM['jumlah_layanan'] = $this->jumlah_layanan;
        }   
        
        $rmIsStored = RekamMedis::create($dataRM);

        return $rmIsStored;
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

            $dataSub['id_sub'] = $idSub;
            $dataSub['id_rekam_medis'] = $this->idRM;
            $dataSub['penyakit'] = $penyakit;

            $subIsStored = SubRekamMedis::create($dataSub);

            return $subIsStored;
        }
    }

    public function create(Request $request) {
        
        $this->validateData();

        if(empty($this->id_pasien)) {
            $pasienIsStored = $this->storePasien();
        }

        if($pasienIsStored) {
            $rmIsStored = $this->storeRekamMedis();
        } else {
            $alertMessage = 'Data Pasien gagal ditambahkan! Silahkan coba lagi.';
        }

        if($rmIsStored) {
            $subIsStored = $this->storeSubRekamMedis();
        } else {
            $alertMessage = 'Data Rekam Medis gagal ditambahkan!';
        }

        if($subIsStored) {
            $alertMessage = empty($this->pasien) ? 'Pasien berhasil ditambahkan. ' : 'Rekam Medis berhasil ditambahkan.';
        } else {
            $alertMessage = 'Data Sub Penyakit gagal ditambahkan!';
        }

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
