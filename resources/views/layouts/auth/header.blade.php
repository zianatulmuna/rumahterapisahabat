<header class="navbar navbar-expand-sm navbar-light bg-light shadow px-4 sticky-top navbar-custom">
    <!-- Button trigger modal -->
    <div class="mobile-toggler d-lg-none me-3">
      <a href="#" data-bs-toggle="modal" data-bs-target="#navbModal">
        <i class="bi bi-list"></i>
      </a>
    </div>
  
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <img src="/assets/Logo_Klinik.jpg" class="logo" alt="Logo Klinik">
      </div>
    </div>
  
    <div class="collapse navbar-collapse nav justify-content-end" id="navbarsExample03">
      <ul class="navbar-nav mr-auto align-items-center">
        @if($userTerapis)
          <li class="me-3 d-none d-sm-block">
            <div class="row">                
              <div class="col">
                <div class="form-switch custom-toggle">
                  <input class="form-check-input" type="checkbox" value="{{ $userTerapis->username }}" id="customSwitch" @if($userTerapis->is_ready) checked @endif onchange="handleSwitchChange(this)">
                  <label class="form-check-label ps-2" for="customSwitch">Hadir</label>
                </div>
              </div>
              <div class="col vr p-0 me-2" style="width: 1px;"></div>
            </div>
          </li>
        @endif
        <li class="nav-item dropdown">
          <a class="nav-link toggle-profil px-0" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ auth()->user()->nama }} 
            @if (auth()->user()->foto)
                <img src="{{ asset('storage/' . auth()->user()->foto) }}" class="avatar-img mx-1" alt="{{ auth()->user()->nama }}">
            @else
                @if(auth()->user()->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/undraw_profile.svg" class="avatar-img mx-1" alt="{{ auth()->user()->nama }}">
                @else
                  <img src="/img/undraw_profile_1.svg" class="avatar-img mx-1" alt="{{ auth()->user()->nama }}">
                @endif
            @endif
            {{-- <img src="/img/undraw_profile.svg" class="avatar-img ml-2"> --}}
            <i class="bi bi-caret-down-fill text-secondary small"></i>
          </a>
          <div class="dropdown-menu shadow dropdown-profil" aria-labelledby="dropdown03">
            <a class="dropdown-item" href="{{ route('profil', auth()->user()->slug) }}">
              <i class="bi bi-person-circle pe-1"></i>
              Profil
            </a>
            <hr class="dropdown-divider my-0" />
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fa-solid fa-right-from-bracket pe-1"></i>
              Keluar Akun
            </a>
          </div>
        </li>        
      </ul>
    </div>  
</header>

@section('modal-alert')
  <!-- Logout Modal-->
  <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.5)" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-expanded="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content mx-3">
        <div class="modal-header justify-content-center border-0 bg-danger">
          <h1 class="fw-bold text-white">
            <i class="bi bi-exclamation-circle" style="font-size: 40px;"></i>
          </h1>
        </div>
        <div class="modal-body text-center py-4">
          <h5 class="fw-bold">Yakin ingin keluar?</h5>
          Tekan "Logout" jika ingin mengakhiri session.
        </div>
        <div class="modal-footer justify-content-between mx-3">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <form action="/logout" method="post">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
    <script>
      function handleSwitchChange(checkbox) {
        if (checkbox.checked) {
            fetch('/setTerapisReady?username=' + checkbox.value + '&status=1')
        } else {
            fetch('/setTerapisReady?username=' + checkbox.value + '&status=0')
        }
      }

    //   document.addEventListener('change', function(e){
    //     e.preventDefault();
    // })
    </script>
@endpush
