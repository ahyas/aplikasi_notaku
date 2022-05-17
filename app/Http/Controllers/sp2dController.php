<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DetailAkunImport;
use App\Imports\DaftarSp2dImport;
use App\Akun;
use DB;
use File;
use DataTables;

class sp2dController extends Controller
{
    public function index(){
        return view("transaksi/sp2d/index");
    }

    public function show_transaksi(){
        $table=DB::table("tb_test_transaksi")
        ->where("status",0)
        ->get();
        return DataTables::of($table)->make(true);
    }

    //membaca file sp2d format .xls
    public function read_xml(Request $request){
        $file = $request->file('file_daftar_sp2d');
        Excel::import(new DaftarSp2dImport, $file);
       // menghapus data kosong yang tidak dibutuhkan
        DB::table("tb_test_transaksi")->whereNull("jenis_spm")->delete();
        //menghapus data jenis spm GUP
        DB::table("tb_test_transaksi")->where("jenis_spm","GUP")->orWhere("jenis_spm","UP")->delete();
        return redirect()->back();
    }

    public function detail_sp2d(Request $request){
        $table=DB::table("tb_test_detail_transaksi")
        ->select("tb_test_detail_transaksi.id","tb_test_detail_transaksi.no_sp2d","tb_akun.keterangan as nama_akun","tb_test_detail_transaksi.akun","tb_test_detail_transaksi.jenis_akun","tb_test_detail_transaksi.jumlah","tb_potongan.keterangan as nama_potongan")
        ->leftjoin("tb_akun", "tb_test_detail_transaksi.akun","=","tb_akun.id_akun")
        ->leftjoin("tb_potongan", "tb_test_detail_transaksi.akun","=","tb_potongan.akun")
        ->where("tb_test_detail_transaksi.no_sp2d", $request->no_sp2d)
        ->orderBy("tb_test_detail_transaksi.jumlah", "DESC")
        ->get();

        return DataTables::of($table)->make(true);
    }

    //membaca file detail akun format .xls
    public function read_excel(Request $request){
        $this->validate($request, [
            'file_detail_akun'  => 'required|mimes:xls,xlsx'
        ]);
        
        $file = $request->file('file_detail_akun');
        DB::table("tb_test_detail_transaksi")->where('no_sp2d', $request["no_sp2d"])->delete();
        Excel::import(new DetailAkunImport($request["no_sp2d"]), $file);

        $result = DB::table("tb_test_detail_transaksi")->where("no_sp2d", $request["no_sp2d"])->get();
        DB::table("tb_test_detail_transaksi")->whereNull("akun")->delete();
      
        return redirect()->back();
    
    }

    public function clear(Request $request){
        DB::table("tb_test_detail_transaksi")->where("no_sp2d",$request->no_sp2d)->delete();
        return response()->json();
    }

    public function simpan(Request $request){
        $no_sp2d = $request["no_sp2d"];
        DB::table("tb_test_transaksi")
        ->where("no_sp2d", $no_sp2d)
        ->update([
            "status"=>1
        ]);
        return response()->json($no_sp2d);
    }

    public function edit(Request $request){
        $table=DB::table("tb_test_detail_transaksi")
        ->where("id", $request->id_detail_transaksi)
        ->first();

        $parent_akun = substr($request->parent_akun, 0, 6);

        $daftar_akun=DB::table("tb_akun")
        ->where("id_akun", "like", $parent_akun."%")
        ->get();

        return response()->json(["table"=>$table,"daftar_akun"=>$daftar_akun,"parent_akun"=>$parent_akun]);
    }

    public function update(Request $request){
        DB::table("tb_test_detail_transaksi")
        ->where("id", $request->id_detail_transaksi)
        ->update([
            "akun"=>$request->id_akun
        ]);

        return response()->json();
    }

    public function delete($no_sp2d){
        DB::table("tb_test_detail_transaksi")
        ->where("no_sp2d",$no_sp2d)
        ->delete();

        DB::table("tb_test_transaksi")
        ->where("no_sp2d",$no_sp2d)
        ->delete();

        return response()->json();

    }
}
