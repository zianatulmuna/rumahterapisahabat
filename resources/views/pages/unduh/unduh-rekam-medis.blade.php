<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rekam Medis {{ $rm->id_rekam_medis }} - {{ $pasien->nama }}</title>

  <!-- Custom fonts -->
  @include('partials.unduh-head')
</head>

<body>
  <div class="halaman">
    <div class="d-flex align-items-center mb-4 mx-4">
      <div class="col-1 px-0">
        <img src="/assets/logo/logo_klinik.png" style="height: 48px; width: auto" alt="" />
      </div>
      <div class="col">
        <h1 class="h2 mb-0 pe-5 text-center">Rekam Medis</h1>
      </div>
    </div>
    <div class="row pb-7 mx-4 data-diri-table">
      <table class="table table-borderless table-sm table-data-diri">
        <thead>
          <tr>
            <th style="width: 20%"></th>
            <th style="width: 80%"></th>
          </tr>
        </thead>
        <tbody>
          
          <tr style="font-size: 15px">
            <td>Nama Pasien</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $pasien->nama }}</span></td>
          </tr>
          <tr style="font-size: 15px">
            <td>No. RM</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $rm->id_rekam_medis }}</span></td>
          </tr>
          <tr style="font-size: 15px">
            <td>Jenis Kelamin</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $pasien->jenis_kelamin }}</span></td>
          </tr>
          <tr style="font-size: 15px">
            <td>Umur</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $umur }} tahun</td>
          </tr>
          <tr style="font-size: 15px">
            <td>Alamat Rumah</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $pasien->alamat }}
                {{ $pasien->alamat }}</span></td>
          </tr>
          <tr style="font-size: 15px">
            <td>Alamat email</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $pasien->email ? $pasien->email : '-' }}</span></td>
          </tr>
          <tr style="font-size: 15px">
            <td>Nomor Telepon</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $pasien->no_telp }}</span></td>
          </tr>
          <tr style="font-size: 15px">
            <td>Agama</td>
            <td class="hstack align-items-start gap-3"><span>:</span><span>{{ $pasien->agama ? $pasien->agama : '-' }}</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <h4 class="fw-semibold mt-3 mx-4 mb-1" style="font-size: 15px">
      Data Rencana Layanan Terapi
    </h4>
    <div class="row mx-4 g-6">
      <div class="col ps-0">
        <table class="table table-bordered table-sm table-top m-0 bg-white" style="font-size: 13px; min-height: 100%">
          <tbody>
            <tr>
              <td class="px-2" style="width: 40%">Tempat Layanan</td>
              <td class="px-2" style="width: 60%">{{ $rm->tempat_layanan }}</td>
            </tr>
            <tr>
              <td class="px-2">Sistem Layanan Terapi</td>
              <td class="px-2">
                {{ $rm->sistem_layanan }}
              </td>
            </tr>
            <tr>
              <td class="px-2">Jumlah Layanan</td>
              <td class="px-2">{{ $rm->jumlah_layanan }}</td>
            </tr>
            <tr>
              <td class="px-2">Jadwal Layanan</td>
              <td class="px-2">{{ $rm->jadwal_layanan }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col pe-0">
        <table class="table table-bordered table-sm table-top m-0 bg-white" style="font-size: 13px; height: 100%">
          <tbody>
            <tr>
              <td class="px-2" style="width: 40%">Tipe Pembayaran</td>
              <td class="px-2" style="width: 60%">{{ $rm->tipe_pembayaran }}</td>
            </tr>
            <tr>
              <td class="px-2">Penanggung Jawab</td>
              <td class="px-2">{{ $rm->penanggungjawab }}</td>
            </tr>
            <tr>
              <td class="px-2">Biaya Pembayaran</td>
              <td class="px-2">{{ $rm->biaya_pembayaran }}</td>
            </tr>
            <tr>
              <td class="px-2">Status Pasien</td>
              <td class="px-2">{{ $rm->status_pasien }}</td>
            </tr>
            <tr>
              <td class="px-2">Status Terapi</td>
              <td class="px-2">{{ $rm->status_terapi }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row mx-4">
      <div class="col ps-0">
        <h4 class="fw-semibold mb-1 mt-3" style="font-size: 15px">
          Keluhan Pasien
        </h4>
        <div class="col ps-0">
          <div class="bg-white px-2 py-1 border border-body-tertiary" style="min-height: 50px; font-size: 13px">
            {!! $rm->keluhan !!}
          </div>
        </div>
        <h4 class="fw-semibold mb-1 mt-3" style="font-size: 15px">
          Data Deteksi
        </h4>
        <div class="col ps-0">
          <div class="bg-white px-2 py-1 border border-body-tertiary" style="min-height: 105px; font-size: 13px">
            {!! $rm->data_deteksi !!}</div>
        </div>
      </div>

      <div class="col pe-0">
        <h4 class="fw-semibold mb-1 mt-3" style="font-size: 15px">
          Catatan Terapis
        </h4>
        <table class="table table-bordered border-body-tertiary table-sm table-top bg-white"
          style="font-size: 13px; min-height: 175px">
          <tr>
            <td class="px-2"><b>Fisik:</b><br>{!! $rm->catatan_fisik !!}</td>
          </tr>
          <tr>
            <td class="px-2"><b>Bioplasmik:</b><br>{!! $rm->catatan_bioplasmatik !!}</td>
          </tr>
          <tr>
            <td class="px-2"><b>Psikologis:</b><br>{!! $rm->catatan_psikologis !!}</td>
          </tr>
          <tr>
            <td class="px-2"><b>Rohani:</b><br>{!! $rm->catatan_rohani !!}</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="row mx-4">
      <div class="col ps-0">
        <h4 class="fw-semibold mt-3 mb-1" style="font-size: 15px">
          Target Terapi
        </h4>
        <table class="table table-bordered border-body-tertiary table-sm table-top bg-white"
          style="font-size: 13px; min-height: 75px">
          <tr>
            <td class="px-2"><b>Kondisi Awal:</b><br>{!! $rm->kondisi_awal !!}</td>
          </tr>
          <tr>
            <td class="px-2"><b>Target Akhir:</b><br>{!! $rm->target_akhir !!}</td>
          </tr>
          <tr>
            <td class="px-2"><b>Hasil Lab:</b><br>{{ $rm->link_perkembangan }}</td>
          </tr>
        </table>
      </div>

      <div class="col pe-0">
        <h4 class="fw-semibold mt-3 mb-1" style="font-size: 15px">
          Kesimpulan
        </h4>
        <div class="bg-white px-2 py-1 border border-body-tertiary" style="min-height: 85px; font-size: 13px">
          {!! $rm->kesimpulan !!}</div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  @include('partials.unduh-script')
</body>

</html>