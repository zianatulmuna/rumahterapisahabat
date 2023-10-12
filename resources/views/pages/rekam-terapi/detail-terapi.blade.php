@extends('layouts.auth.main')

@section('container')
  <div class="content-container custom-terapi-harian">
    <div class="d-flex justify-content-between align-items-center border-bottom mb-4 pb-2">
      <h1 class="h2">Rekam Terapi Harian</h1>
      @if (
          !$rm->is_private ||
              $userAdmin ||
              $userKepala ||
              ($userTerapis && !$userKepala && $userTerapis->id_terapis == $rm->id_terapis))
        <a href="{{ route('terapi.print', [$pasien->slug, $terapi->id_sub, $terapi->id_terapi]) }}" target="_blank"
          class="btn btn-success btn-sm rounded-3 mb-2">
          <i class="bi bi-download pe-1"></i> Unduh
        </a>
      @endif
    </div>

    {{-- Data Diri Pasien --}}
    <div class="row g-4 custom-bio">
      <div class="col-lg-2 pe-sm-3 p-0">
        <div class="d-flex align-items-center justify-content-center">
          @if ($pasien->foto)
            <img src="{{ asset('storage/' . $pasien->foto) }}" class="img-thumbnail" alt="...">
          @else
            @if ($pasien->jenis_kelamin === 'Laki-Laki')
              <img src="/img/avatar-l.png" class="img-thumbnail" alt="...">
            @else
              <img src="/img/avatar-p.png" class="img-thumbnail" alt="...">
            @endif
          @endif
        </div>
      </div>
      <div class="col-lg-7 border-body-tertiary border bg-white px-3 py-2">
        <table class="table-borderless table-sm table-data-diri table bg-white">
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
              <td>No. Telpon</td>
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
              <td>{{ $umur != 0 ? $umur . ' tahun' : '-' }}</td>
            </tr>
            <tr>
              <td class="align-top">Pekerjaan</td>
              <td>{{ $pasien->pekerjaan ? $pasien->pekerjaan : '-' }}</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>{{ $pasien->alamat }}</td>
            </tr>
            <table class="table-borderless table-sm table-data-diri table-info-rm m-0 mt-1 table">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>ID Pasien</td>
                  <td><span class="bg-body-secondary rounded-4 border px-2">{{ $pasien->id_pasien }}</span></td>
                </tr>
                <tr class="table-rm-btn">
                  <td>No. RM</td>
                  <td class="px-2">
                    <span class="">{{ $rm->id_rekam_medis }}</span>
                    <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}"><i
                        class="bi bi-arrow-right-circle-fill small {{ $rm->status_pasien == 'Rawat Jalan' ? 'text-success' : 'text-secondary' }} ps-1"></i></a>
                  </td>
                </tr>
                <tr class="table-rm-p">
                  <td>Status</td>
                  <td class="px-2">{{ $rm->status_pasien }}</td>
                </tr>
              </tbody>
            </table>
      </div>
      <div class="col-12 col-sm-8 col-lg-3 ps-sm-4 ps-0">
        <table class="w-100 table-data-diri">
          <thead>
            <tr class="w-100">
              <th style="width: 35%"></th>
              <th style="width: 65%"></th>
            </tr>
          </thead>
          <tbody class="align-top">
            @if (
                !$rm->is_private ||
                    $userAdmin ||
                    $userKepala ||
                    ($userTerapis && !$userKepala && $userTerapis->id_terapis == $rm->id_terapis))
              <tr>
                <td style="font-weight:bold">Penyakit</td>
                <td class="hstack align-items-start gap-2">
                  <span>:</span>
                  <span>{{ $terapi->subRekamMedis->penyakit }}</span>
                </td>
              </tr>
            @endif
            <tr>
              <td style="font-weight:bold">Tanggal</td>
              <td class="hstack align-items-start gap-2">
                <span>:</span><span>{{ date('d/m/Y', strtotime($terapi->tanggal)) }}</span>
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold">Terapi ke</td>
              <td class="hstack align-items-start gap-2"><span>:</span><span>{{ $index }}</span></td>
            </tr>
            <tr>
              <td style="font-weight:bold">Total Terapi</td>
              <td class="hstack align-items-start gap-2">
                <span>:</span><span>{{ $terapi->subRekamMedis->total_terapi }}</span>
              </td>
            </tr>
            <tr>
              <td style="font-weight:bold">Terapis</td>
              <td class="text-capitalize hstack align-items-start gap-2">
                <span>:</span><span>{{ str_replace(['.', '-', '_'], ' ', $terapi->terapis->username) }}</span>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
    @if (
        !$rm->is_private ||
            $userAdmin ||
            $userKepala ||
            ($userTerapis &&
                !$userKepala &&
                ($userTerapis->id_terapis == $rm->id_terapis || $userTerapis->id_terapis == $terapi->id_terapis)))
      <div class="row row-cols-1 row-cols-md-2 mt-lg-5 mt-4">
        <div class="col px-lg-3">
          <div class="mb-lg-5 mb-4">
            <h4 class="mb-md-3 mb-2 ps-0">Keluhan</h4>
            <div class="py-md-2 px-md-3 border-body-tertiary border bg-white px-2 py-1 text-black"
              style="min-height: 100px">
              {!! $terapi->keluhan !!}
            </div>
          </div>
          <div class="mb-lg-5 mb-4">
            <h4 class="mb-md-3 mb-2 ps-0">Deteksi/Pengukuran</h4>
            <div class="py-md-2 px-md-3 border-body-tertiary border bg-white px-2 py-1 text-black"
              style="min-height: 100px">
              {!! $terapi->deteksi !!}
            </div>
          </div>
          <div class="mb-lg-5 mb-4">
            <h4 class="mb-md-3 mb-2 ps-0">Terapi/Tindakan yang Sudah Dilakukan</h4>
            <div class="py-md-2 px-md-3 border-body-tertiary border bg-white px-2 py-1 text-black"
              style="min-height: 100px">
              {!! $terapi->tindakan !!}
            </div>
          </div>
        </div>
        <div class="col px-lg-3">
          <div class="mb-lg-5 mb-4">
            <h4 class="mb-md-3 mb-2 ps-0">Saran</h4>
            <div class="py-md-2 px-md-3 border-body-tertiary border bg-white px-2 py-1 text-black"
              style="min-height: 100px">
              {!! $terapi->saran !!}
            </div>
          </div>
          <div class="mb-lg-5 mb-4">
            <h4 class="mb-md-3 mb-2 ps-0">Pra Terapi</h4>
            <div class="py-md-2 px-md-3 border-body-tertiary border bg-white px-2 py-1 text-black"
              style="min-height: 100px">
              {!! $terapi->pra_terapi !!}
            </div>
          </div>
          <div class="mb-lg-5 mb-4">
            <h4 class="mb-md-3 mb-2 ps-0">Post Terapi</h4>
            <div class="py-md-2 px-md-3 border-body-tertiary border bg-white px-2 py-1 text-black"
              style="min-height: 100px">
              {!! $terapi->post_terapi !!}
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="alert alert-secondary d-inline-flex col-sm-7 col-lg-5 mt-5 p-0 p-2 px-3">
        <i class="bi bi-lock-fill text-secondary pe-2"></i>
        Anda tidak memiliki akses.
      </div>
    @endif
    @if ($userAdmin || $userKepala)
      <div class="d-flex justify-content-between mt-lg-0 mx-sm-2 mx-0 mb-3 mt-3">
        <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#terapiDeleteModal">
          <i class="bi bi-trash"></i>
          Hapus
        </a>
        <a href="{{ route('terapi.edit', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}"
          class="btn c-btn-warning px-sm-4 px-3">
          <i class="bi bi-pencil-square"></i>
          Edit
        </a>
      </div>
    @else
      @if ($terapi->id_terapis === $userTerapis->id_terapis)
        <div class="d-flex justify-content-between mt-lg-0 mx-sm-2 mx-0 mb-3 mt-3">
          <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#terapiDeleteModal">
            <i class="bi bi-trash"></i>
            Hapus
          </a>
          <a href="{{ route('terapi.edit', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}"
            class="btn c-btn-warning px-sm-4 px-3">
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
  <x-modal-alert id="terapiDeleteModal" title="Yakin ingin menghapus data terapi?" :body="'<span>Data terapi pada tanggal ini akan dihapus <strong>permanen</strong>!</span>'"
    icon="bi bi-exclamation-circle text-danger">
    <form action="{{ route('terapi.delete', [$pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}"
      method="post">
      @method('delete')
      @csrf
      <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
    </form>
  </x-modal-alert>
@endsection
