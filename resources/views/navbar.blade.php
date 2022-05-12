<nav class="navbar" style="background-color: #006634;  min-height: 120px; border-bottom:5px solid #fdce50">
    
        <a class="navbar-brand" href="#"><img src="{{asset('public/image/logo.png')}}" style="width:65px; margin-right:0px;"/></a><div style="padding-left:100px; color:white; padding-top:25px;"><span style=" font-size:25px; font-weight:bold;"><b>MAHKAMAH AGUNG REPUBLIK INDONESIA</b></span><br><span style="font-weight:bold; font-size:20px;">PENGADILAN AGAMA KAIMANA</span></div>

        <ul class="nav navbar-nav navbar-right">      
            @if (Route::has('login'))
                <div class="top-right links" style="padding-top:35px;">
                    @auth
                        <a href="{{ route('dashboard.index') }}" style="color:#ddf4e8; font-size:15px">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="color:#ddf4e8; font-size:15px">Login</a>

                        @if (Route::has('register'))
                            <!--<a href="{{ route('register') }}">Register</a>-->
                        @endif
                    @endauth
                </div>
            @endif     
        </ul>
    </nav>