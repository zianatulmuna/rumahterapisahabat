@extends('layouts.guest.main')

@section('container')
<div class="main-banner" id="home">
    <div class="container mb-5">
      <h1>Sehat pikiran berawal dari sehat jasmani</h1>
      <p>Jagalah kesehatan, seakan-akan kamu akan hidup abadi</p>
      <a href="{{ route('landing.form') }}" class="btn btn-outline-success me-2">Daftar sebagai Pasien</a>
    </div>
  </div>
  <div class="owl-carousel owl-theme owl-show-events">
    <div class="item">
      <img src="/assets/klinik2.jpg" alt="" />
    </div>
    <div class="item">
      <img src="/assets/klinik1.jpg" alt="" />
    </div>
    <div class="item">
      <img src="/assets/klinik2.jpg" alt="" />
    </div>
    <div class="item">
      <img src="/assets/klinik3.jpg" alt="" />
    </div>
    <div class="item">
      <img src="/assets/klinik3.jpg" alt="" />
    </div>
  </div>
  <div class="custom-controls pb-3">
    <button class="custom-prev">
      <i class="bi bi-arrow-left"></i>
    </button>
    <div class="owl-dots"></div>
    <button class="custom-next">
      <i class="bi bi-arrow-right"></i>
    </button>
  </div>

  <div class="container-fluid px-3 px-sm-5 py-5 d-flex justify-content-center" id="jadwal">
    <div class="row px-sm-5" style="width: 99%; max-height: 480px;">
      <div class="col-lg-8 py-2">
        <div class="card p-4 shadow rounded-3 h-100">
          <div class="pb-2 mb-3 border-bottom">
            <h3>Jadwal Terapi</h3>
          </div>
          @livewire('jadwal-landing')
          
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
                <td class="text-center text-capitalize">{{ $jadwal->terapis->username }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center mt-2">
            {{ $jadwal_terapi->links() }}
          </div>
          @else
            <div class="alert alert-light fst-italic py-1 px-2 mt-2 d-inline-flex w-100">
              Belum ada jadwal.
            </div>
          @endif
        </div>
      </div>

      <div class="col-lg-4 py-2 ps-lg-4">
        <div class="card p-4 shadow rounded-3">
          <div class="pb-2 mb-3 border-bottom h-0">
            <h3>Terapis Ready</h3>
          </div>
          <div class="pe-3 content-ready content-ready-landing">
          @foreach($terapis_ready as $terapis)
            <div class="hstack gap-2 my-2 p-2 border rounded-3">
              @if ($terapis->foto)
                  <img src="{{ asset('storage/' . $terapis->foto) }}" class="avatar-img me-2" alt="...">
              @else
                  @if($terapis->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="avatar-img me-2" alt="...">
                  @else
                  <img src="/img/avatar-p.png" class="avatar-img me-2" alt="...">
                  @endif
              @endif
              <span class="me-auto text-truncate text-black text-capitalize">{{ $terapis->nama }}</span>
            </div>
          @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid tim py-5" id="tim">
    <div class="tentang-klinik" id="tentang-klinik">
      <div class="row d-flex align-items-md-center" style="width: 99%">
        <div class="col-lg-5 d-flex justify-content-center my-2">
          <img src="/assets/Login.svg" alt="" />
        </div>
        <div class="col-lg-7">
          <h2>Tentang Klinik</h2>
          <p class="lead my-3 d-flex justify-content-center" style="font-size: 16px">
            Klinik Rumah Terapi Sahabat pertama kali didirikan oleh H. Agus
            Hidayatulloh, ST, MT dengan tujuan untuk menerapkan Terapi Multi
            Biogenesis yang dipelajari beliau ketika berada di Belanda. Klinik
            yang berlokasi di Pagesangan Barat, Mataram, NTB telah berdiri
            selama 9 tahun semenjak tahun 2014.
            <br />Dalam kurun waktu tersebut, klinik telah menerima banyak
            pasien yang memiliki kasus penyakit berat seperti tumor, gagal
            organ dalam, kelumpuhan, dan masih banyak lagi. Tidak hanya itu,
            Klinik juga menangani penyakit non-fisik dan gangguan psikologi
            seperti, stres berlebihan, kecemasan akut, dan lainnya.Dengan
            metode terapi ini, terapis klinik siap membantu menyembuhkan
            penyakit ringan hingga berat.
          </p>
        </div>
      </div>
    </div>
    <div class="content-container">
      <div class="pb-2 mb-3 border-bottom h-0">
        <h2>Tentang Tim</h2>
      </div>
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Arif.jpg" alt="" />
            <h5 class="border-bottom">Arif</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Firnadi.jpg" alt="" />
            <h5 class="border-bottom">Firnadi</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Haris.jpg" alt="" />
            <h5 class="border-bottom">Haris</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Ichan.jpg" alt="" />
            <h5 class="border-bottom">Ichan</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Idan.jpg" alt="" />
            <h5 class="border-bottom">Idan</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Irwan.jpg" alt="" />
            <h5 class="border-bottom">Irwan</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Pardi.jpg" alt="" />
            <h5 class="border-bottom">Pardi</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Risky.jpg" alt="" />
            <h5 class="border-bottom">Risky</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/Rizal.jpg" alt="" />
            <h5 class="border-bottom">Rizal</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
        <div class="col d-flex justify-content-center text-center">
          <div class="tentang-tim">
            <img src="/assets/Terapis/wadi.jpg" alt="" />
            <h5 class="border-bottom">Wadi</h5>
            <p>Terapis Muda</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="testimoni py-5 d-flex justify-content-center" id="testimoni">
    <div class="row mb-2" style="width: 99%">
      <div class="col-md-6 py-2">
        <div class="row g-0 border rounded overflow-hidden mb-4 shadow h-100">
          <div class="col p-3 d-flex flex-column">
            <strong class="d-inline-block mb-2" style="color: #0e8357">Testimoni</strong>
            <h3 class="mb-0">Ferry Budiman</h3>
            <p class="card-text mb-auto">
              Awalnya saya sakit gula darah, tapi setelah terapi Alhamdulillah
              kadar gula di darah saya menurun . Terima kasih Klinik Rumah
              Terapi Sahabat
            </p>
          </div>
          <div class="col-auto p-3 my-auto">
            <img src="/assets/testimoni.jpg" />
          </div>
        </div>
      </div>
      <div class="col-md-6 py-2">
        <div class="row g-0 border rounded overflow-hidden mb-4 shadow h-100">
          <div class="col p-3 d-flex flex-column">
            <strong class="d-inline-block mb-2" style="color: #0e8357">Testimoni</strong>
            <h3 class="mb-0">Trisdayanti Putri</h3>
            <p class="card-text mb-auto">
              Sebelum bertemu dengan terapis di Klinik ini, saya telah
              menderita stroke hingga tidak bisa bicara. Tapi setelah
              menjalani terapi selama setahun, akhirnya suara saya kembali.
              Terima kasih Klinik Rumah Terapi Sahabat
            </p>
          </div>
          <div class="col-auto p-3 my-auto">
            <img src="/assets/avatar-test.JPG" />
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
<script>
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 4,
      },
    },
  });

  $(".owl-carousel").owlCarousel({
    items: 1,
    nav: false, // Turn off default navigation
    dots: false, // Turn off default dots
  });

  $(".custom-prev").click(function () {
    $(".owl-carousel").trigger("prev.owl.carousel");
  });

  $(".custom-next").click(function () {
    $(".owl-carousel").trigger("next.owl.carousel");
  });
</script>
@livewireScripts
@endpush