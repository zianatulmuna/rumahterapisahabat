@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
    <h1 h1 class="h3">Tambah Terapi Harian</h1>
  </div>

  @livewire('terapi-edit-form', ['pasien' => $pasien,'terapi' => $terapi])

  
</div>
@endsection

@push('script')
  @livewireScripts  
@endpush