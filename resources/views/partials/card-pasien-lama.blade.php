<div class="col">
    <div class="card border-0 text-center card-custom shadow-sm">
      <div class="card-header py-1 py-sm-2">
        <h6 class="card-header-text">{{ $pasien->nama }}</h6>
      </div>
        @if ($pasien->foto)
          <img src="{{ asset('storage/' . $pasien->foto) }}" class="card-img-top" alt="...">
        @else
          @if($pasien->jenis_kelamin === 'Laki-Laki')
              <img src="/img/avatar-l.png" class="card-img-top" alt="...">
          @else
              <img src="/img/avatar-p.png" class="card-img-top" alt="...">
          @endif
        @endif
      <div class="card-body py-1 px-2 align-middle">
        <p>
          @foreach($pasien->rekamMedis as $rm)
            {{-- @if($rm->penyakit != null) --}}
              @php
                  $arrayPenyakit = explode(",", $rm->penyakit);
              @endphp
              @foreach($arrayPenyakit as $p)
                <a href="/rekam-terapi/tag?search={{ $p }}" target="_blank" class="link-dark link-underline-light">{{ $p }}</a>@if(!$loop->last),@elseif(!$loop->parent->last),@endif
              @endforeach
            {{-- @endif --}}
          @endforeach
        </p>
      </div>
      <div class="card-footer bg-white d-flex align-item-center justify-content-between">
        @if($pasien->rekamMedis->count() < 1)
            <a href="{{ route('sub.histori', $pasien->slug) }}" class="link-secondary link-underline-secondary disabled">Rekam Terapi</a>
        @else
            <a href="{{ route('sub.histori', $pasien->slug) }}" class="lh-sm">Histori Terapi</a>
        @endif
        <div class="vr"></div>
        <a href="{{ route('pasien.rm', $pasien->slug) }}" class="lh-sm">Rekam Medis</a>
      </div>
    </div>
  </div>