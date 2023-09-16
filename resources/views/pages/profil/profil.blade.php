@extends('layouts.auth.main')

@section('container')
<div class="content-container">
    <div class="align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h2>Data User</h2>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center">
            @if ($user->foto)
                <img src="{{ asset('storage/' . $user->foto) }}" class="img-thumbnail" alt="{{ $user->nama }}" style="height: 240px; width: auto;">
            @else
                @if($user->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="img-thumbnail" alt="{{ $user->nama }}" style="height: 240px; width: auto;">
                @else
                  <img src="/img/avatar-p.png" class="img-thumbnail" alt="{{ $user->nama }}" style="height: 240px; width: auto;">
                @endif
            @endif
        </div>
    </div>

    <table class="table mx-auto shadow-sm border mt-4 table-admin">
        <tbody>
          <tr>
            <td>
              <div class="row row-cols-1 row-cols-sm-2 mt-3">
                <div class="col mb-3 px-4 px-md-5">
                  <p class="my-0" style="color: #919496;">Nama Lengkap</p>
                  <h5>{{ $user->nama }}</h5>
                </div>
  
                <div class="col mb-3 px-4 px-md-5">
                  <p class="my-0" style="color: #919496;">Tanggal Lahir</p>
                  <h5>{{ $tanggal_lahir }}</h5>
                </div>
                              
              </div>
  
              <div class="row row-cols-1 row-cols-sm-2">
                <div class="col mb-3 px-4 px-md-5">
                  <p class="my-0" style="color: #919496;">Nomor Telepon</p>
                  <h5>{{ $user->no_telp }}</h5>
                </div>
  
                <div class="col mb-3 px-4 px-md-5">
                  <p class="my-0"style="color: #919496;">Agama</p>
                  <h5>{{ $user->agama }}</h5>
                </div>                            
              </div>
  
              <div class="row row-cols-1 row-cols-sm-2">
                <div class="col mb-3 px-4 px-md-5">
                  <p class="my-0" style="color: #919496;">Jenis Kelamin</p>
                  <h5>{{ $user->jenis_kelamin }}</h5>
                </div>
  
                <div class="col mb-3 px-4 px-md-5">
                  <p class="my-0" style="color: #919496;">Alamat</p>
                  <h5>{{ $user->alamat }}</h5>
                </div>                            
              </div>
            </td>
          </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-center my-4">
        <a href="{{ route('profil.edit') }}" class="btn c-btn-warning px-4">
            <i class="bi bi-pencil-square pe-1"></i>
            Edit
        </a>
    </div>
</div>
@endsection
