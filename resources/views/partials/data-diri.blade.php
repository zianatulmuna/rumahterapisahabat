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
  <div class="col-lg-8 border-body-tertiary border bg-white px-3 py-2">
    <table class="table-borderless table-sm table-data-diri table bg-white">
      <thead>
        <tr>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Nama</td>
          <td style="max-width: 175px; overflow: auto;">{{ $pasien->nama }}</td>
        </tr>
        <tr>
          <td>No. Telpon</td>
          <td>{{ $pasien->no_telp }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td style="max-width: 175px; overflow: auto;">{{ $pasien->email ? $pasien->email : '-' }}</td>
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
          <td>Pekerjaan</td>
          <td style="max-width: 175px; overflow: auto;">{{ $pasien->pekerjaan ? $pasien->pekerjaan : '-' }}</td>
        </tr>
        <tr>
          <td>Alamat</td>
          <td style="max-width: 175px; overflow: auto;">{{ $pasien->alamat ? $pasien->alamat : '-' }}</td>
        </tr>
      </tbody>
    </table>
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
        @php
          $isRMAktif = $rm != null && $rm->status_pasien == 'Rawat Jalan' ? 1 : 0;
        @endphp
        @if ($rm != null)
          <tr class="table-rm-btn">
            <td>No. RM{{ $isRMAktif ? ' Aktif' : '' }}</td>
            <td class="px-2">
              <span class="">{{ $rm->id_rekam_medis }}</span>
              @if ($isRMAktif)
                <a href="{{ route('pasien.rm', $pasien->slug) }}"><i
                    class="bi bi-arrow-right-circle-fill small text-success ps-1"></i></a>
              @else
                <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}"><i
                    class="bi bi-arrow-right-circle-fill small text-secondary ps-1"></i></a>
              @endif
            </td>
          </tr>
          <tr class="table-rm-p">
            @if (!$isRMAktif)
              <td>Status RM</td>
              <td class="px-2">{{ $rm->status_pasien }}</td>
            @endif
          </tr>
        @endif
      </tbody>
    </table>
  </div>
  <div class="col-lg-2 p-0">
    <div class="button-rm d-flex align-items-sm-center flex-lg-column justify-content-center ps-lg-4">
      <a href="{{ route('rm.histori', $pasien->slug) }}"
        class="btn btn-outline-success btn-sm mx-sm-3 mx-lg-0 w-100 mb-3">Histori Rekam Medis</a>
      <a href="{{ route('sub.histori', $pasien->slug) }}"
        class="btn btn-outline-success btn-sm mx-sm-3 mx-lg-0 w-100 mb-3">Histori Rekam Terapi</a>
      @if (Request::is('pasien/' . $pasien->slug))
        @if ($rm != null)
          <a href="{{ $rm->link_perkembangan }}" target="_blank"
            class="btn btn-outline-success btn-sm mx-sm-3 mx-lg-0 w-100 {{ $rm->link_perkembangan ? '' : 'disabled' }} mb-3">Link
            Hasil Lab</a>
        @endif
      @endif
    </div>
  </div>
</div>
