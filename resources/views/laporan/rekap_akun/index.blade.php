@extends('layout.app')

@section('content')
@if(Auth::user()->level==2 || Auth::user()->level==3)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Daftar Transaksi Akun</div>
                <div class="card-body">
                    <button class="btn btn-primary btn-sm cetak_laporan">Print</button>
                    <table id="tb_akun" class="table display tb_akun" style="width:100%; ">
                        <thead>
                            <th style="width:10px">No.</th>  				
                            <th style="font-weight:bold">ID Akun</th>
                            <th>Akun</th>
                            <th>jenis akun</th>
                            <th>Total transaksi</th>
                            <th>Pagu</th>
                            <th>Realisasi</th>
                            <th>Action</th>
                        </thead>
                            <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Detail akun dan rekap</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col-md-6 mb-4">
                    <table id="tb_daftar_coa" class="table display tb_daftar_coa" style="width:100%; ">
                        <thead>
                            <th style="width:200px">Nama COA</th>
                            <th>Pengeluaran</th>
                            <th>Pagu</th>
                            <th>Realisasi</th>
                            <th width="20px">Action</th>  				
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-6 mb-3">
                    <table id="tb_daftar_subcoa" class="table display tb_daftar_subcoa" style="width:100%; ">
                        <thead>
                            <th>No. SPBy</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Detail nota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <embed src= "" id="data_dukung" width= "100%" style="border:1px grey solid; height:700px">
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $("body").on("click",".cetak_laporan",function(){
        window.open("rekap_akun/print");
    });
    
    $("#tb_akun").DataTable({
        ajax:"{{route('laporan.rekap_akun.show_data')}}",
        serverside:true,
        paginate:false,
        processing:false,
        columns:[
            {data:"id_akun",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data:"id_akun"},
            {data:"nama_akun"},
            {data:"keterangan_akun"},
            {data:"total_nominal", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"pagu_akun", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"realisasi_akun", className: 'dt-body-left', render: $.fn.DataTable.render.number(',', '.', 2, ''),
                mRender:function(data){
                    return data+" % <br><div class='progress' style='background-color:red;'><div class='progress-bar' role='progressbar' style='width: "+data+"%;' aria-valuemin='0' aria-valuemax='100'></div></div>";
                }
            },
            {data:"id_akun",
                mRender:function(data, type, full){
                    if(full["jenis_akun"]==2 || full["jenis_akun"]==3 || full["jenis_akun"]==4){
                        return"<button class='btn btn-primary btn-sm' id='detail_akun' data-id_akun="+data+">Detail</button>";
                    }else{
                        return"<button class='btn btn-primary btn-sm' id='detail_akun' data-id_akun="+data+" disabled>Detail</button>";
                    }
                }
            }
        ]
    });

    $("body").on("click","#detail_akun",function(){
       
        let id_akun = $(this).data("id_akun");
            $(".modalDetail").modal("show");
            $("#tb_daftar_subcoa").DataTable().clear().destroy();
            $("#tb_daftar_coa").DataTable().clear().destroy();
            var table = $("#tb_daftar_coa").DataTable({
                ajax:"rekap_akun/"+id_akun+"/daftar_coa",
                paginate:false,
                searching:false,
                serverside:false,
                processing:false,
                columns:[
                    {data:"nama_coa"},
                    {data:"nominal", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                    {data:"pagu_kegiatan", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                    {data:"realisasi_kegiatan", className: 'dt-body-left',
                        mRender:function(data){
                            return data+"%<br><div class='progress' style='background-color:red;'><div class='progress-bar' role='progressbar' style='width: "+data+"%;' aria-valuemin='0' aria-valuemax='100'></div></div>";
                        }
                    },
                    {data:"id_akun", className: 'dt-body-right',
                        mRender:function(data,type,full){
                            return"<button class='btn btn-primary btn-sm' id='detail_coa' data-id_akun='"+data+"' data-id_coa='"+full['id_coa']+"'>Detail</button>";
                        }
                    },
                ]
            });
    });

    $("body").on("click","#detail_coa",function(){
        let id_coa = $(this).data("id_coa");
        console.log(id_coa);
            $("#tb_daftar_subcoa").DataTable().clear().destroy();
           var tb_subcoa =  $("#tb_daftar_subcoa").DataTable({
                ajax:{url:"{{route('laporan.rekap_akun.detail_coa')}}", type:"GET", data:{id_coa:id_coa}},
                ordering:false,
                paging:false,
                searching:false,
                serverSide:false,
                processing:false,
                columns:[
                    {data:"no_spby"},
                    {data:"deskripsi"},
                    {data:"nominal", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                ],
            });
    });

    $("body").on("click","#nota_pembelian", function(){
        let file = $(this).data("file");
        document.getElementById("data_dukung").src="../public/uploads/"+file;
        $(".modalPreview").modal("show");
    });

});

</script>
@endpush()