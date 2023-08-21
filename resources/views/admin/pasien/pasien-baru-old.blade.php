@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h2>Pasien Baru</h2>
   </div>
   {{-- <div class="d-flex justify-content-end"> --}}
      <a href="{{ route('pasien.create') }}" class="btn btn-primary">Tambah Pasien</a>
   {{-- </div> --}}

<div class="row row-cols-1 row-cols-md-4 g-4 mt-4">
   @foreach ($pasien_baru as $pasien)
   <div class="col mb-4">
      <div class="card h-100" style="width: 13rem;">
         @if($pasien->jenis_kelamin === 'Laki-Laki')
            <img src="/img/avatar-l.png" class="card-img-top" alt="...">
         @else
            <img src="/img/avatar-p.png" class="card-img-top" alt="...">
         @endif
         <a href="/admin/pasien/{{ $pasien->slug }}/edit" class="card-body p-2 btn btn-white rounded-0" style="border: 2px solid #4b4b4b; border-radius: none;">{{ $pasien->nama }}</a>
       </div>
   </div>
   @endforeach
 </div>
</div>

<div class="d-flex justify-content-center mt-5">
   {{ $pasien_baru->links() }}
</div>
@endsection