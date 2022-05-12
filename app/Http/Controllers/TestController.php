<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class TestController extends Controller
{

    public function show_data(){
        $table=DB::table("tb_test")->get();

        return DataTables::of($table)->make(true);
    }
}
