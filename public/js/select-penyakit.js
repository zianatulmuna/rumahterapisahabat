const dropPenyakit = document.querySelector(".dropdown-penyakit");
let selectBtnPenyakit = dropPenyakit.querySelector("button");
let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
let optionsPenyakit = dropPenyakit.querySelector(".select-options");

addPenyakit();

function addPenyakit(selectedPenyakit) {
    optionsPenyakit.innerHTML = "";
    dataPenyakit.forEach(penyakit => {
        let penyakitQuery = `penyakit=${penyakit}`;
        let link = `/admin/dashboard?${queryString}${penyakitQuery}`;
        let isSelected = penyakit == selectedPenyakit ? "active" : "";
            let li = `<a href="${link}" class="text-decoration-none text-dark">
                        <li class="dropdown-item ${isSelected}" 
                            data-nama="${penyakit}" 
                            onclick="updateNamePenyakit(this)">
                            ${penyakit}                            
                        </li>
                    </a>`;
            optionsPenyakit.insertAdjacentHTML("beforeend", li);
    });
    }

function updateNamePenyakit(selectedLi) {
    searchInpPenyakit.value = "";
    addPenyakit(selectedLi.innerText);
    dropPenyakit.classList.remove("active");
    selectBtnPenyakit.firstElementChild.innerText = selectedLi.getAttribute('data-nama');
}

searchInpPenyakit.addEventListener("keyup", () => {
    let arr = [];
    let searchWord = searchInpPenyakit.value.toLowerCase();
    arr = dataPenyakit.filter(penyakit => {
        let data = penyakit;
        return data.toLowerCase().startsWith(searchWord);
    }).map(penyakit => {
        let penyakitQuery = `penyakit=${penyakit}`;
        let link = `/admin/dashboard?${queryString}${penyakitQuery}`;
        let isSelected = penyakit == selectBtnPenyakit.firstElementChild.innerText ? "active" : "";
        return `<a href="${link}" class="text-decoration-none text-dark">
                    <li class="dropdown-item ${isSelected}" 
                        data-nama="${penyakit}" 
                        onclick="updateNamePenyakit(this)">
                        ${penyakit}                            
                    </li>
                </a>`;
    }).join("");
    optionsPenyakit.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Data tidak ditemukan</p>`;
});

selectBtnPenyakit.addEventListener("click", () => dropPenyakit.classList.toggle("active"));
