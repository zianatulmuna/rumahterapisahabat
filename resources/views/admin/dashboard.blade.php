@extends('layouts.auth.main')

@section('container')
<div class="content-container">
    <div class="row mb-3">
      <h1 class="h2 px-0 pb-3 border-bottom text-secondary">Selamat Datang, {{ auth()->user()->nama }} !</h1>
    </div>

    {{-- card performa --}}
    <div class="row row-cols-2 flex-row row-cols-sm-2 row-cols-lg-4 card-performa">        
        <div class="col ps-0 ps-lg-2 p-2">
            <div class="card px-1 shadow-sm rounded-3 border border-light">
                <div class="card-body p-2 p-sm-3">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="order-2 flex-fill d-flex justify-content-end">
                            <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #c8e7f5; height: 50px; width: 50px; border-radius: 50%">
                                <i class="bi bi-calendar-plus fs-4 text-primary"></i>
                            </div>
                        </div>
                        <div class="order-1">
                            <div class="h3 mb-0 fw-bold text-secondary mb-1">{{ $terapiBulanIni }}</div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                Total Terapi</div>
                            <span class="small text-secondary">Bulan ini</span>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col pe-0 pe-lg-2 p-2">
            <div class="card px-1 shadow-sm rounded-3 border border-light">
                <div class="card-body p-2 p-sm-3">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="order-2 flex-fill d-flex justify-content-end">
                            <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #f4f5c8; height: 50px; width: 50px; border-radius: 50%">
                                <i class="bi bi-person-add fs-4 text-warning"></i>
                            </div>
                        </div>
                        <div class="order-1">
                            <div class="h3 mb-0 fw-bold text-secondary mb-1">{{ $prapasienBulanIni }}</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase">
                                Pasien Baru</div>
                            <span class="small text-secondary">Bulan ini</span>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col ps-0 ps-lg-2 p-2">
            <div class="card px-1 shadow-sm rounded-3 border border-light">
                <div class="card-body p-2 p-sm-3">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="order-2 flex-fill d-flex justify-content-end">
                            <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #d3f0f5; height: 50px; width: 50px; border-radius: 50%">
                                <i class="bi bi-person-up fs-4 text-info"></i>
                            </div>
                        </div>
                        <div class="order-1">
                            <div class="h3 mb-0 fw-bold text-secondary mb-1">{{ $rawatJalanBulanIni }}</div>
                            <div class="text-xs font-weight-bold text-info text-uppercase">
                                Rawat Jalan</div>
                            <span class="small text-secondary">Bulan ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col pe-0 pe-lg-2 p-2">
            <div class="card px-1 shadow-sm rounded-3 border border-light">
                <div class="card-body p-2 p-sm-3">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="order-2 flex-fill d-flex justify-content-end">
                            <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #c8f5e5; height: 50px; width: 50px; border-radius: 50%">
                                <i class="bi bi-person-check fs-4 text-success"></i>
                            </div>
                        </div>
                        <div class="order-1">
                            <div class="h3 mb-0 fw-bold text-secondary mb-1">{{ $selesaiBulanIni }}</div>
                            <div class="text-xs font-weight-bold text-success text-uppercase">
                                Pasien Selesai</div>
                            <span class="small text-secondary">Bulan ini</span>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- grafik --}}
        <div class="col-xl-8 p-0 pe-xl-4">
            <x-grafik-dashboard :data-grafik="$dataGrafik" :terapis="$terapis" :penyakit="$penyakit" :maxChart="$maxChart"></x-grafik-dashboard>            
        </div>
        
        {{-- terapis ready --}}
        <div class="col-xl-4 p-0">
            @livewire('terapis-ready')
        </div>        
    </div>

    <div class="row main-bg">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h4">Jadwal Terapi</h1>
        </div>

        <div class="d-flex flex-grow-1 justify-content-between align-item-center flex-wrap flex-md-nowrap align-items-end mt-2 mb-4">
            <div class="col-4">
                {{ $today }}
            </div>
            <div class="col-8">
                <div class="row justify-content-end">
                    <div class="col-sm-9 col-xl-5">
                        <div class="form-control py-0 d-flex flex-row justify-content-between align-items-center flex-wrap taginput">
                            <input type="text" class="flex-grow-1 py-2" id="startDate" placeholder="Pilih Hari Lain" style="cursor: pointer; width: 100px">
                            <i class="bi bi-calendar2-event small icon-date pe-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-2 overflow-auto">
            <table class="table table-bordered align-middle">
                <thead>
                <tr class="text-center">
                    <th scope="col" style="width: 50px;">No</th>
                    <th scope="col" style="">Nama Pasien</th>
                    <th scope="col" style="">Waktu</th>
                    <th scope="col" style="width: 150px;">Rekam Medis</th>
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
                            <td>{{ $jadwal->pasien->nama }}</td>
                            @php
                                $waktu = substr($jadwal->waktu, 0, 5);;
                            @endphp
                            <td class="text-center">{{ $waktu }}</td>
                            <td class="text-center">
                                <a href="{{ route('pasien.rm', $jadwal->pasien->slug) }}" class="btn btn-sm c-btn-success rounded-3">
                                    <i class="bi bi-eye"></i>
                                </a>  
                            </td>
                            <td>{{ $jadwal->terapis->nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const inputDate = document.querySelector("#startDate");

    inputDate.addEventListener("focus", function() {
        document.querySelector(".icon-date").style.display = "none";
        inputDate.type = 'date';
    });
    inputDate.addEventListener("blur", function() {
        document.querySelector(".icon-date").style.display = "block";
        inputDate.type = 'text';
    });

    function handleSwitchChange(checkbox) {
        const total = document.querySelector('#totalReady');
        if (checkbox.checked) {
            fetch('/admin/dashboard/setReady?username=' + checkbox.value + '&status=1')
            .then(response => response.json())
            .then(data => total.innerText = data.total + ' Terapis')
        } else {
            fetch('/admin/dashboard/setReady?username=' + checkbox.value + '&status=0')
            .then(response => response.json())
            .then(data => total.innerText = data.total + ' Terapis')
        }
    }    
    </script>
@endpush

@push('script')
    @if(request('grafik'))
    <script>
        window.onload = function() {
            document.querySelector("#grafik").scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        };
    </script>
    @endif
    @livewireScripts
@endpush