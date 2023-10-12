@extends('layouts.guest.main')

@section('container')
  <div class="container-fluid daftar-pasien">
    <div class="row">
      <main class="ms-md-auto">
        <div class="content-container">
          <h1 class="h2 mb-sm-4 pb-sm-3 border-bottom mb-3 pb-2">Daftar Sebagai Pasien</h1>
          <form method="post" action="{{ route('landing.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="main-bg">
              <div class="row pt-sm-3 pb-sm-2 border-bottom px-2 py-2">
                <h4 class="mx-md-2 mx-lg-3 fw-bold">Data Diri</h4>
              </div>
              <div class="mx-md-2 mx-lg-3 mt-4 px-2">
                <div class="mb-4">
                  <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                    name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" required wire:model="nama">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="no_telp" class="form-label fw-bold">Nomor Telepon <span
                      class="text-danger">*</span></label>
                  <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                    name="no_telp" value="{{ old('no_telp') }}" required>
                  @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                  <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                    name="jenis_kelamin" required>
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
                  <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                  <div class="form-text">Contoh: 9 Desember 1995 diisi 12/09/1995</div>
                  @error('tanggal_lahir')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="email" class="form-label fw-bold">Email</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email') }}">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="pekerjaan" class="form-label fw-bold">Pekerjaan</label>
                  <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan"
                    name="pekerjaan" value="{{ old('pekerjaan') }}" oninput="capEach('pekerjaan')">
                  @error('pekerjaan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="agama" class="form-label fw-bold">Agama</label>
                  <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama"
                    name="agama" value="{{ old('agama') }}" oninput="capEach('agama')">
                  @error('agama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="alamat" class="form-label fw-bold">Alamat</label>
                  <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                    name="alamat" value="{{ old('alamat') }}" oninput="capFirst('alamat')">
                  @error('alamat')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="main-bg mt-sm-4 mt-3">
              <div class="row pt-sm-3 pb-sm-2 border-bottom px-2 py-2">
                <h4 class="mx-md-2 mx-lg-3 fw-bold">Data Penunjang</h4>
              </div>
              <div class="mx-md-2 mx-lg-3 mt-4 px-2">
                <div class="mb-4">
                  <label for="foto" class="form-label fw-bold">Foto</label>
                  <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                    name="foto" value="{{ old('foto') }}" onchange="previewImage()">

                  <div class="row justify-content-sm-start my-2">
                    <img class="img-fluid col-sm-3 img-preview pt-2">
                  </div>

                  @error('foto')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label label class="form-label fw-bold w-100">Metode Pembayaran</label>
                  @foreach ($tipePembayaran as $tipe)
                    @if (old('tipe_pembayaran') == $tipe['value'])
                      <div class="form-check form-check-custom">
                        <input class="form-check-input" type="radio" name="tipe_pembayaran"
                          id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}" checked>
                        <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                      </div>
                    @else
                      <div class="form-check form-check-custom">
                        <input class="form-check-input" type="radio" name="tipe_pembayaran"
                          id="{{ $tipe['id'] }}" value="{{ $tipe['value'] }}">
                        <label class="form-check-label" for="{{ $tipe['value'] }}">{{ $tipe['value'] }}</label>
                      </div>
                    @endif
                  @endforeach
                </div>
                <div class="mb-4">
                  <label for="penanggungjawab" class="form-label fw-bold">Nama Penanggungjawab</label>
                  <input type="text" class="form-control @error('penanggungjawab') is-invalid @enderror"
                    id="penanggungjawab" name="penanggungjawab" value="{{ old('penanggungjawab') }}"
                    oninput="capEach('penanggungjawab')">
                  @error('penanggungjawab')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="keluhan" class="form-label fw-bold">Keluhan <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="2"
                    oninput="capFirst('keluhan')" required>{{ old('keluhan') }}</textarea>
                  @error('keluhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end my-4">
              <button type="submit" class="btn btn-success px-md-4 py-md-2 px-3"
                style="box-shadow: 2px 3px 2px #156640; transition: all 0.15s linear;">Kirim</button>
            </div>
        </div>
        </form>
    </div>
    </main>
  </div>
@endsection

@section('modal-alert')
  @if (session()->has('success'))
    <!-- Modal Daftar-->
    <div class="modal" style="background-color: rgba(0, 0, 0, 0.4); display: block;" id="daftarSuccessModal"
      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered mx-auto" role="document">
        <div class="modal-content mx-3">
          <div class="modal-header justify-content-center border-0">
            <h1 class="fw-bold mb-0 text-white">
              <i class="bi bi-patch-check-fill text-success" style="font-size: 60px;"></i>
            </h1>
          </div>
          <div class="modal-body pb-4 pt-0 text-center">
            <h5 class="fw-bold pb-2">Success!</h5>
            Selamat! Anda berhasil terdaftar sebagai pasien baru. Silahkan hubungi kami di nomor
            <strong>085960664604</strong> atau klik <a href="https://wa.me/6285960664604" target="_blank"
              class="btn btn-sm c-btn-success"> <i class="bi bi-whatsapp pe-1"></i> disini</a>
          </div>
          <div class="modal-footer justify-content-between mx-3">
            <button class="btn btn-secondary btn-sm" type="button" id="closeModal" data-bs-dismiss="modal"
              onclick="closeModalDaftar()">Tutup</button>
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
    function capEach(inputId) {
      var input = document.getElementById(inputId);
      let words = input.value.split(' ');

      for (let i = 0; i < words.length; i++) {
        if (words[i].length > 0) {
          words[i] = words[i][0].toUpperCase() + words[i].substring(1);
        }
      }

      input.value = words.join(' ');
    }

    function capFirst(inputId) {
      var input = document.getElementById(inputId);
      var word = input.value;

      if (word.length > 0) {
        var capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
        input.value = capitalizedWord;
      }
    }

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
