<?php 
include "metode/database.php";
include "metode/kumpulan_function.php";
include "metode/mining.php";
include "metode/display_mining.php";

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


$sql1 = "SELECT
conf.*, log.start_date, log.end_date
FROM
confidence conf, process_log log
WHERE conf.id_process = '$id_process' "
. " AND conf.id_process = log.id "
. " AND conf.from_itemset=2 "
;
$query1=$db_object->db_query($sql1);
$jumlah1=$db_object->db_num_rows($query1);

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
<h2>Hasil Analisa</h2>
<!-- <a href="export/CLP.php?id_process=<?php echo $id_process; ?>" class="btn btn-app btn-light btn-xs" target="blank">
	<i class="ace-icon fa fa-print bigger-160"></i>
	Print
</a> -->
<br>
<table class='table table-bordered table-striped  table-hover'>
	<?php
	$no=1;
	foreach($data_confidence as $key => $val){
		if($val['lolos']==1){
			echo "<tr>";
			echo "<td>".$no.". Jika konsumen membeli ".$val['kombinasi1']
			.", maka konsumen juga akan membeli ".$val['kombinasi2']."</td>";
			echo "</tr>";
		}
		$no++;
	}
	?>
</table>