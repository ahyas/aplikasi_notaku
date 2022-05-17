<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class LaporanGUPController extends Controller
{
    public function index(){
        return view("laporan/gup/index");
    }    

    public function list_gup(){
        $table=DB::table("tb_drpp")
        ->select("no_drpp","tgl","jumlah AS total")
        ->get();
        
        return DataTables::of($table)->make(true);
    }

    public function list_nota(Request $request){
        $table=DB::table("tb_nota")
        ->where("tb_nota.no_drpp",$request['no_drpp'])
        ->select("tb_nota.file","tb_nota.no_spby", "tb_nota.id_akun","tb_nota.deskripsi","tb_nota.nominal","tb_nota.id","tb_akun.keterangan AS nama_akun")
        ->leftJoin("tb_akun", "tb_nota.id_akun","=","tb_akun.id_akun")
        ->get();

        return DataTables::of($table)->make(true);
    }
}
