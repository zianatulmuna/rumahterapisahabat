@extends('layouts.auth.main')

@section('container')
<div class="content-container">
    <div class="row mb-3">
      <h1 class="h2 px-0 pb-3 border-bottom">Selamat Datang, {{ auth()->user()->nama }} !</h1>
    </div>

    {{-- card performa --}}
    <div class="row gap-4">        
        <div class="col p-0">
            <div class="card px-1 shadow-sm rounded-4 h-100" style="border: 1px solid #4e73df;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Terapi</div>
                            <div class="h3 mb-0 fw-bold text-secondary">{{ $terapiBulanIni }}</div>
                            {{-- <span class="small text-secondary"><i class="bi bi-arrow-up-circle-fill text-primary"></i> 25% bulan ini</span> --}}
                        </div>
                        <div class="col-auto me-3 rounded-50 d-flex justify-content-center align-items-center" style="background: #c8e7f5; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-calendar-plus fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col p-0">
            <div class="card px-1 shadow-sm rounded-4 h-100" style="border: 1px solid #f6c23e;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pasien Baru</div>
                            <div class="h3 mb-0 fw-bold text-secondary">{{ $prapasienBulanIni }}</div>
                            {{-- <span class="small text-secondary"><i class="bi bi-arrow-up-circle-fill text-warning"></i> 25% bulan ini</span> --}}
                        </div>
                        <div class="col-auto me-3 rounded-50 d-flex justify-content-center align-items-center" style="background: #f4f5c8; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-person-add fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col p-0">
            <div class="card px-1 shadow-sm rounded-4 h-100" style="border: 1px solid #36b9cc;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rawat Jalan</div>
                            <div class="h3 mb-0 fw-bold text-secondary">{{ $rawatJalanBulanIni }}</div>
                            {{-- <span class="small text-secondary"><i class="bi bi-arrow-up-circle-fill text-info"></i> 25% bulan ini</span> --}}
                        </div>
                        <div class="col-auto me-3 rounded-50 d-flex justify-content-center align-items-center" style="background: #c8eef5; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-person-up fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col p-0">
            <div class="card px-1 shadow-sm rounded-4 h-100" style="border: 1px solid #1cc88a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pasien Selesai</div>
                            <div class="h3 mb-0 fw-bold text-secondary">{{ $selesaiBulanIni }}</div>
                            {{-- <span class="small text-secondary"><i class="bi bi-arrow-down-circle-fill text-success"></i> 25% bulan ini</span> --}}
                        </div>
                        <div class="col-auto me-3 rounded-50 d-flex justify-content-center align-items-center" style="background: #c8f5e5; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-person-check fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex">
        <div class="row main-bg px-3 py-4 row-grafik">
            <div class="d-flex flex-grow-1 justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Manajemen Klinik</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn dropdown-toggle btn-outline-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter Waktu
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/admin/dashboard?grafik=minggu">Minggu ini</a>
                        <a class="dropdown-item" href="/admin/dashboard?grafik=bulan">Bulan ini</a>
                        <a class="dropdown-item" href="/admin/dashboard?grafik=tahun">Tahun ini</a>
                    </div> 
                </div>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Sesi Terapi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pasien Baru</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Pasien Selesai</button>
                </li>
            </ul>

            <div class="tab-content py-3 border border-top-0" id="myTabContent">
                <div class="row my-3 mb-4 ms-2">
                    <div class="col-lg-10 col-sm-11">
                      <div class="d-flex flex-grow-1 justify-content-between align-item-center flex-wrap flex-md-nowrap">
                        <div class="input-group custom-search-grafik px-2 my-sm-2 my-md-0">                      
                          <input type="search" class="form-control" placeholder="Cari Nama Terapis" aria-label="Search" aria-describedby="search-addon" />
                            <button type="button" class="btn btn-outline-success">
                              <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="input-group custom-search-grafik px-2">                      
                          <input type="search" class="form-control" placeholder="Cari Nama Penyakit" aria-label="Search" aria-describedby="search-addon" />
                            <button type="button" class="btn btn-outline-success">
                              <i class="bi bi-search"></i>
                            </button>
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
            </div>
        
        </div>
        
        <div class="row main-bg row-aktif">
            <div class="pt-3">
                <h1 class="h4 pb-3 mb-3 border-bottom">Terapis Ready</h1>
            </div>
        </div>
    </div>

    <div class="row main-bg">
        <div class="d-flex flex-grow-1 justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h4">Jadwal Terapi</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              This week
            </button>
          </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>

    const value=  @json(array_values($dataGrafik));
    const label = @json(array_keys($dataGrafik));

    const tahun = 50;
    const bulan = 15;
    
    new Chart("myChart", {
      type: "line",
      data: {
        labels: label,
        datasets: [{
          fill: false,
          lineTension: 0,
          backgroundColor: "rgba(0,0,255,1.0)",
          borderColor: "rgba(0,0,255,0.1)",
          data: value
        }]
      },
      options: {
        legend: {display: false},
        scales: {
          yAxes: [{ticks: {min: 0, max:bulan}}],
        }
      }
    });
  </script>    
@endpush