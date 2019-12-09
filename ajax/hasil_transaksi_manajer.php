<?php
include "../koneksi.php";
$keyword = $_GET['keyword'];
?>

<table class="table table-bordered" style="margin-top: 15px;">
	<tr  style="background: #131368; color: white;">
		<th>Id</th>
		<th>Transaction Date</th>
		<th>Produk</th>
		<th style="width: 20%;">Action</th>	
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
			<td>
				<center>
					<a href="index.php?akses=manajer&kl=m3&update=<?php echo $row['id'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
					<a href="index.php?akses=manajer&kl=m3&delete=<?php echo $row['id'];?>"  onclick="return confirm('Anda Yakin Untuk Menghapus Transaksi ini?')" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="color: white;"></span></a>
				</center>
			</td>
		</tr>
	<?php } ?>
</table>

