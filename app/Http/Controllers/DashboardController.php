<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class DashboardController extends Controller
{
    public function index(){
        $table=DB::table("pakaiman_dbsilontar.tb_test")->get();
        $table2=DB::table("pakaiman_db_sipp410.dataumumweb")->limit(100)->get();
        return view("dashboard/index", compact("table", "table2"));
    }

    public function show_data(){
        $table=DB::table("pakaiman_db_sipp410.dataumumweb")
        ->select("pakaiman_db_sipp410.dataumumweb.IDPerkara as id","pakaiman_db_sipp410.dataumumweb.noPerkara as no_perkara","pakaiman_db_sipp410.jenisperkaraweb.nama as jenis_perkara", "pakaiman_db_sipp410.dataumumweb.statusAkhir as status_akhir","pakaiman_db_sipp410.dataumumweb.tglPutusan as tgl_putusan","pakaiman_dbsilontar.tb_print_akta.print","pakaiman_db_sipp410.perkara.pihak1_text","pakaiman_db_sipp410.perkara.pihak2_text")
        ->join("pakaiman_db_sipp410.jenisperkaraweb", "pakaiman_db_sipp410.dataumumweb.IDJenisPerkara","=","pakaiman_db_sipp410.jenisperkaraweb.id")
        //->leftjoin("pakaiman_db_sipp410.perkaraprosesweb", "pakaiman_db_sipp410.dataumumweb.IDProses","=","pakaiman_db_sipp410.perkaraprosesweb.IDProses")
        ->leftJoin("pakaiman_dbsilontar.tb_print_akta", "pakaiman_dbsilontar.tb_print_akta.id_perkara","=","pakaiman_db_sipp410.dataumumweb.IDPerkara")
        ->leftJoin("pakaiman_db_sipp410.perkara", "pakaiman_db_sipp410.dataumumweb.IDPerkara","=","pakaiman_db_sipp410.perkara.perkara_id")
        ->where("pakaiman_db_sipp410.dataumumweb.IDProses","=","296")
        ->get();

        return DataTables::of($table)->make(true);
    }
    
    public function cari(Request $request){
        $table=DB::table("pakaiman_db_sipp410.dataumumweb")
        ->select("pakaiman_db_sipp410.dataumumweb.IDPerkara as id","pakaiman_db_sipp410.dataumumweb.noPerkara as no_perkara","pakaiman_db_sipp410.jenisperkaraweb.nama as jenis_perkara", "pakaiman_db_sipp410.dataumumweb.statusAkhir as status_akhir","pakaiman_db_sipp410.dataumumweb.tglPutusan as tgl_putusan","pakaiman_dbsilontar.tb_print_akta.print")
        ->join("pakaiman_db_sipp410.jenisperkaraweb", "pakaiman_db_sipp410.dataumumweb.IDJenisPerkara","=","pakaiman_db_sipp410.jenisperkaraweb.id")
        //->leftjoin("pakaiman_db_sipp410.perkaraprosesweb", "pakaiman_db_sipp410.dataumumweb.IDProses","=","pakaiman_db_sipp410.perkaraprosesweb.IDProses")
        ->leftJoin("pakaiman_dbsilontar.tb_print_akta", "pakaiman_dbsilontar.tb_print_akta.id_perkara","=","pakaiman_db_sipp410.dataumumweb.IDPerkara")
        ->where("pakaiman_dbsilontar.tb_print_akta.no_perkara",$request['no_perkara'])
        ->where("pakaiman_dbsilontar.tb_print_akta.print","Print")
        ->count();

        return response()->json(["table"=>$table]);

    }

    public function edit($id_perkara){
        $table=DB::table("pakaiman_db_sipp410.dataumumweb")
        ->select("pakaiman_db_sipp410.dataumumweb.noPerkara as no_perkara","pakaiman_db_sipp410.dataumumweb.IDPerkara as id_perkara","pakaiman_dbsilontar.tb_print_akta.print")
        ->leftJoin("pakaiman_dbsilontar.tb_print_akta", "pakaiman_dbsilontar.tb_print_akta.id_perkara","=","pakaiman_db_sipp410.dataumumweb.IDPerkara")
        ->where("pakaiman_db_sipp410.dataumumweb.IDPerkara",$id_perkara)
        ->first();

        return response()->json($table);
    }

    public function update(Request $request){
       

       $id_perkara=$request["id_perkara"];
       $no_perkara=$request["no_perkara"];
       $status_cetak=$request["status_cetak"];

       $count = DB::table("pakaiman_dbsilontar.tb_print_akta")
       ->where("pakaiman_dbsilontar.tb_print_akta.id_perkara",$id_perkara)
       ->where("pakaiman_dbsilontar.tb_print_akta.no_perkara",$no_perkara)
       ->count();

       if($count>0){
            $table=DB::table("pakaiman_dbsilontar.tb_print_akta")
            ->where("pakaiman_dbsilontar.tb_print_akta.id_perkara",$id_perkara)
            ->where("pakaiman_dbsilontar.tb_print_akta.no_perkara",$no_perkara)
            ->update([
                "print"=>$status_cetak
            ]);
       }else{
            $table=DB::table("pakaiman_dbsilontar.tb_print_akta")
            ->insert([
                "pakaiman_dbsilontar.tb_print_akta.id_perkara"=>$id_perkara,
                "pakaiman_dbsilontar.tb_print_akta.no_perkara"=>$no_perkara
            ]);
       }

       return response()->json($table);
       //return response()->json(["id_perkara"=>$id_perkara,"no_perkara"=>$no_perkara, "status_cetak"=>$status_cetak]);
    }  
}
