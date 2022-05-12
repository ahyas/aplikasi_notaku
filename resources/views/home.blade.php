<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SiLontar</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link rel = "icon" href ="{{asset('public/image/lontar.png')}}" type = "image/x-icon">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #003a1e;
                
                font-family: 'Nunito', sans-serif;
                
            }

            .full-height {
                height: 80vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>

    @include('navbar')

    <div class="flex-center position-ref full-height">
    <div class="container" style="width:60%;">	
		<div class="panel" style="border:3px solid #47b686;">
			
			<div class="panel-body" style="background-image: linear-gradient(#1fa067, #168c56); padding:0px 30px 30px 30px;" >
            
                <div><br><img src="{{asset('public/image/lontar.png')}}" style="width:120px; float:left; margin-right:20px;"/>
                <h1 style="font-weight:bold; font-family:arial; font-size:60px; line-height:40px; color:white;">SiLontar</h1>
                <p style="font-weight:bold; font-family:arial; font-size:23px; font-weight:bold; color:#fdce50;">Sistem Informasi Pengelolaan Akta Cerai</p>
                </div>
                
                <hr style="border: 1.5px solid #47b686;">
                <form id="pencarianForm" name="pencarianForm" class="form-horizontal">
					{{csrf_field()}} {{method_field('POST')}}
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label style="font-size:20px; color:white; padding-bottom:10px;"><b>Masukan Nomor Perkara :</b></label>
                            <input type="text" class="form-control no_perkara" placeholder="Masukan Nomor Perkara" style="height:40px; font-size:20px; color:black" id="no_perkara" name="no_perkara" >
                        </div>
                    </div>
						<button disabled style="display: inline-block; background-image: linear-gradient(#fdce50, #eea81f); font-weight:bold; border:#efab22" type="submit" class="btn btn-primary btn-lg btn-block" id="btnCari" value="create">CARI</button>
                </form>

			</div>
			<div class="panel-footer" style="background-color:#007642; color:#ddf4e8; text-align:center; border:0">
				<b>Copyright &copy; 2021 - Pengadilan Agama Kaimana. Website: pa-kaimana.go.id</b>
			</div>
		</div>
 
	</div>

        </div>

<div class="modal fade" id="formHasilPencarian" aria-hidden="true">    
    <div class="modal-dialog">
        <div class="modal-content" style="font-size: 13px; font-family: Arial;">
            <div class="modal-header bg-info" style="background-color:#007642; color:white; font-size: 14px; border:0">
                <h3 id="addHeading" style="line-height: 0; color:white; font-weight:bold">INFO</h3>
            </div>
            <div class="modal-body" style="background-image: linear-gradient(#1fa067, #168c56); color:white">
                <p style="font-color:black; font-size:25px"><span id="result"></span></p>
                <p style="font-color:black; font-size:25px"><span id="info"></span></p>
                <div class="modal-footer">
                    <button style="background-image: linear-gradient(#fdce50, #eea81f); font-weight:bold;" type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

    </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
document.getElementById("no_perkara").focus();

$("#no_perkara").keyup(function(){
    var input = $(this).val();
    console.log(input);
    if(input==="") { 
            document.getElementById('btnCari').disabled = true; 
        } else { 
            document.getElementById('btnCari').disabled = false;
        }
});

$("#btnCari").on("click", function(e){
e.preventDefault();
    
    var no_perkara=$("#no_perkara").val();
    console.log(no_perkara);
       
    $.ajax({
        url:"{{route('dashboard.cari')}}",
        type:"POST",
        data:$("#pencarianForm").serialize(),
        datatype:"JSON",
        success:function(data){
            $("#pencarianForm").trigger("reset");
            document.getElementById("result").innerHTML=no_perkara;
            $("#formHasilPencarian").modal("show"); 
            console.log(data.table);
            if(data.table>0){
                document.getElementById("result").innerHTML="Selamat, akta perceraian dengan nomor perkara <b>"+no_perkara+"</b> telah tersedia";
                document.getElementById("info").innerHTML="Mantan Suami/Isteri atau pihak yang diberi kuasa dapat mengambil Akta Cerai tersebut di PA Kaimana dengan membawa KTP atau Kartu Identitas lain yang menampilkan foto";
            }else{
                document.getElementById("result").innerHTML="Maaf, akta perceraian dengan nomor perkara <b>"+no_perkara+"</b> belum tersedia";
                document.getElementById("info").innerHTML="";
            } 
        }
    });
});

</script>
