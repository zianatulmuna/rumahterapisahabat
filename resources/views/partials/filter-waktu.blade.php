<div class="dropdown dropdown-filter-tahun">
    <button class="btn dropdown-toggle btn-outline-success mx-0 d-flex justify-content-between align-items-center button-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <span class="text-capitalize">{{ $tahun ? $tahun : $filter }}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-end rounded-2 shadow px-1 py-2" aria-labelledby="dropdownMenuButton">
        <button type="button" class="dropdown-item {{ $filter == 'minggu ini' ? 'active' : '' }}" wire:click="setFilter('minggu ini')">Minggu Ini</button>
        <button type="button" class="dropdown-item {{ $filter == 'bulan ini' ? 'active' : '' }}" wire:click="setFilter('bulan ini')">Bulan Ini</button>
        <button type="button" class="dropdown-item {{ $filter == 'tahun ini' ? 'active' : '' }}" wire:click="setFilter('tahun ini')">Tahun Ini</button>
        <button type="button" class="dropdown-item {{ $filter == 'semua tahun' ? 'active' : '' }}" wire:click="setFilter('semua tahun')">Semua Tahun</button>
        <div class="p-2">
            <input type="year" class="form-control" id="start" name="start" min="2018-03" value="2018-05" />
        </div>
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