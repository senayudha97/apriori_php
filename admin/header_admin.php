<!DOCTYPE html>
<html>
<head>
  <?php
  $menu = 'nav-item';$menu2 = 'nav-item';$menu3 = 'nav-item'; 
  {if ($_GET['kl'] == 'a1') {
    $menu = 'nav-item active';
  }
  elseif ($_GET['kl'] == 'a2') {
    $menu2 = 'nav-item active'; 
  }
  elseif ($_GET['kl'] == 'a3') {
    $menu3 = 'nav-item active';
  }}
  ?>
</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark fixed-top" style="background-color: #d66400;">
    <!-- <a class="navbar-brand" href="#">LOGO BELUM DI BUAT</a> -->
    <img src="images/logo2.png"   width="12%">

    <div class="container" style="margin-left: -15px;">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="<?php echo $menu; ?>" style="margin-top: 10px; width: 126px;">
           <a href="index.php?akses=admin&kl=a1" class="nav-link">
            <center>
              <span class="glyphicon glyphicon-home" style="color: white;"></span>
              <font size="4"><b>Home</b></font>
            </center>
          </a>
        </li>
        <span style="color :white; margin-top: 25px; font-size: 16px;"><b>|</b></span>
        <li class="<?php echo $menu2; ?> " style="margin-top: 10px; width: 141px;">
         <a href="index.php?akses=admin&kl=a2" class="nav-link">
          <center>
            <span class="glyphicon glyphicon-paste" style="color: white;"></span>
            <font size="4"><b>List Akun</b></font>
          </center>
        </a>
      </li>
      <span style="color :white; margin-top: 25px; font-size: 16px;"><b>|</b></span>
  </ul>
  <ul class="nav navbar-nav navbar-right" style="margin-top: 14px;">
    <li class="nav-link">
      <button type="button" onclick="window.location.href='logout.php'" class="btn btn-md" style="background: #131368; margin-left: -17px; position: absolute;">
        <span class="glyphicon glyphicon-log-out" style="color: white;"></span>
        <font color="White">
          <b>Logout</b>
        </font>
      </button>
    </li>
  </ul>
</div>
</div>
</nav>
</body>
</html>