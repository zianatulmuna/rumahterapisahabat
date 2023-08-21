<div>
  <div class="main-bg">
    <div class="row justify-content-between py-4 py-sm-5 custom-step">
      <div class="col text-center">
        <i class="bi {{  $currentStep == 1 ? 'bi-1-circle-fill' : 'bi-1-circle'  }} text-success h1"></i>
        <h5 class="pt-2">Data Diri</h5>
      </div>
      <div class="col text-center">
        <i class="bi {{  $currentStep == 2 ? 'bi-2-circle-fill' : 'bi-2-circle'  }} text-success h1"></i>
        <h5 class="pt-2">Data Penunjang</h5>
      </div>
      <div class="col text-center">
        <i class="bi {{  $currentStep == 3 ? 'bi-3-circle-fill' : 'bi-3-circle'  }} text-success h1"></i>
        <h5 class="pt-2">Rencana Layanan</h5>
      </div>
      <div class="col text-center">
        <i class="bi {{  $currentStep == 4 ? 'bi-4-circle-fill' : 'bi-4-circle'  }} text-success h1"></i>
        <h5 class="pt-2">Data Awal</h5>
      </div>
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
                <div class="mb-3">
                  <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" wire:model="nama">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="no_telp" class="form-label fw-semibold">Nomor Telepon</label>
                  <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" wire:model="no_telp">
                  @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold">Jenis Kelamin</label>
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
                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir [Bulan/Tanggal/Tahun]</label>
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
                <div class="mb-3">
                  <label for="email" class="form-label fw-semibold">Email</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" wire:model="email">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')" wire:model="pekerjaan">
                    @error('pekerjaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="agama" class="form-label fw-semibold">Agama</label>
                    <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" oninput="capEach('agama')" wire:model="agama">
                    @error('agama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
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
                <div class="mb-3">
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
                  <label for="foto" class="form-label">Foto</label>
                  <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" onchange="previewImage()" wire:model="foto">
                  
                  <div class="row my-3 justify-content-sm-start">
                    @if ($foto)
                      <p class="col-sm-auto m-0">Preview :</p>
                      <img src="{{ $foto->temporaryUrl() }}" class="img-fluid pt-2 col-sm-5 img-preview">
                      <button type="button" class="btn-close small" aria-label="Close" onclick="deleteFoto()" wire:click="deleteFoto"></button>
                    @elseif($dbFoto)
                      <p class="col-sm-auto m-0">Preview :</p>
                      <img src="{{ asset('storage/' . $dbFoto) }}" class="img-fluid pt-2 col-sm-5 img-preview">
                      <button type="button" class="btn-close small" aria-label="Close" onclick="deleteFoto()" wire:click="deleteFoto"></button>
                    @endif
                  </div>

                  @error('foto')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="link_rm" class="form-label fw-semibold">Link Rekam Medis</label>
                  <input type="url" class="form-control @error('link_rm') is-invalid @enderror" id="link_rm" name="link_rm" value="{{ old('link_rm') }}" wire:model="link_rm">
                  @error('link_rm')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>    
                
                <div class="mb-3">
                  <label for="tanggal_pendaftaran" class="form-label fw-semibold">Tanggal Pendaftaran</label>
                    <input type="date" class="form-control @error('tanggal_pendaftaran') is-invalid @enderror" id="tanggal_pendaftaran" name="tanggal_pendaftaran" 
                      value="{{ old('tanggal_pendaftaran') }}" wire:model="tanggal_pendaftaran">
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
        {{-- data layanan --}}
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
                <div class="mb-3">
                  <label for="jadwal_layanan" class="form-label fw-semibold">Jadwal Layanan</label>
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
                  <label class="form-label fw-semibold w-100">Status Terapi</label>
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

                <div class="mb-3">
                  <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai [Bulan/Tanggal/Tahun]</label>
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
                <div class="mb-3">
                  <label for="penyakit" class="form-label fw-semibold">Nama Penyakit</label>
                  @if(session()->has('duplicate'))
                    <div class="alert alert-warning alert-dismissible fade show p-2 px-3" role="alert">
                      {{ session('duplicate') }}
                      <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif
                  @if(!empty($dataTag[0]['db']) && !empty($dataTag[0]['current']))
                      @foreach ($dataTag as $i)
                        @php
                          $thisId = preg_replace('/\s+/', '-', $i['db']);
                        @endphp
                        <div class="d-flex mb-2 me-5">
                          <input type="text" class="form-control w-70 border rounded-0" id="{{ $thisId }}" nama="{{ $thisId }}" value="{{ $i['current'] }}" oninput="capEach('{{ $thisId }}')" disabled>
                          @if($i['db'] != '')
                            <button class="btn text-secondary border border-start-0 rounded-0" id="edit-{{ $thisId }}" type="button" data-toggle="modal" data-target="#{{ $thisId }}Modal">
                              <i class="bi bi-pencil-square pe-1"></i>
                            </button>
                          @endif
                          <button class="btn text-secondary border border-start-0 rounded-0" id="delete-{{ $thisId }}" type="button" data-toggle="modal" data-target="#subDeleteModal"><i class="bi bi-x-circle-fill"></i></button>

                          <button class="btn btn-primary rounded-0 ms-2 d-none" id="save-{{ $thisId }}" type="button" onclick="savePenyakit('{{ $i['db'] }}')">Simpan</button>
                          <button class="btn btn-secondary rounded-0 ms-2 d-none" id="undo-{{ $thisId }}" type="button" onclick="batalEdit('{{ $i['db'] }}')">Batal</button>
                        </div>
                        <x-modal-alert 
                          id="{{ $thisId }}Modal"
                          title="Yakin ingin edit?" 
                          body="Mengubah nama penyakit ini akan mempengaruhi nama penyakit di rekam terapi."
                          icon="bi bi-exclamation-triangle-fill text-warning"
                          >
                            <button class="btn btn-success" type="button" onclick="editPenyakit('{{ $i['db'] }}')" data-dismiss="modal">Edit</button>
                        </x-modal-alert>
                            <!-- Terapi Delete Modal-->
                          <div class="modal fade" id="subDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                          aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                          <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                                            <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                                            <span>Yakin ingin menghapus rekam terapi?</span>
                                          </h5>
                                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-4">Semua data terkait rekam terapi untuk penyakit ini akan dihapus <strong>permanen</strong>! Hal ini termasuk semua data terapi harian.
                                    </div>
                                    <div class="modal-footer">
                                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" wire:click="deleteTagPenyakit('{{ $i['db'] }}')" data-dismiss="modal"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                                    </div>
                                </div>
                              </div>
                          </div>
                      @endforeach   
                    @endif   
                  <div class="form-control d-flex flex-wrap gap-2 p-2 rounded taginput @error('penyakit') is-invalid @enderror">                    
                    @if(count($tag) > 0)
                      @foreach ($tag as $i)
                        <div class="px-2 bg-body-secondary border border-body-secondary rounded-3 tag-item">
                          {{ $i }}
                          <button type="button" class="btn m-0 p-0 text-secondary" wire:click="deleteTagBaru('{{ $i }}')"><i class="bi bi-x-circle-fill"></i></button>
                        </div>
                      @endforeach   
                    @endif 
                    <input 
                      type="text" 
                      class="flex-grow-1" 
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
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="keluhan" class="form-label fw-semibold">Keluhan</label>
                  <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="2" style="text-transform: full-width-kana;" oninput="capFirst('keluhan')" wire:model="keluhan"></textarea>
                  @error('keluhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="data_deteksi" class="form-label fw-semibold">Data Deteksi</label>
                    <textarea class="form-control @error('data_deteksi') is-invalid @enderror" id="data_deteksi" name="data_deteksi" rows="2" oninput="capFirst('data_deteksi')" wire:model="data_deteksi"></textarea>
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

        {{-- button step --}}
        <div class="d-flex justify-content-between my-5 mx-3 mb-md-5 mx-md-5 form-navigation">
          @if($currentStep == 1)
            <div></div>           
          @endif

          @if($currentStep == 2 || $currentStep == 3 || $currentStep == 4)
            <button class="btn btn-secondary" type="button" onclick="toTop()" wire:click="toPrev()">Sebelumnya</button>            
          @endif

          @if($currentStep == 1 || $currentStep == 2 || $currentStep == 3)      
            <button class="btn btn-primary px-md-4 py-md-2" type="button" onclick="toTop()" wire:click="toNext()">Lanjut</button>
          @endif

          @if($currentStep == 4)
            <button type="submit" class="btn c-btn-success px-md-4 py-md-2" onclick="toTop()">Kirim</button>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>

@section('modal-alert')
    <!-- Terapi Delete Modal-->
   <div class="modal fade" id="terapiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content p-3">
            <div class="modal-header">
                  <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                     <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                     <span>Yakin ingin menghapus rekam terapi?</span>
                  </h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">Semua data terkait rekam terapi untuk penyakit ini akan dihapus <strong>permanen</strong>! Hal ini termasuk semua data terapi harian.
            </div>
            <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn c-btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
            </div>
         </div>
      </div>
   </div>
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
      
      updateExistPenyakit(dbValue, inputValue);      
      
      closeSave(id);
    }

    function batalEdit(dbValue) {
      const id = dbValue.replace(/\s+/g, '');
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

    document.addEventListener('livewire:load', function () {
      Livewire.on('runScriptPenyakit', function () {
          const inputField = document.getElementById('tagPenyakit');

          function addTagToController(newTag) {
            Livewire.emit('addTagPenyakit', newTag);
          };

          inputField.addEventListener('keyup', function(event) {
            if (event.key === ",") {
              const value = inputField.value;
              const trimmedValue = value.slice(0, -1);

              addTagToController(trimmedValue);

              inputField.value = "";
            }
          });
      });  
    });

  </script>
@endpush