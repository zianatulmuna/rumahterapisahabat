@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="align-items-center pb-2 mb-4 border-bottom">
      <h2>Pasien Baru</h2>
  </div>

  <div class="pb-3 d-flex justify-content-start">
    <a href="{{ route('pasien.create') }}" class="btn c-btn-primary"><i class="bi bi-person-add"></i> Tambah Pasien</a>
  </div>

  <div class="d-flex flex-nowrap justify-content-between align-item-center flex-wrap flex-md-nowrap my-4 gap-3">
    <form action="/pasien-baru" class="custom-search">
      @if(request('urut'))
        <input type="hidden" name="urut" value="{{ request('urut') }}">
      @endif
      <div class="input-group rounded shadow-sm custom-search-input">
        <span class="input-group-text border-success-subtle bg-white border-end-0 pe-1" id="addon-wrapping"><i class="bi bi-search"></i></span>
        <input type="search" name="search" value="{{ request('search') }}" class="form-control py-2 border-success-subtle border-start-0 rounded-end" placeholder="Cari Nama Pasien atau Penyakit" aria-label="Search" aria-describedby="search-addon" />
        <button type="submit" class="btn btn-outline-success px-4 btn-cari">Cari</button>
      </div>        
    </form>
    <div class="dropdown custom-filter">
      <button class="btn btn-outline-success hstack py-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-funnel pe-1"></i>
        <p class="d-none mb-0 me-auto d-md-inline">
          @if(request('urut'))
            Pasien {{ request('urut') }}
          @else
            Filter Pencarian
          @endif
        </p>
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-1 shadow w-100" aria-labelledby="dropdownMenuButton">
        <li><h6 class="dropdown-header">Urutkan berdasarkan</h6></li>
        <li><a href="?{{ Request::query('search') ? 'search=' . request('search') . '&' : '' }}urut=Terbaru" class="dropdown-item {{ Request::query('urut') == 'Terbaru' ? 'active' : '' }}"><i class="bi bi-sort-numeric-down-alt pe-1"></i> Terbaru</a></li>
        <li><a href="?{{ Request::query('search') ? 'search=' . request('search') . '&' : '' }}urut=Terlama" class="dropdown-item {{ Request::query('urut') == 'Terlama' ? 'active' : '' }}"><i class="bi bi-sort-numeric-down pe-1"></i> Terlama</a></li>
      </div>
    </div>
  </div>

  <div class="pt-3 pb-2 mb-3">
    @if(count($pasien_baru) > 0)
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5 g-3 g-lg-4">          
        @foreach ($pasien_baru as $pasien)                  
          <div class="col">
            <div class="card card-baru border-0 shadow-sm">
              @if($userAdmin || $userTerapis->id_terapis == 'KTR001')
              <a href="{{ route('pasien.edit', $pasien->slug) }}" class="card-header py-2">
                <h6 class="card-header-text">{{ $pasien->nama }}</h6>
              </a>
              @else
                <div class="card-header py-2 text-white">
                  <h6 class="card-header-text">{{ $pasien->nama }}</h6>
                </div>
              @endif
               @if($pasien->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="card-img-top" alt="...">
               @else
                  <img src="/img/avatar-p.png" class="card-img-top" alt="...">
               @endif
               <div class="card-body p-0">
                <div class="px-3 py-2 p-sm-3">
                  <p>Ditambahkan:</p>
                  <div class="d-flex align-item-center justify-content-between py-1">
                    <p class="card-title">{{ date('d/m/Y', strtotime($pasien->tanggal_pendaftaran)) }}</p>
                    <p class="card-title">{{ date('H:i', strtotime($pasien->tanggal_pendaftaran)) }}</p>
                  </div>
                </div>                 
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
     <span class="fst-italic py-4">Data tidak ditemukan.</span>
    @endif
   </div>
</div>

<div class="d-flex justify-content-center mt-5">
   {{ $pasien_baru->appends(request()->query())->links() }}
</div>
@endsection