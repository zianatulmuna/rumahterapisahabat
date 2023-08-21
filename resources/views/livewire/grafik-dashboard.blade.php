<div>
    <div class="main-bg px-3 py-4" id="grafik">
        <div class="pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Manajemen Klinik</h1>
        </div>

        <div class="nav nav-tabs d-flex justify-content-between px-0">
            <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="" class="nav-link active" id="terapi-tab" data-tab="tab">Sesi Terapi</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="" class="nav-link" id="baru-tab" data-tab="tab">Pasien Baru</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="" class="nav-link" id="selesai-tab" data-tab="tab">Pasien Selesai</a>
                </li>
            </ul>
            <div class="dropdown mb-2 mb-md-0">
                <button class="btn dropdown-toggle btn-outline-success" style="width: 100%; max-width: 300px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(request('filter') === 'tahun-ini')
                        Tahun Ini
                    @elseif(request('filter') === 'semua-tahun')
                        Semua tahun
                    @elseif(request('filter') === 'minggu')
                        Minggu Ini
                    @else
                        {{ request('filter') }}
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-right rounded-2 shadow" aria-labelledby="dropdownMenuButton">
                    @php
                        $filters = [
                            'minggu' => 'Minggu ini',
                            'tahun-ini' => 'Tahun ini',
                            'semua-tahun' => 'Semua Tahun',
                        ];
                    @endphp

                    @foreach ($filters as $filterValue => $filterText)
                        <a 
                            href="/admin/dashboard?{{ http_build_query(array_merge(request()->except('filter'), ['grafik' => request('grafik'), 'filter' => $filterValue])) }}" 
                            class="dropdown-item {{ Request::query('filter') == $filterValue ? 'active' : '' }}">                                
                            {{ $filterText }}
                        </a>
                    @endforeach
                    <form action="/admin/dashboard" class="input-group p-2">
                        @if(request('grafik'))
                            <input type="hidden" name="grafik" value="{{ request('grafik') }}">
                        @endif
                        @if(request('terapis'))
                            <input type="hidden" name="terapis" value="{{ request('terapis') }}">
                        @endif
                        @if(request('penyakit'))
                            <input type="hidden" name="penyakit" value="{{ request('penyakit') }}">
                        @endif
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
                        @if(request('grafik') == 'sesi-terapi')
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
            <div class="tab-pane fade show active" id="sesiTerapi" role="tabpanel" aria-labelledby="terapi-tab">
                <canvas id="grafikChart"></canvas>
            </div>
            <div class="tab-pane fade" id="pasienBaru" role="tabpanel" aria-labelledby="baru-tab">
                <canvas id="grafikChart"></canvas>
            </div>
            <div class="tab-pane fade" id="pasienSelesai" role="tabpanel" aria-labelledby="selesai-tab">
                <canvas id="grafikChart"></canvas>
            </div>
            <div class="text-center mt-3">
                <span class="text-center">
                    @if(request('filter') === 'tahun-ini')
                        Data {{ request('grafik') }} tahun Ini
                    @elseif(request('filter') === 'semua-tahun')
                        Data {{ request('grafik') }} setiap tahun
                    @elseif(request('filter') === 'minggu')
                        Data {{ request('grafik') }} minggu ini
                    @else
                        Data {{ request('grafik') }} tahun {{ request('tahun') }}
                    @endif
                    {{ request('terapis') ? 'oleh terapis ' . request('terapis') : '' }}
                    {{ request('penyakit') ? 'berdasarkan penyakit ' . request('penyakit') : '' }}
                </span>
            </div>
        </div>
    
    </div>
</div>

@push('script')
<script>
    const value=  @json(array_values($dataGrafik));
    const label = @json(array_keys($dataGrafik));
    const maxValue = @json($maxChart)
    
    new Chart("grafikChart", {
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
        yAxes: [{ticks: {min: 0, max:maxValue}}],
        }
    }
    });

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

    const terapiTab = document.querySelector('#terapi-tab');
    const baruTab = document.querySelector('#baru-tab');
    const selesaiTab = document.querySelector('#selesai-tab');

    terapiTab.classList.remove('active');
    baruTab.classList.remove('active');
    selesaiTab.classList.remove('active');

    if (grafikValue === 'pasien-baru') {
        baruTab.classList.add('active');
    } else if (grafikValue === 'pasien-selesai') {
        selesaiTab.classList.add('active');
    } else if (grafikValue === 'sesi-terapi') {
        terapiTab.classList.add('active');
    }
</script>    
<script src="/js/select-terapis-grafik.js"></script>
<script src="/js/select-penyakit.js"></script>
@endpush