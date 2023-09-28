<div class="row card-performa">        
    <div class="col-12 col-sm col-md-6 col-xl px-0 py-2 p-sm-2 ps-sm-0">
        <div class="card shadow-sm rounded-3 border border-light h-100 h-100">
            <div class="card-body py-2 px-3 p-sm-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="order-2 flex-fill d-flex justify-content-end">
                        <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #c8e7f5; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-calendar-plus fs-4 text-primary"></i>
                        </div>
                    </div>
                    <div class="order-1">
                        <div class="h2 mb-0 fw-bold text-secondary mb-1">{{ $terapiTahunIni }}</div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase">
                            Total Terapi</div>
                        <span class="small text-secondary">Tahun ini</span>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm col-md-6 col-xl px-0 py-2 p-sm-2 pe-md-0 pe-xl-2">
        <div class="card shadow-sm rounded-3 border border-light h-100">
            <div class="card-body py-2 px-3 p-sm-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="order-2 flex-fill d-flex justify-content-end">
                        <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #d3f0f5; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-person fs-4 text-info"></i>
                        </div>
                    </div>
                    <div class="order-1">
                        <div class="h2 mb-0 fw-bold text-secondary mb-1">{{ $pasienTotal }}</div>
                        <div class="text-xs font-weight-bold text-info text-uppercase">
                            Total Pasien</div>
                        <span class="small text-secondary">Semua</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-12 col-sm col-md-6 col-xl px-0 py-2 p-sm-2 pe-sm-0 pe-md-2 ps-md-0 ps-xl-2">
        <div class="card shadow-sm rounded-3 border border-light h-100">
            <div class="card-body py-2 px-3 p-sm-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="order-2 flex-fill d-flex justify-content-end">
                        <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #f4f5c8; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-person-add fs-4 text-warning"></i>
                        </div>
                    </div>
                    <div class="order-1">
                        <div class="h2 mb-0 fw-bold text-secondary mb-1">{{ $prapasienTahunIni }}</div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase">
                            Pasien Baru</div>
                        <span class="small text-secondary">Tahun ini</span>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4 py-2 px-0 py-2 ps-md-2">
        <div class="card shadow-sm rounded-3 border border-light h-100">
            <div class="card-body py-2 px-3 p-sm-3 pb-sm-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="order-2 flex-fill d-flex justify-content-end">
                        <div class="col-auto rounded-50 d-flex justify-content-center align-items-center" style="background: #c8f5e5; height: 50px; width: 50px; border-radius: 50%">
                            <i class="bi bi-clipboard2-pulse fs-4 text-success"></i>
                        </div>
                    </div>
                    <div class="order-1">
                        <div class="h2 mb-0 fw-bold text-secondary mb-1">{{ $rekamMedisTahunIni }}</div>
                        <div class="text-xs font-weight-bold text-success">
                            REKAM MEDIS <span class="small text-secondary ps-1">(Tahun Ini)</span></div>
                        </div>
                                             
                    
                </div>
                <div class="d-flex justify-content-between w-100 mt-2">
                    <div class="hstack gap-1 mb-1">
                        <i class="bi bi-clock-fill c-text-primary small text-opacity-75"></i> 
                        <span>{{ $rawatJalanTahunIni }}</span>
                        <span class="small text-secondary">Rawat Jalan</span>
                    </div>
                    <div class="hstack gap-1 mb-1">
                        <i class="bi bi-pause-circle-fill text-warning small text-opacity-75"></i> 
                        <span>{{ $jedaTahunIni }}</span>
                        <span class="small text-secondary">Jeda</span>
                    </div>
                    <div class="hstack gap-1 mb-1">
                        <i class="bi bi-check-circle-fill c-text-success small text-opacity-75"></i> 
                        <span>{{ $selesaiTahunIni }}</span>
                        <span class="small text-secondary">Selesai</span>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>