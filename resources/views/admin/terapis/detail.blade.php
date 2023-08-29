@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Data Terapis</h1>
   </div>

   {{-- Data Diri terapis --}}
   <div class="row g-4 custom-bio">
      <div class="col-lg-2 p-0 pe-sm-3">
         <div class="d-flex align-items-center justify-content-center">
          @if ($terapis->foto)
             <img src="{{ asset('storage/' . $terapis->foto) }}" class="img-thumbnail" alt="...">
          @else
             @if($terapis->jenis_kelamin === 'Laki-Laki')
                <img src="/img/avatar-l.png" class="img-thumbnail" alt="...">
             @else
                <img src="/img/avatar-p.png" class="img-thumbnail" alt="...">
             @endif
          @endif
         </div>
       </div>
      <div class="col-md-7 bg-white px-3 py-2 border border-body-tertiary text-black">
         <table class="table table-borderless table-sm bg-white table-data-diri">
            <thead>
               <tr>
                 <th></th>
                 <th></th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>Nama</td>
                  <td>{{ $terapis->nama }}</td>
               </tr>
               <tr>
                  <td>Username</td>
                  <td>{{ $terapis->username }}</td>
               </tr>
               <tr>
                  <td>No. Telp</td>
                  <td>{{ $terapis->no_telp }}</td>
               </tr>
               <tr>
                  <td>Jenis Kelamin</td>
                  <td>{{ $terapis->jenis_kelamin }}</td>
               </tr>
               <tr>
                  <td>TTL</td>
                  <td>{{ $tanggal_lahir }}</td>
               </tr>
               <tr>
                  <td>Alamat</td>
                  <td>{{ $terapis->alamat }}</td>
               </tr>
               <tr>
                  <td>Status</td>
                  <td>{{ $terapis->status }}</td>
               </tr>
               <tr>
                  <td>Total Terapi</td>
                  <td class="d-flex align-items-center">
                     <i class="bi bi-heart-pulse-fill text-success pe-1"></i>
                     <span>{{ $terapis->total_terapi }}</span>
                  </td>
               </tr>
            </tbody>            
         </table>
      </div>
      <div class="col-md-3 text-center ">
         <h5>Tingkatan Terapis</h5>
         <div class="d-flex justify-content-center align-center">
            <h5 class="alert alert-light rounded-0 border border-dark-subtle shadow-sm p-3 py-4">
               <i class="bi bi-award-fill text-primary"></i> Terapis {{ $terapis->tingkatan }}   
            </h5>
         </div>
      </div>
   </div>

   <h4 class="mt-5 mb-3">Histori Terapi</h4>
   @if(count($histori_terapi) > 0)
      <table class="table table-bordered">
         <thead>
         <tr class="text-center">
            <th scope="col" style="width: 70px;">No</th>
            <th scope="col" style="">Tanggal</th>
            <th scope="col" style="">Nama Pasien</th>
            <th scope="col" style="width: 150px;">Aksi</th>          
         </tr>
         </thead>
         <tbody>
            @php
               $startIndex = ($histori_terapi->currentPage() - 1) * $histori_terapi->perPage() + 1;
            @endphp
            @foreach ($histori_terapi as $terapi)
               <tr>
                     <th scope="row" class="text-center">{{ $startIndex++ }}</th>
                     <td class="text-center">{{ date('d/m/Y', strtotime($terapi->tanggal)) }}</td>
                     <td>{{ $terapi->subRekamMedis->rekamMedis->pasien->nama }}</td>
                     <td class="text-center">
                        <a href="{{ route('terapi.detail', [$terapi->subRekamMedis->rekamMedis->pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->tanggal]) }}" class="btn btn-sm rounded-2 c-btn-success">
                           <i class="bi bi-eye"></i>               
                        </a>      
                     </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   @else
      <span class="fst-italic">Belum ada histori terapi.</span>
   @endif
   <div class="d-flex justify-content-between my-5 g-4">
      <a type="button" class="btn c-btn-danger" data-toggle="modal" data-target="#terapisDeleteModal">
         <i class="bi bi-trash"></i>
         Hapus
      </a>
      <a href="{{ route('terapis.edit', $terapis->username) }}" class="btn c-btn-warning px-3">
         <i class="bi bi-pencil-square pe-1"></i>
         Edit
     </a>
   </div>

</div>
@endsection

@section('modal-alert')
    <!-- Terapi Delete Modal-->
   <div class="modal fade" id="terapisDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content p-3">
            <div class="modal-header">
                  <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                     <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                     <span>Yakin ingin menghapus terapis?</span>
                  </h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">Semua data terkait Terapis ini akan dihapus <strong>permanen</strong>!
               <br>Hal ini termasuk semua data terapi, terapi, dll.
            </div>
            <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <form action="{{ route('terapis.delete', $terapis->username) }}" method="post">
                     @method('delete')
                     @csrf
                     <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                  </form>
            </div>
         </div>
      </div>
   </div>
@endsection
