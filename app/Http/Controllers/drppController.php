<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class drppController extends Controller
{
    //

    public function index(){
        $max_no_drpp = DB::table("tb_drpp")->max("id");
        if($max_no_drpp==0){
            $id_drpp = 1;
        }else{
            $id_drpp = $max_no_drpp + 1;
        }
        $total = DB::table("tb_nota")
        ->where("no_drpp",$no_drpp)
        ->sum("nominal");

        return view("transaksi/drpp/index", compact("id_drpp","total"));
    }

    public function show_list(){
        $max_no_drpp = DB::table("tb_drpp")->max("id");
        if($max_no_drpp==0){
            $id_drpp = 1;
        }else{
            $id_drpp = $max_no_drpp + 1;
        }

        $table=DB::table("tb_nota")
        ->where("no_drpp",$no_drpp)
        ->select("tb_nota.id","tb_nota.id_akun","tb_akun.keterangan AS nama_akun","tb_coa.keterangan AS coa","tb_nota.deskripsi","tb_nota.nominal")
        ->leftJoin("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->leftJoin("tb_coa","tb_nota.id_coa","=","tb_coa.id_coa")
        ->get();

        return DataTables::of($table)->make(true);
    }

    public function daftar_nota(){
        $table=DB::table("tb_nota")
        ->whereNull("no_drpp")
        ->where("id_status",2)
        ->select("tb_nota.id","tb_nota.no_spby","tb_nota.id_akun","tb_akun.keterangan AS nama_akun","tb_nota.id_akun","tb_coa.keterangan AS coa","tb_nota.deskripsi","tb_nota.nominal")
        ->leftJoin("tb_coa","tb_nota.id_coa","=","tb_coa.id_coa")
        ->leftJoin("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function update_no_drpp(Request $request){
        return DB::table("tb_nota")
        ->where("id",$request["id_nota"])
        ->update([
            "id"=>$request["no_drpp"]
        ]);
    }

    public function input_nota(Request $request){
        DB::table("tb_nota")
        ->where("id",$request["id_nota"])
        ->update([
            "no_drpp"=>$request["no_drpp"]
        ]);

        $total = DB::table("tb_nota")
        ->where("no_drpp",$request["no_drpp"])
        ->sum("nominal");

        $jml_nota = DB::table("tb_nota")
        ->whereNull("no_drpp")
        ->where("id_status",2)
        ->count();

        return response()->json(["total"=>$total,"jml_nota"=>$jml_nota]);
    }

    public function hapus_nota(Request $request){
        DB::table("tb_nota")
        ->where("id",$request["id_nota"])
        ->update([
            "no_drpp"=>NULL
        ]);

        $jml_nota = DB::table("tb_nota")
        ->where("no_drpp",$request["no_drpp"])
        ->count();

        $total = DB::table("tb_nota")
        ->where("no_drpp",$request["no_drpp"])
        ->sum("nominal");

        return response()->json(["total"=>$total,"jml_nota"=>$jml_nota]);
    }

    public function simpan_drpp(Request $request){
        date_default_timezone_set('Asia/Jayapura');
        $timestamp=date('Y-m-d H:i:s');

        $total = DB::table("tb_nota")
        ->where("no_drpp",$request["no_drpp"])
        ->sum("nominal");
        
        DB::table("tb_drpp")
        ->insert([
            "id"=>$request["no_drpp"],
            "tgl"=>$timestamp,
            "jumlah"=>$total,
            "status"=>6
        ]);

        $last_id=DB::table("tb_drpp")->max("no_drpp");
        $new_id=$last_id+1;
        return response()->json($new_id);
    }

}
