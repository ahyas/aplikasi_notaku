<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class TestController extends Controller
{

    public function show_data(){
        $table=DB::table("tb_test")->get();
        return DataTables::of($table)->make(true);
    }

    public function index(){
         //mengambil transaksi sp2d
         $d = DB::table("tb_test_detail_transaksi")
         ->select(DB::raw('SUBSTR(tb_test_transaksi.tanggal, 5,1) as num_bulan'),"tb_jenis_akun.keterangan as keterangan_akun","tb_jenis_akun.id as id_jenis_akun","tb_akun.jenis_akun","tb_akun.id_akun AS id_akun", "tb_test_detail_transaksi.jumlah as total_nominal","tb_test_detail_transaksi.id_coa")
         ->where("tb_test_detail_transaksi.jumlah",">",0)
         //->where("tb_test_transaksi.status",1)
         ->where("tb_akun.jenis_akun",2)
        // ->where("tb_test_detail_transaksi.id_coa",24)
         //->where(DB::raw('SUBSTR(tb_test_transaksi.tanggal, 5,1)'), 3)
         ->join("tb_test_transaksi","tb_test_detail_transaksi.no_sp2d","=","tb_test_transaksi.no_sp2d")
         ->join("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
         ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id");
         //->get();
 
         $tb_transaksi_akun2 = DB::table("tb_test_detail_transaksi")
         ->select(DB::raw('SUBSTR(tb_test_transaksi.tanggal, 5,1) as num_bulan'),"tb_jenis_akun.keterangan as keterangan_akun","tb_jenis_akun.id as id_jenis_akun","tb_akun.jenis_akun","tb_akun.id_akun AS id_akun", "tb_test_detail_transaksi.jumlah as total_nominal","tb_test_detail_transaksi.id_coa")
         ->where("tb_test_detail_transaksi.jumlah",">",0)
         //->where("tb_test_transaksi.status",1)
         ->where("tb_akun.jenis_akun",2)
        // ->where("tb_test_detail_transaksi.id_coa",24)
         //->where(DB::raw('SUBSTR(tb_test_transaksi.tanggal, 5,1)'), 3)
         ->join("tb_test_transaksi","tb_test_detail_transaksi.no_sp2d","=","tb_test_transaksi.no_sp2d")
         ->join("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
         ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id")
         ->get();
 
         //mengambil transaksi nota
         $tb_transaksi_akun=DB::table("tb_nota")
         ->select(DB::raw('SUBSTR(tb_nota.created_at, 7,1) as num_bulan'),"tb_jenis_akun.keterangan as keterangan_akun","tb_jenis_akun.id as id_jenis_akun", "tb_akun.jenis_akun","tb_akun.id_akun AS id_akun", "tb_nota.nominal as total_nominal","tb_nota.id_coa")
         ->whereNotNull("tb_nota.no_drpp")
         ->where("tb_akun.jenis_akun",2)
         ->where(DB::raw('SUBSTR(tb_nota.created_at, 7,1)'), 3)
         ->where("tb_nota.id_coa",24)
         ->join("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
         ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id")
         ->unionAll($d)
         ->get();

        return view("test/index", compact("tb_transaksi_akun","tb_transaksi_akun2"));
    }
}
