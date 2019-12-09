<?php 
error_reporting(0);
include_once "database.php";
include_once "kumpulan_function.php";
include_once "mining.php";
include_once "display_mining.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Apriori Toko Bangunan</title>
	<link href="assets/images/icon/icon.ico" rel="shortcut icon" />	
</head>
<body style="background-color:lavender;">
	<?php
//object database class
	$db_object = new database();

	if (isset($_POST['submit'])) {
		$can_process = true;
		if (empty($_POST['min_support']) || empty($_POST['min_confidence'])) {
			$can_process = false;
			?>
			<script> location.replace("http://localhost/skripsi/index.php?akses=manajer&kl=m2");</script>
			<?php
		}
		if(!is_numeric($_POST['min_support']) || !is_numeric($_POST['min_confidence'])){
			$can_process = false;
			?>
			<script> location.replace("http://localhost/skripsi/index.php?akses=manajer&kl=m2");</script>
			<?php
		}

		if($can_process){
			$start = $_POST['awal'];
			$end   = $_POST['akhir'];

			if(isset($_POST['id_process'])){
				$id_process = $_POST['id_process'];
			//delete hitungan untuk id_process
				reset_hitungan($db_object, $id_process);

			//update log process
				$field = array(
					"start_date"=>$start,
					"end_date"=>$end,
					"min_support"=>$_POST['min_support'],
					"min_confidence"=>$_POST['min_confidence']
				);
				$where = array(
					"id"=>$id_process
				);
				$query = $db_object->update_record("process_log", $field, $where);
			}
			else{

			//insert log process
				$field_value = array(
					"start_date"=>$start,
					"end_date"=>$end,
					"min_support"=>$_POST['min_support'],
					"min_confidence"=>$_POST['min_confidence']
				);
				$query = $db_object->insert_record("process_log", $field_value);
				$id_process = $db_object->db_insert_id();
			}
			?>
			<!-- Form Setelah Pencarian Data -->
			<div class="panel panel-default" style="width: 95%; margin: auto;">
				<div class="panel-heading" style="background-color: #d66400; color:white;">
					<span class="glyphicon glyphicon-list-alt"></span>
					<b>Form Rule</b>
				</div>
				<div class="panel-body">
					<form method="post" action="">
						<div class="row">
							<div class="col-lg-4" >
								<!-- Date range -->
								<div class="form-group">
									<label>Range Tanggal: </label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="date" name="awal" id="awal" value="<?php echo $start; ?>" >
										<br>
										<input type="date" value="<?php echo $end; ?>" name="akhir" id="akhir">
									</div>
								</div>

								<div class="form-group">
									<button name="search_display" type="submit" class="btn btn-primary">Search Transaksi <i class="fa fa-search"></i></button>
								</div>
							</div>
							<div class="col-lg-4" >
								<label>Rule: </label>							
								<div class="form-group">
									<input name="min_support" type="number" class="form-control" id="minimumSupport" placeholder="Min Support">
								</div>
								<div class="form-group">
									<input name="min_confidence" type="number" class="form-control" placeholder="Min Confidence">
								</div>
								<div class="form-group">
									<button name="submit" style="margin-top: 5px;position: absolute;" type="submit" class="btn btn-success">Proses Apriori <i class="fa fa-check"></i></button>
								</div>
							</div>
							<div class="col-lg-4">
								<div style="margin: auto; size: 50%; background-color: #EEEEEE; height: 100%">
									<center>
										<div class="btn-group" role="group">
											<button type="button" style="margin-top: 10px;"  data-toggle="modal" data-target="#kesimpulan" class="btn btn-success btn-sm"><i class="fa fa-table"></i> Hasil Analisis</button>
										</div>
										<?php br(); ?>							
										<div style="width: 60%; margin: auto;" id="relativeSupport">
										</div>
									</center>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php modalKesimpulan(); ?>

			<br><div class="panel panel-default" style="width: 95%; margin: auto;">
				<div class="panel-heading" style="background-color: #d66400; color:white;">
					<span class="glyphicon glyphicon-list-alt"></span>
					<b>Hasil Apriori</b>
				</div>
				<div class="panel-body">

					<?php
					echo "Min Support Absolut: " . $_POST['min_support'];
					echo "<br>";
					$sql = "SELECT COUNT(*) FROM transaksi WHERE transaction_date BETWEEN '$start' AND '$end' ";
					$res = $db_object->db_query($sql);
					$num = $db_object->db_fetch_array($res);
					$minSupportRelatif = ($_POST['min_support']/$num[0]) * 100;
					echo "Min Support Relatif: " . $minSupportRelatif;
					echo "<br>";
					echo "Min Confidence: " . $_POST['min_confidence'];
					echo "<br>";
					echo "Start Date: " . $_POST['awal'].' - '.$_POST['akhir'];
					echo "<br>";

					$result = mining_process($db_object, $_POST['min_support'], $_POST['min_confidence'],
						$start, $end, $id_process);
					if ($result) {
						display_success("Proses mining selesai");
					} else {
						display_error("Gagal mendapatkan aturan asosiasi");
					}

					display_process_hasil_mining($db_object, $id_process);
					?>
				</div>
			</div>
			<?php
		}
	} 
	else {
		$where = "gagal";
		if(isset($_POST['search_display'])){
			$start = $_POST['awal'];
			$end   = $_POST['akhir'];


			$where = " WHERE a.id = b.id AND  a.transaction_date "
			. " BETWEEN '$start' AND '$end'";
		}
		$sql = "SELECT a.transaction_date, a.produk as kategori, b.produk as nama_produk 
		FROM transaksi a, tb_transaksi b  ".$where; /*echo $sql;*/

		$query = $db_object->db_query($sql);
		$jumlah = $db_object->db_num_rows($query);
		?>
		<div class="panel panel-default" style="width: 95%; margin: auto;">
			<div class="panel-heading" style="background-color: #d66400; color:white;">
				<span class="glyphicon glyphicon-list-alt"></span>
				<b>Form Rule</b>
			</div>
			<div class="panel-body">
				<form method="post" action="">
					<div class="row">
						<div class="col-lg-4" >
							<!-- Date range -->
							<div class="form-group">
								<label>Range Tanggal: </label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="date" name="awal" id="awal" value="<?php echo $start; ?>" >
									<br>
									<input type="date" value="<?php echo $end; ?>" name="akhir" id="akhir">
								</div>
							</div>

							<div class="form-group">
								<button name="search_display" type="submit" class="btn btn-primary">Search Transaksi <i class="fa fa-search"></i></button>
							</div>
						</div>
						<div class="col-lg-4" >
							<label>Rule: </label>							
							<div class="form-group">
								<input name="min_support" type="number" class="form-control" id="minimumSupport" placeholder="Min Support">
							</div>
							<div class="form-group">
								<input name="min_confidence" type="number" class="form-control" placeholder="Min Confidence">
							</div>
							<div class="form-group">
								<button name="submit" style="margin-top: 5px;position: absolute;" type="submit" class="btn btn-success">Proses Apriori <i class="fa fa-check"></i></button>
							</div>
						</div>
						<div class="col-lg-4">
							<div style="margin: auto; size: 50%; background-color: #EEEEEE; height: 100%">
								<center>
									<div class="btn-group" role="group">
										<button type="button" style="margin-top: 10px;"  data-toggle="modal" data-target="#kesimpulan" class="btn btn-success btn-sm"><i class="fa fa-table"></i> Hasil Analisis</button>
									</div>
									<?php br(); ?>							
									<div style="width: 60%; margin: auto;" id="relativeSupport">
									</div>
								</center>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php
		modalKesimpulan();

		if (!empty($pesan_error)) {
			display_error($pesan_error);
		}
		if (!empty($pesan_success)) {
			display_success($pesan_success);
		}


		if (isset($_GET['id_process'])) {
			br();
			$db_object = new database();
			$sql = "SELECT * FROM process_log ";
			$query=$db_object->db_query($sql);
			$jumlah=$db_object->db_num_rows($query);


			$id_process = 0;
			if(isset($_GET['id_process'])){
				$id_process = $_GET['id_process'];
			}
			$sql = "SELECT
			conf.*, log.start_date, log.end_date
			FROM
			confidence conf, process_log log
			WHERE conf.id_process = '$id_process' "
			. " AND conf.id_process = log.id ";

			$query=$db_object->db_query($sql);
			$jumlah=$db_object->db_num_rows($query);

			$sql_log = "SELECT * FROM process_log
			WHERE id = ".$id_process;
			$res_log = $db_object->db_query($sql_log);
			$row_log = $db_object->db_fetch_array($res_log);

			$no=1;
			while($row=$db_object->db_fetch_array($query)){
				$keterangan = ($row['confidence'] <= $row['min_confidence'])?"Tidak Lolos":"Lolos";
				$no++;
				if($row['lolos']==1){
					$data_confidence[] = $row;
				}
			}
			?>
			<div class="panel panel-default" style="width: 95%; margin: auto;">
				<div class="panel-heading" style="background-color: #d66400; color:white;">
					<span class="glyphicon glyphicon-list-alt"></span>
					<b>Hasil Kesimpulan dari Analisis Apriori</b>
				</div>
				<div class="panel-body">
		<!-- <a href="export/CLP.php?id_process=<?php echo $id_process; ?>" class="btn btn-app btn-light btn-xs" target="blank">
			<i class="ace-icon fa fa-print bigger-160"></i>
			Print
		</a> -->
		<br>
		<?php 
		echo "Dengan Tanggal Transaksi ->".$_GET['awal']." - ".$_GET['akhir'];br();
		echo "Minimum Support = ".$_GET['minSupport'];br();
		echo "Minimum Confidence = ".$_GET['minConfidence']."%";br();
		?>
		<br>
		<table class='table table-bordered table-striped  table-hover'>
			<?php
			$no=1;
			foreach($data_confidence as $key => $val){
				if($val['lolos']==1){
					echo "<tr>";
					echo "<td>".$no."</td>";
					echo "<td>Jika konsumen membeli ".$val['kombinasi1']
					.", maka konsumen juga akan membeli ".$val['kombinasi2']."</td>";
					echo "</tr>";
				}
				$no++;
			}
			?>
		</table>
	</div>
	</div><?php
}
elseif ($jumlah == 0) {
	br();
	display_warning("Data Kosong");
}
else {
	?>
	<br><div class="panel panel-default" style="width: 95%; margin: auto;">
		<div class="panel-heading" style="background-color: #d66400; color:white;">
			<span class="glyphicon glyphicon-list-alt"></span>
			<b>Daftar Transaksi (Tanggal : <?php echo $start.' - '.$end." | Dengan Jumlah Data:".$jumlah; ?>)</b>
		</div>
		<div class="panel-body">
			<table class='table table-bordered table-striped  table-hover'>
				<tr style="background-color: #131368;">

					<th style="color: white;">NO</th>
					<th style="color: white;">TANGGAL</th>
					<th style="color: white;">TRANSAKSI</th>
					<th style="color: white;">KATEGORI</th>

				</tr>
				<?php
				$no = 1;
				while ($row = $db_object->db_fetch_array($query)) {
					echo "<tr>";
					echo "<td>" . $no . "</td>";
					echo "<td>" . $row['transaction_date'] . "</td>";
					echo "<td>" . ucwords($row['nama_produk']) . "</td>";
					echo "<td>" . $row['kategori'] . "</td>";
					echo "</tr>";
					$no++;
				}
				?>
			</table>
		</div>
	</div>


	<?php
}           
}
?>
</div>
</div>
</div>
<script type="text/javascript" src="metode/ajax_hasilAnalisa.js"></script>
</body>
</html>