@extends('layouts.auth.main')

@section('container')
<div class="content-container custom-terapi-harian">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Rekam Terapi Harian</h1>
   </div>

    {{-- Data Diri Pasien --}}
    <div class="row g-4 custom-bio">
        <div class="col-lg-2 p-0 pe-sm-3">
            <div class="d-flex align-items-center justify-content-center">
             @if ($pasien->foto)
                <img src="{{ asset('storage/' . $pasien->foto) }}" class="img-thumbnail" alt="...">
             @else
                @if($pasien->jenis_kelamin === 'Laki-Laki')
                   <img src="/img/avatar-l.png" class="img-thumbnail" alt="...">
                @else
                   <img src="/img/avatar-p.png" class="img-thumbnail" alt="...">
                @endif
             @endif
            </div>
          </div>
          <div class="col-lg-7 bg-white px-3 py-2 border border-body-tertiary">
            <table class="table table-borderless table-sm bg-white table-data-diri">
               <thead>
                  <tr>
                    <th></th>
                    <th></th>
                  </tr>
               </thead>
               <tbody class="">
                  <tr>
                     <td>Nama</td>
                     <td>{{ $pasien->nama }}</td>
                  </tr>
                  <tr>
                     <td>No. Telp</td>
                     <td>{{ $pasien->no_telp }}</td>
                  </tr>
                  <tr>
                     <td>Email</td>
                     <td>{{ $pasien->email ? $pasien->email : '-' }}</td>
                  </tr>
                  <tr>
                     <td>Jenis Kelamin</td>
                     <td>{{ $pasien->jenis_kelamin }}</td>
                  </tr>
                  <tr>
                     <td>Umur</td>
                     <td>{{ $umur != 0 ? $umur . ' tahun' : '-'  }}</td>
                  </tr>
                  <tr>
                     <td class="align-top">Pekerjaan</td>
                     <td>{{ $pasien->pekerjaan ? $pasien->pekerjaan : '-' }}</td>
                  </tr>
                  <tr>
                     <td>Alamat</td>
                     <td>{{ $pasien->alamat }}</td>
                  </tr>
            <table class="table table-borderless table-sm m-0 mt-1 table-data-diri table-info-rm">
              <thead>
                 <tr>
                   <th></th>
                   <th></th>
                 </tr>
              </thead>
              <tbody>
                 <tr>
                    <td>ID Pasien</td>
                    <td><span class="bg-body-secondary px-2 rounded-4 border">{{ $pasien->id_pasien }}</span></td>
                 </tr>
                 @if(Request::is('pasien/' . $pasien->slug . '/rekam-medis' . '/*'))
                    @if($rmDetected == 1)
                    <tr class="table-rm-p">
                       <td>No. RM</td>
                       <td class="px-2">{{ $rm->id_rekam_medis }}</td>                  
                    </tr>
                    <tr>
                       <td>Status</td>
                       <td class="px-2">{{ $rm->status_pasien }}</td>                  
                    </tr>
                    @endif
                 @endif
              </tbody>
            </table>
         </div>
        <div class="col-md-3 ps-0 ps-sm-4">
            <table class="w-100 table-data-diri">
                <thead>
                  <tr class="w-100">
                    <th style="width: 45%"></th>
                    <th style="width: 55%"></th>
                  </tr>
                </thead>
                <tbody class="align-top"">
                  <tr>
                      <td style="font-weight:bold">Penyakit</td>
                      <td>{{ $terapi->subRekamMedis->penyakit }}</td>
                  </tr>
                  <tr>
                      <td style="font-weight:bold">Tanggal</td>
                      <td>{{ date('d/m/Y', strtotime($terapi->tanggal)) }}</td>
                  </tr>
                  <tr>
                      <td style="font-weight:bold">Terapi ke</td>
                      <td>{{ $index }}</td>
                  </tr>
                  <tr>
                      <td style="font-weight:bold">Total Terapi</td>
                      <td>{{ $terapi->subRekamMedis->total_terapi}}</td>
                  </tr>
                  <tr>
                      <td style="font-weight:bold">Terapis</td>
                      <td>{{ $terapi->terapis->nama}}</td>
                  </tr>
                  
                </tbody>            
            </table>
        </div>
    </div>
    
    <div class="row mx-0 mx-sm-2">
        <h4 class="fw-semibold mt-4 mt-lg-5 mb-2 ps-0">Keluhan</h4>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->keluhan }}
        </div>
    </div>
    <div class="row mx-0 mx-sm-2">
        <h4 class="fw-semibold mt-4 mt-lg-5 mb-2 ps-0">Deteksi/Pengukuran</h4>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->deteksi }}
        </div>
    </div>
    <div class="row mx-0 mx-sm-2">
        <h4 class="fw-semibold mt-4 mt-lg-5 mb-2 ps-0">Terapi/Tindakan yang Sudah Dilakukan</h4>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->tindakan }}
        </div>
    </div>
    <div class="row mx-0 mx-sm-2">
        <h4 class="fw-semibold mt-4 mt-lg-5 mb-2 ps-0">Saran</h4>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->saran }}
        </div>
    </div>
    <div class="row mx-0 mx-sm-2">
        <h4 class="fw-semibold mt-4 mt-lg-5 mb-2 ps-0">Pra Terapi</h4>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->pra_terapi }}
        </div>
    </div>
    <div class="row mx-0 mx-sm-2">
        <h4 class="fw-semibold mt-4 mt-lg-5 mb-2 ps-0">Post Terapi</h4>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->post_terapi }}
        </div>
    </div>

    @if($userAdmin)
      <div class="d-flex justify-content-between my-5 mx-0 mx-sm-2">
         <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#terapiDeleteModal">
               <i class="bi bi-trash"></i>
               Hapus
         </a>
         <a href="{{ route('terapi.edit', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}" class="btn c-btn-warning px-3 px-sm-4">
            <i class="bi bi-pencil-square"></i>
            Edit
         </a>
      </div>
    @elseif($userKepala)
      <div class="d-flex justify-content-end my-5 mx-0 mx-sm-2">
         <a href="{{ route('terapi.edit', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}" class="btn c-btn-warning px-3 px-sm-4">
            <i class="bi bi-pencil-square"></i>
            Edit
         </a>
      </div>
   @else
      @if($terapi->id_terapis === $userTerapis->id_terapis)
      <div class="mt-5 mx-0 mx-sm-2 text-end">
         <a href="{{ route('terapi.edit', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}" class="btn c-btn-warning px-3 px-sm-4">
            <i class="bi bi-pencil-square"></i>
            Edit
         </a>
      </div>
      @endif
   @endif
      
        
    
    
</div>
@endsection

@section('modal-alert')
    <!-- Terapi Delete Modal-->
    <x-modal-alert 
      id="terapiDeleteModal"
      title="Yakin ingin menghapus data terapi?"
      :body="'<span>Data terapi pada tanggal ini akan dihapus <strong>permanen</strong>!</span>'"
      icon="bi bi-exclamation-circle text-danger"
      >
      <form action="{{ route('terapi.delete', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}" method="post">
         @method('delete')
         @csrf
         <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
      </form>
   </x-modal-alert>
@endsection