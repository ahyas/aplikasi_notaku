<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Akun extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_test_detail_transaksi';
    protected $fillable = ['no_sp2d','akun','jenis_akun','jumlah'];
}