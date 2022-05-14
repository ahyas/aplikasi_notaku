@extends('layout/app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Mencatat SP2D</div>
                <div class="card-body">
                    <form action="{{route('transaksi.sp2d.read_xml')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <label><b>Upoad SP2D (.xml)</b></label>
                        <div class="input-group mb-3">
                            
                        <input type="file" name="file" class="form-control" id="file" placeholder="Recipient's username">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-primary" value="create">Upload</button>
                            </div>
                        </div>
                    </form>

                    <table class="table display table-striped tb_keranjang_sp2d" style="width:100%;">
                        <thead>
                            <th width="10px">No.</th>  				
                            <th width="150px">Nomor SP2D</th>
                            <th>Tanggal SP2D</th>
                            <th style="text-align:right">Nilai(Rp)</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Mencatat detail akun</div>
                <div class="card-body">
                    <form action="{{route('transaksi.sp2d.read_xml')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="text" class="form-control no_sp2d">
                        <label><b>Upoad detail Akun (.xls)</b></label>
                        <div class="input-group mb-3">
                            
                        <input type="file" name="file_detail_akun" class="form-control">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-primary" value="create">Upload</button>
                            </div>
                        </div>
                    </form>

                    <table class="table display table-striped tb_detail_sp2d" style="width:100%;">
                        <thead>
                            <th width="10px">No.</th>  				
                            <th width="150px">Nomor SP2D</th>
                            <th>Tanggal SP2D</th>
                            <th style="text-align:right">Nilai(Rp)</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-lg btn-block btn-sm">Simpan</button>
                    <button type="button" class="btn btn-danger btn-lg btn-block btn-sm">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(".tb_keranjang_sp2d").DataTable({
            ajax:"{{route('transaksi.sp2d.show_transaksi')}}",
            serverside:false,
            scrollY:"300px",
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
                {data:"tanggal"},
                {data:"nilai", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                {data:"no_sp2d", 
                    render:function(data){
                        return"<button class='btn btn-primary btn-sm detail_sp2d' data-no_sp2d='"+data+"'>Detail</button>";
                    }
                }
            ]
        });

        $("body").on("click",".detail_sp2d", function(){
            $(".tb_detail_sp2d").DataTable().clear().destroy();

            let no_sp2d = $(this).data("no_sp2d");
            $(".no_sp2d").val(no_sp2d);
       
            $(".tb_detail_sp2d").DataTable({
                ajax:"{{route('transaksi.sp2d.detail_sp2d',['no_sp2d'=>'"+no_sp2d+"'])}}",
                serverside:false,
                scrollY:"300px",
                oLanguage: {
                    sLoadingRecords: '<img src="{{asset('public/loading_animation/ajax-loader.gif')}}">'
                },
                columns: [
                    {data:"id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data:"no_sp2d"},
                    {data:"tanggal"},
                    {data:"nilai", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                    {data:"id", 
                        render:function(data, type, row){
                            return"<button class='btn btn-primary btn-sm' data-id-transaksi='"+row["id"]+"'>Detail</button>";
                        }
                    }
                ]
            });
         });

    });
</script>
@endpush