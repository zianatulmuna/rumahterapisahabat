<div>
    <div class="main-bg px-3 py-4">
        <div class="pb-2 border-bottom h-0">
            <h1 class="h4">Terapis Ready</h1>
        </div>
        
        @if($userAdmin)
            <div class="d-flex justify-content-between align-items-center my-3">
                <h5 class="text-right m-0" id="totalReady">{{ $terapisReady }} Terapis</h5>
                <button type="button" class="btn text-danger me-3" wire:click="offTerapis()">Off <i class="fa-solid fa-power-off"></i></button>
            </div>
            <div class="pe-3 content-ready" style="">
            @foreach($terapisForReady as $t)
                <div class="hstack my-2 p-2 border {{ $t->is_ready ? 'border-success' : '' }} rounded-3">
                    @if ($t->foto)
                        <img src="{{ asset('storage/' . $t->foto) }}" class="avatar-img me-2" alt="...">
                    @else
                        @if($t->jenis_kelamin === 'Laki-Laki')
                        <img src="/img/avatar-l.png" class="avatar-img me-2" alt="...">
                        @else
                        <img src="/img/avatar-p.png" class="avatar-img me-2" alt="...">
                        @endif
                    @endif
                    <span class="me-auto text-truncate text-black">{{ $t->nama }}</span>
                    <div class="form-check form-switch toggle-success">
                        @if($t->is_ready)
                        <input class="form-check-input" type="checkbox" value="{{ $t->username }}" role="switch" id="flexSwitchCheckDefault" checked  wire:click="toggleSwitch('{{ $t->id_terapis }}', '{{ $t->is_ready }}')">
                        @else
                        <input class="form-check-input" type="checkbox" value="{{ $t->username }}" role="switch" id="flexSwitchCheckDefault" wire:click="toggleSwitch('{{ $t->id_terapis }}', '{{ $t->is_ready }}')">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @elseif($userTerapis->id_terapis == 'KTR001')
            <div class="align-items-center my-3">
                <h5 class="text-right m-0" id="totalReady">{{ $terapisReady }} Terapis</h5>
            </div>
            <div class="pe-3 content-ready" style="">
            @foreach($terapisForReady as $t)
                <div class="hstack my-2 p-2 border {{ $t->is_ready ? 'border-success' : '' }} rounded-3">
                    @if ($t->foto)
                        <img src="{{ asset('storage/' . $t->foto) }}" class="avatar-img me-2" alt="...">
                    @else
                        @if($t->jenis_kelamin === 'Laki-Laki')
                        <img src="/img/avatar-l.png" class="avatar-img me-2" alt="...">
                        @else
                        <img src="/img/avatar-p.png" class="avatar-img me-2" alt="...">
                        @endif
                    @endif
                    <span class="me-auto text-truncate text-black">{{ $t->nama }}</span>
                </div>
                @endforeach
            </div>   
        @elseif($userTerapis)
            <div class="d-flex justify-content-between align-items-center my-3">
                <h5 class="text-right m-0" id="totalReady">{{ $terapisReady }} Terapis</h5>
            </div>
            <div class="pe-3 content-ready" style="">
            @foreach($terapisForReady as $t)
                @if($t->is_ready)
                <div class="hstack my-2 p-2 border rounded-3">
                    @if ($t->foto)
                        <img src="{{ asset('storage/' . $t->foto) }}" class="avatar-img me-2" alt="...">
                    @else
                        @if($t->jenis_kelamin === 'Laki-Laki')
                        <img src="/img/avatar-l.png" class="avatar-img me-2" alt="...">
                        @else
                        <img src="/img/avatar-p.png" class="avatar-img me-2" alt="...">
                        @endif
                    @endif
                    <span class="me-auto text-truncate text-black">{{ $t->nama }}</span>
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
