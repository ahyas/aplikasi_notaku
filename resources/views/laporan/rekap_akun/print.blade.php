<table border="1" style="border-collapse:collapse">
<tr>
    <th colspan="4">Kode satker, Program, Keg. Output, Kode akun dan uraian</th>
    <th colspan="12">Bulan</th>
</tr>
<tr>
    <td colspan="4"></td>
    <?php for($a=1; $a<=12; $a++){?>
        <td><?php echo "0".$a." ".date('F', mktime(0, 0, 0, $a, 10)); ?></td>
    <?php } ?>
</tr>
@foreach($jenis_akun as $jenis_akun)
<tr>
    <td colspan="4"><?php echo $jenis_akun->id." ".strtoupper($jenis_akun->keterangan); ?></td>
    <?php for($a=1; $a<=12; $a++){?>
        
        <td></td>
    <?php } ?>
</tr>
    @foreach($daftar_akun as $row_daftar_akun)
        @if($row_daftar_akun->jenis_akun == $jenis_akun->id)
            <tr>
                <td>{{$row_daftar_akun->id_akun}}</td>
                <td colspan="3">{{$row_daftar_akun->keterangan}}</td>
                <?php for($a=1; $a<=12; $a++){?>
                    <?php $sum_total_nominal=0; ?>
                    <td>
                        @foreach($tb_transaksi_akun as $baris_tb_transaksi_akun)
                            @if($baris_tb_transaksi_akun->id_akun == $row_daftar_akun->id_akun && $baris_tb_transaksi_akun->num_bulan == $a)
                                <?php $sum_total_nominal = $sum_total_nominal+$baris_tb_transaksi_akun->total_nominal; ?>
                                <?php echo number_format($sum_total_nominal,2) ?>
                            @endif
                        @endforeach
                    </td>
                <?php } ?>
            </tr>
            @foreach($daftar_coa as $row_daftar_coa)
                @if($row_daftar_coa->id_akun == $row_daftar_akun->id_akun && $jenis_akun->id <> 1)
                    <tr>
                        <td colspan="4"><p style="text-indent: 40px;"><i>{{$row_daftar_coa->id_akun}} {{$row_daftar_coa->id_coa}} {{$row_daftar_coa->keterangan}}</i></p></td>
                        <?php for($a=1; $a<=12; $a++){?>
                            <td></td>
                        <?php } ?>
                    </tr>
                @endif
            @endforeach
        @endif
    @endforeach
@endforeach
</table>