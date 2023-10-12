<div>
  <div class="mb-3">{{ $today }}</div>

  @if ($jadwal_terapi->count() > 0)
    <table class="custom-jadwal table">
      <thead>
        <tr>
          <th scope="col" style="text-align: center; width: 5%">No</th>
          <th scope="col" style="text-align: center">ID Pasien</th>
          <th scope="col" style="text-align: center">Jam</th>
          <th scope="col" style="text-align: center">Terapis</th>
        </tr>
      </thead>
      <tbody>
        @php
          $index = ($jadwal_terapi->currentPage() - 1) * $jadwal_terapi->perPage() + 1;
        @endphp
        @foreach ($jadwal_terapi as $jadwal)
          <tr>
            <th scope="row">{{ $index++ }}</th>
            <td style="text-align: center">{{ $jadwal->id_pasien }}</td>
            <td style="text-align: center">{{ $jadwal->waktu ? date('H:i', strtotime($jadwal->waktu)) : '' }}</td>
            <td class="text-capitalize text-center">
              {{ $jadwal->id_terapis == '' ? '' : str_replace(['.', '-', '_'], ' ', $jadwal->terapis->username) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center mt-2">
      {{ $jadwal_terapi->links() }}
    </div>
  @else
    <div class="alert alert-light d-inline-flex align-items-start fst-italic my-3 py-2" role="alert">
      <i class="bi bi-exclamation-circle fw-semibold pe-2"></i>
      <div>Jadwal belum ada/tidak ditemukan.</div>
    </div>
  @endif
</div>
