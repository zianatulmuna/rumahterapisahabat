@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Data Terapis</h1>
    </div>

    {{-- Data Diri terapis --}}
    <div class="row g-4 custom-bio">
      <div class="col-lg-2 pe-sm-3 p-0">
        <div class="d-flex align-items-center justify-content-center">
          @if ($terapis->foto)
            <img src="{{ asset('storage/' . $terapis->foto) }}" class="img-thumbnail" alt="...">
          @else
            @if ($terapis->jenis_kelamin === 'Laki-Laki')
              <img src="/img/avatar-l.png" class="img-thumbnail" alt="...">
            @else
              <img src="/img/avatar-p.png" class="img-thumbnail" alt="...">
            @endif
          @endif
        </div>
      </div>
      <div class="col-md-9 col-lg-7 border-body-tertiary border bg-white px-3 py-2 text-black">
        <table class="table-borderless table-sm table-data-diri table bg-white">
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
            <td class="hstack gap-2">
              <i class="fa-solid fa-heart-pulse text-success"></i>
              <span>{{ $terapis->total_terapi }}</span>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-md-3 text-center">
        <h5>Tingkatan Terapis</h5>
        @php
          if ($terapis->tingkatan == 'Utama') {
              $warnaTingkatan = 'c-text-danger';
          }
          if ($terapis->tingkatan == 'Madya') {
              $warnaTingkatan = 'c-text-primary';
          }
          if ($terapis->tingkatan == 'Muda') {
              $warnaTingkatan = 'c-text-success';
          }
          if ($terapis->tingkatan == 'Pratama') {
              $warnaTingkatan = 'c-text-warning';
          }
          if ($terapis->tingkatan == 'Latihan') {
              $warnaTingkatan = 'c-text-secondary';
          }
        @endphp
        <div class="d-flex justify-content-center align-center">
          <h5 class="d-flex d-md-block rounded-0 border-secondary-subtle border bg-white px-4 py-3 shadow-sm">
            <i class="fa-solid fa-medal pb-md-2 {{ $warnaTingkatan }} pe-2"></i>
            <p class="m-0">Terapis {{ $terapis->tingkatan }}</p>
          </h5>
        </div>
      </div>
    </div>

    <h3 class="mt-sm-5 mb-3 mt-3" id="historiTerapi">Sesi Terapi</h3>
    <div class="d-flex justify-content-between align-items-md-end flex-column-reverse flex-md-row my-md-3">
      <div class="my-md-0 mb-2 mt-4">
        {{ $jumlah_terapi }}
        <span class="small">({{ $caption }})</span>
      </div>
      <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4">
        <div class="btn-group w-100">
          <button type="button" class="form-control d-flex justify-content-between align-items-center"
            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <span>Pilih Filter</span>
            <i class="bi bi-calendar2-week"></i>
          </button>
          <ul class="dropdown-menu w-100 shadow-lg">
            <li>
              <h6 class="dropdown-header">Berdasarkan Periode</h6>
            </li>
            <li><a href="?{{ request('tab') ? 'tab=rekap&' : '' }}filter=bulan-ini"
                class="dropdown-item {{ request('filter') == 'bulan-ini' ? 'active' : '' }}">Bulan Ini</a></li>
            <li><a href="?{{ request('tab') ? 'tab=rekap&' : '' }}filter=tahun-ini"
                class="dropdown-item {{ request('filter') == 'tahun-ini' ? 'active' : '' }}">Tahun Ini</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <h6 class="dropdown-header">Berdasarkan Tanggal</h6>
            </li>
            <li class="hstack stack-input-icon px-3 pb-2">
              <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                <i class="bi bi-calendar2-event text-body-tertiary"></i>
              </div>
              <input type="date" value="{{ request('tanggal') }}" id="date" class="form-control">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <h6 class="dropdown-header">Berdasarkan Range Tanggal</h6>
            </li>
            <li class="px-3 pb-2">
              <div class="d-flex w-100 gap-2">
                <label class="form-label flex-fill small m-0">Pilih Tgl Mulai:</label>
                <label class="form-label flex-fill small m-0">Pilih Tgl Akhir:</label>
              </div>
              <div class="d-flex gap-2">
                <div class="hstack stack-input-icon w-100 overflow-hidden">
                  <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                    <i class="bi bi-calendar2-plus text-body-tertiary"></i>
                  </div>
                  <input type="date" value="{{ request('awal') }}" id="startDate" class="form-control">
                </div>
                <div class="hstack stack-input-icon w-100 overflow-hidden">
                  <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                    <i class="bi bi-calendar2-check text-body-tertiary"></i>
                  </div>
                  <input type="date" value="{{ request('akhir') }}" id="endDate" class="form-control">
                </div>
              </div>
              <div class="text-center">
                <button type="button" id="dateBtn"
                  class="btn btn-success btn-sm align-content-end mt-3">Tampilkan</button>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- nav-tab terapi --}}
    <ul class="nav nav-tabs mt-4">
      <li class="nav-item" role="presentation">
        <button class="nav-link link-success {{ request('tab') ? '' : 'active' }}" id="historiBtn" type="button"
          onclick="toHistori()">Histori Terapi</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link link-success {{ request('tab') == 'rekap' ? 'active' : '' }}"
          id="recapBtn" onclick="toRekap()">Rekap Terapi</button>
      </li>
    </ul>

    {{-- data terapi --}}
    <div class="tab-content">
      <div class="border-top-0 border bg-white px-3 py-4">
        @if (request('tab'))
          @if (count($rekap_terapi) > 0)
            <div class="pb-sm-0 overflow-auto pb-4">
              <table class="table-bordered table-sm mb-0 table text-center" style="min-width: 420px;">
                <thead>
                  <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Penyakit</th>
                    <th scope="col">Rekam Terapi</th>
                    <th scope="col">Total Terapi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($rekap_terapi as $terapi)
                    <tr>
                      <th scope="row" class="small-col-number text-center">{{ $loop->index + 1 }}</th>
                      <td class="px-sm-3">{{ $terapi->subRekamMedis->rekamMedis->pasien->nama }}</td>
                      <td class="px-sm-3">{{ $terapi->subRekamMedis->penyakit }}</td>
                      <td class="px-sm-3">
                        <a href="{{ route('terapi.rekam', [$terapi->subRekamMedis->rekamMedis->pasien->slug, $terapi->id_sub]) }}"
                          class="btn btn-sm c-btn-success rounded-3">
                          <i class="bi bi-eye"></i>
                        </a>
                      </td>
                      <td class="small-col-aksi text-center">{{ $terapi->total }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="{{ $rekap_terapi->hasPages() ? 'mt-3 ' : '' }}d-flex justify-content-center">
              {{ $rekap_terapi->appends(request()->query())->links() }}
            </div>
          @else
            <div class="fst-italic">Data belum ada/tidak ditemukan.</div>
          @endif
        @else
          @if (count($histori_terapi) > 0)
            <div class="pb-sm-0 overflow-auto pb-4">
              <table class="table-bordered mb-0 table text-center" style="min-width: 420px;">
                <thead>
                  <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Penyakit</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $startIndex = ($histori_terapi->currentPage() - 1) * $histori_terapi->perPage() + 1;
                  @endphp
                  @foreach ($histori_terapi as $terapi)
                    <tr>
                      <th scope="row" class="small-col-number text-center">{{ $startIndex++ }}</th>
                      <td class="text-center">{{ date('d/m/Y', strtotime($terapi->tanggal)) }}</td>
                      <td class="px-sm-3">{{ $terapi->subRekamMedis->rekamMedis->pasien->nama }}</td>
                      <td class="px-sm-3">{{ $terapi->subRekamMedis->penyakit }}</td>
                      <td class="small-col-aksi text-center">
                        <a href="{{ route('terapi.detail', [$terapi->subRekamMedis->rekamMedis->pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}"
                          class="btn btn-sm rounded-2 c-btn-success">
                          <i class="bi bi-eye"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="{{ $histori_terapi->hasPages() ? 'mt-3 ' : '' }}d-flex justify-content-center">
              {{ $histori_terapi->appends(request()->query())->links() }}
            </div>
          @else
            <div class="fst-italic">Data belum ada/tidak ditemukan.</div>
          @endif
        @endif
      </div>
    </div>

    @if ($userAdmin)
      <div class="d-flex justify-content-end mb-3 mt-5 gap-3">
        <a type="button" class="btn c-btn-danger" data-toggle="modal" data-target="#terapisDeleteModal">
          <i class="bi bi-trash"></i>
          Hapus
        </a>
        <a href="{{ route('terapis.edit', $terapis->username) }}" class="btn c-btn-warning px-3">
          <i class="bi bi-pencil-square pe-1"></i>
          Edit
        </a>
      </div>
    @endif

  </div>
@endsection

@section('modal-alert')
  <!-- Terapi Delete Modal-->
  <x-modal-alert id="terapisDeleteModal" title="Yakin ingin menghapus terapis?" :body="'<span>Semua data terkait Terapis ini akan dihapus <strong>permanen</strong>!
             <br>Hal ini termasuk semua data terapi, terapi, dll.</span>'"
    icon="bi bi-exclamation-circle text-danger">
    <form action="{{ route('terapis.delete', $terapis->username) }}" method="post">
      @method('delete')
      @csrf
      <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
    </form>
  </x-modal-alert>
@endsection

@push('script')
  <script>
    const tunggal = document.querySelector('#date');
    const start = document.querySelector('#startDate');
    const end = document.querySelector('#endDate');
    const dateBtn = document.querySelector('#dateBtn');

    let searchParams = new URLSearchParams(window.location.search);

    const id = @json($terapis->username);

    tunggal.addEventListener('change', function() {
      param = searchParams.has('tab') ? "?tab=rekap&tanggal=" + tunggal.value : "?tanggal=" + tunggal.value;

      window.location.href = param;
    })

    dateBtn.addEventListener('click', function() {
      if (start.value == '') {
        start.classList.add('is-invalid');
      } else if (end.value == '') {
        start.classList.remove('is-invalid');
        end.classList.add('is-invalid');
      } else {
        end.classList.remove('is-invalid');
        param = searchParams.has('tab') ? "tab=rekap&" : "";
        window.location.href = '?' + param + 'awal=' + start.value + '&akhir=' + end.value;
      }
    })

    function toHistori() {
      var currentUrl = window.location.href;
      currentUrl = currentUrl.replace(/([?&])tab=[^&]*&?/, '$1');

      window.location.href = currentUrl;
    }

    function toRekap() {
      window.location.href = "?tab=rekap&" + searchParams.toString();
    }
  </script>
  @if ($request)
    <script>
      window.onload = function() {
        window.location.hash = 'historiTerapi';
      };
    </script>
  @endif
@endpush
