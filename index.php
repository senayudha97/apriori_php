<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'core/core.php'; 
  session_start();
  ?>
  <script type='text/javascript'> 
    title = "Penerapan Algoritma Apiori Untuk Menemukan Pola Pembelian Produk Bangunan";
    position = 0;
    function scrolltitle() {
      document.title = title.substring(position, title.length) + title.substring(0, position); 
      position++;
      if (position > title.length) position = 0;
      titleScroll = window.setTimeout(scrolltitle,20 );
    }
    scrolltitle();
  </script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
  <?php
  $load = '';
  if ($_GET['akses'] == 'gagal') {
    $load = 'gagal';
  }
  elseif ($_GET['akses'] == 'admin') {
    $load = 'admin';
  }
  elseif ($_GET['akses'] == 'petugas') {
    $load = 'petugas';
  }
  elseif ($_GET['akses'] == 'manajer') {
    $load = 'manajer';
  }
  else{
    $load = '';
  }
  

  if ($load == '') {
    header('location:landing_page/index.php');
  }
  elseif ($load == 'gagal') {
    echo "
    <script>
    alert('Anda Tidak Berhasil Login');
    </script>
    ";
    header('location:landing_page/index.php');
  }
  elseif ($load == 'admin') {
    if ($_SESSION['akses'] == "admin") {
      $kl  = $_GET['kl'];
      $sql = "SELECT * FROM kode_link WHERE kode = '$kl'";
      $run = mysqli_query($conn, $sql);
      $result = mysqli_fetch_assoc($run);
      include 'admin/header_admin.php';
      include $result['link'];      
    }
    else{
      header('location:index.php?pesan=gagal');    
    }
  }

  elseif ($load == 'petugas') {
   if ($_SESSION['akses'] == "petugas") {
    $kl  = $_GET['kl'];
    $sql = "SELECT * FROM kode_link WHERE kode = '$kl'";
    $run = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($run);
    include 'petugas/header_petugas.php';
    include $result['link'];
  }
  else{
    header('location:index.php?pesan=gagal');    
  }
}
  
elseif ($load == 'manajer') {
   if ($_SESSION['akses'] == "manajer") {
    $kl  = $_GET['kl'];
    $sql = "SELECT * FROM kode_link WHERE kode = '$kl'";
    $run = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($run);
    include 'manajer/header_manajer.php';
    include $result['link'];
  }
  else{
    header('location:index.php?pesan=gagal');    
  }
}
?>
</body>
</html>