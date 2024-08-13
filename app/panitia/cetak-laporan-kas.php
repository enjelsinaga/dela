<style>
	
		table {width:100%;}
		table, th, td {
		  border: 1px solid black;
		  border-collapse: collapse;}
		th, td {padding: 2px;}
		th{text-align: center;}
		td.center{text-align: center;}	
		.abu{background-color: grey;}
		.ket{
			border: solid white !important;
		}


</style>
<?php 
include '../koneksi/config.php';
	//ambil data dari tabel instansi
	$instansi = mysqli_query($conn, "SELECT * FROM tabel_instansi WHERE id_instansi = 1") or die (mysqli_error($conn));

	//ambil data instansi dari object instansi
	$datainstansi = mysqli_fetch_assoc($instansi);

if(isset($_POST['cetak'])){
	$awal = $_POST['start'];
	$akhir = $_POST['end'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Kas Tensai</title>
</head>
<body>

	<center>
		<hr>
		<img src="../assets/img/<?= $datainstansi['logo_instansi']; ?>" style="float:left" width="100" alt="Profile" class="rounded-circle">
		<h2><?= $datainstansi['nama_instansi']; ?></h2>
		<?= $datainstansi['alamat_instansi']; ?><br>
		Website: <?= $datainstansi['website_instansi']; ?> - Email: <?= $datainstansi['email_instansi']; ?><br>
		Telp: <?= $datainstansi['telepon_instansi']; ?>		
		<hr color="black">
	</center>

	<p>Hal &ensp; &ensp; &ensp;: Laporan Keuangan</p>
	<p>Periode 	&ensp;: <?= date('d-m-Y', strtotime($awal)); ?> s/d <?= date('d-m-Y', strtotime($akhir)); ?></p>

	<table border="1" style="width: 100%">
		<tr class="abu">
            <th width="10px" height="15px">No.</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Dana Masuk</th>
			<th>Dana Keluar</th>
            <th>Saldo (Rp)</th>
		</tr>
		<?php 
			$sql="SELECT * FROM tabel_transaksi
					INNER JOIN tabel_kategori
					ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori 
					WHERE date(tabel_transaksi.tgl_transaksi) BETWEEN '$awal' AND '$akhir'
					ORDER BY id_transaksi ";
                                    
	        $hasil=mysqli_query($conn,$sql) or die(mysqli_error($conn));
	        $no=1;
			$saldo=0;
	        $totalpemasukan=0;
			$totalpengeluaran=0;
	        while ($data = mysqli_fetch_array($hasil)) {
				
				if($data['jenis']==="Dana masuk") {
					$totalpemasukan = $totalpemasukan+$data['jumlah_transaksi'];
					$saldo = $saldo+$data['jumlah_transaksi'];
				  }else if($data['jenis']==="Dana keluar"){
					$totalpengeluaran = $totalpengeluaran+$data['jumlah_transaksi'];
					$saldo = $saldo-$data['jumlah_transaksi'];
				  }
		?>
		<tr>
			<td><?= $no++;?></td>
            <td><?= $data["tgl_transaksi"]; ?></td>
            <td><?= $data["deskripsi_transaksi"]; ?></td>
            <?php if($data["jenis"]==="Dana masuk"): ?>
                          <td><?= number_format($data['jumlah_transaksi']);?></td>                        
                          <td>-</td>
                        <?php else: ?>
                          <td>-</td>                        
                          <td><?= number_format($data['jumlah_transaksi']); ?></td>
                        <?php endif; ?>
            <td align="right"><?= number_format($saldo); ?></td>
		</tr>
		<?php 
		}?>
		<tr>
			<td colspan="3"><center><b>Total </b></center></td>
			<td><b><?= number_format($totalpemasukan);?></b></td>
			<td><b><?= number_format($totalpengeluaran);?></b></td>
			<td align="right"><b><?= number_format($saldo);?></b></td>
		</tr>
	</table>
	<hr>
	<br>
	<table class="ket">
		
        <tr>
            <td class="ket"></td>
            <td align="right" class="ket">Tanah Merah, <?=date("d-m-Y")?></td>
        </tr>
		<tr>
            <td class="ket">Pimpinan</td>
            <td align="right" class="ket">Bendahara</td>
        </tr>
		<tr>
            <td class="ket"></td>
            <td class="ket"></td>
        </tr>
		<tr>
            <td class="ket"></td>
            <td class="ket"></td>
        </tr>
		<tr>
            <td class="ket"></td>
            <td class="ket"></td>
        </tr>
		<tr>
            <td class="ket"></td>
            <td class="ket"></td>
        </tr>
		<tr>
            <td class="ket"></td>
            <td class="ket"></td>
        </tr>
		<tr>
            <td class="ket"></td>
            <td class="ket"></td>
        </tr>
        <tr>
            <td class="ket"><u><b><?= $datainstansi['nama_pimpinan'] ?></b></u></td>
            <td align="right" class="ket"><u><b><?= $datainstansi['nama_bendahara'] ?></b></u></td>
        </tr>
    </table>
	
	<!-- <center>
	<h4 align="right"><b>Pekanbaru,</b> <?=date("d-m-Y")?></h4><br>
	<h4 align="left"><?= $datainstansi['nama_pimpinan'] ?></h4>
	<h4 align="right"><?= $datainstansi['nama_bendahara'] ?></h4>
	</center> -->
	<script>
		window.print();
	</script>
</body>
</html>

<?php 
}
?>