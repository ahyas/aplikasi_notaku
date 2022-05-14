<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use DataTables;
use Excel;

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

    //membaca file sp2d format .xml
    public function read_xml(Request $request){
        $request->validate([
            'file' => 'required|mimes:xml|max:5000',
        ]);
        $fileName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/sp2d'), $fileName);

        $xmlString = file_get_contents(public_path('uploads/sp2d/'.$fileName));
        $xmlObject = simplexml_load_string($xmlString);
        
        foreach ($xmlObject as $row) {
            DB::unprepared("INSERT INTO tb_test_transaksi (no_sp2d, tanggal, nilai)
            SELECT * FROM (SELECT '$row->no_sp2d', '$row->tanggal_sp2d', '$row->nilai_sp2d') AS tmp
            WHERE NOT EXISTS (
                SELECT no_sp2d FROM tb_test_transaksi WHERE no_sp2d = $row->no_sp2d
            ) LIMIT 1;");
        }

        return redirect()->back();
    }

    public function detail_sp2d($no_sp2d){
        $table=DB::table("tb_test_detail_transaksi")->get();
        return DataTables::of($table)->make(true);
    }

    //membaca file detail akun format .xls
    public function read_excel(Request $request){
        $this->validate($request, [
            'file_detail_akun'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('file_detail_akun')->getRealPath();
      
        $data = Excel::load($path)->get();
      
        if($data->count() > 0){
            foreach($data->toArray() as $key => $value){
                foreach($value as $row){
                    $insert_data[] = array(
                        'no_sp2d'  => $request["file_detail_akun"],
                        'akun'   => $row['Akun'],
                        'jumlah'   => $row['Jumlah'],
                    );
                }
            }
        }

        DB::table('tb_test_detail_transaksi')->insert($insert_data);
        return redirect()->back();
    
    }
}
