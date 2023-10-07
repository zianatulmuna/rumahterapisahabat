@if($currentStep == 3)
  <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
    <div class="col">
      <div class="mb-4">
        <label for="tempat_layanan" class="form-label fw-bold">Tempat Layanan <span class="text-danger">*</span></label>
        <div class="form-check p-0 @error('tempatOption') form-control py-1 px-2 is-invalid @enderror">
          <div class="form-check form-check-custom"> 
            <input class="form-check-input" type="radio" name="tempatOption" id="klinik" value="klinik" wire:model="tempatOption" {{ $tempatOption == 'klinik' ? 'checked' : '' }}>
            <label class="form-check-label" for="klinik">Klinik</label>
          </div>
          <div class="form-check form-check-custom"> 
            <input class="form-check-input" type="radio" name="tempatOption" id="lainnya" value="lainnya" wire:model="tempatOption" {{ $tempatOption == 'lainnya' ? 'checked' : '' }}>
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
@endif