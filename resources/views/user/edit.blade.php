@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 h1 class="h2">Edit Profil</h1>
  </div>

  @livewire('form-edit-profil', ['user' => $user])
</div>
@endsection

@push('script')
  @livewireScripts  
@endpush