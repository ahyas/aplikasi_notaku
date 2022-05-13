@extends('layout.app')

@section('content')
<style type="text/css">
td.details-control {
    background: url('public/icons/pluss.png') no-repeat center center;
    cursor: pointer;
    vertical-align: top;
}

tr.shown td.details-control {
    background: url('public/icons/minuss.jpg') no-repeat center center;
    vertical-align: top;
}

div.slider {
    display: none;
}
</style>
@if(Auth::user()->level==3)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Daftar nota belanja</div>

                <div class="card-body">
                
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
                @endif
        
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col">
                        <br>
                        <form action="{{route('bendahara.upload')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            
                                <label for="name" class="control-label"><b>Upload nota pembelian/kwitansi</b></label>
                                <input type="file" name="file" class="form-control" id="file">
                            
                            <div class="mt-3">
                                <button style="display: inline-block; float:left; margin-bottom:25px" type="submit" class="btn btn-primary btn-sm" id="btnUploadSubmit" value="create" disabled="true">Upload</button>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-success btn-sm stretched-link reload" style="float:right; margin-left:10px">Reload</a><br>
                        <label for="name" class="control-label"><b>Total pengeluaran</b></label>
                        <input type="text" class="form-control input-lg total" name="total" id="total" value=<?php echo number_format("$total",2,",","."); ?> readOnly="true" style="text-align:right; font-weight:bold;">
                    </div>
                </div>
                
                    <table id="tb_nota" class="table display tb_nota" style="width:100%;">
                        <thead>
                            <th></th>
                            <th style="width:80px">Tanggal</th>
                            <th style="width:150px">No. Kwitansi</th>
                            <th style="width:150px">No. SPBy</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th style="70px">Jenis</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Detail nota - Tambah akun</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <embed src= "" id="data_dukung" width= "100%" height= "100%" style="border:1px grey solid">
                </div>
                <div class="col-md-4 mb-3">
                    
                <form id="formAkun" class="form-horizontal">
                {{csrf_field()}} {{method_field('POST')}}
                <input type="hidden" id="id_nota" name="id_nota">

                <label for="name" class="col-sm-12 control-label"><b>Akun</b></label>
                <div class="form-group">
                    <div class="col-sm-12">
                        @if(Auth::user()->level==3)
                        <?php $value="true"; ?>
                        @else
                        <?php $value="false"; ?>
                        @endif
                        <select class="form-control" id="akun" name="akun" disabled="{{$value}}">
                            <option value="0">Pilih akun</option>
                            @foreach($table as $row)
                            <option value="{{$row->id_akun}}">{{$row->id_akun}} - {{$row->akun}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-12 control-label"><b>Detail COA</b></label>
                    <div class="col-sm-12">
                        <select class="form-control" id="detail_coa" name="detail_coa" disabled="{{$value}}">
                            <option value="0">Pilih detail COA</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" id="desc_subcoa" name="desc_subcoa">

                <div class="form-group">
                    <div class="col-sm-12">
                    <label for="name" class="control-label"><b>Sub COA</b></label>
                        <select class="form-control" id="sub_coa" name="sub_coa" disabled="true">
                            <option value="0" selected>Pilih Sub COA</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-12 control-label"><b>Deskripsi</b></label>
                    <div class="col-sm-12">
                        
                        <textarea class="form-control" name="deskripsi" id="deskripsi" disabled="{{$value}}" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-12 control-label"><b>Nominal (Bruto)</b></label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="nominal" id="nominal" readOnly="{{$value}}" style="text-align:right">
                    </div>
                </div>

                <input type="hidden" id="cbayar" name="cbayar">

                <div class="form-group">
                <label for="name" class="col-sm-12 control-label"><b>Cara pembayaran</b></label>
                <div class="col-sm-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="tunai" name="cara_bayar" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="tunai">Tunai</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="non_tunai" name="cara_bayar" class="custom-control-input" value="2">
                        <label class="custom-control-label" for="non_tunai">Non tunai</label>
                    </div>
                </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name" class="col-sm-12 control-label"><b>Status</b></label>
                        <select class="form-control" id="input_sakti" name="input_sakti" disabled="{{$value}}">
                            <option value="0">Pilih</option>
                            <option value="1">Input SAKTI</option>
                            <option value="2">Batal Input SAKTI</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                    <label for="name" class="col-sm-12 control-label"><b>Nomor SPBy</b></label>
                        <input type="text" class="form-control" name="no_spby" id="no_spby" readOnly="{{$value}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        
                    </div>
                    <div class="form-group col-md-8">
                    <label for="name" class="col-sm-12 control-label"><b>Nomor Kwitansi</b></label>
                        <input type="text" class="form-control" name="no_kwitansi" id="no_kwitansi">
                    </div>
                </div>
                <br>
                
                <div class="modal-footer">
                    <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="update" value="create">Update</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="modalUploadSPBY"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="">Upload dokumen SPBy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('bendahara.upload_spby')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
                    
					<div class="form-group">
                        <input type="hidden" name="id_nota2" id="id_nota2">
						<label for="name" class="col-sm-3 control-label"><b>File SPBy</b></label>
						<div class="col-sm-12">
                            <input type="file" name="file_spby" class="form-control">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm">Submit</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalUploadKwitansi"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="">Upload dokumen Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('bendahara.upload_kwitansi')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
                    
					<div class="form-group">
                        <input type="hidden" name="id_nota3" id="id_nota3">
						<label for="name" class="col-sm-5 control-label"><b>File Kwitansi</b></label>
						<div class="col-sm-12">
                            <input type="file" name="file_kwitansi" class="form-control">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm">Submit</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
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
@endif
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $("body").on("change","#file",function(){
        document.getElementById("btnUploadSubmit").disabled=false;
    });

    var tb_nota = $(".tb_nota").DataTable({
        ajax: "{{route('bendahara.show_data')}}",
        serverside:false,
        ordering:false,
        searching: true,
        lengthChange: false,
        oLanguage: {
            sLoadingRecords: '<img src="{{asset('public/loading_animation/ajax-loader.gif')}}">'
  		},
        columns:[
            {
                "className" :      'details-control',
                "orderable" :      false,
                "data"      :           null,
                "defaultContent": ''
            },
            {data:"tanggal"},
            {data:"no_kwitansi",
                mRender:function(data, type, full){
                    if(full["file_kwitansi"]=="0"){
                        return"<span>"+data+"</span>";
                    }else{
                        return"<button class='btn btn-primary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_kwitansi' data-file_kwitansi='"+full["file_kwitansi"]+"'><b>"+data+"</b></button>";
                    }
                }
            },
            {data:"no_spby",
                mRender:function(data, type, full){
                    if(full["file_spby"]=="0"){
                        return"<span>"+data+"</span>";
                    }else{
                        return"<button class='btn btn-primary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_spby' data-file_spby='"+full["file_spby"]+"'><b>"+data+"</b></button>";
                    }
                }
            },
            {data:"deskripsi"},
            {data:"nominal", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
            {data:"cara_bayar",
                mRender:function(data){
                    if(data==1){
                        return"<b>tunai</b>";
                    }else if(data==2){
                        return"<b>non tunai</b>";
                    }else{
                        return"<b>N/A</b>";
                    }
                }
            },
            {data:"status",
                mRender:function(data, type, full){
                    if(full["id_status"]==1){
                        return"<span class='badge badge-danger'>"+data+"</span>";
                    }else if(full["id_status"]==2){
                        return"<span class='badge badge-primary'>"+data+"</span>";
                    }else if(full["id_status"]==3){
                        return"<span class='badge badge-success'>"+data+"</span>";
                    }else{
                        return"<span class='badge badge-warning'>"+data+"</span>";
                    }
                }
            },
            {data:"id",
                mRender:function(data, type, full){
                    if(full["id_status"]==2 || full["id_status"]==3){
                        return "<button class='btn btn-success btn-sm' id='detail_nota' data-no_kwitansi='"+full['no_kwitansi']+"' data-file='"+full['file']+"' data-id_akun='"+full["id_akun"]+"' data-id_coa='"+full["id_coa"]+"' data-id_nota='"+full["id"]+"' data-deskripsi='"+full["deskripsi"]+"' data-id_status='"+full["id_status"]+"' data-no_spby='"+full["no_spby"]+"' data-nominal='"+full["nominal"]+"' data-cara_bayar='"+full["cara_bayar"]+"' data-id_subcoa='"+full["id_subcoa"]+"'>Detail</button> <button id='delete_nota' class='btn btn-danger btn-sm' data-id_nota='"+data+"' disabled>Delete</button> ";
                    }else{
                        return "<button class='btn btn-success btn-sm' id='detail_nota' data-no_kwitansi='"+full['no_kwitansi']+"' data-file='"+full['file']+"' data-id_akun='"+full["id_akun"]+"' data-id_coa='"+full["id_coa"]+"' data-id_nota='"+full["id"]+"' data-deskripsi='"+full["deskripsi"]+"' data-id_status='"+full["id_status"]+"' data-no_spby='"+full["no_spby"]+"' data-nominal='"+full["nominal"]+"' data-cara_bayar='"+full["cara_bayar"]+"' data-id_subcoa='"+full["id_subcoa"]+"'>Detail</button> <button id='delete_nota' class='btn btn-danger btn-sm' data-id_nota='"+data+"' >Delete</button> ";
                    }
                }
            }
        ]
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

    $("body").on("click",".reload",function(){
        $(".tb_nota").DataTable().ajax.reload(null, false);
    });

    function format ( d ) {

        if(d.no_spby==null){
            var a = "NULL";
        }else{
            var a = "Upload SPBy";
        }
        // `d` is the original data object for the row
        return '<div class="slider">'+
        '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="">'+
            '<tr>'+
                '<td align="left" style="width:20px"><b>ID Akun</b></td>'+
                '<td style="width:5px"><b>Detail Akun</b></td>'+
                '<td align="left"><b>Detail COA</b></td>'+
                '<td></td>'+
            '</tr>'+
            '<tr>'+
                '<td align="left">'+d.id_akun+'</td>'+
                '<td>'+d.detail_akun+'</td>'+
                '<td align="left">'+d.detail_coa+'</td>'+
                '<td></td>'+
            '</tr>'+
            '<tr>'+
                '<td align="left" colspan="4" style="width:20px"><button class="btn btn-primary btn-sm" id="upload_spby" data-id_nota="'+d.id+'">'+a+'</button><button style="margin-left:10px" class="btn btn-primary btn-sm" id="upload_kwitansi" data-id_nota="'+d.id+'">Upload Kwitansi</button></td>'+
            '</tr>'+       
        '</table>'+
        '</div>';
    }

    $('.tb_nota tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tb_nota.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            // This row is already open - close it
            $('div.slider', row.child()).slideUp( function () {
                row.child.hide();
                tr.removeClass('shown');
            } );
        }
        else {
            // Open this row
            row.child( format(row.data()), 'no-padding' ).show();
            tr.addClass('shown');
 
            $('div.slider', row.child()).slideDown();
        }
    });

});

$("body").on("click", "#upload_spby", function(){
    var id_nota = $(this).data("id_nota");
    console.log(id_nota);
    $("#id_nota2").val(id_nota);
    $("#modalUploadSPBY").modal("show");
});

$("body").on("click","#upload_kwitansi",function(){
    var id_nota = $(this).data("id_nota");
    $("#id_nota3").val(id_nota);
    $("#modalUploadKwitansi").modal("show");
});

$("body").on("click","#detail_nota",function(){
    let file = $(this).data("file");
    document.getElementById("data_dukung").src="public/uploads/"+file;
    let id_akun=$(this).data("id_akun");
    let id_coa=$(this).data("id_coa");
    let id_nota=$(this).data("id_nota");
    let deskripsi=$(this).data("deskripsi");
    let id_status=$(this).data("id_status");
    let nominal=$(this).data("nominal");
    let no_spby=$(this).data("no_spby");
    let cara_bayar=$(this).data("cara_bayar");
    let id_subcoa=$(this).data("id_subcoa");
    let no_kwitansi=$(this).data("no_kwitansi");

    let f = document.getElementById("detail_coa");
    //mengosongka list sebelumnya
    f.options.length=0;

    let g = document.getElementById("sub_coa");
    //mengosongka list sebelumnya
    g.options.length=0;

    $("#id_nota").val(id_nota);
    $("#akun").val(id_akun);
    $("#deskripsi").val(deskripsi);
    $("#nominal").val(nominal);
    $("#no_spby").val(no_spby);
    $("#no_kwitansi").val(no_kwitansi);
    $("#cbayar").val(cara_bayar);

    if(cara_bayar==1){
        document.getElementById("input_sakti").value=1;
        document.getElementById("tunai").checked=true;
    }else if(cara_bayar==2){
        document.getElementById("input_sakti").value=1;
        document.getElementById("non_tunai").checked=true;
    }else{
        document.getElementById("input_sakti").value=0;
        document.getElementById("tunai").checked=false;
        document.getElementById("non_tunai").checked=false;
    }
    
    if(id_status==3){
        document.getElementById("tunai").disabled = true;
        document.getElementById("non_tunai").disabled = true;
        document.getElementById("input_sakti").disabled = false;
        document.getElementById("no_spby").readOnly = false;
        document.getElementById("nominal").readOnly = true;
    }else if(id_status==2){
        document.getElementById("tunai").disabled = true;
        document.getElementById("non_tunai").disabled = true;
        document.getElementById("input_sakti").disabled = false;
        document.getElementById("no_spby").readOnly = false;
        document.getElementById("nominal").readOnly = true;
    }else{
        document.getElementById("tunai").disabled = false;
        document.getElementById("non_tunai").disabled = false;
        document.getElementById("input_sakti").disabled = true;
        document.getElementById("no_spby").readOnly = true;
        document.getElementById("nominal").readOnly = false;
    }

    $.ajax({
        url:"{{route('bendahara.getDetailAkun')}}",
        type:"GET",
        data:{id_akun:id_akun, id_coa:id_coa},
        success:function(data){
            for(let a=0; a<data.baris_coa; a++){
                $("#detail_coa").append("<option value='"+data.detail_coa[a].id_coa+"'>"+data.detail_coa[a].keterangan+"</option>");
            }
            $("#detail_coa").val(id_coa);

            for(let c=0; c<data.baris_subcoa; c++){
                $("#sub_coa").append("<option value='"+data.detail_subcoa[c].id_subcoa+"'>"+data.detail_subcoa[c].keterangan+"</option>");
            }
            $("#sub_coa").val(id_subcoa);

            $(".modalPreview").modal("show");
        }
    });
});

$("body").on("change","#input_sakti",function(){
    console.log($(this).val());
    if($(this).val()==1){
        document.getElementById("no_spby").readOnly=false;
    }else{
        document.getElementById("no_spby").value="";
        document.getElementById("no_spby").readOnly=true;
    }
});

$("body").on("change","input[name=cara_bayar]",function(){
    $("#cbayar").val($(this).val());
});

$("#akun").on("click",function(){
    let id_akun = $(this).val();
    let f = document.getElementById("detail_coa");
    //mengosongka list sebelumnya
    f.options.length=0;

    $.ajax({
        url:"bendahara/"+id_akun+"/coa",
        type:"GET",
        data:{id_akun:id_akun},
        success:function(data){
            $("#detail_coa").append("<option value='0'>Pilih detail COA</option>");
            for(let a=0; a<data.baris; a++){
                $('#detail_coa').append("<option value='"+data.detail_coa[a].id_coa+"'>"+data.detail_coa[a].detail_coa+"</option>")
            }
        }
    });
});

$("#update").on("click",function(e){
    e.preventDefault();
    let nominal = $("#nominal").val();
    let cara_bayar = $("#cbayar").val();
    
        if(nominal==0 || nominal==""){
            alert("isikan nominal yang sesuai");
        }else if(cara_bayar==0){
            alert("Pilih cara pembayaran");
        }else{
            $.ajax({
                url:"{{route('bendahara.update')}}",
                type:"POST",
                data:$("#formAkun").serialize(),
                success:function(data){
                    $(".modalPreview").modal("hide");
                    $(".tb_nota").DataTable().ajax.reload(null, false);
                    $(".total").val(data.total);
                    console.log(data.total);
                }
            });
        }
});

$("body").on('click','#delete_nota',function(){
    console.log($(this).data("id_nota"));
    let id_nota = $(this).data("id_nota");
    if(confirm("Anda yakin ingin ingin menghapus data ini?")){
        $.ajax({
            url:"bendahara/"+id_nota+"/delete",
            type:"GET",
            success:function(data){
                $(".tb_nota").DataTable().ajax.reload();
                console.log("data "+data);
            }
        });
    }
});

</script>
@endpush()