@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h2">Histori Rekam Medis</h1>
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')

   @if($rmDetected == 1)  
      @if(count($rm_terkini) > 0)   
         <h4 class="mt-5 mb-3">Rekam Medis Terkini</h4>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-4 g-xxl-3">
            @foreach($rm_terkini as $rm)   
               <div class="col mb-4">
                  <div class="card shadow-sm">
                     <h6 class="card-header bg-success text-white text-center">NO.RM  {{ $rm->id_rekam_medis }}</h6>
                     <ul class="list-group list-group-flush text-left list-group-histori">
                        <li class="list-group-item">
                           <p class="small">Penyakit:</p>
                           <p class="text-center">
                              @php
                                 $arrayPenyakit = explode(",", $rm->penyakit);
                              @endphp
                              @foreach($arrayPenyakit as $p)
                                 <a href="#" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@endif
                              @endforeach
                           </p>
                        </li>
                        <li class="list-group-item">
                           <div class="d-flex justify-content-between right-0">
                              <div class="col">
                                 <p class="small">Status:</p>
                                 @if($rm->status_pasien == 'Rawat Jalan')
                                    <p><i class="bi bi-clock-fill pe-1 text-primary"></i> Rawat Jalan</p>
                                 @elseif($rm->status_pasien == 'Jeda')
                                    <p><i class="bi bi-pause-circle-fill pe-1 text-warning"></i> Jeda</p>
                                 @else
                                    <p><i class="bi bi-check-circle-fill pe-1 text-success"></i> Selesai</p>
                                 @endif
                              </div>
                              <div class="d-flex justify-content-end">   
                                 <div class="">
                                    <p class="small">Tanggal Mulai:</p>                  
                                    <p><i class="bi bi-calendar2-check-fill pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($rm->updated_at)) }}</p>
                                 </div>
                              </div> 
                           </div>                      
                        </li>
                     </ul>
                     <div class="card-body d-flex justify-content-between">
                        <div class="row">
                           @if(count($rm->subRekamMedis) == 1)
                              <a href="{{ route('terapi.rekam', [$pasien->slug, $rm->subRekamMedis[0]->id_sub]) }}" class="link-success">
                                 Rekam Terapi 
                                 <i class="bi bi-arrow-right"></i>
                              </a>
                           @else 
                              @foreach($rm->subRekamMedis as $sub)
                                 <a href="{{ route('sub.histori', [$pasien->slug, $sub->id_sub]) }}" class="link-success text-decoration-none">
                                    Rekam Terapi {{ $sub->penyakit }} 
                                    <i class="bi bi-arrow-right"></i>
                                 </a>
                              @endforeach
                           @endif
                        </div>
                        {{-- <div class="row w-100">
                        @if(count($rm_terkini) == 1)                           
                           <a href="{{ route('pasien.rm', $pasien->slug) }}">Rekam Medis</a>
                        @else
                           <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}">Rekam Medis</a>
                        @endif
                     </div> --}}
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      @endif
      @if(count($rm_terdahulu) > 0)
         <h4 class="mt-5 mb-3">Rekam Medis Terdahulu</h4>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-4 g-xxl-3">
            @foreach($rm_terdahulu as $rm) 
            <div class="col mb-4">
               <div class="card shadow-sm card-dulu">
                  <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}" class="card-header text-center"><h6>NO.RM  {{ $rm->id_rekam_medis }}</h6></a>
                  <ul class="list-group list-group-flush text-left list-group-histori">
                     <li class="list-group-item">
                        <p class="small">Penyakit:</p>
                        <p class="text-center">
                           @php
                              $arrayPenyakit = explode(",", $rm->penyakit);
                           @endphp
                           @foreach($arrayPenyakit as $p)
                              <a href="#" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@endif
                           @endforeach
                        </p>
                     </li>
                     <li class="list-group-item d-flex justify-content-start align-items-center">
                        <p class="small">Status:</p>
                           @if($rm->status_pasien == 'Rawat Jalan')
                              <p><i class="bi bi-clock-fill ps-2 text-primary"></i> Rawat Jalan</p>
                           @elseif($rm->status_pasien == 'Jeda')
                              <p><i class="bi bi-pause-circle-fill ps-2 text-warning"></i> Jeda</p>
                           @else
                              <p><i class="bi bi-check-circle-fill ps-2 text-success"></i> Selesai</p>
                           @endif              
                     </li>
                     <li class="list-group-item">
                        <div class="d-flex justify-content-between right-0">
                           <div class="col">
                              <p class="small">Tanggal Mulai:</p>
                              <p><i class="bi bi-calendar-plus pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($rm->created_at)) }}</p>
                           </div>
                           <div class="d-flex justify-content-end">   
                              <div class="">
                                 <p class="small">Tanggal Selesai:</p>                  
                                 <p><i class="bi bi-calendar2-check-fill pe-1 text-secondary"></i> {{ date('d-m-Y', strtotime($rm->updated_at)) }}</p>

                              </div>
                           </div> 
                        </div>                      
                     </li>
                     </ul>
                  <div class="card-body d-flex justify-content-between mx-2">
                     @if(count($rm->subRekamMedis) == 1)
                        <a href="{{ route('terapi.rekam', [$pasien->slug, $rm->subRekamMedis[0]->id_sub]) }}">Rekam Terapi</a>
                     @else
                        @foreach($rm->subRekamMedis as $sub)
                           <a href="{{ route('sub.histori', [$pasien->slug, $sub->id_sub]) }}">Terapi {{ $sub->penyakit }}</a>
                        @endforeach
                     @endif
                     <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}">Rekam Medis</a>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      @endif
   @else
      <div class="alert alert-danger mt-5 p-0 p-2 px-3 col-lg-5">
         <i class="bi bi-exclamation-circle pe-1 fw-semibold"></i>
         Pasien ini tidak memiliki histori rekam medis.
      </div>
   @endif
   <a href="{{ route('rm.create', $pasien->slug) }}" class="btn btn-success" style="position: fixed; bottom: 30px; right: 40px;"><i class="bi bi-file-earmark-plus pe-2"></i>Tambah Rekam Medis</a>
</div>
@endsection