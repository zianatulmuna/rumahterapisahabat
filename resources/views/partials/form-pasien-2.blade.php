@if($currentStep == 2)
  <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
    <div class="col">
      <div class="mb-4">
        <label for="foto" class="form-label fw-bold">Foto</label>
        <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" wire:model="foto" @if($addRMPage) disabled @endif>
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
        <label for="tanggal_pendaftaran" class="form-label fw-bold">Tanggal Registrasi Pasien <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
          <input type="date" class="form-control @error('tanggal_pendaftaran') is-invalid @enderror" id="tanggal_pendaftaran" name="tanggal_pendaftaran" 
            value="{{ old('tanggal_pendaftaran') }}" wire:model="tanggal_pendaftaran" @if($addRMPage || $editPage) disabled @endif>
          <div class="form-text">Contoh: 9 Desember 2023 diisi 12/09/2023</div>
            @error('tanggal_pendaftaran')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
      </div>  
      @if($addRMPage || $editPage)
      <div class="mb-4">
        <label for="tanggal_rm" class="form-label fw-bold">Tanggal Registrasi Rekam Medis <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
        <input type="date" class="form-control @error('tanggal_registrasi') is-invalid @enderror" id="tanggal_registrasi" name="tanggal_registrasi" 
          value="{{ old('tanggal_registrasi') }}" wire:model="tanggal_registrasi" @if($isPasienLama) disabled @endif>
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
@endif