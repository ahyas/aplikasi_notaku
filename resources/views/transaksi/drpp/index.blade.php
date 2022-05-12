@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Keranjang DRPP</div>

                <div class="card-body">

                <input type="text" value="{{$no_drpp}}" class="form-control form-control-sm no_drpp">
                <input type="text" value="{{$total}}" class="form-control form-control-sm total" style="align:right">

                <button class="btn btn-primary btn-sm tambah_drpp ">Tambah</button>
                    <table id="tb_keranjang_drpp" class="table display tb_keranjang_drpp" style="width:100%;">
                        <thead>  				
                            <th width="150px">No. SPBy</th>
                            <th>Akun</th>
                            <th>COA</th>
                            <th>Deskripsi</th>
                            <th style="text-align:right">Nominal</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button class="btn btn-success btn-sm simpan_drpp" style="float:right">Simpan</button>
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
                    <table id="tb_daftar_nota" class="table display tb_nota" style="width:100%; ">
                        <thead>  				
                            <th>No. SPBy</th>
                            <th>Akun</th>
                            <th>COA</th>
                            <th>Deskripsi</th>
                            <th style="text-align:right">Nominal</th>
                            <th style=" white-space: nowrap; width: 1px;">Action</th>
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
    $("body").on("click",".tambah_drpp",function(){
        $("#tb_daftar_nota").DataTable().ajax.reload(null, false);
        $(".keranjangDRPP").modal("show");
    });

    $(".tb_keranjang_drpp").DataTable({
        ajax:"{{route('transaksi.drpp.show_list')}}",
        serverSide:false,
        searching:false,
        paging:false,
        columns:[
            {data:"no_spby"},
            {data:"id_akun"},
            {data:"coa"},
            {data:"deskripsi"},
            {data:"nominal"},
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
        columns:[
            {data:"no_spby"},
            {data:"id_akun"},
            {data:"coa"},
            {data:"deskripsi"},
            {data:"nominal"},
            {data:"id",
                mRender:function(data){
                    return"<button class='btn btn-primary btn-sm pilih_nota' id='pilih_nota' data-id_nota='"+data+"'>Pilih</button>";
                }
            }
        ]
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
                $(".total").val(data);
                $("#tb_daftar_nota").DataTable().ajax.reload(null, false);
                $(".tb_keranjang_drpp").DataTable().ajax.reload(null, false);
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
                    $(".total").val(data);
                    $(".tb_keranjang_drpp").DataTable().ajax.reload(null, false);
                }
            });
        }
    });

    $("body").on("click",".simpan_drpp",function(){
        let no_drpp = $(".no_drpp").val();
        let total = $(".total").val();
        if(confirm("Pastikan semua data telah benar sebelum anda menyimpan")){
            $.ajax({
                url:"{{route('transaksi.drpp.simpan_drpp')}}",
                type:"GET",
                data:{no_drpp:no_drpp, total:total},
                success:function(data){
                    $(".no_drpp").val(data);
                    $(".total").val(0);
                    $(".tb_keranjang_drpp").DataTable().ajax.reload(null, false);
                }
            });
        }
    });
});

</script>
@endpush()