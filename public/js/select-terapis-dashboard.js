const dropTerapis = document.querySelector(".dropdown-terapis");
let selectBtnTerapis = dropTerapis.querySelector("button");
let searchInpTerapis = dropTerapis.querySelector(".search-input");
let optionsTerapis = dropTerapis.querySelector(".select-options");

function addTerapis(selectedTerapis) {
    optionsTerapis.innerHTML = "";
    dataTerapis.forEach(terapis => {
        let isSelected = terapis.nama == selectedTerapis ? "active" : "";
        let li = `
                    <li class="dropdown-item ps-1 ${isSelected}" 
                        data-id="${terapis.id_terapis}" 
                        data-nama="${terapis.nama}">
                        <button type="button" class="nav-link text-decoration-none text-dark d-flex justify-content-between w-100" wire:click="setTerapis('${terapis.id_terapis}')">
                            <span class="col-8 text-start text-truncate">${terapis.nama}</span>
                            <span class="small fst-italic">${terapis.tingkatan}</span>
                        </button>
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

// {{ Request::query('grafik') != '' ? 'grafik=' . request('grafik') . '&' : '' }}{{ Request::query('filter') != '' ? '&filter=' . request('filter') . '&' : '' }}