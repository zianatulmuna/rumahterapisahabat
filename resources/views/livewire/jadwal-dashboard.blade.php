<div>
  <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row px-sm-2 mb-sm-3 px-0">
    <div class="my-sm-0 mb-2 mt-4">
      {{ $tglCaption }}
    </div>
    <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4 mt-2">
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
          <li><button type="button" class="dropdown-item {{ $periode == 'bulan-ini' ? 'active' : '' }}"
              wire:click="setFilterPeriode('bulan-ini')">Bulan Ini</button></li>
          <li><button type="button" class="dropdown-item {{ $periode == 'tahun-ini' ? 'active' : '' }}"
              wire:click="setFilterPeriode('tahun-ini')">Tahun Ini</button></li>
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
            <input type="date" value="{{ $tanggal }}" id="date" class="form-control">
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
                <input type="date" id="startDate" class="form-control"
                  value="{{ $this->filter != 'Range' ? '' : $this->tglAwal }}">
              </div>
              <div class="hstack stack-input-icon w-100 overflow-hidden">
                <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                  <i class="bi bi-calendar2-check text-body-tertiary"></i>
                </div>
                <input type="date" id="endDate" class="form-control"
                  value="{{ $this->filter != 'Range' ? '' : $this->tglAkhir }}">
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

  <div class="px-sm-2 px-0">
    @if (count($jadwal_terapi) > 0)
      <div class="overflow-auto">
        <table class="table-bordered table align-middle">
          <thead>
            <tr class="text-center">
              <th scope="col" style="width: 50px;">No</th>
              @if ($periode)
                <th scope="col">Tanggal</th>
              @endif
              <th scope="col" style="">Nama Pasien</th>
              <th scope="col" style="width: 150px;">Rekam Terapi</th>
              <th scope="col" style="">Waktu</th>
              <th scope="col" style="">Terapis</th>

            </tr>
          </thead>
          <tbody>
            @php
              $startIndex = ($jadwal_terapi->currentPage() - 1) * $jadwal_terapi->perPage() + 1;
            @endphp
            @foreach ($jadwal_terapi as $jadwal)
              <tr>
                <th scope="row" class="text-center">{{ $startIndex++ }}</th>
                @if ($periode)
                  <td class="text-center">{{ date('d/m/Y', strtotime($jadwal->tanggal)) }}</td>
                @endif
                <td class="text-center">{{ $jadwal->pasien->nama }}</td>
                <td class="text-center">
                  @php
                    $rm = $jadwal->subRekamMedis->rekamMedis;
                  @endphp
                  @if ($userTerapis && !$userKepala && $rm->is_private && $rm->id_terapis != $jadwal->id_terapis)
                    <button href="" class="btn btn-sm c-btn-secondary rounded-3 disabled" disabled>
                      <i class="bi bi-lock-fill"></i>
                    </button>
                  @else
                    <a href="{{ route('terapi.rekam', [$jadwal->pasien->slug, $jadwal->id_sub]) }}"
                      class="btn btn-sm c-btn-success rounded-3">
                      <i class="bi bi-eye"></i>
                    </a>
                  @endif
                </td>
                <td class="text-center">{{ $jadwal->waktu ? date('H:i', strtotime($jadwal->waktu)) : '' }}</td>
                <td class="text-capitalize text-center">
                  @if ($userTerapis)
                    @if ($jadwal->id_terapis === $userTerapis->id_terapis)
                      <button type="button"
                        class="btn btn-sm c-btn-danger rounded-3 {{ $jadwal->status === 'Tertunda' ? '' : 'disabled' }} px-2"
                        wire:click="lepasJadwal('{{ $jadwal->id_jadwal }}')"
                        {{ $jadwal->status === 'Tertunda' ? '' : 'disabled' }}>Lepas</button>
                    @elseif($jadwal->id_terapis === null)
                      <button type="button" class="btn btn-sm c-btn-warning rounded-3 px-2"
                        wire:click="ambilJadwal('{{ $jadwal->id_jadwal }}','{{ $userTerapis->id_terapis }}')">Ambil</button>
                    @else
                      {{ str_replace(['.', '-', '_'], ' ', $jadwal->terapis->username) }}
                    @endif
                  @else
                    {{ $jadwal->id_terapis ? str_replace(['.', '-', '_'], ' ', $jadwal->terapis->username) : '' }}
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center p mb-3 mt-5">
        {{ $jadwal_terapi->links() }}
      </div>
    @else
      <div class="alert alert-light d-inline-flex align-items-start fst-italic my-3 py-2" role="alert">
        <i class="bi bi-exclamation-circle fw-semibold pe-2"></i>
        <div>Jadwal belum ada/tidak ditemukan.</div>
      </div>
    @endif

  </div>
</div>

@push('script')
  <script>
    const tunggal = document.querySelector('#date');
    const start = document.querySelector('#startDate');
    const end = document.querySelector('#endDate');
    const dateBtn = document.querySelector('#dateBtn');

    tunggal.addEventListener('change', function() {
      Livewire.emit('setFilterTanggal', tunggal.value);
    })

    dateBtn.addEventListener('click', function() {
      if (start.value == '') {
        start.classList.add('is-invalid');
      } else if (end.value == '') {
        start.classList.remove('is-invalid');
        end.classList.add('is-invalid');
      } else {
        end.classList.remove('is-invalid');

        Livewire.emit('setFilterRange', {
          awal: start.value,
          akhir: end.value
        });
      }
    })
  </script>
@endpush
