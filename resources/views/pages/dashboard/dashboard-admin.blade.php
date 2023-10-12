@extends('layouts.auth.main')

@section('container')
  <div class="content-container mx-2">
    <div class="row mb-3">
      <h1 class="h2 border-bottom text-secondary px-0 pb-3">Selamat Datang, {{ auth()->user()->nama }}</h1>
    </div>

    {{-- card performa --}}
    @include('partials.card-performa')

    <div class="row">
      {{-- grafik --}}
      <div class="col-xl-8 pe-xl-4 mt-lg-3 mt-2 p-0">
        @livewire('grafik-dashboard')
      </div>

      {{-- terapis ready --}}
      <div class="col-xl-4 mt-3 p-0">
        @livewire('terapis-ready')
      </div>
    </div>

    <div class="row main-bg mt-lg-4 mt-3" id="jadwal">
      <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-3 flex-wrap pb-2 pt-3">
        <h1 class="h4">Jadwal Terapi</h1>
      </div>
      {{-- jadwal --}}
      @livewire('jadwal-dashboard')
    </div>
  </div>
@endsection

@push('script')
  @livewireScripts
@endpush
