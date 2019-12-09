<?php 
include_once "database.php";
include 'kumpulan_function.php';
error_reporting(0);

$tglAwal = $_GET['tglAwal'];
$tglAkhir = $_GET['tglAkhir'];
$minimumSupport = $_GET['minimumSupport'];

$db_object = new database();
$sql 	= "SELECT COUNT(*) FROM transaksi WHERE transaction_date BETWEEN '$tglAwal' AND '$tglAkhir' ";
$res 	= $db_object->db_query($sql);
$num 	= $db_object->db_fetch_array($res);
$pesan	="";
if ($num[0] > 0) {
	$hasilMinimumsupport = number_format(($minimumSupport/$num[0]) * 100)."%";
	if ($hasilMinimumsupport > 100) {
			$pesan = "Tidak di sarankan untuk melakukan proses Apriori, Minimum support tidak boleh melebihi banyaknya jumlah transaksi";
		}	
}
else{
	$hasilMinimumsupport = "Tidak di dapatkan, Jumlah Transaksi tidak ditemukan";
}

?>

<div style="width: 100%; margin: auto;" id="relativeSupport">
	<b>Jumlah Transaksi : </b><?php echo $num[0] - 1; ?><br>
	<b>Relative Support : </b><?php echo $hasilMinimumsupport; ?><br>
	<?php echo $pesan; ?>
</div>