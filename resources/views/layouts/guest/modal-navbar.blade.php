<div class="container-fluid">
  <div class="row">
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header border-bottom pb-2">
          <img src="/assets/icon_terapi.png" class="logo">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-content">
          <div class="offcanvas-body">
            <div class="container-fluid">
              <button class="nav-link" aria-current="page" href="#home" data-bs-dismiss="offcanvas">
                Beranda
              </button>
            </div>
            <div class="container-fluid">
              <a class="nav-link" aria-current="page" href="#jadwal" data-bs-dismiss="offcanvas">
                Jadwal
              </a>
            </div>
            <div class="container-fluid">
              <button class="nav-link" aria-current="page" href="#tim" data-bs-dismiss="offcanvas">
                Tim
              </button>
            </div>
            <div class="container-fluid">
              <a class="nav-link" aria-current="page" href="#testimoni" data-bs-dismiss="offcanvas">
                Testimoni
              </a>
            </div>

            <div class="container-fluid mt-3">
              <a class="nav-link {{ Route::is('landing.form') ? 'fw-bold text-success' : ''}}" aria-current="page" href="{{ route('landing.form') }}">
                Daftar Sebagai Pasien
              </a>
            </div>
            <div class="container-fluid ">
              <a class="nav-link {{ Route::is('login') ? 'fw-bold text-success' : ''}}" aria-current="page" href="{{ route('login') }}">
                Masuk Akun
              </a>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
      