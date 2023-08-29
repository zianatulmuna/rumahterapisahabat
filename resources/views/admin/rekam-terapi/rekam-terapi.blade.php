@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Rekam Terapi</h1>
   </div>

   {{-- Data Diri Pasien --}}
   @include('partials.data-diri')

   <div class="row row-cols-1 row-cols-lg-2 g-6">
        <div class="col">
        <h4 class="mt-4 mt-lg-5 mb-3">Penyakit</h4>
        <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 60px">
                <a href="#" class="link-secondary link-underline-light">{{ $sub->penyakit }}</a>
        </div>
        </div>
        <div class="col">
        <h4 class="mt-4 mt-lg-5 mb-3">Keluhan</h4>
        <div class="bg-white px-3 py-2 border border-body-tertiary"  style="min-height: 60px">
            <p>{{ $sub->rekamMedis->keluhan }}</p>
        </div>
        </div>
    </div>

    <h4 class="mt-4 mt-lg-5 mb-3" id="rekamTerapi">Histori Terapi</h4>
    @if(count($rekam_terapi) > 0)
        <div class="overflow-auto">
            <table class="table table-bordered text-center"  style="min-width: 420px;">
                <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Terapi</th>
                    <th scope="col">Terapis</th>
                    <th scope="col">Pra Terapi</th>
                    <th scope="col" style="min-width: 90px;">Aksi</th>
                </tr>
                </thead>
                <tbody>            
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($rekam_terapi as $terapi)
                        <tr>
                            <th scope="row" style="max-width: 50px">{{ $i++ }}</th>
                            <td style="width: 200px">{{ date('d/m/Y', strtotime($terapi->tanggal)) }}</td>
                            <td class="text-capitalize">{{ $terapi->terapis->username }}</td>
                            <td>{{ $terapi->pra_terapi }}</td>
                            <td style="width: 130px">
                                <a href="" class="c-badge c-bg-info">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="{{ route('terapi.detail', [$pasien->slug, $sub->id_sub, $terapi->tanggal]) }}" class="c-badge c-bg-success ms-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>                
                    @endforeach
                        
                </tbody>
            </table>
        </div>
    @else
      <span class="fst-italic">Belum ada histori terapi.</span>
    @endif
    <div class="d-flex justify-content-between my-5 gap-3">
        <a type="button" class="btn c-btn-danger" data-toggle="modal" data-target="#terapiDeleteModal">
            <i class="bi bi-trash"></i>
            Hapus
        </a>
        <a href="{{ route('terapi.tambah', [$pasien->slug, $sub->id_sub]) }}" class="btn btn-primary">
            <i class="bi bi-plus-square pe-2"></i>
            Tambah
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
                     <span>Yakin ingin menghapus rekam terapi?</span>
                  </h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">Semua data terkait rekam terapi untuk penyakit ini akan dihapus <strong>permanen</strong>! Hal ini termasuk semua data terapi harian.
            </div>
            <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <form action="{{ route('sub.delete', [$pasien->slug, $sub->id_sub]) }}" method="post">
                     @method('delete')
                     @csrf
                     <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                  </form>
            </div>
         </div>
      </div>
   </div>
@endsection

@push('script')
    @if(session()->has('success'))
    <script>
        window.onload = function() {
            window.location.hash = 'rekamTerapi';
        };
    </script>
    @endif    
@endpush