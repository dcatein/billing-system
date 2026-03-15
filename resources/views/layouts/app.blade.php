<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Billing Saas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"
    defer></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"
    defer></script>
</head>

<body>
  <!-- ******* Header ******* -->

  <header class="header fixed-top d-flex shadow-lg" id="header">
    {{-- <div class="d-flex align-items-center container-fluid justify-content-between justify-content-sm-start"> --}}
      <div class="row justify-content-between col-12">
        <div class="col-8">
            @hasanyrole('manager|admin')
                  <a href="{{ route('dashboard') }}">
                    <span class="text-white">Billing Saas</span>
                  </a>
                  <i class="bi bi-list toggle-sidebar-btn btn" data-bs-toggle="collapse" aria-expanded="false"
                    data-bs-target="#sidebar" role="button" aria-controls="#sidebar"></i>
            @endhasanyrole
        </div>

        <div class="col-2 offset-md-2 p-2 ">

          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
              data-bs-toggle="dropdown" aria-expanded="false">
              {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Edit</a></li>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <li>
                  <button class="btn btn-link" type="submit">Logout</button>
                </li>
              </form>


            </ul>
          </div>

        </div>



      </div>
  </header>
  <!-- ******* Fim do Header ****** -->





  <main class="main" id="top">
    @hasanyrole('manager|admin')
        @include('layouts.sidebar')
    @endhasanyrole
    <div class="content">

      @include('layouts.topbar')

      <div class="container-fluid py-4">

        @yield('content')

      </div>

    </div>

  </main>
    @include('components.success-modal')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        @endif
    });
</script>

</body>

</html>
