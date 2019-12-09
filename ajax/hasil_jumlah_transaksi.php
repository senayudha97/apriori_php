<?php
include '../koneksi.php';
$keyword = $_GET['keyword'];
?>

<table class="table table-bordered" style="margin-top: 15px; ">
	<tr  style="background: #131368; color: white;">
		<th>Nama Produk</th>
		<th>Kategori Produk</th>
		<th>Satuan Produk</th>
		<th>Action</th>	
	</tr>
	<?php 
	$sql = "SELECT * FROM tb_barang WHERE id_barang LIKE '%$keyword%' 
	OR nama_barang LIKE '%$keyword%' OR satuan LIKE '%$keyword%' OR kategori_barang LIKE '%$keyword%'
	";	$run = mysqli_query($conn, $sql);
	while ($row = $run->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $row['nama_barang']; ?></td>
			<td><?php echo $row['kategori_barang']; ?></td>
			<td><?php echo $row['satuan']; ?></td>
			<td>
				<center>
					<a href="index.php?akses=petugas&kl=p2&update=<?php echo $row['id_barang'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
					<a href="index.php?akses=petugas&kl=p2&delete=<?php echo $row['id_barang'];?>"  onclick="return confirm('Anda Yakin Untuk Menghapus Akun ini?')" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="color: white;"></span></a>
				</center>
			</td>
		</tr>
	<?php } ?>
</table>
