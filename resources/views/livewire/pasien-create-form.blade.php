
@php
  $addRMPage = $id_rekam_medis == null && $id_pasien != null ? 1 : 0;
  $editPage = $id_rekam_medis != null && $id_pasien != null ? 1 : 0;
@endphp
<div>
  <div class="main-bg">

    @include('partials.form-pasien-step')

    <form wire:submit.prevent='create' class="main-form" id="createForm" enctype="multipart/form-data">
      @csrf
      <div class="tab-content m-0" id="nav-tabContent">
        @include('partials.form-pasien-1')
        @include('partials.form-pasien-2')
        @include('partials.form-pasien-3')
        @include('partials.form-pasien-4')
        @include('partials.form-pasien-5')
        @include('partials.form-pasien-6')
        
        {{-- button step --}}
        <div class="d-flex justify-content-between my-5 mx-3 mb-md-5 mx-md-5 form-navigation">
          @if($currentStep == 1)
            <div></div>           
          @endif

          @if($currentStep >= 2 && $currentStep <= 6)
            <button class="btn btn-secondary" type="button" onclick="toTop()" wire:click="toPrev()">Sebelumnya</button>            
          @endif
          
          @if($currentStep >= 1 && $currentStep <= 5)     
            <button class="btn c-btn-success px-3 px-md-4 py-md-2" type="button" onclick="toTop()" wire:click="toNext()">Lanjut</button>
          @endif

          @if($currentStep == 6)
            <button type="submit" class="btn btn-success px-3 px-md-4 py-md-2" onclick="toSubmit()">Kirim</button>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
  
@push('script')
  <script>
    const target = document.querySelector(".main-bg");
    
    function capEach(inputId) {
      var input = document.getElementById(inputId);
        let words = input.value.split(' ');
  
        for (let i = 0; i < words.length; i++) {
            if (words[i].length > 0) {
                words[i] = words[i][0].toUpperCase() + words[i].substring(1);
            }
        }
  
        input.value = words.join(' ');
    } 
  
    function capFirst(inputId) {
      var input = document.getElementById(inputId);
      var word = input.value;
  
      if (word.length > 0) {
        var capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
        input.value = capitalizedWord;
      }
    } 
  
    function toTop() {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start"
      });
    }
  
    function addPenyakitToController(newTag) {
      Livewire.emit('addTagPenyakit', newTag);
      document.querySelector(".search-input").value = "";
    };
  
    function setAlamatToController(tempat, kode, provId, jalan, provinsi, kabupaten) {
      Livewire.emit('setAlamatKode', { tempat: tempat, kode: kode, provId: provId, jalan: jalan, provinsi: provinsi, kabupaten: kabupaten });
    };
  
    document.addEventListener('livewire:load', function () {
      
      Livewire.on('runScriptPenyakit', function () {
        let dataPenyakit = @json($listPenyakit);
  
        const dropPenyakit = document.querySelector(".dropdown-penyakit");
        let searchInpPenyakit = dropPenyakit.querySelector(".search-input");
        let optionsPenyakit = dropPenyakit.querySelector(".select-options");
        let dropdown = dropPenyakit.querySelector(".dropdown-dinamis");      
        let tambahBtn = dropPenyakit.querySelector("#hiddenTambahBtn");
  
        function addPenyakit() {
          optionsPenyakit.innerHTML = "";
          dataPenyakit.forEach(penyakit => {
                let li = `
                          <li class="dropdown-item" 
                              data-nama="${penyakit}" 
                              onclick="addPenyakitToController('${penyakit}')">
                              ${penyakit}                            
                          </li>
                        `;
                optionsPenyakit.insertAdjacentHTML("beforeend", li);
          });
        }
  
        searchInpPenyakit.addEventListener('keydown', function(event) {
          const value = searchInpPenyakit.value;
          dropdown.style.display = 'block';
  
          let arr = [];
          let searchWords = searchInpPenyakit.value.toLowerCase().split(' ');
          arr = dataPenyakit.filter(penyakit => {
              let data = penyakit.toLowerCase();
              return searchWords.every(word => data.includes(word));
          }).map(penyakit => {
              return `<button type="button" class="dropdown-item px-2" 
                          data-nama="${penyakit}"
                          onclick="addPenyakitToController('${penyakit}')">
                          ${penyakit}                            
                      </button>
                      `;
          }).join("");
  
          if(arr) {
            optionsPenyakit.innerHTML = arr;
          } else {
            dropdown.style.display = 'none';
          }

          if (event.key === "Enter" || (event.key === ",")) {
            if(value != "") {
              const trimmedValue = value.replace(/,$/, '');
              addPenyakitToController(trimmedValue);

              searchInpPenyakit.value = "";
            }
          }
          if (event.key === 'Enter') {
            event.preventDefault(); 
          }
        });
  
        tambahBtn.addEventListener("click", function() {
          if(searchInpPenyakit.value != '') {
            addPenyakitToController(searchInpPenyakit.value);
          }
          searchInpPenyakit.value = "";
        });
  
        searchInpPenyakit.addEventListener("focus", function() {
          addPenyakit();
          dropdown.style.display = 'block';
        });
  
        document.addEventListener('click', function(event) {
          if (!searchInpPenyakit.contains(event.target)) {
            dropdown.style.display = 'none';
          }
        });
      }); 
      
      Livewire.on('runScriptAlamat', kab_prov => {
        const provinsiSelect = document.querySelector("#provinsi");
        const kabupatenSelect = document.querySelector("#kabupaten");
        const jalanInput = document.querySelector("#jalan");
        const saveAlamat = document.querySelector("#simpanAlamat");
        const k_bsni = document.querySelector("#k_bsni");
        const alamatButton = document.querySelector("#alamatBtn");
        const closeButton = document.querySelector("#tutupBtn");
  
        function populateKabupaten(provinsiId) {
          kabupatenSelect.innerHTML = '';
          kabupatenSelect.innerHTML = `<option value="">Pilih Kabupaten</option>`;
  
          fetch('/database/kota-kabupaten.json')
            .then(response => response.json())
            .then(data => {
                const kabupatenData = data.filter(kabupaten => kabupaten.provinsi_id === provinsiId);
                kabupatenData.forEach(kabupaten => {
                  kabupatenSelect.innerHTML += `
                    <option value="${kabupaten.kabupaten_kota}" data-kode="${kabupaten.k_bsni}" ${kabupaten.kabupaten_kota === kab_prov.kabupaten ? 'selected' : ''}>${kabupaten.kabupaten_kota}</option>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching JSON data:', error);
            });
        }
  
        function populateProvinsi() {
  
          fetch('/database/provinsi.json')
            .then(response => response.json())
            .then(data => {
                data.forEach(provinsi => {
                  provinsiSelect.innerHTML += `
                    <option value="${provinsi.provinsi}" data-id="${provinsi.id}" ${provinsi.provinsi === kab_prov.provinsi ? 'selected' : ''}>${provinsi.provinsi}</option>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching JSON data:', error);
            });
        }
  
        alamatButton.addEventListener('click', function() {
          populateProvinsi();
          if(kab_prov.kabupaten != null) {
            populateKabupaten(kab_prov.provId);
          }
        });
  
        provinsiSelect.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const selectedProvinsiId = selectedOption.getAttribute("data-id");
          provinsiSelect.setAttribute("data-id", selectedProvinsiId);
  
          populateKabupaten(parseInt(selectedProvinsiId));
        });
  
        kabupatenSelect.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const selected = selectedOption.value;
          k_bsni.value = selected;
        });
  
        saveAlamat.addEventListener('click', function() {
          provinsiSelect.classList.remove("is-invalid");
          kabupatenSelect.classList.remove("is-invalid");
  
          if(provinsiSelect.value == "") {
            provinsiSelect.classList.add("is-invalid");
          }
  
          else if(kabupatenSelect.value == "") {
            kabupatenSelect.classList.add("is-invalid");
          } else {
            let alamat = kabupatenSelect.value + ', ' + provinsiSelect.value;
            const kode = kabupatenSelect.options[kabupatenSelect.selectedIndex].getAttribute("data-kode");
            const provId = parseInt(provinsiSelect.getAttribute("data-id"));
  
            if(jalanInput.value != "") {
              alamat = jalanInput.value + ', ' + kabupatenSelect.value + ', ' + provinsiSelect.value; 
            } 
    
            alamatButton.textContent = alamat; 
            
            setAlamatToController(alamat, kode, provId, jalanInput.value, provinsiSelect.value, kabupatenSelect.value);
            closeButton.click();
          }
  
        });
      });
    });
    
  </script>
@endpush
  