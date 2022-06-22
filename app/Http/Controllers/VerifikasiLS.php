<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class VerifikasiLS extends Controller
{
    public function index(){
        return view("transaksi/ls/verifikasi_ls/index");
    }

    public function show_transaksi(){
        $table=DB::table("tb_test_transaksi")
        ->where("status",9)
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function detail_sp2d(Request $request){
        $table=DB::table("tb_test_detail_transaksi")
        ->select("tb_test_detail_transaksi.id","tb_test_detail_transaksi.no_sp2d","tb_akun.keterangan as nama_akun","tb_test_detail_transaksi.akun","tb_test_detail_transaksi.jenis_akun","tb_test_detail_transaksi.jumlah","tb_potongan.keterangan as nama_potongan")
        ->leftjoin("tb_akun", "tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->leftjoin("tb_potongan", "tb_test_detail_transaksi.akun","=","tb_potongan.akun")
        ->where("tb_test_detail_transaksi.no_sp2d", $request->no_sp2d)
        ->orderBy("tb_test_detail_transaksi.jumlah", "DESC")
        ->get();

        return DataTables::of($table)->make(true);
    }

    public function update(Request $request){
        DB::table("tb_test_detail_transaksi")
        ->where("id", $request->id_detail_transaksi)
        ->update([
            "akun"=>$request->id_akun
        ]);

        return response()->json();
    }

    public function simpan(Request $request){
        $no_sp2d = $request["no_sp2d"];
        DB::table("tb_test_transaksi")
        ->where("no_sp2d", $no_sp2d)
        ->update([
            "status"=>10
        ]);
        return response()->json();
    }
    
}
