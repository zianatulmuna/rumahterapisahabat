<div class="dropdown dropdown-filter-tahun">
  <button
    class="btn dropdown-toggle btn-outline-success d-flex justify-content-between align-items-center button-toggle mx-0"
    type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
    <span class="text-capitalize">{{ $tahun ? $tahun : $filter }}</span>
  </button>
  <div class="dropdown-menu dropdown-menu-end rounded-2 px-1 py-2 shadow" aria-labelledby="dropdownMenuButton">
    <button type="button" class="dropdown-item {{ $filter == 'minggu ini' ? 'active' : '' }}"
      wire:click="setFilter('minggu ini')">Minggu Ini</button>
    <button type="button" class="dropdown-item {{ $filter == 'bulan ini' ? 'active' : '' }}"
      wire:click="setFilter('bulan ini')">Bulan Ini</button>
    <button type="button" class="dropdown-item {{ $filter == 'tahun ini' ? 'active' : '' }}"
      wire:click="setFilter('tahun ini')">Tahun Ini</button>
    <button type="button" class="dropdown-item {{ $filter == 'semua tahun' ? 'active' : '' }}"
      wire:click="setFilter('semua tahun')">Semua Tahun</button>
    <div class="input-group p-2">
      <input type="search" class="form-control py-0" name="tahunForm" id="tahunInput" min="2014" max="2023"
        value="{{ $filter != 'tahun' ? '' : $tahun }}" placeholder="Tahun">
      <button type="button" id="tahunBtn" class="btn btn-outline-success">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>
</div>

@push('script')
  <script>
    document.addEventListener('livewire:load', function() {

      const btnTahun = document.querySelector('#tahunBtn');
      let tahunIni = new Date().getFullYear();

      btnTahun.addEventListener('click', function(e) {
        let inputTahun = document.querySelector('#tahunInput').value;

        if (!isNaN(inputTahun) && inputTahun >= 2014 && inputTahun <= tahunIni) {
          Livewire.emit('setTahun', inputTahun);
        } else {
          alert('Masukkan tahun dalam rentang 2014 sampai tahun ini.');
        }
      });

    });
  </script>
@endpush
