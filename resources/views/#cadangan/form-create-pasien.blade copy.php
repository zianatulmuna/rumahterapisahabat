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
    <form wire:submit.prevent='create' class="main-form" id="createForm" enctype="multipart/form-data">
      @csrf
      <div class="tab-content m-0" id="nav-tabContent">
        {{-- data diri --}}
        @if($currentStep == 4)
          <div class="" id="nav-diri" aria-labelledby="nav-diri-tab" tabindex="0">
            <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
              <div class="col">                
                <div class="mb-3">
                  <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" @if($id_pasien) disabled @endif wire:model="nama">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="no_telp" class="form-label fw-semibold">Nomor Telepon</label>
                  <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" @if($id_pasien) disabled @endif wire:model="no_telp">
                  @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold">Jenis Kelamin</label>
                  <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" @if($id_pasien) disabled @endif @if($id_pasien) disabled @endif wire:model="jenis_kelamin" required aria-label=".form-select-sm example">
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
                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir [Bulan/Tanggal/Tahun]</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" 
                      value="{{ old('tanggal_lahir') }}" @if($id_pasien) disabled @endif wire:model="tanggal_lahir">
                    <div class="form-text">Contoh: 9 Desember 1995 diisi 12/09/1995</div>
                      @error('tanggal_lahir')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                </div>
              </div>
                    
              <div class="col">
                <div class="mb-3">
                  <label for="email" class="form-label fw-semibold">Email</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" @if($id_pasien) disabled @endif wire:model="email">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')" @if($id_pasien) disabled @endif wire:model="pekerjaan">
                    @error('pekerjaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="agama" class="form-label fw-semibold">Agama</label>
                    <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" oninput="capEach('agama')" @if($id_pasien) disabled @endif wire:model="agama">
                    @error('agama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" oninput="capFirst('alamat')" @if($id_pasien) disabled @endif wire:model="alamat">
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
        @if($currentStep == 1)
          <div class="" id="nav-penunjang" aria-labelledby="nav-penunjang-tab" tabindex="0">
            <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
              <div class="col">
                <div class="mb-4">
                  <label label class="form-label fw-semibold w-100">Metode Pembayaran</label>
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
                <div class="mb-3">
                  <label for="penanggungjawab" class="form-label fw-semibold">Nama Penanggungjawab</label>
                  <input type="text" class="form-control @error('penanggungjawab') is-invalid @enderror" id="penanggungjawab" name="penanggungjawab" value="{{ old('penanggungjawab') }}" oninput="capEach('penanggungjawab')" wire:model="penanggungjawab">
                  @error('penanggungjawab')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="biaya_pembayaran" class="form-label fw-semibold">Biaya Pembayaran</label>
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
                <div class="mb-3">
                  <label for="foto" class="form-label fw-semibold">Foto</label>
                  <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" wire:model="foto" @if($id_pasien) disabled @endif>
                  @if ($foto)
                  <div class="row my-3 justify-content-sm-start fotoPreview">
                    <p class="col-sm-auto m-0">Preview :</p>
                    <img src="{{ $foto->temporaryUrl() }}" class="img-fluid pt-2 col-sm-5 img-preview">
                    <button type="button" class="btn-close small" aria-label="Close" onclick="deleteFoto()" wire:click="deleteFoto"></button>
                  </div>
                  @endif
                  @error('foto')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>    
                {{-- <div class="mb-3">
                  <label for="link_rm" class="form-label fw-semibold">Link Rekam Medis</label>
                  <input type="url" class="form-control @error('link_rm') is-invalid @enderror" id="link_rm" name="link_rm" value="{{ old('link_rm') }}" wire:model="link_rm">
                  @error('link_rm')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>  --}}
                <div class="mb-3">
                  <label for="tanggal_pendaftaran" class="form-label fw-semibold">Tanggal Pendaftaran [Bulan/Tanggal/Tahun]</label>
                    <input type="date" class="form-control @error('tanggal_pendaftaran') is-invalid @enderror" id="tanggal_pendaftaran" name="tanggal_pendaftaran" 
                      value="{{ old('tanggal_pendaftaran') }}" wire:model="tanggal_pendaftaran" @if($id_pasien) disabled @endif>
                    <div class="form-text">Contoh: 9 Desember 2023 diisi 12/09/2023</div>
                      @error('tanggal_pendaftaran')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                </div>     
              </div>              
            </div>
          </div>
        @endif

        @if($currentStep == 3)
          {{-- rencana layanan --}}
          <div class="tabe-pane show active" id="nav-layanan" role="tabpanel" aria-labelledby="nav-layanan-tab" tabindex="0">
            <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
              <div class="col">
                <div class="mb-3">
                  <label for="tempat_layanan" class="form-label fw-semibold">Tempat Layanan</label>
                  <input type="text" class="form-control @error('tempat_layanan') is-invalid @enderror" id="tempat_layanan" name="tempat_layanan" value="{{ old('tempat_layanan') }}" oninput="capFirst('tempat_layanan')" wire:model="tempat_layanan">
                  @error('tempat_layanan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="jadwal_layanan" class="form-label fw-semibold">Jadwal Layanan</label>
                  <input type="text" class="form-control @error('jadwal_layanan') is-invalid @enderror" id="jadwal_layanan" name="jadwal_layanan" value="{{ old('jadwal_layanan') }}" oninput="capFirst('jadwal_layanan')" wire:model="jadwal_layanan">
                  @error('jadwal_layanan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="sistem_layanan" class="form-label fw-semibold">Sistem Layanan</label>
                  <input type="text" class="form-control @error('sistem_layanan') is-invalid @enderror" id="sistem_layanan" name="sistem_layanan" value="{{ old('sistem_layanan') }}" wire:model="sistem_layanan">
                  @error('sistem_layanan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="jumlah_layanan" class="form-label fw-semibold">Jumlah Layanan</label>
                  <input type="number" class="form-control @error('jumlah_layanan') is-invalid @enderror" id="jumlah_layanan" name="jumlah_layanan" value="{{ old('jumlah_layanan') }}" oninput="capFirst('jumlah_layanan')" wire:model="jumlah_layanan">
                  @error('jumlah_layanan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                
              </div>
              
              <div class="col">
                <div class="mb-4">
                  <label class="form-label fw-semibold w-100">Status Terapi</label>
                  <div class="form-check p-0">
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

                <div class="mb-3">
                  <label for="ket_status" class="form-label fw-semibold">Keterangan Status Terapi</label>
                  <input type="text" class="form-control @error('ket_status') is-invalid @enderror" id="ket_status" name="ket_status" value="{{ old('ket_status') }}" wire:model="ket_status">
                  @error('ket_status')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                
                <div class="mb-4">
                  <label class="form-label fw-semibold w-100">Status Pasien</label>
                  <div class="form-check p-0">
                    @foreach($statusPasien as $statusp)
                      @if(old('status_pasien') == $statusp['value'])
                        <div class="form-check form-check-custom">
                          <input class="form-check-input sp-input" type="radio" name="status_pasien" id="{{ $statusp['name'] }}" value="{{ $statusp['value'] }}" wire:model="status_pasien" checked>
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
                <div class="mb-3">
                  <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai [Bulan/Tanggal/Tahun]</label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" 
                      value="{{ old('tanggal_selesai') }}">
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
        @if($currentStep == 2)
          <div class="" id="nav-awal" role="tabpanel" aria-labelledby="nav-awal-tab" tabindex="0">
            <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
              <div class="col">
                {{-- penyakit --}}
                {{-- <div class="mb-3"> 
                  <label for="penyakit" class="form-label fw-semibold">Nama Penyakit</label>                     
                  <div class="dropdown w-100 dropdown-penyakit">
                      <input type="text" class="form-control search-input" placeholder="Cari penyakit">

                      <div class="dropdown-menu dropdown-dinamis ps-2 px-sm-3 w-100 shadow">
                          
                          <ul class="select-options"></ul>
                      </div>
                  </div>
                </div> --}}
                <div class="mb-3 dropdown-penyakit">
                  <label for="penyakit" class="form-label fw-semibold">Nama Penyakit</label>
                  <div class="form-control d-flex flex-wrap gap-2 p-2 rounded taginput @error('penyakit') is-invalid @enderror">                    
                    @if(count($tag) > 0)
                      @foreach ($tag as $i)
                        <div class="px-2 bg-body-secondary border border-body-secondary rounded-3 tag-item">
                          {{ $i }}
                          <button type="button" class="btn m-0 p-0 text-secondary" wire:click="deleteTagPenyakit('{{ $i }}')"><i class="bi bi-x-circle-fill"></i></button>
                        </div>
                      @endforeach   
                    @endif   
                    <input 
                      type="text" 
                      class="flex-grow-1 @error('penyakit') is-invalid @enderror data-rm search-input" 
                      id="tagPenyakit" 
                      name="tagPenyakit" 
                      placeholder="Tambah.." 
                      oninput="capEach('tagPenyakit')"
                      >                                 
                  </div>
                  <div class="dropdown-menu dropdown-dinamis ps-2 px-sm-3 shadow">   
                    <ul class="select-options"></ul>
                  </div>
                  <div class="form-text">Tekan koma "," atau Enter untuk menambah penyakit.</div>
                  @error('penyakit')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- <div class="mb-3 dropdown-penyakit">
                  <label for="penyakit" class="form-label fw-semibold">Nama Penyakit</label>
                  <div class="form-control d-flex flex-wrap gap-2 p-2 rounded taginput @error('penyakit') is-invalid @enderror">                    
                    @if(count($tag) > 0)
                      @foreach ($tag as $i)
                        <div class="px-2 bg-body-secondary border border-body-secondary rounded-3 tag-item">
                          {{ $i }}
                          <button type="button" class="btn m-0 p-0 text-secondary" wire:click="deleteTagPenyakit('{{ $i }}')"><i class="bi bi-x-circle-fill"></i></button>
                        </div>
                      @endforeach   
                    @endif   
                    <input 
                      type="text" 
                      class="flex-grow-1 @error('penyakit') is-invalid @enderror data-rm" 
                      id="tagPenyakit" 
                      name="tagPenyakit" 
                      placeholder="Tambah.." 
                      oninput="capEach('tagPenyakit')"
                      wire:model.debounce.500ms="newTag"
                      wire:keydown.enter="enterTagPenyakit"
                      >                                 
                  </div>
                  <div class="form-text">Tekan koma "," atau Enter untuk menambah penyakit.</div>
                  @error('penyakit')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div> --}}
                <div class="mb-3">
                  <label for="keluhan" class="form-label fw-semibold">Keluhan</label>
                  <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="3" style="text-transform: full-width-kana;" oninput="capFirst('keluhan')" wire:model="keluhan"></textarea>
                  @error('keluhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="data_deteksi" class="form-label fw-semibold">Data Deteksi</label>
                    <textarea class="form-control @error('data_deteksi') is-invalid @enderror" id="data_deteksi" name="data_deteksi" rows="3" oninput="capFirst('data_deteksi')" wire:model="data_deteksi"></textarea>
                    @error('data_deteksi')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>                  
              </div> 
              <div class="col">
                <div class="mb-3">
                  <label for="catatan_fisik" class="form-label fw-semibold">Catatan Fisik</label>
                  <input type="text" class="form-control @error('catatan_fisik') is-invalid @enderror" id="catatan_fisik" name="catatan_fisik" value="{{ old('catatan_fisik') }}" oninput="capFirst('catatan_fisik')" wire:model="catatan_fisik">
                  @error('catatan_fisik')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="catatan_bioplasmatik" class="form-label fw-semibold">Catatan Bioplasmatik</label>
                  <input type="text" class="form-control @error('catatan_bioplasmatik') is-invalid @enderror" id="catatan_bioplasmatik" name="catatan_bioplasmatik" value="{{ old('catatan_bioplasmatik') }}" oninput="capFirst('catatan_bioplasmatik')" wire:model="catatan_bioplasmatik">
                  @error('catatan_bioplasmatik')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="catatan_psikologis" class="form-label fw-semibold">Catatan Psikologis</label>
                    <input type="text" class="form-control @error('catatan_psikologis') is-invalid @enderror" id="catatan_psikologis" name="catatan_psikologis" value="{{ old('catatan_psikologis') }}" oninput="capFirst('catatan_psikologis')" wire:model="catatan_psikologis">
                    @error('catatan_psikologis')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="catatan_rohani" class="form-label fw-semibold">Catatan Rohani</label>
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
                <div class="mb-3">
                  <label for="kondisi_awal" class="form-label fw-semibold">Kondisi Awal</label>
                  <textarea class="form-control @error('kondisi_awal') is-invalid @enderror" id="kondisi_awal" name="kondisi_awal" rows="3" style="text-transform: full-width-kana;" oninput="capFirst('kondisi_awal')" wire:model="kondisi_awal"></textarea>
                  @error('kondisi_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="target_akhir" class="form-label fw-semibold">Target Akhir</label>
                    <textarea class="form-control @error('target_akhir') is-invalid @enderror" id="target_akhir" name="target_akhir" rows="3" oninput="capFirst('target_akhir')" wire:model="target_akhir"></textarea>
                    @error('target_akhir')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>                  
              </div>    
              <div class="col">
                <div class="mb-3">
                  <label for="link_perkembangan" class="form-label fw-semibold">Link Perkembangan Target</label>
                  <input type="text" class="form-control @error('link_perkembangan') is-invalid @enderror" id="link_perkembangan" name="link_perkembangan" rows="3" oninput="capFirst('link_perkembangan')" wire:model="link_perkembangan">
                  @error('link_perkembangan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
              </div>
                <div class="mb-3">
                  <label for="kondisi_awal" class="form-label fw-semibold">Kesimpulan Akhir</label>
                  <textarea class="form-control @error('kondisi_awal') is-invalid @enderror" id="kondisi_awal" name="kondisi_awal" rows="5" style="text-transform: full-width-kana;" oninput="capFirst('kondisi_awal')" wire:model="kondisi_awal"></textarea>
                  @error('kondisi_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                                  
              </div>                 
            </div>
          </div>
        @endif
        
        {{-- button step --}}
        <div class="d-flex justify-content-between my-5 mx-3 mb-md-5 mx-md-5 form-navigation">
          @if($currentStep == 1)
            <div></div>           
          @endif

          @if($currentStep >= 2 && $currentStep <= 5)
            <button class="btn btn-secondary" type="button" onclick="toTop()" wire:click="toPrev()">Sebelumnya</button>            
          @endif
          
          @if($currentStep >= 1 && $currentStep <= 4)     
            <button class="btn c-btn-success px-3 px-md-4 py-md-2" type="button" onclick="toTop()" wire:click="toNext()">Lanjut</button>
          @endif

          @if($currentStep == 5)
            <button type="submit" class="btn btn-success px-3 px-md-4 py-md-2" onclick="toTop()">Kirim</button>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>

@push('script')
{{-- script penyakit --}}
{{-- <script>    
  let dataPenyakit = @json($listPenyakit);

  const dropPenyakit = document.querySelector(".dropdown-penyakit");
  // let selectBtnPenyakit = dropPenyakit.querySelector("button");
  let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
  let optionsPenyakit = dropPenyakit.querySelector(".select-options");
  let dropdown = dropPenyakit.querySelector(".dropdown-dinamis");

  // function setPenyakitToController(selectedLi) {
  //     let nama = selectedLi.getAttribute('data-nama');
  //     Livewire.emit('setPenyakit', nama);
  // };

  // addPenyakit();

  function addPenyakit(selectedPenyakit) {
      optionsPenyakit.innerHTML = "";
      dataPenyakit.forEach(penyakit => {
          let isSelected = penyakit == selectedPenyakit ? "active" : "";
              let li = `
                          <li class="dropdown-item ${isSelected}" 
                              data-nama="${penyakit}" 
                              onclick="setPenyakitToController(this)">
                              ${penyakit}                            
                          </li>
                      `;
              optionsPenyakit.insertAdjacentHTML("beforeend", li);
      });
  }

  searchInpPenyakit.addEventListener("keyup", () => {
      let arr = [];
      let searchWords = searchInpPenyakit.value.toLowerCase().split(' ');
      arr = dataPenyakit.filter(penyakit => {
          let data = penyakit.toLowerCase();
          return searchWords.every(word => data.includes(word));
      }).map(penyakit => {
          // let isSelected = penyakit == selectBtnPenyakit.firstElementChild.innerText ? "active" : "";
          return `<li class="dropdown-item" 
                      data-nama="${penyakit}">
                      ${penyakit}                            
                  </li>
                  `;
      }).join("");

      if(arr) {
        optionsPenyakit.innerHTML = arr;
      } else {
        dropdown.style.display = 'none';
      }
      // optionsPenyakit.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
  });

  // selectBtnPenyakit.addEventListener("click", () => dropPenyakit.classList.toggle("active"));
  searchInpPenyakit.addEventListener("focus", function() {
    dropdown.style.display = 'block';
  });

  searchInpPenyakit.addEventListener("blur", function() {
    dropdown.style.display = 'none';
  });

</script> --}}

<script>
  const target = document.querySelector(".main-bg");
  
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

  function toTop() {
    target.scrollIntoView({
      behavior: "smooth",
      block: "start"
    });
  }

  // function upPenyakit(selectedLi) {
  //   const dropPenyakit = document.querySelector(".dropdown-penyakit");
  //       // let selectBtnPenyakit = dropPenyakit.querySelector("button");
  //       let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
  //   searchInpPenyakit.value = selectedLi.getAttribute('data-nama');
  // }
  function addTagToController(newTag) {
    Livewire.emit('addTagPenyakit', newTag);
  };

  document.addEventListener('livewire:load', function () {
    
    Livewire.on('runScriptPenyakit', function () {
        const inputField = document.getElementById('tagPenyakit');

        // function addTagToController(newTag) {
        //   Livewire.emit('addTagPenyakit', newTag);
        // };

        // inputField.addEventListener('keyup', function(event) {
        //   if (event.key === ",") {
        //     const value = inputField.value;
        //     const trimmedValue = value.slice(0, -1);

        //     addTagToController(trimmedValue);

        //     inputField.value = "";
        //   }
        // });
        let dataPenyakit = @json($listPenyakit);

        const dropPenyakit = document.querySelector(".dropdown-penyakit");
        // let selectBtnPenyakit = dropPenyakit.querySelector("button");
        let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
        let optionsPenyakit = dropPenyakit.querySelector(".select-options");
        let dropdown = dropPenyakit.querySelector(".dropdown-dinamis");

        // function setPenyakitToController(selectedLi) {
        //     let nama = selectedLi.getAttribute('data-nama');
        //     Livewire.emit('setPenyakit', nama);
        // };

        // addPenyakit();
        searchInpPenyakit.addEventListener('keyup', function(event) {
          const value = searchInpPenyakit.value;

          if (event.key === "Enter" || (event.key === "," && value.endsWith(","))) {
              const trimmedValue = value.replace(/,$/, '');
              addTagToController(trimmedValue);

              searchInpPenyakit.value = "";
          }
      });

        // searchInpPenyakit.addEventListener('keyup', function(event) {
        //   if (event.key === ",") {
        //     const value = searchInpPenyakit.value;
        //     const trimmedValue = value.slice(0, -1);

        //     addTagToController(trimmedValue);

        //     searchInpPenyakit.value = "";
        //   }
        //   if (event.key === "Enter") {
        //     const value = searchInpPenyakit.value;
        //     addTagToController(value);

        //     searchInpPenyakit.value = "";
        //   }
        // });

        // function addPenyakit(selectedPenyakit) {
        //     optionsPenyakit.innerHTML = "";
        //     dataPenyakit.forEach(penyakit => {
        //         let isSelected = penyakit == selectedPenyakit ? "active" : "";
        //             let li = `
        //                         <li class="dropdown-item ${isSelected}" 
        //                             data-nama="${penyakit}" 
        //                             onclick="setPenyakitToController(this)">
        //                             ${penyakit}                            
        //                         </li>
        //                     `;
        //             optionsPenyakit.insertAdjacentHTML("beforeend", li);
        //     });
        // }

        

        searchInpPenyakit.addEventListener("keyup", () => {
            dropdown.style.display = 'block';
            let arr = [];
            let searchWords = searchInpPenyakit.value.toLowerCase().split(' ');
            arr = dataPenyakit.filter(penyakit => {
                let data = penyakit.toLowerCase();
                return searchWords.every(word => data.includes(word));
            }).map(penyakit => {
                return `<button type="button" class="dropdown-item" 
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
        });

        // selectBtnPenyakit.addEventListener("click", () => dropPenyakit.classList.toggle("active"));
        searchInpPenyakit.addEventListener("focus", function() {
          dropdown.style.display = 'block';
        });

        // searchInpPenyakit.addEventListener("blur", function() {
        //   dropdown.style.display = 'none';
        // });

        document.addEventListener('click', function(event) {
          if (!searchInpPenyakit.contains(event.target)) {
            dropdown.style.display = 'none';
          }
        });
    });  
    
  });
</script>
@endpush