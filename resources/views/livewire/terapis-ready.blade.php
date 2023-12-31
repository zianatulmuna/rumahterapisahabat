<div>
  <div class="main-bg px-3 py-4">
    <div class="border-bottom h-0 pb-2">
      <h1 class="h4">Terapis Ready</h1>
    </div>

    @if ($userAdmin)
      <div class="d-flex justify-content-between align-items-center my-3">
        <h5 class="m-0 text-right" id="totalReady">{{ $terapisReady }} Terapis</h5>
        <button type="button" class="btn text-danger me-3" wire:click="offTerapis()">Off <i
            class="fa-solid fa-power-off"></i></button>
      </div>
      <div class="content-ready pe-3" style="">
        @foreach ($terapisForReady as $t)
          <div class="hstack {{ $t->is_ready ? 'border-success' : '' }} rounded-3 my-2 border p-2">
            @if ($t->foto)
              <img src="{{ asset('storage/' . $t->foto) }}" class="avatar-img me-2" alt="...">
            @else
              @if ($t->jenis_kelamin === 'Laki-Laki')
                <img src="/img/profile-l.png" class="avatar-img me-2" alt="...">
              @else
                <img src="/img/profile-p.png" class="avatar-img me-2" alt="...">
              @endif
            @endif
            <span class="text-truncate me-auto text-black">{{ $t->nama }}</span>
            <div class="form-check form-switch toggle-stack toggle-success">
              @if ($t->is_ready)
                <input class="form-check-input" type="checkbox" value="{{ $t->username }}" role="switch"
                  id="flexSwitchCheckDefault" checked
                  wire:click="toggleSwitch('{{ $t->id_terapis }}', '{{ $t->is_ready }}')">
              @else
                <input class="form-check-input" type="checkbox" value="{{ $t->username }}" role="switch"
                  id="flexSwitchCheckDefault" wire:click="toggleSwitch('{{ $t->id_terapis }}', '{{ $t->is_ready }}')">
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @elseif($userTerapis)
      <div class="d-flex justify-content-between align-items-center my-3">
        <h5 class="m-0 text-right" id="totalReady">{{ $terapisReady }} Terapis</h5>
      </div>
      <div class="content-ready pe-3" style="">
        @foreach ($terapisForReady as $t)
          @if ($t->is_ready)
            <div class="hstack rounded-3 my-2 border p-2">
              @if ($t->foto)
                <img src="{{ asset('storage/' . $t->foto) }}" class="avatar-img me-2" alt="...">
              @else
                @if ($t->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="avatar-img me-2" alt="...">
                @else
                  <img src="/img/avatar-p.png" class="avatar-img me-2" alt="...">
                @endif
              @endif
              <span class="text-truncate me-auto text-black">{{ $t->nama }}</span>
            </div>
          @endif
        @endforeach
      </div>
    @endif
  </div>
</div>

@push('script')
  <script>
    function handleSwitchChange(checkbox) {
      if (checkbox.checked) {
        Livewire.emit('toggleSwitch', checkbox.value, 0);
      } else {
        Livewire.emit('toggleSwitch', checkbox.value, 1);
      }
    }
  </script>
@endpush
