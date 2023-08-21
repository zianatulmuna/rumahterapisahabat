@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
    <h1 h1 class="h3">Tambah Terapi Harian</h1>
  </div>

  <div class="main-bg">
    <form method="post" action="{{ route('terapi.update', [$pasien->slug, $sub->id_sub, $terapi->tanggal]) }}" class="main-form mb-30 p-4" id="terapiForm">
      @method('put')
      @csrf
      <div class="row p-3 gap-3">
        <div class="col select-terapis"> 
          <label for="waktu" class="form-label fw-semibold">Nama Terapis</label>
          <select id="id_terapis" name="id_terapis" class="selectpicker show-tick d-block w-100 border border-body-tertiary rounded @error('id_terapis') is-invalid @enderror" data-live-search="true" title="Pilih Terapis">
            @foreach ($terapis as $t)
              @if (old('id_terapis', $terapi->id_terapis) == $t->id_terapis)
                <option value="{{ $t->id_terapis }}" selected>{{ $t->nama }} ({{ $t->tingkatan }})</option>
              @else
                <option value="{{ $t->id_terapis }}">{{ $t->nama }} ({{ $t->tingkatan }})</option>  
              @endif              
            @endforeach
          </select>
          @error('id_terapis')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col d-flex gap-3 w-100"> 
          <div class="">
            <label for="tanggal" class="form-label fw-semibold">Tanggal Terapi</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $terapi->tanggal) }}">
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
          <textarea type="text" class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" value="{{ old('keluhan', $terapi->keluhan) }}" oninput="capFirst('keluhan')" rows="4">{{ old('keluhan', $terapi->keluhan) }}</textarea>
          @error('keluhan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col"> 
          <label for="tindakan" class="form-label fw-semibold">Terapi/Tindakan yang Sudah Dilakukan</label>
          <textarea type="text" class="form-control @error('tindakan') is-invalid @enderror" id="tindakan" name="tindakan" value="{{ old('tindakan', $terapi->tindakan) }}" oninput="capFirst('tindakan')" rows="4">{{ old('tindakan', $terapi->tindakan) }}</textarea>
          @error('tindakan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="row p-3 gap-3">
        <div class="col"> 
          <label for="deteksi" class="form-label fw-semibold">Deteksi/Pengukuran</label>
          <textarea type="text" class="form-control @error('deteksi') is-invalid @enderror" id="deteksi" name="deteksi" value="{{ old('deteksi', $terapi->deteksi) }}" oninput="capFirst('deteksi')" rows="4">{{ old('deteksi', $terapi->deteksi) }}</textarea>
          @error('deteksi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>        
        <div class="col"> 
          <label for="saran" class="form-label fw-semibold">Saran</label>
          <textarea type="text" class="form-control @error('saran') is-invalid @enderror" id="saran" name="saran" value="{{ old('saran', $terapi->saran) }}" oninput="capFirst('saran')" rows="4">{{ old('saran', $terapi->saran) }}</textarea>
          @error('saran')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="d-flex justify-content-between p-3 mt-3">
        <div class="d-flex justify-content-start gap-3">
          <button type="button" id="resetButton" class="btn btn-secondary px-4" onclick="goBack()"></i> Batal</button>
          <button type="button" id="resetButton" class="btn btn-outline-danger"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
        </div>
        <button type="submit" class="btn btn-success px-4 py-2">Kirim</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<style>
  .select-terapis button {
    background-color: #fff;
  }

  .bootstrap-select .dropdown-toggle:focus {
    outline: none !important;
  }

  .bootstrap-select .dropdown-menu li a {
    border-bottom: 1px solid #e7e5e5
  }
</style>
@endpush

@push('script')
<script>
  function goBack() {
    history.back();
  }

  function capFirst(inputId) {
    var input = document.getElementById(inputId);
    var word = input.value;

    if (word.length > 0) {
      var capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
      input.value = capitalizedWord;
    }
  } 
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endpush