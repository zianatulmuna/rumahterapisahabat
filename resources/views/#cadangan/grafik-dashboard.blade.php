<div>
    <div class="main-bg px-3 py-4 grafik-perkembangan" id="grafik">
        <div class="pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Manajemen Klinik</h1>
        </div>

        <div class="nav nav-tabs d-flex justify-content-between px-0">
            <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link px-2 px-sm-3 {{ $grafik == 'Sesi Terapi' ? 'active' : '' }}" id="terapi-tab" data-tab="tab" wire:click="setMenu('Sesi Terapi')">Sesi Terapi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link px-2 px-sm-3 {{ $grafik == 'Pasien Baru' ? 'active' : '' }}" id="baru-tab" data-tab="tab" wire:click="setMenu('Pasien Baru')">Pasien Baru</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link px-2 px-sm-3 {{ $grafik == 'Pasien Selesai' ? 'active' : '' }}" id="selesai-tab" data-tab="tab" wire:click="setMenu('Pasien Selesai')">Pasien Selesai</button>
                </li>
            </ul>
            <div class="d-none d-sm-block mb-2 mb-md-0">
                <div class="dropdown dropdown-filter-tahun">
                    <button class="btn dropdown-toggle btn-outline-success mx-0 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                        <span class="text-capitalize">{{ $filterTahun ? $tahun : $filter }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end rounded-2 shadow p-1" aria-labelledby="dropdownMenuButton">
                        <button type="button" class="dropdown-item" wire:click="setFilter('minggu ini')">Minggu Ini</button>
                        <button type="button" class="dropdown-item" wire:click="setFilter('tahun ini')">Tahun Ini</button>
                        <button type="button" class="dropdown-item" wire:click="setFilter('semua tahun')">Semua Tahun</button>
                        <div class="input-group p-2">
                            <input type="search" class="form-control py-0" name="tahunForm" id="tahunInput" min="2014" max="2023" placeholder="Tahun">
                            <button type="button" id="tahunBtn" class="btn btn-outline-success">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="tab-content py-3 border border-top-0" id="myTabContent">
            <div class="row row-cols-1 row-cols-sm-2 p-3 mb-3">
                <div class="col custom-search-grafik px-2 mb-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-terapis">
                        @if($grafik == 'Sesi Terapi')
                            <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    {{-- {{ {{ y }} ? request('terapis') : 'Pilih Terapis' }} --}}
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu px-3 w-100 shadow">
                                <div class="input-group py-2">
                                    <span class="input-group-text pe-1 bg-white border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-start-0 search-input" placeholder="Cari nama terapis">
                                </div>
                                <ul class="select-options"></ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col custom-search-grafik px-2 mb-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-penyakit">
                        <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>
                                {{ request('penyakit') ? request('penyakit') : 'Pilih Penyakit' }}
                            </span>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu px-3 w-100 shadow">
                            <div class="input-group py-2">
                                <span class="input-group-text pe-1 bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-start-0 search-input" placeholder="Cari penyakit">
                            </div>
                            <ul class="select-options"></ul>
                        </div>
                    </div>
                </div>
                <div class="d-block d-sm-none px-2 w-100">
                    @include('partials.filter-waktu')
                </div>
            </div>

            <canvas id="grafikChart"></canvas>

            <div class="text-center mt-3">
                <span class="text-center">
                    Data {{ $grafik }} {{ $filter }}
                </span>
            </div>
        </div>
    
    </div>
</div>

@push('script')
<script>
    document.addEventListener('livewire:load', function () {
        const inputTahun = document.querySelector('#tahunInput');
        const btnTahun = document.querySelector('#tahunBtn');

        btnTahun.addEventListener('click', function(e) {
            Livewire.emit('setTahun', inputTahun.value);
        });

        Livewire.on('chartUpdated', grafik => {
            updateChart(grafik.dataGrafik, grafik.maxChart); 
        });

        function updateChart(dataGrafik, max) {
            const value = Object.values(dataGrafik);
            const label = Object.keys(dataGrafik);
            const maxValue = max;

            const chart = new Chart("grafikChart", {
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
                        yAxes: [{ticks: {min: 0, max: maxValue}}],
                    }
                }
            });
        }

        updateChart(@json($dataGrafik), @json($maxChart));
    });

    // let dataTerapis = @json($terapis->toArray());
    // let dataPenyakit = @json($penyakit);
</script>    
{{-- <script src="/js/select-terapis-dashboard.js"></script>
<script src="/js/select-penyakit.js"></script> --}}
@endpush