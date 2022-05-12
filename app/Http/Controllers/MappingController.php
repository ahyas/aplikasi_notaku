<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use File;

class MappingController extends Controller
{
    public function index(){
        return view("mapping/index");
    }

    public function getDaftarAkun(){
        $table=DB::table("tb_akun")->get();
        return DataTables::of($table)->make(true);
    }

    public function edit_akun(Request $request){
        $table=DB::table("tb_akun")
        ->where("id",$request["id_akun"])
        ->first();
        return response()->json($table);
    }

    public function update_akun(Request $request){
        $find=DB::table("tb_akun")
        ->where("id","<>",$request["id_akun"])
        ->where("id_akun", $request["akun"])
        ->count();

        if($find==0){
            DB::table("tb_akun")
            ->where("id",$request["id_akun"])
            ->update([
                "id_akun"=>$request["akun"],
                "keterangan"=>$request["keterangan_akun"],
                "pagu"=>$request["pagu_akun"]
            ]);   
        }

        return response()->json($find);
    }

    public function getDaftarCOA($id_akun){
        $table=DB::table("tb_coa")
        ->where("id_akun",$id_akun)
        ->get();
        return DataTables::of($table)->make(true);
    }

    public function saveCOA(Request $request){
        $max_id=DB::table("tb_coa")
        ->max("id_coa");

        DB::table("tb_coa")
        ->insert([
            "id_akun"=>$request["id_akun2"],
            "id_coa"=>$max_id+1,
            "keterangan"=>$request["nama_coa"],
            "pagu"=>$request["pagu_coa"]
        ]);
        return response()->json();
    }

    public function deleteCOA(Request $request){
        DB::table("tb_coa")
        ->where("id_coa",$request["id_coa"])
        ->delete();
        
        DB::table("tb_sub_coa")
        ->where("id_coa",$request["id_coa"])
        ->delete();

        return response()->json();
    }

    public function editCOA(Request $request){
        $table=DB::table("tb_coa")
        ->select("pagu","keterangan")
        ->where("id_coa",$request["id_coa"])
        ->first();
        return response()->json($table);
    }

    public function updateCOA(Request $request){
        $table=DB::table("tb_coa")
        ->where("id_coa",$request["id_coa"])
        ->update([
            "keterangan"=>$request["nama_coa"],
            "pagu"=>$request["pagu_coa"]
        ]);
        return response()->json($table);
    }

    public function getDaftarSubCOA($id_coa){
        $table=DB::table("tb_sub_coa")
        ->where("id_coa",$id_coa)
        ->get();

        return DataTables::of($table)->make(true);
    }

    public function saveSubCOA(Request $request){
        $max_id=DB::table("tb_sub_coa")
        ->max("id_subcoa");

        DB::table("tb_sub_coa")
        ->insert([
            "id_coa"=>$request["id_coa2"],
            "id_subcoa"=>$max_id+1,
            "keterangan"=>$request["nama_subcoa"]
        ]);
        return response()->json();
    }

    public function deleteSubCOA(Request $request){
        DB::table("tb_sub_coa")
        ->where("id_subcoa",$request["id_subcoa"])
        ->delete();
        return response()->json();
    }

    public function updateSubCOA(Request $request){
        DB::table("tb_sub_coa")
        ->where("id_subcoa",$request["id_subcoa"])
        ->update([
            "keterangan"=>$request["nama_subcoa"]
        ]);
        return response()->json();
    }

    public function editSubCOA(Request $request){
        $table=DB::table("tb_sub_coa")
        ->where("id_subcoa",$request["id_subcoa"])
        ->select("keterangan")
        ->first();
        return response()->json($table);
    }
}
