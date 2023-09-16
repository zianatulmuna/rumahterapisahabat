<div>
    <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row px-0 px-sm-2 mb-sm-3">
        <div class="text-center mb-2 mt-4 my-sm-0">
            {{ $tglCaption }}
        </div>
        <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4 mt-2">
            <div class="btn-group w-100">
                <button type="button" class="form-control d-flex justify-content-between align-items-center" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <span>Pilih Tanggal</span>
                    <i class="bi bi-calendar2-week"></i>
                </button>
                <ul class="dropdown-menu w-100 shadow-lg">
                    <li><h6 class="dropdown-header">Berdasarkan Tanggal</h6></li>
                    <li class="px-3 pb-2 hstack stack-input-icon">
                        <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                            <i class="bi bi-calendar2-event text-body-tertiary"></i>
                        </div>
                        <input type="date" value="{{ $tanggal }}" id="date" class="form-control">
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Berdasarkan Range Tanggal</h6></li>
                    <li class="px-3 pb-2">
                        <div class="d-flex gap-2 w-100">
                            <label class="form-label flex-fill small m-0">Pilih Tgl Mulai:</label>
                            <label class="form-label flex-fill small m-0">Pilih Tgl Akhir:</label>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="hstack stack-input-icon w-100 overflow-hidden">
                                <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                                    <i class="bi bi-calendar2-plus text-body-tertiary"></i>
                                </div>
                                <input type="date" value="{{ $tglAwal }}" id="startDate" class="form-control">
                            </div>
                            <div class="hstack stack-input-icon w-100 overflow-hidden">
                                <div class="d-block d-sm-none form-control pe-1 input-icon" style="width: auto;">
                                    <i class="bi bi-calendar2-check text-body-tertiary"></i>
                                </div>
                                <input type="date" value="{{ $tglAkhir }}" id="endDate" class="form-control">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" id="dateBtn" class="btn btn-success btn-sm mt-3 align-content-end">Tampilkan</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="px-0 px-sm-2 overflow-auto">
        @if(count($jadwal_terapi) > 0)
            <table class="table table-bordered align-middle">
                <thead>
                <tr class="text-center">
                    <th scope="col" style="width: 50px;">No</th>
                    <th scope="col" style="">Nama Pasien</th>
                    <th scope="col" style="">Waktu</th>
                    <th scope="col" style="width: 150px;">Rekam Medis</th>
                    <th scope="col" style="">Terapis</th>
                    
                </tr>
                </thead>
                <tbody>
                    @php
                        $startIndex = ($jadwal_terapi->currentPage() - 1) * $jadwal_terapi->perPage() + 1;
                    @endphp
                    @foreach ($jadwal_terapi as $jadwal)
                        <tr>
                            <th scope="row" class="text-center">{{ $startIndex++ }}</th>
                            <td>{{ $jadwal->pasien->nama }}</td>
                            @php
                                $waktu = substr($jadwal->waktu, 0, 5);;
                            @endphp
                            <td class="text-center">{{ $waktu }}</td>
                            <td class="text-center">
                                <a href="{{ route('pasien.rm', $jadwal->pasien->slug) }}" class="btn btn-sm c-btn-success rounded-3">
                                    <i class="bi bi-eye"></i>
                                </a>  
                            </td>
                            <td class="text-capitalize text-center">
                            @if($userTerapis)
                                @if($jadwal->id_terapis === $userTerapis->id_terapis)
                                    <button type="button" class="btn btn-sm c-btn-danger px-2 rounded-3 {{ $jadwal->status === 'Tertunda' ? '' : 'disabled'  }}" wire:click="lepasJadwal('{{ $jadwal->id_jadwal }}')" {{ $jadwal->status === 'Tertunda' ? '' : 'disabled'  }}>Lepas</button>
                                @elseif($jadwal->id_terapis === null)
                                    <button type="button" class="btn btn-sm c-btn-warning px-2 rounded-3" wire:click="ambilJadwal('{{ $jadwal->id_jadwal }}','{{ $userTerapis->id_terapis }}')">Ambil</button>
                                @else
                                    {{ $jadwal->terapis->username }}
                                @endif
                            @else
                                {{ $jadwal->id_terapis ? $jadwal->terapis->username : '' }}
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5 mb-3 p">
                {{ $jadwal_terapi->links() }}
            </div>
        @else
            <div class="alert alert-warning py-2 mt-3 d-inline-flex align-items-center fst-italic" role="alert">
                <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
                <div>Data pada tanggal yang dipilih tidak ditemukan.</div>
            </div>
        @endif
        
    </div>
</div>

@push('script')
<script>
    const tunggal = document.querySelector('#date');
    const start = document.querySelector('#startDate');
    const end = document.querySelector('#endDate');
    const dateBtn = document.querySelector('#dateBtn');

    tunggal.addEventListener('change', function(){
        // Livewire.emit('setFilterTanggal', tunggal.value);
        fetch('/beranda/jadwal?tanggal=' + tunggal.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    })

    dateBtn.addEventListener('click', function(){
        if(start.value == '') {
            start.classList.add('is-invalid');
        } else if(end.value == '') {
            start.classList.remove('is-invalid');
            end.classList.add('is-invalid');
        } else {
            end.classList.remove('is-invalid');

            Livewire.emit('setFilterRange', {awal: start.value, akhir: end.value});
        }
    })
</script>
@endpush