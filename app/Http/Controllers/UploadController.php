<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use File;
use PDF;

class UploadController extends Controller
{
    public function index(){
        $table=DB::table("tb_akun")->select("id_akun","keterangan AS akun")->get();
        $total=DB::table("tb_nota")
        ->where("id_status",">",1)
        ->whereNull("no_drpp")
        ->sum("nominal");

        return view("upload/index", compact("table","total"));
    }

    public function list_nota(Request $request){
        $table = DB::table("tb_nota")
        ->select(DB::raw("DATE_FORMAT(tb_nota.created_at, '%d-%m-%Y') as tanggal"),"tb_nota.id_subcoa","tb_nota.deskripsi","tb_nota.id","tb_nota.file","tb_nota.file_spby","tb_nota.file_kwitansi","tb_nota.id_akun","tb_nota.id_coa","tb_coa.keterangan AS detail_coa","tb_akun.keterangan AS detail_akun","tb_status.status","tb_nota.id_status","tb_nota.no_spby","tb_nota.no_kwitansi","tb_nota.nominal","tb_nota.cara_bayar")
        ->where("tb_nota.no_drpp",$request['no_drpp'])
        ->leftjoin("tb_coa", "tb_nota.id_coa","=","tb_coa.id_coa")
        ->leftjoin("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->leftJoin("tb_status","tb_nota.id_status","=","tb_status.id")
        ->orderBy("tb_nota.created_at","DESC")
        ->orderByRaw("FIELD(tb_nota.id_status , '1', '4', '2','3','5')")
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function list_gup(){
        $table=DB::table("tb_drpp")
        ->select(DB::raw("DATE_FORMAT(tgl, '%d-%m-%Y') AS tgl"), "id as id_drpp","no_drpp","file_drpp","jumlah AS total")
        ->where("status",7)
        ->get();
        
        return DataTables::of($table)->make(true);
    }

    public function upload_spby(Request $request){
        date_default_timezone_set('Asia/Jayapura');
        $request->validate([
            'file_spby' => 'required|mimes:pdf|max:5000',
        ]);
  
        $fileName = time().'.'.$request->file_spby->extension();  
   
        $request->file_spby->move(public_path('uploads/spby'), $fileName);
        $timestamp=date('Y-m-d H:i:s');

        DB::table("tb_nota")
        ->where("id",$request["id_nota2"])
        ->update([
            "file_spby"=>$fileName,
        ]);

        return back()->with('success','File SPBy '.$fileName.' berhasil diupload.');
    }

    public function upload_kwitansi(Request $request){
        $request->validate([
            'file_kwitansi' => 'required|mimes:pdf|max:5000',
        ]);
  
        $fileName = time().'.'.$request->file_kwitansi->extension();  
   
        $request->file_kwitansi->move(public_path('uploads/kwitansi'), $fileName);
        $timestamp=date('Y-m-d H:i:s');

        DB::table("tb_nota")
        ->where("id",$request["id_nota3"])
        ->update([
            "file_kwitansi"=>$fileName,
        ]);
        
        return back()->with('success','File kwitansi '.$fileName.' berhasil diupload.')->with('file',$fileName);
    }

    public function upload_drpp(Request $request){
        $request->validate([
            'file_drpp' => 'required|mimes:pdf|max:5000',
        ]);
  
        $fileName = time().'.'.$request->file_drpp->extension();  
   
        $request->file_drpp->move(public_path('uploads/drpp'), $fileName);
        $timestamp=date('Y-m-d H:i:s');

        DB::table("tb_drpp")
        ->where("id",$request["id_drpp2"])
        ->update([
            "no_drpp"=>$request["no_drpp"],
            "file_drpp"=>$fileName,
        ]);

        DB::table("tb_nota")
        ->where("no_drpp",$request["id_drpp2"])
        ->update([
            "no_drpp"=>$request["no_drpp"]
        ]);

        return back()->with('success','File DRPP '.$fileName.' berhasil diupload.')->with('file',$fileName);
    }
    
}
