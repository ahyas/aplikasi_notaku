
<table style="border:1px solid grey; border-collapse:collapse;">
    <tr>
        <td>num_bulan</td>
        <td>keterangan_akun</td>
        <td>id_jenis_akun</td>
        <td>jenis_akun</td>
        <td>id_akun</td>
        <td>total_nominal</td>
        <td>id_coa</td>
    </tr>
@foreach($tb_transaksi_akun as $row)
    <tr>
        <td>{{$row->num_bulan}}</td>
        <td>{{$row->keterangan_akun}}</td>
        <td>{{$row->id_jenis_akun}}</td>
        <td>{{$row->jenis_akun}}</td>
        <td>{{$row->id_akun}}</td>
        <td align="right"><?php echo number_format($row->total_nominal,0); ?></td>
        <td>{{$row->id_coa}}</td>    
    <tr>
@endforeach
</table>