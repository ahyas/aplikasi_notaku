<?php

namespace App\Imports;

use App\Sp2d;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //Membaca kolom berdasarkan header name
use Maatwebsite\Excel\Imports\HeadingRowFormatter; //menonaktifkan format penulisan header

HeadingRowFormatter::default('none');

class DaftarSp2dImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        //mencegah duplikat data saat menginput ke database
        Sp2d::insertOrIgnore([
            'no_sp2d'       => $row['Nomor SP2D'],
            'tanggal'       => $row['Tanggal SP2D'],
            'nilai'         => $row['Nilai SP2D'],
            'jenis_spm'     => $row['Jenis SPM'],
            'jenis_sp2d'    => $row['Jenis SP2D'],
            'deskripsi'     => $row['Deskripsi']
        ]);
    }

    public function headingRow(): int
    {
        return 3; //mulai membaca data dari baris ke 3
    }

}
