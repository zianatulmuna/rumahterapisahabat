{{-- Data Diri Pasien --}}
<div class="row g-4 custom-bio">
    <div class="col-lg-2">
      <div class="d-flex align-items-center justify-content-center">
       @if ($pasien->foto)
          <img src="{{ asset('storage/' . $pasien->foto) }}" class="img-thumbnail" alt="...">
       @else
          @if($pasien->jenis_kelamin === 'Laki-Laki')
             <img src="/img/avatar-l.png" class="img-thumbnail" alt="...">
          @else
             <img src="/img/avatar-p.png" class="img-thumbnail" alt="...">
          @endif
       @endif
      </div>
    </div>
    <div class="col-lg-8 bg-white px-3 py-2 border border-body-tertiary">
       <table class="table table-borderless table-sm bg-white table-data-diri">
          <thead>
             <tr>
               {{-- <th style="width: 20%"></th>
               <th style="width: 80%"></th> --}}
               <th></th>
               <th></th>
             </tr>
          </thead>
          <tbody>
             <tr>
                <td>Nama</td>
                <td>{{ $pasien->nama }}</td>
             </tr>
             <tr>
                <td>No. Telp</td>
                <td>{{ $pasien->no_telp }}</td>
             </tr>
             <tr>
                <td>Email</td>
                <td>{{ $pasien->email }}</td>
             </tr>
             <tr>
                <td>Jenis Kelamin</td>
                <td>{{ $pasien->jenis_kelamin }}</td>
             </tr>
             <tr>
                <td>Umur</td>
                <td>{{ $umur }} tahun</td>
             </tr>
             <tr>
                <td>Pekerjaan</td>
                <td>{{ $pasien->pekerjaan }}</td>
             </tr>
             <tr>
                <td>Alamat</td>
                <td>{{ $pasien->alamat }}</td>
             </tr>
             <tr class="fw-semibold">
                <td>ID Pasien</td>
                <td>{{ $pasien->id_pasien }}</td>
             </tr>
             @if(Request::is('admin/pasien/' . $pasien->slug))
               @if($rmDetected == 1)
                  <tr class="fw-semibold">
                     <td>No. RM</td>
                     <td>{{ $rm->id_rekam_medis }}</td>                  
                  </tr>
                  <tr>
                     <td>Status</td>
                     <td>{{ $rm->status_pasien }}</td>                  
                  </tr>
               @endif
             @endif
          </tbody>            
       </table>
    </div>
    <div class="col-lg-2">
       <div class="button-rm d-flex align-items-sm-center flex-lg-column justify-content-center ps-lg-4">
         <a href="{{ route('sub.histori', $pasien->slug) }}" class="btn btn-success btn-sm mb-3">Histori Rekam Terapi</a>
         <a href="{{ route('rm.histori', $pasien->slug) }}" class="btn btn-success btn-sm mb-3 mx-sm-3 mx-lg-0">Histori Rekam Medis</a>
         <a href="{{ route('rm.print', [$pasien->slug, $rm->id_rekam_medis]) }}" class="btn btn-success btn-sm mb-3">Unduh Rekam Medis</a>
       </div>
    </div>
</div>