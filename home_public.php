<?php 
require_once("include/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet">
  <style type="text/css">
    body {
      margin: 0;
      background: url('assets/ued.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .overlay {
      background: rgba(0,0,0,0.35);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 24px;
    }
    .card-landing {
      background: rgba(255,255,255,0.95);
      border-radius: 14px;
      padding: 30px 28px 24px 28px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.25);
      max-width: 720px;
      width: 100%;
    }
    .logo {
      max-width: 80%;
      height: auto;
      margin-bottom: 16px;
    }
    .btn-row { margin-top: 14px; }
  </style>
</head>
<body>
  <div class="overlay">
    <div class="card-landing">
      <img class="logo" src="images/text-ued-1.png" alt="Logo">
      <p class="lead" style="margin-bottom: 0;">Welcome to the E-Learning Portal</p>
      <div class="row btn-row">
        <div class="col-sm-4" style="margin-bottom: 8px;"><a class="btn btn-primary btn-block" href="login.php">Student Login</a></div>
        <div class="col-sm-4" style="margin-bottom: 8px;"><a class="btn btn-default btn-block" href="admin/login.php">Admin Login</a></div>
        <div class="col-sm-4" style="margin-bottom: 8px;"><a class="btn btn-success btn-block" href="register.php">Register</a></div>
      </div>
    </div>
  </div>
  <script src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap.min.js"></script>
</body>
</html>


