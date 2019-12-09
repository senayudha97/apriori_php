<?php
include 'koneksi.php';
session_start();
// error_reporting(0);


if (isset($_POST['kirim'])) {
	$username	=	$_POST['username'];
	$password	=	sha1($_POST['password']);

	$sql 		=	"SELECT * FROM tb_login WHERE username = '$username' AND password = '$password'";
	$run		= 	mysqli_query($conn, $sql);
	$cek		=	mysqli_num_rows($run);

	if ($cek	> 	0) {
		$data	=	mysqli_fetch_assoc($run);


		if ($data['level'] == 'admin') {
			$_SESSION['username'] = $username;
			$_SESSION['akses']  = "admin";
			header('location:index.php?akses=admin&kl=a1');
		}
		else if ($data['level'] == 'petugas') {
			$_SESSION['username'] = $username;
			$_SESSION['akses']  = "petugas";
			header('location:index.php?akses=petugas&kl=p1');
		}
		else if ($data['level'] == 'manajer') {
			$_SESSION['username'] = $username;
			$_SESSION['akses']  = "manajer";
			header('location:index.php?akses=manajer&kl=m1');
		}
		else
		{
			header('location:index.php?akses=gagal');
		}
	}
	else{
		header('location:index.php?akses=gagal');
	}
}
?>