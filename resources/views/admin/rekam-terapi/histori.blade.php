@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Histori Rekam Terapi</h1>
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')
   
   @if($rmDetected == 1)
      @if(count($rm_terkini) > 0) 
         <h4 class="mt-5 mb-3">Rekam Terapi Terkini</h4>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4">
            @foreach($rm_terkini as $rm)
               @if(count($rm->subRekamMedis) > 0)
                  @foreach($rm->subRekamMedis as $sub)
                     <div class="col mb-4">
                        <div class="card shadow-sm">
                           <h6 class="card-header bg-success text-white text-center">{{ $sub->penyakit }}</h6>
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
                  @endforeach
               @else
               <div class="w-100">
                  <div class="alert alert-warning hstack gap-1 p-2 px-3 d-inline-flex">
                     <i class="bi bi-exclamation-circle pe-1 fw-semibold"></i>
                     <p class="m-0">Data rekam terapi telah dihapus. Tambahkan penyakit pada Rekam Medis
                     <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.</p>
                  </div>
               </div>
               @endif
            @endforeach
         </div>
      @endif
      @if(count($rm_terdahulu) > 0)
         <h4 class="mt-4 mb-3">Rekam Terapi Terdahulu</h4>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4">
            @foreach($rm_terdahulu as $rm)
                  @foreach($rm->subRekamMedis as $sub)
                  <div class="col mb-4">
                     <div class="card shadow-sm">
                        <h6 class="card-header bg-secondary text-white text-center">{{ $sub->penyakit }}</h6>
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
                                          $mulai = $m->tanggal;
                                       } else {
                                          $mulai = '-';
                                       }
                                    @endphp
                                    <p class="small">Tanggal Mulai:</p>
                                    <p><i class="bi bi-calendar-plus pe-1 text-light-emphasis"></i> {{ date('d-m-Y', strtotime($mulai)) }}</p>
                                 </div>
                                 <div class="d-flex justify-content-end">   
                                    <div class="">
                                       @php
                                          if(count($sub->rekamTerapi) > 0) {
                                             $m = $sub->rekamTerapi()->orderBy('tanggal', 'DESC')->first();
                                             $akhir = $m->tanggal;
                                          } else {
                                             $akhir = '-';
                                          }
                                       @endphp
                                       <p class="small">Tanggal Selesai:</p>                  
                                       <p><i class="bi bi-calendar-check pe-1 text-light-emphasis"></i> {{ date('d-m-Y', strtotime($akhir)) }}</p>
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