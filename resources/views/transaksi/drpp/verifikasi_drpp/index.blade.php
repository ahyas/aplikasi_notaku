@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h5 style="font-weight:bold; margin-top:50px">Verifikasi DRPP</h5>
            <div class="card">
                <div class="card-header">Daftar DRPP</div>
                <div class="card-body">
                    <table id="tb_gup" class="table display table-striped tb_gup" style="width:100%; ">
                        <thead>     						
                            <th>Tanggal</th>
                            <th>No. DRPP</th>
                            <th style="text-align:right">Total</th>
                            <th>Action</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Daftar nota</div>
                <div class="card-body">
                
                <input type="hidden" class="id_drpp" />
                    <table id="tb_nota" class="table display table-striped tb_nota" style="width:100%;">
                        <thead>  
                            <th>Tanggal</th>                                                                                 
                            <th>Akun</th>      
                            <th></th>
                            <th>COA</th>                                                  				
                            <th>Deskripsi</th>
                            <th style="text-align:right">Nilai</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button class="btn btn-primary btn-sm btn-block" id="setuju_drpp" disabled="true" style="margin-top:20px">Setuju</button>
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
                <div class="col-md-12 mb-3">
                    <table id="tb_daftar_coa" class="table display tb_daftar_coa" style="width:100%; ">
                        <thead>
                            <th>Nama COA</th>
                            <th>Nominal</th>
                            <th>Deskripsi</th>  				
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

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $(".tb_gup").DataTable({
        ajax        :"{{route('verifikasi_drpp.list_gup')}}",
        searching   :false,
        serverside  :false,
        paging      :false,
        select:true,
        columns     :[
            {data:"tgl", width:"80px"},
            {data:"no_drpp",
                render:function(data, type, full){
                    if(data == ""){
                        return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                    }else{
                        return"<span>"+data+"</span>";
                    }
                }
            },
            {data:"total", className:'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"id",
                mRender:function(data){
                    return"<button class='btn btn-primary btn-sm detail' data-id_drpp='"+data+"'>Detail</button>";
                }
            }
        ]
    });

    $("body").on("click",".detail",function(){
        let id_drpp = $(this).data("id_drpp");
        $(".id_drpp").val(id_drpp);

        document.getElementById("setuju_drpp").disabled = false;
        $(".tb_nota").DataTable().clear().destroy();
        $(".tb_nota").DataTable({
            ajax    :{url:"{{route('verifikasi_drpp.list_nota')}}", type:"GET", data:{id_drpp:id_drpp}},
            serverside:false,
            paging:false,
            scrollY:"250px",
            columns:[
                {data:"tanggal", width: "80px"},
                {data:"id_akun"},
                {data:"nama_akun"},
                {data:"detail_coa"},
                {data:"deskripsi"},
                {data:"nominal", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:"dt-body-right"},
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='nota_pembelian' data-id_nota='"+data+"' data-file='"+full["file"]+"'>Nota</button>";
                    }
                }
            ]            
        });
    });

    $("body").on("click","#setuju_drpp", function(){
        let id_drpp = $(".id_drpp").val();
        console.log(id_drpp);
        if(confirm("Anda yakin ingin menyetujui DRPP ini?")){
            $.ajax({
                url:"{{route('verifikasi_drpp.setuju_drpp')}}",
                type:"GET",
                data:{id_drpp:id_drpp},
                success:function(data){
                    document.getElementById("setuju_drpp").disabled = true;
                    $(".tb_nota").DataTable().clear().destroy();
                    $(".tb_gup").DataTable().ajax.reload();
                }
            });
        }
    });

    $("body").on("click","#nota_pembelian",function(){
        let file = $(this).data("file");
        document.getElementById("data_dukung").src="../public/uploads/"+file;
        $(".modalPreview").modal("show");
    });

    
});
</script>
@endpush()