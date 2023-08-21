@extends('layouts.auth.main')

@section('container')
<div class="container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h2">Terapis</h1>
   </div>

<div class="row row-cols-1 row-cols-md-4 g-4 mt-4">
   @foreach ($therapist as $terapis)
   <div class="col mb-4">
      <div class="card h-100" style="width: 13rem;">
         @if($terapis->jenis_kelamin === 'Laki-Laki')
            <img src="/img/avatar-l.png" class="card-img-top" alt="...">
         @else
            <img src="/img/avatar-p.png" class="card-img-top" alt="...">
         @endif
         <a href="{{ route('terapis.show', $terapis->id_terapis) }}" class="card-body p-2 btn btn-white rounded-0" style="border: 2px solid #4b4b4b; border-radius: none;">{{ $terapis->nama }}</a>
       </div>
   </div>
   @endforeach
 </div>
</div>

{{-- <div class="d-flex justify-content-center mt-5">
   {{ $therapist->links() }}
</div> --}}
@endsection