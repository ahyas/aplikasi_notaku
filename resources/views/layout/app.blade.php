<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Buku Kas</title>

    <!-- Fonts -->
    <link rel='icon' href="{{asset('public/image/logo_.png')}}" type='image/x-icon' sizes="16x16" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">

    <style type="text/css">
        table{
            font-size:15px;
        }
        table tr td:last-child {
            white-space: nowrap;
            width: 1px;
        }

        .modal-xl {
            max-width: 85% !important;
        }

        @media (min-width: 768px) {
  .animate {
    animation-duration: 0.3s;
    -webkit-animation-duration: 0.3s;
    animation-fill-mode: both;
    -webkit-animation-fill-mode: both;
  }
}

        @keyframes slideIn {
  0% {
    transform: translateY(1rem);
    opacity: 0;
  }

  100% {
    transform: translateY(0rem);
    opacity: 1;
  }

  0% {
    transform: translateY(1rem);
    opacity: 0;
  }
}

@-webkit-keyframes slideIn {
  0% {
    -webkit-transform: transform;
    -webkit-opacity: 0;
  }

  100% {
    -webkit-transform: translateY(0);
    -webkit-opacity: 1;
  }

  0% {
    -webkit-transform: translateY(1rem);
    -webkit-opacity: 0;
  }
}

.slideIn {
  -webkit-animation-name: slideIn;
  animation-name: slideIn;
}

	</style>
</head>
<body style="background-color:#f4f5f8">

    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-secondary">
                <a class="navbar-brand" href="#">
                <img src="{{asset('public/image/logo_.png')}}" width="35" height="35" style="margin:0" alt="">
                    <b>Buku Kas</b>
                </a>                

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    @if(Auth::user()->level==2)
                    <a class="nav-link" href="{{route('verifikator.dashboard')}}" id="navbarDropdown" role="button">
                        Home
                    </a>                
                    @elseif(Auth::user()->level==4)
                    <a class="nav-link" href="{{route('nota.dashboard')}}" id="navbarDropdown" role="button">
                        Home
                    </a>
                    @else
                    <a class="nav-link" href="{{route('ls.dashboard')}}" id="navbarDropdown" role="button">
                        Home
                    </a>
                    @endif

                    @if(Auth::user()->level==3)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdown" >
                                <a class="dropdown-item" href="{{route('mapping.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mapping akun dan anggaran</a>
                            </div>
                        </li>
                    @endif
                        <li class="nav-item dropdown">
                        
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Transaksi
                            </a>

                            <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdown">

                            @if(Auth::user()->level==4)
                                <a class="dropdown-item" href="{{route('transaksi.nota.catat_nota')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mencatat Nota pembelian</a>

                                <a class="dropdown-item" href="{{route('transaksi.drpp.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mencatat DRPP</a>
                            @endif

                            @if(Auth::user()->level==3)
                                <a class="dropdown-item" href="{{route('ls.catat_sp2d')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mencatat SP2D</a>
                            @endif

                            @if(Auth::user()->level==2)
                            
                                <a class="dropdown-item" href="{{route('verifikator.verifikasi_nota')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Verifikasi nota pembelian</a>

                                <a class="dropdown-item" href="{{route('verifikasi_ls.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Verifikasi LS</a>

                                <a class="dropdown-item" href="{{route('verifikasi_drpp.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Verifikasi DRPP</a>
                            @endif

                            </div>
                            
                        </li>
                        
                        @if(Auth::user()->level==4)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Upload
                            </a>

                            <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdown">
                                <a  class="dropdown-item" href="{{route('upload.upload_data_dukung')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Upload data dukung</a>

                            </div>
                        </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Laporan
                            </a>

                            <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdown">
                                <a  class="dropdown-item" href="{{route('laporan.rekap_akun')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Daftar Belanja Per Akun</a>

                                @if(Auth::user()->level==4 || Auth::user()->level==2)
                                <a  class="dropdown-item" href="{{route('laporan_gup.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Daftar Belanja GUP</a>
                                @endif

                                @if(Auth::user()->level==3 || Auth::user()->level==2)
                                <a  class="dropdown-item" href="{{route('laporan_sp2d.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/>  Daftar Belanja LS</a>
                                @endif

                            </div>
                            
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Referensi
                            </a>

                            <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{asset('public/rkk/rkk_dipa01.pdf')}}" target="_blank"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Rincian Kertas Kerja</a>

                            </div>
                            
                        </li>
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if(Auth::user()->level==2)
                                <img src="{{asset('public/image/eddyw.jpg')}}" width="30" height="30" class="rounded-circle" style="border:1px solid white"/> {{ Auth::user()->name }}
                                @elseif(Auth::user()->level==3)
                                <img src="{{asset('public/image/ahyasw.jpg')}}" width="30" height="30" class="rounded-circle" style="border:1px solid white"/> {{ Auth::user()->name }}
                                @elseif(Auth::user()->level==4)
                                <img src="{{asset('public/image/myamin.jpg')}}" width="30" height="30" class="rounded-circle" style="border:1px solid white"/> {{ Auth::user()->name }}
                                @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        
        <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <script src="//cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js" integrity="sha512-5m2r+g00HDHnhXQDbRLAfZBwPpPCaK+wPLV6lm8VQ+09ilGdHfXV7IVyKPkLOTfi4vTTUVJnz7ELs7cA87/GMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @stack('scripts')
</body>
</html>
