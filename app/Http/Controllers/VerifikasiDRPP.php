<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class VerifikasiDRPP extends Controller
{
    public function index(){
        return view("transaksi/drpp/verifikasi_drpp/index");
    }

    public function list_gup(){
        $table=DB::table("tb_drpp")
        ->where("status",6)
        ->select("id",DB::raw("DATE_FORMAT(tgl, '%d-%m-%Y') as tgl"),"jumlah AS total", "no_drpp")
        ->get();
        
        return DataTables::of($table)->make(true);
    }

    public function list_nota(Request $request){

        $table = DB::table("tb_nota")
        ->select(DB::raw("DATE_FORMAT(tb_nota.updated_at, '%d-%m-%Y') as tanggal"),"tb_nota.id_subcoa","tb_nota.deskripsi","tb_nota.id","tb_nota.file","tb_nota.file_spby","tb_nota.file_kwitansi","tb_nota.id_akun","tb_nota.id_coa","tb_coa.keterangan AS detail_coa","tb_akun.keterangan AS nama_akun","tb_status.status","tb_nota.id_status","tb_nota.no_spby","tb_nota.no_kwitansi","tb_nota.nominal","tb_nota.cara_bayar")
        ->where("tb_nota.no_drpp",$request['id_drpp'])
        ->leftjoin("tb_coa", "tb_nota.id_coa","=","tb_coa.id_coa")
        ->leftjoin("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->leftJoin("tb_status","tb_nota.id_status","=","tb_status.id")
        ->orderBy("tb_nota.created_at","DESC")
        ->orderByRaw("FIELD(tb_nota.id_status , '1', '4', '2','3','5')")
        ->get();

        return DataTables::of($table)->make(true);
    }

    public function setuju_drpp(Request $request){

        $table = DB::table("tb_drpp")
        ->where("id", $request["id_drpp"])
        ->update([
            "status"=>7
        ]);

        return response()->json($table);
    }
    
}
