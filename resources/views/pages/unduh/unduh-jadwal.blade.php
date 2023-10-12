<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jadwal {{ $caption }}</title>

  <!-- Custom fonts -->
  @include('partials.unduh-head')
</head>

<body>
  <div class="halaman">
    <div class="d-flex align-items-center mx-4 mb-4">
      <div class="col-1 px-0">
        <img src="/assets/logo/logo_klinik.png" style="height: 48px; width: auto" alt="" />
      </div>
      <div class="col">
        <h1 class="h2 mb-0 pe-5 text-center">Jadwal</h1>
      </div>
    </div>
    <div class="row mx-4 mt-4">
      <table class="table-bordered border-1 table border align-middle" style="min-width: 450px">
        <thead>
          <tr class="py-1 text-center" style="font-size: 15px">
            <th scope="col" class="py-1">No</th>
            <th scope="col" class="py-1">Tanggal</th>
            <th scope="col" class="py-1">Nama Pasien</th>
            <th scope="col" class="py-1" class="table-col-terapis">Terapis</th>
            <th scope="col" class="py-1">Keterangan</th>
          </tr>
        </thead>
        <tbody style="font-size: 13px">
          @foreach ($list_jadwal as $jadwal)
            <tr>
              <th scope="row " class="py-1 text-center">{{ $loop->index + 1 }}</th>
              <td class="py-1 text-center">{{ date('d/m/Y', strtotime($jadwal->tanggal)) }}</td>
              <td class="py-1 text-center">{{ $jadwal->pasien->nama }}</td>
              <td class="text-capitalize py-1 text-center">
                {{ $jadwal->id_terapis == '' ? '' : $jadwal->terapis->username }}</td>
              <td class="py-1 text-center">{{ $jadwal->status }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  @include('partials.unduh-script')

</html>
