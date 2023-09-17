<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/assets/logo/icon_klinik.png">
  <title>Rumah Terapi Sahabat</title>

  <!-- Custom fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;1,200;1,400&display=swap"
    rel="stylesheet" />

  <!-- Owl Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />

  <!-- Bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Custom styles -->
  <link href="/css/styles.css" rel="stylesheet" />
  @stack('style')
</head>

<body>
    @include('layouts.guest.header') 

  <div class="landing-container">
    @include('layouts.guest.modal-navbar')    
    @yield('container')    
  </div>

  @yield('modal-alert')

  <!-- Logout Modal-->
  <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.3)" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-expanded="false">
    <div class="modal-dialog modal-dialog-centered mx-auto" role="document">
      <div class="modal-content mx-3">
        <div class="modal-header justify-content-center border-0 bg-danger">
          <h1 class="fw-bold text-white">
            <i class="bi bi-exclamation-circle" style="font-size: 40px;"></i>
          </h1>
        </div>
        <div class="modal-body text-center py-4">
          <h5 class="fw-bold">Yakin ingin keluar?</h5>
          Tekan "Logout" jika ingin mengakhiri session.
        </div>
        <div class="modal-footer justify-content-between mx-3">
          <button class="btn btn-secondary" type="button" id="logoutCloseBtn">Cancel</button>
          <form action="/logout" method="post">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @unless(Request::is('login'))
    @include('layouts.guest.footer')       
  @endunless

  <!-- Bootstrap core JavaScript-->
  {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script> --}}
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- chart -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/c40b365784.js" crossorigin="anonymous"></script>

  <!-- script logout modal -->
  <script>
    document.querySelector('#logoutCloseBtn').addEventListener('click', function(event) {
      document.getElementById('logoutModal').classList.remove('show');
    });
  </script>

  <!-- script pages -->
  @stack('script')
  
</body>

</html>