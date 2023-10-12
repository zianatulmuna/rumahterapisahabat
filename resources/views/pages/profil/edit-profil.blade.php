@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 h1 class="h2">Edit Profil</h1>
    </div>

    @livewire('profil-edit-form', ['user' => $user])
  </div>
@endsection

@push('script')
  @livewireScripts
@endpush
