<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class DashboardController extends Controller
{
    public function laporan_1(){
        $table = DB::table("tb_sub_komponen")
        ->select("keterangan AS nama_komponen")
        ->get();

        $tb_nota = DB::table("tb_nota")
        ->where("tb_nota.id_status",3)
        ->join("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->join("tb_sub_komponen","tb_akun.id_sub_komponen","=","tb_sub_komponen.id")
	    ->select("tb_akun.id_sub_komponen","tb_sub_komponen.kode","tb_sub_komponen.keterangan", DB::raw("SUM(tb_nota.nominal) as realisasi_akun"))
	    ->groupBy("tb_akun.id_sub_komponen");

        $tb_sp2d = DB::table("tb_test_detail_transaksi")
        ->where("tb_test_detail_transaksi.jumlah",">",0)
        ->join("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->join("tb_sub_komponen","tb_akun.id_sub_komponen","=","tb_sub_komponen.id")
	    ->select("tb_akun.id_sub_komponen", "tb_sub_komponen.kode","tb_sub_komponen.keterangan", DB::raw("SUM(tb_test_detail_transaksi.jumlah) as realisasi_akun"))
	    ->groupBy("tb_akun.id_sub_komponen")
        ->unionAll($tb_nota)
	    ->get();

        $baris = $table->count();

        return response()->json(["table"=>$table, "baris"=>$baris, "tb_nota"=>$tb_nota, "tb_sp2d"=>$tb_sp2d]);
    }
}
