{{-- <div class="dropdown dropdown-filter-tahun">
    <button class="btn dropdown-toggle btn-outline-success mx-0 d-flex justify-content-between align-items-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if(request('filter') === 'tahun-ini')
            Tahun Ini
        @elseif(request('filter') === 'semua-tahun')
            Semua tahun
        @elseif(request('filter') === 'minggu')
            Minggu Ini
        @else
            {{ request('filter') }}
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-right rounded-2 shadow" aria-labelledby="dropdownMenuButton">
        @php
            $filters = [
                'minggu' => 'Minggu ini',
                'tahun-ini' => 'Tahun ini',
                'semua-tahun' => 'Semua Tahun',
            ];
        @endphp

        @foreach ($filters as $filterValue => $filterText)
            <a 
                href="/admin/dashboard?{{ http_build_query(array_merge(request()->except('filter'), ['grafik' => request('grafik'), 'filter' => $filterValue])) }}" 
                class="dropdown-item {{ Request::query('filter') == $filterValue ? 'active' : '' }}">                                
                {{ $filterText }}
            </a>
        @endforeach
        <form action="/admin/dashboard" class="input-group p-2">
            @if(request('grafik'))
                <input type="hidden" name="grafik" value="{{ request('grafik') }}">
            @endif
            @if(request('terapis'))
                <input type="hidden" name="terapis" value="{{ request('terapis') }}">
            @endif
            @if(request('penyakit'))
                <input type="hidden" name="penyakit" value="{{ request('penyakit') }}">
            @endif
            <input type="search" class="form-control rounded-start py-0" name="filter" id="tahunInput" min="2014" max="2023" placeholder="Tahun">
            <button type="submit" id="btnTahun" class="btn btn-outline-success">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div> 
</div> --}}

<div class="dropdown dropdown-filter-tahun">
    <button class="btn dropdown-toggle btn-outline-success mx-0 d-flex justify-content-between align-items-center button-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <span class="text-capitalize">{{ $tahun ? $tahun : $filter }}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-end rounded-2 shadow p-1" aria-labelledby="dropdownMenuButton">
        <button type="button" class="dropdown-item" wire:click="setFilter('minggu ini')">Minggu Ini</button>
        <button type="button" class="dropdown-item" wire:click="setFilter('tahun ini')">Tahun Ini</button>
        <button type="button" class="dropdown-item" wire:click="setFilter('semua tahun')">Semua Tahun</button>
        <div class="input-group p-2">
            <input type="search" class="form-control py-0" name="tahunForm" id="tahunInput" min="2014" max="2023" placeholder="Tahun">
            <button type="button" id="tahunBtn" class="btn btn-outline-success">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div> 
</div>

@push('script')
    <script>
        document.addEventListener('livewire:load', function () {

            // script tahun
            const inputTahun = document.querySelector('#tahunInput');
            const btnTahun = document.querySelector('#tahunBtn');

            btnTahun.addEventListener('click', function(e) {
                Livewire.emit('setTahun', inputTahun.value);
            });
        });
    </script>
@endpush