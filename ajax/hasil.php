<?php
include '../koneksi.php';
$keyword = $_GET['keyword'];
?>

<table class="table table-bordered" style="margin-top: 15px; ">
	<tr  style="background: #131368; color: white;">
		<th>Nama</th>
		<th>Username</th>
		<th>Email</th>
		<th>Level</th>
		<th>Action</th>	
	</tr>
	<?php 
	$sql = "SELECT * FROM tb_login WHERE username LIKE '%$keyword%' 
	OR nama LIKE '%$keyword%' OR level LIKE '%$keyword%' OR email LIKE '%$keyword%'
	";	$run = mysqli_query($conn, $sql);
	while ($row = $run->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $row['nama']; ?></td>
			<td><?php echo $row['username']; ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['level']; ?></td>

			<td>
				<center>
					<a href="index.php?akses=admin&kl=a2&update=<?php echo $row['username'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
					<a href="index.php?akses=admin&kl=a2&delete=<?php echo $row['username'];?>"  onclick="return confirm('Anda Yakin Untuk Menghapus Akun ini?')" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="color: white;"></span></a>
				</center>
			</td>
		</tr>
	<?php } ?>
</table>
