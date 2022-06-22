@extends('layout/app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h5 style="font-weight:bold; margin-top:50px">Verifikasi LS</h5>
            <div class="card">
                <div class="card-header">Daftar SP2D</div>
                <div class="card-body">

                    <table class="table display table-striped tb_keranjang_sp2d" style="width:100%;">
                        <thead>
                            <th width="10px">No.</th>  				
                            <th width="150px">Nomor SP2D</th>
                            <th>Tanggal</th>
                            <th>Jenis SPM</th>
                            <th>Deskripsi</th>
                            <th style="text-align:right">Nilai(Rp)</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Detail akun</div>
                <div class="card-body">
                <input type="hidden" class="form-control no_sp2d" name="no_sp2d" id="no_sp2d" readonly>
                    <table class="table display table-striped tb_detail_sp2d" id="tb_detail_sp2d" style="width:100%;">
                        <thead>  	
                            <th width="10px">No.</th>			
                            <th width="50px">Akun</th>
                            <th >Keterangan</th>
                            <th >Jenis</th>
                            <th width="80px" style="text-align:right">Jumlah</th>
                            <th width="50px">Action</th>
                        </thead>
                        <tbody class="our-table"></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right">Total:</th>
                                <th width="50px" style="text-align:right"></th>
                                <th width="50px" style="text-align:right"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="button" class="btn btn-primary btn-lg btn-block btn-sm" id="simpan" disabled="true" style="margin-top:15px">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Start form COA-->
<div class="modal fade" id="modalAkun"  style="overflow: hidden;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="coa_modal_title">Edit jenis akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>

            <div class="modal-body">
                <form id="formEditAkun" name="formEditAkun" class="form-horizontal">
					{{csrf_field()}} {{method_field('POST')}}
                    <input type="hidden" class="form-control" name="id_detail_transaksi" id="id_detail_transaksi">
					<div class="form-group">
						<label for="name" class="col-sm-3 control-label"><b>No. SP2D : </b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="nomer_sp2d" id="nomer_sp2d" readonly>
						</div>

                        <label for="name" class="col-sm-3 control-label"><b>Akun : </b></label>
						<div class="col-sm-12">
                            <select class="form-control" id="id_akun" name="id_akun">
                               
                            </select>
						</div>

                        <label for="name" class="col-sm-3 control-label"><b>jumlah : </b></label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="jumlah" readonly>
						</div>
					</div>

					<div class="modal-footer">
						<button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnUpdateAkun" value="create">Update</button>
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End form COA-->

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        //menampilkan daftar sp2d
        $(".tb_keranjang_sp2d").DataTable({
            ajax:"{{route('verifikasi_ls.show_transaksi')}}",
            serverside:false,
            scrollY:"300px",
            paging:false,
            oLanguage: {
                sLoadingRecords: '<img src="{{asset('public/loading_animation/ajax-loader.gif')}}">'
  		    },
            columns: [
                {data:"no_sp2d",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data:"no_sp2d"},
                {data:"tanggal", width:"100px"},
                {data:"jenis_spm"},
                {data:"deskripsi"},
                {data:"nilai", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                {data:"no_sp2d", 
                    render:function(data){
                        return"<button class='btn btn-primary btn-sm detail_sp2d' data-no_sp2d='"+data+"'>Detail</button>";
                    }
                }
            ]
        });

        function tb_detail(no_sp2d){
            $(".tb_detail_sp2d").DataTable().clear().destroy();
            $(".tb_detail_sp2d").DataTable({
                ajax:
                {
                    url     : "{{route('verifikasi_ls.detail_sp2d')}}",
                    type    : "GET",
                    data    : {no_sp2d:no_sp2d}
                },
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();
                    var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };
        
                    // Total over all pages
                    total = api.column(4).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    
                    // Update footer
                    $(api.column(4).footer()).html(numFormat(total));
                },
                initComplete: function(settings, json) {
                    var oTable = $('#tb_detail_sp2d').DataTable();
                    var info = oTable.page.info();
                    var count = info.recordsTotal;

                    if(count==0){
                        document.getElementById("simpan").disabled=true;
                    }else{
                        document.getElementById("simpan").disabled=false;
                    }
                },
                serverside  :false,
                responsive: true,
                searching :false,
                paging :false,
                scrollY:"300px",
                ordering:false,
                oLanguage   : {
                    sLoadingRecords: '<img src="{{asset('public/loading_animation/ajax-loader.gif')}}">'
                },
                columns: [
                    {data:"akun",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data:"akun"},
                    {data:"nama_akun",
                        render:function(data, type, full){
                            if(full["jenis_akun"]=="BELANJA"){
                                if(data==null){
                                    return"<span class='badge badge-danger'>"+data+"</span>";
                                }else{
                                    return"<span>"+data+"</span>";
                                }
                            }else{
                                return"<span>"+full["nama_potongan"]+"</span>";
                            }
                        }
                    },
                    {data:"jenis_akun"},
                    {data:"jumlah", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                    {data:"id", 
                        render:function(data, type, full){
                            if(full["jenis_akun"]=="BELANJA"){
                                return"<button class='btn btn-success btn-sm' id='edit_akun' data-parent_akun='"+full["akun"]+"' data-id_detail_transaksi='"+data+"' data-nama_akun='"+full["nama_akun"]+"'>Edit</button>";
                            }else{
                                return"<button class='btn btn-success btn-sm' id='edit_akun' data-parent_akun='"+full["akun"]+"' data-id_detail_transaksi='"+data+"' data-nama_akun='"+full["nama_akun"]+"' disabled>Edit</button>";
                            }
                        }
                    }
                ]
            });
        }

        $("body").on("click","#edit_akun", function(){
            let id_detail_transaksi = $(this).data("id_detail_transaksi");
            let parent_akun = $(this).data("parent_akun");
            let nama_akun = $(this).data("nama_akun");
            $.ajax({
                url:"{{route('ls.edit')}}",
                type:"GET",
                data:{id_detail_transaksi:id_detail_transaksi, parent_akun:parent_akun},
                success:function(data){
                    let select = document.getElementById('id_akun');
                    $('#id_akun').find('option').remove();
                    console.log("parent "+data.parent_akun);
                    if(nama_akun==null){
                        var par = document.createElement('option');
                        par.value = parent_akun;
                        par.innerHTML = parent_akun+" null";
                        select.appendChild(par);
                    }

                    for(var a=0; a<=data.daftar_akun.length-1; a++){
                        var opt = document.createElement('option');
                        opt.value = data.daftar_akun[a].id_akun;
                        opt.innerHTML = data.daftar_akun[a].id_akun+" "+data.daftar_akun[a].keterangan;
                        select.appendChild(opt);
                        
                    }
                    
                    $("#id_akun").val(data.table.akun);
                    $("#id_detail_transaksi").val(data.table.id);
                    $("#nomer_sp2d").val(data.table.no_sp2d);
                    $("#jumlah").val(data.table.jumlah);
                    $("#modalAkun").modal("show");
                }
            });
        });

        $("#btnUpdateAkun").on("click",function(e){
            e.preventDefault();
            
            $.ajax({
                url:"{{route('verifikasi_ls.update')}}",
                type:"POST",
                data:$("#formEditAkun").serialize(),
                success:function(data){
                    $("#modalAkun").modal("hide");
                    $(".tb_detail_sp2d").DataTable().ajax.reload();
                }
            });
        });
        //menampilkan detail sp2d
        $("body").on("click",".detail_sp2d", function(){

            let no_sp2d = $(this).data("no_sp2d");

            $(".no_sp2d").val(no_sp2d);
            console.log(no_sp2d);
            tb_detail(no_sp2d);
            
         });        
        
         //menyimpan daftar rincian akun
         $("body").on("click","#simpan",function(){
            let no_sp2d = $("#no_sp2d").val();
            //check apakah masih terdapat data null
            let is_null = $( ".our-table td:nth-child(3):contains('null')").length;
            console.log(is_null);
            if(is_null == 1){
                alert("Lengkapi data!")
            }else{
                if(confirm("Anda yakin ingin menyimpan data ini?")){
                    $.ajax({
                        url:"{{route('verifikasi_ls.simpan')}}",
                        type:"GET",
                        data:{no_sp2d:no_sp2d},
                        success:function(data){
                            console.log("return "+data);
                            $(".tb_keranjang_sp2d").DataTable().ajax.reload(null, false);
                            tb_detail();
                            $(".no_sp2d").val("");
                            document.getElementById("simpan").disabled=true;
                        }
                    });
                }
            }
        });

    });
</script>
@endpush