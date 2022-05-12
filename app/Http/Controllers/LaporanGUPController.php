<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class LaporanGUPController extends Controller
{
    public function index(){
        return view("laporan/gup/index");
    }    

    public function list_gup(){
        $table=DB::table("tb_drpp")
        ->select("no_drpp","tgl","jumlah AS total")
        ->get();
        
        return DataTables::of($table)->make(true);
    }

    public function list_nota(Request $request){
        $table=DB::table("tb_nota")
        ->where("no_drpp",$request['no_drpp'])
        ->get();

        return DataTables::of($table)->make(true);
    }
}
