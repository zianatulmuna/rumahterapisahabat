<div>
    <div class="mb-3">{{ $today }}</div>

    @if($jadwal_terapi->count() > 0)
    <table class="table custom-jadwal">
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
        @foreach($jadwal_terapi as $jadwal)
        <tr>
        <th scope="row">{{ $index++ }}</th>
        <td style="text-align: center">{{ $jadwal->id_pasien }}</td>
        <td style="text-align: center">{{ date('H:i', strtotime($jadwal->waktu)) }}</td>
        <td class="text-center text-capitalize">{{ $jadwal->id_terapis == '' ? '' : $jadwal->terapis->username }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <div class="d-flex justify-content-center mt-2">
    {{ $jadwal_terapi->links() }}
    </div>
    @else
    <div class="alert alert-light col-sm-7 fst-italic py-1 px-2 mt-2" role="alert">
        Belum ada jadwal.
    </div>
    @endif
</div>
