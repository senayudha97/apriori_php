<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <style type="text/css">
    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
    }
    img.avatar {
      width: 40%;
      border-radius: 50%;
    }
  </style>  
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #d66400; margin-top: -216px;">
    <a class="navbar-brand" href="#">LOGO BELUM DI BUAT</a>

    <div class="container">
      <!-- <img src="images/logo.png" class="navbar-brand" width="500px"> -->

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <button type="button" class="btn btn-lg" style="background: #131368;" data-toggle="modal" data-target="#exampleModalLong">
              <font color="White">
                <b>Login</b>
              </font>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Modal -->
  <form method="POST" action="cek_login.php">
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="imgcontainer">
              <center>
                <img src="images/login.png" alt="Avatar" class="avatar">
              </center>
            </div>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-user"></span>    
                <input type="text" class="form-control" placeholder="Username" name="username">
              </div>  
            </div>     
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-lock"></span>
                <input type="Password   " class="form-control" placeholder="Password" name="password">
              </div>            
            </div>
          </div>
          <div class="modal-footer">      
            <button type="submit" class="btn btn-block" name="kirim" style="background-color: #d66400 ;">
              <font color="White">
                <b>Login</b>
              </font>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
</html>