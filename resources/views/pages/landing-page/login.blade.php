@extends('layouts.guest.main')

@section('container')
<div class="container custom-login">
    <div class="row g-0 d-flex align-items-center justify-content-center border rounded-1 bg-white shadow my-5">
      <div class="col-md-6">
        <div class="card p-5 px-4 p-sm-5 border-0 text-center">
          <h3 class="fw-bold" style="font-family: Raleway">Masuk Akun</h3>
          <p class="mb-4">Selamat Datang Terapis</p>
          @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible small fade show py-1 px-2 hstack" role="alert" id="myAlert">
            <span class="me-auto">Gagal Login!</span>
            <button type="button" class="btn p-0" data-dismiss="alert" aria-label="Close"><i class="bi bi-x-circle-fill text-danger-emphasis"></i></button>
            </div>
          @endif
          <form action="/login" class="px-lg-3" method="post">
            @csrf
            <div class="input-group mt-2 mb-3">
              <span class="input-group-text bg-success text-white border-0" id="basic-addon1">
                <i class="bi bi-person-fill"></i>
              </span>
              <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required>
            </div>
            @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
            <div class="input-group mb-3">
              <span class="input-group-text bg-success text-white border-0" id="basic-addon1">
                <i class="bi bi-key-fill"></i>
              </span>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}" required>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
            @enderror
            <button type="submit" class="btn btn-success btn-block mt-4">
              Masuk Akun
            </button>
          </form>
        </div>
      </div>

      <div class="col-md-6 p-5 d-none d-md-block">
        <img src="/assets/Login.svg" alt="" />
      </div>
    </div>
  </div>
@endsection

@push('style')
<style>
    body {
      background-image: url("/assets/Login-bg.svg");
      background-position: center center;
      background-repeat: no-repeat;
      min-height: 93vh;
      height: 100%;
      background-size: cover;
      z-index: 1;
      /* background-color: #cee6dc */
    }
</style>
@endpush