@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 border-bottom">
      <h1 class="h2">Jadwal Terapi</h1>
      @if(count($jadwal_terapi) > 0)
      <a href="" class="btn btn-sm btn-success rounded-3" onclick="printJadwal()">
        <i class="bi bi-download pe-1"></i>
        Unduh
      </a>
      @endif
   </div>

    <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row mb-sm-3">
        <div class="text-center mb-2 mt-4 my-sm-0">
            {{ $caption }}
        </div>
        <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4 mt-4">
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
                        <input type="date" value="{{ request('tanggal') }}" id="date" class="form-control">
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Berdasarkan Periode</h6></li>
                    <li><a href="?filter=bulan-ini" class="dropdown-item {{ request('filter') == 'bulan-ini' ? 'active' : '' }}">Bulan Ini</a></li>
                    <li><a href="?filter=tahun-ini" class="dropdown-item {{ request('filter') == 'tahun-ini' ? 'active' : '' }}">Tahun Ini</a></li>
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
                                <input type="date" value="{{ request('awal') }}" id="startDate" class="form-control">
                            </div>
                            <div class="hstack stack-input-icon w-100 overflow-hidden">
                                <div class="d-block d-sm-none form-control pe-1 input-icon" style="width: auto;">
                                    <i class="bi bi-calendar2-check text-body-tertiary"></i>
                                </div>
                                <input type="date" value="{{ request('akhir') }}" id="endDate" class="form-control">
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

    <div class="overflow-auto">
        @if(count($jadwal_terapi) > 0)
            <table class="table table-bordered align-middle overflow-auto" style="min-width: 450px;">
                <thead>
                <tr class="text-center">
                    <th scope="col">No</th>
                    @if(request('filter') || request('awal'))
                    <th scope="col">Tanggal</th>
                    @endif
                    <th scope="col">Nama Pasien</th>
                    <th scope="col" class="table-col-rm">Rekam Medis</th>
                    <th scope="col" class="table-col-terapis">Penyakit</th>
                    <th scope="col" class="table-col-terapis">Rekam Terapi</th>
                    <th scope="col" class="table-col-aksi">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $startIndex = ($jadwal_terapi->currentPage() - 1) * $jadwal_terapi->perPage() + 1;
                    @endphp
                    @foreach ($jadwal_terapi as $jadwal)
                        <tr>
                            <th scope="row" class="text-center">{{ $startIndex++ }}</th>
                            @if(request('filter') || request('awal'))
                            <td class="text-center">{{ date('d/m/Y', strtotime($jadwal->tanggal)) }}</td>
                            @endif
                            <td class="text-center">{{ $jadwal->pasien->nama }}</td>
                            <td class="text-center">
                                <a href="{{ route('pasien.rm', $jadwal->pasien->slug) }}" class="btn btn-sm c-btn-success rounded-3">
                                    <i class="bi bi-eye"></i>
                                </a>  
                            </td>
                            <td class="text-capitalize text-center">{{ $jadwal->id_sub ? $jadwal->subRekamMedis->penyakit : '-' }}</td>
                            <td class="text-center">
                                @if($jadwal->status === "Tertunda")
                                    <a href="{{ route('jadwal.isi', [$jadwal->pasien->slug, $jadwal->id_jadwal]) }}" class="btn btn-sm c-btn-primary px-3 rounded-3">
                                        <h6 class="m-0">Isi</h6>
                                    </a>  
                                @else
                                    <a href="{{ route('terapi.rekam', [$jadwal->pasien->slug, $jadwal->id_sub ]) }}" class="btn btn-sm btn-light border-secondary-subtle px-3 rounded-3">Lihat</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($jadwal->status === "Tertunda")
                                    <a href="{{ route('jadwal.lepas', [$jadwal->pasien->slug, $jadwal->id_jadwal]) }}" class="btn btn-sm c-btn-danger px-2 rounded-3">Lepas</a>
                                @else
                                    <a href="" class="btn btn-sm c-btn-danger px-2 rounded-3 disabled" tabindex="-1" role="button" aria-disabled="true">Lepas</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning py-2 mt-5 d-inline-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle pe-2 fw-semibold"></i>
                <div>Data pada tanggal yang dipilih tidak ditemukan.</div>
            </div>
        @endif
    </div>
</div>

<div class="d-flex justify-content-center mb-4">
    {{ $jadwal_terapi->appends(request()->query())->links() }}
</div>
@endsection

@push('script')
    <script>
        const tunggal = document.querySelector('#date');
        const start = document.querySelector('#startDate');
        const end = document.querySelector('#endDate');
        const dateBtn = document.querySelector('#dateBtn');

        tunggal.addEventListener('change', function(){
            window.location.href = '?tanggal=' + tunggal.value;
        })

        dateBtn.addEventListener('click', function(){
            if(start.value == '') {
                start.classList.add('is-invalid');
            } else if(end.value == '') {
                start.classList.remove('is-invalid');
                end.classList.add('is-invalid');
            } else {
                end.classList.remove('is-invalid');
                window.location.href = '?awal=' + start.value + '&akhir=' + end.value;
            }
        })

          document.addEventListener('change', function(e){
            e.preventDefault();
        })

        function printJadwal() {
            let currentPath = window.location.search;
            let url = "";

            if(currentPath == '') {
                url = "/jadwal/print?awal=null&akhir=null";
            } else if(currentPath == "?filter=bulan-ini") {
                url = "/jadwal/print" + currentPath;
            } else if(currentPath == "?filter=tahun-ini") {
                url = "/jadwal/print" + currentPath;
            }else {
                var urlParams = new URLSearchParams(currentPath);

                if(urlParams.get('tanggal') != null) {
                    url = "/jadwal/print?awal=" + urlParams.get('tanggal') + "&akhir=null";
                } else {
                    url = "/jadwal/print" + currentPath;
                }
            }
            
            // window.open(url, "_blank");
            let a = document.createElement('a');
            a.target= '_blank';
            a.href= url;
            a.click();
        }
    </script>
@endpush