@extends('layouts.guest.main')

@section('container')
<div class="container-fluid daftar-pasien">
  <div class="row">
    <main class="ms-md-auto">
      <div class="content-container">
        <h1 class="h2 pb-2 mb-3 mb-sm-4 pb-sm-3 border-bottom">Daftar Sebagai Pasien</h1>
        <form method="post" action="{{ route('landing.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="main-bg">
            <div class="row py-2 pt-sm-3 pb-sm-2 px-2 border-bottom">
              <h4 class="mx-md-2 mx-lg-3 fw-bold">Data Diri</h4>
            </div>
            <div class="px-2 mx-md-2 mx-lg-3 mt-4">
              <div class="mb-4">
                <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" required wire:model="nama">
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-4">
                <label for="no_telp" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required wire:model="no_telp">
                @error('no_telp')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-4">
                <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
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
              <div class="mb-4">
                <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" 
                  value="{{ old('tanggal_lahir') }}" wire:model="tanggal_lahir">
                <div class="form-text">Contoh: 9 Desember 1995 diisi 12/09/1995</div>
                @error('tanggal_lahir')
                  <div class="invalid-feedback">
                  {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-4">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" wire:model="email">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-4">
                  <label for="pekerjaan" class="form-label fw-bold">Pekerjaan</label>
                  <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')" wire:model="pekerjaan">
                  @error('pekerjaan')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
              </div>
              <div class="mb-4">
                  <label for="agama" class="form-label fw-bold">Agama</label>
                  <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" oninput="capEach('agama')" wire:model="agama">
                  @error('agama')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
              </div>
              <div class="mb-4">
                  <label for="alamat" class="form-label fw-bold">Alamat</label>
                  <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" oninput="capFirst('alamat')" wire:model="alamat">
                  @error('alamat')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                  @enderror
              </div>
            </div>
          </div>

          <div class="main-bg mt-3 mt-sm-4">
            <div class="row py-2 pt-sm-3 pb-sm-2 px-2 border-bottom">
              <h4 class="mx-md-2 mx-lg-3 fw-bold">Data Penunjang</h4>
            </div>
            <div class="px-2 mx-md-2 mx-lg-3 mt-4">
              <div class="mb-4">
                <label for="foto" class="form-label fw-bold">Foto</label>
                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" onchange="previewImage()">

                <div class="row my-2 justify-content-sm-start">
                  {{-- <p class="col-sm-auto m-0">Preview :</p> --}}
                  <img class="img-fluid pt-2 col-sm-3 img-preview">
                  {{-- <button type="button" class="btn-close small" aria-label="Close" wire:click="deleteFoto"></button> --}}
                </div>

                @error('foto')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-4">
                <label label class="form-label fw-bold w-100">Metode Pembayaran</label>
                @foreach($tipePembayaran as $tipe)
                  @if (old('tipe_pembayaran') == $tipe['value'])
                    <div class="form-check form-check-custom">                        
                        <input class="form-check-input" type="radio" name="tipe_pembayaran" id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}">
                        <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                    </div>
                  @else
                    <div class="form-check form-check-custom">                        
                        <input class="form-check-input" type="radio" name="tipe_pembayaran" id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}">
                        <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                    </div>
                  @endif
                @endforeach
              </div>
              <div class="mb-4">
                <label for="penanggungjawab" class="form-label fw-bold">Nama Penanggungjawab</label>
                <input type="text" class="form-control @error('penanggungjawab') is-invalid @enderror" id="penanggungjawab" name="penanggungjawab" value="{{ old('penanggungjawab') }}" oninput="capEach('penanggungjawab')">
                @error('penanggungjawab')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-4">
                <label for="keluhan" class="form-label fw-bold">Keluhan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="2" style="text-transform: full-width-kana;" oninput="capFirst('keluhan')" required></textarea>
                @error('keluhan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end my-4 ">
            <button type="submit" class="btn btn-success px-3 px-md-4 py-md-2" style="box-shadow: 2px 3px 2px #156640; transition: all 0.15s linear;">Kirim</button>
          </div>
        </div>
      </form>
    </div>
    </main>
  </div>
@endsection

@section('modal-alert')
  @if(session()->has('success'))
    <!-- Modal Daftar-->
    <div class="modal" style="background-color: rgba(0, 0, 0, 0.4); display: block;" id="daftarSuccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered mx-auto" role="document">
        <div class="modal-content mx-3">
          <div class="modal-header justify-content-center border-0">
            <h1 class="fw-bold text-white mb-0">
              <i class="bi bi-patch-check-fill text-success" style="font-size: 60px;"></i>
            </h1>
          </div>
          <div class="modal-body text-center pt-0 pb-4">
            <h5 class="fw-bold pb-2">Success!</h5>
            Selamat! Anda berhasil terdaftar sebagai pasien baru dengan ID <strong>{{ session('success') }}</strong>. Silahkan hubungi kami di nomor <strong>085960664604</strong> atau klik <a href="https://wa.me/6285960664604" target="_blank" class="btn btn-sm c-btn-success"> <i class="bi bi-whatsapp pe-1"></i> disini</a>
          </div>
          <div class="modal-footer justify-content-between mx-3">
            <button class="btn btn-secondary btn-sm" type="button" id="closeModal" data-bs-dismiss="modal" onclick="closeModalDaftar()">Tutup</button>
            <a href="/" class="btn btn-primary btn-sm">Ke Beranda</a>
          </div>
        </div>
      </div>
    </div>
    @endif
@endsection

@push('style')
    <style>
      body {
        background-color: #f1f4fc;
      }
    </style>
@endpush

@push('script')
  <script>
    document.querySelector('#keluhan').addEventListener('input', function(event) {
      if (event.key === "Enter") {
        var textarea = document.querySelector('#keluhan');
        textarea.value += '\n';
      }
    });

    function closeModalDaftar() {
      document.getElementById('daftarSuccessModal').style.display = 'none';
    };

    function previewImage() {
      const image = document.querySelector('#foto');
      const imgPreview = document.querySelector('.img-preview')

      imgPreview.style.display = 'block';

      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
      }
    }
  </script>
@endpush