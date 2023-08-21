@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Rekam Terapi</h1>
   </div>

    {{-- Data Diri Pasien --}}
    <div class="row g-4">
        <div class="col-md-2" style="max-height: 214px; overflow: hidden;">
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
        <div class="col-md-7 bg-white px-3 py-2 border border-body-tertiary text-black">
        <table class="table table-borderless table-sm bg-white table-data-diri">
            <thead>
                <tr>
                <th style="width: 20%"></th>
                <th style="width: 80%"></th>
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
        <div class="col-md-3 ps-4">
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
    
    <div class="row mt-5 mb-3 mx-2">
        <h5 class="ps-0">Keluhan</h5>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->keluhan }}
        </div>
    </div>
    <div class="row mt-5 mb-3 mx-2">
        <h5 class="ps-0">Deteksi/Pengukuran</h5>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->deteksi }}
        </div>
    </div>
    <div class="row mt-5 mb-3 mx-2">
        <h5 class="ps-0">Terapi/Tindakan yang Sudah Dilakukan</h5>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->tindakan }}
        </div>
    </div>
    <div class="row mt-5 mb-3 mx-2">
        <h5 class="ps-0">Saran</h5>
        <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 100px">
            {{ $terapi->saran }}
        </div>
    </div>

    <div class="d-flex justify-content-between my-5 mx-2">
        <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#terapiDeleteModal">
            <i class="bi bi-trash"></i>
            Hapus
        </a>
        <a href="{{ route('terapi.edit', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->tanggal]) }}" class="btn btn-warning px-4">
            <i class="bi bi-pencil-square"></i>
            Edit
        </a>
    </div>
    
</div>
@endsection

@section('modal-alert')
    <!-- Terapi Delete Modal-->
   <div class="modal fade" id="terapiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content p-3">
            <div class="modal-header">
                  <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                     <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                     <span>Yakin ingin menghapus data terapi?</span>
                  </h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">Data terapi pada tanggal ini akan dihapus <strong>permanen</strong>!</div>
            <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <form action="{{ route('terapi.delete', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->tanggal]) }}" method="post">
                     @method('delete')
                     @csrf
                     <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                  </form>
            </div>
         </div>
      </div>
   </div>
@endsection