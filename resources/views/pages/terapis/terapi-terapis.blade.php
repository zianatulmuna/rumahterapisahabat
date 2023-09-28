@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Histori Terapi</h1>
   </div>

   {{-- Data Diri terapis --}}
   <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row my-sm-3">
      <div class="mb-2 mt-4 my-sm-0">
          {{ $tanggal_caption }}
      </div>
      <div class="col-12 col-sm-7 col-md-6 col-lg-5 col-xl-4">
          <div class="btn-group w-100">
              <button type="button" class="form-control d-flex justify-content-between align-items-center" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  <span>Pilih Filter</span>
                  <i class="bi bi-calendar2-week"></i>
              </button>
              <ul class="dropdown-menu w-100 shadow-lg">
                  <li><h6 class="dropdown-header">Berdasarkan Periode</h6></li>
                  <li><a href="?filter=bulan-ini" class="dropdown-item {{ request('filter') == 'bulan-ini' ? 'active' : '' }}">Bulan Ini</a></li>
                  <li><a href="?filter=tahun-ini" class="dropdown-item {{ request('filter') == 'tahun-ini' ? 'active' : '' }}">Tahun Ini</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><h6 class="dropdown-header">Berdasarkan Tanggal</h6></li>
                  <li class="px-3 pb-2 hstack stack-input-icon">
                      <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                          <i class="bi bi-calendar2-event text-body-tertiary"></i>
                      </div>
                      <input type="date" value="{{ request('tanggal') }}" id="date" class="form-control">
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
   @if(count($histori_terapi) > 0)
   <div class="overflow-auto mt-4">
      <table class="table table-bordered" style="min-width: 420px;">
         <thead>
         <tr class="text-center">
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Penyakit</th>
            <th scope="col">Aksi</th>          
         </tr>
         </thead>
         <tbody>
            @php
               $startIndex = ($histori_terapi->currentPage() - 1) * $histori_terapi->perPage() + 1;
            @endphp
            @foreach ($histori_terapi as $terapi)
               <tr>
                     <th scope="row" class="text-center small-col-number">{{ $startIndex++ }}</th>
                     <td class="text-center">{{ date('d/m/Y', strtotime($terapi->tanggal)) }}</td>
                     <td class="px-sm-3">{{ $terapi->subRekamMedis->rekamMedis->pasien->nama }}</td>
                     <td class="px-sm-3">{{ $terapi->subRekamMedis->penyakit}}</td>
                     <td class="text-center small-col-aksi">
                        <a href="{{ route('terapi.detail', [$terapi->subRekamMedis->rekamMedis->pasien->slug, $terapi->subRekamMedis->id_sub, $terapi->id_terapi]) }}" class="btn btn-sm rounded-2 c-btn-success">
                           <i class="bi bi-eye"></i>               
                        </a>      
                     </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
   <div class="mt-3">
      {{ $histori_terapi->appends(request()->query())->links() }}
   </div>
   @endif
   
   @if($userAdmin)
   <div class="d-flex justify-content-end mb-4 mt-5 gap-3">
      <a type="button" class="btn c-btn-danger" data-toggle="modal" data-target="#terapisDeleteModal">
         <i class="bi bi-trash"></i>
         Hapus
      </a>
      <a href="{{ route('terapis.edit', $terapis->username) }}" class="btn c-btn-warning px-3">
         <i class="bi bi-pencil-square pe-1"></i>
         Edit
     </a>
   </div>
   @endif

</div>
@endsection

@section('modal-alert')
    <!-- Terapi Delete Modal-->
   <x-modal-alert 
      id="terapisDeleteModal"
      title="Yakin ingin menghapus terapis?"
      :body="'<span>Semua data terkait Terapis ini akan dihapus <strong>permanen</strong>!
         <br>Hal ini termasuk semua data terapi, terapi, dll.</span>'"
      icon="bi bi-exclamation-circle text-danger"
      >
      <form action="{{ route('terapis.delete', $terapis->username) }}" method="post">
         @method('delete')
         @csrf
         <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
      </form>
   </x-modal-alert>
@endsection

@push('script')
    <script>
        const tunggal = document.querySelector('#date');
        const start = document.querySelector('#startDate');
        const end = document.querySelector('#endDate');
        const dateBtn = document.querySelector('#dateBtn');

        const id = @json($terapis->username);

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
    </script>
    @if($request)
    <script>
        window.onload = function() {
            window.location.hash = 'historiTerapi';
        };
    </script>
    @endif  
@endpush