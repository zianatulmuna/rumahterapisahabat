<!-- offcanvas -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasAuth"
  aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header border-bottom pb-2">
    <a href="/"><img src="/assets/logo/logo_klinik.png" class="logo"></a>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-content">
    <div class="offcanvas-body">            
      <div class="my-4">
        <a href="/beranda" class="nav-link hstack gap-2 {{ Request::is('beranda') ? 'fw-bold text-success text-success' : ''}}" aria-current="page">
          <i class="bi bi-house-door-fill"></i>
          Beranda
        </a>
      </div>
      @unless ($userTerapis)
      <div class="my-4">
        <a href="{{ route('pasien.baru') }}" class="nav-link hstack gap-2 {{ Request::is('pasien-baru*') ? 'fw-bold text-success' : ''}}">
          <i class="bi bi-person-plus-fill"></i>
          Pasien Baru
        </a>
      </div>                
      @endunless

      <div class="my-4">
        <a href="{{ route('pasien.lama') }}" class="nav-link hstack gap-2 {{ Request::is('pasien/*') ? 'fw-bold text-success' : ''}}">
          <i class="bi bi-person-fill-check"></i>
          {{ $userTerapis ? "Pasien" : "Pasien Lama" }}
        </a>
      </div>

      <div class="my-4">
        <a href="{{ route('jadwal') }}" class="nav-link hstack gap-2 {{ Request::is('jadwal*') ? 'fw-bold text-success' : ''}}">
          <i class="bi bi-calendar-plus-fill"></i>
          {{ $userTerapis ? "Terapi" : "Jadwal" }}
        </a>
      </div>

      @unless ($userTerapis)
      <div class="my-4">
        <a href="{{ route('terapis') }}" class="nav-link hstack gap-2 {{ Request::is('terapis*') ? 'fw-bold text-success' : ''}}">
          <i class="fa-solid fa-user-nurse"></i>
          Terapis
        </a>
      </div>
      @endunless

      <div class="mt-5 pb-5">
        <div class="my-4">
          <a href="{{ route('profil', auth()->user()->slug) }}" class="nav-link hstack gap-2">
            <i class="bi bi-person-circle"></i>
            Profil
          </a>
        </div>

        <div class="my-4">
          <a class="dropdown-item text-danger hstack gap-2" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="bi bi-box-arrow-right"></i>
            Keluar Akun
          </a>
        </div>
      </div>
    </div>
  </div>
</div> 