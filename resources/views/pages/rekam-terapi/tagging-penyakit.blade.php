@extends('layouts.auth.main')

@section('container')
<div class="content-container">
  <div class="align-items-center pb-2 mb-4 border-bottom">
      <h2>Data Rekam Terapi Berdasarkan Penyakit</h2>
  </div>

  <div class="d-flex flex-nowrap justify-content-between align-item-center flex-wrap flex-md-nowrap my-4 gap-3">
    <form action="/rekam-terapi/tag" class="custom-search">
      @if(request('urut'))
        <input type="hidden" name="urut" value="{{ request('urut') }}">
      @endif
      <div class="input-group rounded shadow-sm custom-search-input">
        <span class="input-group-text border-success-subtle bg-white border-end-0 pe-1" id="addon-wrapping"><i class="bi bi-search"></i></span>
        <input type="search" name="search" value="{{ request('search') }}" class="form-control py-2 border-success-subtle border-start-0 rounded-end" placeholder="Cari Penyakit" aria-label="Search" aria-describedby="search-addon" />
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
    @if(count($sub_penyakit) > 0)
      <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3">
        @foreach($sub_penyakit as $sub)
          <div class="col mb-4">
            <div class="card shadow-sm">
              <h6 class="card-header fw-bold text-center{{ $sub->rekamMedis->status_pasien == "Rawat Jalan" ? ' bg-success text-white' : ' bg-nonaktif' }}">{{ $sub->penyakit }}</h6>
              <ul class="list-group list-group-flush text-left list-group-histori">                
                <li class="list-group-item">
                  <div class="d-flex justify-content-between right-0">
                      <div class="col" style="max-width: 50%;">
                        <p class="small">Pasien:</p>
                        <p class="text-truncate"><i class="bi bi-person-fill pe-1 text-light-emphasis"></i>{{ $sub->rekamMedis->pasien->nama }}</p>
                      </div>
                      <div class="d-flex justify-content-end"> 
                        <div class="" style="min-width: 114px">  
                          <p class="small">Total Terapi:</p>
                          <p class="align-center"><i class="bi bi-heart-pulse-fill text-success pe-2"></i>{{ $sub->total_terapi }}/{{ $sub->rekamMedis->jumlah_layanan }}</p>
                        </div>
                      </div> 
                  </div>                      
                </li>
                <li class="list-group-item">
                  <div class="d-flex justify-content-between right-0">
                    <div class="col">
                      <p class="small">NO. RM:</p>
                      <p>{{ $sub->id_rekam_medis }}</p>
                    </div>
                    <div class="d-flex justify-content-end">   
                      <div class="" style="min-width: 114px">
                        <p class="small">Status Pasien:</p>
                        @if($sub->rekamMedis->status_pasien == 'Rawat Jalan')
                          <p><i class="bi bi-clock-fill pe-1 c-text-primary"></i> Rawat Jalan</p>
                        @elseif($sub->rekamMedis->status_pasien == 'Jeda')
                          <p><i class="bi bi-pause-circle-fill pe-1 text-warning"></i> Jeda</p>
                        @else
                          <p><i class="bi bi-check-circle-fill pe-1 text-success"></i> Selesai</p>
                        @endif                         
                      </div>
                    </div> 
                  </div>                      
                </li>
              </ul>
              <div class="card-body d-flex justify-content-between mx-2">
                  <a href="{{ route('terapi.rekam', [$sub->rekamMedis->pasien->slug, $sub->id_sub]) }}" class="link-success">Rekam Terapi</a>
                  <a href="{{ route('pasien.rm', $sub->rekamMedis->pasien->slug) }}" class="link-success">Rekam Medis</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="d-flex justify-content-center mt-3">
        {{ $sub_penyakit->appends(request()->query())->links() }}
     </div>
    @else
     <span class="fst-italic py-4">Data tidak ditemukan.</span>
    @endif
   </div>
</div>
@endsection