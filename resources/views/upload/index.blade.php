@extends('layout.app')

@section('content')
<style type="text/css">
td.details-control {
    background: url("{{asset('public/icons/pluss.png')}}") no-repeat center center;
    cursor: pointer;
    vertical-align: top;
}

tr.shown td.details-control {
    background: url("{{asset('public/icons/minuss.jpg')}}") no-repeat center center;
    vertical-align: top;
}

div.slider {
    display: none;
}
</style>
@if(Auth::user()->level==3)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10" style="margin-bottom:20px;">
            <h5 style="font-weight:bold; margin-top:50px">Upload data dukung</h5>
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
                        <tfoot>
                            <tr>
                                <th style="text-align:center" colspan="2">TOTAL : </th>
                                <th style="text-align:right"></th>
                                <th></th>
                            </tr>
                        </tfoot>
				    </table>
                </div>
            </div>
        </div>

        <div class="col-10">
            <div class="card">
                <div class="card-header">Upload data dukung</div>

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
                <input type="hidden" id="id_drpp" disabled="true">
                    <table id="tb_nota" class="table display table-striped tb_nota" style="width:100%;">
                        <thead>
                            <th style="width:80px">Tanggal</th>
                            <th style="width:150px">No. Kwitansi</th>
                            <th style="width:150px">No. SPBy</th>
                            <th>Akun</th>
                            <th>COA</th>
                            <th>Deskripsi</th>
                            <th style="text-align: right">Nominal</th>
                            <th style="70px">Jenis</th>
                            <th>Status</th>
                            <th style="text-align: right">Action</th>
                        </thead>
                        <tbody class="our-table"></tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align:center" colspan="6">TOTAL : </th>
                                <th style="text-align:right"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
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

<div class="modal fade" id="modalUploadSPBY"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="">Upload dokumen SPBy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('upload.upload_spby')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
                    
					<div class="form-group">
                        <input type="hidden" name="id_nota2" id="id_nota2">
                        <label for="name" class="col-sm-3 control-label"><b>No. SPBy</b></label>
						<div class="col-sm-12">
                            <input type="text" name="nomer_spby" id="nomer_spby" class="form-control" readonly>
						</div>

						<label for="name" class="col-sm-3 control-label"><b>File SPBy</b></label>
						<div class="col-sm-12">
                            <input type="file" name="file_spby" id="file_spby" class="form-control">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="simpan_spby" disabled="true">Submit</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUploadKwitansi"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="">Upload dokumen Kwitansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('upload.upload_kwitansi')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
                    
					<div class="form-group">
                        <input type="hidden" name="id_nota3" id="id_nota3">
                        <label for="name" class="col-sm-12 control-label"><b>No. Kwitansi</b></label>
						<div class="col-sm-12">
                            <input type="text" name="nomer_kwitansi" id="nomer_kwitansi" class="form-control" readonly>
						</div>

						<label for="name" class="col-sm-12 control-label"><b>File Kwitansi</b></label>
						<div class="col-sm-12">
                            <input type="file" name="file_kwitansi" id="file_kwitansi" class="form-control">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="simpan_kwitansi" disabled="true">Submit</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUploadDRPP" style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="">Upload dokumen DRPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('upload.upload_drpp')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}
                    
					<div class="form-group">
                        <input type="hidden" name="id_drpp2" id="id_drpp2">
                        <label for="name" class="col-sm-12 control-label"><b>No. DRPP</b></label>
						<div class="col-sm-12">
                            <input type="text" name="no_drpp" id="no_drpp" class="form-control">
						</div>

						<label for="name" class="col-sm-12 control-label"><b>File DRPP</b></label>
						<div class="col-sm-12">
                            <input type="file" name="file_drpp" id="file_drpp" class="form-control">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="simpan_drpp" disabled="true">Submit</button>
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
                    <embed src= "" id="file_spby2" width= "100%" height= "100%" style="border:1px grey solid">
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
                    <embed src= "" id="file_kwitansi2" width= "100%" height= "100%" style="border:1px grey solid">
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade modalLihatDRPP" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Lihat dokumen DRPP</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col" style="height:800px">
                    <embed src="" id="file_drpp2" width= "100%" height= "100%" style="border:1px grey solid">
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
    $("body").on("change","#file_drpp",function(){
        document.getElementById("simpan_drpp").disabled=false;
    });

    $("body").on("change","#file_spby",function(){
        console.log("change");
        document.getElementById("simpan_spby").disabled=false;
    });

    $(".tb_gup").DataTable({
        ajax        :"{{route('upload.list_gup')}}",
        searching   :false,
        serverside  :false,
        select      :true,
        scrollY     :"180px",
        paging      :false,
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            total = api.column(2).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            
            // Update footer
            $(api.column(2).footer()).html(numFormat(total));
            
        },
        columns     :[
            {data:"tgl", width:"100px"},
            {data:"no_drpp",
                mRender:function(data, type, full){
                    if(full["no_drpp"]=="" || full["no_drpp"]==null){
                        return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                    }else{
                        if(full["file_drpp"]=="" || full["file_drpp"]==null){
                            return"<span>"+data+"</span>";    
                        }else{
                            return"<button class='btn btn-primary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_drpp' data-file_drpp='"+full["file_drpp"]+"'><b>"+data+"</b></button>";
                        }
                    }
                }
            },
            {data:"total", className:'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
            {data:"no_drpp",
                mRender:function(data, type, full){
                    return"<button class='btn btn-primary btn-sm detail' data-id_drpp='"+full["id_drpp"]+"' data-no_drpp='"+data+"'>Detail</button> <button class='btn btn-warning btn-sm upload_drpp' data-id_drpp='"+full["id_drpp"]+"' data-no_drpp='"+data+"'>Upload DRPP</button>";
                }
            }
        ]
    });

    $("body").on("change","#file",function(){
        document.getElementById("btnUploadSubmit").disabled=false;
    });

    $("body").on("click",".detail",function(){
        console.log("detail ")
        
        let id_drpp = $(this).data("id_drpp");
        $("#id_drpp").val(id_drpp);

        $(".tb_nota").DataTable().clear().destroy();

        var tb_nota = $(".tb_nota").DataTable({
            ajax    :{url:"{{route('upload.list_nota')}}", type:"GET", data:{id_drpp:id_drpp}},
            serverside:false,
            ordering:false,
            scrollY:"250px",
            paging:false,
            searching: true,
            lengthChange: false,
            oLanguage: {
                sLoadingRecords: '<img src="{{asset('public/loading_animation/ajax-loader.gif')}}">'
            },
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };
    
                // Total over all pages
                total = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                
                // Update footer
                $(api.column(6).footer()).html(numFormat(total));
                
            },
            columns:[
                {data:"tanggal", width:"100px"},
                {data:"no_kwitansi", width:"100px",
                    mRender:function(data, type, full){
                        if(full["no_kwitansi"]=="0" || full["no_kwitansi"]==null){
                            return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                        }else{
                            if(full["file_kwitansi"]=="0" || full["file_kwitansi"]==null){
                                return"<span>"+data+"</span> <br><button class='btn btn-secondary btn-sm' id='upload_kwitansi' data-id_nota='"+full["id"]+"' data-nomer_kwitansi='"+full['no_kwitansi']+"'>Upload</button>";    
                            }else{
                                return"<button class='btn btn-secondary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_kwitansi' data-file_kwitansi='"+full["file_kwitansi"]+"'><b>"+data+"</b></button> <br><button class='btn btn-secondary btn-sm' id='upload_kwitansi' data-id_nota='"+full["id"]+"' data-nomer_kwitansi='"+full['no_kwitansi']+"'>Upload</button>";
                            }
                        }
                    }
                },
                {data:"no_spby", width:"100px",
                    mRender:function(data, type, full){
                        if(full["no_spby"]=="0" || full["no_spby"]==null){
                            return"<span class='badge bg-danger' style='color:white'>NULL</span>";
                        }else{
                            if(full["file_spby"]=="0" || full["file_spby"]==null){
                                return"<span>"+data+"</span> <br><button class='btn btn-secondary btn-sm' id='upload_spby' data-id_nota='"+full["id"]+"' data-no_spby='"+full["no_spby"]+"'>Upload</button>";    
                            }else{
                                return"<button class='btn btn-secondary btn-sm' style='background-color:transparent; padding:0; border:none; color:blue;' id='lihat_spby' data-file_spby='"+full["file_spby"]+"'><b>"+data+"</b></button> <br><button class='btn btn-secondary btn-sm' id='upload_spby' data-id_nota='"+full["id"]+"' data-no_spby='"+full["no_spby"]+"'>Upload</button>";
                            }
                        }
                    }
                },
                {data:"id_akun", width:"250px",
                    render:function(data, type, full){
                        return'<span>'+data+'- '+ full["detail_akun"] +'</span>';
                    }
                },
                {data:"detail_coa", width:"250px"},
                {data:"deskripsi", width:"300px"},
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
                        
                        return "<button class='btn btn-success btn-sm' id='detail_nota' data-no_kwitansi='"+full['no_kwitansi']+"' data-file='"+full['file']+"' data-id_akun='"+full["id_akun"]+"' data-id_coa='"+full["id_coa"]+"' data-id_nota='"+full["id"]+"' data-deskripsi='"+full["deskripsi"]+"' data-id_status='"+full["id_status"]+"' data-no_spby='"+full["no_spby"]+"' data-nominal='"+full["nominal"]+"' data-cara_bayar='"+full["cara_bayar"]+"' data-id_subcoa='"+full["id_subcoa"]+"'>Detail</button>";
                    }
                }
            ]
        });

        });


        $("body").on("click","#lihat_spby",function(){
            
            $(".modalLihatSPBY").modal("show");
            
            var file_spby = $(this).data("file_spby");
            
            document.getElementById("file_spby2").src="public/uploads/spby/"+file_spby;
        });

        $("body").on("click","#lihat_kwitansi",function(){
            
            $(".modalLihatKwitansi").modal("show");
            var file_kwitansi = $(this).data("file_kwitansi");
            console.log(file_kwitansi);
            document.getElementById("file_kwitansi2").src="public/uploads/kwitansi/"+file_kwitansi;
        });

        $("body").on("click","#lihat_drpp",function(){
            
            $(".modalLihatDRPP").modal("show");
            
            var file_drpp = $(this).data("file_drpp");
            console.log(file_drpp);
            document.getElementById("file_drpp2").src="public/uploads/drpp/"+file_drpp;
        });

});

$("body").on("click", ".upload_drpp", function(){
    let id_drpp = $(this).data("id_drpp");
    
    let no_drpp = $(this).data("no_drpp");
    $("#id_drpp2").val(id_drpp);
    $("#no_drpp").val(no_drpp);
    $("#file_drpp").val("");
    document.getElementById("simpan_drpp").disabled = true;

    $("#modalUploadDRPP").modal("show");
});

$("body").on("click", "#upload_spby", function(){
    var id_nota = $(this).data("id_nota");
    
    var nomer_spby = $(this).data("no_spby");

    $("#nomer_spby").val(nomer_spby);
    if(nomer_spby == 0 || nomer_spby == null){
        document.getElementById("simpan_spby").disabled = true;
        document.getElementById("file_spby").disabled = true;
    }else{
        document.getElementById("simpan_spby").disabled = false;
        document.getElementById("file_spby").disabled = false;
    }
    $("#id_nota2").val(id_nota);
    document.getElementById("simpan_spby").disabled = true;
    $("#modalUploadSPBY").modal("show");
});

$("body").on("click","#upload_kwitansi",function(){
    var id_nota = $(this).data("id_nota");

    var nomer_kwitansi = $(this).data("nomer_kwitansi");
    $("#nomer_kwitansi").val(nomer_kwitansi);
    if(nomer_kwitansi == 0 || nomer_kwitansi == null){
        document.getElementById("simpan_kwitansi").disabled = true;
        document.getElementById("file_kwitansi").disabled = true;
    }else{
        document.getElementById("simpan_kwitansi").disabled = false;
        document.getElementById("file_kwitansi").disabled = false;
    }
    $("#id_nota3").val(id_nota);
    document.getElementById("simpan_kwitansi").disabled = true;
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
        url:"{{route('transaksi.nota.getDetailAkun')}}",
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
                url:"{{route('transaksi.nota.update')}}",
                type:"POST",
                data:$("#formAkun").serialize(),
                success:function(data){
                    $(".modalPreview").modal("hide");
                    $(".tb_nota").DataTable().ajax.reload(null, false);
                    $(".total").val(data.total);
                    console.log(data.no_kwitansi);
                }
            });
        }
});

</script>
@endpush()