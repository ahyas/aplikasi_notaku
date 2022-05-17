<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Sp2d extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_test_transaksi';
    protected $fillable = ['no_sp2d','tanggal','nilai','status','jenis_spm','jenis_sp2d','deskripsi'];
}