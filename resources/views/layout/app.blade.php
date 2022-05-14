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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                @if(Auth::user()->level==2)
                <a class="navbar-brand" href="{{ url('/ppk') }}">
                    <b>Notaku</b>
                </a>                
                @else
                <a class="navbar-brand" href="{{ url('/bendahara') }}">
                    <b>Notaku</b>
                </a>
                @endif

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a style="color:#0a4293; font-size:14px; font-weight:600;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color:#fafafa; box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
                                <a style="color:#0a4293; font-size:14px;"  class="dropdown-item" href="{{route('mapping.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Mapping akun dan anggaran</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a style="color:#0a4293; font-size:14px; font-weight:600;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Laporan
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color:#fafafa; box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
                                <a style="color:#0a4293; font-size:14px;"  class="dropdown-item" href="{{route('laporan.rekap_akun')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Rekap per akun</a>
                                <a style="color:#0a4293; font-size:14px;"  class="dropdown-item" href="{{route('laporan_gup.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> GUP</a>

                            </div>
                            
                        </li>
                        @if(Auth::user()->level==3)
                        <li class="nav-item dropdown">
                            <a style="color:#0a4293; font-size:14px; font-weight:600;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Transaksi
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color:#fafafa; box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
                                <a style="color:#0a4293; font-size:14px;" class="dropdown-item" href="{{route('transaksi.drpp.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Catat DRPP</a>

                                <a style="color:#0a4293; font-size:14px;" class="dropdown-item" href="{{route('transaksi.sp2d.index')}}"><img src="https://img.icons8.com/fluent/25/000000/new-product.png"/> Catat SP2D</a>
                            </div>
                            
                        </li>
                        @endif
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
