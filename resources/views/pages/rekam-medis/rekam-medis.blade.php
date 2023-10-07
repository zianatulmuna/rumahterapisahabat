@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">
      @if(Request::is('pasien/' . $pasien->slug . '/rekam-medis*'))
         Detail Rekam Medis
      @elseif(Route::is('pasien.rm'))
         Rekam Medis
      @endif
      </h1>
      @if($rm && $isAllowed)
         <a href="{{ route('rm.print', [$pasien->slug, $rm->id_rekam_medis]) }}" target="_blank" class="btn btn-success btn-sm rounded-3 mb-2">
            <i class="bi bi-download pe-1"></i> Unduh
         </a>
      @endif
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')

   @if($rm && $isAllowed)          
      {{-- Data Layanan --}}
      <h4 class="mt-4 mt-lg-5 mb-3">Rencana Layanan Terapi</h4>
      <div class="row row-cols-1 row-cols-lg-2">
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
               @if($rm->is_private)
               <tr>
                  <td class="px-2">Terapis<i class="bi bi-person-fill-lock small ps-2 text-secondary"></i></td>
                  <td class="px-2">{{ $rm->terapis->nama}}</td>
               </tr>
               @endif
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
                  <td class="px-2">Jumlah Bayar</td>
                  <td class="px-2">{{ $rm->jumlah_bayar }}</td>
               </tr>               
               <tr>
                  <td class="px-2">Status Terapi</td>
                  <td class="px-2">{{ $rm->status_terapi }}</td>
               </tr>
               @if ($rm->ket_status)
                  <tr>
                     <td class="px-2">Ket. Jeda/Selesai</td>
                     <td class="px-2">{!! $rm->ket_status !!}</td>
                  </tr>
               @endif
            </table>
         </div>      
      </div>
      
      <div class="row row-cols-1 row-cols-lg-2">
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Penyakit</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 60px">
               @php
                  $arrayPenyakit = explode(",", $rm->penyakit);
               @endphp
               @foreach($arrayPenyakit as $p)
                  <a href="/rekam-terapi/tag?search={{ $p }}" target="_blank" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@endif
               @endforeach
            </div>
         </div>
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Keluhan</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary"  style="min-height: 60px">
               <p>{!! $rm->keluhan !!}</p>
            </div>
         </div>
      </div>

      <div class="row row-cols-1 row-cols-lg-2">
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Data Deteksi</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 140px">
               <p>{!! $rm->data_deteksi !!}</p>
            </div>
         </div>
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Catatan Terapis</h4>
            <table class="table table-bordered border-body-tertiary table-sm table-top bg-white">
               <tr>
                  <td class="px-2 col-2">Fisik</td>
                  <td class="px-2">{!! $rm->catatan_fisik !!}</td>
               </tr>
               <tr>
                  <td class="px-2">Bioplasmatik</td>
                  <td class="px-2">{!! $rm->catatan_bioplasmatik !!}</td>
               </tr>
               <tr>
                  <td class="px-2">Psikologis</td>
                  <td class="px-2">{!! $rm->catatan_psikologis !!}</td>
               </tr>
               <tr>
                  <td class="px-2">Rohani</td>
                  <td class="px-2">{!! $rm->catatan_rohani !!}</td>
               </tr>
            </table>
         </div>
      </div>

      <div class="row row-cols-1 row-cols-lg-2">
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Target Terapi</h4>
            <table class="table table-bordered border-body-tertiary table-sm table-top bg-white">
               <tr>
                  <td class="px-2 col-5 col-sm-4">Kondisi Awal</td>
                  <td class="px-2">{!! $rm->kondisi_awal !!}</td>
               </tr>
               <tr>
                  <td class="px-2">Target Akhir</td>
                  <td class="px-2">{!! $rm->target_akhir !!}</td>
               </tr>
            </table>
         </div>
         <div class="col">
            <h4 class="mt-4 mt-lg-5 mb-3">Kesimpulan</h4>
            <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 65px">
               <p>{!! $rm->kesimpulan !!}</p>
            </div>
         </div>
         
      </div>
   @else
      <div class="alert {{ $isAllowed ? 'alert-warning' : 'alert-secondary' }} mt-5 p-0 p-2 px-3 d-inline-flex col-sm-7 col-lg-5">
         @if($isAllowed)
            <i class="bi bi-exclamation-circle pe-2"></i> Tidak ada rekam medis yang aktif.
            <a href="{{ route('rm.histori', $pasien->slug) }}" class="alert-link ps-2">Lihat Histori</a>
         @else 
            <i class="bi bi-lock-fill pe-2 text-secondary"></i>
            Anda tidak memiliki akses.
         @endif
      </div>
   @endif

   @if($userAdmin || $userKepala)
      @if($rm) 
         <div class="d-flex justify-content-between mb-3 mt-5 g-4">
            <a href="" class="btn btn-outline-danger py-1 px-2 py-sm-2 px-sm-3" data-toggle="modal" data-target="#pasienDeleteModal"><i class="bi bi-exclamation-triangle"></i> Hapus Pasien</a>
            <div class="d-flex justify-content-end pe-lg-1">
               <a type="button" class="btn c-btn-danger py-1 px-2 px-sm-3 py-sm-2 mx-2 mx-sm-3" data-toggle="modal" data-target="#rmDeleteModal"><i class="bi bi-trash"></i> Hapus</a>
               <a href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="btn c-btn-warning  py-1 px-2 py-sm-2 px-sm-3 ml-3"><i class="bi bi-pencil-square pe-lg-1"></i> Edit</a>
            </div>
         </div>
      @else
      <div class="d-flex mt-5">
         <a href="" class="btn btn-outline-danger py-1 px-2 py-sm-2 px-sm-3" data-toggle="modal" data-target="#pasienDeleteModal"><i class="bi bi-exclamation-triangle"></i> Hapus Pasien</a>
      </div>
      @endif
   @endif

</div>
@endsection

@section('modal-alert')  
   <!-- Pasien Delete Modal--> 
   <x-modal-alert 
      id="pasienDeleteModal"
      title="Yakin ingin hapus Pasien?"
      :body="'<span>Semua data terkait pasien ini akan dihapus <strong>permanen</strong>! 
         <br>Hal ini termasuk semua data rekam medis, terapi, jadwal, dll.</span>'"
      icon="bi bi-exclamation-circle text-danger"
      >
      <form action="{{ route('pasien.delete', $pasien->slug) }}" method="post">
         @method('delete')
         @csrf
         <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
      </form>
   </x-modal-alert>

   @if($rm)
      <!-- RM Delete Modal-->
      <x-modal-alert 
         id="rmDeleteModal"
         title="Yakin ingin hapus Rekam Medis?"
         :body="'<span>Semua data terkait rekam medis ini akan dihapus <strong>permanen</strong>! 
            <br>Hal ini termasuk semua data terapi, jadwal, dll.</span>'"
         icon="bi bi-exclamation-circle text-danger"
         >
         <form action="{{ route('rm.delete', [$pasien->slug, $rm->id_rekam_medis]) }}" method="post">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
         </form>
      </x-modal-alert>
   @endif
@endsection
