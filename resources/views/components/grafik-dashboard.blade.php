<div>
    <div class="main-bg px-3 py-4 grafik-perkembangan" id="grafik">
        <div class="pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Manajemen Klinik</h1>
        </div>

        <div class="nav nav-tabs d-flex justify-content-between px-0">
            <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="/admin/dashboard?grafik=sesi terapi{{ Request::query('filter') != '' ? '&filter=' . request('filter') : '' }}{{ Request::query('penyakit') != '' ? '&penyakit=' . request('penyakit') : '' }}" class="nav-link px-2 px-sm-3 active" id="terapi-tab" data-tab="tab">Sesi Terapi</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="/admin/dashboard?grafik=pasien baru{{ Request::query('filter') != '' ? '&filter=' . request('filter') : '' }}{{ Request::query('penyakit') != '' ? '&penyakit=' . request('penyakit') : '' }}" class="nav-link px-2 px-sm-3" id="baru-tab" data-tab="tab">Pasien Baru</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="/admin/dashboard?grafik=pasien selesai{{ Request::query('filter') != '' ? '&filter=' . request('filter') : '' }}{{ Request::query('penyakit') != '' ? '&penyakit=' . request('penyakit') : '' }}" class="nav-link px-2 px-sm-3" id="selesai-tab" data-tab="tab">Pasien Selesai</a>
                </li>
            </ul>
            <div class="d-none d-sm-block mb-2 mb-md-0">
                @include('partials.filter-waktu')
            </div>
        </div>

        <div class="tab-content py-3 border border-top-0" id="myTabContent">
            <div class="row row-cols-1 row-cols-sm-2 p-3 mb-3">
                <div class="col custom-search-grafik px-2 mb-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-terapis">
                        @if(request('grafik') == 'sesi terapi')
                            <button class="form-control d-flex justify-content-between align-items-center @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>
                                    {{ request('terapis') ? request('terapis') : 'Pilih Terapis' }}
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
                        Data {{ request('grafik') }} tahun ini
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

    if (grafikValue === 'pasien baru') {
        baruTab.classList.add('active');
    } else if (grafikValue === 'pasien selesai') {
        selesaiTab.classList.add('active');
    } else if (grafikValue === 'sesi terapi') {
        terapiTab.classList.add('active');
    }
</script>    
<script src="/js/select-terapis-grafik.js"></script>
<script src="/js/select-penyakit.js"></script>
@endpush