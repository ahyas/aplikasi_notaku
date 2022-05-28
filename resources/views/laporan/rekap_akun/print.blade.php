<table border="1" style="border-collapse:collapse; border-color:#d9d9d9">
<tr>
    <th colspan="4">Kode satker, Program, Keg. Output, Kode akun dan uraian</th>
    <th colspan="12">Bulan</th>
</tr>
<tr>
    <td colspan="4"></td>
    <?php for($a=1; $a<=12; $a++){?>
        <td style="width:100px"><?php echo date('F', mktime(0, 0, 0, $a, 10)); ?></td>
    <?php } ?>
</tr>
@foreach($jenis_akun as $jenis_akun)
<tr>
    <td colspan="4"><?php echo $jenis_akun->id." ".strtoupper($jenis_akun->keterangan); ?></td>
    <?php for($a=1; $a<=12; $a++){?>
        <td></td>
    <?php } ?>
</tr>
<?php ?>
    @foreach($daftar_akun as $row_daftar_akun)
        @if($row_daftar_akun->jenis_akun == $jenis_akun->id)
            <!--Bila jenis akun adalah gaji dantunjangan-->
            @if($row_daftar_akun->jenis_akun == 1)
                <tr>
                    <td style="background-color:#d9d9d9">{{$row_daftar_akun->id_akun}}</td>
                    <td colspan="3" style="background-color:#d9d9d9">{{$row_daftar_akun->keterangan}}</td>
                    
                    <?php for($a=1; $a<=12; $a++){?>
                       
                        <?php $sum_total_nominal2=0; ?>
                        <td style="text-align:right; background:#d9d9d9">
                            @foreach($tb_transaksi_akun2 as $baris_tb_transaksi_akun2)
                                @if(($baris_tb_transaksi_akun2->id_akun == $row_daftar_akun->id_akun) && ($baris_tb_transaksi_akun2->num_bulan == $a))
                                    <?php $sum_total_nominal2 += $baris_tb_transaksi_akun2->total_nominal; ?>
                                   
                                @endif
                            @endforeach
                            <?php $total_transaksi_akun[] = $sum_total_nominal2; ?>
                            <b><?php echo number_format($sum_total_nominal2, 2); ?></b>
                        </td>
                    <?php } ?>
                </tr>
            <!--Bila jenis akun bukan gaji dan tunjangan-->
            @else
                <tr>
                    <td colspan="4" style="height:25px"></td>
                </tr>
                <tr>
                    <td style="background-color:#d9d9d9">{{$row_daftar_akun->id_akun}}</td>
                    <td colspan="3" style="background-color:#d9d9d9">{{$row_daftar_akun->keterangan}}</td>
                    
                    <?php for($a=1; $a<=12; $a++){?>
                        
                        <?php $sum_total_nominal=0; ?>
                        <td style="text-align:right; background:#d9d9d9">
                            @foreach($tb_transaksi_akun as $baris_tb_transaksi_akun)
                                @if(($baris_tb_transaksi_akun->id_akun == $row_daftar_akun->id_akun) && ($baris_tb_transaksi_akun->num_bulan == $a))
                                    <?php $sum_total_nominal += $baris_tb_transaksi_akun->total_nominal; ?>   
                                @endif
                            @endforeach
                            <?php $total_transaksi_akun[] = $sum_total_nominal; ?>
                            <b><?php echo number_format($sum_total_nominal, 2); ?></b>
                        </td>
                    <?php } ?>
                </tr>
            @endif
            
            @foreach($daftar_coa as $row_daftar_coa)
                @if(($row_daftar_coa->id_akun == $row_daftar_akun->id_akun) && ($jenis_akun->id <> 1))
                    <tr>
                        <td colspan="4" style="color:blue"><p style="text-indent: 40px;"><i>- {{$row_daftar_coa->keterangan}}</i></p></td>
                        <?php for($s=1; $s<=12; $s++){?>
                            <?php $nominal_transaksi_akun = 0; ?>
                            <td style="text-align:right;">
                                @foreach($tb_transaksi_akun as $row_tb_transaksi_akun)
                                    @if(($row_tb_transaksi_akun->num_bulan == $s) && ($row_tb_transaksi_akun->id_coa == $row_daftar_coa->id_coa))
                                        <?php $nominal_transaksi_akun += $row_tb_transaksi_akun->total_nominal; ?> 
                                       <!-- <i>{{$row_tb_transaksi_akun->total_nominal}}<i>-->
                                    @endif
                                @endforeach
                            <?php echo number_format($nominal_transaksi_akun, 2); ?>
                            </td>
                        <?php } ?>
                    </tr>
                @endif
            @endforeach
        @endif
    @endforeach
@endforeach
<tr>
    <td colspan="4" style="text-align: right">
        <?php $jml_isi = count($total_transaksi_akun)-12; ?>
        <b>Jumlah</b>
    </td>
   
    <?php for($foot=0; $foot<=11; $foot++){?>
        <td style="text-align:right;">
        <?php $d=0; ?>
                @for($z=$foot; $z<=($jml_isi+$foot); $z+=12)
                    @foreach($total_transaksi_akun as $key => $value)
                        @if($key == $z)
                            <?php $d+=$value; ?>
                        @endif
                    @endforeach
                @endfor
                <b><?php echo number_format($d, 2); ?></b>
        </td>
    <?php } ?>
</tr>
</table>