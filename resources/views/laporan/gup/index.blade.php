@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h5 style="font-weight:bold; margin-top:50px">Daftar belanja GUP</h5>
            <div class="card">
                <div class="card-header">DRPP</div>
                <div class="card-body">
                    
                    <table id="tb_gup" class="table display table-striped tb_gup" style="width:100%; ">
                        <thead>     						
                            <th>No. DRPP</th>
                            <th>Tgl. DRPP</th>
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
    <div class="row justify-content-center"">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Daftar nota</div>
                <div class="card-body">
                <div id="template"></div>
                    <table id="tb_nota" class="table display table-striped tb_nota" style="width:100%; ">
                        <thead>  
                            <th>Tanggal</th>  
                            <th>No. Kwitansi</th>
                            <th>No. SPBy</th>                                                                                   
                            <th>Akun</th>      
                            <th>COA</th>                                                  				
                            <th>Deskripsi</th>
                            <th style="text-align:right">Nilai</th>
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

<div class="modal fade modalLihatSPBY" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Lihat dokumen SPBy</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col" style="height:800px">
                    <embed src= "" id="file_spby" width= "100%" height= "100%" style="border:1px grey solid">
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade modalLihatKwitansi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Lihat dokumen Kwitansi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col" style="height:800px">
                    <embed src= "" id="file_kwitansi" width= "100%" height= "100%" style="border:1px grey solid">
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
        ajax        :"{{route('laporan_gup.list_gup')}}",
        searching   :false,
        serverside  :false,
        select: true,
        scrollY:"200px",
        paging      :false,
        columns     :[
            {data:"no_drpp"},
            {data:"tgl"},
            {data:"total", className:'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"no_drpp",
                mRender:function(data){
                    return"<button class='btn btn-primary btn-sm detail' data-no_drpp='"+data+"'>Detail</button>";
                }
            }
        ]
    });

    $("body").on("click",".detail",function(){
        let no_drpp = $(this).data("no_drpp");
        console.log(no_drpp);
        $(".tb_nota").DataTable().clear().destroy();
        $(".tb_nota").DataTable({
            ajax    :{url:"{{route('laporan_gup.list_nota')}}", type:"GET", data:{no_drpp:no_drpp}},
            serverside:false,
            paging:false,
            scrollY:"400px",
            columns:[
                {data:"tanggal", width: "80px"},
                {data:"no_kwitansi", width:"100px",
                    mRender:function(data, type, full){
                        if(full["no_kwitansi"]=="0" || full["no_kwitansi"]==null){
                            return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                        }else{
                            if(full["file_kwitansi"]=="0" || full["file_kwitansi"]==null){
                                return"<span>"+data+"</span>";    
                            }else{
                                return"<button class='btn btn-primary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_kwitansi' data-file_kwitansi='"+full["file_kwitansi"]+"'><b>"+data+"</b></button>";
                            }
                        }
                    }
                },
                {data:"no_spby",
                    mRender:function(data, type, full){
                        if(full["no_spby"]=="0" || full["no_spby"]==null){
                            return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                        }else{
                            if(full["file_spby"]=="0" || full["file_spby"]==null){
                                return"<span>"+data+"</span>";    
                            }else{
                                return"<button class='btn btn-primary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_spby' data-file_spby='"+full["file_spby"]+"'><b>"+data+"</b></button>";
                            }
                        }
                    }
                },
                {data:"id_akun", width:"250px",
                    render:function(data, type, full){
                        return'<span>'+data+' - '+full['nama_akun']+'</span>';
                    }
                },
                {data:"detail_coa", width:"250px"},
                {data:"deskripsi", width:"300px"},
                {data:"nominal", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:"dt-body-right"},
                {data:"id", width:"50px",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='nota_pembelian' data-id_nota='"+data+"' data-file='"+full["file"]+"'>Nota</button>";
                    }
                }
            ]            
        });
    });

    $("body").on("click","#lihat_spby",function(){
        console.log($(this).data("file_spby"));
        $(".modalLihatSPBY").modal("show");
        var file_spby = $(this).data("file_spby");
        document.getElementById("file_spby").src="public/uploads/spby/"+file_spby;
    });

    $("body").on("click","#lihat_kwitansi",function(){
        console.log($(this).data("file_kwitansi"));
        $(".modalLihatKwitansi").modal("show");
        var file_kwitansi = $(this).data("file_kwitansi");
        document.getElementById("file_kwitansi").src="public/uploads/kwitansi/"+file_kwitansi;
    });

    $("body").on("click","#nota_pembelian",function(){
        let file = $(this).data("file");
        document.getElementById("data_dukung").src="../public/uploads/"+file;
        $(".modalPreview").modal("show");
    });

    
});
</script>
@endpush()