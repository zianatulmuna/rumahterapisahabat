{{-- Data Diri Pasien --}}
<div class="row g-4 custom-bio">
   <div class="col-lg-2 p-0 pe-sm-3">
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
                <td>No. Telpon</td>
                <td>{{ $pasien->no_telp }}</td>
             </tr>
             <tr>
                <td>Email</td>
                <td>{{ $pasien->email ? $pasien->email : '-' }}</td>
             </tr>
             <tr>
                <td>Jenis Kelamin</td>
                <td>{{ $pasien->jenis_kelamin }}</td>
             </tr>
             <tr>
                <td>Umur</td>
                <td>{{ $umur != 0 ? $umur . ' tahun' : '-'  }}</td>
             </tr>
             <tr>
                <td>Pekerjaan</td>
                <td>{{ $pasien->pekerjaan ? $pasien->pekerjaan : '-' }}</td>
             </tr>
             <tr>
                <td>Alamat</td>
                <td>{{ $pasien->alamat }}</td>
             </tr>
          </tbody>            
       </table>
       <table class="table table-borderless table-sm m-0 mt-1 table-data-diri table-info-rm">
         <thead>
            <tr>
              <th></th>
              <th></th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>ID Pasien</td>
               <td><span class="bg-body-secondary px-2 rounded-4 border">{{ $pasien->id_pasien }}</span></td>
            </tr>
            
            @if(Request::is('pasien/' . $pasien->slug . '*') )
               @unless (Request::is('pasien/*/rekam-medis') || Request::is('pasien/*/rekam-terapi'))
                  @if($rmDetected == 1)
                  {{-- <tr class="table-rm-btn">
                     <td>No. RM</td>
                     <td class="">
                        <div class="d-inline-flex bg-success-subtle px-2 rounded-4 border text-decoration-none link-dark">
                           <span class="">{{ $rm->id_rekam_medis }}</span>
                           <a href=""><i class="bi bi-arrow-right-circle-fill small ps-2 text-success"></i></a>
                        </div>
                     </td>                  
                  </tr> --}}
                  <tr class="table-rm-btn">
                     <td>No. RM</td>
                     <td class="px-2">
                        <span class="">{{ $rm->id_rekam_medis }}</span>
                        <a href="{{ route('rm.detail', [$pasien->slug, $rm->id_rekam_medis]) }}"><i class="bi bi-arrow-right-circle-fill small ps-1 text-success"></i></a>
                     </td>                  
                  </tr>
                  <tr class="table-rm-p">
                     <td>Status</td>
                     <td class="px-2">{{ $rm->status_pasien }}</td>                  
                  </tr>
                  @endif                   
               @endunless
            @endif
         </tbody>
       </table>
    </div>
    <div class="col-lg-2 p-0">
       <div class="button-rm d-flex align-items-sm-center flex-lg-column justify-content-center ps-lg-4">
          <a href="{{ route('rm.histori', $pasien->slug) }}" class="btn btn-outline-success btn-sm mb-3 mx-sm-3 mx-lg-0 w-100">Histori Rekam Medis</a>
         <a href="{{ route('sub.histori', $pasien->slug) }}" class="btn btn-outline-success btn-sm mb-3 mx-sm-3 mx-lg-0 w-100">Histori Rekam Terapi</a>
         @if(Request::is('pasien/'. $pasien->slug))
            @if($rmDetected == 1)
            <a href="{{ $rm->link_perkembangan }}" class="btn btn-outline-success btn-sm mb-3 mx-sm-3 mx-lg-0 w-100 {{ $rm->link_perkembangan ? '' : 'disabled' }}">Link Hasil Lab</a>
            @endif
         @endif
       </div>
    </div>
</div>