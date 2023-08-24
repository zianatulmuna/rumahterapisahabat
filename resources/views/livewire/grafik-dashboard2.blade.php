<div>
    <div class="main-bg px-3 py-4" id="grafik">
        <div class="pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Manajemen Klinik</h1>
        </div>

        <div class="nav nav-tabs d-flex justify-content-between px-0">
            {{-- filter menu --}}
            <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link {{ $grafik == 'Sesi Terapi' ? 'active' : '' }}" id="terapi-tab" data-tab="tab" wire:click="setMenu('Sesi Terapi')">Sesi Terapi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link {{ $grafik == 'Pasien Baru' ? 'active' : '' }}" id="baru-tab" data-tab="tab" wire:click="setMenu('Pasien Baru')">Pasien Baru</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link {{ $grafik == 'Pasien Selesai' ? 'active' : '' }}" id="selesai-tab" data-tab="tab" wire:click="setMenu('Pasien Selesai')">Pasien Selesai</button>
                </li>
            </ul>
            {{-- filter waktu --}}
            <div class="dropdown mb-2 mb-md-0">
                <button class="btn dropdown-toggle btn-outline-success" style="width: 100%; max-width: 300px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-capitalize">{{ $filter }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right rounded-2 shadow" aria-labelledby="dropdownMenuButton">
                    <button type="button" class="dropdown-item" wire:click="setFilter('minggu ini')">Minggu Ini</button>
                    <button type="button" class="dropdown-item" wire:click="setFilter('tahun ini')">Tahun Ini</button>
                    <button type="button" class="dropdown-item" wire:click="setFilter('semua tahun')">Semua Tahun</button>
                    <form action="/admin/dashboard" class="input-group p-2">
                        <input type="search" class="form-control py-0" name="filter" id="tahunInput" min="2014" max="2023" placeholder="Tahun">
                        <button type="submit" id="btnTahun" class="btn btn-outline-success">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div> 
            </div>
        </div>

        <div class="tab-content py-3 border border-top-0" id="myTabContent">
            <div class="row p-3 mb-3">
                <div class="col custom-search-grafik px-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-terapis">
                        @if($menu = 'Sesi Terapi')
                            <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    {{ request('terapis') ? request('terapis') : 'Pilih Terapis' }}
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu px-3 w-100 shadow">
                                <div class="input-group py-2">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control search-input" placeholder="Cari nama terapis">
                                </div>
                                <ul class="select-options"></ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col custom-search-grafik px-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-penyakit">
                        <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>
                                {{ request('penyakit') ? request('penyakit') : 'Pilih Penyakit' }}
                            </span>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu px-3 w-100 shadow">
                            <div class="input-group py-2">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control search-input" placeholder="Cari penyakit">
                            </div>
                            <ul class="select-options"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="grafikChart"></canvas>
            </div>
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
        Livewire.on('chartUpdated', dataGrafik => {
            updateChart(dataGrafik); 
        });

        function updateChart(dataGrafik) {
            const value = Object.values(dataGrafik);
            const label = Object.keys(dataGrafik);
            const maxValue = @json($maxChart);

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

        updateChart(@json($dataGrafik));
    });
    // document.addEventListener('livewire:load', function () {
    //     Livewire.on('chartUpdated', () => {
    //         updateChart(); 
    //     });

    //     function updateChart() {
    //         const value=  @json(array_values($dataGrafik));
    //         const label = @json(array_keys($dataGrafik));
    //         const maxValue = @json($maxChart)

    //         const chart = new Chart("grafikChart", {
    //             type: "line",
    //             data: {
    //                 labels: label,
    //                 datasets: [{
    //                     fill: false,
    //                     lineTension: 0,
    //                     backgroundColor: "rgba(0,0,255,1.0)",
    //                     borderColor: "rgba(0,0,255,0.1)",
    //                     data: value
    //                 }]
    //             },
    //             options: {
    //                 legend: {display: false},
    //                 scales: {
    //                     yAxes: [{ticks: {min: 0, max: maxValue}}],
    //                 }
    //             }
    //         });
    //     }

    //     updateChart();
    // });

    let dataTerapis = @json($terapis->toArray());
    let dataPenyakit = @json($penyakit);

    let grafikQuery = '{{ Request::query('grafik') }}';
    let filterQuery = '{{ Request::query('filter') }}';
    let terapisQuery = '{{ Request::query('terapis') }}';
    let penyakitQuery = '{{ Request::query('penyakit') }}';

    let queryString = '';
    queryString += grafikQuery ? `grafik=${grafikQuery}&` : '';
    queryString += filterQuery ? `filter=${filterQuery}&` : '';
    queryString += terapisQuery ? `terapis=${terapisQuery}&` : '';
    queryString += penyakitQuery ? `penyakit=${penyakitQuery}&` : '';

    const grafikValue = '{{ request('grafik') }}';

    // const terapiTab = document.querySelector('#terapi-tab');
    // const baruTab = document.querySelector('#baru-tab');
    // const selesaiTab = document.querySelector('#selesai-tab');

    // terapiTab.classList.remove('active');
    // baruTab.classList.remove('active');
    // selesaiTab.classList.remove('active');

    // if (grafikValue === 'pasien-baru') {
    //     baruTab.classList.add('active');
    // } else if (grafikValue === 'pasien-selesai') {
    //     selesaiTab.classList.add('active');
    // } else if (grafikValue === 'sesi-terapi') {
    //     terapiTab.classList.add('active');
    // }
</script>    
<script src="/js/select-terapis-grafik.js"></script>
<script src="/js/select-penyakit.js"></script>
@endpush