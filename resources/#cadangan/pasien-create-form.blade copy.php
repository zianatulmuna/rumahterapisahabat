<div>
    <div class="main-bg">
      {{-- Step header --}}
      @include('partials.form-pasien-step-header')

      {{-- form --}}
      <form wire:submit.prevent='create' class="main-form" id="createForm" enctype="multipart/form-data">
        @csrf
        <div class="tab-content m-0" id="nav-tabContent">
          {{-- data diri --}}
          @if($currentStep == 1)
            <div class="" id="nav-diri" aria-labelledby="nav-diri-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">                
                  <div class="mb-4">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" @if($id_pasien) disabled @endif required wire:model="nama">
                    @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="no_telp" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" @if($id_pasien) disabled @endif required wire:model="no_telp">
                    @error('no_telp')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
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
                  <div class="mb-4">
                    <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
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
                  <div class="mb-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" @if($id_pasien) disabled @endif wire:model="email">
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="pekerjaan" class="form-label fw-bold">Pekerjaan</label>
                      <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')" @if($id_pasien) disabled @endif wire:model="pekerjaan">
                      @error('pekerjaan')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                      <label for="agama" class="form-label fw-bold">Agama</label>
                      <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" oninput="capEach('agama')" @if($id_pasien) disabled @endif wire:model="agama">
                      @error('agama')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                      <label for="alamat" class="form-label fw-bold">Alamat</label>
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
          @if($currentStep == 2)
            <div class="" id="nav-penunjang" aria-labelledby="nav-penunjang-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Foto</label>
                    <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" wire:model="foto" @if($id_pasien) disabled @endif>
                    @if($foto || $dbFoto)
                      <div class="row my-3 justify-content-sm-start fotoPreview">
                        <p class="col-sm-auto m-0">Preview :</p>
                        <img src="{{ $foto ? $foto->temporaryUrl() : asset('storage/' . $dbFoto) }}" class="img-fluid pt-2 col-sm-3 img-preview" style="max-height: 100px; width: auto">
                        @if($foto)
                        <button type="button" class="btn-close small" aria-label="Close" wire:click="deleteFoto"></button>
                        @endif
                      </div>
                    @endif
                    @error('foto')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>    
                  <div class="mb-4">
                    <label for="tanggal_pendaftaran" class="form-label fw-bold">Tanggal Registrasi <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
                      <input type="date" class="form-control @error('tanggal_pendaftaran') is-invalid @enderror" id="tanggal_pendaftaran" name="tanggal_pendaftaran" 
                        value="{{ old('tanggal_pendaftaran') }}" wire:model="tanggal_pendaftaran" @if($id_pasien) disabled @endif>
                      <div class="form-text">Contoh: 9 Desember 2023 diisi 12/09/2023</div>
                        @error('tanggal_pendaftaran')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                  </div>  
                  @if($id_pasien)
                  <div class="mb-4">
                    <label for="tanggal_rm" class="form-label fw-bold">Tanggal Registrasi Rekam Medis <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_registrasi') is-invalid @enderror" id="tanggal_registrasi" name="tanggal_registrasi" 
                      value="{{ old('tanggal_registrasi') }}" wire:model="tanggal_registrasi">
                    @error('tanggal_registrasi')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>  
                  @endif 
                  <div class="mb-4">
                    <label for="penanggungjawab" class="form-label fw-bold">Nama Penanggungjawab</label>
                    <input type="text" class="form-control @error('penanggungjawab') is-invalid @enderror" id="penanggungjawab" name="penanggungjawab" value="{{ old('penanggungjawab') }}" oninput="capEach('penanggungjawab')" wire:model="penanggungjawab">
                    @error('penanggungjawab')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col">
                  <div class="mb-4">
                    <label label class="form-label fw-bold w-100">Metode Pembayaran</label>
                    @foreach($tipePembayaran as $tipe)
                      @if (old('tipe_pembayaran') == $tipe['value'])
                        <div class="form-check form-check-block">                        
                            <input class="form-check-input" type="radio" name="tipe_pembayaran" id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}" checked wire:model="tipe_pembayaran">
                            <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                        </div>
                      @else
                        <div class="form-check form-check-block">                        
                            <input class="form-check-input" type="radio" name="tipe_pembayaran" id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}" wire:model="tipe_pembayaran">
                            <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                        </div>
                      @endif
                    @endforeach
                  </div>                  
                  <div class="mb-4">
                    <label for="biaya_pembayaran" class="form-label fw-bold">Biaya Pembayaran</label>
                    <input type="text" class="form-control @error('biaya_pembayaran') is-invalid @enderror" id="biaya_pembayaran" name="biaya_pembayaran" value="{{ old('biaya_pembayaran') }}" wire:model="biaya_pembayaran">
                    @error('biaya_pembayaran')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="jumlah_bayar" class="form-label fw-bold">Jumlah Bayar</label>
                    <div class="hstack gap-2">
                      <input type="number" class="form-control @error('jumlah_bayar') is-invalid @enderror" id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar') }}" wire:model="jumlah_bayar" style="max-width: 100px">
                      <span>X Bayar</span>
                    </div>
                    @error('jumlah_bayar')
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
                  <div class="mb-4">
                    <label for="tempat_layanan" class="form-label fw-bold">Tempat Layanan <span class="text-danger">*</span></label>
                    <div class="form-check ps-0 @error('tempatOption') form-control py-1 px-2 is-invalid @enderror">
                      <div class="form-check form-check-custom"> 
                        <input class="form-check-input" type="radio" name="tempatOption" id="klinik" value="klinik" wire:model="tempatOption" checked>
                        <label class="form-check-label" for="klinik">Klinik</label>
                      </div>
                      <div class="form-check form-check-custom"> 
                        <input class="form-check-input" type="radio" name="tempatOption" id="lainnya" value="lainnya" wire:model="tempatOption" checked>
                        <label class="form-check-label" for="lainnya">Lainnya</label>
                      </div>
                    </div>
                    <button type="button" class="form-control mt-2 text-start @error('tempat_layanan') is-invalid @enderror" id="alamatBtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="display:{{ $tempatOption == 'lainnya' ? 'block' : 'none'}};">
                      {{ $tempat_layanan ? $tempat_layanan : 'Masukkan Alamat' }}
                    </button>
                    @error('tempat_layanan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('tempatOption')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- modal alamat --}}
                  <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.2)" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="staticBackdropLabel">Alamat Tempat Layanan</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" class="form-control" id="k_bsni" name="k_bsni" value="{{ old('k_bsni') }}" wire:model="k_bsni">
                          <div class="mb-4">
                            <label class="form-label fw-bold">Provinsi</label>
                            <select class="form-select" style="max-height: 200px; overflow-y: auto;" id="provinsi" name="provinsi">
                              <option value="">Pilih Provinsi</option>
                            </select>
                          </div>
                          <div class="mb-4">
                            <label class="form-label fw-bold">Kota/Kabupaten</label>
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
                    <label for="jadwal_layanan" class="form-label fw-bold">Jadwal Layanan</label>
                    <input type="text" class="form-control @error('jadwal_layanan') is-invalid @enderror" id="jadwal_layanan" name="jadwal_layanan" value="{{ old('jadwal_layanan') }}" oninput="capFirst('jadwal_layanan')" wire:model="jadwal_layanan">
                    @error('jadwal_layanan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
  
                  <div class="mb-4">
                    <label for="sistem_layanan" class="form-label fw-bold">Sistem Layanan</label>
                    <div class="input-group">
                      <input type="text" class="form-control me-auto @error('sistem_layanan') is-invalid @enderror" id="sistem_layanan" name="sistem_layanan" value="{{ old('sistem_layanan') }}" oninput="capFirst('sistem_layanan')" wire:model="sistem_layanan">
                      <select class="form-select" id="sistemOption" name="sistemOption" wire:model="sistemOption">
                        <option value="Paket" selected>Paket</option>
                        <option value="Non-Paket">Non-Paket</option>
                      </select>
                    </div>
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
                  
                </div>
                
                <div class="col">
                  <div class="mb-4">
                    <label class="form-label fw-bold w-100">Status Terapi <span class="text-danger">*</span></label>
                    <div class="form-check p-0 @error('status_terapi') form-control py-1 px-2 is-invalid @enderror">
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
                    @error('status_terapi')
                      <div class="invalid-feedback d-block">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  
                  <div class="mb-4">
                    <label class="form-label fw-bold w-100">Status Rekam Medis <span class="text-danger">*</span></label>
                    <div class="form-check @error('status_pasien') form-control py-1 px-2 is-invalid @enderror p-0">
                      @foreach($statusPasien as $statusp)
                        @if(old('status_pasien') == $statusp['value'])
                          <div class="form-check form-check-custom">
                            <input class="form-check-input sp-input " type="radio" name="status_pasien" id="{{ $statusp['name'] }}" value="{{ $statusp['value'] }}" wire:model="status_pasien" checked>
                            <label class="form-check-label" for="{{ $statusp['name'] }}">{{ $statusp['value'] }}</label>
                          </div>
                        @else
                          <div class="form-check form-check-custom">
                            <input class="form-check-input" type="radio" name="status_pasien" id="{{ $statusp['name'] }}" value="{{ $statusp['value'] }}" wire:model="status_pasien">
                            <label class="form-check-label" for="{{ $statusp['name'] }}">{{ $statusp['value'] }}</label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                    @error('status_pasien')
                      <div class="invalid-feedback d-block">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>

                  <div class="mb-4">
                    <label for="tanggal_selesai" class="form-label fw-bold">Tanggal Selesai <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
                      <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" 
                        value="{{ old('tanggal_selesai') }}" wire:model="tanggal_selesai">
                      <div class="form-text">Diisi hanya saat status Rekam Medis Jeda/Selesai</div>
                        @error('tanggal_selesai')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                  </div>

                  <div class="mb-4">
                    <label for="ket_status" class="form-label fw-bold">Keterangan Status</label>
                    <textarea type="text" class="form-control @error('ket_status') is-invalid @enderror" id="ket_status" name="ket_status" rows="1" oninput="capFirst('ket_status')" wire:model="ket_status">{{ old('ket_status') }}</textarea>
                    @error('ket_status')
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
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="keluhan" class="form-label fw-bold">Keluhan</label>
                    <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="4" style="text-transform: full-width-kana;" oninput="capFirst('keluhan')" wire:model="keluhan"></textarea>
                    @error('keluhan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="data_deteksi" class="form-label fw-bold">Data Deteksi</label>
                      <textarea class="form-control @error('data_deteksi') is-invalid @enderror" id="data_deteksi" name="data_deteksi" rows="5" oninput="capFirst('data_deteksi')" wire:model="data_deteksi"></textarea>
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
                    <textarea type="text" class="form-control @error('catatan_fisik') is-invalid @enderror" id="catatan_fisik" name="catatan_fisik" value="{{ old('catatan_fisik') }}" oninput="capFirst('catatan_fisik')" wire:model="catatan_fisik"></textarea>
                    @error('catatan_fisik')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="catatan_bioplasmatik" class="form-label fw-bold">Catatan Bioplasmatik</label>
                    <textarea type="text" class="form-control @error('catatan_bioplasmatik') is-invalid @enderror" id="catatan_bioplasmatik" name="catatan_bioplasmatik" value="{{ old('catatan_bioplasmatik') }}" oninput="capFirst('catatan_bioplasmatik')"  wire:model="catatan_bioplasmatik"></textarea>
                    @error('catatan_bioplasmatik')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                      <label for="catatan_psikologis" class="form-label fw-bold">Catatan Psikologis</label>
                      <textarea type="text" class="form-control @error('catatan_psikologis') is-invalid @enderror" id="catatan_psikologis" name="catatan_psikologis" value="{{ old('catatan_psikologis') }}" oninput="capFirst('catatan_psikologis')"  wire:model="catatan_psikologis"></textarea>
                      @error('catatan_psikologis')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                    <label for="catatan_rohani" class="form-label fw-bold">Catatan Rohani</label>
                    <textarea type="text" class="form-control @error('catatan_rohani') is-invalid @enderror" id="catatan_rohani" name="catatan_rohani" value="{{ old('catatan_rohani') }}"  oninput="capFirst('catatan_rohani')" wire:model="catatan_rohani"></textarea>
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

          @if($currentStep == 6)
            <div class="" id="" role="tabpanel" aria-labelledby="nav-awal-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-4">                    
                    <label class="form-label fw-bold">Privasi Data</label>
                    <div class="form-check form-switch toggle-success toggle-md">
                      <input class="form-check-input" id="is_private" name="is_private" type="checkbox" role="switch" wire:model="is_private">
                      <label class="form-check-label ps-3" for="is_private">Jaga Data</label>
                    </div>
                    <div class="form-text">Aktifkan untuk menjaga privasi data pasien.</div>
                    @error('is_private')
                      <div class="invalid-feedback">
                      {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="col">   
                  <div class="mb-4">
                    <label class="form-label fw-bold">Terapis Default</label>
                    <select class="form-select @error('id_terapis') is-invalid @enderror" id="id_terapis" name="id_terapis" wire:model="id_terapis" {{ $is_private ? '' : 'disabled' }}>
                      <option value="">Pilih Terapis</option>
                      @foreach($listTerapis as $terapis)
                        @if (old('terapis') == $terapis)
                          <option value="{{ $terapis->id_terapis }}" selected>{{ $terapis->nama }}</option>
                        @else
                          <option value="{{ $terapis->id_terapis }}">{{ $terapis->nama }}</option>
                        @endif
                      @endforeach
                    </select>
                    @error('id_terapis')
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
  
            @if($currentStep >= 2 && $currentStep <= 6)
              <button class="btn btn-secondary" type="button" onclick="toTop()" wire:click="toPrev()">Sebelumnya</button>            
            @endif
            
            @if($currentStep >= 1 && $currentStep <= 5)     
              <button class="btn c-btn-success px-3 px-md-4 py-md-2" type="button" onclick="toTop()" wire:click="toNext()">Lanjut</button>
            @endif
  
            @if($currentStep == 6)
              <button type="submit" class="btn btn-success px-3 px-md-4 py-md-2" onclick="toTop()">Kirim</button>
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>
  
@push('script')
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
  
    function addPenyakitToController(newTag) {
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
                              onclick="addPenyakitToController('${penyakit}')">
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
                          onclick="addPenyakitToController('${penyakit}')">
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
              const trimmedValue = value.replace(/,$/, '');
              addPenyakitToController(trimmedValue);
  
              searchInpPenyakit.value = "";
          }
        });
  
        tambahBtn.addEventListener("click", function() {
          if(searchInpPenyakit.value != '') {
            addPenyakitToController(searchInpPenyakit.value);
          }
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
                  provinsiSelect.innerHTML += `
                    <option value="${provinsi.provinsi}" data-id="${provinsi.id}" ${provinsi.provinsi === kab_prov.provinsi ? 'selected' : ''}>${provinsi.provinsi}</option>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching JSON data:', error);
            });
        }
  
        alamatButton.addEventListener('click', function() {
          populateProvinsi();
          if(kab_prov.kabupaten != null) {
            populateKabupaten(kab_prov.provId);
          }
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
  