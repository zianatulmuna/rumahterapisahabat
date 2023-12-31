@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between align-items-center border-bottom mb-4 pb-2">
      <h1 class="h2">Rekam Terapi</h1>
      @if (
          !$rm->is_private ||
              $userAdmin ||
              $userKepala ||
              ($userTerapis && !$userKepala && $userTerapis->id_terapis == $rm->id_terapis))
        <a href="{{ route('rekam.print', [$pasien->slug, $sub->id_sub]) }}" target="_blank"
          class="btn btn-success btn-sm rounded-3 mb-2">
          <i class="bi bi-download pe-1"></i> Unduh
        </a>
      @endif
    </div>

    {{-- Data Diri Pasien --}}
    @include('partials.data-diri')

    @if (
        !$rm->is_private ||
            $userAdmin ||
            $userKepala ||
            ($userTerapis && !$userKepala && $userTerapis->id_terapis == $rm->id_terapis))

      <div class="row row-cols-1 row-cols-lg-2 g-6">
        <div class="col">
          <h4 class="mt-lg-5 mb-3 mt-4">Penyakit</h4>
          <div class="border-body-tertiary border bg-white px-3 py-2" style="min-height: 60px">
            <a href="/rekam-terapi/tag?search={{ $sub->penyakit }}"
              class="link-dark link-underline-light">{{ $sub->penyakit }}</a>
          </div>
        </div>
        <div class="col">
          <h4 class="mt-lg-5 mb-3 mt-4">Keluhan</h4>
          <div class="border-body-tertiary border bg-white px-3 py-2" style="min-height: 60px">
            {!! $sub->rekamMedis->keluhan !!}
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-lg-5 mb-3 mt-4">
        <h4 class="mb-0" id="rekamTerapi">Histori Terapi</h4>
        @if (count($rekam_terapi) > 0)
          <a href="{{ route('sub.print', [$pasien->slug, $sub->id_sub]) }}" target="_blank"
            class="c-badge c-badge-successboot">
            <i class="bi bi-download pe-1"></i> Unduh Semua
          </a>
        @else
          <div class=""></div>
        @endif
      </div>
      @if (count($rekam_terapi) > 0)
        <div class="overflow-auto">
          <table class="table-bordered table text-center" style="min-width: 420px;">
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
                  <td class="text-capitalize">{{ str_replace(['.', '-', '_'], ' ', $terapi->terapis->username) }}</td>
                  <td>{!! $terapi->pra_terapi !!}</td>
                  <td style="width: 130px">
                    <a href="{{ route('terapi.print', [$pasien->slug, $sub->id_sub, $terapi->id_terapi]) }}"
                      target="_blank" class="c-badge c-badge-info">
                      <i class="bi bi-download"></i>
                    </a>
                    <a href="{{ route('terapi.detail', [$pasien->slug, $sub->id_sub, $terapi->id_terapi]) }}"
                      class="c-badge c-badge-success ms-1">
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

      @if ($userAdmin || $userKepala)
        <div class="d-flex justify-content-between mb-3 mt-4 gap-3">
          <a type="button" class="btn c-btn-danger" data-toggle="modal" data-target="#terapiDeleteModal">
            <i class="bi bi-trash"></i>
            Hapus
          </a>
          <a href="{{ route('terapi.tambah', [$pasien->slug, $sub->id_sub]) }}" class="btn btn-primary">
            <i class="bi bi-plus-square pe-2"></i>
            Tambah
          </a>
        </div>
      @elseif($userTerapis)
        <div class="d-flex justify-content-end mb-3 mt-4">
          <a href="{{ route('terapi.tambah', [$pasien->slug, $sub->id_sub]) }}" class="btn btn-primary">
            <i class="bi bi-plus-square pe-2"></i>
            Tambah
          </a>
        </div>
      @endif
    @else
      <div class="alert alert-secondary d-inline-flex col-sm-7 col-lg-5 mt-5 p-0 p-2 px-3">
        <i class="bi bi-lock-fill text-secondary pe-2"></i>
        Anda tidak memiliki akses.
      </div>
    @endif
  </div>
@endsection

@section('modal-alert')
  <!-- Terapi Delete Modal-->
  <x-modal-alert id="terapiDeleteModal" title="Yakin ingin menghapus rekam terapi?" :body="'<span>Semua data terkait rekam terapi untuk penyakit ini akan dihapus <strong>permanen</strong>! Hal ini termasuk semua data terapi harian.</span>'"
    icon="bi bi-exclamation-circle text-danger">
    <form action="{{ route('sub.delete', [$pasien->slug, $sub->id_sub]) }}" method="post">
      @method('delete')
      @csrf
      <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
    </form>
  </x-modal-alert>
@endsection

@push('script')
  @if (session()->has('success'))
    <script>
      window.onload = function() {
        window.location.hash = 'rekamTerapi';
      };
    </script>
  @endif
@endpush
