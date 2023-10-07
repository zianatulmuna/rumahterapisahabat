@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
    <h1 class="h2">Pasien Lama</h1>
  </div>

  <div class="d-flex flex-nowrap justify-content-between align-item-center flex-wrap flex-md-nowrap my-4 gap-3">
    <form action="/pasien/lama" class="custom-search">
      @if(request('urut'))
        <input type="hidden" name="urut" value="{{ request('urut') }}">
      @endif
      @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
      @endif
      <div class="input-group rounded shadow-sm custom-search-input">
        <span class="input-group-text border-success-subtle bg-white border-end-0 pe-1" id="addon-wrapping"><i class="bi bi-search"></i></span>
        <input type="search" name="search" value="{{ request('search') }}" class="form-control py-2 border-success-subtle border-start-0 rounded-end" placeholder="Cari Nama Pasien/Penyakit/ID.Pasien/No.RM" aria-label="Search" aria-describedby="search-addon" />
        <button type="submit" class="btn btn-outline-success px-4 btn-cari">Cari</button>
      </div>        
    </form>
    <div class="dropdown custom-filter">
      <button class="btn btn-outline-success hstack py-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-funnel pe-1"></i>
        <p class="d-none mb-0 me-auto d-md-inline">
        @if(request('status'))
          Pasien {{ request('status') }}
        @elseif(request('urut'))
          Pasien {{ request('urut') }}
        @else
          Filter Pencarian
        @endif
        </p>
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-1 shadow w-100" aria-labelledurut="dropdownMenuButton">
        <h6 class="dropdown-header">Berdasarkan status</h6>
        <a 
          href="?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}{{ Request::query('urut') ? 'urut=' . request('urut') : '' }}" 
          class="dropdown-item {{ Request::query('status') ? '' : 'active' }}">
          Semua
        </a>
        <a 
          href="?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}status=Rawat Jalan{{ Request::query('urut') ? '&urut=' . request('urut') : '' }}"
          class="dropdown-item {{ Request::query('status') == 'Rawat Jalan' ? 'active' : '' }}">
          Rawat Jalan
        </a>
        <a 
          href="?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}status=Jeda{{ Request::query('urut') ? '&urut=' . request('urut') : '' }}" 
          class="dropdown-item {{ Request::query('status') == 'Jeda' ? 'active' : '' }}">
          Jeda
        </a>
        <a 
          href="?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}status=Selesai{{ Request::query('urut') ? '&urut=' . request('urut') : '' }}" 
          class="dropdown-item {{ Request::query('status') == 'Selesai' ? 'active' : '' }}">
          Selesai
        </a>
        <div class="dropdown-divider"></div>
        <h6 class="dropdown-header">Urutkan berdasarkan</h6>
        <a 
          href="?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}{{ Request::query('status') ? 'status=' . request('status') . '&' : '' }}urut=Terbaru" 
          class="dropdown-item {{ Request::query('urut') == 'Terbaru' ? 'active' : '' }}">
          <i class="bi bi-sort-numeric-down-alt pe-1"></i> Terbaru
        </a>
        <a 
          href="?{{ Request::query('search') != '' ? 'search=' . request('search') . '&' : '' }}{{ Request::query('status') ? 'status=' . request('status') . '&' : '' }}urut=Terlama" 
          class="dropdown-item {{ Request::query('urut') == 'Terlama' ? 'active' : '' }}">
          <i class="bi bi-sort-numeric-down pe-1"></i> Terlama
        </a>
      </div>
    </div>
  </div>

  <div class="pt-3 pb-2 mb-3">
    @if(count($pasien_lama) > 0)
      <div class="row row-cols-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-3 g-xl-4 g-xxl-3">
        @foreach ($pasien_lama as $pasien)
          <div class="col">
            <div class="card border-0 text-center card-custom shadow-sm">
              <div class="card-header py-1 py-sm-2">
                <h6 class="card-header-text">{{ $pasien->nama }}</h6>
              </div>
                @if ($pasien->foto)
                  <img src="{{ asset('storage/' . $pasien->foto) }}" class="card-img-top" alt="...">
                @else
                  @if($pasien->jenis_kelamin === 'Laki-Laki')
                      <img src="/img/avatar-l.png" class="card-img-top" alt="...">
                  @else
                      <img src="/img/avatar-p.png" class="card-img-top" alt="...">
                  @endif
                @endif

                <div class="card-body py-1 px-2 align-middle">
                  <p>
                    @php
                      $arrayPenyakitAllowed = [];
                      $emptyRM = 1;
                      $isHidden = 0;
                      foreach ($pasien->rekamMedis as $rm) {
                        if ($userAdmin || $userKepala || !$rm->is_private || ($userTerapis && !$userKepala && $rm->is_private && $rm->id_terapis == $userTerapis->id_terapis)) {
                          $arrayPenyakitAllowed = array_merge($arrayPenyakitAllowed, explode(",", $rm->penyakit));
                        }
                        $isHidden = $rm->is_private ? 1 : 0;
                        $emptyRM = 0;
                      }                  
                    @endphp
                    @if($emptyRM)
                      <div></div>
                    @elseif(count($arrayPenyakitAllowed) > 0)
                      @foreach($arrayPenyakitAllowed as $p)
                        <a href="/rekam-terapi/tag?search={{ $p }}" target="_blank" class="link-dark link-underline-light d-inline">{{ $p }}</a>@if(!$loop->last || ($loop->last && $isHidden)),@endif
                      @endforeach
                      @if($isHidden)
                      <i class="bi bi-lock-fill text-secondary"></i>
                      @endif
                    @endif
                    @if(!$emptyRM && count($arrayPenyakitAllowed) == 0)
                      <div class="d-inline-flex justify-content-center align-items-center text-secondary"><i class="bi bi-lock-fill"></i></div>
                    @endif
                  </p>
                </div>
                <div class="card-footer bg-white d-flex align-item-center justify-content-between">
                  <a href="{{ route('sub.histori', $pasien->slug) }}" class="lh-sm">Histori Terapi</a>
                  <div class="vr"></div>
                  <a href="{{ route('pasien.rm', $pasien->slug) }}" class="lh-sm">Rekam Medis</a>
                </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="d-flex justify-content-center mt-5">
        {{ $pasien_lama->appends(request()->query())->links() }}
     </div>
    @else
     <span class="fst-italic py-4">Data tidak ditemukan.</span>
    @endif
  </div>

   

</div>


@endsection