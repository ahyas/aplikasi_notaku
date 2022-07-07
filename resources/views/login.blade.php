<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel = "icon" href ="{{asset('public/image/logo_.png')}}" type = "image/x-icon">
</head>
<style type="text/css">


.form-control {
	
	background: #f2f2f2;
	box-shadow: none !important;
	border: transparent;
}
.form-control:focus {
	background: #e2e2e2;
}
.form-control, .btn {        
	border-radius: 2px;
}
.login-form {
    background-image: linear-gradient(#1fa067, #168c56);
    left:50%;
	width: 350px;
	position: absolute;
  top: 20%;
  -ms-transform: translateX(-50%);
  transform: translateX(-50%);
}

.login-form form {
	color: white;
	border-radius: 3px;
	
	box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.login-form .btn {        
	font-size: 16px;
	font-weight: bold;
	background: #3598dc;
	border: none;
	outline: none !important;
}
.login-form .btn:hover, .login-form .btn:focus {
	background: #2389cd;
}
.login-form a {
    
	color: #fff;
	text-decoration: underline;
}
.login-form a:hover {
	text-decoration: none;
}
.login-form form a {
	color: #7a7a7a;
	text-decoration: none;
}
.login-form form a:hover {
	text-decoration: underline;
}

</style>

<body style=" background-color: white;">

            <div class="login-form">  
            <img src="{{asset('public/image/logo_.png')}}" style=" display: block;
  margin-left: auto; margin-right: auto; margin-top:20px; margin-bottom:0; width:120px"/>       
                <form action="{{ route('login') }}" method="post">
                @csrf
                <h1 class="text-center" style="font-weight:bold; color:#fdce50; line-height:0">Buku Kas</h1>
                <h6 class="text-center" style="line-height:15px; line-height:25px;  padding-top:20px; color:#fdce50; font-weight:bold; padding-bottom:20px">Budaya Akuntabel Kinerja Anggaran 
       Satker</h6>
                    @if(session('errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Something it's wrong:
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for=""><strong>Username</strong></label>
                        <input type="text" name="email" id="email" value='' class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Password</strong></label>
                        <input type="password" id="password" name="password" value='' class="form-control" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Log In</button>

                </form>
                
            </div>

        
</body>
</html>
<script src="{{asset('public/adminlte/plugins/jquery/jquery.min.js')}}"></script>

<script type="text/javascript">

</script>