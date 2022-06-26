<style>
    .bg{
        text-align:right; 
        background-color:#fff1b0;
    }

    body{
        font-family: Arial, Helvetica, sans-serif;
        font-size:10px;
    }
</style>
<h2 style="text-align:center">LAPORAN REALISASI PENYERAPAN ANGGARAN DIPA SATUAN KERJA</h2>
<h2 style="text-align:center; line-height:0">TAHUN 2022</h2>

<table border="0.4" style="border-collapse:collapse; border-color:#bdbdbd; width:100%; table-layout:fixed;">
<tr>
    <th colspan="4" rowspan="2">Kode satker, Program, Keg. Output, Kode akun dan uraian</th>
    <th rowspan="2">DIPA Awal</th>
    <th colspan="12">Bulan</th>
    <th rowspan="2" class="bg" style="text-align:center">Realisasi</th>
    <th rowspan="2" class="bg" style="text-align:center">Saldo</th>
    <th rowspan="2" class="bg" style="text-align:center">( % )</th>
</tr>
<tr>
    <?php for($a=1; $a<=12; $a++){?>
        <td style="text-align:center"><b><?php echo date('F', mktime(0, 0, 0, $a, 10)); ?></b></td>
    <?php } ?>
</tr>
<?php  $n=133; $num=0;?>
@foreach($tb_komponen as $tb_komponen)
<tr>
    <td colspan="4" style="height:25px"></td>
    <td></td>
    <td colspan="15"></td>
</tr>
<tr style="background-color:#99ed93">
    <td colspan="4"><b><?php echo $tb_komponen->id." ".strtoupper($tb_komponen->keterangan); ?></b></td>
    <td><b><?php echo number_format($tb_komponen->pagu,0 ); ?></b></td>
    <?php for($a=1; $a<=12; $a++){?>
        <td></td>
    <?php } ?>
    <td></td>
    <td></td>
    <td></td>
</tr>
<?php $x=-12; $y=-12; $cc=0;?> 
@foreach($tb_sub_komponen as $row_tb_sub_komponen)

    @if($row_tb_sub_komponen->id_komponen == $tb_komponen->id )
        <tr>
            <td colspan="4" style="height:25px"></td>
            <td></td>
            <td colspan="15"></td>
            
        </tr>

        <tr style="background-color:#7ae4ff">
            <td colspan="4">
                <i>{{$row_tb_sub_komponen->kode}} - {{$row_tb_sub_komponen->keterangan}}</i><br>
            </td>
            <td style="text-align:right;"><b><?php echo number_format($row_tb_sub_komponen->pagu, 0) ?></b></td>
            <?php for($a=1; $a<=12; $a++){?>
                
                <td style="text-align:right;">
                <?php $ty=0; $dy=0;?>
                @foreach($daftar_akun as $row_daftar_akun)
                <?php $sum_total_nominal=0; ?> <?php $sum_total_nominal2=0; ?>
                    @if($row_daftar_akun->id_sub_komponen == $row_tb_sub_komponen->id)
                        @if($row_daftar_akun->id_komponen == $tb_komponen->id)
                            <!--Bila jenis akun adalah gaji dantunjangan-->
                            @if($row_daftar_akun->id_komponen == 1)
                            
                                @foreach($tb_transaksi_akun2 as $baris_tb_transaksi_akun2)
                                    @if(($baris_tb_transaksi_akun2->id_akun == $row_daftar_akun->id_akun) && ($baris_tb_transaksi_akun2->num_bulan == $a))
                                        <?php $sum_total_nominal2 += $baris_tb_transaksi_akun2->total_nominal; $pp=1; ?>
                                    @endif
                                @endforeach
                            @else
                           
                                @foreach($tb_transaksi_akun as $key => $baris_tb_transaksi_akun)
                                    @if(($baris_tb_transaksi_akun->id_akun == $row_daftar_akun->id_akun) && ($baris_tb_transaksi_akun->num_bulan == $a))
                                        <?php $sum_total_nominal += $baris_tb_transaksi_akun->total_nominal; $pp=2;?> 
                                    @endif
                                @endforeach
                                
                            @endif
                            
                        @endif
                    @endif
                    <?php $ty+=$sum_total_nominal; $dy+=$sum_total_nominal2; ?>
                @endforeach

                    @if($pp==1)
                        <b><?php echo number_format($dy,0); ?></b>
                        <?php $total_realisasi_sub_komp[] = $dy; ?>
                    @else
                        <b><?php echo number_format($ty,0); ?><b>
                        <?php $total_realisasi_sub_komp[] = $ty; ?>
                    @endif
            
                </td>
            <?php } ?>

                <td align="right">
                   <?php 
                   $num+=1;                  
                   $jj=0;

                   ?>
                    @for($u=($num*12)-12; $u<=(12*$num)-1; $u++)
                        @foreach($total_realisasi_sub_komp as $key => $val)
                            @if($key == $u)
                            <?php  $jj+=$val; ?>
                            @endif
                        @endforeach
                        
                    @endfor
                    <b><?php echo number_format($jj,0); ?></b>
                </td>
                <td align="right">
                    <?php $saldo = $row_tb_sub_komponen->pagu - $jj; ?>
                    <b><?php echo number_format($saldo, 0); ?></b>
                </td>
                <td align="right">
                    <?php $prosentase_sub_komponen = ($jj / $row_tb_sub_komponen->pagu) * 100;  ?>
                    <b><?php echo number_format($prosentase_sub_komponen,2);?> %</b>
                </td>
        </tr>

<?php $sum_total_dipa_awal = 0; ?> 
    @foreach($daftar_akun as $row_daftar_akun)

        @if($row_daftar_akun->id_sub_komponen == $row_tb_sub_komponen->id)

        @if($row_daftar_akun->id_komponen == $tb_komponen->id)
            <!--Bila jenis akun adalah gaji dantunjangan-->
            
            @if($row_daftar_akun->id_komponen == 1)
                <tr>
                    <td colspan="4" style="background-color:#d9d9d9; padding-left:15px;">{{$row_daftar_akun->id_akun}} - {{$row_daftar_akun->keterangan}}</td>
                    <td style="background-color:#d9d9d9; text-align:right;"><b>
                        <?php echo number_format($row_daftar_akun->pagu,0) ?></b>
                        
                        <?php $total_dipa_awal[] = $row_daftar_akun->pagu; ?>
                    </td>
                    <?php for($a=1; $a<=12; $a++){?>
                       
                        <?php $sum_total_nominal2=0; ?>
                        <td style="text-align:right; background:#d9d9d9;">
                            @foreach($tb_transaksi_akun2 as $baris_tb_transaksi_akun2)
                                @if(($baris_tb_transaksi_akun2->id_akun == $row_daftar_akun->id_akun) && ($baris_tb_transaksi_akun2->num_bulan == $a))
                                    <?php $sum_total_nominal2 += $baris_tb_transaksi_akun2->total_nominal; ?>
                                @endif
                            @endforeach
                            <?php $total_transaksi_akun[] = $sum_total_nominal2; ?>
                            <b><?php echo number_format($sum_total_nominal2, 0); ?></b>
                        </td>
                    <?php } ?>
                    <td align="right" style=" background-color:#d9d9d9;">
                   
                       <?php $x+=12; ?>
                       <?php $b=0; ?>
                        @for($t=$x; $t<=($x+11); $t++)
                        
                            @foreach($total_transaksi_akun as $key => $value)
                                @if($key == $t)
                                    <?php $b+=$value; ?>
                                @endif 
                            @endforeach
                           
                        @endfor
                        <b><?php echo number_format($b,0); ?></b>
                    </td>
                    <td align="right" style=" background-color:#d9d9d9;">
                        <?php $saldo_akun = $row_daftar_akun->pagu - $b; ?>
                        <b><?php echo number_format($saldo_akun, 0); ?></b>
                    </td>
                    <td align="right" style=" background-color:#d9d9d9;">
                        <?php $prosentase_akun = ($b / $row_daftar_akun->pagu)*100; ?>
                        <?php echo number_format($prosentase_akun,2); ?> %
                    </td>
                </tr>
            <!--Bila jenis akun bukan gaji dan tunjangan-->
            @else
                
                <tr>
                    <td colspan="4" style="background-color:#d9d9d9; padding-left:15px">{{$row_daftar_akun->id_akun}} - {{$row_daftar_akun->keterangan}}</td>
                    <td style="background-color:#d9d9d9; text-align:right">
                        <b><?php echo number_format($row_daftar_akun->pagu, 0); ?></b>
                        <?php $total_dipa_awal[] = $row_daftar_akun->pagu; ?>
                    </td>

                    <!--Start perhitungan realisasi akun per bulan-->
                    <?php for($a=1; $a<=12; $a++){?>    
                        <?php $sum_total_nominal=0; ?>
                        <td style="text-align:right; background:#d9d9d9;">
                            @foreach($tb_transaksi_akun as $key => $baris_tb_transaksi_akun)
                                @if(($baris_tb_transaksi_akun->id_akun == $row_daftar_akun->id_akun) && ($baris_tb_transaksi_akun->num_bulan == $a))
                                    <?php $sum_total_nominal += $baris_tb_transaksi_akun->total_nominal; ?>   
                                @endif
                            @endforeach
                            <?php $total_transaksi_akun[] = $sum_total_nominal;?>
                            <b><?php echo number_format($sum_total_nominal, 0); ?></b>
                        </td>

                    <?php } ?>
                    <!--End perhitungan realisasi akun per bulan-->
                    
                    <!--Start perhitungan total realisasi akun setahun-->
                    <td align="right" style="background-color:#d9d9d9;">
                        <?php $n+=12; ?>
                        <?php $b=0; ?>
                          @for($f = $n-1; $f <= ($n+11); $f++)
                            @foreach($total_transaksi_akun as $key => $value)
                                @if($key == $f)
                                    <?php $b+=$value; ?>

                                @endif
                            @endforeach
                          @endfor
                          
                          <b><?php echo number_format($b, 0); ?></b>
                    </td>
                    <!--End perhitungan total realisasi akun setahun-->
                    <td align="right" style="background-color:#d9d9d9;">
                        <?php $saldo_akun2 = $row_daftar_akun->pagu - $b; ?>
                        <b><?php echo number_format($saldo_akun2, 0); ?></b>
                    </td>
                    <td align="right" style="background-color:#d9d9d9;">
                        <?php $prosentase_akun2 = ($b / $row_daftar_akun->pagu) * 100; ?>
                        <?php echo number_format($prosentase_akun2, 2); ?> %
                    </td>
                </tr>
                
            @endif
            
            @foreach($daftar_coa as $row_daftar_coa)
                @if(($row_daftar_coa->id_akun == $row_daftar_akun->id_akun) && ($tb_komponen->id <> 1))
                    <tr>
                        <td colspan="4" style="color:blue; padding-left:25px"><i>- {{$row_daftar_coa->keterangan}}</i></td>
                        <td style="text-align:right"><?php echo number_format($row_daftar_coa->pagu, 0); ?></td>
                        <?php for($s=1; $s<=12; $s++){?>
                            <?php $nominal_transaksi_akun = 0; ?>
                            <td style="text-align:right;">
                                @foreach($tb_transaksi_akun as $row_tb_transaksi_akun)
                                    @if(($row_tb_transaksi_akun->num_bulan == $s) && ($row_tb_transaksi_akun->id_coa == $row_daftar_coa->id_coa))
                                        <?php $nominal_transaksi_akun += $row_tb_transaksi_akun->total_nominal; ?> 
                                        <!-- <i>{{$row_tb_transaksi_akun->total_nominal}}<i>-->
                                        
                                    @endif
                                @endforeach
                                <?php $grandtotal_transaksi_akun[] = $nominal_transaksi_akun; ?>
                            <?php echo number_format($nominal_transaksi_akun, 0); ?>
                            </td>
                        <?php } ?>
                        <td class="bg">
                        <?php $h=0; ?>
                        @foreach($tb_transaksi_akun as $row_grandtotal_coa)
                            @if($row_grandtotal_coa->id_coa == $row_daftar_coa->id_coa)
                                <?php $h+=$row_grandtotal_coa->total_nominal; ?>
                            @endif
                        @endforeach
                        
                        <b><?php echo number_format($h,0); ?></b>  
                          
                          
                        </td>
                        <td class="bg">
                            <?php $saldo_coa = $row_daftar_coa->pagu - $h; ?>
                            <b><?php echo number_format($saldo_coa, 0); ?></b>
                        </td>
                        <td class="bg">
                            <?php $prosentase_coa = ($h/$row_daftar_coa->pagu)*100; ?>
                            <?php echo number_format($prosentase_coa, 2); ?> %
                        </td>
                    </tr>
                @endif
            @endforeach
           
        @endif

        @endif

    @endforeach
    <?php $x++; ?>

    @endif
    @endforeach
    
@endforeach
<?php $num++; ?>
<tr>
    <td height="30px" colspan="4" style="text-align: center; background-color:#fff1b0">
        <?php $jml_isi = count($total_transaksi_akun)-12; ?>
        <b>Realisasi per bulan</b>
    </td>
    <td class="bg"><b>
        <?php $gg = 0; ?>
        @foreach($total_dipa_awal as $hasil)
            <?php $gg += $hasil; ?>
        @endforeach
        <?php echo number_format($gg, 0); ?></b>
    </td>
   
    <?php for($foot=0; $foot<=11; $foot++){?>
        <td class="bg">
        <?php $d=0; ?>
                @for($z=$foot; $z<=($jml_isi+$foot); $z+=12)
                    @foreach($total_transaksi_akun as $key => $value)
                        @if($key == $z)
                            <?php 
                            
                            $d+=$value; 

                            ?>
                        @endif
                    @endforeach
                @endfor
                <?php $total_realisasi_all[] = $d; ?>
                <b><?php echo number_format($d, 0); ?></b>
        </td>
    <?php } ?>
    <td class="bg">
        <?php $t = 0; ?>
        @foreach($total_realisasi_all as $row)
            <?php $t+=$row; ?>
        @endforeach
        <b><?php echo number_format($t, 0); ?></b>
    </td>
    <td class="bg">
        <?php $saldo_pagu_global = $gg - $t; ?></b>
        <b><?php echo number_format($saldo_pagu_global, 0);  ?></b>
    </td>
    <td class="bg">
        <?php $prosentase_global = ($t/$gg) * 100; ?>
        <?php echo number_format($prosentase_global, 2);  ?> %
    </td>
</tr>
</table>