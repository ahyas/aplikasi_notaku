<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class LaporanSP2DController extends Controller
{
    public function index(){
        return view("laporan/sp2d/index");
    }

    public function show_daftar_sp2d(){
        $table = DB::table("tb_test_transaksi")
        ->where("status",10)
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function show_daftar_akun(Request $request){
        $table = DB::table("tb_test_detail_transaksi")
        ->where("tb_test_detail_transaksi.no_sp2d",$request->no_sp2d)
        ->select("tb_potongan.keterangan as nama_potongan","tb_test_detail_transaksi.id","tb_test_detail_transaksi.akun","tb_test_detail_transaksi.jumlah","tb_test_detail_transaksi.jenis_akun","tb_akun.keterangan AS nama_akun")
        ->leftJoin("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->leftJoin("tb_potongan","tb_test_detail_transaksi.akun","=","tb_potongan.akun")
        ->orderBy("tb_test_detail_transaksi.jumlah", "DESC")
        ->get();
        return DataTables::of($table)->make(true);
    }
}
