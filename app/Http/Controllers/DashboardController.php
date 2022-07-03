<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class DashboardController extends Controller
{
    public function laporan_1(){
        $table_sub_komponen = DB::table("tb_sub_komponen")
        ->select("id","kode","keterangan AS nama_komponen","pagu")
        ->get();

        $tb_nota = DB::table("tb_nota")
        ->where("tb_nota.id_status",3)
        ->whereNotNull("tb_nota.no_drpp")
        ->join("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->join("tb_sub_komponen","tb_akun.id_sub_komponen","=","tb_sub_komponen.id")
	    ->select("tb_akun.id_sub_komponen","tb_sub_komponen.kode","tb_sub_komponen.keterangan AS nama_komponen", DB::raw("SUM(tb_nota.nominal) as realisasi_akun"))
	    ->groupBy("tb_sub_komponen.id");

        $merge_table = DB::table("tb_test_detail_transaksi")
        ->where("tb_test_detail_transaksi.jumlah",">",0)
        ->where("tb_test_transaksi.status",10)
        ->join("tb_test_transaksi","tb_test_detail_transaksi.no_sp2d","=","tb_test_transaksi.no_sp2d")
        ->join("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->join("tb_sub_komponen","tb_akun.id_sub_komponen","=","tb_sub_komponen.id")
	    ->select("tb_akun.id_sub_komponen", "tb_sub_komponen.kode","tb_sub_komponen.keterangan AS nama_komponen", DB::raw("SUM(tb_test_detail_transaksi.jumlah) as realisasi_akun"))
	    ->groupBy("tb_sub_komponen.id")
        ->union($tb_nota)
	    ->get();

        $baris = $merge_table->count();

        return response()->json(["table_sub_komponen"=>$table_sub_komponen, "baris"=>$baris, "tb_nota"=>$tb_nota, "merge_table"=>$merge_table]);
    }

    public function laporan_2(){
        $tb_nota = DB::table("tb_nota")
        ->where("tb_nota.id_status",3)
        ->whereNotNull("tb_nota.no_drpp")
	    
        ->sum("tb_nota.nominal");

        $merge_table = DB::table("tb_test_detail_transaksi")
        ->where("tb_test_detail_transaksi.jumlah",">",0)
        ->where("tb_test_transaksi.status",10)
        ->join("tb_test_transaksi","tb_test_detail_transaksi.no_sp2d","=","tb_test_transaksi.no_sp2d")
	    
	    ->sum("tb_test_detail_transaksi.jumlah");

        $total_realisasi = $tb_nota + $merge_table;
        
        return response()->json($total_realisasi);
    }

    public function kondisi_kas(){
        $nota_belum_drpp = DB::table("tb_nota")
        ->whereNull("no_drpp")
        ->count();

        if($nota_belum_drpp==0){
            $last_drpp = DB::table("tb_drpp")->max("id");
            $table = DB::table("tb_drpp")
            ->where("id", $last_drpp)
            ->first();

        }else{
            $table = DB::table("tb_nota")
            ->whereNull("no_drpp")
            ->sum("nominal");
        }

        return response()->json(["table"=>$table, "nota_belum_drpp"=>$nota_belum_drpp]);
    }
}
