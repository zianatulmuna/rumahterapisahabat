@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      @if(Request::is('admin/pasien/' . $pasien->slug . '/rekam-medis*'))
         <h1 class="h2">Histori Rekam Medis</h1>
      @elseif(Request::is('admin/pasien/'. $pasien->slug))
         <h1 class="h2">Data Pasien</h1>
      @elseif(Request::is('admin/pasien/' . $pasien->slug . '/rekam*'))
         <h1 class="h2">Histori Rekam Terapi</h1>
      @endif
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')

   @if($rmDetected == 1)          
      {{-- Data Layanan --}}
      <h4 class="mt-4 mt-lg-5 mb-3">Rencana Layanan Terapi</h4>
      <div class="row row-cols-1 row-cols-lg-2 g-6">
         <div class="col">
            <table class="table table-bordered table-sm table-top m-0 bg-white">
               <tr>
                  <td class="px-2 col-5 col-sm-4">Tempat Layanan</td>
                  <td class="px-2">{{ $rm->tempat_layanan }}</td>
               </tr>
               <tr>
                  <td class="px-2">Sistem Layanan</td>
                  <td class="px-2">{{ $rm->sistem_layanan }}</td>
               </tr>
               <tr>
                  <td class="px-2">Jumlah Layanan</td>
                  <td class="px-2">{{ $rm->jumlah_layanan }}</td>
               </tr>
               <tr>
                  <td class="px-2">Jadwal Layanan</td>
                  <td class="px-2">{{ $rm->jadwal_layanan }}</td>
               </tr>
            </table>
         </div>
         <div class="col">
            <table class="table table-bordered table-sm table-top m-0 mt-4 mt-lg-0 bg-white">
               <tr>
                  <td class="px-2 col-5 col-sm-4">Tipe Pembayaran</td>
                  <td class="px-2">{{ $rm->tipe_pembayaran }}</td>
               </tr>
               <tr>
                  <td class="px-2">Penanggungjawab</td>
                  <td class="px-2">{{ $rm->penanggungjawab }}</td>
               </tr>
               <tr>
                  <td class="px-2">Biaya Pembayaran</td>
                  <td class="px-2">{{ $rm->biaya_pembayaran }}</td>
               </tr>
               <tr>
                  <td class="px-2">Status Pasien</td>
                  <td class="px-2">{{ $rm->status_pasien }}</td>
               </tr>
               <tr>
                  <td class="px-2">Status Terapi</td>
                  <td class="px-2">{{ $rm->status_terapi }}</td>
               </tr>
            </table>
         </div>      
      </div>
      
      <div class="row row-cols-1 row-cols-lg-2 g-6">
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Penyakit</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 60px">
               @php
                  $arrayPenyakit = explode(",", $rm->penyakit);
               @endphp
               @foreach($arrayPenyakit as $p)
                  <a href="#" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@endif
               @endforeach
            </div>
         </div>
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Keluhan</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary"  style="min-height: 60px">
               <p>{{ $rm->keluhan }}</p>
            </div>
         </div>
      </div>

      <div class="row row-cols-1 row-cols-lg-2 g-6">
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Data Deteksi</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 140px">
               <p>{{ $rm->data_deteksi }}</p>
            </div>
         </div>
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Catatan Terapis</h4>
            <table class="table table-bordered border-body-tertiary table-sm table-top bg-white">
               <tr>
                  <td class="px-2 col-2">Fisik</td>
                  <td class="px-2">{{ $rm->catatan_fisik }}</td>
               </tr>
               <tr>
                  <td class="px-2">Bioplasmatik</td>
                  <td class="px-2">{{ $rm->catatan_bioplasmatik }}</td>
               </tr>
               <tr>
                  <td class="px-2">Psikologis</td>
                  <td class="px-2">{{ $rm->catatan_psikologis }}</td>
               </tr>
               <tr>
                  <td class="px-2">Rohani</td>
                  <td class="px-2">{{ $rm->catatan_rohani }}</td>
               </tr>
            </table>
         </div>
      </div>
   @elseif($rmDetected == 0) 
      <div class="alert alert-warning my-5 p-0 p-2 px-3 col-lg-5">
         <i class="bi bi-exclamation-circle"></i>
         Tidak ada rekam medis yang aktif. 
         <a href="{{ route('rm.histori', $pasien->slug) }}" class="alert-link">Lihat Histori</a>
      </div>
   @else
      <div class="alert alert-success my-5 p-0 p-2 px-3 col-lg-6">
         <i class="bi bi-exclamation-octagon"></i>
         Ada lebih dari 1 rekam medis aktif. Pilih di
         <a href="{{ route('rm.histori', $pasien->slug) }}" class="alert-link">Histori Rekam Medis</a>
      </div>
   @endif

   @if($rmDetected == 1) 
      <div class="d-flex justify-content-between my-5 g-4">
         <a href="" class="btn btn-outline-danger py-1 px-2 py-sm-2 px-sm-3" data-toggle="modal" data-target="#pasienDeleteModal"><i class="bi bi-exclamation-triangle"></i> Hapus Pasien</a>
         <div class="d-flex justify-content-end pe-lg-1">
            <a type="button" class="btn c-btn-danger py-1 px-2 px-sm-3 py-sm-2 mx-2 mx-sm-3" data-toggle="modal" data-target="#rmDeleteModal"><i class="bi bi-trash"></i> Hapus</a>
            <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="btn c-btn-warning  py-1 px-2 py-sm-2 px-sm-3 ml-3"><i class="bi bi-pencil-square pe-lg-1"></i> Edit</a>
         </div>
      </div>
   @else
      <a href="{{ route('pasien.delete', $pasien->slug) }}" class="btn btn-warning py-1 px-2 py-sm-2 px-sm-3" data-toggle="modal" data-target="#pasienDeleteModal"><i class="bi bi-exclamation-triangle-fill"></i> Hapus Pasien</a>
   @endif
</div>
@endsection

@section('modal-alert')   
   <!-- Pasien Delete Modal-->
   <div class="modal fade" id="pasienDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content p-3">
            <div class="modal-header">
                  <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                     <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                     <span>Yakin ingin menghapus Pasien?</span>
                  </h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">Semua data terkait pasien ini akan dihapus <strong>permanen</strong>! 
               <br>Hal ini termasuk semua data rekam medis, terapi, jadwal, dll.</div>
            <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <form action="{{ route('pasien.delete', $pasien->slug) }}" method="post">
                     @method('delete')
                     @csrf
                     <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                  </form>
            </div>
         </div>
      </div>
   </div>

   @if($rmDetected == 1)
      <!-- RM Delete Modal-->
      <div class="modal fade" id="rmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content p-3">
               <div class="modal-header">
                  <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                     <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                     <span>Yakin ingin menghapus Rekam Medis?</span>
                  </h5>
                  <h5 class="modal-title" id="exampleModalLabel"></h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body py-4">Semua data terkait rekam medis ini akan dihapus <strong>permanen</strong>! 
                  <br>Hal ini termasuk semua data terapi, jadwal, dll.</div>
               <div class="modal-footer">
                     <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                     <form action="{{ route('rm.delete', [$pasien->slug, $rm->id_rekam_medis]) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                     </form>
               </div>
            </div>
         </div>
      </div>
   @endif
@endsection
