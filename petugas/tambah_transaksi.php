<!DOCTYPE html>
<html>
<head>
</head>
<body style="background-color:lavender;">
	<div class="row" style="margin-top: 15px; background-color:">
		<!-- Table List Akun -->
		<div class="col-sm-6">
			<div class="panel panel-default" style="margin-left: 10px;">
				<div class="panel-heading" style="background-color: #d66400; color:white;">
					<span class="glyphicon glyphicon-list-alt"></span>
					<b>Daftar Transaksi</b>
				</div>
				<div class="panel-body">
					<form action="" method="POST" name="form">
						<div class="input-group">
							<input  id="order" type="text" class="form-control" name="barang" placeholder="Pilih Barang pada Table di Bawah" style="background-color: #EEEEEE" style="width: 93%">
							<br><br>
							<input  id="order" type="text" class="form-control" name="kategori" placeholder="Pilih Barang pada Table di Bawah" style="background-color: #EEEEEE" style="width: 93%">
							<br><br>
							<input type="date" class="form-control" name="tgl_transaksi" style="width: 86%">
							<button type="submit" name="ktransaksi" class="btn btn-outline-success" style="position: absolute; margin-left: 20px; border: 1px solid #28A745;"><i class="fa fa-check"></i></button>
						</div>
					</form>
					<br>
					<form action="" method="POST">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
							<input  id="keyword_cari_produk" type="text" class="form-control" name="keyword_cari_produk" placeholder="Isikan Keyword Untuk Mencari Data">
						</div>
					</form>					
					<div id="cari_produk">
						<table class="table table-bordered" style="margin-top: 15px;">
							<tr  style="background: #131368; color: white;">
								<th>Add</th>
								<th>Nama Produk</th>
								<th>Kategori Produk</th>
								<th>Satuan Produk</th>
							</tr>
							<?php 
							$sql = "SELECT * FROM tb_barang ORDER BY kategori_barang ASC";
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
					</div>
				</div>

			</div>
		</div>
		<script>
			var selected = [];
			function input(){
				selected = Array.from(document.querySelectorAll("input[type=checkbox]:checked")) 
				.map(function(checkbox) { return checkbox.value; })
				.join(',');                    
				document.getElementById('order').value = selected;
			}
		</script>
		<!-- Table Transaksi -->
		<div class="col-sm-6">
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
								<th>Id Transaksi</th>
								<th>Transaction Date</th>
								<th>Produk</th>
							</tr>
							<?php 
							$sql = "SELECT * FROM tb_transaksi";
							$run = mysqli_query($conn, $sql);
							while ($row = $run->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $row['transaction_date']; ?></td>
									<td><?php echo $row['produk']; ?></td>
								</tr>
							<?php } ?>

						</table>
					</div>
				</div>

			</div>
		</div>
		<br>
		<!-- <script type="text/javascript" src="js/ajax_search_produk_transaksi.js"></script> -->
		<script type="text/javascript" src="js/ajax_search_transaksi.js"></script>



		<!-- DOM untuk Load Barang dan Kategori -->
		<script type="text/javascript">
			function insert(nama_barang, kategori_barang) {
				var barang = document.form.barang.value;
				var kategori = document.form.kategori.value;
				if (barang.length < 1) {
					var barang = document.form.barang.value = document.form.barang.value + nama_barang ;
					var kategori = document.form.kategori.value = document.form.kategori.value  + kategori_barang;
				}
				else
				{
					var barang = document.form.barang.value = document.form.barang.value + "," + nama_barang ;
					var kategori = document.form.kategori.value = document.form.kategori.value  + "," + kategori_barang;			
				}
			}
			function clean() {
				document.form.barang.value = "";
				document.form.kategori.value = "";
			}
		</script>
	</body>
	</html>

	<?php 	
	if (isset($_POST['ktransaksi'])) {
		$nama_barang 	= $_POST['barang'];
		$kategori_barang= $_POST['kategori'];
		$tgl_transaksi	=	$_POST['tgl_transaksi'];
		$tb_transaksi			= mysqli_query($conn, "INSERT INTO `tb_transaksi`(`id`, `transaction_date`, `produk`) VALUES ('','$tgl_transaksi','$nama_barang')");
		$transaksi			= mysqli_query($conn, "INSERT INTO `transaksi`(`id`, `transaction_date`, `produk`) VALUES ('','$tgl_transaksi','$kategori_barang')");
		echo "<script>window.location='index.php?akses=petugas&kl=p3';</script>";
	}
	?>