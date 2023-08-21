@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h2">Pasien Lama</h1>
   </div>

   <!-- Topbar Search -->
   <div class="d-flex">
      <form
         class="d-none d-sm-inline-block form-inline mr-auto ml-md-7 my-2 my-md-0 w-50 navbar-search">
         <div class="input-group">
            <input type="text" class="form-control bg-white border-0 small" placeholder="Search for..."
               aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
               <button class="btn btn-success" type="button">
                     <i class="fas fa-search fa-sm"></i>
               </button>
            </div>
         </div>
      </form>
   </div>
   

   <div class="row row-cols-1 row-cols-md-4 g-3 mt-4">
      @foreach ($pasien_lama as $pasien)
      <div class="col">
         <div class="card h-100" style="width: 15rem;">
            <h6 class="text-dark card-title stretched-link text-truncate text-center flex-fill py-2 px-3" style="background-color: white; width: 100%; position: absolute; top: 0px;">
               {{ $pasien->nama }}
            </h6>
            <div class="foto-pasien" style="max-height: 222px; overflow: hidden;">
               @if ($pasien->foto)
                  <img src="{{ asset('storage/' . $pasien->foto) }}" class="card-img-top" alt="...">
               @else
                  @if($pasien->jenis_kelamin === 'Laki-Laki')
                     <img src="/img/avatar-l.png" class="card-img-top" alt="...">
                  @else
                     <img src="/img/avatar-p.png" class="card-img-top" alt="...">
                  @endif
               @endif
            </div>
            <div class="card-body text-center p-2">
               <div class="card-subtitle mb-2 mt-1 text-body-secondary" style="height: 40px">
                  @foreach($pasien->rekamMedis as $rm)
                     {{ $loop->first ? '' : ',' }}
                     @php
                         $arrayPenyakit = collect(explode(",", $rm->penyakit));
                     @endphp
                     @foreach($arrayPenyakit as $p)
                        {{ $loop->first ? '' : ',' }}
                        <a href="#" class="link-secondary link-underline-light">{{ $p }}</a>
                     @endforeach
                  @endforeach
               </div>
               <div class="p-2 d-flex justify-content-between bottom-0">
                  @if($pasien->rekamMedis->count() < 1)
                     <a href="{{ route('sub.histori', $pasien->slug) }}" class="link-secondary link-underline-secondary disabled">Rekam Terapi</a>
                  @else
                     <a href="{{ route('sub.histori', $pasien->slug) }}">Rekam Terapi</a>
                  @endif
                  <a href="{{ route('pasien.rm', $pasien->slug) }}">Rekam Medis</a>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   
   {{-- <div class="row row-cols-1 row-cols-md-4 g-3 mt-4">
      @foreach ($pasien_lama as $pasien)
      <div class="col mb-4">
         <div class="card h-100" style="width: 14rem;">
            <div class="foto-pasien" style="max-height: 222px; overflow: hidden;">
               @if ($pasien->foto)
                  <img src="{{ asset('storage/' . $pasien->foto) }}" class="card-img-top" alt="...">
               @else
                  @if($pasien->jenis_kelamin === 'Laki-Laki')
                     <img src="/img/avatar-l.png" class="card-img-top" alt="...">
                  @else
                     <img src="/img/avatar-p.png" class="card-img-top" alt="...">
                  @endif
               @endif
            </div>
            <div class="card-img-overlay d-flex align-items-center p-0">
               <h6 class="text-dark card-title stretched-link text-truncate text-center flex-fill py-2 px-3" style="background-color: white; width: 100%; position: absolute; top: 0px;">
                  {{ $pasien->nama }}
               </h6>
            </div>
            <div class="card-body text-center p-2">
               <h6 class="card-subtitle mb-2 mt-1 text-body-secondary" style="height: 32px">
                  @foreach($pasien->rekamMedis as $rm)
                     {{ $loop->first ? '' : ', ' }}
                     {{ $rm->penyakit }}
                  @endforeach
               </h6>
               <div class="card-body p-2 d-flex justify-content-between bottom-0">
                  <a href="/admin/p/rekam-terapi/histori/{{ $pasien->id_pasien }}">Rekam Terapi</a>
                  <a href="/admin/p/rekam-medis/{{ $pasien->slug }}">Rekam Medis</a>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div> --}}
   
   
</div>

<div class="d-flex justify-content-center mt-5">
   {{ $pasien_lama->links() }}
</div>
@endsection

@section('modal-alert') 
{{-- modal delete success --}}
<div class="modal" id="deleteSuccess" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
   <div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="btn-close" id="btnClose" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-40">
         <p class="text-danger m-0" style="font-size: 3em;"><i class="bi bi-check-circle"></i></p>
         <h3>Berhasil!</h3>
         <p>Pasien berhasil dihapus</p>
         <button class="btn btn-secondary my-3 py-2 px-3" type="button" id="closeModal" data-dismiss="modal">Oke</button>
      </div>
   </div>
   </div>
</div>
@endsection

@push('script')
   @if(session()->has('rmDeleteSuccess'))
      <script>
         window.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('deleteSuccess');
            modal.style.display = 'block';

            document.getElementById('btnClose').addEventListener('click', function() {
               modal.style.display = 'none';
            });
            
            document.getElementById('closeModal').addEventListener('click', function() {
               modal.style.display = 'none';
            });                  
         });      
      </script>
   @endif    
@endpush