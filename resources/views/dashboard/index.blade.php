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
                        <h5 style="font-weight:bold">Kondisi kas saat ini</h5>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card text-white bg-primary">
                                <div class="card-body">
                                <div style="float:left"><img src="{{asset('public/image/wallet.png')}}" style=" display: block;
   margin-right: 20px; width:80px"/></div>  
                                    <h5 class="card-title" style="padding-bottom:10px">Pagu Uang Persediaan</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:30px; line-height:0">30,000,000.00</div></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-white bg-success">
                                <div class="card-body">
                                <div style="float:left"><img src="{{asset('public/image/logo3.png')}}" style=" display: block;
   margin-right: 20px; width:80px"/></div>
                                    <h5 class="card-title" style="padding-bottom:10px">Total pengeluaran berjalan</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:30px; line-height:0" id="pengeluaran"></div></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-white bg-danger">
                                <div class="card-body">
                                <div style="float:left"><img src="{{asset('public/image/logo4.png')}}" style=" display: block;
   margin-right: 20px; width:80px"/></div>
                                    <h5 class="card-title" style="padding-bottom:10px">Saldo Uang Persediaan</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:30px; line-height:0" id="saldo"></div></p>
                                </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5 style="font-weight:bold">Realisasi anggaran <span class="badge rounded-pill bg-primary" style="color:white; font-size:15px;"><a href="{{route('laporan.rekap_akun')}}" target="_blank" role="button" style="color:white; text-decoration:none">Detail</a></span></h5>
                        
                            <div class="row">
                                <div class="col-5">
                                    <div style="height:500px; overflow:auto;">
                                        <table id="tb_sub_komponen" class="table table-striped tb_sub_komponen" style="font-size:13px; color:#575656; width:100%">
                                            <thead>    						
                                                <th>Sub komponen</th>
                                                <th style="text-align:right">Pagu</th>
                                                <th style="text-align:right">Realisasi</th>
                                                <th style="text-align:right;">Prosentase</th>
                                                <th style="text-align:right">Saldo</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <h5 style="font-weight:bold">Daftar revolving GUP <span class="badge rounded-pill bg-primary" style="color:white; font-size:15px;"><a href="{{route('laporan_gup.index')}}" target="_blank" role="button" style="color:white; text-decoration:none">Detail</a></span></h5>
                                    <table id="tb_gup" class="table table-striped tb_gup" style="width:70%; color:#575656; font-size:13px">
                                        <thead>    						
                                            <th>No DRPP</th>
                                            <th style="text-align:right">Pagu UP</th>
                                            <th style="text-align:right">Pengeluaran</th>
                                            <th style="text-align:right">Saldo UP</th>
                                            <th style="text-align:right">Prosentase</th>
                                        </thead>
                                    <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-7">
                                    
                                        <canvas id="myChart"></canvas>
                                    
                                    <br>
                                    
                                    <div style="width:50%;" >
                                        <canvas id="myChart2"></canvas>
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
    const chart2 = document.getElementById('myChart2').getContext('2d');

    var sub_komponen = [];
    var newObj = {};
    var pagu = {};
    var saldo = {};
    var tb_sub_komponen = [];
    var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;

    $.ajax({
        url:"{{route('dashboard.chart.laporan_1')}}",
        type:"GET",
        dataType:"JSON",
        success:function(data){
            var grand_total = 0;
            var grand_total_realisasi = 0;
            var grand_total_saldo = 0;

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
                pagu[data.table_sub_komponen[c].nama_komponen] = data.table_sub_komponen[c].pagu;
                saldo[data.table_sub_komponen[c].nama_komponen] = Number(data.table_sub_komponen[c].pagu - sub_komponen[c]);

                tb_sub_komponen[c] = {sub_komponen: data.table_sub_komponen[c].nama_komponen, realisasi_sub_komponen :  sub_komponen[c]}
                var prosentase_realisasi = numFormat((sub_komponen[c]/data.table_sub_komponen[c].pagu)*100);
                var total_saldo = Number(data.table_sub_komponen[c].pagu - sub_komponen[c]);
                console.log(prosentase_realisasi)
                var rows = "<tr>"  
                            + "<td>" + data.table_sub_komponen[c].kode+" - "+data.table_sub_komponen[c].nama_komponen + "</td>"  
                            + "<td align='right'>" + numFormat(data.table_sub_komponen[c].pagu) + "</td>"
                            + "<td align='right'><span>" + numFormat(sub_komponen[c]) + "</span><div class='progress'><div class='progress-bar bg-success' role='progressbar' style='width: "+prosentase_realisasi+"%' aria-valuemin='0' aria-valuemax='100'></div><div class='progress-bar bg-primary' role='progressbar' style='width: '"+Number(100-prosentase_realisasi)+"'% aria-valuemin='0' aria-valuemax='100'></div></div></td>"
                            + "<td align='right'><b> ("+ prosentase_realisasi + " %)</b> </td>"
                            + "<td align='right'>" + numFormat(total_saldo) + "</td>"    
                            + "</tr>";  

                $('#tb_sub_komponen tbody').append(rows);  

                grand_total+=Number(data.table_sub_komponen[c].pagu);
                grand_total_realisasi+=sub_komponen[c];
                grand_total_saldo+=total_saldo;
            }

            var end_row = "<tr style='font-weight:bold'>"
                            + "<td align='left'>TOTAL:</td>"  
                            + "<td align='right'>" + numFormat(grand_total) + "</td>"
                            + "<td align='right'>" + numFormat(grand_total_realisasi) + "</td>"
                            + "<td align='right'></td>"
                            + "<td align='right'>" + numFormat(grand_total_saldo) + "</td>"      
                            + "</tr>";  

                $('#tb_sub_komponen tbody').append(end_row);  

            const myChart = new Chart(ctx, {
                type: 'bar',
                    data: {
                        datasets: 
                        [
                            {
                                barThickness: 10,
                                maxBarThickness: 20,
                                minBarLength: 10,
                                label: 'Realisasi',
                                data: newObj,
                                backgroundColor: [ 
                                    'rgb(67, 184, 31)',
                                ]
                            },
                            {
                                barThickness: 10,
                                maxBarThickness: 20,
                                minBarLength: 10,
                                label: 'Pagu ',
                                data: pagu,
                                backgroundColor: [ 
                                    'rgb(54, 162, 235)',
                                ]
                            },
                            {
                                barThickness: 10,
                                maxBarThickness: 20,
                                minBarLength: 10,
                                label: 'Saldo ',
                                data: saldo,
                                backgroundColor: [ 
                                    'rgb(255, 99, 132)',
                                ]
                            },

                        ]
                    },
                    options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Realisasi sub komponen'
                        }
                        },
                        scales: {
                        y: {
                            min: 1000000,
                            
                            
                        }
                    }
                },
                    
            });

        }
    });

    $("#tb_gup").DataTable({
        ajax:"{{route('laporan_gup.list_gup')}}",
        processing:false,
        searching:false,
        ordering:false,
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
            {data:"total",className:'dt-body-right',
                render:function(data, type, full){
                    return numFormat(30000000);
                }
            },
            {data:"total", className:'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"total", className:'dt-body-right',
                render:function(data){
                    return numFormat(Number(30000000 - data));
                }
            },
            {data:"total", className:'dt-body-right',
                render:function(data, type, full){
                    let prosentase_revolving = Number((data / 30000000)*100);
                    return numFormat(prosentase_revolving)+" %";
                }
            }
        ]
    });

    $.ajax({
        url:"{{route('dashboard.chart.kondisi_kas')}}",
        type:"GET",
        dataType:"JSON",
        success:function(data){
                
                let total_pengeluaran = data.table;
                let prosentase_pengeluaran = Number(total_pengeluaran / 30000000)*100;
                document.getElementById("pengeluaran").innerHTML = numFormat(total_pengeluaran)+" <span style='font-size:25px'>("+numFormat(prosentase_pengeluaran)+" %)</span>";
                let saldo = Number(30000000 - total_pengeluaran);
                document.getElementById("saldo").innerHTML = numFormat(saldo);
            
        }
    });

    $.ajax({
        url:"{{route('dashboard.chart.laporan_2')}}",
        type:"GET",
        dataType:"JSON",
        success:function(data){
            
            console.log(data.total_realisasi);

            const myChart2 = new Chart(chart2, {
                type: 'doughnut',
                data: {
                    labels: [
                        'Saldo', 'Realisasi'
                    ],
                    datasets: [
                    {
                        label: 'Pagu2',
                        data: [data.saldo, data.total_realisasi],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(67, 184, 31)',
                        ],
                        hoverOffset: 4
                    }
                ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Realisasi DIPA'
                        },
                    legend: {
                        position: 'top',
                        }
                    }
                },
                    
            });
        }
    });

});
</script>
@endpush