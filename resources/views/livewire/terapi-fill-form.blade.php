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
                  <div class="mb-4">
                    <label for="pasien" class="form-label fw-bold">Pasien</label>
                    <input type="text" class="form-control" value="{{ $pasien->nama }}" id="pasien" name="pasien" readonly>
                  </div>
                  <div class="mb-4"> 
                      <label for="tanggal" class="form-label fw-bold">Tanggal Terapi <small class="fw-semibold">[Bulan/Tanggal/Tahun]</small></label>
                      <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ $tanggal }}" readonly>
                  </div>
                  <div class="mb-4">
                      <label for="waktu" class="form-label fw-bold">Waktu Terapi</label>
                      <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu', $waktu) }}" wire:model="waktu">
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
                        <label for="keluhan" class="form-label fw-bold">Keluhan Pasien <span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" value="{{ old('keluhan') }}" oninput="capFirst('keluhan')" rows="3" wire:model="keluhan">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-4"> 
                        <label for="deteksi" class="form-label fw-bold">Deteksi/Pengukuran <span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control @error('deteksi') is-invalid @enderror" id="deteksi" name="deteksi" value="{{ old('deteksi') }}" oninput="capFirst('deteksi')" rows="3" wire:model="deteksi">{{ old('deteksi') }}</textarea>
                        @error('deteksi')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                </div>
                <div class="col">
                    <div class="mb-4"> 
                        <label for="tindakan" class="form-label fw-bold">Terapi/Tindakan yang Sudah Dilakukan <span class="text-danger">*</span></label>
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
    </script>
  @endpush