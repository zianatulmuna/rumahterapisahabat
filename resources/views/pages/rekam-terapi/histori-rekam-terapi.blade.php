@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Histori Rekam Terapi</h1>
    </div>

    {{-- Data Diri Pasien --}}
    @include('partials.data-diri')

    @if ($rmDetected == 1)
      <h4 class="mb-3 mt-5">Rekam Terapi Terkini</h4>
      @if ($rm)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3">
          @if (count($rm->subRekamMedis) > 0)
            @foreach ($rm->subRekamMedis as $sub)
              @if (
                  $userAdmin ||
                      $userKepala ||
                      !$rm->is_private ||
                      ($userTerapis && !$userKepala && $rm->is_private && $rm->id_terapis == $userTerapis->id_terapis))
                <div class="col mb-4">
                  <div class="card shadow-sm">
                    <h6 class="card-header bg-success fw-bold text-center text-white">{{ $sub->penyakit }}</h6>
                    <ul class="list-group list-group-flush list-group-histori text-left">
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between right-0">
                          <div class="col">
                            <p class="small">NO. RM:</p>
                            <p>{{ $sub->id_rekam_medis }}</p>
                          </div>
                          <div class="d-flex justify-content-end">
                            <div class="" style="min-width: 114px">
                              <p class="small">Total Terapi:</p>
                              <p class="align-center"><i
                                  class="bi bi-heart-pulse-fill text-success pe-2"></i>{{ $sub->total_terapi }}/{{ $rm->jumlah_layanan }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between right-0">
                          <div class="col">
                            @php
                              if (count($sub->rekamTerapi) > 0) {
                                  $m = $sub
                                      ->rekamTerapi()
                                      ->orderBy('tanggal', 'ASC')
                                      ->first();
                                  $mulai = date('d-m-Y', strtotime($m->tanggal));
                              } else {
                                  $mulai = '-';
                              }
                            @endphp
                            <p class="small">Tanggal Mulai:</p>
                            <p><i class="bi bi-calendar-plus text-light-emphasis pe-1"></i> {{ $mulai }}</p>
                          </div>
                          <div class="d-flex justify-content-end">
                            <div class="" style="min-width: 114px">
                              @php
                                if (count($sub->rekamTerapi) > 0) {
                                    $m = $sub
                                        ->rekamTerapi()
                                        ->orderBy('tanggal', 'DESC')
                                        ->first();
                                    $akhir = date('d-m-Y', strtotime($m->tanggal));
                                } else {
                                    $akhir = '-';
                                }
                              @endphp
                              <p class="small">Tanggal Terkini:</p>
                              <p><i class="bi bi-calendar-check text-light-emphasis pe-1"></i> {{ $akhir }}</p>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <div class="card-body d-flex justify-content-between mx-2">
                      <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}" class="link-success">Rekam
                        Terapi</a>
                      <a href="{{ route('pasien.rm', $pasien->slug) }}" class="link-success">Rekam Medis</a>
                    </div>
                  </div>
                </div>
              @else
                <div class="col mb-4">
                  <div class="card bg-body-tertiary shadow-sm" style="min-height: 200px;">
                    <div class="bi bi-lock fs-1 text-secondary m-auto pe-2"></div>
                  </div>
                </div>
              @endif
            @endforeach
          @else
            <div class="w-100">
              <div class="alert alert-warning hstack d-inline-flex gap-1 p-2 px-3">
                <i class="bi bi-exclamation-circle fw-semibold pe-1"></i>
                <p class="m-0">Data rekam terapi telah dihapus.
                  @if ($userAdmin || $userKepala)
                    Tambahkan penyakit pada Rekam Medis <a
                      href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.
                  @endif
                </p>
              </div>
            </div>
          @endif
        </div>
      @else
        <div class="alert alert-warning d-inline-flex mb-4 p-0 p-2 px-3">
          <i class="bi bi-exclamation-circle fw-semibold pe-2"></i>
          Pasien ini tidak memiliki histori rekam medis aktif.
        </div>
      @endif
      @if (count($rm_terdahulu) > 0)
        <h4 class="mb-3 mt-4">Rekam Terapi Terdahulu</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3">
          @php
            $countSub = 0;
          @endphp
          @foreach ($rm_terdahulu as $rm)
            @foreach ($rm->subRekamMedis as $sub)
              @if (
                  $userAdmin ||
                      $userKepala ||
                      !$rm->is_private ||
                      ($userTerapis && !$userKepala && $rm->is_private && $rm->id_terapis == $userTerapis->id_terapis))
                <div class="col mb-4">
                  <div class="card shadow-sm">
                    <h6 class="card-header bg-nonaktif fw-bold text-center">{{ $sub->penyakit }}</h6>
                    <ul class="list-group list-group-flush list-group-histori text-left">
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between right-0">
                          <div class="col">
                            <p class="small">NO. RM:</p>
                            <p>{{ $sub->id_rekam_medis }}</p>
                          </div>
                          <div class="d-flex justify-content-end">
                            <div class="" style="min-width: 114px">
                              <p class="small">Total Terapi:</p>
                              <p class="align-center"><i
                                  class="bi bi-heart-pulse-fill text-success pe-2"></i>{{ $sub->total_terapi }}/{{ $rm->jumlah_layanan }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between right-0">
                          <div class="col">
                            @php
                              if (count($sub->rekamTerapi) > 0) {
                                  $m = $sub
                                      ->rekamTerapi()
                                      ->orderBy('tanggal', 'ASC')
                                      ->first();
                                  $mulai = date('d-m-Y', strtotime($m->tanggal));
                              } else {
                                  $mulai = '-';
                              }
                            @endphp
                            <p class="small">Tanggal Mulai:</p>
                            <p><i class="bi bi-calendar-plus text-light-emphasis pe-1"></i> {{ $mulai }}</p>
                          </div>
                          <div class="d-flex justify-content-end">
                            <div class="">
                              @php
                                if (count($sub->rekamTerapi) > 0) {
                                    $m = $sub
                                        ->rekamTerapi()
                                        ->orderBy('tanggal', 'DESC')
                                        ->first();
                                    $akhir = date('d-m-Y', strtotime($m->tanggal));
                                } else {
                                    $akhir = '-';
                                }
                              @endphp
                              <p class="small">Tanggal Selesai:</p>
                              <p><i class="bi bi-calendar-check text-light-emphasis pe-1"></i> {{ $akhir }}</p>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <div class="card-body d-flex justify-content-between mx-2">
                      <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}" class="link-success">Rekam
                        Terapi</a>
                      <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}" class="link-success">Rekam
                        Medis</a>
                    </div>
                  </div>
                </div>
              @else
                <div class="col mb-4">
                  <div class="card bg-body-tertiary shadow-sm" style="min-height: 200px;">
                    <div class="bi bi-lock fs-1 text-secondary m-auto pe-2"></div>
                  </div>
                </div>
              @endif
              @php
                $countSub++;
              @endphp
            @endforeach
          @endforeach
        </div>
        @if ($countSub == 0)
          <div class="w-100">
            <div class="alert alert-secondary hstack d-inline-flex gap-1 p-2 px-3">
              <i class="bi bi-exclamation-circle fw-semibold pe-1"></i>
              <p class="m-0">Data rekam terapi telah dihapus.
                @if ($userAdmin || $userKepala)
                  Tambahkan penyakit pada Rekam Medis <a
                    href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}" class="alert-link">disini</a>.
                @endif
              </p>
            </div>
          </div>
        @endif
      @endif
    @else
      <div class="alert alert-danger d-inline-flex mt-5 p-0 p-2 px-3">
        <i class="bi bi-exclamation-circle fw-semibold pe-2"></i>
        Pasien ini tidak memiliki histori rekam terapi.
        @if ($userAdmin || $userKepala)
          <a href="{{ route('rm.create', $pasien->slug) }}" class="alert-link ps-2">Tambah Rekam Medis</a>
        @endif
      </div>
    @endif
  </div>
@endsection
