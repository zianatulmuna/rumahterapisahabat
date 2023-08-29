<div>
    <div class="main-bg">
      {{-- Step header --}}
      <div class="row justify-content-between py-2 py-sm-3 px-md-4 custom-step border-bottom">
        <div class="col text-center">
          <i class="bi {{  $currentStep == 1 ? 'bi-1-circle-fill' : 'bi-1-circle'  }} text-success h1"></i>
          <h5 class="pt-2">Data Diri</h5>
        </div>
        <div class="col text-center">
          <i class="bi {{  $currentStep == 2 ? 'bi-2-circle-fill' : 'bi-2-circle'  }} text-success h1"></i>
          <h5 class="pt-2">Data Akun</h5>
        </div>
      </div>
  
      {{-- form --}}
      <form wire:submit.prevent='update' class="main-form mb-30" id="updateForm" enctype="multipart/form-data">
        @csrf
        <div class="mt-4 mt-sm-5" id="nav-tabContent">
          {{-- data diri --}}
          @if($currentStep == 1)
            <div class="" id="nav-diri" aria-labelledby="nav-diri-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
                <div class="col">                
                  <div class="mb-4">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" oninput="capEach('nama')" wire:model="nama">
                    @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="no_telp" class="form-label fw-bold">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" wire:model="no_telp">
                    @error('no_telp')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Kelamin</label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" wire:model="jenis_kelamin" required aria-label=".form-select-sm example">
                      <option value="">Pilih Jenis Kelamin</option>
                      @foreach($jenisKelamin as $gender)
                        @if (old('jenis_kelamin') == $gender)
                          <option value="{{ $gender }}" selected>{{ $gender }}</option>
                        @else
                          <option value="{{ $gender }}">{{ $gender }}</option>
                        @endif
                      @endforeach
                    </select>
                    @error('jenis_kelamin')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                      <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" 
                        value="{{ old('tanggal_lahir') }}" wire:model="tanggal_lahir">
                      <div class="form-text">Contoh: 9 Desember 1995 diisi 12/09/1995</div>
                        @error('tanggal_lahir')
                              <div class="invalid-feedback">
                              {{ $message }}
                              </div>
                          @enderror
                  </div>
                </div>
                      
                <div class="col">
                  <div class="mb-4">
                      <label for="agama" class="form-label fw-bold">Agama</label>
                      <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" oninput="capEach('agama')" wire:model="agama">
                      @error('agama')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                      <label for="alamat" class="form-label fw-bold">Alamat</label>
                      <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" oninput="capFirst('alamat')" wire:model="alamat">
                      @error('alamat')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                      @enderror
                  </div>
                  <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Foto</label>
                    <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" value="{{ old('foto') }}" wire:model="foto">
                    <div class="row my-3 justify-content-sm-start">
                      @if ($foto)
                        <p class="col-sm-auto m-0">Preview :</p>
                        <img src="{{ $foto->temporaryUrl() }}" class="img-fluid pt-2 col-sm-5 img-preview">
                        <button type="button" class="btn-close small" aria-label="Close" onclick="deleteFoto()" wire:click="deleteFoto"></button>
                      @elseif($dbFoto)
                        <p class="col-sm-auto m-0">Preview :</p>
                        <img src="{{ asset('storage/' . $dbFoto) }}" class="img-fluid pt-2 col-sm-5 img-preview">
                        <button type="button" class="btn-close small" aria-label="Close" onclick="deleteFoto()" wire:click="deleteFoto"></button>
                      @endif
                    </div>
                    @error('foto')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>  
                </div>
              </div>
            </div>
          @endif
          {{-- data penunjang --}}
          @if($currentStep == 2)
            <div class="" id="nav-penunjang" aria-labelledby="nav-penunjang-tab" tabindex="0">
              <div class="row row-cols-1 row-cols-lg-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">                
                <div class="col">
                  <div class="mb-4">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" wire:model="username">
                    @error('username')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" id="password" name="password" rows="4" style="text-transform: full-width-kana;" placeholder="Masukkan password baru" wire:model="password">
                      <button type="button" class="input-group-text border-start-0 bg-white @error('password') is-invalid @enderror" id="pswButton"><i class="bi bi-eye-fill text-secondary"></i></button>
                    </div>
                    <div class="form-text">Minimal 3 karakter.</div>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col">
                  <div class="mb-4">
                    <label class="form-label fw-bold">Tingkatan Terapis</label>
                    <select class="form-select @error('tingkatan') is-invalid @enderror" id="tingkatan" name="tingkatan" wire:model="tingkatan" required aria-label=".form-select-sm example">
                      <option value="" selected>Tingkatan Terapis</option>
                      @foreach($tingkatanTerapis as $tingkatan)
                        @if (old('tingkatan') == $tingkatan)
                          <option value="{{ $tingkatan }}" selected>{{ $tingkatan }}</option>
                        @else
                          <option value="{{ $tingkatan }}">{{ $tingkatan }}</option>
                        @endif
                      @endforeach
                    </select>
                    @error('tingkatan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label label class="form-label fw-bold w-100">Status Terapis</label>
                    @foreach($statusTerapis as $status)
                      @if (old('status') == $status)
                        <div class="form-check form-check-inline">                        
                            <input class="form-check-input" type="radio" name="status" id="{{ $status }}" value="{{ $status }}" checked wire:model="status">
                            <label class="form-check-label" for="{{ $status }}">{{ $status }}</label>
                        </div>
                      @else
                        <div class="form-check form-check-inline">                        
                            <input class="form-check-input" type="radio" name="status" id="{{ $status }}" value="{{ $status }}" wire:model="status">
                            <label class="form-check-label" for="{{ $status }}">{{ $status }}</label>
                        </div>
                      @endif
                    @endforeach
                  </div>
                </div>           
              </div>
            </div>
          @endif
          
          {{-- button step --}}
          <div class="d-flex justify-content-between my-5 mx-3 mb-md-5 mx-md-5 form-navigation">
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

    document.addEventListener('livewire:load', function () {
    
      Livewire.on('runScript', function () {
        const btn = document.querySelector('#pswButton');
        let input = document.getElementById('password');

        btn.addEventListener('click', function () {
          let x = document.getElementById('password').type;
          if (x == 'password') {
              input.type = 'text';
              btn.innerHTML = `<i class="bi bi-eye-slash-fill text-secondary"></i>`;
          } else {
              input.type = 'password';
              btn.innerHTML = `<i class="bi bi-eye-fill text-secondary"></i>`;
          }
        });
      });
    });
  </script>
@endpush