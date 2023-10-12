@if ($currentStep == 1)
  <div class="row row-cols-1 row-cols-md-2 px-md-5 g-0 g-md-4 g-lg-5 px-3">
    <div class="col">
      <div class="mb-4">
        <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
          value="{{ old('nama') }}" oninput="capEach('nama')" @if ($addRMPage) disabled @endif
          required wire:model="nama">
        @error('nama')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="no_telp" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp"
          value="{{ old('no_telp') }}" @if ($addRMPage) disabled @endif required wire:model="no_telp">
        @error('no_telp')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin"
          @if ($addRMPage) disabled @endif @if ($addRMPage) disabled @endif
          wire:model="jenis_kelamin" required aria-label=".form-select-sm example">
          <option value="">Pilih Jenis Kelamin</option>
          @foreach ($jenisKelamin as $gender)
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
        <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir <small
            class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir"
          name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" @if ($addRMPage) disabled @endif
          wire:model="tanggal_lahir">
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
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
          value="{{ old('email') }}" @if ($addRMPage) disabled @endif wire:model="email">
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="pekerjaan" class="form-label fw-bold">Pekerjaan</label>
        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan"
          name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')"
          @if ($addRMPage) disabled @endif wire:model="pekerjaan">
        @error('pekerjaan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="agama" class="form-label fw-bold">Agama</label>
        <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama"
          value="{{ old('agama') }}" oninput="capEach('agama')" @if ($addRMPage) disabled @endif
          wire:model="agama">
        @error('agama')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="alamat" class="form-label fw-bold">Alamat</label>
        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
          value="{{ old('alamat') }}" oninput="capFirst('alamat')" @if ($addRMPage) disabled @endif
          wire:model="alamat">
        @error('alamat')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
  </div>
@endif
