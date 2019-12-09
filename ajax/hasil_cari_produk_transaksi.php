<?php
include '../koneksi.php';
$keyword = $_GET['keyword'];
?>

<table class="table table-bordered" style="margin-top: 15px;">
	<tr  style="background: #131368; color: white;">
		<th>Add</th>
		<th>Nama Produk</th>
		<th>Kategori Produk</th>
		<th>Satuan Produk</th>
	</tr>
	<?php 
	$sql = "SELECT * FROM tb_barang WHERE id_barang LIKE '%$keyword%' 
	OR nama_barang LIKE '%$keyword%' OR satuan LIKE '%$keyword%' OR kategori_barang LIKE '%$keyword%'";
	$run = mysqli_query($conn, $sql);
	while ($row = $run->fetch_assoc()) { ?>
		<tr>
			<td><input type="button" class="button" value="+" onclick="insert('<?php echo $row['nama_barang']; ?>', '<?php echo $row['kategori_barang']; ?>')"></td>
			<td><?php echo $row['nama_barang']; ?></td>
			<td><?php echo $row['kategori_barang']; ?></td>
			<td><?php echo $row['satuan']; ?></td>
		</tr>
	<?php } ?>

</table>