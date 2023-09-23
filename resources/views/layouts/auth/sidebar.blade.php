<nav id="sidebarMenu" class="col-lg-2 d-lg-block sidebar collapse sidebar-custom">
  <div class="position-sticky">
    <ul class="nav flex-column mx-1">
      <li class="nav-item">
        <a href="{{ route('beranda') }}" class="hstack {{ Request::is('beranda') ? 'active' : ''}}" aria-current="page">
          <i class="bi bi-house-door-fill me-2"></i>
          Beranda
        </a>
      </li>
      @if($userAdmin || $userTerapis->id_terapis == 'KTR001') 
        <hr class="sidebar-divider my-0" />
        <li class="nav-item">
          <a href="{{ route('pasien.baru') }}" class="hstack {{ Request::is('pasien-baru*') ? 'active shadow-sm' : ''}}">
            <i class="bi bi-person-plus-fill me-2"></i>
            Pasien Baru
          </a>
        </li>
      @endif
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('pasien.lama') }}" class="hstack {{ Request::is('pasien/*') ? 'active' : ''}}">
          <i class="bi bi-person-fill-check me-2"></i>
          Pasien {{ $userAdmin || $userTerapis->id_terapis == 'KTR001' ? "Lama" : "" }}
        </a>
      </li>
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('jadwal') }}" class="hstack {{ Request::is('jadwal*') ? 'active' : ''}}">
          <i class="bi bi-calendar-plus-fill me-2"></i>
          Jadwal
        </a>
      </li>
      @if($userAdmin || $userTerapis->id_terapis == 'KTR001') 
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('terapis') }}" class="hstack {{ Request::is('terapis*') ? 'active' : ''}}">
          <i class="fa-solid fa-user-nurse me-2"></i>
          Terapis
        </a>
      </li>
      @endif
      @if($userTerapis) 
      <hr class="sidebar-divider my-0" />
      <li class="nav-item">
        <a href="{{ route('sesi.terapi') }}" class="hstack align-items-center {{ Request::is('sesi-terapi*') ? 'active' : ''}}">
          <i class="bi-heart-pulse-fill me-2"></i>
          Sesi Terapi
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>