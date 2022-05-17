<?php

namespace App\Imports;

use App\Akun;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DetailAkunImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $no_sp2d;

    function __construct($no_sp2d) {
        $this->no_sp2d = $no_sp2d;
    }

    public function model(array $row)
    {
        return new Akun([
            'no_sp2d'       => $this->no_sp2d,
            'akun'          => $row['akun'],
            'jenis_akun'    => $row['jenis'],
            'jumlah'        => $row['jumlah'],
        ]);
    }

    public function headingRow(): int
    {
        return 4;
    }

}
