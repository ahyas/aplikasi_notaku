@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h5 style="font-weight:bold; margin-top:50px">Mencatat DRPP</h5>
            <div class="card">
                <div class="card-header">Keranjang DRPP</div>

                <div class="card-body">

                <input type="hidden" value="{{$no_drpp}}" class="form-control form-control-sm no_drpp">
                    @if(Auth::user()->level == 4)
                    <button class="btn btn-primary btn-sm tambah_drpp " style="margin-bottom:20px">Tambah</button>
                    @else
                    <button class="btn btn-primary btn-sm tambah_drpp " style="margin-bottom:20px" disabled>Tambah</button>
                    @endif

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label"><b>Total</b></label>
                        <div class="col-sm-12">
                            <input type="text" value=<?php echo number_format("$total",2,",","."); ?> class="form-control form-control total" style="text-align:right; font-weight:bold" readonly>
                        </div>
                    </div>
                    
                    <table id="tb_keranjang_drpp" class="table display table-striped tb_keranjang_drpp">
                        <thead>  				
                            <th>Akun</th>
                            <th></th>
                            <th>COA</th>
                            <th>Deskripsi</th>
                            <th style="text-align:right">Nominal</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <br>
                    <button class="btn btn-success btn-sm btn-block simpan_drpp" id="simpan_drpp" style="float:right" disabled="true">Simpan</button>
                </div>
               
            </div>
        </div>
    </div>
</div>

<div class="modal fade keranjangDRPP" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Tambah nota transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <table id="tb_daftar_nota" class="table display tb_nota" width="100%">
                        <thead>  				
                            <th>Akun</th>
                            <th></th>
                            <th>COA</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th>Action</th>
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
<script type="text/javascript">
$(document).ready(function(){

    var total_drpp = $(".total").val();
    console.log(total_drpp);

    if(total_drpp == "0,00" ){
        document.getElementById("simpan_drpp").disabled= true;
    }else{
        document.getElementById("simpan_drpp").disabled= false;
    }

    $(".tb_keranjang_drpp").DataTable({
        ajax:"{{route('transaksi.drpp.show_list')}}",
        serverSide:false,
        searching:false,
        scrollY:"400px",
        paging:false,
        columns:[
            {data:"id_akun"},
            {data:"nama_akun"},
            {data:"coa"},
            {data:"deskripsi"},
            {data:"nominal", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:"dt-body-right"},
            {data:"id",
                mRender:function(data, type, full){
                    return"<button class='btn btn-danger btn-sm hapus_nota' data-id_nota='"+data+"'>Hapus</button>";
                }
            }
        ]
    });

    $("#tb_daftar_nota").DataTable({
        ajax:"{{route('transaksi.drpp.daftar_nota')}}",
        serverSide:false,
        scrollY:"300px",
        paging:false,
        columns:[
            {data:"id_akun"},
            {data:"nama_akun"},
            {data:"coa"},
            {data:"deskripsi"},
            {data:"nominal", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:"dt-body-right"},
            {data:"id",
                mRender:function(data){
                    return"<button class='btn btn-primary btn-sm pilih_nota' id='pilih_nota' data-id_nota='"+data+"'>Pilih</button>";
                }
            }
        ]
    });

    $("body").on("click",".tambah_drpp",function(){
        $(".keranjangDRPP").modal("show");
        $("#tb_daftar_nota").DataTable().ajax.reload(null, false);
    });

    $("body").on("click","#pilih_nota",function(){
        let no_drpp = $(".no_drpp").val();
        let id_nota = $(this).data("id_nota");
        $.ajax({
            url:"{{route('transaksi.drpp.input_nota')}}",
            type:"GET",
            data:{id_nota:id_nota,no_drpp:no_drpp},
            success:function(data){
                //$(".keranjangDRPP").modal("hide");
                $(".total").val(Number(data.total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                console.log(data.jml_nota);

                if(data.jml_nota == 0){
                    $(".keranjangDRPP").modal("hide");
                    
                }
                $("#tb_daftar_nota").DataTable().ajax.reload(null, false);
                $(".tb_keranjang_drpp").DataTable().ajax.reload(null, false);
                document.getElementById("simpan_drpp").disabled = false;
            }
        });
    });

    $("body").on("click",".hapus_nota",function(){
        let id_nota = $(this).data("id_nota");
        let no_drpp = $(".no_drpp").val();
        if(confirm("Anda yakin ingin menghapus nota?")){
            $.ajax({
                url:"{{route('transaksi.drpp.hapus_nota')}}",
                type:"GET",
                data:{id_nota:id_nota,no_drpp:no_drpp},
                success:function(data){
                    $(".total").val(Number(data.total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    if(data.jml_nota == 0){
                        document.getElementById("simpan_drpp").disabled = true;
                    }else{
                        document.getElementById("simpan_drpp").disabled = false;
                    }
                    $(".tb_keranjang_drpp").DataTable().ajax.reload(null, false);
                }
            });
        }
    });

    $("body").on("click",".simpan_drpp",function(){
        let no_drpp = $(".no_drpp").val();
        let total = $(".total").val();
        console.log(total);
        if(confirm("Pastikan semua data telah benar sebelum anda menyimpan")){
            $.ajax({
                url:"{{route('transaksi.drpp.simpan_drpp')}}",
                type:"GET",
                data:{no_drpp:no_drpp, total:total},
                success:function(data){
                    $(".no_drpp").val(data.total);
                    $(".total").val("0,00");
                    $(".tb_keranjang_drpp").DataTable().ajax.reload(null, false);
                    document.getElementById("simpan_drpp").disabled = true;
                }
            });
        }
    });
});

</script>
@endpush()