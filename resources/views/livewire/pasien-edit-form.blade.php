<div>
    <div class="main-bg">
      {{-- Step header --}}
      <div class="row justify-content-between py-sm-5 custom-step custom-step-pasien">
        <div class="col text-center">
          <i class="bi {{  $currentStep == 1 ? 'bi-1-circle-fill' : ($currentStep >= 1 ? 'bi bi-check-circle-fill' : 'bi-1-circle')  }} text-success h1"></i>
          <h5 class="pt-2">Data Diri</h5>
        </div>
        <div class="col text-center">
          <i class="bi {{  $currentStep == 2 ? 'bi-2-circle-fill' : ($currentStep >= 2 ? 'bi bi-check-circle-fill' : 'bi-2-circle')  }} text-success h1"></i>
          <h5 class="pt-2">Data Penunjang</h5>
        </div>
        <div class="col text-center">
          <i class="bi {{  $currentStep == 3 ? 'bi-3-circle-fill' : ($currentStep >= 3 ? 'bi bi-check-circle-fill' : 'bi-3-circle')  }} text-success h1"></i>
          <h5 class="pt-2">Rencana Layanan</h5>
        </div>
        <div class="col text-center">
          <i class="bi {{  $currentStep == 4 ? 'bi-4-circle-fill' : ($currentStep >= 4 ? 'bi bi-check-circle-fill' : 'bi-4-circle')  }} text-success h1"></i>
          <h5 class="pt-2">Data Awal</h5>
        </div>
        <div class="col text-center">
          <i class="bi {{  $currentStep == 5 ? 'bi-5-circle-fill' : 'bi-5-circle'  }} text-success h1"></i>
          <h5 class="pt-2">Target Terapi</h5>
        </div>
      </div>
      <div class="text-center step-title mt-3 mb-4">
        @php
          $stepTitles = [
            1 => 'Data Diri',
            2 => 'Data Penunjang',
            3 => 'Rencana Layanan',
            4 => 'Data Awal',
            5 => 'Target Terapi',
          ];
        @endphp
        <h5 class="m-0">{{ $stepTitles[$currentStep] }}</h5>
      </div>
  
      {{-- form --}}
      <form wire:submit.prevent='update' class="main-form" enctype="multipart/form-data">
        @csrf
        <div class="tab-content m-0" id="nav-tabContent">
          {{-- data diri --}}
          @if($currentStep == 1)
            <div class="" id="nav-diri" aria-labelledby="nav-diri-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">                
                  <div class="mb-4">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" wire:model="nama">
                    @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="no_telp" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" wire:model="no_telp">
                    @error('no_telp')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" wire:model="jenis_kelamin" required aria-label=".form-select-sm example">
                      <option value="">Pilih Jenis Kelamin</option>
                      @foreach($jenisKelamin as $gender)
                        @if (old('jenis_kelamin') == $gender)
                          <option value="{{ $gender }}" selected>{{ $gender }}</option>
                        @else
                          <option value="{{ $gender }}">{{ $gender }}</option>
                        @endif
                      @endforeach
                    </select>
                    @error('jenis_kelamin')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
                      <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" 
                        value="{{ old('tanggal_lahir') }}" wire:model="tanggal_lahir">
                      <div class="form-text">Contoh: 9 Desember 1995 diisi 12/09/1995</div>
                        @error('tanggal_lahir')
                              <div class="invalid-feedback">
                              {{ $message }}
                              </div>
                          @enderror
                  </div>
                  
                </div>
                      
                <div class="col">
                  <div class="mb-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" wire:model="email">
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="pekerjaan" class="form-label fw-bold">Pekerjaan</label>
                      <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')" wire:model="pekerjaan">
                      @error('pekerjaan')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                      <label for="agama" class="form-label fw-bold">Agama</label>
                      <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" oninput="capEach('agama')" wire:model="agama">
                      @error('agama')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" oninput="capFirst('alamat')" wire:model="alamat">
                    @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                  
                </div>
              </div>
            </div>
          @endif
          {{-- data penunjang --}}
          @if($currentStep == 2)
            <div class="" id="nav-penunjang" aria-labelledby="nav-penunjang-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-4">
                    <label label class="form-label fw-bold w-100">Metode Pembayaran</label>
                    @foreach($tipePembayaran as $tipe)
                      @if (old('tipe_pembayaran') == $tipe['value'])
                        <div class="form-check form-check-custom">                        
                            <input class="form-check-input" type="radio" name="tipe_pembayaran" id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}" checked wire:model="tipe_pembayaran">
                            <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                        </div>
                      @else
                        <div class="form-check form-check-custom">                        
                            <input class="form-check-input" type="radio" name="tipe_pembayaran" id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}" wire:model="tipe_pembayaran">
                            <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                        </div>
                      @endif
                    @endforeach
                  </div>
                  <div class="mb-4">
                    <label for="penanggungjawab" class="form-label fw-bold">Nama Penanggungjawab</label>
                    <input type="text" class="form-control @error('penanggungjawab') is-invalid @enderror" id="penanggungjawab" name="penanggungjawab" value="{{ old('penanggungjawab') }}" oninput="capEach('penanggungjawab')" wire:model="penanggungjawab">
                    @error('penanggungjawab')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="biaya_pembayaran" class="form-label fw-bold">Biaya Pembayaran</label>
                    <input type="number" class="form-control @error('biaya_pembayaran') is-invalid @enderror" id="biaya_pembayaran" name="biaya_pembayaran" value="{{ old('biaya_pembayaran') }}" wire:model="biaya_pembayaran">
                    <div id="biayaHelp" class="form-text">Contoh: untuk Rp.1.000.000 diisi 1000000</div>
                    @error('biaya_pembayaran')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                      
                <div class="col">
                  <div class="mb-4">
                    <label for="tanggal_pendaftaran" class="form-label fw-bold">Tanggal Registrasi Pasien <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
                      <input type="date" class="form-control @error('tanggal_pendaftaran') is-invalid @enderror" id="tanggal_pendaftaran" name="tanggal_pendaftaran" 
                        value="{{ old('tanggal_pendaftaran') }}" wire:model="tanggal_pendaftaran">
                        @error('tanggal_pendaftaran')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                  </div>
                  <div class="mb-4">
                    <label for="tanggal_rm" class="form-label fw-bold">Tanggal Registrasi Rekam Medis <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_ditambahkan') is-invalid @enderror" id="tanggal_ditambahkan" name="tanggal_ditambahkan" 
                      value="{{ old('tanggal_ditambahkan') }}" wire:model="tanggal_ditambahkan">
                    @error('tanggal_ditambahkan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  
                  <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Foto</label>
                    <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" wire:model="foto">
                    
                    @if ($foto)
                      <div class="row my-3 justify-content-sm-start">
                        <p class="col-sm-auto m-0">Preview :</p>
                        <img src="{{ $foto->temporaryUrl() }}" class="img-fluid pt-2 col-sm-3 img-preview">
                        <button type="button" class="btn-close small" aria-label="Close" wire:click="deleteFoto"></button>
                      </div>
                    @elseif($dbFoto)
                      <div class="row my-3 justify-content-sm-start">
                        <p class="col-sm-auto m-0">Preview :</p>
                        <img src="{{ asset('storage/' . $dbFoto) }}" class="img-fluid pt-2 col-sm-3 img-preview">
                        <button type="button" class="btn-close small" aria-label="Close" wire:click="deleteFoto"></button>
                      </div>
                    @endif
  
                    @error('foto')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                        
                </div>              
              </div>
            </div>
          @endif
          {{-- data layanan --}}
          @if($currentStep == 3)
            {{-- rencana layanan --}}
            <div class="tabe-pane show active" id="nav-layanan" role="tabpanel" aria-labelledby="nav-layanan-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-4">
                    <label for="tempat_layanan" class="form-label fw-bold">Tempat Layanan <span class="text-danger">*</span></label>
                    <button type="button" class="form-control text-start @error('tempat_layanan') is-invalid @enderror" id="alamatBtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      {{ $tempat_layanan ? $tempat_layanan : 'Masukkan Alamat' }}
                    </button>
                    @error('tempat_layanan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  {{-- modal alamat --}}
                  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="staticBackdropLabel">Alamat Tempat Layanan</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" class="form-control" id="k_bsni" name="k_bsni" value="{{ old('k_bsni') }}" wire:model="k_bsni">
                          <div class="mb-4">
                            <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                            <select class="form-select" style="max-height: 200px; overflow-y: auto;" id="provinsi" name="provinsi">
                              <option value="">Pilih Provinsi</option>
                            </select>
                          </div>
                          <div class="mb-4">
                            <label class="form-label fw-bold">Kota/Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-select" style="max-height: 200px; overflow-y: auto;" id="kabupaten" name="kabupaten" required>
                              <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                          </div>
                          <div class="mb-4">
                            <label for="jalan" class="form-label fw-bold">Jalan/No.Gedung/Desa/Kecamatan</label>
                            <input type="text" class="form-control" id="jalan" name="jalan" value="{{ $jalan }}" oninput="capFirst('jalan')">
                          </div>                        
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                          <button type="button" class="btn btn-secondary" id="tutupBtn" data-bs-dismiss="modal">Tutup</button>
                          <button type="button" class="btn btn-success" id="simpanAlamat">Simpan</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="mb-4">
                    <label for="sistem_layanan" class="form-label fw-bold">Sistem Layanan</label>
                    <input type="text" class="form-control @error('sistem_layanan') is-invalid @enderror" id="sistem_layanan" name="sistem_layanan" value="{{ old('sistem_layanan') }}" wire:model="sistem_layanan">
                    @error('sistem_layanan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="jumlah_layanan" class="form-label fw-bold">Jumlah Layanan</label>
                    <input type="number" class="form-control @error('jumlah_layanan') is-invalid @enderror" id="jumlah_layanan" name="jumlah_layanan" value="{{ old('jumlah_layanan') }}" oninput="capFirst('jumlah_layanan')" wire:model="jumlah_layanan">
                    @error('jumlah_layanan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="jadwal_layanan" class="form-label fw-bold">Jadwal Layanan</label>
                    <input type="text" class="form-control @error('jadwal_layanan') is-invalid @enderror" id="jadwal_layanan" name="jadwal_layanan" value="{{ old('jadwal_layanan') }}" oninput="capFirst('jadwal_layanan')" wire:model="jadwal_layanan">
                    @error('jadwal_layanan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>                
                </div>
  
                <div class="col">
                  <div class="mb-4">
                    <label class="form-label fw-bold w-100">Status Terapi <span class="text-danger">*</span></label>
                    <div class="form-check form-check-custom p-0">
                      @foreach($statusTerapi as $status)
                        @if(old('status_terapi') == $status['value'])
                          <div class="form-check form-check-custom"> 
                            <input class="form-check-input" type="radio" name="status_terapi" id="{{ $status['name'] }}" value="{{ $status['value'] }}" wire:model="status_terapi" checked>
                            <label class="form-check-label" for="{{ $status['name'] }}">{{ $status['value'] }}</label>
                          </div>
                        @else
                          <div class="form-check form-check-custom">
                            <input class="form-check-input" type="radio" name="status_terapi" id="{{ $status['name'] }}" value="{{ $status['value'] }}" wire:model="status_terapi">
                            <label class="form-check-label" for="{{ $status['name'] }}">{{ $status['value'] }}</label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
  
                  <div class="mb-4">
                    <label for="ket_status" class="form-label fw-bold">Keterangan Status Terapi</label>
                    <input type="text" class="form-control @error('ket_status') is-invalid @enderror" id="ket_status" name="ket_status" value="{{ old('ket_status') }}" wire:model="ket_status">
                    @error('ket_status')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  
                  <div class="mb-4">
                    <label class="form-label fw-bold w-100">Status Pasien <span class="text-danger">*</span></label>
                    <div class="form-check form-check-custom p-0">
                      @foreach($statusPasien as $statusp)
                        @if(old('status_pasien') == $statusp['value'])
                          <div class="form-check form-check-custom">
                            <input class="form-check-input" type="radio" name="status_pasien" id="{{ $statusp['name'] }}" value="{{ $statusp['value'] }}" wire:model="status_pasien" checked>
                            <label class="form-check-label" for="{{ $statusp['name'] }}">{{ $statusp['value'] }}</label>
                          </div>
                        @else
                          <div class="form-check form-check-custom">
                            <input class="form-check-input" type="radio" name="status_pasien" id="{{ $statusp['name'] }}" value="{{ $statusp['value'] }}" wire:model="status_pasien">
                            <label class="form-check-label" for="{{ $statusp['name'] }}">{{ $statusp['value'] }}</label>
                          </div>
                        @endif
                      @endforeach
                      @error('status_pasien')
                        <div class="invalid-feedback d-block">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>
                  </div>
  
                  <div class="mb-4">
                    <label for="tanggal_selesai" class="form-label fw-bold">Tanggal Selesai <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
                      <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" 
                        value="{{ old('tanggal_selesai') }}" wire:model="tanggal_selesai">
                      <div class="form-text">Diisi hanya saat status Rekam Medis Selesai</div>
                        @error('tanggal_selesai')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                  </div>
                </div>
                </div>
            </div>
          @endif
  
          {{-- data awal --}}
          @if($currentStep == 4)
            <div class="" id="nav-awal" role="tabpanel" aria-labelledby="nav-awal-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-3 dropdown-penyakit">
                    <label for="penyakit" class="form-label fw-bold">Nama Penyakit <span class="text-danger">*</span></label>
                    @if(session()->has('duplicate'))
                      <div class="alert alert-warning alert-dismissible fade show py-1 px-2 py-lg-2 px-lg-3 hstack" role="alert" id="myAlert">
                        <span class="me-auto">{{ session('duplicate') }}</span>
                        <button type="button" class="btn p-0" data-dismiss="alert" aria-label="Close"><i class="bi bi-x-circle-fill  text-warning-emphasis"></i></button>
                      </div>
                    @endif
                    @if(!empty($dataTag[0]['db']) && !empty($dataTag[0]['current']))
                      @foreach ($dataTag as $i)
                        @php
                          $thisId = preg_replace('/\s+/', '-', $i['db']);
                        @endphp
                        <div class="d-flex mb-2 me-0 me-sm-5 me-md-0 me-xl-5">
                          <input type="text" class="form-control w-70 border rounded-0" id="{{ $thisId }}" nama="{{ $thisId }}" value="{{ $i['current'] }}" oninput="capEach('{{ $thisId }}')" disabled>
                          @if($i['db'] != '')
                            <button class="btn text-secondary border border-start-0 rounded-0" id="edit-{{ $thisId }}" type="button" data-toggle="modal" data-target="#{{ $thisId }}EditModal">
                              <i class="bi bi-pencil-square pe-1"></i>
                            </button>
                          @endif
                          <button class="btn text-secondary border border-start-0 rounded-0" id="delete-{{ $thisId }}" type="button" data-toggle="modal" data-target="#{{ $thisId }}DeleteModal"><i class="bi bi-x-circle-fill"></i></button>
  
                          <button class="btn btn-sm c-btn-primary rounded-0 ms-2 d-none" id="save-{{ $thisId }}" type="button" onclick="savePenyakit('{{ $i['db'] }}')">Simpan</button>
                          <button class="btn btn-sm c-btn-secondary rounded-0 ms-2 d-none" id="undo-{{ $thisId }}" type="button" onclick="batalEdit('{{ $i['db'] }}')">Batal</button>
                        </div>
                        <x-modal-alert 
                          id="{{ $thisId }}EditModal"
                          title="Yakin ingin edit?" 
                          :body="'<span>Mengubah nama penyakit ini akan mempengaruhi nama penyakit di <strong>rekam terapi</strong>.</span>'"
                          icon="bi bi-exclamation-circle text-warning"
                          >
                            <button class="btn btn-success px-4" type="button" onclick="editPenyakit('{{ $i['db'] }}')" data-dismiss="modal">Edit</button>
                        </x-modal-alert>
                        <!-- Terapi Delete Modal-->
                        <x-modal-alert 
                          id="{{ $thisId }}DeleteModal"
                          title="Yakin ingin hapus penyakit?"
                          :body="'<span>Semua data terkait rekam terapi untuk penyakit ini akan dihapus <strong>permanen</strong>! Hal ini termasuk semua data terapi harian.</span>'"
                          icon="bi bi-exclamation-circle text-danger"
                          >
                          <button type="button" class="btn btn-danger" wire:click="deleteTagPenyakit('{{ $i['db'] }}')" data-dismiss="modal"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                        </x-modal-alert>
                      @endforeach   
                    @endif  
                     
                    <div class="form-control d-flex flex-wrap gap-2 p-2 rounded taginput @error('penyakit') is-invalid @enderror">                    
                      @if(count($tag) > 0)
                        @foreach ($tag as $i)
                          <div class="py-1 px-2 bg-body-secondary border border-body-secondary rounded-3 tag-item">
                            <span>{{ $i }}</span>
                            <button type="button" class="btn m-0 p-0 ps-2 text-body-tertiary" wire:click="deleteTagBaru('{{ $i }}')"><i class="bi bi-x-circle-fill"></i></button>
                          </div>
                        @endforeach   
                      @endif 
                      <input 
                        type="text" 
                        class="flex-grow-1 search-input" 
                        id="tagPenyakit" 
                        name="tagPenyakit" 
                        placeholder="Tambah.." 
                        oninput="capEach('tagPenyakit')"
                        autocomplete="off">                                 
                    </div>
                    
                    <div class="dropdown-menu dropdown-dinamis p-3 pt-2 bg-body-tertiary shadow">  
                      <p class="small mb-1">Pilih Penyakit:</p> 
                      <ul class="select-options bg-white mb-0 rounded"></ul>
                    </div>
                    <div class="text-end d-sm-none">
                      <button type="button" class="btn btn-success btn-sm mt-2" id="hiddenTambahBtn">Tambah</button>
                    </div>
                    <div class="form-text d-none d-sm-block">Tekan koma "," atau Enter untuk menambah penyakit.</div>
                    @error('penyakit')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="keluhan" class="form-label fw-bold">Keluhan</label>
                    <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="2" style="text-transform: full-width-kana;" oninput="capFirst('keluhan')" wire:model="keluhan"></textarea>
                    @error('keluhan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="data_deteksi" class="form-label fw-bold">Data Deteksi</label>
                      <textarea class="form-control @error('data_deteksi') is-invalid @enderror" id="data_deteksi" name="data_deteksi" rows="2" oninput="capFirst('data_deteksi')" wire:model="data_deteksi"></textarea>
                      @error('data_deteksi')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>                  
                </div>   
                <div class="col">                
                  <div class="mb-4">
                    <label for="catatan_fisik" class="form-label fw-bold">Catatan Fisik</label>
                    <input type="text" class="form-control @error('catatan_fisik') is-invalid @enderror" id="catatan_fisik" name="catatan_fisik" value="{{ old('catatan_fisik') }}" oninput="capFirst('catatan_fisik')" wire:model="catatan_fisik">
                    @error('catatan_fisik')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="catatan_bioplasmatik" class="form-label fw-bold">Catatan Bioplasmatik</label>
                    <input type="text" class="form-control @error('catatan_bioplasmatik') is-invalid @enderror" id="catatan_bioplasmatik" name="catatan_bioplasmatik" value="{{ old('catatan_bioplasmatik') }}" oninput="capFirst('catatan_bioplasmatik')" wire:model="catatan_bioplasmatik">
                    @error('catatan_bioplasmatik')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="catatan_psikologis" class="form-label fw-bold">Catatan Psikologis</label>
                      <input type="text" class="form-control @error('catatan_psikologis') is-invalid @enderror" id="catatan_psikologis" name="catatan_psikologis" value="{{ old('catatan_psikologis') }}" oninput="capFirst('catatan_psikologis')" wire:model="catatan_psikologis">
                      @error('catatan_psikologis')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                    <label for="catatan_rohani" class="form-label fw-bold">Catatan Rohani</label>
                    <input type="text" class="form-control @error('catatan_rohani') is-invalid @enderror" id="catatan_rohani" name="catatan_rohani" value="{{ old('catatan_rohani') }}" oninput="capFirst('catatan_rohani')" wire:model="catatan_rohani">
                    @error('catatan_rohani')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>            
              </div>
            </div>
          @endif
  
          {{-- data target --}}
          @if($currentStep == 5)
            <div class="" id="" role="tabpanel" aria-labelledby="nav-awal-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-4">
                    <label for="kondisi_awal" class="form-label fw-bold">Kondisi Awal</label>
                    <textarea class="form-control @error('kondisi_awal') is-invalid @enderror" id="kondisi_awal" name="kondisi_awal" rows="3" style="text-transform: full-width-kana;" oninput="capFirst('kondisi_awal')" wire:model="kondisi_awal"></textarea>
                    @error('kondisi_awal')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="target_akhir" class="form-label fw-bold">Target Akhir</label>
                      <textarea class="form-control @error('target_akhir') is-invalid @enderror" id="target_akhir" name="target_akhir" rows="3" oninput="capFirst('target_akhir')" wire:model="target_akhir"></textarea>
                      @error('target_akhir')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                  </div>                  
                </div>    
                <div class="col">
                  <div class="mb-4">
                    <label for="link_perkembangan" class="form-label fw-bold">Link Perkembangan Target</label>
                    <input type="text" class="form-control @error('link_perkembangan') is-invalid @enderror" id="link_perkembangan" name="link_perkembangan" rows="3" oninput="capFirst('link_perkembangan')" wire:model="link_perkembangan">
                    @error('link_perkembangan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                  <div class="mb-4">
                    <label for="kesimpulan" class="form-label fw-bold">Kesimpulan Akhir</label>
                    <textarea class="form-control @error('kesimpulan') is-invalid @enderror" id="kesimpulan" name="kesimpulan" rows="5" style="text-transform: full-width-kana;" oninput="capFirst('kesimpulan')" wire:model="kesimpulan"></textarea>
                    @error('kesimpulan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                                    
                </div>                 
              </div>
            </div>
          @endif
  
          {{-- button step --}}
          @if($rm == null) 
            <div class="d-flex justify-content-between my-4 mx-3 mb-md-5 mx-md-5 form-navigation">
              <a href="" class="btn btn-outline-danger py-1 px-2 py-sm-2 px-sm-3" data-toggle="modal" data-target="#pasienDeleteModal">
                <span class="d-none d-sm-block"><i class="bi bi-exclamation-triangle pe-2"></i>Hapus Pasien</span>
                <span class="d-block d-sm-none"><i class="bi bi-exclamation-triangle"></i> Hapus</span>
              </a>
              <div class="div">
          @else
            <div class="my-4 mx-3 mb-md-5 mx-md-5 form-navigation">
              <div class="d-flex justify-content-between">
          @endif

              @if($currentStep == 1)
                <div></div>           
              @endif
    
              @if($currentStep >= 2 && $currentStep <= 5)
                <button class="btn btn-secondary py-1 px-2 px-sm-3 py-sm-2" type="button" onclick="toTop()" wire:click="toPrev()">
                  <span class="{{ $rm == null ? 'd-none d-md-block' : '' }}">Sebelumnya</span>
                  <span class="{{ $rm == null ? 'd-block d-md-none' : 'd-none' }}"><i class="bi bi-caret-left"></i> Prev</span>
                </button>            
              @endif
              
              @if($currentStep >= 1 && $currentStep <= 4)     
                <button class="btn c-btn-success py-1 px-2 py-sm-2 px-sm-3 ms-2 ms-md-3" type="button" onclick="toTop()" wire:click="toNext()">
                  <span class="{{ $rm == null ? 'd-none d-md-block' : '' }}">Lanjut</span>
                  <span class="{{ $rm == null ? 'd-block d-md-none' : 'd-none' }}">Next <i class="bi bi-caret-right"></i></span>
                </button>
              @endif
    
              @if($currentStep == 5)
                <button type="submit" class="btn btn-success px-3 px-md-4 py-md-2" onclick="toTop()">Kirim</button>
              @endif
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

@section('modal-alert')  
   <!-- Pasien Delete Modal--> 
   <x-modal-alert 
      id="pasienDeleteModal"
      title="Yakin ingin hapus Pasien?"
      :body="'<span>Semua data terkait pasien ini akan dihapus <strong>permanen</strong>! 
         <br>Hal ini termasuk semua data rekam medis, terapi, jadwal, dll.</span>'"
      icon="bi bi-exclamation-circle text-danger"
      >
      <form action="{{ route('pasien.delete', $slug) }}" method="post">
         @method('delete')
         @csrf
         <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
      </form>
   </x-modal-alert>
@endsection

@push('script')
  <script>
    const target = document.querySelector(".main-bg");
    function toTop() {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start"
      });
    }

    function capEach(inputId) {
      var input = document.getElementById(inputId);
        let words = input.value.split(' ');

        for (let i = 0; i < words.length; i++) {
            if (words[i].length > 0) {
                words[i] = words[i][0].toUpperCase() + words[i].substring(1);
            }
        }

        input.value = words.join(' ');
    } 

    function capFirst(inputId) {
      var input = document.getElementById(inputId);
      var word = input.value;
  
      if (word.length > 0) {
        var capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
        input.value = capitalizedWord;
      }
    } 

    function editPenyakit(dbValue) {
      const id = dbValue.replace(/\s+/g, '-');
      
      document.querySelector(`#${id}`).removeAttribute('disabled');
      document.querySelector(`#edit-${id}`).classList.add('d-none');
      document.querySelector(`#delete-${id}`).classList.add('d-none');
      document.querySelector(`#save-${id}`).classList.remove('d-none');
      document.querySelector(`#undo-${id}`).classList.remove('d-none');
    }

    function updateExistPenyakit(dbValue, inputValue) {
      let data = { dbValue: dbValue, inputValue: inputValue };
      Livewire.emit('editExistPenyakit', data);
    };

    function savePenyakit(dbValue) {
      const id = dbValue.replace(/\s+/g, '-');

      const inputValue = document.querySelector(`#${id}`).value;

      if(dbValue != inputValue) {
        updateExistPenyakit(dbValue, inputValue);  
      }    
      
      closeSave(id);
    }

    function batalEdit(dbValue) {
      const id = dbValue.replace(/\s+/g, '-');
      document.querySelector(`#${id}`).value = dbValue;
      closeSave(id);
    }

    function closeSave(id) {
      document.querySelector(`#${id}`).setAttribute('disabled');
      document.querySelector(`#edit-${id}`).classList.remove('d-none');
      document.querySelector(`#delete-${id}`).classList.remove('d-none');
      document.querySelector(`#save-${id}`).classList.add('d-none');
      document.querySelector(`#undo-${id}`).classList.add('d-none');
    }

    function addTagToController(newTag) {
      Livewire.emit('addTagPenyakit', newTag);
      document.querySelector(".search-input").value = "";
    };

    function setAlamatToController(tempat, kode, provId, jalan, provinsi, kabupaten) {
      Livewire.emit('setAlamatKode', { tempat: tempat, kode: kode, provId: provId, jalan: jalan, provinsi: provinsi, kabupaten: kabupaten });
    };


    document.addEventListener('livewire:load', function () {
    
      Livewire.on('runScriptPenyakit', function () {
        let dataPenyakit = @json($listPenyakit);

        const dropPenyakit = document.querySelector(".dropdown-penyakit");
        let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
        let optionsPenyakit = dropPenyakit.querySelector(".select-options");
        let dropdown = dropPenyakit.querySelector(".dropdown-dinamis");
        let tambahBtn = dropPenyakit.querySelector("#hiddenTambahBtn");

        function addPenyakit() {
          optionsPenyakit.innerHTML = "";
          dataPenyakit.forEach(penyakit => {
                let li = `
                          <li class="dropdown-item" 
                              data-nama="${penyakit}" 
                              onclick="addTagToController('${penyakit}')">
                              ${penyakit}                            
                          </li>
                        `;
                optionsPenyakit.insertAdjacentHTML("beforeend", li);
          });
        }

        searchInpPenyakit.addEventListener('keyup', function(event) {
          const value = searchInpPenyakit.value;
          dropdown.style.display = 'block';

          let arr = [];
          let searchWords = searchInpPenyakit.value.toLowerCase().split(' ');
          arr = dataPenyakit.filter(penyakit => {
              let data = penyakit.toLowerCase();
              return searchWords.every(word => data.includes(word));
          }).map(penyakit => {
              return `<button type="button" class="dropdown-item px-2" 
                          data-nama="${penyakit}"
                          onclick="addTagToController('${penyakit}')">
                          ${penyakit}                            
                      </button>
                      `;
          }).join("");

          if(arr) {
            optionsPenyakit.innerHTML = arr;
          } else {
            dropdown.style.display = 'none';
          }

          if (event.key === "Enter" || (event.key === "," && value.endsWith(","))) {
            if(value != "") {
              const trimmedValue = value.replace(/,$/, '');
              addTagToController(trimmedValue);

              searchInpPenyakit.value = "";
            }
          } 
        });

        tambahBtn.addEventListener("click", function() {
          addTagToController(searchInpPenyakit.value);
          searchInpPenyakit.value = "";
        });

        searchInpPenyakit.addEventListener("focus", function() {
          addPenyakit();
          dropdown.style.display = 'block';
        });

        document.addEventListener('click', function(event) {
          if (!searchInpPenyakit.contains(event.target)) {
            dropdown.style.display = 'none';
          }
        });
      });  

      Livewire.on('runScriptAlamat', kab_prov => {
        const provinsiSelect = document.querySelector("#provinsi");
        const kabupatenSelect = document.querySelector("#kabupaten");
        const jalanInput = document.querySelector("#jalan");
        const saveAlamat = document.querySelector("#simpanAlamat");
        const k_bsni = document.querySelector("#k_bsni");
        const alamatButton = document.querySelector("#alamatBtn");
        const closeButton = document.querySelector("#tutupBtn");

        function populateKabupaten(provinsiId) {
          kabupatenSelect.innerHTML = '';
          kabupatenSelect.innerHTML = `<option value="">Pilih Kabupaten</option>`;

          fetch('/database/kota-kabupaten.json')
            .then(response => response.json())
            .then(data => {
                const kabupatenData = data.filter(kabupaten => kabupaten.provinsi_id === provinsiId);
                kabupatenData.forEach(kabupaten => {
                  kabupatenSelect.innerHTML += `
                    <option value="${kabupaten.kabupaten_kota}" data-kode="${kabupaten.k_bsni}" ${kabupaten.kabupaten_kota === kab_prov.kabupaten ? 'selected' : ''}>${kabupaten.kabupaten_kota}</option>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching JSON data:', error);
            });
        }

        function populateProvinsi() {

          fetch('/database/provinsi.json')
            .then(response => response.json())
            .then(data => {
                data.forEach(provinsi => {
                  if(provinsi.provinsi === kab_prov.provinsi) {
                    provinsiSelect.innerHTML += `
                      <option value="${provinsi.provinsi}" data-id="${provinsi.id}" selected>${provinsi.provinsi}</option>
                      `;
                      provinsiSelect.setAttribute("data-id", provinsi.id);
                  } else {
                    provinsiSelect.innerHTML += `
                      <option value="${provinsi.provinsi}" data-id="${provinsi.id}">${provinsi.provinsi}</option>
                      `;
                  }
                });
            })
            .catch(error => {
                console.error('Error fetching JSON data:', error);
            });
        }

        alamatButton.addEventListener('click', function() {

          populateProvinsi();

          setTimeout(function() {
            if(kab_prov.provId != null) {
              populateKabupaten(kab_prov.provId);
            } else {
              const provId = parseInt(provinsiSelect.getAttribute("data-id"));
              populateKabupaten(provId);
            }
          }, 1000);
          
        });

        provinsiSelect.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const selectedProvinsiId = selectedOption.getAttribute("data-id");
          provinsiSelect.setAttribute("data-id", selectedProvinsiId);

          populateKabupaten(parseInt(selectedProvinsiId));
        });

        kabupatenSelect.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const selected = selectedOption.value;
          k_bsni.value = selected;
        });

        saveAlamat.addEventListener('click', function() {
          provinsiSelect.classList.remove("is-invalid");
          kabupatenSelect.classList.remove("is-invalid");

          if(provinsiSelect.value == "") {
            provinsiSelect.classList.add("is-invalid");
          }

          else if(kabupatenSelect.value == "") {
            kabupatenSelect.classList.add("is-invalid");
          } else {
            let alamat = kabupatenSelect.value + ', ' + provinsiSelect.value;
            const kode = kabupatenSelect.options[kabupatenSelect.selectedIndex].getAttribute("data-kode");
            const provId = parseInt(provinsiSelect.getAttribute("data-id"));

            if(jalanInput.value != "") {
              alamat = jalanInput.value + ', ' + kabupatenSelect.value + ', ' + provinsiSelect.value; 
            } 
    
            alamatButton.textContent = alamat; 
            
            setAlamatToController(alamat, kode, provId, jalanInput.value, provinsiSelect.value, kabupatenSelect.value);
            closeButton.click();
          }

        });
      });

    });

  </script>
@endpush