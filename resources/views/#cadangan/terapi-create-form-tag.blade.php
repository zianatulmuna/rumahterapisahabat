<div>
    <div class="main-bg">
      {{-- Step header --}}
      <div class="row justify-content-between py-2 py-sm-3 px-md-4 custom-step border-bottom">
        <div class="col text-center">
          <i class="bi {{  $currentStep == 1 ? 'bi-1-circle-fill' : 'bi-1-circle'  }} text-success h1"></i>
          <h5 class="pt-2">Data Sesi</h5>
        </div>
        <div class="col text-center">
          <i class="bi {{  $currentStep == 2 ? 'bi-2-circle-fill' : 'bi-2-circle'  }} text-success h1"></i>
          <h5 class="pt-2">Data Terapi</h5>
        </div>
      </div>
  
      {{-- form --}}
      <form wire:submit.prevent='create' class="main-form" id="createForm" enctype="multipart/form-data">
        @csrf
        <div class="mt-4 mt-sm-5" id="nav-tabContent">
          {{-- data diri --}}
          @if($currentStep == 1)
            <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                  <div class="mb-3 dropdown-terapis">
                    <label for="id_terapis" class="form-label fw-bold">Nama Terapis <span class="text-danger">*</span></label>
                    <div class="form-control d-flex flex-wrap gap-2 p-2 rounded taginput @error('id_terapis') is-invalid @enderror">                    
                      @if(count($tagTerapis) > 0)
                        @foreach ($tagTerapis as $i)
                          <div class="py-1 px-2 bg-body-tertiary border border-body-secondary rounded-3 tag-item">
                            <span class="fw-semibold">{{ $i['nama'] }}</span>
                            <button type="button" class="btn m-0 p-0 ps-2 text-body-tertiary" wire:click="deleteTagTerapis('{{ $i['id'] }}')"><i class="bi bi-x-circle"></i></button>
                          </div>
                        @endforeach   
                      @endif 
                      <input 
                        type="text" 
                        class="flex-grow-1 search-input" 
                        id="tagTerapis" 
                        name="tagTerapis" 
                        placeholder="Tambah.." 
                        oninput="capEach('tagTerapis')"
                        autocomplete="off">                                 
                    </div>
                    <div class="dropdown-menu dropdown-dinamis p-3 pt-2 bg-body-tertiary shadow">  
                      <p class="small mb-1">Pilih Terapis:</p> 
                      <ul class="select-options bg-white mb-0 rounded"></ul>
                    </div>
                    <div class="text-end d-sm-none">
                      <button type="button" class="btn btn-success btn-sm mt-2" id="hiddenTambahBtn">Tambah</button>
                    </div>
                    <div class="form-text d-none d-sm-block">Tekan koma "," atau Enter untuk menambah terapis.</div>
                    @error('id_terapis')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                    <div class="mb-4"> 
                        <label for="tanggal" class="form-label fw-bold">Tanggal Terapi [Bulan/Tanggal/Tahun]</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" wire:model="tanggal">
                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="waktu" class="form-label fw-bold">Waktu Terapi</label>
                        <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}" wire:model="waktu">
                        @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-4"> 
                        <label for="pra_terapi" class="form-label fw-bold">Pra Terapi</label>
                        <textarea type="text" class="form-control @error('pra_terapi') is-invalid @enderror" id="pra_terapi" name="pra_terapi" value="{{ old('pra_terapi') }}" oninput="capFirst('pra_terapi')" rows="3" wire:model="pra_terapi">{{ old('pra_terapi') }}</textarea>
                        @error('pra_terapi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4"> 
                        <label for="post_terapi" class="form-label fw-bold">Post Terapi</label>
                        <textarea type="text" class="form-control @error('post_terapi') is-invalid @enderror" id="post_terapi" name="post_terapi" value="{{ old('post_terapi') }}" oninput="capFirst('post_terapi')" rows="3" wire:model="post_terapi">{{ old('post_terapi') }}</textarea>
                        @error('post_terapi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
          @endif
          {{-- data penunjang --}}
          @if($currentStep == 2)
            <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">
                    <div class="mb-4"> 
                        <label for="keluhan" class="form-label fw-bold">Keluhan Pasien</label>
                        <textarea type="text" class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" value="{{ old('keluhan') }}" oninput="capFirst('keluhan')" rows="3" wire:model="keluhan">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-4"> 
                        <label for="deteksi" class="form-label fw-bold">Deteksi/Pengukuran</label>
                        <textarea type="text" class="form-control @error('deteksi') is-invalid @enderror" id="deteksi" name="deteksi" value="{{ old('deteksi') }}" oninput="capFirst('deteksi')" rows="3" wire:model="deteksi">{{ old('deteksi') }}</textarea>
                        @error('deteksi')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                </div>
                <div class="col">
                    <div class="mb-4"> 
                        <label for="tindakan" class="form-label fw-bold">Terapi/Tindakan yang Sudah Dilakukan</label>
                        <textarea type="text" class="form-control @error('tindakan') is-invalid @enderror" id="tindakan" name="tindakan" value="{{ old('tindakan') }}" oninput="capFirst('tindakan')" rows="3" wire:model="tindakan">{{ old('tindakan') }}</textarea>
                        @error('tindakan')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>  
                      <div class="mb-4"> 
                        <label for="saran" class="form-label fw-bold">Saran</label>
                        <textarea type="text" class="form-control @error('saran') is-invalid @enderror" id="saran" name="saran" value="{{ old('saran') }}" oninput="capFirst('saran')" rows="3" wire:model="saran">{{ old('saran') }}</textarea>
                        @error('saran')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                </div>
            </div>
          @endif
          
          {{-- button step --}}
          <div class="d-flex justify-content-between my-4 my-md-5 mx-3 mb-md-5 mx-md-5 form-navigation">
            @if($currentStep == 1)
              <div></div>    
              <button class="btn c-btn-success px-3 px-md-4 py-md-2" type="button" onclick="toTop()" wire:click="toNext()">Lanjut</button>      
            @endif
  
            @if($currentStep == 2)
            <button class="btn btn-secondary" type="button" onclick="toTop()" wire:click="toPrev()">Sebelumnya</button>    
              <button type="submit" class="btn btn-success px-3 px-md-4 py-md-2" onclick="toTop()">Kirim</button>       
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>
  
  @push('script')
    <script>
      const target = document.querySelector(".main-bg");

      let dataTerapis = @json($terapis->toArray());

      const dropTerapis = document.querySelector(".dropdown-terapis");
      let searchInpTerapis = dropTerapis.querySelector(".search-input");
      let optionsTerapis = dropTerapis.querySelector(".select-options");
      let dropdown = dropTerapis.querySelector(".dropdown-dinamis");      
      let tambahBtn = dropTerapis.querySelector("#hiddenTambahBtn");

      function toTop() {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start"
        });
      }

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
  
      function passwordAction() {    
        var x = document.getElementById('password').type;

        if (x == 'password') {
            document.getElementById('password').type = 'text';
            document.getElementById('mybutton').innerHTML = `<i class="bi bi-eye-slash-fill text-secondary"></i>`;
        } else {
            document.getElementById('password').type = 'password';
            document.getElementById('mybutton').innerHTML = `<i class="bi bi-eye-fill text-secondary"></i>`;
        }
      }

      function addTerapisToController(id, nama) {
        Livewire.emit('addTagTerapis', { id: id, nama: nama });
        document.querySelector(".search-input").value = "";
      };

      function addTerapis() {
        optionsTerapis.innerHTML = "";
        dataTerapis.forEach(terapis => {
              let li = `
                        <li class="dropdown-item" 
                            data-nama="${terapis.nama}" 
                            onclick="addTerapisToController('${terapis.id_terapis}','${terapis.nama}')">
                            ${terapis.nama}                            
                        </li>
                      `;
              optionsTerapis.insertAdjacentHTML("beforeend", li);
        });
      }

      searchInpTerapis.addEventListener('keyup', function(event) {
        const value = searchInpTerapis.value;
        dropdown.style.display = 'block';

        let arr = [];
        let searchWords = searchInpTerapis.value.toLowerCase().split(' ');
        arr = dataTerapis.filter(terapis => {
            let data = terapis.nama.toLowerCase();
            return searchWords.every(word => data.includes(word));
        }).map(terapis => {
            return `<li class="dropdown-item" 
                        data-nama="${terapis.nama}" 
                        onclick="addTerapisToController('${terapis.id_terapis}','${terapis.nama}')">
                        ${terapis.nama}                            
                    </li>
                    `;
        }).join("");

        optionsTerapis.innerHTML = arr ? arr : `<p class="p-2 m-0">Oops! Data tidak ditemukan</p>`;
        

        if (event.key === "Enter" || (event.key === "," && value.endsWith(","))) {
            searchInpTerapis.value = "";
        }
      });

      tambahBtn.addEventListener("click", function() {
        addTagToController(searchInpTerapis.value);
        searchInpTerapis.value = "";
      });

      searchInpTerapis.addEventListener("focus", function() {
        addTerapis();
        dropdown.style.display = 'block';
      });

      document.addEventListener('click', function(event) {
        if (!searchInpTerapis.contains(event.target)) {
          dropdown.style.display = 'none';
        }
      });


      
    </script>
  @endpush