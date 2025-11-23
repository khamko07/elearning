<?php
require_once("../include/initialize.php");
?>

<?php
// login confirmation
if(isset($_SESSION['USERID'])){
  redirect(web_root."admin/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Login - eLearning</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom CSS -->
  <link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
  
  <style>
    .admin-login-container {
      background: linear-gradient(135deg, var(--secondary-indigo) 0%, var(--secondary-purple) 100%);
    }
    
    .admin-login-card {
      border-top: 4px solid var(--secondary-indigo);
    }
    
    .admin-login-header h2 {
      color: var(--secondary-indigo);
    }
  </style>
</head>
<body>
  <div class="login-container admin-login-container">
    <div class="login-card admin-login-card">
      <div class="login-header">
        <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo" class="login-logo">
        <h2>Admin Portal</h2>
        <p>Sign in to access the admin panel</p>
      </div>

      <?php echo check_message(); ?>

      <form class="login-form" action="" method="POST">
        <div class="form-group">
          <label for="user_email" class="form-label">Username</label>
          <div class="input-group">
            <span class="input-icon">
              <i class="fas fa-user-shield"></i>
            </span>
            <input 
              type="text" 
              id="user_email" 
              name="user_email" 
              class="form-control" 
              placeholder="Enter your username"
              required
              autocomplete="username"
            >
          </div>
        </div>

        <div class="form-group">
          <label for="user_pass" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-icon">
              <i class="fas fa-lock"></i>
            </span>
            <input 
              type="password" 
              id="user_pass" 
              name="user_pass" 
              class="form-control" 
              placeholder="Enter your password"
              required
              autocomplete="current-password"
            >
          </div>
        </div>

        <button type="submit" name="btnLogin" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, var(--secondary-indigo) 0%, var(--secondary-purple) 100%); border: none;">
          <i class="fas fa-sign-in-alt me-2"></i>Login
        </button>
      </form>

      <div class="login-footer">
        <a href="../index.php">
          <i class="fas fa-arrow-left me-2"></i>Back to Home
        </a>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if(isset($_POST['btnLogin'])){
  $email = trim($_POST['user_email']);
  $upass  = trim($_POST['user_pass']);
  $h_upass = sha1($upass);

  if ($email == '' OR $upass == '') {
    message("Invalid Username and Password!", "error");
    redirect("login.php");
  } else {
    //it creates a new objects of member
    $user = new User();
    //make use of the static function, and we passed to parameters
    $res = $user::userAuthentication($email, $h_upass);
    if ($res==true) {
      message("You login as ".$_SESSION['TYPE'].".","success");
      if ($_SESSION['TYPE']=='Administrator'){
        redirect(web_root."admin/index.php");
      } else {
        redirect(web_root."admin/login.php");
      }
    } else {
      message("Account does not exist! Please contact Administrator.", "error");
      redirect(web_root."admin/login.php");
    }
  }
}
?>
