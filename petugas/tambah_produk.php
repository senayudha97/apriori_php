
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="background-color:lavender;">
	<div class="row">
		<div class="col-sm-12">
			<div class="btn-group" role="group" aria-label="Basic example" style="margin-left:12px;">
				<button type="button" data-toggle="modal" data-target="#tproduk" class="btn btn-success">Tambah Produk</button>
				<button type="button" data-toggle="modal" data-target="#tkatogeori" class="btn btn-success">Tambah Kategori</button>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 15px; background-color:">
		<!-- Table List Akun -->
		<div class="col-sm-8">
			<div class="panel panel-default" style="margin-left: 10px;">
				<div class="panel-heading" style="background-color: #d66400; color:white;">
					<span class="glyphicon glyphicon-list-alt"></span>
					<b>Daftar Produk</b>
				</div>
				<div class="panel-body">
					<form action="" method="POST">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
							<input  id="keyword" type="text" class="form-control" name="keyword" placeholder="Isikan Keyword Untuk Mencari Data">
						</div>
					</form>
					<div id="hasil">
						<table class="table table-bordered" style="margin-top: 15px; ">
							<tr  style="background: #131368; color: white;">
								<th>Nama Produk</th>
								<th>Kategori Produk</th>
								<th>Satuan Produk</th>
								<th>Action</th>	
							</tr>
							<?php 
							$sql = "SELECT * FROM tb_barang";
							$run = mysqli_query($conn, $sql);
							while ($row = $run->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $row['nama_barang']; ?></td>
									<td><?php echo $row['kategori_barang']; ?></td>
									<td><?php echo $row['satuan']; ?></td>
									<td>
										<center>
											<a href="index.php?akses=petugas&kl=p2&update=<?php echo $row['id_barang'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
											<a href="index.php?akses=petugas&kl=p2&delete=<?php echo $row['id_barang'];?>"  onclick="return confirm('Anda Yakin Untuk Menghapus Produk ini?')" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="color: white;"></span></a>
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
				$id_barang = $_GET['update'];
				$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_barang WHERE id_barang = '$id_barang'"));
				?>
				<form action="" method="POST">
					<div class="panel panel-default" style="margin-left: 10px; position: absolute; width: 394px;">
						<div class="panel-heading" style="background-color: #d66400; color:white;">
							<span class="glyphicon glyphicon-edit"></span>
							<b>Update Form</b>
						</div>
						<div class="panel-body">
							<input type="hidden"  name="id_barang" value="<?php echo $data['id_barang']; ?>">
							<input required type="text" class="form-control" value="<?php echo $data['nama_barang']; ?>" name="nama_barang">
							<br>
							<select class="form-control" name="kategori">
								<option value="<?php echo $data['kategori_barang'] ?>"><?php echo $data['kategori_barang'] ?></option>
								<?php 
								$run 	=mysqli_query($conn, "SELECT * FROM `tb_kategori` ORDER BY kategori ASC");
								while ($row = $run->fetch_assoc()) {
									echo $row['kategori'];									
									?>
										<option value="<?php echo $row['kategori']; ?>"><?php echo $row['kategori']; ?></option>
								<?php } ?>
							</select> 	 	
							<br>
							<input required type="text" class="form-control" name="satuan" style="background-color: #80080" 
							value="<?php echo $data['satuan']; ?>">
							<br>
							<br>
							<input required type="submit" name="sendupdate" class="btn btn-sm btn-warning" value="CONFIRM">
						</div>
					</div>
				</form>
				<?php 
				if (isset($_POST['sendupdate'])) {
					$id_barang			= 	$_POST['id_barang'];
					$nama_barang		=	$_POST['nama_barang'];
					$satuan				=	$_POST['satuan'];
					$kategori_barang	=	$_POST['kategori'];

						// echo $nama.$email.$level;

					$run 	=	mysqli_query($conn, "UPDATE `tb_barang` SET `nama_barang`='$nama_barang',`kategori_barang`='$kategori_barang',`satuan`='$satuan' WHERE id_barang = '$id_barang'");
					if ($run){
						echo "<script>window.location='index.php?akses=petugas&kl=p2';</script>";
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
	<br>

	<!-- Modal Tambah Produk -->
	<form method="POST" action="">
		<div class="modal fade" id="tproduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="imgcontainer">
							<h4>ISI FORM TAMBAH PRODUK DENGAN BENAR</h4>
						</div>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-cart-plus"></i></span>
							<input required id="nama_barang" type="text" class="form-control" name="nama_barang" placeholder="Nama Barang">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-cart-plus"></i></span>
							<input required id="nama_barang" type="text" class="form-control" name="satuan" placeholder="Masukan Satuan Barang">
						</div>
						<br>	
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></span>
							<select class="form-control" name="kategori">
								<option selected>--Silahakan Pilih Kategori</option>
								<?php 
								$run 	=mysqli_query($conn, "SELECT * FROM tb_kategori");
								while ($row = $run->fetch_assoc()) {
									echo $row['kategori'];									
									?>
									<option value="<?php echo $row['kategori']; ?>"><?php echo $row['kategori']; ?></option>
								<?php } ?>
							</select>
						</div>
						<br>						
					</div>
					<div class="modal-footer">      
						<button type="submit" class="btn btn-block btn-success" name="tbarang" >
							<font color="White">
								<b>SIMPAN</b>
							</font>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- Modal Tambah Kategori -->
	<form method="POST" action="">
		<div class="modal fade" id="tkatogeori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="imgcontainer">
							<h4>ISI FORM TAMBAH KATEGORI DENGAN BENAR</h4>
						</div>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<input type="text" class="form-control" name="kategori" style="width: 90%" placeholder="Isi Dengan Nama Kategori Baru">
							<div class="input-group-append">
								<button type="submit" name="tkategori" class="btn btn-primary" type="submit"><i class="fa fa-plus"></i></button>
							</div>
						</div>
						<br>
					</div>
					<div class="modal-footer">      
					</div>
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript" src="js/ajax_search_tambah_barang.js"></script>
</body>
</html>

<?php 	
if (isset($_POST['tbarang'])) {
	$nama_barang 	= $_POST['nama_barang'];
	$kategori		=	$_POST['kategori'];
	$satuan 		=	$_POST['satuan'];
	$run			= mysqli_query($conn, "INSERT INTO `tb_barang`( `nama_barang`, `kategori_barang`, `satuan`) VALUES ('$nama_barang','$kategori','$satuan')");
	echo "<script>window.location='index.php?akses=petugas&kl=p2';</script>";
}
if (isset($_POST['tkategori'])) {
	$kategori		= $_POST['kategori'];

	$run		= mysqli_query($conn, "INSERT INTO `tb_kategori`(`id`, `kategori`) VALUES ('','$kategori')");
	echo "<script>window.location='index.php?akses=petugas&kl=p2';</script>";
}
if (isset($_GET['delete'])) {
	$id_barang	= $_GET['delete'];
	$run		= mysqli_query($conn, "DELETE FROM `tb_barang` WHERE id_barang = '$id_barang'");
			// header("Refresh:0");
	echo "<script>window.location='index.php?akses=petugas&kl=p2';</script>";			
}
?>