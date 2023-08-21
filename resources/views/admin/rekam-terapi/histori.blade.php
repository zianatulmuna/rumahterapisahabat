@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h2">Histori Rekam Terapi</h1>
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')
   
   @if($rmDetected == 1)
      @if(count($rm_terkini) > 0) 
         <h4 class="mt-5 mb-3">Rekam Terapi Terkini</h4>
         <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($rm_terkini as $rm)
               @if(count($rm->subRekamMedis) > 0)
                  @foreach($rm->subRekamMedis as $sub)
                     <div class="col mb-4">
                        <div class="card">
                           <h6 class="card-header bg-success text-white text-center">{{ $sub->penyakit }}</h6>
                           <ul class="list-group list-group-flush text-left list-group-histori">
                              <li class="list-group-item text-center">
                                 <p class="small d-inline">Total Terapi:</p>
                                 <p class="fs-5 d-inline">{{ $sub->total_terapi }}/{{ $rm->jumlah_layanan }}</p>
                              </li>
                              <li class="list-group-item">
                                 <div class="row">
                                    <div class="col ms-1">
                                       <p class="small">NO.RM:</p>
                                       <p>{{ $sub->id_rekam_medis }}</p>
                                    </div>
                                    <div class="col ms-4">  
                                       <p class="small">Status:</p>                   
                                       @if($rm->status_pasien == 'Rawat Jalan')
                                          <p><i class="bi bi-clock-fill pe-1 text-primary"></i> Rawat Jalan</p>
                                       @elseif($rm->status_pasien == 'Jeda')
                                          <p><i class="bi bi-pause-circle-fill pe-1 text-warning"></i> Jeda</p>
                                       @else
                                          <p><i class="bi bi-check-circle-fill pe-1 text-success"></i> Selesai</p>
                                       @endif
                                    </div>  
                                 </div>                     
                              </li>
                              <li class="list-group-item">
                                 <div class="row">
                                    <div class="col ms-1">
                                       <p class="small">Tanggal Mulai:</p>
                                       <p><i class="bi bi-calendar-plus pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($sub->created_at)) }}</p>
                                    </div>
                                    <div class="col ms-4">   
                                       <p class="small">Tanggal Terkini:</p>                  
                                       <p><i class="bi bi-calendar2-check-fill pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($sub->updated_at)) }}</p>
                                    </div> 
                                 </div>                      
                              </li>
                           </ul>
                           <div class="card-body d-flex justify-content-between mx-2">
                              <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}">Rekam Terapi</a>
                              <a href="{{ route('pasien.rm', $pasien->slug) }}">Rekam Medis</a>
                           </div>
                        </div>
                     </div>
                  @endforeach
               @else
                  <div class="alert alert-warning ms-2 p-2 col-xl-7">
                     <i class="bi bi-exclamation-circle pe-1 fw-semibold"></i>
                     Data rekam terapi telah dihapus. Tambahkan penyakit pada Rekam Medis
                     <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.
                  </div>
                  {{-- <span class="fst-italic ">Data rekam terapi telah dihapus. Tambahkan penyakit di rekam medis <a href="">disini</a></span> --}}
               @endif
            @endforeach
         </div>
      @endif
      @if(count($rm_terdahulu) > 0)
         <h4 class="mt-5 mb-3">Rekam Terapi Terdahulu</h4>
         <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($rm_terdahulu as $rm)
                  @foreach($rm->subRekamMedis as $sub)
                     <div class="col mb-4">
                        <div class="card">
                           <h6 class="card-header bg-secondary text-white text-center">{{ $sub->penyakit }}</h6>
                           <ul class="list-group list-group-flush text-left list-group-histori">
                              <li class="list-group-item text-center">
                                 <p class="small d-inline">Total Terapi:</p>
                                 <p class="fs-5 d-inline">{{ $sub->total_terapi }}/{{ $rm->jumlah_layanan }}</p>
                              </li>
                              <li class="list-group-item">
                                 <div class="row">
                                    <div class="col ms-1">
                                       <p class="small">NO.RM:</p>
                                       <p>{{ $sub->id_rekam_medis }}</p>
                                    </div>
                                    <div class="col ms-4">  
                                       <p class="small">Status:</p>                   
                                       @if($rm->status_pasien == 'Rawat Jalan')
                                          <p><i class="bi bi-clock-fill pe-1 text-primary"></i> Rawat Jalan</p>
                                       @elseif($rm->status_pasien == 'Jeda')
                                          <p><i class="bi bi-pause-circle-fill pe-1 text-warning"></i> Jeda</p>
                                       @else
                                          <p><i class="bi bi-check-circle-fill pe-1 text-success"></i> Selesai</p>
                                       @endif
                                    </div> 
                                 </div>                      
                              </li>
                              <li class="list-group-item">
                                 <div class="row">
                                    <div class="col ms-1">
                                       <p class="small">Tanggal Mulai:</p>
                                       <p><i class="bi bi-calendar-plus pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($sub->created_at)) }}</p>
                                    </div>
                                    <div class="col ms-4">   
                                       <p class="small">Tanggal Terkini:</p>                  
                                       <p><i class="bi bi-calendar2-check-fill pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($sub->updated_at)) }}</p>
                                    </div>   
                                 </div>                    
                              </li>
                           </ul>
                           <div class="card-body d-flex justify-content-between mx-2">
                              <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}">Rekam Terapi</a>
                              <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}">Rekam Medis</a>
                           </div>
                        </div>
                     </div>
                  @endforeach
            @endforeach
         </div>
      @endif
   @else
      <div class="alert alert-danger mt-5 p-0 p-2 px-3 col-xl-7">
         <i class="bi bi-exclamation-circle pe-1 fw-semibold"></i>
         Pasien ini tidak memiliki histori rekam terapi.
         <a href="{{ route('rm.create', $pasien->slug) }}" class="alert-link">Tambah Rekam Medis</a>
      </div>
   @endif
</div>
@endsection