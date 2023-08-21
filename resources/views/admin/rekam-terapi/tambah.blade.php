@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
    <h1 h1 class="h3">Tambah Terapi Harian</h1>
  </div>

  <div class="main-bg">
    <form method="post" action="{{ route('terapi.store', [$pasien->slug, $sub->id_sub]) }}" class="main-form mb-30 p-4" id="terapiForm">
      @csrf
      <div class="row p-3 gap-3">
        <div class="col">
          <div class="mb-3">
            <label for="id_terapis" class="form-label fw-semibold @error('id_terapis') is-invalid @enderror">Terapis</label>
            <div class="dropdown search-dinamis dropdown-terapis">
               <input type="hidden" name="id_terapis" value="{{ old('id_terapis') }}" id="id_terapis" class="form-control">
               <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <span>Pilih Terapis</span>
                 <i class="bi bi-chevron-down"></i>
               </button>
               <div class="dropdown-menu px-3 w-100 shadow">
                  <div class="input-group py-2">
                     <span class="input-group-text"><i class="bi bi-search"></i></span>
                     <input type="text" class="form-control search-input" placeholder="Cari nama terapis">
                  </div>
                  <ul class="select-options"></ul>
               </div>
            </div>
            @error('id_terapis')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
        </div>
        <div class="col d-flex gap-3 w-100"> 
          <div class="">
            <label for="tanggal" class="form-label fw-semibold">Tanggal Terapi</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
            <div class="form-text">Contoh: 9 Desember 2022 diisi 12/09/2022</div>
            @error('tanggal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="flex-fill">
            <label for="waktu" class="form-label fw-semibold">Waktu Terapi</label>
            <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}">
            @error('waktu')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
          
        
      </div>
      <div class="row p-3 gap-3">        
        <div class="col"> 
          <label for="keluhan" class="form-label fw-semibold">Keluhan Pasien</label>
          <textarea type="text" class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" value="{{ old('keluhan') }}" oninput="capFirst('keluhan')" rows="4">{{ old('keluhan') }}</textarea>
          @error('keluhan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col"> 
          <label for="tindakan" class="form-label fw-semibold">Terapi/Tindakan yang Sudah Dilakukan</label>
          <textarea type="text" class="form-control @error('tindakan') is-invalid @enderror" id="tindakan" name="tindakan" value="{{ old('tindakan') }}" oninput="capFirst('tindakan')" rows="4">{{ old('tindakan') }}</textarea>
          @error('tindakan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="row p-3 gap-3">
        <div class="col"> 
          <label for="deteksi" class="form-label fw-semibold">Deteksi/Pengukuran</label>
          <textarea type="text" class="form-control @error('deteksi') is-invalid @enderror" id="deteksi" name="deteksi" value="{{ old('deteksi') }}" oninput="capFirst('deteksi')" rows="4">{{ old('deteksi') }}</textarea>
          @error('deteksi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>        
        <div class="col"> 
          <label for="saran" class="form-label fw-semibold">Saran</label>
          <textarea type="text" class="form-control @error('saran') is-invalid @enderror" id="saran" name="saran" value="{{ old('saran') }}" oninput="capFirst('saran')" rows="4">{{ old('saran') }}</textarea>
          @error('saran')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
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
  const resetButton = document.getElementById("resetButton");

  resetButton.addEventListener("click", function() {
    location.reload();
  });

  function capFirst(inputId) {
    var input = document.getElementById(inputId);
    var word = input.value;

    if (word.length > 0) {
      var capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
      input.value = capitalizedWord;
    }
  } 

  let dataTerapis = @json($terapis->toArray());
   
</script>
<script src="/js/select-terapis.js"></script>

@endpush