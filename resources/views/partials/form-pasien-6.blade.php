@if($currentStep == 6)
<div class="row row-cols-1 row-cols-md-2 px-3 px-md-5 g-0 g-md-4 g-lg-5">
  <div class="col">
    <div class="mb-4">                    
      <label class="form-label fw-bold">Privasi Data</label>
      <div class="form-check form-switch toggle-success toggle-md">
        <input class="form-check-input" id="is_private" name="is_private" type="checkbox" role="switch" wire:model="is_private">
        <label class="form-check-label ps-3" for="is_private">Jaga Data</label>
      </div>
      <div class="form-text">Aktifkan untuk menjaga privasi data pasien.</div>
      @error('is_private')
        <div class="invalid-feedback">
        {{ $message }}
        </div>
      @enderror
    </div>
  </div>
  <div class="col">   
    <div class="mb-4">
      <label class="form-label fw-bold">Terapis Default</label>
      <select class="form-select @error('id_terapis') is-invalid @enderror" id="id_terapis" name="id_terapis" wire:model="id_terapis" {{ $is_private ? '' : 'disabled' }}>
        <option value="">Pilih Terapis</option>
        @foreach($listTerapis as $terapis)
          @if (old('terapis') == $terapis)
            <option value="{{ $terapis->id_terapis }}" selected>{{ $terapis->nama }}</option>
          @else
            <option value="{{ $terapis->id_terapis }}">{{ $terapis->nama }}</option>
          @endif
        @endforeach
      </select>
      @error('id_terapis')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>                             
  </div>               
</div>
@endif