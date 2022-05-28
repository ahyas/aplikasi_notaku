<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use File;

class LaporanController extends Controller
{
    public function index(){
        
        return view("laporan/rekap_akun/index");
    }

    public function show_data(){
        $tb_transaksi_nota=DB::table("tb_nota")
        ->select("tb_jenis_akun.keterangan as keterangan_akun", "tb_akun.jenis_akun","tb_akun.pagu AS pagu_akun","tb_akun.id_akun AS id_akun","tb_akun.keterangan AS nama_akun", DB::raw("SUM(tb_nota.nominal) as total_nominal"), DB::raw("((SUM(tb_nota.nominal)/tb_akun.pagu)*100) AS realisasi_akun"))
        ->whereNotNull("tb_nota.no_drpp")
        ->join("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id")
        ->groupBy("tb_akun.jenis_akun","tb_akun.pagu","tb_nota.id_akun", "tb_akun.id_akun","tb_akun.keterangan");

        //menggabungkan 2 tabel menjadi satu
        $tb_transaksi_akun = DB::table("tb_test_detail_transaksi")
        ->select("tb_jenis_akun.keterangan as keterangan_akun","tb_akun.pagu as jenis_akun", "tb_akun.pagu as pagu_akun","tb_akun.id_akun AS id_akun", "tb_akun.keterangan as nama_akun", DB::raw("SUM(tb_test_detail_transaksi.jumlah) as total_nominal"), DB::raw("SUM(tb_test_detail_transaksi.jumlah/tb_akun.pagu) as realisasi_akun"))
        ->join("tb_test_transaksi","tb_test_detail_transaksi.no_sp2d","=","tb_test_transaksi.no_sp2d")
        ->join("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id")
        ->groupBy("tb_test_detail_transaksi.akun")
        ->union($tb_transaksi_nota)
        ->get();

        return DataTables::of($tb_transaksi_akun)->make(true);
    }

    public function print(){
        $tb_transaksi_akun=DB::table("tb_nota")
        ->select(DB::raw('SUBSTR(tb_nota.created_at, 7,1) as num_bulan'),"tb_jenis_akun.keterangan as keterangan_akun","tb_jenis_akun.id as id_jenis_akun", "tb_akun.jenis_akun","tb_akun.id_akun AS id_akun", "tb_nota.nominal as total_nominal","tb_nota.id_coa")
        ->whereNotNull("tb_nota.no_drpp")
        ->join("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id")
        ->get();

        $tb_transaksi_akun2 = DB::table("tb_test_detail_transaksi")
        ->select(DB::raw('SUBSTR(tb_test_transaksi.tanggal, 5,1) as num_bulan'),"tb_jenis_akun.keterangan as keterangan_akun","tb_jenis_akun.id as id_jenis_akun","tb_akun.jenis_akun","tb_akun.id_akun AS id_akun", "tb_test_detail_transaksi.jumlah as total_nominal")
        ->where("tb_test_detail_transaksi.jumlah",">",0)
        ->where("tb_test_transaksi.status",1)
        ->join("tb_test_transaksi","tb_test_detail_transaksi.no_sp2d","=","tb_test_transaksi.no_sp2d")
        ->join("tb_akun","tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->join("tb_jenis_akun","tb_akun.jenis_akun","=","tb_jenis_akun.id")
        ->get();

        $jenis_akun = DB::table("tb_jenis_akun")->get();

        $daftar_akun = DB::table("tb_akun")->get();

        $daftar_coa = DB::table("tb_coa")->get();

        return view("laporan/rekap_akun/print", compact("tb_transaksi_akun","tb_transaksi_akun2","daftar_akun","jenis_akun","daftar_coa"));
    }

    public function daftar_coa($id_akun){
        $table=DB::table("tb_nota")
        ->select("tb_coa.id_coa","tb_coa.pagu as pagu_kegiatan","tb_nota.id_akun","tb_coa.keterangan as nama_coa",DB::raw("SUM(tb_nota.nominal) as nominal"), DB::raw("((SUM(tb_nota.nominal)/tb_coa.pagu)*100) AS realisasi_kegiatan"))
        ->whereNotNull("tb_nota.no_drpp")
        ->where("tb_nota.id_akun",$id_akun)
        ->join("tb_coa","tb_nota.id_coa","=","tb_coa.id_coa","left outer")
        ->groupBy("tb_nota.id_akun")
        ->get();
        
        return DataTables::of($table)->make(true);
    }

    public function detail_coa(Request $request){
        $table=DB::table("tb_nota")
        ->select(DB::raw("SUBSTR(tb_nota.created_at,1,10) as tanggal"), "tb_nota.nominal","tb_nota.deskripsi","tb_nota.no_spby","tb_nota.file")
        ->whereNotNull("tb_nota.no_drpp")
        ->where("tb_nota.id_akun",$request["id_akun"])
        ->get();

        return DataTables::of($table)->make(true);
    }
    
}
