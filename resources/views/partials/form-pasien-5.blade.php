@if($currentStep == 5)
  <div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
    <div class="col">
      <div class="mb-4">
        <label for="kondisi_awal" class="form-label fw-bold">Kondisi Awal</label>
        <textarea class="form-control @error('kondisi_awal') is-invalid @enderror" id="kondisi_awal" name="kondisi_awal" rows="3" style="text-transform: full-width-kana;" oninput="capFirst('kondisi_awal')" wire:model="kondisi_awal"></textarea>
        @error('kondisi_awal')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-4">
          <label for="target_akhir" class="form-label fw-bold">Target Akhir</label>
          <textarea class="form-control @error('target_akhir') is-invalid @enderror" id="target_akhir" name="target_akhir" rows="3" oninput="capFirst('target_akhir')" wire:model="target_akhir"></textarea>
          @error('target_akhir')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
      </div>                  
    </div>    
    <div class="col">
      <div class="mb-4">
        <label for="link_perkembangan" class="form-label fw-bold">Link Perkembangan Target</label>
        <input type="text" class="form-control @error('link_perkembangan') is-invalid @enderror" id="link_perkembangan" name="link_perkembangan" rows="3" oninput="capFirst('link_perkembangan')" wire:model="link_perkembangan">
        @error('link_perkembangan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
    </div>
      <div class="mb-4">
        <label for="kesimpulan" class="form-label fw-bold">Kesimpulan Akhir</label>
        <textarea class="form-control @error('kesimpulan') is-invalid @enderror" id="kesimpulan" name="kesimpulan" rows="5" style="text-transform: full-width-kana;" oninput="capFirst('kesimpulan')" wire:model="kesimpulan"></textarea>
        @error('kesimpulan')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
                        
    </div>                 
  </div>
@endif