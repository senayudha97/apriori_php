<?php
include "../koneksi.php";
$keyword = $_GET['keyword'];
?>

<table class="table table-bordered" style="margin-top: 15px;">
	<tr  style="background: #131368; color: white;">
		<th>Id Transaksi</th>
		<th>Transaction Date</th>
		<th>Produk</th>
	</tr>
	<?php 
	$sql = "SELECT * FROM tb_transaksi WHERE id LIKE '%$keyword%' 
	OR transaction_date LIKE '%$keyword%' OR produk LIKE '%$keyword%'";
	$run = mysqli_query($conn, $sql);
	while ($row = $run->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['transaction_date']; ?></td>
			<td><?php echo $row['produk']; ?></td>
		</tr>
	<?php } ?>
</table>	