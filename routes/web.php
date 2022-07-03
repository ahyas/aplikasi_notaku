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

Route::group(['middleware'=>'auth'], function(){
    Route::get("home","DashboardController@index");
    Route::post('logout', 'AuthController@logout')->name('logout');    

    Route::get("dashboard/chart/laporan_1","DashboardController@laporan_1")->name("dashboard.chart.laporan_1");
    Route::get("dashboard/chart/kondisi_kas","DashboardController@kondisi_kas")->name("dashboard.chart.kondisi_kas");
    Route::get("dashboard/chart/laporan_2","DashboardController@laporan_2")->name("dashboard.chart.laporan_2");
    
    Route::get("verifikator","VerifikatorController@index")->name("verifikator.dashboard");
    Route::get("verifikator/verifikasi_nota", "VerifikatorController@verifikasi_nota")->name("verifikator.verifikasi_nota");
    Route::post("verifikator/upload","VerifikatorController@upload")->name("verifikator.upload");
    Route::get("verifikator/show_data","VerifikatorController@ShowData")->name("verifikator.show_data");
    Route::get("verifikator/{id_akun}/coa","VerifikatorController@getCOA");
    Route::get("verifikator/get_akun","VerifikatorController@getDetailCOA")->name("verifikator.getDetailCOA");
    Route::post("verifikator/update","VerifikatorController@update")->name("verifikator.update");
    Route::get("verifikator/{id_nota}/delete","VerifikatorController@delete");
    Route::get("verifikator/{id_coa}/sub_coa","VerifikatorController@getSubCOA")->name("verifikator.getSubCOA");
    
    Route::get("transaksi/nota","NotaController@index")->name("nota.dashboard");
    Route::get("transaksi/nota/catat_nota","NotaController@catat_nota")->name("transaksi.nota.catat_nota");
    Route::post("transaksi/nota/upload","NotaController@upload")->name("transaksi.nota.upload");
    Route::get("transaksi/nota/show_data","NotaController@ShowData")->name("transaksi.nota.show_data");
    Route::get("transaksi/nota/{id_akun}/coa","NotaController@getCOA");
    Route::get("transaksi/nota/get_akun","NotaController@getDetailAkun")->name("transaksi.nota.getDetailAkun");
    Route::post("transaksi/nota/update","NotaController@update")->name("transaksi.nota.update");
    Route::get("transaksi/nota/{id_nota}/delete","NotaController@delete");

    Route::get("transaksi/verifikasi_drpp","VerifikasiDRPP@index")->name("verifikasi_drpp.index");
    Route::get("transaksi/verifikasi_drpp/list_gup","VerifikasiDRPP@list_gup")->name("verifikasi_drpp.list_gup"); 
    Route::get("transaksi/verifikasi_drpp/list_nota","VerifikasiDRPP@list_nota")->name("verifikasi_drpp.list_nota");
    Route::get("transaksi/verifikasi_drpp/setuju_drpp","VerifikasiDRPP@setuju_drpp")->name("verifikasi_drpp.setuju_drpp");

    Route::get("transaksi/verifikasi_ls","VerifikasiLS@index")->name("verifikasi_ls.index");
    Route::get("transaksi/verifikasi_ls/show_transaksi","VerifikasiLS@show_transaksi")->name("verifikasi_ls.show_transaksi");
    Route::get("transaksi/verifikasi_ls/detail_sp2d","VerifikasiLS@detail_sp2d")->name("verifikasi_ls.detail_sp2d");
    Route::post("transaksi/verifikasi_ls/update", "VerifikasiLS@update")->name("verifikasi_ls.update");
    Route::get("transaksi/verifikasi_ls/simpan","VerifikasiLS@simpan")->name("verifikasi_ls.simpan");

    Route::get("transaksi/drpp","drppController@index")->name("transaksi.drpp.index");
    Route::get("transaksi/drpp/show_list","drppController@show_list")->name("transaksi.drpp.show_list");
    Route::get("transaksi/drpp/daftar_nota","drppController@daftar_nota")->name("transaksi.drpp.daftar_nota");
    Route::get("transaksi/drpp/input_nota","drppController@input_nota")->name("transaksi.drpp.input_nota");
    Route::get("transaksi/drpp/hapus_nota","drppController@hapus_nota")->name("transaksi.drpp.hapus_nota");
    Route::get("transaksi/drpp/simpan_drpp","drppController@simpan_drpp")->name("transaksi.drpp.simpan_drpp");

    Route::get("ls","LSController@index")->name("ls.dashboard");
    Route::get("ls/catat_sp2d", "LSController@catat_sp2d")->name("ls.catat_sp2d");
    Route::post("ls/catat_sp2d/upload_daftar_sp2d", "LSController@upload_daftar_sp2d")->name("ls.upload_daftar_sp2d");
    Route::get("ls/catat_sp2d/show_transaksi","LSController@show_transaksi")->name("ls.show_transaksi");
    Route::get("ls/catat_sp2d/show_detail_transaksi", "LSController@show_detail_transaksi")->name("ls.show_detail_transaksi");
    Route::get("ls/catat_sp2d/detail_sp2d","LSController@detail_sp2d")->name("ls.detail_sp2d");
    Route::post("ls/catat_sp2d/upload_daftar_akun","LSController@upload_daftar_akun")->name("ls.upload_daftar_akun");
    Route::get("ls/catat_sp2d/clear","LSController@clear")->name("ls.clear");
    Route::get("ls/catat_sp2d/simpan","LSController@simpan")->name("ls.simpan");
    Route::get("ls/catat_sp2d/edit","LSController@edit")->name("ls.edit");
    Route::post("ls/catat_sp2d/update", "LSController@update")->name("ls.update");
    Route::get("ls/catat_sp2d/{no_sp2d}/delete","LSController@delete");

    Route::get("upload", "UploadController@index")->name("upload.upload_data_dukung");
    Route::get("upload/list_gup", "UploadController@list_gup")->name("upload.list_gup");
    Route::get("upload/list_nota", "UploadController@list_nota")->name("upload.list_nota");
    Route::post("upload/upload_spby","UploadController@upload_spby")->name("upload.upload_spby");
    Route::post("upload/upload_kwitansi","UploadController@upload_kwitansi")->name("upload.upload_kwitansi");
    Route::post("upload/upload_drpp","UploadController@upload_drpp")->name("upload.upload_drpp");

    Route::get("mapping","MappingController@index")->name("mapping.index");
    Route::get("mapping/get_program","MappingController@getProgram")->name("mapping.get_daftar_program");
    Route::get("mapping/get_kegiatan","MappingController@getKegiatan")->name("mapping.get_daftar_kegiatan");
    Route::get("mapping/get_kro","MappingController@getDaftarKRO")->name("mapping.get_daftar_kro");
    Route::get("mapping/get_ro","MappingController@getDaftarRO")->name("mapping.get_daftar_ro");
    Route::get("mapping/get_komponen","MappingController@getDaftarKomponen")->name("mapping.get_daftar_komponen");
    Route::get("mapping/get_sub_komponen","MappingController@getDaftarSubKomponen")->name("mapping.get_daftar_sub_komponen");
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
    Route::get("laporan/rekap_akun/print","LaporanController@print")->name("laporan.rekap_akun.print");
    Route::get("laporan/rekap_akun/show_data","LaporanController@show_data")->name("laporan.rekap_akun.show_data");
    Route::get("laporan/rekap_akun/{id_akun}/daftar_coa","LaporanController@daftar_coa")->name("laporan.rekap_akun.daftar_coa");
    Route::get("laporan/rekap_akun/{id_akun}/transaksi_coa","LaporanController@transaksi_coa")->name("laporan.rekap_akun.transaksi_coa");
    Route::get("laporan/rekap_akun/detail_akun","LaporanController@detail_akun")->name("laporan.rekap_akun.detail_akun");
    Route::get("laporan/rekap_akun/detail_coa","LaporanController@detail_coa")->name("laporan.rekap_akun.detail_coa");
    
    Route::get("laporan/gup","LaporanGUPController@index")->name("laporan_gup.index");
    Route::get("laporan/gup/list_gup","LaporanGUPController@list_gup")->name("laporan_gup.list_gup"); 
    Route::get("laporan/gup/list_nota","LaporanGUPController@list_nota")->name("laporan_gup.list_nota");

    Route::get("laporan/sp2d", "LaporanSP2DController@index")->name("laporan_sp2d.index");
    Route::get("laporan/sp2d/show_daftar_sp2d", "LaporanSP2DController@show_daftar_sp2d")->name("laporan_sp2d.show_daftar_sp2d");
    Route::get("laporan/sp2d/detail_sp2d","LaporanSP2DController@show_daftar_akun")->name("laporan_sp2d.detail_sp2d");

    //Start test route
    Route::get("test","TestController@index")->name("test.index");
    //End test route
});




