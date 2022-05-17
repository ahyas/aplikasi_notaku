<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');
Route::get('/',function(){
    return view('login');
})->name("home");

Route::post("dashboard/cari_nomor", "DashboardController@cari")->name("dashboard.cari");
Route::group(['middleware'=>'auth'], function(){
    Route::post('logout', 'AuthController@logout')->name('logout');    
    
    Route::get("ppk","PpkController@index")->name("ppk.dashboard");
    Route::post("ppk/upload","PpkController@upload")->name("ppk.upload");
    Route::get("ppk/show_data","PpkController@ShowData")->name("ppk.show_data");
    Route::get("ppk/{id_akun}/coa","PpkController@getCOA");
    Route::get("ppk/get_akun","PpkController@getDetailCOA")->name("ppk.getDetailCOA");
    Route::post("ppk/update","PpkController@update")->name("ppk.update");
    Route::get("ppk/{id_nota}/delete","PpkController@delete");
    Route::get("ppk/{id_coa}/sub_coa","PpkController@getSubCOA")->name("ppk.getSubCOA");
    
    Route::get("bendahara","BendaharaController@index")->name("bendahara.dashboard");
    Route::post("bendahara/upload","BendaharaController@upload")->name("bendahara.upload");
    Route::post("bendahara/upload_spby","BendaharaController@upload_spby")->name("bendahara.upload_spby");
    Route::post("bendahara/upload_kwitansi","BendaharaController@upload_kwitansi")->name("bendahara.upload_kwitansi");
    Route::get("bendahara/show_data","BendaharaController@ShowData")->name("bendahara.show_data");
    Route::get("bendahara/{id_akun}/coa","BendaharaController@getCOA");
    Route::get("bendahara/get_akun","BendaharaController@getDetailAkun")->name("bendahara.getDetailAkun");
    Route::post("bendahara/update","BendaharaController@update")->name("bendahara.update");
    Route::get("bendahara/{id_nota}/delete","BendaharaController@delete");

    Route::get("mapping","MappingController@index")->name("mapping.index");
    Route::get("mapping/get_akun","MappingController@getDaftarAkun")->name("mapping.get_daftar_akun");
    Route::get("mapping/coa/{id_akun}/daftar_coa","MappingController@getDaftarCOA");
    Route::post("mapping/coa/save","MappingController@saveCOA")->name("mapping.coa.save");
    Route::get("mapping/coa/delete","MappingController@deleteCOA")->name("mapping.coa.delete");
    Route::get("mapping/coa/edit","MappingController@editCOA")->name("mapping.coa.edit");
    Route::post("mapping/coa/update","MappingController@updateCOA")->name("mapping.coa.update");
    Route::get("mapping/subcoa/{id_coa}/daftar_subcoa","MappingController@getDaftarSubCOA");
    Route::post("mapping/subcoa/save","MappingController@saveSubCOA")->name("mapping.subcoa.save");
    Route::get("mapping/subcoa/delete","MappingController@deleteSubCOA")->name("mapping.subcoa.delete");
    Route::get("mapping/subcoa/edit","MappingController@editSubCOA")->name("mapping.subcoa.edit");
    Route::post("mapping/subcoa/update","MappingController@updateSubCOA")->name("mapping.subcoa.update");
    Route::get("mapping/akun/edit_akun","MappingController@edit_akun")->name("mapping.akun.edit_akun");
    Route::post("mapping/akun/update_akun","MappingController@update_akun")->name("mapping.akun.update_akun");

    Route::get("laporan/rekap_akun","LaporanController@index")->name("laporan.rekap_akun");
    Route::get("laporan/rekap_akun/show_data","LaporanController@show_data")->name("laporan.rekap_akun.show_data");
    Route::get("laporan/rekap_akun/{id_akun}/daftar_coa","LaporanController@daftar_coa")->name("laporan.rekap_akun.daftar_coa");
    Route::get("laporan/rekap_akun/{id_akun}/transaksi_coa","LaporanController@transaksi_coa")->name("laporan.rekap_akun.transaksi_coa");
    Route::get("laporan/rekap_akun/detail_coa","LaporanController@detail_coa")->name("laporan.rekap_akun.detail_coa");
    
    Route::get("laporan/gup","LaporanGUPController@index")->name("laporan_gup.index");
    Route::get("laporan/gup/list_gup","LaporanGUPController@list_gup")->name("laporan_gup.list_gup"); 
    Route::get("laporan/gup/list_nota","LaporanGUPController@list_nota")->name("laporan_gup.list_nota");

    Route::get("transaksi/drpp","drppController@index")->name("transaksi.drpp.index");
    Route::get("transaksi/drpp/show_list","drppController@show_list")->name("transaksi.drpp.show_list");
    Route::get("transaksi/drpp/daftar_nota","drppController@daftar_nota")->name("transaksi.drpp.daftar_nota");
    Route::get("transaksi/drpp/input_nota","drppController@input_nota")->name("transaksi.drpp.input_nota");
    Route::get("transaksi/drpp/hapus_nota","drppController@hapus_nota")->name("transaksi.drpp.hapus_nota");
    Route::get("transaksi/drpp/simpan_drpp","drppController@simpan_drpp")->name("transaksi.drpp.simpan_drpp");

    Route::get("transaksi/catat_sp2d", "sp2dController@index")->name("transaksi.sp2d.index");
    Route::post("transaksi/catat_sp2d/read_xml", "sp2dController@read_xml")->name("transaksi.sp2d.read_xml");
    Route::get("transaksi/catat_sp2d/show_transaksi","sp2dController@show_transaksi")->name("transaksi.sp2d.show_transaksi");
    Route::get("transaksi/catat_sp2d/show_detail_transaksi", "sp2dController@show_detail_transaksi")->name("transaksi.sp2d.show_detail_transaksi");
    Route::get("transaksi/catat_sp2d/detail_sp2d","sp2dController@detail_sp2d")->name("transaksi.sp2d.detail_sp2d");
    Route::post("transaksi/catat_sp2d/read_excel","sp2dController@read_excel")->name("transaksi.sp2d.read_excel");
    Route::get("transaksi/catat_sp2d/clear","sp2dController@clear")->name("transaksi.sp2d.clear");
    Route::get("transaksi/catat_sp2d/simpan","sp2dController@simpan")->name("transaksi.sp2d.simpan");
    Route::get("transaksi/catat_sp2d/edit","sp2dController@edit")->name("transaksi.sp2d.edit");
    Route::post("transaksi/catat_sp2d/update", "sp2dController@update")->name("transaksi.sp2d.update");
    Route::get("transaksi/catat_sp2d/{no_sp2d}/delete","sp2dController@delete");
});




