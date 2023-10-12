<div class="row card-performa">
  <div class="col-12 col-sm col-md-6 col-xl p-sm-2 ps-sm-0 px-0 py-2">
    <div class="card rounded-3 border-light h-100 h-100 border shadow-sm">
      <div class="card-body p-sm-3 px-3 py-2">
        <div class="d-flex justify-content-between align-items-center">
          <div class="flex-fill d-flex justify-content-end order-2">
            <div class="rounded-50 d-flex justify-content-center align-items-center col-auto"
              style="background: #c8e7f5; height: 50px; width: 50px; border-radius: 50%">
              <i class="bi bi-calendar-plus fs-4 text-primary"></i>
            </div>
          </div>
          <div class="order-1">
            <div class="h2 fw-bold text-secondary mb-0 mb-1">{{ $terapiTahunIni }}</div>
            <div class="font-weight-bold text-primary text-uppercase text-xs">
              Total Terapi</div>
            <span class="small text-secondary">Tahun ini</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm col-md-6 col-xl p-sm-2 pe-md-0 pe-xl-2 px-0 py-2">
    <div class="card rounded-3 border-light h-100 border shadow-sm">
      <div class="card-body p-sm-3 px-3 py-2">
        <div class="d-flex align-items-center justify-content-between">
          <div class="flex-fill d-flex justify-content-end order-2">
            <div class="rounded-50 d-flex justify-content-center align-items-center col-auto"
              style="background: #d3f0f5; height: 50px; width: 50px; border-radius: 50%">
              <i class="bi bi-person fs-4 text-info"></i>
            </div>
          </div>
          <div class="order-1">
            <div class="h2 fw-bold text-secondary mb-0 mb-1">{{ $pasienTotal }}</div>
            <div class="font-weight-bold text-info text-uppercase text-xs">
              Total Pasien</div>
            <span class="small text-secondary">Semua</span>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="col-12 col-sm col-md-6 col-xl p-sm-2 pe-sm-0 pe-md-2 ps-md-0 ps-xl-2 px-0 py-2">
    <div class="card rounded-3 border-light h-100 border shadow-sm">
      <div class="card-body p-sm-3 px-3 py-2">
        <div class="d-flex align-items-center justify-content-between">
          <div class="flex-fill d-flex justify-content-end order-2">
            <div class="rounded-50 d-flex justify-content-center align-items-center col-auto"
              style="background: #f4f5c8; height: 50px; width: 50px; border-radius: 50%">
              <i class="bi bi-person-add fs-4 text-warning"></i>
            </div>
          </div>
          <div class="order-1">
            <div class="h2 fw-bold text-secondary mb-0 mb-1">{{ $prapasienTahunIni }}</div>
            <div class="font-weight-bold text-warning text-uppercase text-xs">
              Pasien Baru</div>
            <span class="small text-secondary">Tahun ini</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-xl-4 ps-md-2 px-0 py-2 py-2">
    <div class="card rounded-3 border-light h-100 border shadow-sm">
      <div class="card-body p-sm-3 pb-sm-2 px-3 py-2">
        <div class="d-flex align-items-center justify-content-between">
          <div class="flex-fill d-flex justify-content-end order-2">
            <div class="rounded-50 d-flex justify-content-center align-items-center col-auto"
              style="background: #c8f5e5; height: 50px; width: 50px; border-radius: 50%">
              <i class="bi bi-clipboard2-pulse fs-4 text-success"></i>
            </div>
          </div>
          <div class="order-1">
            <div class="h2 fw-bold text-secondary mb-0 mb-1">{{ $rekamMedisTahunIni }}</div>
            <div class="font-weight-bold text-success text-xs">
              REKAM MEDIS <span class="small text-secondary ps-1">(Tahun Ini)</span></div>
          </div>
        </div>
        <div class="d-flex justify-content-between w-100 mt-2">
          <div class="hstack mb-1 gap-1">
            <i class="bi bi-clock-fill c-text-primary small text-opacity-75"></i>
            <span>{{ $rawatJalanTahunIni }}</span>
            <span class="small text-secondary">Rawat Jalan</span>
          </div>
          <div class="hstack mb-1 gap-1">
            <i class="bi bi-pause-circle-fill text-warning small text-opacity-75"></i>
            <span>{{ $jedaTahunIni }}</span>
            <span class="small text-secondary">Jeda</span>
          </div>
          <div class="hstack mb-1 gap-1">
            <i class="bi bi-check-circle-fill c-text-success small text-opacity-75"></i>
            <span>{{ $selesaiTahunIni }}</span>
            <span class="small text-secondary">Selesai</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
