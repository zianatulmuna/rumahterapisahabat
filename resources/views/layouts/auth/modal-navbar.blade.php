<!-- Modal -->
<div class="modal fade p-0 modal-navbar" id="navbModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="h3">Klinik Rumah Terapi Sahabat</h1>
        </div>
        <div class="modal-body">            
            <div class="modal-line">
              <a href="/admin/dashboard" class="nav-link hstack {{ Request::is('admin/dashboard') ? 'active' : ''}}" aria-current="page">
                <i class="bi bi-house-door-fill"></i>
                Beranda
              </a>
            </div>

            <div class="modal-line">
              <a href="{{ route('pasien.baru') }}" class="nav-link hstack {{ Request::is('admin/pasien-baru*') ? 'active shadow-sm' : ''}}">
                <i class="bi bi-person-plus-fill"></i>
                Pasien Baru
              </a>
            </div>

            <div class="modal-line">
              <a href="{{ route('pasien.lama') }}" class="nav-link hstack {{ Request::is('admin/pasien/*') ? 'active' : ''}}">
                <i class="bi bi-person-fill-check"></i>
                Pasien Lama
              </a>
            </div>

            <div class="modal-line">
              <a href="{{ route('jadwal') }}" class="nav-link hstack {{ Request::is('admin/jadwal*') ? 'active' : ''}}">
                <i class="bi bi-calendar-plus-fill"></i>
                Jadwal
              </a>
          </div>

            <div class="modal-line">
              <a href="{{ route('terapis') }}" class="nav-link hstack {{ Request::is('admin/terapis*') ? 'active' : ''}}">
                <i class="fa-solid fa-user-nurse"></i>
                Terapis
              </a>
            </div>
        </div>

        <div class="modal-body modal-custom">
          <div class="modal-line ">
            <a href="{{ route('profil', auth()->user()->slug) }}" class="nav-link">
              <i class="bi bi-person-circle"></i>
              Profil
            </a>
          </div>

          <div class="modal-line">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="bi bi-box-arrow-right"></i>
              Keluar Akun
            </a>
          </div>
        </div>
      </div>
    </div>
  </div> 