@extends('layouts.auth.main')

@section('container')
<div class="content-container mx-2">
    <div class="row mb-3">
      <h1 class="h2 px-0 pb-3 border-bottom text-secondary">Selamat Datang, {{ auth()->user()->nama }} !</h1>
    </div>
        {{-- grafik --}}
        <div class="row p-0 mt-2 mt-lg-3">
            @livewire('grafik-dashboard')
        </div>

    <div class="row main-bg mt-3 mt-lg-4" id="jadwal">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h4">Jadwal Terapi</h1>
        </div>

        @livewire('jadwal-dashboard')

        
    </div>
</div>
@endsection

@push('script')
<script>
    // const inputDate = document.querySelector("#startDate");

    // inputDate.addEventListener("focus", function() {
    //     document.querySelector(".icon-date").style.display = "none";
    //     inputDate.type = 'date';
    //     inputDate.classList.remove("ps-2");
    // });
    // inputDate.addEventListener("blur", function() {
    //     document.querySelector(".icon-date").style.display = "block";
    //     inputDate.type = 'text';
    // });

    function handleSwitchChange(checkbox) {
        const total = document.querySelector('#totalReady');
        if (checkbox.checked) {
            fetch('/admin/dashboard/setReady?username=' + checkbox.value + '&status=1')
            .then(response => response.json())
            .then(data => total.innerText = data.total + ' Terapis')
        } else {
            fetch('/admin/dashboard/setReady?username=' + checkbox.value + '&status=0')
            .then(response => response.json())
            .then(data => total.innerText = data.total + ' Terapis')
        }
    }    
</script>

{{-- @if(request('tanggal') || request('mulai'))
    <script>
        window.onload = function() {
            // document.querySelector("#jadwal").scrollIntoView({
            //     behavior: "smooth",
            //     block: "start"
            // });
            window.location.hash = 'jadwal';
        };
    </script>
@endif --}}
@livewireScripts
@endpush