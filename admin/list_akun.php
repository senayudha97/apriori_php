<?php 
include 'koneksi.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body style="background-color:lavenderblush;">
	<div class="row">
		<div class="col-sm-12">
			<button class="btn btn-success" data-toggle="modal" data-target="#regis" style="margin-left:12px;"><b>Tambah Akun  </b><span class="glyphicon glyphicon-plus
				"></span></button>
			</div>
		</div>
		<div class="row" style="margin-top: 15px; background-color:">
			<!-- Table List Akun -->
			<div class="col-sm-8">
				<div class="panel panel-default" style="margin-left: 10px;">
					<div class="panel-heading" style="background-color: #d66400; color:white;">
						<span class="glyphicon glyphicon-list-alt"></span>
						<b>Daftar Akun</b>
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
								<th>Nama</th>
								<th>Username</th>
								<th>Email</th>
								<th>Level</th>
								<th>Action</th>	
							</tr>
							<?php 
							$sql = "SELECT * FROM tb_login";
							$run = mysqli_query($conn, $sql);
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
						</div>
					</div>

				</div>
			</div>
			<!-- Update Panel -->
			<div class="col-sm-4">
				<?php  
				if (isset($_GET['update'])) {
					$username = $_GET['update'];
					$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_login WHERE username = '$username'"));
					?>
					<form action="" method="POST">
						<div class="panel panel-default" style="margin-left: 10px; position: absolute; width: 394px;">
							<div class="panel-heading" style="background-color: #d66400; color:white;">
								<span class="glyphicon glyphicon-edit"></span>
								<b>Update Form</b>
							</div>
							<div class="panel-body">
								<input required type="text" class="form-control" value="<?php echo $data['nama']; ?>" name="nama">
								<br>
								<input required type="text" class="form-control" readonly style="background-color: #80080" value="<?php echo $data['username']; ?>">
								<br>
								<input required type="text" class="form-control" value="<?php echo $data['email']; ?>" name="email">
								<br>
								<select class="form-control" name="level">
									<option value="<?php echo $data['level']; ?>" style="color: grey;" selected><?php echo $data['level']; ?></option>
									<option>Admin</option>
									<option>Petugas</option>
									<option>Manajer</option>
								</select>
								<br>
								<input required type="submit" name="sendupdate" class="btn btn-sm btn-warning" value="CONFIRM">
							</div>
						</div>
					</form>
					<?php 
					if (isset($_POST['sendupdate'])) {
						$nama	=	$_POST['nama'];
						$email	=	$_POST['email'];
						$level	=	$_POST['level'];

						// echo $nama.$email.$level;

						$run 	=	mysqli_query($conn, "UPDATE `tb_login` SET `level`='$level',`nama`='$nama',`email`='$email' WHERE username = '$username'");
						if ($run){
							echo "<script>window.location='index.php?akses=admin&kl=a2';</script>";
						}
						else{
							echo "gagal";
						}
					}
				}
				else{
					function chartquery($level)
					{
						global $conn;
						$chart = mysqli_fetch_assoc(mysqli_query($conn,  "SELECT level, COUNT(*) AS jumlah FROM tb_login WHERE level IN ('$level')
							GROUP BY level"));
						return  $chart['jumlah'];
					}
					$dataPoints = array(
						array("label"=> "Admin", "y"=> chartquery('admin')),
						array("label"=> "Petugas", "y"=> chartquery('petugas')),
						array("label"=> "Manajer", "y"=> chartquery('manajer'))
					);
					?>
					<script>
						window.onload = function () {

							var chart = new CanvasJS.Chart("chartContainer", {
								animationEnabled: true,
								exportEnabled: true,
								title:{
									text: "Chart Akun"
								},
								data: [{
									type: "pie",
									showInLegend: "true",
									legendText: "{label}",
									indexLabelFontSize: 16,
									yValueFormatString: "#,##0",
									dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
								}]
							});
							chart.render();

						}
					</script>
					<div id="chartContainer" style="height: 370px; width: 400px;"></div>
					<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				<?php } ?>
			</div>
		</div>
		<br>

		<!-- Modal -->
		<form method="POST" action="">
			<div class="modal fade" id="regis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="imgcontainer">
								<h3>ISI FORM REGISTER DENGAN BENAR</h3>
							</div>
						</div>
						<div class="modal-body">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input required id="email" type="text" class="form-control" name="nama" placeholder="Nama Lengkap">
							</div>
							<br>	
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input required id="email" type="text" class="form-control" name="username" placeholder="Username">
							</div>
							<br>	
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input required id="email" type="text" class="form-control" name="password" placeholder="Password">
							</div>
							<br>	
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input required id="email" type="text" class="form-control" name="email" placeholder="Email">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></span>
								<select class="form-control" name="level">
									<option value="admin">admin</option>
									<option value="petugas">petugas</option>
									<option value="manajer">manajer</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">      
							<button type="submit" class="btn btn-block btn-success" name="tambah" >
								<font color="White">
									<b>SIMPAN</b>
								</font>
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript" src="js/ajax_search.js"></script>
	</body>
	</html>

	<?php 	
	if (isset($_POST['tambah'])) {
		$nama		= $_POST['nama'];
		$username	= $_POST['username'];
		$password	= sha1($_POST['password']);
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