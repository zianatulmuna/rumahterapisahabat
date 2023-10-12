@if($currentStep == 4)
  <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
    <div class="col">
      <div class="mb-4 dropdown-penyakit">
        <label for="penyakit" class="form-label fw-bold">Nama Penyakit <span class="text-danger">*</span></label>
        @if($editPage)
          @if(session()->has('duplicate'))
            <div class="alert alert-warning alert-dismissible fade show py-1 px-2 py-lg-2 px-lg-3 hstack" role="alert" id="myAlert">
              <span class="me-auto">{{ session('duplicate') }}</span>
              <button type="button" class="btn p-0" data-dismiss="alert" aria-label="Close"><i class="bi bi-x-circle-fill  text-warning-emphasis"></i></button>
            </div>
          @endif
          @if(!empty($dataTag[0]['db']) && !empty($dataTag[0]['current']))
            @foreach ($dataTag as $i)
              @php
                $thisId = preg_replace('/\s+/', '-', $i['db']);
              @endphp
              <div class="d-flex mb-2 me-0 me-sm-5 me-md-0 me-xl-5">
                <input type="text" class="form-control w-70 border rounded-0" id="{{ $thisId }}" nama="{{ $thisId }}" value="{{ $i['current'] }}" oninput="capEach('{{ $thisId }}')" disabled>
                @if($i['db'] != '')
                  <button class="btn text-secondary border border-start-0 rounded-0" id="edit-{{ $thisId }}" type="button" onclick="editPenyakit('{{ $i['db'] }}')">
                    <i class="bi bi-pencil-square pe-1"></i>
                  </button>
                  <button class="btn text-secondary border border-start-0 rounded-0" id="delete-{{ $thisId }}" type="button" data-toggle="modal" data-target="#{{ $thisId }}DeleteModal"><i class="bi bi-x-circle-fill"></i></button>
                @endif

                <button class="btn btn-sm c-btn-primary rounded-0 ms-2 d-none" id="save-{{ $thisId }}" type="button" onclick="savePenyakit('{{ $i['db'] }}')">Simpan</button>
                <button class="btn btn-sm c-btn-secondary rounded-0 ms-2 d-none" id="undo-{{ $thisId }}" type="button" onclick="batalEdit('{{ $i['db'] }}')">Batal</button>
              </div>
              <!-- Terapi Delete Modal-->
              <x-modal-alert 
                id="{{ $thisId }}DeleteModal"
                title="Yakin ingin hapus penyakit?"
                :body="'<span>Semua data terkait rekam terapi untuk penyakit ini akan dihapus <strong>permanen</strong>! Hal ini termasuk semua data terapi harian.</span>'"
                icon="bi bi-exclamation-circle text-danger"
                >
                <button type="button" class="btn btn-danger" wire:click="deleteTagPenyakit('{{ $i['db'] }}')" data-dismiss="modal"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
              </x-modal-alert>
            @endforeach   
          @endif 
        @endif 
        
        <div class="form-control d-flex flex-wrap gap-2 p-2 rounded taginput @error('penyakit') is-invalid @enderror">                    
          @if(count($tag) > 0)
            @foreach ($tag as $i)
              <div class="py-1 px-2 bg-body-secondary border border-body-secondary rounded-3 tag-item">
                <span>{{ $i }}</span>
                <button type="button" class="btn m-0 p-0 ps-2 text-body-tertiary" wire:click="deleteTagBaru('{{ $i }}')"><i class="bi bi-x-circle-fill"></i></button>
              </div>
            @endforeach   
          @endif 
          <input 
            type="text" 
            class="flex-grow-1 search-input" 
            id="tagPenyakit" 
            name="tagPenyakit" 
            placeholder="Tambah.." 
            oninput="capEach('tagPenyakit')"
            autocomplete="off">                                 
        </div>
        
        <div class="dropdown-menu dropdown-dinamis p-3 pt-2 bg-body-tertiary shadow">  
          <p class="small mb-1">Pilih Penyakit:</p> 
          <ul class="select-options bg-white mb-0 rounded"></ul>
        </div>
        <div class="text-end d-sm-none">
          <button type="button" class="btn btn-success btn-sm mt-2" id="hiddenTambahBtn">Tambah</button>
        </div>
        <div class="form-text d-none d-sm-block">Tekan koma "," atau Enter untuk menambah penyakit.</div>
        @error('penyakit')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="keluhan" class="form-label fw-bold">Keluhan</label>
        <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="{{ $isPasienLama || $addRMPage ? '2' : '3' }}" style="text-transform: full-width-kana;" oninput="capFirst('keluhan')" wire:model="keluhan"></textarea>
        @error('keluhan')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
          <label for="data_deteksi" class="form-label fw-bold">Data Deteksi</label>
          <textarea class="form-control @error('data_deteksi') is-invalid @enderror" id="data_deteksi" name="data_deteksi" rows="{{ $isPasienLama || $addRMPage ? '3' : '5' }}" oninput="capFirst('data_deteksi')" wire:model="data_deteksi"></textarea>
          @error('data_deteksi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>                  
    </div> 
    <div class="col">
      <div class="mb-4">
        <label for="catatan_fisik" class="form-label fw-bold">Catatan Fisik</label>
        <textarea type="text" class="form-control @error('catatan_fisik') is-invalid @enderror" id="catatan_fisik" name="catatan_fisik" value="{{ old('catatan_fisik') }}" oninput="capFirst('catatan_fisik')" wire:model="catatan_fisik"></textarea>
        @error('catatan_fisik')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="catatan_bioplasmatik" class="form-label fw-bold">Catatan Bioplasmatik</label>
        <textarea type="text" class="form-control @error('catatan_bioplasmatik') is-invalid @enderror" id="catatan_bioplasmatik" name="catatan_bioplasmatik" value="{{ old('catatan_bioplasmatik') }}" oninput="capFirst('catatan_bioplasmatik')"  wire:model="catatan_bioplasmatik"></textarea>
        @error('catatan_bioplasmatik')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-4">
          <label for="catatan_psikologis" class="form-label fw-bold">Catatan Psikologis</label>
          <textarea type="text" class="form-control @error('catatan_psikologis') is-invalid @enderror" id="catatan_psikologis" name="catatan_psikologis" value="{{ old('catatan_psikologis') }}" oninput="capFirst('catatan_psikologis')"  wire:model="catatan_psikologis"></textarea>
          @error('catatan_psikologis')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
      </div>
      <div class="mb-4">
        <label for="catatan_rohani" class="form-label fw-bold">Catatan Rohani</label>
        <textarea type="text" class="form-control @error('catatan_rohani') is-invalid @enderror" id="catatan_rohani" name="catatan_rohani" value="{{ old('catatan_rohani') }}"  oninput="capFirst('catatan_rohani')" wire:model="catatan_rohani"></textarea>
        @error('catatan_rohani')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>                   
  </div>
@endif