@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Jadwal Terapi</h1>
   </div>

   <div class="d-flex justify-content-start">
        <a href="{{ route('jadwal.create') }}" class="btn c-btn-primary">
            <i class="bi bi-plus-square pe-2"></i>
            Tambah
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-sm-end flex-column-reverse flex-sm-row my-sm-3">
        <div class="text-center mb-2 mt-4 my-sm-0">
            {{ $today }}
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
                    <li><h6 class="dropdown-header">Berdasarkan Range Tanggal</h6></li>
                    <li class="px-3 pb-2">
                        <div class="d-flex gap-2 w-100">
                            <label class="form-label flex-fill small m-0">Pilih Tgl Mulai:</label>
                            <label class="form-label flex-fill small m-0">Pilih Tgl Akhir:</label>
                        </div>
                        {{-- <div class="d-none d-sm-flex gap-2 w-100">
                            <input type="date" value="{{ request('mulai') }}" id="startDate" class="form-control" placeholder="Pilih Hari">
                            <input type="date" value="{{ request('akhir') }}" id="endDate" class="form-control" placeholder="Pilih Hari">
                        </div> --}}
                        
                        <div class="d-flex gap-2">
                            <div class="hstack stack-input-icon w-100 overflow-hidden">
                                <div class="d-block d-sm-none form-control input-icon pe-1" style="width: auto;">
                                    <i class="bi bi-calendar2-plus text-body-tertiary"></i>
                                </div>
                                <input type="date" value="{{ request('mulai') }}" id="startDate" class="form-control">
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
                    <th scope="col">Nama Pasien</th>
                    <th scope="col" class="table-col-rm">Rekam Medis</th>
                    <th scope="col" class="table-col-terapis">Terapis</th>
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
                            <td>{{ $jadwal->pasien->nama }}</td>
                            <td class="text-center">
                                <a href="{{ route('pasien.rm', $jadwal->pasien->slug) }}" class="btn btn-sm c-btn-success rounded-3">
                                    <i class="bi bi-eye"></i>
                                </a>  
                            </td>
                            <td class="text-capitalize text-center">{{ $jadwal->terapis->username }}</td>
                            <td class="text-center">
                                <a href="" class="c-badge c-badge-danger me-2" data-toggle="modal" data-target="#terapiDeleteModal">
                                    <i class="bi bi-trash"></i>                      
                                </a>
                                <a href="{{ route('jadwal.edit', [$jadwal->pasien->slug, $jadwal->terapis->username, $jadwal->tanggal]) }}" class="c-badge c-badge-warning">
                                    <i class="bi bi-pencil-square"></i>                  
                                </a>      
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

<div class="d-flex justify-content-center my-4 p">
    {{-- {{ $jadwal_terapi->links() }} --}}
    {{ $jadwal_terapi->appends(request()->query())->links() }}
</div>
@endsection

@section('modal-alert')
    @if(count($jadwal_terapi) > 0)
    <!-- Terapi Delete Modal-->
   <div class="modal fade" id="terapiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content p-3">
            <div class="modal-header">
                  <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                     <i class="bi bi-trash text-danger pe-2 fs-4"></i>
                     <span>Yakin ingin menghapus jadwal?</span>
                  </h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">Jadwal akan dihapus <strong>permanen</strong>!</div>
            <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <form action="{{ route('jadwal.delete', [$jadwal->pasien->slug, $jadwal->terapis->username, $jadwal->tanggal]) }}" method="post">
                     @method('delete')
                     @csrf
                     <button type="submit" class="btn btn-danger"><i class="bi bi-exclamation-triangle"></i> Hapus</button>
                  </form>
            </div>
         </div>
      </div>
   </div>
   @endif
@endsection

@push('script')
    <script>
        const tunggal = document.querySelector('#date');
        const start = document.querySelector('#startDate');
        const end = document.querySelector('#endDate');
        const dateBtn = document.querySelector('#dateBtn');

        tunggal.addEventListener('change', function(){
            window.location.href = '/admin/jadwal?tanggal=' + tunggal.value;
        })

        dateBtn.addEventListener('click', function(){
            if(start.value == '') {
                start.classList.add('is-invalid');
            } else if(end.value == '') {
                start.classList.remove('is-invalid');
                end.classList.add('is-invalid');
            } else {
                end.classList.remove('is-invalid');
                window.location.href = '/admin/jadwal?mulai=' + start.value + '&akhir=' + end.value;
            }
        })
    </script>
@endpush