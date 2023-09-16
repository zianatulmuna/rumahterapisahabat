<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rekam Terapi {{ $sub->penyakit }} - {{ $pasien->nama }} - NORM {{ $sub->rekamMedis->id_rekam_medis }}</title>

  <!-- Custom fonts -->
  @include('unduh.partials.head')
</head>

<body>
  @foreach ($list_terapi as $terapi)
    <div class="d-flex align-items-center mb-4 mx-4">
      <div class="col-1 px-0">
        <img src="/assets/Logo_Klinik.png" style="height: 48px; width: auto" alt="" />
      </div>
      <div class="col">
        <h1 class="h2 mb-0 pe-5 text-center">Data Terapi</h1>
      </div>
    </div>
    <div class="row pb-7 mx-4">
      <table class="table table-borderless table-sm table-data-diri">
        <thead>
          <tr>
            <th style="width: 25%"></th>
            <th style="width: 78%"></th>
          </tr>
        </thead>
        <tbody>
          <tr style="font-size: 15px">
            <td>Tanggal Terapi</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $terapi->tanggal }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Nama Pasien</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $pasien->nama }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Nama Penyakit</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $sub->penyakit }}</span>
            </td>
          </tr>
          
          <tr style="font-size: 15px">
            <td>Terapi ke-</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $loop->index + 1 }} dari {{ $sub->rekamMedis->jumlah_layanan }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Lokasi Terapi</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $sub->rekamMedis->tempat_layanan }}</span>
            </td>
          </tr>
          <tr style="font-size: 15px">
            <td>Sistem Layanan Terapi</td>
            <td class="hstack align-items-start gap-3">
              <span>:</span><span>{{ $sub->rekamMedis->sistem_layanan }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="row mx-4">
      <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
        Keluhan
      </h4>
      <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 75px; font-size: 13px">
        {{ $terapi->keluhan }}
      </div>
    </div>
    <div class="row mx-4">
      <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
        Deteksi/Pengukuran
      </h4>
      <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 75px; font-size: 13px">
        {{ $terapi->deteksi }}
      </div>
    </div>
    <div class="row mx-4">
      <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
        Terapi/Tindakan yang Sudah Dilakukan
      </h4>
      <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 75px; font-size: 13px">
        {{ $terapi->tindakan }}
      </div>
    </div>
    <div class="row mx-4">
      <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">Saran</h4>
      <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 75px; font-size: 13px">
        {{ $terapi->saran }}
      </div>
    </div>
    <div class="row mx-4">
      <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
        Pra Terapi
      </h4>
      <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 75px; font-size: 13px">
        {{ $terapi->pra_terapi }}
      </div>
    </div>
    <div class="row mx-4">
      <h4 class="fw-semibold mt-3 mb-1 ps-0" style="font-size: 15px">
        Post Terapi
      </h4>
      <div class="bg-white py-2 border border-body-tertiary text-black" style="min-height: 75px; font-size: 13px">
        {{ $terapi->post_terapi }}
      </div>
    </div>
    <div class="small mx-4 fw-lighter" style="position: fixed; bottom: 0; font-size: 13px">
      Jl. Meninting Raya No.18, Pagesangan Barat, Mataram, NTB. <br>
      Telp : 085960664604 (WhatsApp)
    </div>
    @if(!$loop->last)
      <div class="pagebreak"></div>
    @endif
  @endforeach

  @include('unduh.partials.script')
</body>

</html>