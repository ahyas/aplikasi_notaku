<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

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

	</style>
</head>
<body>

    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-secondary">
                <a class="navbar-brand" href="#">
                    <b>Notaku</b>
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
                            
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" >
                                <a class="dropdown-item" href="{{route('mapping.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mapping akun dan anggaran</a>
                            </div>
                        </li>
                    @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Transaksi
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            @if(Auth::user()->level==4)
                                <a class="dropdown-item" href="{{route('transaksi.nota.catat_nota')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mencatat Nota pembelian</a>

                                <a class="dropdown-item" href="{{route('transaksi.drpp.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mencatat DRPP</a>
                            @endif

                            @if(Auth::user()->level==3)
                                <a class="dropdown-item" href="{{route('ls.catat_sp2d')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mencatat SP2D</a>
                            @endif

                            @if(Auth::user()->level==2)
                                <a class="dropdown-item" href="{{route('verifikator.verifikasi_nota')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Verifikasi nota pembelian</a>

                                <a class="dropdown-item" ><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Verifikasi LS</a>

                                <a class="dropdown-item" href="{{route('verifikasi_drpp.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Verifikasi DRPP</a>
                            @endif

                            </div>
                            
                        </li>
                        
                        @if(Auth::user()->level==3)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Upload
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a  class="dropdown-item" href="{{route('upload.upload_data_dukung')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Upload data dukung</a>

                            </div>
                        </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Laporan
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a  class="dropdown-item" href="{{route('laporan.rekap_akun')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Daftar Belanja Per Akun</a>

                                @if(Auth::user()->level==4 || Auth::user()->level==2)
                                <a  class="dropdown-item" href="{{route('laporan_gup.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Daftar Belanja GUP</a>
                                @endif

                                @if(Auth::user()->level==3 || Auth::user()->level==2)
                                <a  class="dropdown-item" href="{{route('laporan_sp2d.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/>  Daftar Belanja LS</a>
                                @endif

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
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script src="//cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>
        @stack('scripts')
</body>
</html>
