<header class="navbar navbar-expand-lg navbar-light bg-light shadow px-4 sticky-top navbar-landing">
    <!-- Button trigger offcanvas -->
    <button class="btn btn-success btn-sm py-1 me-2 d-lg-none" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
      <i class="bi bi-list fs-6"></i>
    </button>

    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a href="/"><img src="/assets/logo/logo_klinik.png" class="logo" alt="Rumah Terapi Sahabat"></a>
      </div>
    </div>

    <div class="collapse navbar-collapse nav justify-content-end" id="navbarsExample03">
      <ul class="collapse navbar-collapse nav justify-content-end">
        <li class="nav-item px-3 d-flex align-items-center d-none d-lg-grid">
          <a href="/" style="
                text-decoration: none;
                font-family: 'Raleway', sans-serif;
                color: #0e8357;
              ">Beranda</a>
        </li>
        <li class="nav-item mx-3 d-flex align-items-center d-none d-lg-grid">
          <a href="/#jadwal" style="
                text-decoration: none;
                font-family: 'Raleway', sans-serif;
                color: #0e8357;
              ">Jadwal</a>
        </li>
        <li class="nav-item mx-3 d-flex align-items-center d-none d-lg-grid">
          <a href="/#tim" style="
                text-decoration: none;
                font-family: 'Raleway', sans-serif;
                color: #0e8357;
              ">Tim</a>
        </li>
        <li class="nav-item mx-3 d-flex align-items-center d-none d-lg-grid">
          <a href="/#testimoni" style="
                text-decoration: none;
                font-family: 'Raleway', sans-serif;
                color: #0e8357;
              ">Testimoni</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('landing.form') }}" class="btn {{ Route::is('login') ? 'btn-success' : 'btn-outline-success' }} mx-3 d-none d-lg-grid">Daftar Sebagai Pasien</a>
        </li>
        @if($userAdmin||$userTerapis)
        <li class="nav-item dropdown ps-2">
          <a class="nav-link link-success dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if($userAdmin)
              {{-- {{ $userAdmin->nama }} --}}
              @if ($userAdmin->foto)
                <img src="{{ asset('storage/' . $userAdmin->foto) }}" class="avatar-img mx-1" alt="{{ $userAdmin->nama }}">
              @else
                @if($userAdmin->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="avatar-img mx-1" alt="{{ $userAdmin->nama }}">
                @else
                  <img src="/img/undraw_profile_1.svg" class="avatar-img mx-1" alt="{{ $userAdmin->nama }}">
                @endif
              @endif
            @elseif($userTerapis)
              {{-- {{ $userTerapis->nama }} --}}
              @if ($userTerapis->foto)
                <img src="{{ asset('storage/' . $userTerapis->foto) }}" class="avatar-img mx-1" alt="{{ $userTerapis->nama }}">
              @else
                @if($userTerapis->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="avatar-img mx-1" alt="{{ $userTerapis->nama }}">
                @else
                  <img src="/img/undraw_profile_1.svg" class="avatar-img mx-1" alt="{{ $userTerapis->nama }}">
                @endif
              @endif
            @else
              {{-- {{ $userKepala->nama }} --}}
              @if ($userKepala->foto)
                <img src="{{ asset('storage/' . $userKepala->foto) }}" class="avatar-img mx-1" alt="{{ $userKepala->nama }}">
              @else
                @if($userKepala->jenis_kelamin === 'Laki-Laki')
                  <img src="/img/avatar-l.png" class="avatar-img mx-1" alt="{{ $userKepala->nama }}">
                @else
                  <img src="/img/undraw_profile_1.svg" class="avatar-img mx-1" alt="{{ $userKepala->nama }}">
                @endif
              @endif
            @endif 
            
          </a>
          <ul class="dropdown-menu dropdown-menu-end me-3" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="/beranda"><i class="bi bi-layout-text-sidebar-reverse pe-2"></i> Beranda Saya</a></li>

            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="/logout" method="post">
                  @csrf
                  <button type="submit" class="text-danger dropdown-item"><i class="bi bi-box-arrow-left pe-2"></i> Keluar Akun</button>
              </form>
          </li>
          </ul>
        </li>      
        @else
        <li class="nav-item">
          <a href="{{ route('login') }}" class="btn {{ Route::is('login') ? 'btn-outline-success' : 'btn-success' }} d-none d-lg-grid">Masuk</a>
        </li>
        @endif        
      </ul>
    </div>
</header>