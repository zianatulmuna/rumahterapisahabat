@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Histori Rekam Medis</h1>
    </div>

    {{-- Data Diri Pasien --}}
    @include('partials.data-diri')

    @if ($rmDetected)
      <h4 class="mb-3 mt-5">Rekam Medis Terkini</h4>
      @if ($rm)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3">
          @if ($isTerkiniAllowed)
            <div class="col mb-4">
              <div class="card card-kini h-100 shadow-sm">
                <a href="{{ route('pasien.rm', $pasien->slug) }}" class="card-header text-center">
                  <h6>NO.RM {{ $rm->id_rekam_medis }}</h6>
                </a>
                <ul class="list-group list-group-flush list-group-histori text-left">
                  <li class="list-group-item">
                    <p class="small">Penyakit:</p>
                    <p class="text-center">
                      @php
                        $arrayPenyakit = explode(',', $rm->penyakit);
                      @endphp
                      @foreach ($arrayPenyakit as $p)
                        <a href="/rekam-terapi/tag?search={{ $p }}"
                          class="link-dark link-underline-light">{{ $p }}</a>
                        @if (!$loop->last)
                          ,
                        @endif
                      @endforeach
                    </p>
                  </li>
                  <li class="list-group-item">
                    <div class="d-flex justify-content-between right-0">
                      <div class="col">
                        <p class="small">Status Pasien:</p>
                        <p><i class="bi bi-clock-fill c-text-primary pe-1"></i> Rawat Jalan</p>
                      </div>
                      <div class="d-flex justify-content-end">
                        <div class="">
                          <p class="small">Status Terapi:</p>
                          <p><i
                              class="bi {{ $rm->status_terapi == 'Terapi Baru' ? 'bi-0-circle-fill c-text-success' : 'bi-arrow-right-circle-fill c-text-warning' }} pe-1"></i>{{ $rm->status_terapi }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="card-body row">
                  @if (count($rm->subRekamMedis) == 0)
                    <div class="fst-italic">Data rekam terapi telah dihapus.
                      @if ($userAdmin || $userKepala)
                        Tambahkan penyakit pada Rekam Medis <a
                          href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}"
                          class="alert-link">disini</a>.
                      @endif
                    </div>
                  @elseif(count($rm->subRekamMedis) == 1)
                    <a href="{{ route('terapi.rekam', [$pasien->slug, $rm->subRekamMedis[0]->id_sub]) }}"
                      class="link-success text-decoration-none">
                      Rekam Terapi
                      <i class="bi bi-arrow-right"></i>
                    </a>
                  @else
                    @foreach ($rm->subRekamMedis as $sub)
                      <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}"
                        class="link-success text-decoration-none">
                        Rekam Terapi {{ $sub->penyakit }}
                        <i class="bi bi-arrow-right"></i>
                      </a>
                    @endforeach
                  @endif
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
        </div>
      @else
        <div class="alert alert-warning d-inline-flex mb-4 p-0 p-2 px-3">
          <i class="bi bi-exclamation-circle fw-semibold pe-2"></i> Pasien ini tidak memiliki histori rekam medis aktif.
        </div>
      @endif
      @if (count($rm_terdahulu) > 0)
        <h4 class="mb-3 mt-4">Rekam Medis Terdahulu</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3">
          @foreach ($rm_terdahulu as $rm)
            @if ($isTerdahuluAllowed)
              <div class="col mb-4">
                <div class="card card-dulu h-100 shadow-sm">
                  <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}"
                    class="card-header text-center">
                    <h6>NO.RM {{ $rm->id_rekam_medis }}</h6>
                  </a>
                  <ul class="list-group list-group-flush list-group-histori text-left">
                    <li class="list-group-item">
                      <p class="small">Penyakit:</p>
                      <p class="text-center">
                        @php
                          $arrayPenyakit = explode(',', $rm->penyakit);
                        @endphp
                        @foreach ($arrayPenyakit as $p)
                          <a href="/rekam-terapi/tag?search={{ $p }}" target="_blank"
                            class="link-dark link-underline-light">{{ $p }}</a>
                          @if (!$loop->last)
                            ,
                          @endif
                        @endforeach
                      </p>
                    </li>
                    <li class="list-group-item">
                      <div class="d-flex justify-content-between right-0">
                        <div class="col">
                          <p class="small">Status Pasien:</p>
                          @if ($rm->status_pasien == 'Jeda')
                            <p><i class="bi bi-pause-circle-fill text-warning pe-1"></i> Jeda</p>
                          @else
                            <p><i class="bi bi-check-circle-fill text-success pe-1"></i> Selesai</p>
                          @endif
                        </div>
                        <div class="d-flex justify-content-end">
                          <div class="">
                            @if ($rm->status_pasien == 'Jeda')
                              <p class="small">Tanggal Jeda:</p>
                              <p><i class="bi bi-calendar2-check-fill text-light-emphasis pe-1"></i>
                                {{ date('d-m-Y', strtotime($rm->tanggal_selesai)) }}</p>
                            @else
                              <p class="small">Tanggal Selesai:</p>
                              <p><i class="bi bi-calendar2-check-fill text-light-emphasis pe-1"></i>
                                {{ date('d-m-Y', strtotime($rm->tanggal_selesai)) }}</p>
                            @endif
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <div class="card-body row">
                    @if (count($rm->subRekamMedis) == 0)
                      <div class="fst-italic">Data rekam terapi telah dihapus.
                        @if ($userAdmin || $userKepala)
                          Tambahkan penyakit pada Rekam Medis <a
                            href="{{ route('rm.edit', [$pasien->slug, $rm->id_rekam_medis]) }}"
                            class="alert-link">disini</a>.
                        @endif
                      </div>
                    @elseif(count($rm->subRekamMedis) == 1)
                      <a href="{{ route('terapi.rekam', [$pasien->slug, $rm->subRekamMedis[0]->id_sub]) }}"
                        class="link-success text-decoration-none">
                        Rekam Terapi
                        <i class="bi bi-arrow-right"></i>
                      </a>
                    @else
                      @foreach ($rm->subRekamMedis as $sub)
                        <a href="{{ route('terapi.rekam', [$pasien->slug, $sub->id_sub]) }}"
                          class="link-success text-decoration-none">
                          Rekam Terapi {{ $sub->penyakit }}
                          <i class="bi bi-arrow-right"></i>
                        </a>
                      @endforeach
                    @endif
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
        </div>
      @endif
    @else
      <div class="alert alert-danger d-inline-flex mt-5 w-auto p-0 p-2 px-3">
        <i class="bi bi-exclamation-circle fw-semibold pe-2"></i>
        Pasien ini tidak memiliki histori rekam medis.
      </div>
    @endif

    @if ($userAdmin || $userKepala)
      <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('rm.create', $pasien->slug) }}" class="btn c-btn-primary"><i
            class="bi bi-file-earmark-plus pe-2"></i>Tambah Rekam Medis</a>
      </div>
    @endif
  </div>
@endsection
