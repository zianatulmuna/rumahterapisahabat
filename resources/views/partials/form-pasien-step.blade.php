<div class="row justify-content-between py-sm-5 custom-step custom-step-pasien">
    <div class="col text-center">
      <i class="bi {{  $currentStep == 1 ? 'bi-1-circle-fill' : ($currentStep >= 1 ? 'bi bi-check-circle-fill' : 'bi-1-circle')  }} text-success h1"></i>
      <h5 class="pt-2">Data Diri</h5>
    </div>
    <div class="col text-center">
      <i class="bi {{  $currentStep == 2 ? 'bi-2-circle-fill' : ($currentStep >= 2 ? 'bi bi-check-circle-fill' : 'bi-2-circle')  }} text-success h1"></i>
      <h5 class="pt-2">Data Penunjang</h5>
    </div>
    <div class="col text-center">
      <i class="bi {{  $currentStep == 3 ? 'bi-3-circle-fill' : ($currentStep >= 3 ? 'bi bi-check-circle-fill' : 'bi-3-circle')  }} text-success h1"></i>
      <h5 class="pt-2">Rencana Layanan</h5>
    </div>
    <div class="col text-center">
      <i class="bi {{  $currentStep == 4 ? 'bi-4-circle-fill' : ($currentStep >= 4 ? 'bi bi-check-circle-fill' : 'bi-4-circle')  }} text-success h1"></i>
      <h5 class="pt-2">Data Awal</h5>
    </div>
    <div class="col text-center">
      <i class="bi {{  $currentStep == 5 ? 'bi-5-circle-fill' : ($currentStep >= 5 ? 'bi bi-check-circle-fill' : 'bi-5-circle')  }} text-success h1"></i>
      <h5 class="pt-2">Target Terapi</h5>
    </div>
    <div class="col text-center">
      <i class="bi {{  $currentStep == 6 ? 'bi-6-circle-fill' : 'bi-6-circle'  }} text-success h1"></i>
      <h5 class="pt-2">Privasi Data</h5>
    </div>
  </div>
  <div class="text-center step-title mt-3 mb-4">
    @php
      $stepTitles = [
        1 => 'Data Diri',
        2 => 'Data Penunjang',
        3 => 'Rencana Layanan',
        4 => 'Data Awal',
        5 => 'Target Terapi',
        6 => 'Privasi Data',
      ];
    @endphp
    <h5 class="m-0">{{ $stepTitles[$currentStep] }}</h5>
</div>