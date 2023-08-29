<div>
    {{-- <div class="col-xl-4 alert alert-info alert-dismissible shadow-lg text-wrap fade show action-alert" style="position: fixed; bottom: 80px; right: 20px;" role="alert">
        <div class="d-flex align-items-center header-color">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong class="header-message">Success!</strong>
        </div>
        <div class="body-alert ps-4">
            <p class="m-0 text-dark">{{ session('success') }}sukses berhasil ditaman</p>
        </div>
        <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> --}}
    <div class="col-md-6 col-lg-4 mx-sm-0 alert alert-dismissible shadow-lg text-wrap fade show action-alert hstack g-2 align-items-start" style="position: fixed; bottom: 0px; right: 22px; margin-left: 28px; background-color: #cdfad6" role="alert" id="myAlert">
        <i class="bi bi-check-circle-fill header-color text-success fs-5 me-2"></i>
        <div class="ps-1">
            <strong class="header-message text-success">Success!</strong>
            <p class="m-0 text-dark body-alert">{{ session('success') }}</p>
        </div>
        <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    {{-- <div class="toast fade show" style="position: fixed; bottom: 20px; right: 20px;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-5 header-color me-2"></i>
                <strong class="header-message fs-6">Success!</strong>
            </div>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-black" style="font-size: 12pt;">
            {{ session('success') }} sukses berhasil ditaman
        </div>
      </div> --}}
</div>

@push('script')  
    @if(session()->has('create'))
        <script>
            document.querySelector('.header-message').textContent = "Create Success";
        </script>
    @elseif(session()->has('createPasien'))
        <script>
            document.querySelector('.body-alert').innerHTML += `<a href="/admin/pasien/{{ session('createPasien') }}">Lihat Data</a>`;            
        </script>
    @elseif(session()->has('update'))
        <script>
            document.querySelector('.header-message').textContent = "Update Success";
        </script>
    @elseif(session()->has('delete'))
        <script>
            document.querySelector('.header-message').textContent = "Delete Success";
        </script>
    @endif
    <script>
        const myAlert = document.getElementById('myAlert');

        document.body.addEventListener('click', function(event) {
          if (!myAlert.contains(event.target)) {
            myAlert.style.display = 'none';
          }
        });
    </script>

@endpush