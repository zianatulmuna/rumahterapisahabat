@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Edit Jadwal Terapi</h1>
   </div>

   <div class="main-bg">
      <form method="post" action="{{ route('jadwal.update', [$old_pasien->slug, $old_terapis->id_terapis, $old_tanggal->tanggal]) }}" class="main-form mb-30 p-4" id="terapiForm">
         @method('put')
         @csrf
         <div class="row p-3 gap-3">
            <div class="col"> 
               <div class="mb-3 select-search pasien-select">
                  <label for="waktu" class="form-label fw-semibold">Nama Pasien</label>
                  <select id="id_pasien" name="id_pasien" class="selectpicker d-block w-100 border border-body-tertiary rounded @error('id_pasien') is-invalid @enderror" data-live-search="true" title="Pilih Pasien" data-size="5">
                  @foreach ($pasien as $p)
                     @if (old('id_pasien', $old_pasien->id_pasien) == $p->id_pasien)
                        <option 
                           value="{{ $p->id_pasien }}" 
                           data-nama="{{ $p->nama }}"
                           data-telp="{{ $p->no_telp }}" 
                           data-birth="{{ $p->tanggal_lahir }}" 
                           data-gender="{{ $p->jenis_kelamin }}" selected>
                           {{ $p->nama }}
                        </option>
                     @else
                        <option 
                           value="{{ $p->id_pasien }}" 
                           data-nama="{{ $p->nama }}" 
                           data-telp="{{ $p->no_telp }}" 
                           data-birth="{{ $p->tanggal_lahir }}" 
                           data-gender="{{ $p->jenis_kelamin }}">
                           {{ $p->nama }}
                        </option>  
                     @endif             
                  @endforeach
                  </select>
                  @error('id_pasien')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
                <div class="mb-3">
                  <label for="no_telp" class="form-label fw-semibold @error('no_telp') is-invalid @enderror">Nomor Telepon</label>
                  <input type="text" class="form-control" value="{{ old('no_telp', $old_pasien->no_telp) }}" id="no_telp" name="no_telp" readonly>
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label fw-semibold @error('jenis_kelamin') is-invalid @enderror">Jenis Kelamin</label>
                  <input type="text" class="form-control" value="{{ old('jenis_kelamin', $old_pasien->jenis_kelamin) }}" id="jenis_kelamin" name="jenis_kelamin" readonly>
                </div>
                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                  <input type="text" class="form-control" value="{{ old('tanggal_lahir', $old_pasien->tanggal_lahir) }}" id="tanggal_lahir" name="tanggal_lahir" readonly>
                </div>
            </div>            
            <div class="col"> 
               <div class="mb-3 select-search">
                  <label for="waktu" class="form-label fw-semibold">Nama Terapis</label>
                  <select id="id_terapis" name="id_terapis" class="selectpicker d-block w-100 border border-body-tertiary rounded @error('id_terapis') is-invalid @enderror" data-live-search="true" title="Pilih Terapis" data-size="5">
                  @foreach ($terapis as $t)
                     @if (old('id_terapis', $old_terapis->id_terapis) == $t->id_terapis)
                        <option value="{{ $t->id_terapis }}" data-subtext="({{ $t->tingkatan }})" selected>{{ $t->nama }} ({{ $t->tingkatan }})</option>
                     @else
                        <option value="{{ $t->id_terapis }}" data-subtext="({{ $t->tingkatan }})">{{ $t->nama }}</option>  
                     @endif              
                  @endforeach
                  </select>
                  @error('id_terapis')
                     <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
               <div class="mb-3"> 
                  <label for="tanggal" class="form-label fw-semibold">Tanggal Terapi</label>
                  <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $old_tanggal->tanggal) }}">
                  <div class="form-text">Contoh: 9 Desember 2022 diisi 12/09/2022</div>
                  @error('tanggal')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
               <div class="mb-3">
                  <label for="waktu" class="form-label fw-semibold">Waktu Terapi</label>
                  <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu', $old_tanggal->waktu) }}">
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

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<style>
  .bootstrap-select .select-search button {
    background-color: #fff;
  }

  .bootstrap-select .dropdown-toggle:focus {
    outline: none !important;
  }

  .bootstrap-select .dropdown-menu {
   box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
  }

  .bootstrap-select .dropdown-menu li a {
    border-bottom: 1px solid #e7e5e5
  }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
   const divElement = document.querySelector('.pasien-select');
   const options = divElement.querySelectorAll('option');

   var telp = document.querySelector('#no_telp');
   var gender = document.querySelector('#jenis_kelamin');
   var birth = document.querySelector('#tanggal_lahir');
   
   divElement.addEventListener('change', function() {
      const selected = document.querySelector('.filter-option-inner-inner');
      const namaValue = selected.textContent;        

      for (var i = 0; i < options.length; i++) {
         var optionText = options[i].getAttribute('data-nama');
         if (optionText === namaValue) {
            telp.value = options[i].getAttribute('data-telp');
            gender.value = options[i].getAttribute('data-gender');
            birth.value = options[i].getAttribute('data-birth');       
            break;
         }
              
      }
   });

   const resetButton = document.getElementById("resetButton");

   resetButton.addEventListener("click", function() {
      location.reload();
   });
</script>
@endpush