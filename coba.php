<?php 
include_once "metode/database.php";
include_once "metode/kumpulan_function.php";
include_once "metode/mining.php";

$db_object = new database();
$sql = "SELECT * FROM process_log ";
$query=$db_object->db_query($sql);
$jumlah=$db_object->db_num_rows($query);

if($jumlah==0){
	echo "Data kosong...";
}
else{
	?>
	<table class='table table-bordered table-striped  table-hover'>
		<tr>
			<th>No</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Min Support</th>
			<th>Min Confidence</th>
			<th>Lihat Analisa</th>
		</tr>
		<?php
		$no=1;
		while($row=$db_object->db_fetch_array($query)){
			echo "<tr>";
			echo "<td>".$no."</td>";
			echo "<td>".format_date2($row['start_date'])."</td>";
			echo "<td>".format_date2($row['end_date'])."</td>";
			echo "<td>".$row['min_support']."</td>";
			echo "<td>".$row['min_confidence']."</td>";
			$view = "<a href='coba_result.php?&id_process=".$row['id']."'>View rule</a>";
			echo "<td>".$view."</td>";
			$no++;
		}
		?>
	</table>
	<?php
}
?>