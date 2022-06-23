@extends('layout.app')

@section('content')
<style type="text/css">
td.details-control {
    background: url('../public/icons/pluss.png') no-repeat center center;
    cursor: pointer;
    vertical-align: top;
}

tr.shown td.details-control {
    background: url('../public/icons/minuss.jpg') no-repeat center center;
    vertical-align: top;
}

div.slider {
    display: none;
}
</style>
@if(Auth::user()->level==2)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h5 style="font-weight:bold; margin-top:50px">Verifikasi nota pembelian</h5>
            <div class="card">
                <div class="card-header">Daftar nota</div>

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
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name" class="col-sm-4 control-label"><b>UP</b></label>
                            <input type="text" class="form-control input-lg up" name="up" id="up" value=<?php echo number_format("30000000",2,",","."); ?> readOnly="true" style="text-align:right; font-weight:bold;">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name" class="col-sm-12 control-label"><b>Total pengeluaran</b></label>
                            <input type="text" class="form-control input-lg total" name="total" id="total" value=<?php echo number_format("$total",2,",","."); ?> readOnly="true" style="text-align:right; font-weight:bold;">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name" class="col-sm-12 control-label"><b>Total saldo</b></label>
                            <input type="text" class="form-control" name="" id="" readOnly="true" value="<?php echo number_format("$total_saldo",2,",","."); ?>" style="text-align:right; font-weight:bold;">
                        </div>
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name" class="control-label"><b>Prosentase capaian GUP :</b></label>
                            <span class="font-size:20px; float:right"><b>{{$prosentase_capaian_gup}} %</b></span>
                            <br>
                        </div>
                    </div>                          
                    
                    <table id="tb_nota" class="table display tb_nota" style="width:100%; ">
                        <thead>  				
                            <th style="width:80px">Tanggal</th>
                            <th>Akun</th>
                            <th></th>
                            <th>COA</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th width="70px">Jenis</th>
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
                    <div class="form-group">
                        <div class="col-sm-12">
                        <label for="name" class="control-label"><b>Akun</b></label>
                            <select class="form-control" id="akun" name="akun">
                                <option value="0">Pilih akun</option>
                                @foreach($table as $row)
                                <option value="{{$row->id_akun}}">{{$row->id_akun}} - {{$row->akun}}</option>
                                @endforeach
                            </select>
                            <small class="form-text" style="color:blue">Saldo akun : <span id="saldo_akun" style="font-weight:bold; float:right"></span></small>
                        </div>
                    </div>

                    <input type="hidden" id="desc_coa" name="desc_coa">

                    <div class="form-group">
                        <div class="col-sm-12">
                        <label for="name" class="control-label"><b>Detail COA</b></label>
                            <select class="form-control" id="detail_coa" name="detail_coa" disabled="true">
                                <option value="0" selected>Pilih detail COA</option>
                            </select>
                            <small class="form-text" style="color:blue">Saldo COA : <span id="saldo_coa" style="font-weight:bold; float:right"></span></small>
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
                        <div class="col-sm-12">
                        <label for="name" class="control-label"><b>Deskripsi</b></label>
                            
                            <textarea class="form-control" name="deskripsi" id="deskripsi" readOnly="true" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label"><b>Nominal (Bruto)</b></label>
                        <div class="col-sm-6">
                            <input type="nominal" class="form-control" name="nominal" id="nominal" style="text-align:right" value="0">
                        </div>
                    </div>

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
@endif
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){

    $("body").on("click",".open_rkk",function(){
        console.log("buka rkk");
        window.open("../public/rkk/rkk_dipa01.pdf", '_blank').focus();
    });

    var tb_nota = $(".tb_nota").DataTable({
        ajax: "{{route('verifikator.show_data')}}",
        serverside:false,
        ordering:false,
        searching: true,
        lengthChange: false,
        oLanguage: {
            sLoadingRecords: '<img src="{{asset('public/loading_animation/ajax-loader.gif')}}">'
  		},
        columns:[
            {data:"tanggal"},
            {data:"id_akun", width:"40px",
                mRender:function(data){
                    if(data == 0 || data == null){
                        return'<span class="badge bg-danger" style="color:white">NULL</span>';
                    }else{
                        return data;
                    }
                }
            },
            {data:"detail_akun",
                mRender:function(data){
                    if(data == 0 || data == null){
                        return'<span class="badge bg-danger" style="color:white">NULL</span>';
                    }else{
                        return data;
                    }
                }
            },
            {data:"detail_coa",
                mRender:function(data){
                    if(data == 0 || data == null){
                        return'<span class="badge bg-danger" style="color:white">NULL</span>';
                    }else{
                        return data;
                    }
                }
            },
            {data:"deskripsi",
                mRender:function(data){
                    if(data == 0 || data == null){
                        return'<span class="badge bg-danger" style="color:white">NULL</span>';
                    }else{
                        return data;
                    }
                }
            },
            {data:"nominal", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"cara_bayar",
                mRender:function(data){
                    if(data==1){
                        return"<b>tunai</b>";
                    }else{
                        return"<b>non tunai</b>";
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
                    return "<button class='btn btn-success btn-sm' id='detail_nota' data-file='"+full['file']+"' data-id_akun='"+full["id_akun"]+"' data-id_coa='"+full["id_coa"]+"' data-id_nota='"+full["id"]+"' data-deskripsi='"+full["deskripsi"]+"' data-id_status='"+full["id_status"]+"' data-nominal='"+full["nominal"]+"' data-cara_bayar='"+full["cara_bayar"]+"' data-id_subcoa='"+full["id_subcoa"]+"'>Detail</button>";
                }
            }
        ]
    });


    });

$("body").on("click","#detail_nota",function(){
    let file = $(this).data("file");
    document.getElementById("data_dukung").src="../public/uploads/"+file;
    let id_akun=$(this).data("id_akun");
    let id_coa=$(this).data("id_coa");
    let id_subcoa=$(this).data("id_subcoa");
    let id_nota=$(this).data("id_nota");
    let deskripsi=$(this).data("deskripsi");
    let id_status=$(this).data("id_status");
    let nominal = $(this).data("nominal");
    let cara_bayar=$(this).data("cara_bayar");
    console.log(id_akun);

    $("#id_nota").val(id_nota);
  
    $("#akun").val(id_akun);
    $("#deskripsi").val(deskripsi);
    $("#nominal").val(nominal);
    $("#desc_coa").val(id_coa);
    $("#desc_subcoa").val(id_subcoa);

    if(cara_bayar==1){
        document.getElementById("tunai").checked=true;
    }else if(cara_bayar==2){
        document.getElementById("non_tunai").checked=true;
    }else{
        document.getElementById("tunai").checked=false;
        document.getElementById("non_tunai").checked=false;
    }

    
    //input SAKTI
    if(id_status==3){
        document.getElementById("update").disabled=true;
        document.getElementById("tunai").disabled = true;
        document.getElementById("non_tunai").disabled = true;
        document.getElementById("akun").disabled=true;
        document.getElementById("detail_coa").disabled=true;
        document.getElementById("sub_coa").disabled=true;
        document.getElementById("deskripsi").readOnly=true;
        document.getElementById("nominal").disabled=true;
    }else if(id_status==4){
        document.getElementById("update").disabled=false;
        document.getElementById("tunai").disabled = false;
        document.getElementById("non_tunai").disabled = false;
        document.getElementById("akun").disabled=false;
        document.getElementById("detail_coa").disabled=true;
        document.getElementById("sub_coa").disabled=true;
        document.getElementById("deskripsi").readOnly=true;
        document.getElementById("nominal").disabled=false;
    }else{
        document.getElementById("update").disabled=false;
        document.getElementById("tunai").disabled = false;
        document.getElementById("non_tunai").disabled = false;
        document.getElementById("akun").disabled=false;
        document.getElementById("detail_coa").disabled=false;
        document.getElementById("sub_coa").disabled=false;
        document.getElementById("deskripsi").readOnly=false;
        document.getElementById("nominal").disabled=false;
    }

    let f = document.getElementById("detail_coa");
    //mengosongka list sebelumnya
    f.options.length=0;

    let g = document.getElementById("sub_coa");
    //mengosongka list sebelumnya
    g.options.length=0;

    $.ajax({
        url:"{{route('verifikator.getDetailCOA')}}",
        type:"GET",
        data:{id_akun:id_akun, id_coa:id_coa},
        success:function(data){
            document.getElementById("saldo_akun").innerHTML = data.saldo_akun;
            document.getElementById("saldo_coa").innerHTML = data.saldo_coa;

            $("#detail_coa").append("<option value='0'>Pilih detail COA</option>");
            for(let a=0; a<data.baris_coa; a++){
                $("#detail_coa").append("<option value='"+data.detail_coa[a].id_coa+"'>"+data.detail_coa[a].keterangan+"</option>");
            }
            $("#detail_coa").val(id_coa);
            
            $('#sub_coa').append("<option value='0'>Pilih Sub COA</option>");
            for(let c=0; c<data.baris_subcoa; c++){
                $("#sub_coa").append("<option value='"+data.detail_subcoa[c].id_subcoa+"'>"+data.detail_subcoa[c].keterangan+"</option>");
            }
            //Jika tidak terdapat sub COA pada list
            if(id_subcoa==101){
                $("#sub_coa").val(0);
                document.getElementById("sub_coa").disabled=true;
            }else{
                $("#sub_coa").val(id_subcoa);
            }

            $(".modalPreview").modal("show");
        }
    });

});


$("#akun").on("click",function(){
    let id_akun = $(this).val();
    document.getElementById("saldo_coa").innerHTML = 0;
    document.getElementById("sub_coa").disabled=true;

    if(id_akun==0){ 
        document.getElementById("detail_coa").value=0;
        document.getElementById("detail_coa").disabled=true;
        document.getElementById("deskripsi").readOnly=true;
    }else{
        let f = document.getElementById("detail_coa");
        //mengosongka list sebelumnya
        f.options.length=0;

        let g = document.getElementById("sub_coa");
        //mengosongka list sebelumnya
        g.options.length=0;
        
        $.ajax({
            url:id_akun+"/coa",
            type:"GET",
            data:{id_akun:id_akun},
            success:function(data){
                //Sisa pagu akun
                document.getElementById("saldo_akun").innerHTML = data.saldo_akun;

                if(data.baris>0){
                    $("#detail_coa").append("<option value='0'>Pilih detail COA</option>");
                    for(let a=0; a<data.baris; a++){
                        $('#detail_coa').append("<option value='"+data.detail_coa[a].id_coa+"'>"+data.detail_coa[a].detail_coa+"</option>")
                    }
                    $('#sub_coa').append("<option value='0'>Pilih Sub COA</option>");
                    document.getElementById("detail_coa").disabled=false;
                }else{
                    $("#detail_coa").append("<option value='0'>Pilih detail COA</option>");
                    $('#sub_coa').append("<option value='0'>Pilih Sub COA</option>");
                    document.getElementById("detail_coa").disabled=true;
                }
            }
        });
    }
});
    

$("#detail_coa").on("click",function(){
    let id_coa = $(this).val();
    console.log(id_coa);
    $("#desc_coa").val(id_coa);
    if(id_coa==0){
        
        document.getElementById("sub_coa").disabled=true;
        document.getElementById("deskripsi").readOnly=true;
        $("#deskripsi").val("");
    
    }else{
      
        document.getElementById("sub_coa").disabled=false;
        document.getElementById("deskripsi").readOnly=false;

        let f = document.getElementById("sub_coa");
        //mengosongka list sebelumnya
        f.options.length=0;
        //mengisi dengan list yang baru
        $.ajax({
            url:id_coa+"/sub_coa",
            type:"GET",
            data:{id_coa:id_coa},
            success:function(data){
                document.getElementById("saldo_coa").innerHTML = data.saldo_coa;

                if(data.baris>0){

                    $("#sub_coa").append("<option value='0'>Pilih sub COA</option>");
                    for(let a=0; a<data.baris; a++){
                        $('#sub_coa').append("<option value='"+data.table[a].id_subcoa+"'>"+data.table[a].nama_subcoa+"</option>")
                    }
                    $("#desc_subcoa").val(0);
                    document.getElementById("sub_coa").disabled=false;
                }else{
                    $("#sub_coa").append("<option value='0'>Pilih sub COA</option>");
                    $("#desc_subcoa").val(101);
                    document.getElementById("sub_coa").disabled=true;
                }
            }
        });
    }
});

$("#sub_coa").click(function(){
    let id_subcoa = $(this).val();
    $("#desc_subcoa").val(id_subcoa);
});

$("#update").on("click",function(e){
    console.log("upadate");
    e.preventDefault();
    let deskripsi =$("#deskripsi").val();
    let nominal = $("#nominal").val();
    let detail_coa = $("#detail_coa").val();
    let sub_coa = $("#sub_coa").val();
    let desc_subcoa = $("#desc_subcoa").val();

    if(detail_coa==0){
        alert("Pilih detail COA")
    }else if(desc_subcoa==0){
        alert("isikan detail sub COA");
    }else if(deskripsi==""){
        alert("Isikan deskripsi");
    }else if(nominal=="" || nominal==0){
        alert("Isikan nominal");
    }else{
        $.ajax({
            url:"{{route('verifikator.update')}}",
            type:"POST",
            data:$("#formAkun").serialize(),
            success:function(data){
                $(".modalPreview").modal("hide");
                $(".tb_nota").DataTable().ajax.reload(null, false);
            }
        });
    }
});

</script>
@endpush()