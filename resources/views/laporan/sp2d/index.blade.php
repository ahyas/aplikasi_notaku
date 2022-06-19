@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
    <div class="col-8">
        <h5 style="font-weight:bold">Daftar belanja LS</h5>
            <div class="card">
                <div class="card-header">Daftar SP2D</div>
                <div class="card-body">
                    <table id="tb_daftar_sp2d" class="table display tb_daftar_sp2d" style="width:100%; ">
                        <thead>    
                            <th>No.</th> 						
                            <th>No. SP2D</th>
                            <th style="width:80px">Tgl. SP2D</th>
                            <th style="width:80px">Jenis SPM</th>
                            <th>Deskripsi</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
						<tbody></tbody>
				    </table>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">Detail akun</div>
                <div class="card-body">
                <div id="template"></div>
                    <table id="tb_daftar_akun" class="table display table-triped tb_daftar_akun" style="width:100%; ">
                        <thead>  
                            <th>No.</th>
                            <th style="width:100px">Akun</th>      
                            <th style="width:250">Keterangan</th>                      				
                            <th style="width:300px">Jenis</th>
                            <th>Jumlah</th>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right">Total:</th>
                                <th width="50px" style="text-align:right"></th>
                            </tr>
                        </tfoot>
                    </table>
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
        $(".tb_daftar_sp2d").DataTable({
            ajax:"{{route('laporan_sp2d.show_daftar_sp2d')}}",
            serverside:false,
            scrollY:"500px",
            columns:[
                {data:"no_sp2d",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                },
                {data:"no_sp2d"},
                {data:"tanggal"},
                {data:"jenis_spm"},
                {data:"deskripsi"},
                {data:"nilai", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:'dt-body-right',},
                {data:"no_sp2d",
                    render:function(data){
                        return"<button class='btn btn-primary btn-sm detail_sp2d' data-no_sp2d='"+data+"'>Detail</button>";
                    }
                },
            ]
        });

        getDaftarAkun();

        function getDaftarAkun(no_sp2d){
            $(".tb_daftar_akun").DataTable().clear().destroy();
            
            $(".tb_daftar_akun").DataTable({
                ajax:{
                    url : "{{route('laporan_sp2d.detail_sp2d')}}",
                    type: "GET",
                    data: {no_sp2d:no_sp2d}
                },
                searching:false,
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
                ordering:false,
                serverside:false,
                paging:false,
                columns:[
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
                    {data:"jumlah", render: $.fn.DataTable.render.number(',', '.', 2, ''), className:'dt-body-right'},
                    
                ]
            });
        }

        $("body").on("click",".detail_sp2d",function(){
            let no_sp2d = $(this).data("no_sp2d");
            getDaftarAkun(no_sp2d);
        });
    });
</script>
@endpush