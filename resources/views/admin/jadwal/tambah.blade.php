@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Tambah Jadwal Terapi</h1>
   </div>

   <div class="main-bg">
      <form method="post" action="{{ route('jadwal.store') }}" class="main-form mb-30 p-sm-4" id="terapiForm">
        @csrf
        <div class="row row-cols-1 row-cols-md-2 p-3 py-sm-2 g-0 g-md-4 g-lg-5">
            <div class="col"> 
               <div class="mb-4">
                  <label for="id_pasien" class="form-label fw-bold @error('id_pasien') is-invalid @enderror">Pasien</label>
                  <div class="dropdown search-dinamis dropdown-pasien">
                     <input type="hidden" name="id_pasien" value="{{ old('id_pasien') }}" id="id_pasien" class="form-control">
                     <button class="form-control d-flex justify-content-between align-items-center @error('id_pasien') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <span>Pilih Pasien</span>
                       <i class="bi bi-chevron-down"></i>
                     </button>
                     <div class="dropdown-menu px-3 w-100 bg-body-tertiary shadow">
                        <div class="input-group py-2">
                           <span class="input-group-text pe-1 bg-white border-end-0"><i class="bi bi-search"></i></span>
                           <input type="text" class="form-control border-start-0 search-input" placeholder="Cari nama pasien">
                        </div>
                        <ul class="select-options bg-white rounded"></ul>
                     </div>
                  </div>
                  @error('id_pasien')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
               <div class="mb-4">
                  <label for="no_telp" class="form-label fw-bold @error('no_telp') is-invalid @enderror">Nomor Telepon</label>
                  <input type="text" class="form-control" value="{{ old('no_telp') }}" id="no_telp" name="no_telp" readonly>
               </div>
               <div class="mb-4">
                  <label for="jenis_kelamin" class="form-label fw-bold @error('jenis_kelamin') is-invalid @enderror">Jenis Kelamin</label>
                  <input type="text" class="form-control" value="{{ old('jenis_kelamin') }}" id="jenis_kelamin" name="jenis_kelamin" readonly>
               </div>
               <div class="mb-4">
                  <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                  <input type="text" class="form-control" value="{{ old('tanggal_lahir') }}" id="tanggal_lahir" name="tanggal_lahir" readonly>
               </div>
            </div>            
            <div class="col"> 
               <div class="mb-4">
                  <label for="id_terapis" class="form-label fw-bold @error('id_terapis') is-invalid @enderror">Terapis</label>
                  <div class="dropdown search-dinamis dropdown-terapis">
                     <input type="hidden" name="id_terapis" value="{{ old('id_terapis') }}" id="id_terapis" class="form-control">
                     <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <span>Pilih Terapis</span>
                       <i class="bi bi-chevron-down"></i>
                     </button>
                     <div class="dropdown-menu px-3 w-100 bg-body-tertiary shadow">
                        <div class="input-group py-2">
                           <span class="input-group-text pe-1 bg-white border-end-0"><i class="bi bi-search"></i></span>
                           <input type="text" class="form-control border-start-0 search-input" placeholder="Cari nama terapis">
                        </div>
                        <ul class="select-options bg-white rounded"></ul>
                     </div>
                  </div>
                  @error('id_terapis')
                     <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
               <div class="mb-4"> 
                  <label for="tanggal" class="form-label fw-bold">Tanggal Terapi</label>
                  <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                  <div class="form-text">Contoh: 9 Desember 2022 diisi 12/09/2022</div>
                  @error('tanggal')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
               <div class="mb-4">
                  <label for="waktu" class="form-label fw-bold">Waktu Terapi</label>
                  <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}">
                  @error('waktu')
                     <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
            </div>      
        </div>
  
        <div class="d-flex justify-content-between p-3 mt-3">
          <button type="button" id="resetButton" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
          <button type="submit" class="btn btn-success px-4 py-2">Kirim</button>
        </div>
      </form>
    </div>

</div>
@endsection

@push('script')
   <script>
      let dataPasien = @json($pasien->toArray());
      let dataTerapis = @json($terapis->toArray());
   </script>
   <script src="/js/select-pasien.js"></script>
   <script src="/js/select-terapis.js"></script>
@endpush