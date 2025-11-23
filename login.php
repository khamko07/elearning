<?php 
require_once ("include/initialize.php");   
if (isset($_SESSION['StudentID'])) {
  redirect('index.php');
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Login - eLearning</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom CSS -->
  <link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo" class="login-logo">
        <h2>Welcome Back</h2>
        <p>Sign in to continue your learning journey</p>
      </div>

      <?php check_message(); ?>

      <form class="login-form" action="" method="POST">
        <div class="form-group">
          <label for="user_email" class="form-label">Username</label>
          <div class="input-group">
            <span class="input-icon">
              <i class="fas fa-user"></i>
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

        <button type="submit" name="btnLogin" class="btn btn-primary btn-block">
          <i class="fas fa-sign-in-alt me-2"></i>Login
        </button>
      </form>

      <div class="login-footer">
        <a href="register.php">
          <i class="fas fa-user-plus me-2"></i>Create Account
        </a>
        <span class="separator">|</span>
        <a href="admin/login.php">
          <i class="fas fa-user-shield me-2"></i>Admin Login
        </a>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <?php 
  if(isset($_POST['btnLogin'])){
    $email = trim($_POST['user_email']);
    $upass  = trim($_POST['user_pass']);
    $h_upass = sha1($upass);
    
    if ($email == '' OR $upass == '') {
      message("Invalid Username and Password!", "error");
      redirect(web_root."login.php");
    } else {  
      //it creates a new objects of member
      $student = new Student();
      //make use of the static function, and we passed to parameters
      $res = $student::studentAuthentication($email, $h_upass);
      if ($res==true) {  
        redirect(web_root."index.php"); 
        echo $_SESSION['StudentID'];
      } else {
        message("Account does not exist! Please contact Administrator.", "error");
        redirect(web_root."login.php");
      }
    }
  } 
  ?>
</body>
</html>
