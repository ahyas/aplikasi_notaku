@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h5 style="font-weight:bold; margin-top:50px">Daftar belanja per akun</h5>
            <div class="card">
                <div class="card-header">Daftar Transaksi Akun</div>
                <div class="card-body">
                    <button class="btn btn-primary btn-sm cetak_laporan" style="margin-bottom:20px">Print</button>
                    <table id="tb_akun" class="table table-striped tb_akun" style="width:100%; ">
                        <thead>
                            <th style="width:10px">No.</th>  				
                            <th style="width:60px">ID Akun</th>
                            <th>Akun</th>
                            <th>jenis akun</th>
                            <th>Pagu</th>
                            <th>Realisasi</th>
                            <th>Saldo</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php $no = 0; $total_realisasi = 0; $total_pagu = 0;?>
                           @foreach($tb_akun as $row)
                                <tr>
                                    <td><?php echo $no+=1; ?></td>
                                    <td>{{$row->id_akun}}</td>
                                    <td>{{$row->keterangan}}</td>   
                                    <td>{{$row->nama_komponen}}</td>
                                    <td style="text-align:right"><?php echo number_format($row->pagu,2); ?></td>
                                    <td style="text-align:right">
                                    @if($row->id_komponen == 1)
                                        <?php $realisasi_ls = 0; ?>
                                        @foreach($tb_ls as $row_ls)
                                            @if($row_ls->akun == $row->id_akun)
                                                <?php $realisasi_ls+=$row_ls->jumlah; ?>

                                            @endif
                                        @endforeach
                                        <?php $realisasi = $realisasi_ls; ?>
                                        
                                    @else
                                    <?php $realisasi_nota = 0; ?>
                                        @foreach($tb_nota as $row_nota)
                                            @if($row_nota->id_akun == $row->id_akun)
                                                <?php $realisasi_nota+=$row_nota->nominal; ?>
                                            @endif
                                        @endforeach
                                        <?php $realisasi = $realisasi_nota; ?>
                                        
                                    @endif
                                    <?php $total_realisasi += $realisasi; ?>
                                    <?php $total_pagu += $row->pagu; ?>
                                    <?php echo number_format($realisasi, 2); ?>
                                    </td>
                                    <td style="text-align:right">
                                        <b><?php echo number_format($row->pagu - $realisasi, 2); ?></b>
                                    </td>
                                    <td >
                                    @if($row->id_komponen == 1)
                                        <button class='btn btn-primary btn-sm' id='detail_akun' data-id_akun="{{$row->id_akun}}" disabled>Detail</button>
                                    @else
                                        <button class='btn btn-primary btn-sm' id='detail_akun' data-id_akun="{{$row->id_akun}}">Detail</button>
                                    @endif
                                    </td>
                                </tr>
                           @endforeach
                        <?php $no++; ?>
                        <tr>
                            <td colspan="4" style="text-align:center; font-weight:bold"><b>Total</b></td>
                            <td style="text-align:right; font-weight:bold"><?php echo number_format($total_pagu, 2);  ?></td>
                            <td style="text-align:right; font-weight:bold"><?php echo number_format($total_realisasi, 2); ?><br><?php echo "(".number_format(($total_realisasi/$total_pagu)*100, 2)." %)";  ?></td>
                            <td style="text-align:right; font-weight:bold"><?php echo number_format($total_pagu - $total_realisasi, 2); ?></td>
                            <td></td>
                        </tr>
                        </tbody>
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
                <div class="col-md-6 mb-4">
                    <table id="tb_daftar_coa" class="table display tb_daftar_coa" style="width:100%; ">
                        <thead>
                            <th style="width:200px">Nama COA</th>
                            <th>Pagu</th>
                            <th>Realisasi</th>
                            <th>Saldo</th>
                            <th width="20px">Action</th>  				
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-6 mb-3">
                    <table id="tb_daftar_subcoa" class="table display tb_daftar_subcoa" style="width:100%; ">
                        <thead>
                            <th>No. SPBy</th>
                            <th width="70px">Tanggal</th>
                            <th>Deskripsi</th>
                            <th style="padding-right:10px">Nominal</th>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align:left">Realisasi : </th>
                                <th style="text-align:left"></th>
                            </tr>
                        </tfoot>
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
$("body").on("click",".cetak_laporan",function(){
window.open("rekap_akun/print");
});

$("body").on("click","#detail_akun",function(){
      
      let id_akun = $(this).data("id_akun");
      console.log(id_akun);

          $(".modalDetail").modal("show");
          $("#tb_daftar_subcoa").DataTable().clear().destroy();
          $("#tb_daftar_coa").DataTable().clear().destroy();
          var table = $("#tb_daftar_coa").DataTable({
              ajax:"rekap_akun/"+id_akun+"/daftar_coa",
              paginate:false,
              searching:false,
              serverside:false,
              processing:false,
              columns:[
                  {data:"keterangan"},
                  {data:"pagu", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                  {data:"realisasi", className: 'dt-body-right', 
                    mRender:$.fn.DataTable.render.number(',', '.', 2, ''), function(data, type, full){
                            let prosentase_realisasi = (data / full["pagu"]) * 100;
                            return'<span>'+data+" ("+prosentase_realisasi+' %)</span>';
                        }
                    },
                  {data:"pagu", className: 'dt-body-right', 
                    render:$.fn.DataTable.render.number(',', '.', 2, ''), function(data, type, full){
                            let saldo = data - full["realisasi"];
                            return '<b><span>'+saldo+'</span></b>';
                        }
                    },
                  {data:"id_akun", className: 'dt-body-right',
                      mRender:function(data,type,full){
                          return"<button class='btn btn-primary btn-sm' id='detail_coa' data-id_akun='"+data+"' data-id_coa='"+full['id_coa']+"'>Detail</button>";
                      }
                  },
              ]
          });
  });

  $("body").on("click","#detail_coa",function(){
        let id_akun = $(this).data("id_akun");
        let id_coa = $(this).data("id_coa");
        console.log(id_akun+" "+id_coa)

            $("#tb_daftar_subcoa").DataTable().clear().destroy();
            var tb_subcoa =  $("#tb_daftar_subcoa").DataTable({
                ajax:{url:"{{route('laporan.rekap_akun.detail_coa')}}", type:"GET", data:{id_akun:id_akun, id_coa:id_coa}},
                ordering:false,
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();
                    var numFormat = $.fn.DataTable.render.number( '\,', '.', 2, '' ).display;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };
        
                    // Total over all pages
                    total = api.column(3).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    
                    // Update footer
                    $(api.column(3).footer()).html(numFormat(total));
                },
                paging:false,
                searching:false,
                serverSide:false,
                processing:false,
                columns:[
                    {data:"no_spby"},
                    {data:"tanggal"},
                    {data:"deskripsi"},
                    {data:"nominal", className: 'dt-body-right', render: $.fn.DataTable.render.number(',', '.', 2, '')},
                ],
            });
    });
</script>
@endpush()