<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Download Rekam Terapi</title>

  <!-- Custom fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;1,200;1,400&display=swap"
    rel="stylesheet" />

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />

  <!-- Bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Custom styles -->
  @include('unduh.partials.head')
</head>

<body>
  <div class="halaman">
    <div class="d-flex align-items-center mb-4 mx-4">
      <div class="col-1 px-0">
        <img src="/assets/Logo_Klinik.png" style="height: 48px; width: auto" alt="" />
      </div>
      <div class="col">
        <h1 class="h2 mb-0 pe-5 text-center">Rekam Terapi</h1>
      </div>
    </div>
    <div class="row pb-7 mx-4">
      <table class="table table-borderless table-sm table-data-diri">
        <thead>
          <tr>
            <th style="width: 20%"></th>
            <th style="width: 80%"></th>
          </tr>
        </thead>
        <tbody>
          <tr style="font-size: 15px">
            <td>ID Pasien</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $pasien->id_pasien }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Nama Pasien</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $pasien->nama }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Jenis Kelamin</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $pasien->jenis_kelamin }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Umur</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $umur }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="row mx-4">
      <div class="col ps-0">
        <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
          Penyakit
        </h4>
        <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 60px; font-size: 13px">{{ $sub->penyakit }}</div>
      </div>
      <div class="col pe-0">
        <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
          Keluhan
        </h4>
        <div class="bg-white px-3 py-2 border border-body-tertiary" style="min-height: 60px; font-size: 13px">{{ $sub->rekamMedis->keluhan }}</div>
      </div>
    </div>

    <h4 class="mt-3 mx-4 mb-1 fw-semibold" id="rekamTerapi" style="font-size: 15px">
      Histori Terapi
    </h4>
    <div class="overflow-auto mx-4">
      <table class="table table-bordered text-center">
        <thead class="text-center" style="font-size: 15px">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal Terapi</th>
            <th scope="col">Terapis</th>
            <th scope="col">Pra Terapi</th>
          </tr>
        </thead>
        <tbody style="font-size: 13px">
          @foreach ($list_terapi as $terapi)
          <tr>
            <th scope="row" style="max-width: 50px">{{ $loop->index + 1 }}</th>
            <td style="width: 200px">{{ date('d-m-Y', strtotime($terapi->tanggal)) }}</td>
            <td class="text-capitalize">{{ $terapi->terapis->username }}</td>
            <td>{{ $terapi->pra_terapi }}</td>
          </tr>                        
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @include('unduh.partials.script')
</body>

</html>