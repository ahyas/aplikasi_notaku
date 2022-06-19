<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use File;

class VerifikatorController extends Controller
{
    //

    public function index(){
        return view("dashboard/index");
    }

    public function verifikasi_nota(){
        $table=DB::table("tb_akun")->select("id_akun","keterangan AS akun")->get();
        $total=DB::table("tb_nota")
        ->whereNull("no_drpp")
        ->where("id_status",">",1)
        ->sum("nominal");

        $total_saldo = 30000000-$total;

        $prosentase_capaian_gup=number_format(($total/30000000)*100, 2, '.', '');
        return view("transaksi/nota/verifikator/index", compact("table","total","prosentase_capaian_gup","total_saldo"));
    }

    public function ShowData(){
        $table=DB::table("tb_nota")
        ->select(DB::raw("DATE_FORMAT(tb_nota.created_at, '%d-%m-%Y') as tanggal"),"tb_nota.no_kwitansi","tb_nota.id_subcoa", "tb_nota.deskripsi","tb_nota.id","tb_nota.file","tb_nota.file_spby","tb_nota.file_kwitansi","tb_nota.id_akun","tb_nota.id_coa","tb_coa.keterangan AS detail_coa","tb_akun.keterangan AS detail_akun","tb_status.status","tb_nota.id_status","tb_nota.no_spby","tb_nota.nominal","tb_nota.cara_bayar")
        ->where("tb_nota.id_status",">",1)
        ->whereNull("tb_nota.no_drpp")
        ->leftjoin("tb_coa", "tb_nota.id_coa","=","tb_coa.id_coa")
        ->leftjoin("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->leftJoin("tb_status","tb_nota.id_status","=","tb_status.id")
        ->orderBy("tb_nota.created_at","DESC")
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function upload(Request $request){
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);
  
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads'), $fileName);

        DB::table("tb_nota")
        ->insert([
            "file"=>$fileName
        ]);
        return back()->with('success','You have successfully upload file.')->with('file',$fileName);
    }

    public function getCOA($id_akun){
        $table=DB::table("tb_coa")
        ->select("id_akun","id_coa","keterangan AS detail_coa")
        ->where("id_akun",$id_akun)
        ->get();
        $baris=$table->count();
        return response()->json(["detail_coa"=>$table,"baris"=>$baris]);
    }

    public function getDetailCOA(Request $request){

        $detail_coa=DB::table("tb_coa")
        ->where("id_akun",$request["id_akun"])
        ->get();

        $baris_coa=$detail_coa->count();

        $detail_subcoa=DB::table("tb_sub_coa")
        ->where("id_coa",$request["id_coa"])
        ->get();

        $baris_subcoa=$detail_subcoa->count();

        return response()->json(["detail_coa"=>$detail_coa,"baris_coa"=>$baris_coa,"detail_subcoa"=>$detail_subcoa,"baris_subcoa"=>$baris_subcoa]);
    }

    public function update(Request $request){
        DB::table("tb_nota")
        ->where("id",$request["id_nota"])
        ->update([
            "id_akun"=>$request["akun"],
            "id_coa"=>$request["desc_coa"],
            "id_subcoa"=>$request["desc_subcoa"],
            "deskripsi"=>$request["deskripsi"],
            "id_status"=>2,
            "nominal"=>$request["nominal"],
            "cara_bayar"=>$request["cara_bayar"]
        ]);
        return response()->json();
    }

    public function getSubCOA($id_coa){
        $table=DB::table("tb_sub_coa")
        ->select("id_coa","id_subcoa","keterangan AS nama_subcoa")
        ->where("id_coa",$id_coa)
        ->get();
        $baris=$table->count();

        return response()->json(["table"=>$table, "baris"=>$baris]);
    }

}
