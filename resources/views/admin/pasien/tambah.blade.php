@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
    @if(empty($pasien))
      <h1 h1 class="h2">Tambah Pasien</h1>
    @else
      <h1 h1 class="h2">Tambah Rekam Medis</h1>
    @endif
  </div>

  @livewire('form-create-pasien', ['pasien' => $pasien])
</div>
@endsection

@push('script')
  @livewireScripts  
@endpush