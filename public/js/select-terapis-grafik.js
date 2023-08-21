const dropTerapis = document.querySelector(".dropdown-terapis");
let selectBtnTerapis = dropTerapis.querySelector("button");
let searchInpTerapis = dropTerapis.querySelector(".search-input");
let optionsTerapis = dropTerapis.querySelector(".select-options");

addTerapis();

function addTerapis(selectedTerapis) {
    optionsTerapis.innerHTML = "";
    dataTerapis.forEach(terapis => {
        let terapisQuery = `terapis=${terapis.nama}`;
        let link = `/admin/dashboard?${queryString}${terapisQuery}`;
        let isSelected = terapis.nama == selectedTerapis ? "active" : "";
        let li = `
                    <li class="dropdown-item ${isSelected}" 
                        data-id="${terapis.id_terapis}" 
                        data-nama="${terapis.nama}" 
                        onclick="updateNameTerapis(this)">
                        <a href="${link}" class="text-decoration-none text-dark d-flex justify-content-between">
                            <p class="m-0">${terapis.nama}</p>
                            <p class="m-0 small fst-italic">${terapis.tingkatan}</p>
                        </a>
                    </li>
                `;     
        optionsTerapis.insertAdjacentHTML("beforeend", li);
    });
    }

function updateNameTerapis(selectedLi) {
    searchInpTerapis.value = "";
    addTerapis(selectedLi.innerText);
    dropTerapis.classList.remove("active");
    selectBtnTerapis.firstElementChild.innerText = selectedLi.getAttribute('data-nama');
    idTerapis.value = selectedLi.getAttribute('data-id');
}

searchInpTerapis.addEventListener("keyup", () => {
    let arr = [];
    let searchWord = searchInpTerapis.value.toLowerCase();
    arr = dataTerapis.filter(terapis => {
        let data = terapis.nama;
        return data.toLowerCase().startsWith(searchWord);
    }).map(terapis => {
        let terapisQuery = `terapis=${terapis.nama}`;
        let link = `/admin/dashboard?${queryString}${terapisQuery}`;
        let isSelected = terapis.nama == selectBtnTerapis.firstElementChild.innerText ? "active" : "";
        return `<li class="dropdown-item d-flex justify-content-between ${isSelected}" 
                    data-id="${terapis.id_terapis}" 
                    data-nama="${terapis.nama}" 
                    onclick="updateNameTerapis(this)">
                    <a href="${link}" class="text-decoration-none text-dark d-flex justify-content-between">
                        <p class="m-0">${terapis.nama}</p>
                        <p class="m-0 small fst-italic">${terapis.tingkatan}</p>
                    </a>
                </li>`;
    }).join("");
    optionsTerapis.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
});

selectBtnTerapis.addEventListener("click", () => dropTerapis.classList.toggle("active"));

// {{ Request::query('grafik') != '' ? 'grafik=' . request('grafik') . '&' : '' }}{{ Request::query('filter') != '' ? '&filter=' . request('filter') . '&' : '' }}