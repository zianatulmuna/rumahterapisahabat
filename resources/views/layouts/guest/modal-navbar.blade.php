<div class="container-fluid">
  <div class="row">
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header border-bottom pb-2">
          <a href="/"><img src="/assets/logo/icon_klinik.png" class="logo"></a>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-content">
          <div class="offcanvas-body">
            <div class="container-fluid my-2">
              <a class="nav-link" aria-current="page" href="/" data-bs-dismiss="offcanvas">
                Beranda
              </a>
            </div>
            <div class="container-fluid my-2">
              <a class="nav-link" aria-current="page" href="/#jadwal" data-bs-dismiss="offcanvas">
                Jadwal
              </a>
            </div>
            <div class="container-fluid my-2">
              <button class="nav-link" aria-current="page" href="/#tim" data-bs-dismiss="offcanvas">
                Tim
              </button>
            </div>
            <div class="container-fluid my-2">
              <a class="nav-link" aria-current="page" href="/#testimoni" data-bs-dismiss="offcanvas">
                Testimoni
              </a>
            </div>

            <div class="container-fluid my-2">
              <a class="nav-link {{ Route::is('landing.form') ? 'fw-bold text-success' : ''}}" aria-current="page" href="{{ route('landing.form') }}">
                Daftar Sebagai Pasien
              </a>
            </div>
            
            @if($userAdmin||$userTerapis||$userKepala)
            <div class="container-fluid my-2 mt-4">
              <a class="nav-link {{ Route::is('beranda') ? 'fw-bold text-success' : ''}}" aria-current="page" href="{{ route('beranda') }}">
                <i class="bi bi-layout-text-sidebar-reverse pe-2"></i>
                Beranda Saya
              </a>
            </div>
            <div class="container-fluid my-2">
              <a class="dropdown-item text-danger hstack gap-2" href="/#" data-toggle="modal" data-target="#logoutModal" data-bs-dismiss="offcanvas">
                <i class="bi bi-box-arrow-right"></i>
                Keluar Akun
              </a>
            </div>     
            @else
            <div class="container-fluid my-2">
              <a class="nav-link {{ Route::is('login') ? 'fw-bold text-success' : ''}}" aria-current="page" href="{{ route('login') }}">
                Masuk Akun
              </a>
            </div>
            @endif
          </div>
        </div>
      </div>
  </div>
</div>
      