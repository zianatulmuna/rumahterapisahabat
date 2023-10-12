@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Edit Jadwal Terapi</h1>
    </div>

    <div class="main-bg">
      <form method="post" action="{{ route('jadwal.update', [$jadwal->id_jadwal]) }}" class="main-form mb-30 p-sm-4"
        id="terapiForm">
        @method('put')
        @csrf
        <div class="row row-cols-1 row-cols-md-2 py-sm-2 g-0 g-md-4 g-lg-5 p-3">
          <div class="col">
            <div class="mb-4">
              <label for="id_pasien" class="form-label fw-bold">Pasien</label>
              <div class="dropdown search-dinamis dropdown-pasien">
                <input type="hidden" name="id_pasien" value="{{ old('id_pasien', $pasien->id_pasien) }}" id="id_pasien"
                  class="form-control">
                <button class="form-control d-flex justify-content-between align-items-center" type="button"
                  data-bs-toggle="dropdown" aria-expanded="false" disabled>
                  <span>Pilih Pasien</span>
                  <i class="bi bi-chevron-down"></i>
                </button>
                <div class="dropdown-menu w-100 bg-body-tertiary px-3 shadow">
                  <div class="input-group py-2">
                    <span class="input-group-text border-end-0 bg-white pe-1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0 search-input" placeholder="Cari nama pasien">
                  </div>
                  <ul class="select-options rounded bg-white"></ul>
                </div>
              </div>
            </div>
            <div class="mb-4">
              <label for="no_telp" class="form-label fw-bold">Nomor Telepon</label>
              <input type="text" class="form-control" value="{{ old('no_telp', $pasien->no_telp) }}" id="no_telp"
                name="no_telp" disabled>
            </div>
            <div class="mb-4">
              <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
              <input type="text" class="form-control" value="{{ old('jenis_kelamin', $pasien->jenis_kelamin) }}"
                id="jenis_kelamin" name="jenis_kelamin" disabled>
            </div>
            <div class="mb-4">
              <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
              <input type="text" class="form-control" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}"
                id="tanggal_lahir" name="tanggal_lahir" disabled>
            </div>
          </div>
          <div class="col">
            <div class="mb-4">
              <label for="id_terapis" class="form-label fw-bold @error('id_terapis') is-invalid @enderror">Terapis</label>
              <div class="dropdown search-dinamis dropdown-terapis">
                <input type="hidden" name="id_terapis" value="{{ old('id_terapis', $jadwal->id_terapis) }}"
                  id="id_terapis" class="form-control">
                <button
                  class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror"
                  type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span>Pilih Terapis</span>
                  <i class="bi bi-chevron-down"></i>
                </button>
                <div class="dropdown-menu w-100 bg-body-tertiary px-3 shadow">
                  <div class="input-group py-2">
                    <span class="input-group-text border-end-0 bg-white pe-1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0 search-input"
                      placeholder="Cari nama terapis">
                  </div>
                  <ul class="select-options rounded bg-white"></ul>
                </div>
              </div>
              @error('id_terapis')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="penyakit" class="form-label fw-bold">Penyakit</label>
              <input type="hidden" id="id_sub" name="id_sub" value="{{ old('id_sub', $jadwal->id_sub) }}">
              <div class="form-control bg-body-secondary">{{ $jadwal->subRekamMedis->penyakit }} (NO.RM:
                {{ $jadwal->subRekamMedis->id_rekam_medis }})</div>
            </div>
            <div class="mb-4">
              <label for="tanggal" class="form-label fw-bold">Tanggal Terapi <small
                  class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}">
              @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="waktu" class="form-label fw-bold">Waktu Terapi</label>
              <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu"
                name="waktu" value="{{ old('waktu', $jadwal->waktu) }}">
              @error('waktu')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-3 p-3">
          <button type="submit" class="btn btn-success px-4 py-2">Kirim</button>
        </div>
      </form>
    </div>

  </div>
@endsection

@push('script')
  <script>
    let dataPasien = @json($list_pasien->toArray());
    let dataTerapis = @json($list_terapis->toArray());
  </script>
  <script src="/js/select-pasien.js"></script>
  <script src="/js/select-terapis.js"></script>
@endpush
