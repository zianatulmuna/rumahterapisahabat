@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Histori Rekam Terapi</h1>
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')
   
   @if($rmDetected == 1)
      <h4 class="mt-5 mb-3">Rekam Terapi Terkini</h4>
      @if($rm)
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4">
            @if(count($rm->subRekamMedis) > 0)
               @foreach($rm->subRekamMedis as $sub)
                  @if($userAdmin || $userKepala || !$rm->is_private || ($userTerapis && !$userKepala && $rm->is_private && $rm->id_terapis == $userTerapis->id_terapis))
                     <div class="col mb-4">
                        <div class="card shadow-sm">
                           <h6 class="card-header bg-success text-white fw-bold text-center">{{ $sub->penyakit }}</h6>
                           <ul class="list-group list-group-flush text-left list-group-histori">
                              <li class="list-group-item">
                                 <div class="d-flex justify-content-between right-0">
                                    <div class="col">
                                       <p class="small">NO. RM:</p>
                                       <p>{{ $sub->id_rekam_medis }}</p>
                                    </div>
                                    <div class="d-flex justify-content-end">   
                                       <div class="" style="min-width: 114px">
                                          <p class="small">Total Terapi:</p>
                                          <p class="align-center"><i class="bi bi-heart-pulse-fill text-success pe-2"></i>{{ $sub->total_terapi }}/{{ $rm->jumlah_layanan }}</p>
                                       </div>
                                    </div> 
                                 </div>                      
                              </li>
                              <li class="list-group-item">
                                 <div class="d-flex justify-content-between right-0">
                                    <div class="col">
                                       @php
                                          if(count($sub->rekamTerapi) > 0) {
                                             $m = $sub->rekamTerapi()->orderBy('tanggal', 'ASC')->first();
                                             $mulai = date('d-m-Y', strtotime($m->tanggal));
                                          } else {
                                             $mulai = '-';
                                          }
                                       @endphp
                                       <p class="small">Tanggal Mulai:</p>
                                       <p><i class="bi bi-calendar-plus pe-1 text-light-emphasis"></i> {{ $mulai }}</p>
                                    </div>
                                    <div class="d-flex justify-content-end">   
                                       <div class="" style="min-width: 114px">
                                          @php
                                             if(count($sub->rekamTerapi) > 0) {
                                                $m = $sub->rekamTerapi()->orderBy('tanggal', 'DESC')->first();
                                                $akhir = date('d-m-Y', strtotime($m->tanggal));
                                             } else {
                                                $akhir = '-';
                                             }
                                          @endphp
                                          <p class="small">Tanggal Terkini:</p>                  
                                          <p><i class="bi bi-calendar-check pe-1 text-light-emphasis"></i> {{ $akhir }}</p>
                                       </div>
                                    </div> 
                                 </div>                      
                              </li>
                           </ul>
                           <div class="card-body d-flex justify-content-between mx-2">
                              <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}" class="link-success">Rekam Terapi</a>
                              <a href="{{ route('pasien.rm', $pasien->slug) }}" class="link-success">Rekam Medis</a>
                           </div>
                        </div>
                     </div>
                  @else
                     <div class="col mb-4">
                        <div class="card shadow-sm bg-body-tertiary" style="min-height: 200px;">
                           <div class="bi bi-lock pe-2 fs-3 m-auto text-secondary"></div>
                        </div>
                     </div>                 
                  @endif
               @endforeach
            @else
            <div class="w-100">
               <div class="alert alert-warning hstack gap-1 p-2 px-3 d-inline-flex">
                  <i class="bi bi-exclamation-circle pe-1 fw-semibold"></i>
                  <p class="m-0">Data rekam terapi telah dihapus. 
                     @if($userAdmin || $userKepala)
                        Tambahkan penyakit pada Rekam Medis <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.
                     @endif
                  </p>
               </div>
            </div>
            @endif
         </div>
      @else
         <div class="alert alert-warning d-inline-flex p-0 p-2 px-3 mb-4">
            <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
            Pasien ini tidak memiliki histori rekam medis aktif.
         </div>
      @endif
      @if(count($rm_terdahulu) > 0)
         <h4 class="mt-4 mb-3">Rekam Terapi Terdahulu</h4>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4">
            @php
                $countSub = 0;
            @endphp
         @foreach($rm_terdahulu as $rm)
            @foreach($rm->subRekamMedis as $sub)
               @if($userAdmin || $userKepala || !$rm->is_private || ($userTerapis && !$userKepala && $rm->is_private && $rm->id_terapis == $userTerapis->id_terapis))
                  <div class="col mb-4">
                     <div class="card shadow-sm">
                        <h6 class="card-header bg-nonaktif fw-bold text-center">{{ $sub->penyakit }}</h6>
                        <ul class="list-group list-group-flush text-left list-group-histori">
                           <li class="list-group-item">
                              <div class="d-flex justify-content-between right-0">
                                 <div class="col">
                                    <p class="small">NO. RM:</p>
                                    <p>{{ $sub->id_rekam_medis }}</p>
                                 </div>
                                 <div class="d-flex justify-content-end">   
                                    <div class="" style="min-width: 114px">
                                       <p class="small">Total Terapi:</p>
                                       <p class="align-center"><i class="bi bi-heart-pulse-fill text-success pe-2"></i>{{ $sub->total_terapi }}/{{ $rm->jumlah_layanan }}</p>
                                    </div>
                                 </div> 
                              </div>                      
                           </li>
                           <li class="list-group-item">
                              <div class="d-flex justify-content-between right-0">
                                 <div class="col">
                                    @php
                                       if(count($sub->rekamTerapi) > 0) {
                                          $m = $sub->rekamTerapi()->orderBy('tanggal', 'ASC')->first();
                                          $mulai = date('d-m-Y', strtotime($m->tanggal));
                                       } else {
                                          $mulai = '-';
                                       }
                                    @endphp
                                    <p class="small">Tanggal Mulai:</p>
                                    <p><i class="bi bi-calendar-plus pe-1 text-light-emphasis"></i> {{ $mulai }}</p>
                                 </div>
                                 <div class="d-flex justify-content-end">   
                                    <div class="">
                                       @php
                                          if(count($sub->rekamTerapi) > 0) {
                                             $m = $sub->rekamTerapi()->orderBy('tanggal', 'DESC')->first();
                                             $akhir = date('d-m-Y', strtotime($m->tanggal));
                                          } else {
                                             $akhir = '-';
                                          }
                                       @endphp
                                       <p class="small">Tanggal Selesai:</p>                  
                                       <p><i class="bi bi-calendar-check pe-1 text-light-emphasis"></i> {{ $akhir }}</p>
                                    </div>
                                 </div> 
                              </div>                      
                           </li>
                        </ul>
                        <div class="card-body d-flex justify-content-between mx-2">
                           <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}" class="link-success">Rekam Terapi</a>
                           <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}" class="link-success">Rekam Medis</a>
                        </div>
                     </div>
                  </div>
               @else
                  <div class="col mb-4">
                     <div class="card shadow-sm bg-body-tertiary" style="min-height: 200px;">
                        <div class="bi bi-lock pe-2 fs-3 m-auto text-secondary"></div>
                     </div>
                  </div>
               @endif
               @php
                  $countSub++;
               @endphp
            @endforeach
         @endforeach
         </div>
         @if($countSub == 0)
         <div class="w-100">
            <div class="alert alert-secondary hstack gap-1 p-2 px-3 d-inline-flex">
               <i class="bi bi-exclamation-circle pe-1 fw-semibold"></i>
               <p class="m-0">Data rekam terapi telah dihapus. 
                  @if($userAdmin || $userKepala)
                     Tambahkan penyakit pada Rekam Medis <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.
                  @endif
               </p>
            </div>
         </div>
         @endif
      @endif
   @else
      <div class="alert alert-danger d-inline-flex mt-5 p-0 p-2 px-3">
         <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
         Pasien ini tidak memiliki histori rekam terapi.
         @if($userAdmin || $userKepala)
            <a href="{{ route('rm.create', $pasien->slug) }}" class="alert-link ps-2">Tambah Rekam Medis</a>
         @endif
      </div>
   @endif
</div>
@endsection