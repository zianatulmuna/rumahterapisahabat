@extends('layouts.auth.main')

@section('container')
<div class="content-container mx-2">
    <div class="row mb-2">
      <h1 class="h2 px-0 pb-3 border-bottom text-secondary">Selamat Datang, {{ auth()->user()->nama }}</h1>
    </div>

    <div class="row">
        {{-- grafik --}}
        <div class="col-xl-8 p-0 pe-xl-4 mt-2 mt-lg-3">
            @livewire('grafik-dashboard')
        </div>
        
        {{-- terapis ready --}}
        <div class="col-xl-4 p-0 mt-3">            
            @livewire('terapis-ready')
        </div>        
    </div>

    <div class="row main-bg mt-3 mt-lg-4" id="jadwal">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
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