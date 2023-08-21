@extends('layouts.auth.main')

@section('container')
<div class="content-container">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
      <h1 class="h2">Edit Pasien</h1>
   </div>

   <div class="modal" id="modalSuccess" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" id="btnClose" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center py-40">
            <p class="text-success" style="font-size: 3em;"><i class="fa-regular fa-circle-check"></i></p>
            <h3>Good Job!</h3>
            <p>Data berhasil di-update</p>
            <button class="btn btn-secondary my-3 py-2 px-3" type="button" id='closeModal' data-bs-dismiss="modal">Oke</button>
          </div>
        </div>
      </div>
    </div>

   @livewire('form-edit-pasien', ['pasien' => $pasien, 'rm' => $rm])
</div>
@endsection

@push('script')
   @livewireScripts
@endpush