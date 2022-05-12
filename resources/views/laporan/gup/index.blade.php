@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row">
    <div class="col-4">
            <div class="card">
                <div class="card-header">DRPP</div>
                <div class="card-body">
                    
                    <table id="tb_gup" class="table display tb_gup" style="width:100%; ">
                        <thead>     						
                            <th>No. DRPP</th>
                            <th>Tgl. DRPP</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card">
                <div class="card-header">Daftar nota</div>
                <div class="card-body">
                <div id="template"></div>
                    <table id="tb_nota" class="table display tb_nota" style="width:100%; ">
                        <thead>  
                            <th>No. SPBy</th>				
                            <th>Deskripsi</th>
                            <th>Nilai</th>
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

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $(".tb_gup").DataTable({
        ajax        :"{{route('laporan_gup.list_gup')}}",
        searching   :false,
        serverside  :false,
        paging      :false,
        columns     :[
            {data:"no_drpp"},
            {data:"tgl"},
            {data:"total", render: $.fn.DataTable.render.number(',', '.', 2, '')},
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
            columns:[
                {data:"no_spby"},
                {data:"deskripsi"},
                {data:"nominal", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:"dt-body-right"},
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='nota_pembelian' data-id_nota='"+data+"' data-file='"+full["file"]+"'>Nota pembelian</button>";
                    }
                }
            ]            
        });
    });

    $("body").on("click","#nota_pembelian",function(){
        let file = $(this).data("file");
        document.getElementById("data_dukung").src="../public/uploads/"+file;
        $(".modalPreview").modal("show");
    });

    
});
</script>
@endpush()