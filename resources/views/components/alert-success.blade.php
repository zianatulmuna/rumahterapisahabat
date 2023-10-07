<div>
    <div class="col-md-6 col-lg-4 mx-sm-0 alert alert-dismissible shadow-lg text-wrap fade show action-alert hstack g-2 align-items-start" style="position: fixed; bottom: 0px; right: 22px; margin-left: 28px; background-color: #cdfad6" role="alert" id="myAlert">
        <i class="bi bi-check-circle-fill header-color text-success fs-5 me-2"></i>
        <div class="ps-1">
            <strong class="header-message text-success">Success!</strong>
            <p class="m-0 text-dark body-alert">{{ session('success') }}</p>
        </div>
        <button type="button" class="btn-close small" data-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

@push('script')  
    @if(session()->has('create'))
        <script>
            document.querySelector('.header-message').textContent = "Create Success";
        </script>
    @elseif(session()->has('createPasien'))
        <script>
            document.querySelector('.body-alert').innerHTML += `<a href="/pasien/{{ session('createPasien') }}" class="ps-2">Lihat Data</a>`;            
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