@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Jadwal Terapi</h1>
   </div>

   <div class="d-flex justify-content-start">
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-square pe-2"></i>
            Tambah
        </a>
    </div>

    <div class="d-flex flex-grow-1 justify-content-between align-item-center flex-wrap flex-md-nowrap align-items-end mt-3 mb-4">
        <div class="col-4">
            {{ $today }}
        </div>
        <div class="col-8">
            <div class="row justify-content-end">
                <div class="col-sm-9 col-xl-5">
                    <div class="form-control py-0 d-flex flex-row justify-content-between align-items-center flex-wrap taginput">
                        <input type="text" class="flex-grow-1 py-2" id="startDate" placeholder="Pilih Hari" style="cursor: pointer; width: 100px">
                        <i class="bi bi-calendar2-event small icon-date pe-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-auto">
        <table class="table table-bordered align-middle">
            <thead>
            <tr class="text-center">
                <th scope="col" style="width: 50px;">No</th>
                <th scope="col" style="">Nama Pasien</th>
                <th scope="col" style="width: 150px;">Rekam Medis</th>
                <th scope="col" style="">Terapis</th>
                <th scope="col" style="width: 150px;">Aksi</th>
                
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
                        <td>{{ $jadwal->terapis->nama }}</td>
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
    </div>
</div>

<div class="d-flex justify-content-center my-4 p">
    {{ $jadwal_terapi->links() }}
</div>
@endsection

@section('modal-alert')
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
@endsection

@push('script')
    <script>
        const inputDate = document.querySelector("#startDate");

        inputDate.addEventListener("focus", function() {
            document.querySelector(".icon-date").style.display = "none";
            inputDate.type = 'date';
        });
        inputDate.addEventListener("blur", function() {
            document.querySelector(".icon-date").style.display = "block";
            inputDate.type = 'text';
        });
    </script>
@endpush