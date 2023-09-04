<div>
    <div class="main-bg px-3 py-4 grafik-perkembangan" id="grafik">
        <div class="pb-2 mb-3 border-bottom">
            <h1 class="h4">Grafik Sesi Terapi</h1>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="row row-cols-1 mb-3 p-3 {{ $userTerapis ? 'row-cols-sm-2 px-sm-4' : 'row-cols-sm-3' }}">
                {{-- penyakit --}}
                <div class="col px-1 mb-2 my-sm-2 my-md-0 col-sm-8 px-sm-2">                      
                    <div class="dropdown w-100 search-dinamis dropdown-penyakit">
                        <button class="form-control d-flex justify-content-between align-items-center {{ $nama_penyakit ? 'border-success text-success' : '' }} @error('id_terapis') is-invalid @enderror" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-truncate" id="namaPenyakit">
                                {{ $nama_penyakit ? $nama_penyakit : 'Pilih Penyakit' }}
                            </span>
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu px-2 py-1 w-100 bg-body-tertiary shadow">
                            <div class="input-group py-2">
                                <span class="input-group-text pe-1 bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-start-0 search-input" placeholder="Cari penyakit">
                            </div>
                            <ul class="select-options bg-white rounded m-0"></ul>
                            <div class="text-center text-secondary small py-2">
                                <a class="text-reset text-decoration-none" style="cursor: pointer;" data-nama="" onclick="setPenyakitToController(this)"><i class="bi bi-trash3"></i> Hapus Pilihan</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-4 {{ $userTerapis ? '' : 'col-lg-3' }} px-1 my-sm-2 my-md-0">
                    @include('partials.filter-waktu')
                </div>
            </div> 
            <canvas id="grafikChart"></canvas>

            <div class="text-center mt-3">
                <span class="text-center">
                    Data {{ $grafik }}{{ $nama_penyakit ? ' penyakit ' . $nama_penyakit : '' }} {{ $filter }} {{ $filter == 'tahun' ? $tahun : '' }}
                    {{ $nama_terapis ? 'oleh terapis ' . $nama_terapis : '' }}
                </span>
            </div>
        </div>
    
    </div>
</div>

@push('script')
{{-- script terapis --}}
@unless($userTerapis)
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

    function addTerapis() {
        optionsTerapis.innerHTML = "";
        dataTerapis.forEach(terapis => {
            let isSelected = terapis.nama == document.querySelector("#namaTerapis").innerText ? "active" : "";
            let li = `
                        <li class="dropdown-item ${isSelected}" 
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
            let isSelected = terapis.nama == document.querySelector("#namaTerapis").innerText ? "active" : "";
            return `
                        <li class="dropdown-item ${isSelected}" 
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
        }).join("");
        optionsTerapis.innerHTML = arr ? arr : `<p class="p-2 m-0">Oops! Data tidak ditemukan</p>`;
    });

    selectBtnTerapis.addEventListener("click", () => {
        dropTerapis.classList.toggle("active");
        addTerapis();
    });
</script>
@endunless
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

    function addPenyakit() {
        optionsPenyakit.innerHTML = "";
        dataPenyakit.forEach(penyakit => {
            let isSelected = penyakit == document.querySelector("#namaPenyakit").innerText ? "active" : "";
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
            let isSelected = penyakit == document.querySelector("#namaPenyakit").innerText ? "active" : "";
            return `<li class="dropdown-item ${isSelected}" 
                        data-nama="${penyakit}" 
                        onclick="setPenyakitToController(this)">
                        ${penyakit}                            
                    </li>
                    `;
        }).join("");
        optionsPenyakit.innerHTML = arr ? arr : `<p class="p-2 m-0">Oops! Data tidak ditemukan</p>`;
    });

    selectBtnPenyakit.addEventListener("click", () => {
        dropPenyakit.classList.toggle("active");
        addPenyakit();
    });

</script>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('chartUpdated', grafik => {
            updateChart(grafik.dataGrafik, grafik.maxChart);    

            // addTerapis();      
            // addPenyakit();      
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
</script>
@endpush