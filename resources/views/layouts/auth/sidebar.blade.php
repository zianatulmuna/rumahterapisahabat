<nav id="sidebarMenu" class="col-lg-2 d-lg-block sidebar collapse sidebar-custom">
  <div class="position-sticky">
    <ul class="nav flex-column mx-1">
      <li class="nav-item">
        <a href="{{ route('beranda') }}" class="nav-link hstack {{ Request::is('beranda') ? 'active' : ''}}" aria-current="page">
          <i class="bi bi-house-door-fill me-2"></i>
          Beranda
        </a>
      </li>
      @unless($userTerapis && !$userKepala) 
        <hr class="sidebar-divider my-0" />
        <li class="nav-item">
          <a href="{{ route('pasien.baru') }}" class="nav-link hstack {{ Request::is('pasien-baru*') ? 'active shadow-sm' : ''}}">
            <i class="bi bi-person-plus-fill me-2"></i>
            Pasien Baru
          </a>
        </li>
      @endunless
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('pasien.lama') }}" class="nav-link hstack {{ Request::is('pasien/*') ? 'active' : ''}}">
          <i class="bi bi-person-fill-check me-2"></i>
          Pasien {{ $userAdmin || $userKepala ? "Lama" : "" }}
        </a>
      </li>
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('jadwal') }}" class="nav-link hstack {{ Request::is('jadwal*') ? 'active' : ''}}">
          <i class="bi bi-calendar-plus-fill me-2"></i>
          Jadwal
          {{-- {{ $userTerapis ? "Terapi" : "Jadwal" }} --}}
        </a>
      </li>
      @unless($userTerapis) 
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('terapis') }}" class="nav-link hstack {{ Request::is('terapis*') ? 'active' : ''}}">
          <i class="fa-solid fa-user-nurse me-2"></i>
          Terapis
        </a>
      </li>
      @endunless
      @if($userTerapis) 
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('sesi.terapi', $userTerapis->username) }}" class="nav-link hstack align-items-center {{ Request::is('sesi-terapi*') ? 'active' : ''}}">
          <i class="bi-heart-pulse-fill me-2"></i>
          Sesi Terapi
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>