@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Terapis</h1>
    </div>

    @if ($userAdmin)
      <div class="d-flex justify-content-start pb-3">
        <a href="{{ route('terapis.add') }}" class="btn c-btn-primary"><i class="bi bi-person-add"></i> Tambah Terapis</a>
      </div>
    @endif

    <div class="d-flex justify-content-between my-4 gap-3">
      <form action="/terapis" class="custom-search rounded shadow-sm">
        @if (request('tingkatan'))
          <input type="hidden" name="tingkatan" value="{{ request('tingkatan') }}">
        @endif
        <div class="input-group custom-search-input rounded">
          <span class="input-group-text border-success-subtle border-end-0 bg-white pe-1" id="addon-wrapping"><i
              class="bi bi-search"></i></span>
          <input type="search" name="search" value="{{ request('search') }}"
            class="form-control border-success-subtle border-start-0 rounded-end py-2"
            placeholder="Cari Nama/Username Terapis" aria-label="Search" aria-describedby="search-addon" />
          <button type="submit" class="btn btn-outline-success btn-cari px-4">Cari</button>
        </div>
      </form>
      <div class="dropdown custom-filter">
        <button class="btn btn-outline-success hstack dropdown-toggle py-2" type="button" id="dropdownMenuButton"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <p class="d-none d-md-inline mb-0 me-auto">
            <i class="bi bi-funnel pe-2"></i>
            @if (request('tingkatan'))
              Terapis {{ request('tingkatan') }}
            @else
              Filter Tingkatan
            @endif
          </p>
          <i class="bi bi-funnel filter-icon"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right w-100 mt-1 border-0 shadow-lg" aria-labelledby="dropdownMenuButton">
          <a href="/terapis" class="dropdown-item {{ Request::query('tingkatan') ? '' : 'active' }}">Semua</a>
          @foreach ($tingkatan as $tingkat)
            <a href="/terapis?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}tingkatan={{ $tingkat }}"
              class="dropdown-item {{ Request::query('tingkatan') == $tingkat ? 'active' : '' }}">{{ $tingkat }}</a>
          @endforeach
        </div>
      </div>
    </div>

    <div class="mb-3 pb-2 pt-3">
      @if (count($terapis) > 0)
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 g-3 g-xl-4 g-xxl-3">
          @foreach ($terapis as $t)
            <div class="col">
              <div class="card card-custom card-terapis border-0 shadow-sm">
                <a href="{{ route('terapis.detail', $t->username) }}" class="card-header p-0">
                  <h6 class="card-header-text p-2">{{ $t->nama }}</h6>
                </a>
                @if ($t->foto)
                  <img src="{{ asset('storage/' . $t->foto) }}" class="card-img-top" alt="{{ $t->nama }}">
                @else
                  @if ($t->jenis_kelamin === 'Laki-Laki')
                    <img src="/img/avatar-l.png" class="card-img-top" alt="{{ $t->nama }}">
                  @else
                    <img src="/img/avatar-p.png" class="card-img-top" alt="{{ $t->nama }}">
                  @endif
                @endif
                <div class="card-body d-flex justify-content-center align-items-center p-0">
                  <p class="card-title">Terapis {{ $t->tingkatan }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <span class="fst-italic">Data tidak ditemukan.</span>
      @endif
    </div>
  </div>

  <div class="d-flex justify-content-center p my-4">
    {{ $terapis->links() }}
  </div>
@endsection
