@extends('layout.app')

@section('content')
<style type="text/css">
    
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
        <h5 style="font-weight:bold">Mapping akun dan anggaran</h5>
            <div class="card">
                <div class="card-header">Program</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_program" class="table display tb_program" style="width:100%;">
                        <thead>     						
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Kegiatan</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_kegiatan" class="table display tb_kegiatan" style="width:100%;">
                        <thead>     						
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">KRO</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_kro" class="table display tb_kro" style="width:100%;">
                        <thead>     						
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">RO</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_ro" class="table display tb_ro" style="width:100%;">
                        <thead>     						
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Komponen</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_komponen" class="table display tb_komponen" style="width:100%;">
                        <thead>     						
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Sub Komponen</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_sub_komponen" class="table display tb_sub_komponen" style="width:100%;">
                        <thead>     						
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Akun/Detail</div>
                <div class="card-body">
                    <button class="btn btn-success btn-sm" style="margin-bottom:15px">Baru</button>
                    
                    <table id="tb_akun" class="table display tb_akun" style="width:100%;">
                        <thead>     						
                            <th>ID Akun</th>
                            <th>Keterangan</th>
                            <th>Pagu</th>
                            <th>Akun</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">COA</div>
                <div class="card-body">
                <button class="btn btn-success btn-sm coa_baru" id="coa_baru" style="margin-bottom:15px">Baru</button>
                <div id="template"></div>
                <table id="tb_coa" class="table display tb_coa" style="width:100%;">
                    <thead>  
                       	<th>ID</th>				
                        <th>Keterangan</th>
                        <th>Pagu</th>
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
        <div class="col-8">
            <div class="card">
                <div class="card-header">Sub COA</div>
                <div class="card-body">
                <button class="btn btn-success btn-sm subcoa_baru" id="subcoa_baru" style="margin-bottom:15px">Baru</button>
                    <div id="subcoa"></div>
                    <table id="tb_subcoa" class="table display tb_subcoa" style="width:100%;">
                        <thead>
                            <th>ID</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--End form template-->

<div class="modal modal-fade" id="modalAkun"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="subcoa_modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="formAkun" name="subcoaForm" class="form-horizontal">
					{{csrf_field()}} {{method_field('POST')}}
					<div class="form-group">
                        <input type="text" class="form-control" name="id_akun" id="id_akun">
                        <label for="name" class="col-sm-3 control-label"><b>Akun</b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="akun" id="akun">
						</div>
						<label for="name" class="col-sm-3 control-label"><b>Keterangan</b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="keterangan_akun" id="keterangan_akun">
						</div>
                        <label for="name" class="col-sm-3 control-label"><b>Pagu</b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="pagu_akun" id="pagu_akun">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnAkunSubmit">Submit</button>
						<button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnAkunUpdate">Update</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Start form COA-->
<div class="modal modal-fade" id="modalCOA"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="coa_modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>

            <div class="modal-body">
                <form id="coaForm" name="daftarcoaForm" class="form-horizontal">
					{{csrf_field()}} {{method_field('POST')}}
                    <input type="hidden" id="id_akun2" name="id_akun2">
                    <input type="hidden" id="id_coa" name="id_coa">

					<div class="form-group">
						<label for="name" class="col-sm-4 control-label"><b>Keterangan : </b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="nama_coa" id="nama_coa">
						</div>

                        <label for="name" class="col-sm-3 control-label"><b>Nominal : </b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="pagu_coa" id="pagu_coa">
						</div>
					</div>

					<div class="modal-footer">
						<button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnCOASubmit" value="create">Submit</button>
						<button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnCOAUpdate" value="create">Update</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End form COA-->

<!--Start form subcoa-->
<div class="modal" id="modalSubcoa"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="subcoa_modal_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
                <form id="subcoaForm" name="subcoaForm" class="form-horizontal">
					{{csrf_field()}} {{method_field('POST')}}
                    <input type="hidden" id="id_coa2" name="id_coa2">
                    <input type="hidden" id="id_subcoa" name="id_subcoa">
					<div class="form-group">
						<label for="name" class="col-sm-3 control-label"><b>Keterangan</b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="nama_subcoa" id="nama_subcoa">
						</div>
					</div>

					<div class="modal-footer">
                        <button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnSubCOASubmit">Submit</button>
						<button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnSubCOAUpdate">Update</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End form pertanyaan-->
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){

    $(".tb_program").DataTable({
        ajax:"{{route('mapping.get_daftar_program')}}",
        serverSide:false,
        searching:false,
        paging:false,
        columns:[
            {data:"kode"},
            {data:"keterangan"},
            {data:"pagu",className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
            {data:"id",
                mRender:function(data, type, full){
                    return"<button class='btn btn-primary btn-sm' id='edit_program' data-id_program='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_program' data-id_program='"+full["id"]+"'>Detail</button> <button id='delete_program' class='btn btn-danger btn-sm' data-id_program='"+full["id"]+"'>Delete</button>";
                }
            }
        ]
    });

    $("body").on("click","#detail_program", function(){
        let id_program = $(this).data("id_program");

        $(".tb_kegiatan").DataTable().clear().destroy();
        $(".tb_kro").DataTable().clear().destroy();
        $(".tb_ro").DataTable().clear().destroy();
        $(".tb_komponen").DataTable().clear().destroy();
        $("#tb_sub_komponen").DataTable().clear().destroy();
        $("#tb_akun").DataTable().clear().destroy();
        $("#tb_coa").DataTable().clear().destroy();
        $("#tb_subcoa").DataTable().clear().destroy();

        $(".tb_kegiatan").DataTable({
            ajax:{
                url:"{{route('mapping.get_daftar_kegiatan')}}",
                type:"GET",
                data : {id_program : id_program}
            },
            serverSide:false,
            searching:false,
            paging:false,
            columns:[
                {data:"kode"},
                {data:"keterangan"},
                {data:"pagu",className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='edit_kegiatan' data-id_kegiatan='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_kegiatan' data-id_kegiatan='"+full["id"]+"'>Detail</button> <button id='delete_kegiatan' class='btn btn-danger btn-sm' data-id_kegiatan='"+full["id"]+"'>Delete</button>";
                    }
                }
            ]
        });

    });

    $("body").on("click","#detail_kegiatan",function(){
        let id_kegiatan = $(this).data("id_kegiatan");

        $(".tb_kro").DataTable().clear().destroy();
        $(".tb_ro").DataTable().clear().destroy();
        $(".tb_komponen").DataTable().clear().destroy();
        $("#tb_sub_komponen").DataTable().clear().destroy();
        $("#tb_akun").DataTable().clear().destroy();
        $("#tb_coa").DataTable().clear().destroy();
        $("#tb_subcoa").DataTable().clear().destroy();

        $(".tb_kro").DataTable({
            ajax:{
                url:"{{route('mapping.get_daftar_kro')}}",
                type:"GET",
                data:{id_kegiatan:id_kegiatan}
            },
            serverSide:false,
            searching:false,
            paging:false,
            columns:[
                {data:"kode"},
                {data:"keterangan"},
                {data:"pagu",className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='edit_kro' data-id_komponen='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_kro' data-id_kro='"+full["id"]+"'>Detail</button> <button id='delete_komponen' class='btn btn-danger btn-sm' data-id_kro='"+full["id"]+"'>Delete</button>";
                    }
                }
            ]
        });
    });

    $("body").on("click","#detail_kro",function(){
        let id_kro = $(this).data("id_kro");
        
        $(".tb_ro").DataTable().clear().destroy();
        $(".tb_komponen").DataTable().clear().destroy();
        $("#tb_sub_komponen").DataTable().clear().destroy();
        $("#tb_akun").DataTable().clear().destroy();
        $("#tb_coa").DataTable().clear().destroy();
        $("#tb_subcoa").DataTable().clear().destroy();

        $(".tb_ro").DataTable({
            ajax:{
                url:"{{route('mapping.get_daftar_ro')}}",
                type:"GET",
                data:{id_kro:id_kro},
            },
            serverSide:false,
            searching:false,
            paging:false,
            columns:[
                {data:"kode"},
                {data:"keterangan"},
                {data:"pagu",className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='edit_ro' data-id_komponen='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_ro' data-id_ro='"+full["id"]+"'>Detail</button> <button id='delete_komponen' class='btn btn-danger btn-sm' data-id_ro='"+full["id"]+"'>Delete</button>";
                    }
                }
            ]
        });
    });

    $("body").on("click","#detail_ro", function(){
        let id_ro = $(this).data("id_ro");
       
        $(".tb_komponen").DataTable().clear().destroy();
        $("#tb_sub_komponen").DataTable().clear().destroy();
        $("#tb_akun").DataTable().clear().destroy();
        $("#tb_coa").DataTable().clear().destroy();
        $("#tb_subcoa").DataTable().clear().destroy();

        $(".tb_komponen").DataTable({
            ajax:{
                url:"{{route('mapping.get_daftar_komponen')}}",
                type:"GET",
                data:{id_ro:id_ro}
            },
            serverSide:false,
            searching:false,
            paging:false,
            columns:[
                {data:"kode"},
                {data:"keterangan"},
                {data:"pagu",className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='edit_komponen' data-id_komponen='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_komponen' data-id_komponen='"+full["id"]+"'>Detail</button> <button id='delete_komponen' class='btn btn-danger btn-sm' data-id_komponen='"+full["id"]+"'>Delete</button>";
                    }
                }
            ]
        });
    });

    $("body").on("click","#detail_komponen",function(){

        let id_komponen = $(this).data("id_komponen");
        $("#tb_sub_komponen").DataTable().clear().destroy();
        $("#tb_akun").DataTable().clear().destroy();
        $("#tb_coa").DataTable().clear().destroy();
        $("#tb_subcoa").DataTable().clear().destroy();

        $("#tb_sub_komponen").DataTable({
            ajax:{
                url :"{{route('mapping.get_daftar_sub_komponen')}}",
                type :"GET",
                data : {id_komponen : id_komponen}
            },
            serverside:false,
            searching:false,
            paging:false,
            columns:[
                {data:"kode"},
                {data:"keterangan"},
                {data:"pagu", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='edit_coa' data-id_coa='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_sub_komponen' data-id_sub_komponen='"+full["id"]+"'>Detail</button> <button id='delete_sub_komponen' class='btn btn-danger btn-sm' data-id_sub_komponen='"+full["id"]+"'>Delete</button>";
                    }
                }
            ]
        });

    });

    $("body").on("click","#detail_sub_komponen",function(){
        let id_sub_komponen = $(this).data("id_sub_komponen");

        $("#tb_akun").DataTable().clear().destroy();
        $("#tb_coa").DataTable().clear().destroy();
        $("#tb_subcoa").DataTable().clear().destroy();

        $("#tb_akun").DataTable({
            ajax:{
                url:"{{route('mapping.get_daftar_akun')}}",
                type:"GET",
                data:{id_sub_komponen:id_sub_komponen},
            },
            serverside:false,
            searching:false,
            paging:false,   
            columns:[
                {data:"id_akun"},
                {data:"keterangan"},
                {data:"pagu",className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
                {data:"id",
                    mRender:function(data, type, full){
                        return"<button class='btn btn-primary btn-sm' id='edit_akun' data-id_akun='"+full["id"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_akun' data-id_akun='"+full["id_akun"]+"'>Detail</button> <button id='delete_akun' class='btn btn-danger btn-sm' data-id_akun='"+full["id"]+"'>Delete</button>";
                    }
                }
            ]
        });
    });

$("body").on("click","#detail_akun",function(){
    $("#tb_coa").DataTable().clear().destroy();
    $("#tb_subcoa").DataTable().clear().destroy();

    let id_akun = $(this).data("id_akun");
    
    $("#id_akun2").val(id_akun);
    $("#tb_coa").DataTable({
        ajax:"mapping/coa/"+id_akun+"/daftar_coa",
        serverside:false,
        searching:false,
        paging:false,
        columns:[
            {data:"id_coa"},
            {data:"keterangan"},
            {data:"pagu", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '') },
            {data:"id_coa",
                mRender:function(data, type, full){
                    return"<button class='btn btn-primary btn-sm' id='edit_coa' data-id_coa='"+full["id_coa"]+"'>Edit</button> <button class='btn btn-success btn-sm' id='detail_coa' data-id_coa='"+full["id_coa"]+"'>Detail</button> <button id='delete_coa' class='btn btn-danger btn-sm' data-id_coa='"+full["id_coa"]+"'>Delete</button>";
                }
            }
        ]
    });
});

$("body").on("click","#detail_coa",function(){
    $("#tb_subcoa").DataTable().clear().destroy();

    let id_coa = $(this).data("id_coa");
    $("#id_coa2").val(id_coa);
    console.log(id_coa);
    $("#tb_subcoa").DataTable({
        ajax:"mapping/subcoa/"+id_coa+"/daftar_subcoa",
        serverside:false,
        searching:false,
        paging:false,
        columns:[
            {data:"id_subcoa"},
            {data:"keterangan"},
            {data:"id_sub_coa",
                mRender:function(data, type, full){
                    return"<button class='btn btn-primary btn-sm' id='edit_subcoa' data-id_subcoa='"+full["id_subcoa"]+"'>Edit</button> <button id='delete_subcoa' class='btn btn-danger btn-sm' data-id_subcoa='"+full["id_subcoa"]+"'>Delete</button>";
                }
            }
        ]
    });
});

$("body").on("click","#coa_baru",function(){
    $("#modalCOA").modal("show");
    $("#nama_coa").val("");
    document.getElementById("coa_modal_title").innerHTML="Tambah COA baru";
    document.getElementById("btnCOASubmit").style.display = "inline-block";
    document.getElementById("btnCOAUpdate").style.display = "none";
});

$("#btnCOASubmit").on("click", function(e){
    e.preventDefault();
    $.ajax({
        url:"{{route('mapping.coa.save')}}",
        type:"POST",
        data:$("#coaForm").serialize(),
        success:function(){
            $("#tb_coa").DataTable().ajax.reload();
            $("#modalCOA").modal("hide");
        }
    });
});

$("body").on("click","#edit_coa", function(){
    document.getElementById("coa_modal_title").innerHTML="Edit COA";
    document.getElementById("btnCOASubmit").style.display = "none";
    document.getElementById("btnCOAUpdate").style.display = "inline-block";
    let id_coa=$(this).data("id_coa");
    $("#id_coa").val(id_coa);

    $.ajax({
        url:"{{route('mapping.coa.edit')}}",
        type:"GET",
        data:{id_coa:id_coa},
        success:function(data){
            console.log(data);
            $("#nama_coa").val(data.keterangan);
            $("#pagu_coa").val(data.pagu);
            $("#modalCOA").modal("show");
        }
    });
});

$("#btnCOAUpdate").click(function(e){
    e.preventDefault();
    console.log("nama coa "+nama_coa+" id_coa : "+id_coa);
    $.ajax({
        url:"{{route('mapping.coa.update')}}",
        type:"POST",
        data:$("#coaForm").serialize(),
        success:function(data){
            $("#modalCOA").modal("hide");
            $("#tb_coa").DataTable().ajax.reload();
        }
    });
});

$("body").on("click","#delete_coa",function(){
    console.log("delete");
    let id_coa=$(this).data("id_coa");
    console.log(id_coa);
    $.ajax({
        url:"{{route('mapping.coa.delete')}}",
        type:"GET",
        data:{id_coa:id_coa},
        success:function(data){
            $("#tb_coa").DataTable().ajax.reload();
            $("#tb_subcoa").DataTable().clear().destroy();
        }
    });
});

$("body").on("click","#subcoa_baru",function(){
    document.getElementById("subcoa_modal_title").innerHTML="Tambah sub COA";
    document.getElementById("btnSubCOASubmit").style.display = "inline-block";
    document.getElementById("btnSubCOAUpdate").style.display = "none";
    $("#modalSubcoa").modal("show");
});

$("#btnSubCOASubmit").click(function(e){
    e.preventDefault();
    
    $.ajax({
        url:"{{route('mapping.subcoa.save')}}",
        type:"POST",
        data:$("#subcoaForm").serialize(),
        success:function(data){
            $("#tb_subcoa").DataTable().ajax.reload();
            $("#modalSubcoa").modal("hide");
        }
    });
});

$("body").on("click","#delete_subcoa",function(){
    console.log($(this).data("id_subcoa"));
    let id_subcoa=$(this).data("id_subcoa");
    $.ajax({
        url:"{{route('mapping.subcoa.delete')}}",
        type:"GET",
        data:{id_subcoa:id_subcoa},
        success:function(data){
            $("#tb_subcoa").DataTable().ajax.reload();
        }
    });
});

$("body").on("click","#edit_subcoa",function(){
    document.getElementById("subcoa_modal_title").innerHTML="Edit sub COA";
    document.getElementById("btnSubCOASubmit").style.display = "none";
    document.getElementById("btnSubCOAUpdate").style.display = "inline-block";

    let id_subcoa=$(this).data("id_subcoa");
    console.log(id_subcoa);
    $("#id_subcoa").val(id_subcoa);
    $.ajax({
        url:"{{route('mapping.subcoa.edit')}}",
        type:"GET",
        data:{id_subcoa:id_subcoa},
        success:function(data){
            $("#nama_subcoa").val(data.keterangan);
          
            $("#modalSubcoa").modal("show");
        }
    });
});

$("#btnSubCOAUpdate").click(function(e){
    e.preventDefault();
    $.ajax({
        url:"{{route('mapping.subcoa.update')}}",
        type:"POST",
        data:$("#subcoaForm").serialize(),
        success:function(data){
            $("#tb_subcoa").DataTable().ajax.reload();
            $("#modalSubcoa").modal("hide");
        }
    });
});

$("body").on("click", "#edit_akun",function(){

    document.getElementById("btnAkunSubmit").style.display = "none";
    document.getElementById("btnAkunUpdate").style.display = "inline-block";
    console.log("asd");
    let id_akun = $(this).data("id_akun");
    $.ajax({
        url:"{{route('mapping.akun.edit_akun')}}",
        type:"GET",
        data:{id_akun:id_akun},
        success:function(data){
            console.log(data);
            $("#id_akun").val(data.id);
            $("#akun").val(data.id_akun);
            $("#keterangan_akun").val(data.keterangan);
            $("#pagu_akun").val(data.pagu);
            $("#modalAkun").modal("show");
        }
    });
});

$("#btnAkunUpdate").click(function(e){
    e.preventDefault();
    
    $.ajax({
        url:"{{route('mapping.akun.update_akun')}}",
        type:"POST",
        data:$("#formAkun").serialize(),
        success:function(data){
            if(data>0){
                alert("id akun sudah dipakai");
                return false;
            }
            $("#modalAkun").modal("hide");
            $("#tb_akun").DataTable().ajax.reload(null, false);
        }
    });
});

});
</script>
@endpush
