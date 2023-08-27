<div>
    <div class="main-bg px-3 py-4 grafik-perkembangan" id="grafik">
        <div class="pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Manajemen Klinik</h1>
        </div>

        <div class="nav nav-tabs px-0">
            {{-- menu --}}
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
            {{-- waktu --}}
            {{-- <div class="d-none d-sm-block mb-2 mb-md-0">
                @include('partials.filter-waktu')
            </div> --}}
        </div>

        <div class="tab-content py-3 border border-top-0" id="myTabContent">
            <div class="row row-cols-1 row-cols-sm-3 p-3 mb-3">
                {{-- terapis --}}
                <div class="col col-sm-4 col-lg-5 px-1 mb-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-terapis">
                        {{-- @if($grafik == 'Sesi Terapi') --}}
                            <button class="form-control d-flex justify-content-between align-items-center {{ $nama_terapis ? 'border-success text-success' : '' }} @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false" {{ $grafik != 'Sesi Terapi' ? 'disabled' : '' }}>
                                <span>
                                    @if($grafik == 'Sesi Terapi')
                                        {{ $nama_terapis ? $nama_terapis : 'Pilih Terapis' }}
                                    @endif
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
                        {{-- @endif --}}
                    </div>
                </div>
                {{-- penyakit --}}
                <div class="col col-sm-4 px-1 mb-2 my-sm-2 my-md-0">                      
                    <div class="dropdown w-100 search-dinamis dropdown-penyakit">
                        <button class="form-control d-flex justify-content-between align-items-center {{ $nama_penyakit ? 'border-success text-success' : '' }} @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>
                                {{ $nama_penyakit ? $nama_penyakit : 'Pilih Penyakit' }}
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
                <div class="col col-sm-4 col-lg-3 px-1 my-sm-2 my-md-0">
                    @include('partials.filter-waktu')
                </div>
            </div>

            <canvas id="grafikChart"></canvas>

            <div class="text-center mt-3">
                <span class="text-center">
                    Data {{ $grafik }} {{ $filter }} {{ $filter == 'tahun' ? $tahun : '' }}
                    {{ $nama_terapis ? 'oleh terapis ' . $nama_terapis : '' }}
                    {{ $nama_penyakit ? 'berdasarkan penyakit ' . $nama_penyakit : '' }}
                </span>
            </div>
        </div>
    
    </div>
</div>

@push('script')
{{-- script terapis --}}
<script>
    let dataTerapis = @json($terapis->toArray());

    const dropTerapis = document.querySelector(".dropdown-terapis");
    let selectBtnTerapis = dropTerapis.querySelector("button");
    let searchInpTerapis = dropTerapis.querySelector(".search-input");
    let optionsTerapis = dropTerapis.querySelector(".select-options");

    function setTerapisToController(selectedLi) {
        let id = selectedLi.getAttribute('data-id');
        let nama = selectedLi.getAttribute('data-nama');
        Livewire.emit('setTerapis', { id: id, nama: nama });
    };

    function addTerapis(selectedTerapis) {
        optionsTerapis.innerHTML = "";
        dataTerapis.forEach(terapis => {
            let isSelected = terapis.nama == selectedTerapis ? "active" : "";
            let li = `
                        <li class="dropdown-item ps-1 ${isSelected}" 
                            id="terapisOption"
                            data-id="${terapis.id_terapis}" 
                            data-nama="${terapis.nama}"
                            onclick="setTerapisToController(this)">
                            <p class="m-0 d-flex justify-content-between w-100" >
                                <span class="col-8 text-start text-truncate">${terapis.nama}</span>
                                <span class="small fst-italic">${terapis.tingkatan}</span>
                            </p>
                        </li>
                    `;     
            optionsTerapis.insertAdjacentHTML("beforeend", li);
        });
    }

    searchInpTerapis.addEventListener("keyup", () => {
        let arr = [];
        let searchWords = searchInpTerapis.value.toLowerCase().split(' ');
        arr = dataTerapis.filter(terapis => {
            let data = terapis.nama.toLowerCase();
            return searchWords.every(word => data.includes(word));
        }).map(terapis => {
            let isSelected = terapis.nama == selectBtnTerapis.firstElementChild.innerText ? "active" : "";
            return `
                    <li class="dropdown-item ps-1 ${isSelected}" 
                        data-id="${terapis.id_terapis}" 
                        data-nama="${terapis.nama}" 
                        onclick="updateNameTerapis(this)">
                        <button type="button" class="nav-link text-decoration-none text-dark d-flex justify-content-between w-100" wire:click="setTerapis('${terapis.id_terapis}')">
                            <span class="col-8 text-start text-truncate">${terapis.nama}</span>
                            <span class="small fst-italic">${terapis.tingkatan}</span>
                        </button>
                    </li>
                    `;  
        }).join("");
        optionsTerapis.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
    });

    selectBtnTerapis.addEventListener("click", () => dropTerapis.classList.toggle("active"));
</script>

{{-- script penyakit --}}
<script>    
    let dataPenyakit = @json($penyakit);

    const dropPenyakit = document.querySelector(".dropdown-penyakit");
    let selectBtnPenyakit = dropPenyakit.querySelector("button");
    let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
    let optionsPenyakit = dropPenyakit.querySelector(".select-options");

    function setPenyakitToController(selectedLi) {
        let nama = selectedLi.getAttribute('data-nama');
        Livewire.emit('setPenyakit', nama);
    };

    function addPenyakit(selectedPenyakit) {
        optionsPenyakit.innerHTML = "";
        dataPenyakit.forEach(penyakit => {
            let isSelected = penyakit == selectedPenyakit ? "active" : "";
                let li = `
                            <li class="dropdown-item ${isSelected}" 
                                data-nama="${penyakit}" 
                                onclick="setPenyakitToController(this)">
                                ${penyakit}                            
                            </li>
                        `;
                optionsPenyakit.insertAdjacentHTML("beforeend", li);
        });
    }

    searchInpPenyakit.addEventListener("keyup", () => {
        let arr = [];
        let searchWords = searchInpPenyakit.value.toLowerCase().split(' ');
        arr = dataPenyakit.filter(penyakit => {
            let data = penyakit.toLowerCase();
            return searchWords.every(word => data.includes(word));
        }).map(penyakit => {
            let isSelected = penyakit == selectBtnPenyakit.firstElementChild.innerText ? "active" : "";
            return `<li class="dropdown-item ${isSelected}" 
                        data-nama="${penyakit}" 
                        onclick="setPenyakitToController(this)">
                        ${penyakit}                            
                    </li>
                    `;
        }).join("");
        optionsPenyakit.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
    });

    selectBtnPenyakit.addEventListener("click", () => dropPenyakit.classList.toggle("active"));

</script>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('chartUpdated', grafik => {
            updateChart(grafik.dataGrafik, grafik.maxChart);    

            addTerapis('');      
            addPenyakit('');      
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
        addTerapis();
        addPenyakit();
    });
</script>
@endpush