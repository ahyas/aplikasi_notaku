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
        $jumlah_nota_masuk = DB::table("tb_nota")
        ->where("tb_nota.id_status",4)
        ->whereNull("tb_nota.no_drpp")
        ->count();

        $jumlah_sp2d_masuk = DB::table("tb_test_transaksi")
        ->where("status",9)
        ->count();

        $jumlah_drpp_masuk = DB::table("tb_drpp")
        ->where("status",6)
        ->select("no_drpp","tgl","jumlah AS total")
        ->count();

        return view("dashboard/index", compact("jumlah_nota_masuk","jumlah_sp2d_masuk","jumlah_drpp_masuk"));
    }

    public function verifikasi_nota(){
        $nota_belum_drpp = DB::table("tb_nota")
        ->whereNull("no_drpp")
        ->count();

        if($nota_belum_drpp==0){
            $last_drpp = DB::table("tb_drpp")->max("id");
            $sum = DB::table("tb_drpp")
            ->where("id", $last_drpp)
            ->first();

            $total = $sum->jumlah;
            $total_saldo = 30000000-$total;

        }else{
            $sum = DB::table("tb_nota")
            ->whereNull("no_drpp")
            ->sum("nominal");

            $total = $sum;
            $total_saldo = 30000000-$total;

        }


        $table=DB::table("tb_akun")
        ->select("id_akun","keterangan AS akun")
        ->get();

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

    public function hitung_saldo_akun($id_akun){

        if($id_akun <> 0){
            $realisasi_akun=DB::table("tb_nota")
            ->whereNotNull("tb_nota.no_drpp")
            ->where("id_akun",$id_akun)
            ->groupBy("tb_nota.id_akun")
            ->sum("tb_nota.nominal");

            $pagu_akun = DB::table("tb_akun")
            ->select("pagu")
            ->where("id_akun",$id_akun)
            ->first();

            $saldo = number_format($pagu_akun->pagu - $realisasi_akun, 2);

            return $saldo;
        }else{
            return 0;
        }

    }

    public function hitung_saldo_coa($id_coa){
        if($id_coa <> 0){
            $realisasi_coa=DB::table("tb_nota")
            ->whereNotNull("tb_nota.no_drpp")
            ->where("id_akun",$id_coa)
            ->groupBy("tb_nota.id_coa")
            ->sum("tb_nota.nominal");

            $pagu_coa = DB::table("tb_coa")
            ->select("pagu")
            ->where("id_coa",$id_coa)
            ->first();

            $saldo = number_format($pagu_coa->pagu - $realisasi_coa, 2);

            return $saldo;

        }else{
            return 0;
        }

    }

    public function getCOA($id_akun){
        $table=DB::table("tb_coa")
        ->select("id_akun","id_coa","keterangan AS detail_coa")
        ->where("id_akun",$id_akun)
        ->get();

        $saldo_akun = self::hitung_saldo_akun($id_akun);

        $baris=$table->count();
        return response()->json(["detail_coa"=>$table,"baris"=>$baris,"saldo_akun"=>$saldo_akun]);
    }

    public function getDetailCOA(Request $request){

        $saldo_akun = self::hitung_saldo_akun($request["id_akun"]);
        $saldo_coa = self::hitung_saldo_coa($request["id_coa"]);

        $detail_coa=DB::table("tb_coa")
        ->where("id_akun",$request["id_akun"])
        ->get();

        $baris_coa=$detail_coa->count();

        $detail_subcoa=DB::table("tb_sub_coa")
        ->where("id_coa",$request["id_coa"])
        ->get();

        $baris_subcoa=$detail_subcoa->count();

        return response()->json(["detail_coa"=>$detail_coa,"baris_coa"=>$baris_coa,"detail_subcoa"=>$detail_subcoa,"baris_subcoa"=>$baris_subcoa, "saldo_akun"=>$saldo_akun, "saldo_coa"=>$saldo_coa]);
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
        $saldo_coa = self::hitung_saldo_coa($id_coa);

        $table=DB::table("tb_sub_coa")
        ->select("id_coa","id_subcoa","keterangan AS nama_subcoa")
        ->where("id_coa",$id_coa)
        ->get();
        $baris=$table->count();

        return response()->json(["table"=>$table, "baris"=>$baris,"saldo_coa"=>$saldo_coa]);
    }

}
