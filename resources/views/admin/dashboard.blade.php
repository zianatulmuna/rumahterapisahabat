@extends('layouts.auth.main')

@section('container')
<div class="content-container mx-2">
    <div class="row mb-3">
      <h1 class="h2 px-0 pb-3 border-bottom text-secondary">Selamat Datang, {{ auth()->user()->nama }} !</h1>
    </div>

    {{-- card performa --}}
    <div class="row row-cols-2 flex-row row-cols-sm-2 row-cols-lg-4 card-performa">        
        <div class="col ps-0 p-2">
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
        <div class="col pe-0 p-2">
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
        <div class="col-xl-8 p-0 pe-xl-4 mt-2 mt-lg-3">
            {{-- @livewire('grafik-dashboard', ['dataGrafig' => $dataGrafik, 'terapis' => $terapis, 'penyakit' => $penyakit]) --}}
            @livewire('grafik-dashboard')
            {{-- <x-grafik-dashboard :data-grafik="$dataGrafik" :terapis="$terapis" :penyakit="$penyakit" :maxChart="$maxChart"></x-grafik-dashboard>             --}}
        </div>
        
        {{-- terapis ready --}}
        <div class="col-xl-4 p-0 mt-3">
            @livewire('terapis-ready')
        </div>        
    </div>

    <div class="row main-bg mt-3 mt-lg-4" id="jadwal">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h4">Jadwal Terapi</h1>
        </div>

        {{-- <div class="d-flex flex-grow-1 justify-content-between flex-wrap flex-md-nowrap align-items-center align-items-sm-end px-0 px-sm-2 mb-3">
            <div class="col-sm-4">
                {{ $today }}
            </div>
            <div class="col-sm-8">
                <div class="row justify-content-end">
                    <div class="col-sm-9 col-xl-5">
                        <div class="form-control px-1 px-sm-2 py-0 d-flex flex-row justify-content-between align-items-center flex-wrap taginput" style="min-width: 128px;">
                            <input type="text" class="flex-grow-1 ps-2 py-2" id="startDate" placeholder="Pilih Hari" style="cursor: pointer; width: 100px">
                            <i class="bi bi-calendar2-event small icon-date pe-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row px-0 px-sm-2 mb-sm-3">
            <div class="text-center mb-2 mt-4 my-sm-0">
                {{ $today }}
            </div>
            <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4 mt-2">
                <div class="btn-group w-100">
                    <button type="button" class="form-control d-flex justify-content-between align-items-center" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <span>Pilih Tanggal</span>
                        <i class="bi bi-calendar2-week"></i>
                    </button>
                    <ul class="dropdown-menu w-100 shadow-lg">
                        <li><h6 class="dropdown-header">Berdasarkan Tanggal</h6></li>
                        <li class="px-3 pb-2 hstack stack-input-icon">
                            <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                                <i class="bi bi-calendar2-event text-body-tertiary"></i>
                            </div>
                            <input type="date" value="{{ request('tanggal') }}" id="date" class="form-control">
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Berdasarkan Range Tanggal</h6></li>
                        <li class="px-3 pb-2">
                            <div class="d-flex gap-2 w-100">
                                <label class="form-label flex-fill small m-0">Pilih Tgl Mulai:</label>
                                <label class="form-label flex-fill small m-0">Pilih Tgl Akhir:</label>
                            </div>
                            {{-- <div class="d-none d-sm-flex gap-2 w-100">
                                <input type="date" value="{{ request('mulai') }}" id="startDate" class="form-control" placeholder="Pilih Hari">
                                <input type="date" value="{{ request('akhir') }}" id="endDate" class="form-control" placeholder="Pilih Hari">
                            </div> --}}
                            
                            <div class="d-flex gap-2">
                                <div class="hstack stack-input-icon w-100 overflow-hidden">
                                    <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                                        <i class="bi bi-calendar2-plus text-body-tertiary"></i>
                                    </div>
                                    <input type="date" value="{{ request('mulai') }}" id="startDate" class="form-control">
                                </div>
                                <div class="hstack stack-input-icon w-100 overflow-hidden">
                                    <div class="d-block d-sm-none form-control pe-1 input-icon" style="width: auto;">
                                        <i class="bi bi-calendar2-check text-body-tertiary"></i>
                                    </div>
                                    <input type="date" value="{{ request('akhir') }}" id="endDate" class="form-control">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" id="dateBtn" class="btn btn-success btn-sm mt-3 align-content-end">Tampilkan</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="px-0 px-sm-2 overflow-auto">
            @if(count($jadwal_terapi) > 0)
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
                                <td class="text-capitalize text-center">{{ $jadwal->terapis->username }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-5 mb-3 p">
                    {{ $jadwal_terapi->appends(request()->query())->links() }}
                </div>
            @else
                <div class="alert alert-warning py-2 mt-3 d-inline-flex align-items-center fst-italic" role="alert">
                    <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
                    <div>Data pada tanggal yang dipilih tidak ditemukan.</div>
                </div>
            @endif
            
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
        inputDate.classList.remove("ps-2");
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
<script>
    const tunggal = document.querySelector('#date');
    const start = document.querySelector('#startDate');
    const end = document.querySelector('#endDate');
    const dateBtn = document.querySelector('#dateBtn');

    tunggal.addEventListener('change', function(){
        window.location.href = '/admin/dashboard?tanggal=' + tunggal.value;
    })

    dateBtn.addEventListener('click', function(){
        if(start.value == '') {
            start.classList.add('is-invalid');
        } else if(end.value == '') {
            start.classList.remove('is-invalid');
            end.classList.add('is-invalid');
        } else {
            end.classList.remove('is-invalid');
            window.location.href = '/admin/dashboard?mulai=' + start.value + '&akhir=' + end.value;
        }
    })
</script>
@if(request('tanggal') || request('mulai'))
    <script>
        window.onload = function() {
            // document.querySelector("#jadwal").scrollIntoView({
            //     behavior: "smooth",
            //     block: "start"
            // });
            window.location.hash = 'jadwal';
        };
    </script>
@endif
@livewireScripts
@endpush