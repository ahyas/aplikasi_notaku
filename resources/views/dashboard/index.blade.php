@extends('layout.app')
@section('content')
<div class="container">
<head>

    <title>Daftar Perkara Masuk</title>
    
    <style type="text/css">
    .dataTables_filter input { width: 300px;
    border: 1px solid #cdcdcd; }
    </style>

</head>

<body style=" background-color: #003a1e;">
<div class="row">
    <div class="col-sm-12 main">
        <div class="panel panel-success ">
            <div class="panel-heading">
                <h2 class="panel-title" text="align-center">Daftar perkara masuk</h2>
            </div>
    <div class="panel-body">
        <div class="box-button">
            <table class="table table-striped data-table" width="100%">
                <thead>
                <tr>                   
                    <th>ID</th>
                    <th>No. Perkara</th>
                    <th>Pihak 1</th>
                    <th>Pihak 2</th>
                    <th>Jenis</th>
                    <th>Status akhir</th>
                    <th>Tgl. putusan</th>
                    <th>Status Cetak</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
</div>

<div class="modal fade" id="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
				
				<h3 class="modal-title" id="modal_title">Edit status</h3>
            </div>

            <div class="modal-body">
                <form id="statusForm" name="statusForm" class="form-horizontal">
					{{csrf_field()}} {{method_field('POST')}}
					<label>ID Perkara :</label>
                    <input type="text" class="form-control" readonly id="id_perkara" name="id_perkara"><br>
                    <label>No. Perkara :</label>
                    <input type="text" class="form-control" readonly id="no_perkara" name="no_perkara">
                    <br>
                    <div class="form-group">
                        <div class="col-sm-10">
                        <label>Masukan Status akhir :</label>
                            <select class="form-control status_cetak" id="status_cetak" name="status_cetak">
                                <option value="Print">Sudah Print</option>
                                <option value="">Belum Print</option>
                            </select>
                        </div>
                    </div>

					<div class="modal-footer">
						<button style="display: inline-block;" type="submit" class="btn btn-primary btn-sm" id="btnUpdate" value="create">Update</button>
						<button style="display: inline-block;" type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span>Cancel</span></button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
console.log("haloo brooo");
    $(".table").DataTable({
        ajax:"{{route('dashboard.show_data')}}",
        processing: false,
        bStateSave: true,
        serverSide: false,
        order: [[ 0, "desc" ]],
        columns:[
            {data:"id"},
            {data:"no_perkara"},
            {data:"pihak2_text"},
            {data:"pihak1_text"},
            {data:"jenis_perkara"},
            {data:"status_akhir"},
            {data:"tgl_putusan"},
            {data:"print"},
            {data:"id",
                mRender: function ( data ) 
                {
                    return '<a href="javascript:void(0)" class="btn btn-success btn-sm edit" data-id="'+data+'"<i class="fas fa-times edit"></i>Edit</a>';
                }
            }
        ]
    });

    $("body").on("click", ".edit", function(){
        console.log($(this).data("id"));
        
        var id_perkara = $(this).data("id");

        $.ajax({
            url:"dashboard/"+id_perkara+"/edit_status",
            type:"GET",
            datatype:"JSON",
            success:function(data){
                console.log(data.no_perkara);
                $("#id_perkara").val(id_perkara);
                $("#no_perkara").val(data.no_perkara);
                $("#status_cetak").val(data.print);
                console.log("status print "+data.print);
                $("#modalForm").modal("show");
            }
        });
    });

    $("#btnUpdate").on("click", function(e){
        e.preventDefault();
        var id_perkara = $("#id_perkara").val();
        var no_perkara = $("#no_perkara").val();

        console.log(id_perkara);
        console.log(no_perkara);
        $.ajax({
            type    : "POST",
            url     : "{{route('dashboard.update')}}",
            dataType: "JSON",
            data    : $("#statusForm").serialize(),
            success:function(data){
                $(".table").DataTable().ajax.reload(null, false);
                $("#modalForm").modal("hide");
                $.notify("Data telah di update", "success");
            }
        });
        
    });
});
</script>
@endpush

