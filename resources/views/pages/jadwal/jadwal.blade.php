@extends('layouts.auth.main')

@section('container')
  <div class="content-container">
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-4 flex-wrap pb-2">
      <h1 class="h2">Jadwal Terapi</h1>
      @if (count($jadwal_terapi) > 0)
        <a href="" class="btn btn-sm btn-success rounded-3" onclick="printJadwal()">
          <i class="bi bi-download pe-1"></i>
          Unduh
        </a>
      @endif
    </div>

    @if ($userAdmin)
      <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('jadwal.add') }}" class="btn c-btn-primary">
          <i class="bi bi-plus-square pe-2"></i>
          Tambah
        </a>

      </div>
    @endif

    <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row my-sm-3">
      <div class="my-sm-0 my-3">
        {{ $caption }}
      </div>
      <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4">
        <div class="btn-group w-100">
          <button type="button" class="form-control d-flex justify-content-between align-items-center"
            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <span>Pilih Tanggal</span>
            <i class="bi bi-calendar2-week"></i>
          </button>
          <ul class="dropdown-menu w-100 shadow-lg">
            <li>
              <h6 class="dropdown-header">Berdasarkan Periode</h6>
            </li>
            <li><a href="?filter=bulan-ini"
                class="dropdown-item {{ request('filter') == 'bulan-ini' ? 'active' : '' }}">Bulan Ini</a></li>
            <li><a href="?filter=tahun-ini"
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
    <div class="overflow-auto">
      @if (count($jadwal_terapi) > 0)
        <table class="table-bordered table overflow-auto text-center align-middle" style="min-width: 450px;">
          <thead>
            <tr>
              <th scope="col">No</th>
              @if (request('filter') || request('awal'))
                <th scope="col">Tanggal</th>
              @endif
              <th scope="col">Nama Pasien</th>
              <th scope="col">Rekam Terapi</th>
              <th scope="col">Penyakit</th>
              <th scope="col">Waktu</th>
              <th scope="col">Terapis</th>
              @if ($userAdmin)
                <th scope="col" class="table-col-aksi">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php
              $startIndex = ($jadwal_terapi->currentPage() - 1) * $jadwal_terapi->perPage() + 1;
            @endphp
            @foreach ($jadwal_terapi as $jadwal)
              <tr>
                <th scope="row">{{ $startIndex++ }}</th>
                @if (request('filter') || request('awal'))
                  <td>{{ date('d/m/Y', strtotime($jadwal->tanggal)) }}</td>
                @endif
                <td>{{ $jadwal->pasien->nama }}</td>
                <td>
                  <a href="{{ route('terapi.rekam', [$jadwal->pasien->slug, $jadwal->id_sub]) }}"
                    class="btn btn-sm c-btn-success rounded-3">
                    <i class="bi bi-eye"></i>
                  </a>
                </td>
                <td>{{ $jadwal->subRekamMedis->penyakit }}</td>
                <td>{{ $jadwal->waktu ? date('H:i', strtotime($jadwal->waktu)) : '' }}</td>
                <td class="text-capitalize text-center">
                  {{ $jadwal->id_terapis ? str_replace(['.', '-', '_'], ' ', $jadwal->terapis->username) : '' }}</td>
                @if ($userAdmin)
                  <td>
                    <a href="{{ route('jadwal.delete', $jadwal->id_jadwal) }}" class="c-badge c-badge-danger me-2"
                      data-bs-toggle="modal" data-bs-target="#jadwalDeleteModal"
                      onclick="setDeleteJadwal('{{ $jadwal->id_jadwal }}')">
                      <i class="bi bi-trash"></i>
                    </a>
                    <a href="{{ route('jadwal.edit', [$jadwal->pasien->slug, $jadwal->id_jadwal]) }}"
                      class="c-badge c-badge-warning">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                  </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="fst-italic pt-3">Data belum ada/tidak ditemukan.</div>
      @endif
    </div>
  </div>

  <div class="d-flex justify-content-center mb-4">
    {{ $jadwal_terapi->appends(request()->query())->links() }}
  </div>
@endsection

@section('modal-alert')
  @if (count($jadwal_terapi) > 0)
    <!-- Terapi Delete Modal-->
    <x-modal-alert id="jadwalDeleteModal" title="Yakin ingin menghapus jadwal?" :body="'<span>Jadwal akan dihapus <strong>permanen</strong>!</span>'"
      icon="bi bi-exclamation-circle text-danger">
      <form action="" method="post">
        @method('delete')
        @csrf
        <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
      </form>
    </x-modal-alert>
  @endif
@endsection

@push('script')
  <script>
    const tunggal = document.querySelector('#date');
    const start = document.querySelector('#startDate');
    const end = document.querySelector('#endDate');
    const dateBtn = document.querySelector('#dateBtn');

    tunggal.addEventListener('change', function() {
      window.location.href = '?tanggal=' + tunggal.value;
    })

    dateBtn.addEventListener('click', function() {
      if (start.value == '') {
        start.classList.add('is-invalid');
      } else if (end.value == '') {
        start.classList.remove('is-invalid');
        end.classList.add('is-invalid');
      } else {
        end.classList.remove('is-invalid');
        window.location.href = '?awal=' + start.value + '&akhir=' + end.value;
      }
    })

    document.querySelector('#alertBtn').addEventListener('click', function(event) {
      document.getElementById('jadwalDeleteModal').classList.remove('show');
    });
    document.querySelector('#xAlertBtn').addEventListener('click', function(event) {
      document.getElementById('jadwalDeleteModal').classList.remove('show');
    });

    function setDeleteJadwal(id) {
      const modal = document.querySelector("#jadwalDeleteModal");
      var form = modal.querySelector("form");
      var targetUrl = '/jadwal/' + id + '/delete';
      form.action = targetUrl;

      console.log(id, targetUrl, form);
    }

    function printJadwal() {
      let currentPath = window.location.search;
      let url = "";

      if (currentPath == '') {
        url = "/jadwal/print?awal=null&akhir=null";
      } else if (currentPath == "?filter=bulan-ini") {
        url = "/jadwal/print" + currentPath;
      } else if (currentPath == "?filter=tahun-ini") {
        url = "/jadwal/print" + currentPath;
      } else {
        var urlParams = new URLSearchParams(currentPath);

        if (urlParams.get('tanggal') != null) {
          url = "/jadwal/print?awal=" + urlParams.get('tanggal') + "&akhir=null";
        } else {
          url = "/jadwal/print" + currentPath;
        }
      }

      let a = document.createElement('a');
      a.target = '_blank';
      a.href = url;
      a.click();
    }
  </script>
@endpush
