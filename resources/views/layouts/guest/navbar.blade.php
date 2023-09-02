<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">Rumah Terapi Sahabat</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
        </ul>

        {{-- <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="/login" class="nav-link"><i class="bi bi-box-arrow-right"></i> Login</a>
            </li>
        </ul> --}}

        
        <ul class="navbar-nav ms-auto">
            @if(Auth::guard('admin')->user()||Auth::guard('terapis')->user())
            <li class="nav-item dropdown">
                @if(Auth::guard('admin')->user())
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Welcome back, {{ Auth::guard('admin')->user()->nama }}
                </a>
                @else
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Welcome back, {{ Auth::guard('terapis')->user()->nama }}
                  </a>
                @endif
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/beranda"><i class="bi bi-layout-text-sidebar-reverse"></i> My Dashboard</a></li>

                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-left"></i> Logout</button>
                    </form>
                </li>
                </ul>
              </li>
      
            @else
            <li class="nav-item">
                <a href="/login" class="nav-link"><i class="bi bi-box-arrow-right"></i> Login</a>
            </li>

            @endif
        </ul>
        </div>
    </div>
    </nav>