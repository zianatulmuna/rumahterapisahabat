<div>
    <div class="modal" id="modalSuccess" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
           <div class="modal-header">
              <button type="button" class="btn-close" id="btnClose" data-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body text-center py-40">
              <p class="text-success mb-1" style="font-size: 3em;"><i class="bi bi-check-circle"></i></p>
              <h3>Berhasil!</h3>
              <p>{{ session('success') }}</p>
              <button class="btn btn-secondary my-3 py-2 px-3" type="button" id="closeModal" data-dismiss="modal">Oke</button>
           </div>
        </div>
        </div>
     </div>
</div>