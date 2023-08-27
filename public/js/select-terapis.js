const dropTerapis = document.querySelector(".dropdown-terapis");
let selectBtnTerapis = dropTerapis.querySelector("button");
let searchInpTerapis = dropTerapis.querySelector(".search-input");
let optionsTerapis = dropTerapis.querySelector(".select-options");

let idTerapis = dropTerapis.querySelector("#id_terapis");

let oldIdTerapis = idTerapis.value;     

if(oldIdTerapis != '') {
    let namaOld = dataTerapis.find(terapis => terapis.id_terapis === oldIdTerapis);
    selectBtnTerapis.firstElementChild.innerText = namaOld.nama;
}

addTerapis();

function addTerapis(selectedTerapis) {
    optionsTerapis.innerHTML = "";
    dataTerapis.forEach(terapis => {
        let isSelected = terapis.nama == selectedTerapis ? "active" : "";
            let li = `<li class="dropdown-item d-flex justify-content-between ${isSelected}" 
                            data-id="${terapis.id_terapis}" 
                            data-nama="${terapis.nama}" 
                            onclick="updateNameTerapis(this)">
                            <div class="col-8 text-truncate">${terapis.nama}</div>
                            <div class="small fst-italic">${terapis.tingkatan}</div>
                        </li>`;
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

// searchInpTerapis.addEventListener("keyup", () => {
//     let arr = [];
//     let searchWord = searchInpTerapis.value.toLowerCase();
//     arr = dataTerapis.filter(terapis => {
//         let data = terapis.nama;
//         return data.toLowerCase().startsWith(searchWord);
//     }).map(terapis => {
//         let isSelected = terapis.nama == selectBtnTerapis.firstElementChild.innerText ? "active" : "";
//         return `<li class="dropdown-item d-flex justify-content-between ${isSelected}" 
//                     data-id="${terapis.id_terapis}" 
//                     data-nama="${terapis.nama}" 
//                     onclick="updateNameTerapis(this)">
//                     <div class="col-8 text-truncate">${terapis.nama}</div>
//                     <div class="small fst-italic">${terapis.tingkatan}</div>
//                 </li>`;
//     }).join("");
//     optionsTerapis.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
// });
searchInpTerapis.addEventListener("keyup", () => {
    let arr = [];
    let searchWords = searchInpTerapis.value.toLowerCase().split(' ');
    arr = dataTerapis.filter(terapis => {
      let data = terapis.nama.toLowerCase();
      return searchWords.every(word => data.includes(word));
    }).map(terapis => {
      let isSelected = terapis.nama == selectBtnTerapis.firstElementChild.innerText ? "active" : "";
      return `<li class="dropdown-item d-flex justify-content-between ${isSelected}" 
                  data-id="${terapis.id_terapis}" 
                  data-nama="${terapis.nama}" 
                  onclick="updateNameTerapis(this)">
                  <div class="col-8 text-truncate">${terapis.nama}</div>
                  <div class="small fst-italic">${terapis.tingkatan}</div>
              </li>`;
    }).join("");
    optionsTerapis.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
  });
  

selectBtnTerapis.addEventListener("click", () => dropTerapis.classList.toggle("active"));
