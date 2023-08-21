<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/assets/icon_klinik.png">
    <title>Dashboard Admin</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Bootstrap icon -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}

    <!-- Custom styles -->
    <link href="/css/styles.css" rel="stylesheet">
    <style>
      body {
         width: 800px;
      }
    </style>
  </head>

<body>
   <div class="content-container">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
            <h1 class="h2">Data Pasien</h1>
      </div>

      {{-- Data Diri Pasien --}}
   <div class="row g-4 custom-bio">
      <div class="col-lg-2">
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
      <div class="col-lg-8 bg-white px-3 py-2 border border-body-tertiary">
         <table class="table table-borderless table-sm bg-white table-data-diri">
            <thead>
               <tr>
               {{-- <th style="width: 20%"></th>
               <th style="width: 80%"></th> --}}
               <th></th>
               <th></th>
               </tr>
            </thead>
            <tbody>
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
                  <td>{{ $pasien->email }}</td>
               </tr>
               <tr>
                  <td>Jenis Kelamin</td>
                  <td>{{ $pasien->jenis_kelamin }}</td>
               </tr>
               <tr>
                  <td>Umur</td>
                  <td>{{ $umur }} tahun</td>
               </tr>
               <tr>
                  <td>Pekerjaan</td>
                  <td>{{ $pasien->pekerjaan }}</td>
               </tr>
               <tr>
                  <td>Alamat</td>
                  <td>{{ $pasien->alamat }}</td>
               </tr>
               <tr class="fw-semibold">
                  <td>ID Pasien</td>
                  <td>{{ $pasien->id_pasien }}</td>
               </tr>
               @if(Request::is('admin/pasien/' . $pasien->slug))
               @if($rmDetected == 1)
                  <tr class="fw-semibold">
                     <td>No. RM</td>
                     <td>{{ $rm->id_rekam_medis }}</td>                  
                  </tr>
                  <tr>
                     <td>Status</td>
                     <td>{{ $rm->status_pasien }}</td>                  
                  </tr>
               @endif
               @endif
            </tbody>            
         </table>
      </div>
   </div>

         {{-- Data Layanan --}}
         <h4 class="mt-4 mt-lg-5 mb-3">Rencana Layanan Terapi</h4>
         <div class="row row-cols-1 row-cols-lg-2 g-6">
            <div class="col">
               <table class="table table-bordered table-sm table-top m-0 bg-white">
                  <tr>
                     <td class="px-2 col-5 col-lg-4">Tempat Layanan</td>
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
                     <td class="px-2 col-5 col-lg-4">Tipe Pembayaran</td>
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
   </div>

   <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script> <!--dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>