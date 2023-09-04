const dropPasien = document.querySelector(".dropdown-pasien");
let selectBtnPasien = dropPasien.querySelector("button");
let searchInpPasien = dropPasien.querySelector(".search-input");
let optionsPasien = dropPasien.querySelector(".select-options");

let idPasien = dropPasien.querySelector("#id_pasien");
let telp = document.querySelector('#no_telp');
let gender = document.querySelector('#jenis_kelamin');
let birth = document.querySelector('#tanggal_lahir');

let oldIdPasien = idPasien.value;     

if(oldIdPasien != '') {
    let namaOld = dataPasien.find(pasien => pasien.id_pasien === oldIdPasien);
    selectBtnPasien.firstElementChild.innerText = namaOld.nama;
}

addPasien();

function addPasien(selectedPasien) {
    optionsPasien.innerHTML = "";
    dataPasien.forEach(pasien => {
        let isSelected = pasien.nama == selectedPasien ? "active" : "";
            let li = `<li class="dropdown-item ${isSelected}" 
                            data-id="${pasien.id_pasien}" 
                            data-nama="${pasien.nama}" 
                            data-telp="${pasien.no_telp}" 
                            data-birth="${pasien.tanggal_lahir}" 
                            data-gender="${pasien.jenis_kelamin}"
                            onclick="updateNamePasien(this)">
                            ${pasien.nama}
                    </li>`;
            optionsPasien.insertAdjacentHTML("beforeend", li);
    });
    }

function updateNamePasien(selectedLi) {
    searchInpPasien.value = "";
    addPasien(selectedLi.innerText);
    dropPasien.classList.remove("active");
    selectBtnPasien.firstElementChild.innerText = selectedLi.getAttribute('data-nama');
    idPasien.value = selectedLi.getAttribute('data-id');
    telp.value = selectedLi.getAttribute('data-telp');
    gender.value = selectedLi.getAttribute('data-gender');
    birth.value = selectedLi.getAttribute('data-birth');

    setTimeout(function() {
        pasienChange();
    }, 1000);
}

searchInpPasien.addEventListener("keyup", () => {
    let arr = [];
    let searchWords = searchInpPasien.value.toLowerCase().split(' ');
    arr = dataPasien.filter(pasien => {
        let data = pasien.nama.toLowerCase();
        return searchWords.every(word => data.includes(word));
    }).map(pasien => {
        let isSelected = pasien.nama == selectBtnPasien.firstElementChild.innerText ? "active" : "";
        return `<li class="dropdown-item${isSelected}" 
                    data-id="${pasien.id_pasien}" 
                    data-nama="${pasien.nama}" 
                    data-telp="${pasien.no_telp}" 
                    data-birth="${pasien.tanggal_lahir}" 
                    data-gender="${pasien.jenis_kelamin}"
                    onclick="updateNamePasien(this)">
                    ${pasien.nama}
                </li>`;
    }).join("");
    optionsPasien.innerHTML = arr ? arr : `<p class="p-2 m-0">Oops! Data tidak ditemukan</p>`;
});

selectBtnPasien.addEventListener("click", () => dropPasien.classList.toggle("active"));
