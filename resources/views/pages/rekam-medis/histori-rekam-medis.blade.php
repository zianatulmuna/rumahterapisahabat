@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Histori Rekam Medis</h1>
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')

   @if($rmDetected == 1)  
      <h4 class="mt-5 mb-3">Rekam Medis Terkini</h4>
      @if(count($rm_terkini) > 0)   
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4">
            @foreach($rm_terkini as $rm)   
               <div class="col mb-4">
                  <div class="card shadow-sm card-kini h-100">
                     
                     <a href="{{ count($rm_terkini) == 1 ? route('pasien.rm', $pasien->slug) : route('rm.detail', [$pasien->slug, $rm->id_rekam_medis])}}" class="card-header text-center"><h6>NO.RM  {{ $rm->id_rekam_medis }}</h6></a>
                     <ul class="list-group list-group-flush text-left list-group-histori">
                        <li class="list-group-item">
                           <p class="small">Penyakit:</p>
                           <p class="text-center">
                              @php
                                 $arrayPenyakit = explode(",", $rm->penyakit);
                              @endphp
                              @foreach($arrayPenyakit as $p)
                                 <a href="/rekam-terapi/tag?search={{ $p }}" target="_blank" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@endif
                              @endforeach
                           </p>
                        </li>
                        <li class="list-group-item">
                           <div class="d-flex justify-content-between right-0">
                              <div class="col">
                                 <p class="small">Status Pasien:</p>
                                 <p><i class="bi bi-clock-fill pe-1 c-text-primary"></i> Rawat Jalan</p>
                              </div>
                              <div class="d-flex justify-content-end">   
                                 <div class="">
                                    <p class="small">Status Terapi:</p>                  
                                    <p><i class="bi {{ $rm->status_terapi == 'Terapi Baru' ? 'bi-0-circle-fill c-text-success' : 'bi-arrow-right-circle-fill c-text-warning' }} pe-1"></i>{{ $rm->status_terapi }}</p>
                                 </div>
                              </div> 
                           </div>                      
                        </li>
                     </ul>
                     <div class="card-body row">
                        @if(count($rm->subRekamMedis) == 0)
                           <div class="fst-italic">Data rekam terapi telah dihapus. 
                              @if($userAdmin)
                                 Tambahkan penyakit pada Rekam Medis <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.
                              @endif
                           </div>
                        @elseif(count($rm->subRekamMedis) == 1)
                           <a href="{{ route('terapi.rekam', [$pasien->slug, $rm->subRekamMedis[0]->id_sub]) }}" class="link-success text-decoration-none">
                              Rekam Terapi 
                              <i class="bi bi-arrow-right"></i>
                           </a>
                        @else 
                           @foreach($rm->subRekamMedis as $sub)
                              <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}" class="link-success text-decoration-none">
                                 Rekam Terapi {{ $sub->penyakit }} 
                                 <i class="bi bi-arrow-right"></i>
                              </a>
                           @endforeach
                        @endif
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      @else
         <div class="alert alert-warning d-inline-flex p-0 p-2 px-3 mb-4">
            <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
            Pasien ini tidak memiliki histori rekam medis aktif.
         </div>
      @endif
      @if(count($rm_terdahulu) > 0)
         <h4 class="mt-4 mb-3">Rekam Medis Terdahulu</h4>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4">
            @foreach($rm_terdahulu as $rm) 
            <div class="col mb-4">
               <div class="card shadow-sm card-dulu h-100">
                  <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}" class="card-header text-center"><h6>NO.RM  {{ $rm->id_rekam_medis }}</h6></a>
                  <ul class="list-group list-group-flush text-left list-group-histori">
                     <li class="list-group-item">
                        <p class="small">Penyakit:</p>
                        <p class="text-center">
                           @php
                              $arrayPenyakit = explode(",", $rm->penyakit);
                           @endphp
                           @foreach($arrayPenyakit as $p)
                              <a href="/rekam-terapi/tag?search={{ $p }}" target="_blank" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@endif
                           @endforeach
                        </p>
                     </li>
                     <li class="list-group-item">
                        <div class="d-flex justify-content-between right-0">
                           <div class="col">
                              <p class="small">Status Pasien:</p>
                              @if($rm->status_pasien == 'Jeda')
                                 <p><i class="bi bi-pause-circle-fill pe-1 text-warning"></i> Jeda</p>
                              @else
                                 <p><i class="bi bi-check-circle-fill pe-1 text-success"></i> Selesai</p>
                              @endif 
                           </div>
                           <div class="d-flex justify-content-end">   
                              <div class="">
                                 @if($rm->status_pasien == 'Jeda')
                                    <p class="small">Tanggal Jeda:</p>                  
                                    <p><i class="bi bi-calendar2-check-fill pe-1 text-light-emphasis"></i> {{ date('d-m-Y', strtotime($rm->tanggal_selesai)) }}</p>
                                 @else
                                    <p class="small">Tanggal Selesai:</p>                  
                                    <p><i class="bi bi-calendar2-check-fill pe-1 text-light-emphasis"></i> {{ date('d-m-Y', strtotime($rm->tanggal_selesai)) }}</p>
                                 @endif 
                                 
                              </div>
                           </div> 
                        </div>                      
                     </li>
                     </ul>
                     <div class="card-body row">
                        @if(count($rm->subRekamMedis) == 1)
                           <a href="{{ route('terapi.rekam', [$pasien->slug, $rm->subRekamMedis[0]->id_sub]) }}" class="link-success text-decoration-none">
                              Rekam Terapi 
                              <i class="bi bi-arrow-right"></i>
                           </a>
                        @else 
                           @foreach($rm->subRekamMedis as $sub)
                              <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}" class="link-success text-decoration-none">
                                 Rekam Terapi {{ $sub->penyakit }} 
                                 <i class="bi bi-arrow-right"></i>
                              </a>
                           @endforeach
                        @endif
                     </div>
               </div>
            </div>
            @endforeach
         </div>
      @endif
   @else
      <div class="alert alert-danger w-auto d-inline-flex mt-5 p-0 p-2 px-3">
         <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
         Pasien ini tidak memiliki histori rekam medis.
      </div>
   @endif

   @if($userAdmin || $userTerapis->id_terapis == 'KTR001')
      <div class="d-flex mt-3 justify-content-end">
         <a href="{{ route('rm.create', $pasien->slug) }}" class="btn c-btn-primary"><i class="bi bi-file-earmark-plus pe-2"></i>Tambah Rekam Medis</a>
      </div>
   @endif
</div>
@endsection