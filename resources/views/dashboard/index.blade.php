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
                        <h5>Realisasi anggaran</h5>
                        <div style="width:70%">
                            <canvas id="myChart"></canvas>
                        </div>
                        <br>
                        <h5>Daftar revolving GUP</h5>
                        <table id="tb_gup" class="table display table-striped tb_gup" style="width:70%">
                        <thead>    						
                            <th>No DRPP</th>
                            <th style="text-align:right">Total</th>
                        </thead>
						<tbody></tbody>
				        </table>
                        <br>
                        <h5>Kondisi kas saat ini</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Uang Persediaan</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:20px">30,000,000.00</div></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Pengeluaran</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:20px" id="pengeluaran"></div></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-white bg-danger">
                                <div class="card-body">
                                    <h5 class="card-title">Saldo</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:20px" id="saldo"></div></p>
                                </div>
                                </div>
                            </div>
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
    var newObj = {};
    $.ajax({
        url:"{{route('dashboard.chart.laporan_1')}}",
        type:"GET",
        dataType:"JSON",
        success:function(data){

            for(let c = 0; c < data.table_sub_komponen.length; c++){
                //console.log(data.table_sub_komponen[c].id+" "+data.table_sub_komponen[c].nama_komponen);
                
                let sum_realisasi_akun = 0;
                for(let a = 0; a < data.merge_table.length; a++){
                    
                    if(data.merge_table[a].id_sub_komponen == data.table_sub_komponen[c].id){

                        sum_realisasi_akun+= Number(data.merge_table[a].realisasi_akun);
                        
                    }
                }

                //console.log(data.table_sub_komponen[c].nama_komponen+" "+sum_realisasi_akun);
                sub_komponen.push(sum_realisasi_akun);                
               
                newObj[data.table_sub_komponen[c].nama_komponen] = sub_komponen[c];
                
            }

            console.log(newObj)   

            const myChart = new Chart(ctx, {
                type: 'bar',
                    data: {
                        datasets: [{
                            label: 'Realisasi anggaran',
                            data: newObj,
                            backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    
            });

        }
    });

    $("#tb_gup").DataTable({
        ajax:"{{route('laporan_gup.list_gup')}}",
        processing:false,
        searching:false,
        serverside:false,
        scrollY:"300px",
        paging:false,
        columns:[
            {data:"no_drpp", 
                mRender:function(data, type, full){
                    if(full["no_drpp"]=="" || full["no_drpp"]==null){
                        return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                    }else{
                        return"<span>"+data+"</span>";    
                    }
                }
            },
            {data:"total", className:'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
        ]
    });

    $.ajax({
        url:"{{route('dashboard.chart.kondisi_kas')}}",
        type:"GET",
        dataType:"JSON",
        success:function(data){
            var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;
            if(data.nota_belum_drpp == 0){
                let jumlah_pengeluaran_terakhir = data.table.jumlah;
                document.getElementById("pengeluaran").innerHTML = numFormat(jumlah_pengeluaran_terakhir);
                let saldo = Number(30000000 - jumlah_pengeluaran_terakhir);
                document.getElementById("saldo").innerHTML = numFormat(saldo);
            }else{
                let total_pengeluaran = data.table;
                document.getElementById("pengeluaran").innerHTML = numFormat(total_pengeluaran);
                let saldo = Number(30000000 - total_pengeluaran);
                document.getElementById("saldo").innerHTML = numFormat(saldo);
            }
        }
    })

});
</script>
@endpush