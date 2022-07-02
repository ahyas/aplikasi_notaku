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
                        @if(Auth::user()->level == 2)
                            @if($jumlah_nota_masuk > 0)
                            <div class="alert alert-danger" role="alert">
                                Anda memiliki <span class="badge rounded-pill bg-danger" style="color:white; font-size:15px;">
                                    {{$jumlah_nota_masuk}}
                                <span class="visually-hidden">nota</span>
                                </span> yang belum di verifikasi. <a href="{{route('verifikator.verifikasi_nota')}}" class="alert-link"> Verifikasi sekarang!</a> 
                            </div>
                            @endif

                            @if($jumlah_sp2d_masuk > 0)
                            <div class="alert alert-danger" role="alert">
                                Anda memiliki <span class="badge rounded-pill bg-danger" style="color:white; font-size:15px;">
                                    {{$jumlah_sp2d_masuk}}
                                <span class="visually-hidden">SP2D</span>
                                </span> yang belum di verifikasi. <a href="{{route('verifikasi_ls.index')}}" class="alert-link"> Verifikasi sekarang!</a> 
                            </div>
                            @endif

                            @if($jumlah_drpp_masuk > 0)
                            <div class="alert alert-danger" role="alert">
                                Anda memiliki <span class="badge rounded-pill bg-danger" style="color:white; font-size:15px;">
                                    {{$jumlah_drpp_masuk}}
                                <span class="visually-hidden">DRPP</span>
                                </span> yang belum di verifikasi. <a href="{{route('verifikasi_drpp.index')}}" class="alert-link"> Verifikasi sekarang!</a> 
                            </div>
                            @endif

                        @endif
                        <div style="width:400px">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/JavaScript">
$(document).ready(function(){

    const ctx = document.getElementById('myChart').getContext('2d');
    var sub_komponen = [];
    $.ajax({
        url:"{{route('dashboard.chart.laporan_1')}}",
        type:"GET",
        dataType:"JSON",
        success:function(data){
            console.log(data.tb_sp2d);
            
            for(let a = 0; a < data.baris; a++){
                
                sub_komponen.push(data.table[a].nama_komponen);
            }

            const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [data.table],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                    }]
                }
            });
        }
    });

});
</script>
@endpush