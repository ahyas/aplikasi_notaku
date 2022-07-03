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
                                <div style="float:left"><img src="{{asset('public/image/up.png')}}" style=" display: block;
   margin-right: 20px; width:80px"/></div>  
                                    <h5 class="card-title">Uang Persediaan</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:20px">30,000,000.00</div></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-white bg-success">
                                <div class="card-body">
                                <div style="float:left"><img src="{{asset('public/image/pengeluaran.png')}}" style=" display: block;
   margin-right: 20px; width:80px"/></div>
                                    <h5 class="card-title">Pengeluaran</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:20px" id="pengeluaran"></div></p>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-white bg-danger">
                                <div class="card-body">
                                <div style="float:left"><img src="{{asset('public/image/saldo.png')}}" style=" display: block;
   margin-right: 20px; width:80px"/></div>
                                    <h5 class="card-title">Saldo</h5>
                                    <p class="card-text"><div style="font-weight:bold; font-size:20px" id="saldo"></div></p>
                                </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5 style="font-weight:bold">Realisasi anggaran</h5>
                        
                            <div class="row">
                                <div class="col-5">
                                    <table id="tb_sub_komponen" class="table table-striped tb_sub_komponen" style="font-size:12px">
                                        <thead>    						
                                            <th>Sub komponen</th>
                                            <th style="text-align:right">Pagu</th>
                                            <th style="text-align:right">Realisasi</th>
                                            <th style="text-align:right">Saldo</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-7">
                                    <p>Realisasi sub komponen</p>
                                    <canvas id="myChart"></canvas>
                                    <br>
                                    <p>Realisasi DIPA</p>
                                    <div style="width:60%">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>

                        <h5 style="font-weight:bold">Daftar revolving GUP</h5>
                        <table id="tb_gup" class="table display table-striped tb_gup" style="width:70%">
                        <thead>    						
                            <th>No DRPP</th>
                            <th style="text-align:right">Total</th>
                        </thead>
						<tbody></tbody>
				        </table>

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
    var tb_sub_komponen = [];
    var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;

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
                tb_sub_komponen[c] = {sub_komponen: data.table_sub_komponen[c].nama_komponen, realisasi_sub_komponen :  sub_komponen[c]}
                var prosentase_realisasi = numFormat((sub_komponen[c]/data.table_sub_komponen[c].pagu)*100);
                console.log(prosentase_realisasi)
                var rows = "<tr>"  
                            + "<td class='yourTableTh'>" + data.table_sub_komponen[c].kode+" - "+data.table_sub_komponen[c].nama_komponen + "</td>"  
                            + "<td class='yourTableTh' align='right'>" + numFormat(data.table_sub_komponen[c].pagu) + "</td>"
                            + "<td class='yourTableTh' align='right' width='150px'>" + numFormat(sub_komponen[c]) +"<br><div class='progress'><div class='progress-bar bg-success' role='progressbar' style='width: "+prosentase_realisasi+"%' aria-valuemin='0' aria-valuemax='100'></div><div class='progress-bar bg-secondary' role='progressbar' style='width: '"+Number(100-prosentase_realisasi)+"'% aria-valuemin='0' aria-valuemax='100'></div></div> <b><span>("+ prosentase_realisasi + " %)</span></b></td>"
                            + "<td class='yourTableTh' align='right'>" + numFormat(Number(data.table_sub_komponen[c].pagu - sub_komponen[c])) + "</td>"    
                            + "</tr>";  

                $('#tb_sub_komponen tbody').append(rows);  
            }

            console.log(tb_sub_komponen)   

            const myChart = new Chart(ctx, {
                type: 'bar',
                    data: {
                        datasets: [{
                            barThickness: 20,
                            maxBarThickness: 20,
                            minBarLength: 10,
                            label: 'Realisasi Sub Komponen',
                            data: newObj,
                            backgroundColor: [
                          
                            'rgb(54, 162, 235)',
                            
                            ]
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
                    'Saldo',
                    'Realisasi',
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [data.saldo, data.total_realisasi],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                    hoverOffset: 4
                }]
                },
                    
            });
        }
    });

});
</script>
@endpush