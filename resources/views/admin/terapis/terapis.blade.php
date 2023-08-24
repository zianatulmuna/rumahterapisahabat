@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
    <h1 class="h2">Terapis</h1>
  </div>

  <div class="pb-3 d-flex justify-content-start">
    <a href="{{ route('terapis.create') }}" class="btn c-btn-primary"><i class="bi bi-person-add"></i> Tambah Terapis</a>
  </div>

  <div class="d-flex justify-content-between my-4 gap-3">
    <form action="/admin/terapis" class="custom-search shadow-sm rounded">
      @if(request('tingkatan'))
        <input type="hidden" name="tingkatan" value="{{ request('tingkatan') }}">
      @endif
      <div class="input-group rounded custom-search-input">
        <span class="input-group-text border-success-subtle bg-white border-end-0 pe-1" id="addon-wrapping"><i class="bi bi-search"></i></span>
        <input type="search" name="search" value="{{ request('search') }}" class="form-control py-2 border-success-subtle border-start-0 rounded-end" placeholder="Cari Nama Terapis" aria-label="Search" aria-describedby="search-addon" />
        <button type="submit" class="btn btn-outline-success px-4 btn-cari">Cari</button>
      </div>        
      </form>
    <div class="dropdown custom-filter">
      <button class="btn btn-outline-success py-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <p class="d-none d-md-inline">
          <i class="bi bi-funnel"></i>
          @if(request('tingkatan'))
            Terapis {{ request('tingkatan') }}
          @else
            Filter Tingkatan
          @endif
        </p>
        <i class="bi bi-funnel filter-icon"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-1 shadow-lg border-0" aria-labelledby="dropdownMenuButton">
        <a href="/admin/terapis" class="dropdown-item {{ Request::query('tingkatan') ? '' : 'active' }}">Semua</a>
        @foreach($tingkatan as $tingkat)
            <a href="/admin/terapis?{{ Request::query('search') != '' ? 'search=' . request('search') . '' : '' }}tingkatan={{ $tingkat }}" class="dropdown-item {{ Request::query('tingkatan') == $tingkat ? 'active' : '' }}">{{ $tingkat }}</a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="pt-3 pb-2 mb-3">
    @if(count($terapis) > 0)
      <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 g-3 g-xl-4 g-xxl-3">
        @foreach ($terapis as $t)
          <div class="col">
            <div class="card card-custom border-0 card-terapis shadow-sm">
              <a href="{{ route('terapis.detail', $t->username) }}" class="card-header py-2">
                <h6 class="card-header-text">{{ $t->nama }}</h6>
              </a>
              @if ($t->foto)
                <img src="{{ asset('storage/' . $t->foto) }}" class="card-img-top" alt="{{ $t->nama }}">
              @else
                @if($t->jenis_kelamin === 'Laki-Laki')
                    <img src="/img/avatar-l.png" class="card-img-top" alt="{{ $t->nama }}">
                @else
                    <img src="/img/avatar-p.png" class="card-img-top" alt="{{ $t->nama }}">
                @endif
              @endif
              <div class="card-body p-0 d-flex justify-content-center align-items-center">
                <p class="card-title">Terapis {{ $t->tingkatan }}</p>
              </div>
            </div>          
          </div>
        @endforeach
      </div>
    @else
     <span class="fst-italic">Data tidak ditemukan."</span>
    @endif
  </div>

   

</div>

<div class="d-flex justify-content-center my-4 p">
   {{ $terapis->links() }}
</div>
@endsection