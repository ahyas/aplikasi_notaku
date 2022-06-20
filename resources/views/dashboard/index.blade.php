@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-10">
    <h5 style="font-weight:bold; margin-top:50px">Dashboard</h5>
            <div class="card">
                <div class="card-header">Home</div>
                <div class="card-body">
                    <p>Selamat datang <b>{{Auth::user()->name}}</b></p>
                </div>
                </div>
            </div>
    </div>
    </div>
</div>
@endsection