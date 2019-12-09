<!DOCTYPE html>
<html>
<body style="background-color:lavender;">
	<div class="row" style="margin-top: 15px; background-color:">
		
		<!-- Table Transaksi -->
		<div class="col-sm-8">
			<div class="panel panel-default" style="margin-left: 10px;">
				<div class="panel-heading" style="background-color: #d66400; color:white;">
					<span class="glyphicon glyphicon-list-alt"></span>
					<b>Daftar Transaksi</b>
				</div>
				<div class="panel-body">
					<form action="" method="POST">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
							<input  id="keyword_cari_transaksi" type="text" class="form-control" name="keyword_cari_transaksi" placeholder="Isikan Keyword Untuk Mencari Data">
						</div>
					</form>
					<div id="cari_transaksi">
						<table class="table table-bordered" style="margin-top: 15px;">
							<tr  style="background: #131368; color: white;">
								<th>Id</th>
								<th>Transaction Date</th>
								<th>Produk</th>
								<th style="width: 20%;">Action</th>	
							</tr>
							<?php 
							$sql = "SELECT * FROM tb_transaksi";
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
					</div>
				</div>
			</div>
		</div>
		<!-- Update Panel -->
		<div class="col-sm-4">
			<?php  
			if (isset($_GET['update'])) {
				$id_transaksi = $_GET['update'];
				$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE id = '$id_transaksi'"));
				$data2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id = '$id_transaksi'"));
				?>
				<form action="" method="POST">
					<div class="panel panel-default" style="margin-left: 10px; position: absolute; width: 394px;">
						<div class="panel-heading" style="background-color: #d66400; color:white;">
							<span class="glyphicon glyphicon-edit"></span>
							<b>Update Form</b>
						</div>
						<div class="panel-body">
							<input type="hidden"  name="id_transaksi" value="<?php echo $data['id']; ?>">
							<input required type="date" class="form-control" value="<?php echo $data['transaction_date']; ?>" name="tgl_transaksi">
							<br>
							<textarea class="form-control" name="produk" rows="5"><?php echo $data['produk']; ?></textarea>
							<br>
							<textarea class="form-control" name="kategori" rows="5"><?php echo $data2['produk']; ?></textarea>				
							<br>
							<br>
							<input required type="submit" name="sendupdate" class="btn btn-sm btn-warning" value="CONFIRM">
						</div>
					</div>
				</form>
				<?php 
				if (isset($_POST['sendupdate'])) {
					$id_transaksi 	= $_POST['id_transaksi'];
					$tgl_transaksi	= $_POST['tgl_transaksi'];
					$produk 		= $_POST['produk'];
					$kategori 		= $_POST['kategori'];

					$run 	=	mysqli_query($conn, "UPDATE `tb_transaksi` SET `transaction_date`='$tgl_transaksi',`produk`='$produk' WHERE id = '$id_transaksi'");
					$run_kategori 	=	mysqli_query($conn, "UPDATE `transaksi` SET `transaction_date`='$tgl_transaksi',`produk`='$kategori' WHERE id = '$id_transaksi'");
					if ($run && $run_kategori){
						echo "<script>window.location='index.php?akses=manajer&kl=m3';</script>";
					}
					else{
						echo "gagal";
					}
				}
			}
			else{
			} ?>
		</div>
	</div>
</div>
<br>
<script type="text/javascript" src="js/ajax_transaksi_manajer.js"></script>
</body>
</html>

<?php 	
if (isset($_POST['tambah'])) {
	$nama		= $_POST['nama'];
	$username	= $_POST['username'];
	$password	= $_POST['password'];
	$email		= $_POST['email'];
	$level 		= $_POST['level'];

	$run		= mysqli_query($conn, "INSERT INTO `tb_login`(`nama`, `username`, `password`, `email`, `level`) VALUES ('$nama','$username','$password','$email','$level')");
			// header("Refresh:0");
			// header('location:index.php');
	echo "<script>window.location='index.php?akses=admin&kl=a2';</script>";
}
if (isset($_GET['delete'])) {
	$username	= $_GET['delete'];
	$run		= mysqli_query($conn, "DELETE FROM `tb_login` WHERE username = '$username'");
			// header("Refresh:0");
	echo "<script>window.location='index.php?akses=admin&kl=a2';</script>";			
}
?>