<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use File;

class BendaharaController extends Controller
{
    public function index(){
        $table=DB::table("tb_akun")->select("id_akun","keterangan AS akun")->get();
        $total=DB::table("tb_nota")
        ->where("id_status",">",1)
        ->whereNull("no_drpp")
        ->sum("nominal");
        return view("nota/bendahara/index", compact("table","total"));
    }

    public function ShowData(){
        $table=DB::table("tb_nota")
        ->select(DB::raw("DATE_FORMAT(tb_nota.created_at, '%d-%m-%Y') as tanggal"),"tb_nota.id_subcoa","tb_nota.deskripsi","tb_nota.id","tb_nota.file","tb_nota.file_spby","tb_nota.file_kwitansi","tb_nota.id_akun","tb_nota.id_coa","tb_coa.keterangan AS detail_coa","tb_akun.keterangan AS detail_akun","tb_status.status","tb_nota.id_status","tb_nota.no_spby","tb_nota.no_kwitansi","tb_nota.nominal","tb_nota.cara_bayar")
        ->whereNull("tb_nota.no_drpp")
        ->leftjoin("tb_coa", "tb_nota.id_coa","=","tb_coa.id_coa")
        ->leftjoin("tb_akun","tb_nota.id_akun","=","tb_akun.id_akun")
        ->leftJoin("tb_status","tb_nota.id_status","=","tb_status.id")
        ->orderBy("tb_nota.created_at","DESC")
        ->orderByRaw("FIELD(tb_nota.id_status , '1', '4', '2','3','5')")
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function upload(Request $request){
        date_default_timezone_set('Asia/Jayapura');
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv|max:5000',
        ]);
  
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads'), $fileName);
        $timestamp=date('Y-m-d H:i:s');

        DB::table("tb_nota")
        ->insert([
            "file"=>$fileName,
            "created_at"=>$timestamp,
            "updated_at"=>$timestamp,
        ]);
        return back()->with('success','File nota '.$fileName.' berhasil di upload');
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

    public function getCOA($id_akun){
        $table=DB::table("tb_coa")
        ->select("id_akun","id_coa","keterangan AS detail_coa")
        ->where("id_akun",$id_akun)
        ->get();
        $baris=$table->count();
        return response()->json(["detail_coa"=>$table,"baris"=>$baris]);
    }

    public function getDetailAkun(Request $request){

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
        date_default_timezone_set('Asia/Jayapura');
        $input_sakti=$request["input_sakti"];
        if($input_sakti==1){
            $id_status=3;
        }else{
            $id_status=4;
        }

        $timestamp=date('Y-m-d H:i:s');
        DB::table("tb_nota")
        ->where("id",$request["id_nota"])
        ->update([
            "id_status"=>$id_status,
            "no_kwitansi"=>$request["no_kwitansi"],
            "no_spby"=>$request["no_spby"],
            "cara_bayar"=>$request["cbayar"],
            "nominal"=>$request["nominal"],
            "updated_at"=>$timestamp,
        ]);

        $table=DB::table("tb_nota")
        ->where("id_status",">",1)
        ->whereNull("no_drpp")
        ->sum("tb_nota.nominal");

        $total=number_format("$table",2,",",".");

        return response()->json(["total"=>$total]);
    }

    public function delete($id_nota){
        $table=DB::table("tb_nota")->where("id",$id_nota)
        ->first();

        if(File::exists(public_path('uploads/'.$table->file))){
            DB::table("tb_nota")
            ->where("id",$id_nota)
            ->delete();

            File::delete(public_path('uploads/'.$table->file));   
        }

        return response()->json();
    }
}
