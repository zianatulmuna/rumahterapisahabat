@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Tambah Jadwal Terapi</h1>
    </div>

    <div class="main-bg">
      <form method="post" action="{{ route('jadwal.store') }}" class="main-form mb-30 p-sm-4" id="terapiForm">
        @csrf
        <div class="row row-cols-1 row-cols-md-2 py-sm-2 g-0 g-md-4 g-lg-5 p-3">
          <div class="col">
            <div class="mb-4">
              <label for="id_pasien" class="form-label fw-bold @error('id_pasien') is-invalid @enderror">Pasien <span
                  class="text-danger">*</span></label>
              <div class="dropdown search-dinamis dropdown-pasien">
                <input type="hidden" name="id_pasien" value="{{ old('id_pasien') }}" id="id_pasien" class="form-control">
                <button
                  class="form-control d-flex justify-content-between align-items-center @error('id_pasien') is-invalid @enderror"
                  type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
              @error('id_pasien')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="no_telp" class="form-label fw-bold @error('no_telp') is-invalid @enderror">Nomor
                Telepon</label>
              <input type="text" class="form-control" value="{{ old('no_telp') }}" id="no_telp" name="no_telp"
                readonly>
            </div>
            <div class="mb-4">
              <label for="jenis_kelamin" class="form-label fw-bold @error('jenis_kelamin') is-invalid @enderror">Jenis
                Kelamin</label>
              <input type="text" class="form-control" value="{{ old('jenis_kelamin') }}" id="jenis_kelamin"
                name="jenis_kelamin" readonly>
            </div>
            <div class="mb-4">
              <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
              <input type="text" class="form-control" value="{{ old('tanggal_lahir') }}" id="tanggal_lahir"
                name="tanggal_lahir" readonly>
            </div>
          </div>
          <div class="col">
            <div class="mb-4">
              <label for="id_terapis" class="form-label fw-bold @error('id_terapis') is-invalid @enderror">Terapis</label>
              <div class="dropdown search-dinamis dropdown-terapis">
                <input type="hidden" name="id_terapis" value="{{ old('id_terapis') }}" id="id_terapis"
                  class="form-control" required>
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
                  <ul class="select-options mb-2 rounded bg-white"></ul>
                  <div class="text-secondary small text-center">
                    <a class="text-reset text-decoration-none" style="cursor: pointer;" data-nama=""
                      onclick="setAllTerapis()">
                      <i class="bi bi-eye"></i> Tampilkan Semua Terapis
                    </a>
                  </div>
                </div>
              </div>
              @error('id_terapis')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">Pilih Penyakit <span class="text-danger">*</span></label>
              <select class="form-select @error('id_sub') is-invalid @enderror" id="id_sub" name="id_sub" required>
                <option value="">Pilih Penyakit</option>
              </select>
              @error('id_sub')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="tanggal" class="form-label fw-bold">Tanggal Terapi <small
                  class="fw-semibold">[Bulan/Tanggal/Tahun]</small> <span class="text-danger">*</span></label>
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                name="tanggal" value="{{ old('tanggal') }}" required>
              @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-4">
              <label for="waktu" class="form-label fw-bold">Waktu Terapi</label>
              <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu"
                name="waktu" value="{{ old('waktu') }}">
              @error('waktu')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="mt-3 p-3 text-end">
          <button type="submit" class="btn btn-success px-4 py-2">Kirim</button>
        </div>
      </form>
    </div>

  </div>
@endsection



@push('script')
  <script>
    let dataPasien = @json($pasien->toArray());
    const allTerapis = @json($listTerapis->toArray());
    let dataTerapis;

    setDataTerapis(allTerapis);

    function setDataTerapis(data) {
      dataTerapis = data;
    }

    function setAllTerapis() {
      setDataTerapis(allTerapis);
      addTerapis();
    }
  </script>
  <script>
    const subSelect = document.querySelector("#id_sub");

    function pasienChange() {
      fetch('/jadwal/tambah/getSubRekamMedis?id=' + id_pasien.value)
        .then(response => response.json())
        .then(data => {
          // console.log(data);
          subSelect.innerHTML = "";
          if (data.length > 1) {
            subSelect.innerHTML = `;
                  <option value="">Pilih Penyakit</option>
                  `;
          }
          data.forEach(sub => {
            subSelect.innerHTML += `
                  <option value="${sub.id_sub}">${sub.penyakit} (ID.RM: ${sub.id_rm})</option>
                  `;
          });
        })
        .catch(error => {
          console.error('Error fetching JSON data:', error);
        });
    };

    function terapisCheck() {
      fetch('/jadwal/tambah/terapisCheck?id=' + id_pasien.value)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            setDataTerapis(data);
          } else {
            setDataTerapis(allTerapis)
          }
          addTerapis();
        })
        .catch(error => {
          console.error('Error fetching JSON data:', error);
        });
    };
  </script>

  <script src="/js/select-pasien.js"></script>
  <script src="/js/select-terapis.js"></script>
@endpush

@if ($errors->any())
  @push('script')
    <script>
      setTimeout(function() {
        pasienChange();
        terapisCheck();
      }, 1000);
    </script>
  @endpush
@endif
