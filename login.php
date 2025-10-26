<?php 
require_once ("include/initialize.php");   
if (isset($_SESSION['StudentID'])) {
  redirect('index.php');
}
?> 

<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
  <title>Đăng nhập - Hệ thống E-Learning</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

  <!-- Bootstrap 5 -->
  <link href="<?php echo web_root; ?>css/bootstrap5.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">  
  
  <!-- Our Design System -->
  <link href="<?php echo web_root; ?>assets/css/main.css" rel="stylesheet">
</head>
<body>
  <!-- Theme Toggle Button -->
  <div class="fixed" style="top: 20px; right: 20px; z-index: 1000;">
    <button data-theme-toggle class="btn btn-ghost" title="Chuyển đổi giao diện">
      <i class="fas fa-moon"></i>
    </button>
  </div>

  <!-- Authentication Container -->
  <div class="auth-container">
    <?php check_message(); ?>
    
    <div class="auth-card">
      <div class="auth-header">
        <img src="images/text-ued-1.png" alt="Logo UED" class="auth-logo">
        <h1 class="auth-title">Đăng nhập</h1>
        <p class="auth-subtitle">Chào mừng trở lại hệ thống E-Learning!</p>
      </div>
      
      <form class="auth-form" action="" method="POST" id="loginForm"> 
        <div class="form-group">
          <label class="form-label required" for="user_email">Email hoặc Tên đăng nhập</label>
          <input 
            class="form-input" 
            type="text" 
            id="user_email"
            name="user_email" 
            placeholder="Nhập email hoặc tên đăng nhập..."
            required
            autocomplete="username"
          >
          <div class="form-error" id="email-error"></div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="user_pass">Mật khẩu</label>
          <div class="input-group">
            <input 
              class="form-input" 
              type="password" 
              id="user_pass"
              name="user_pass" 
              placeholder="Nhập mật khẩu..."
              required
              autocomplete="current-password"
            >
            <button type="button" class="input-addon" id="togglePassword" title="Hiện/ẩn mật khẩu">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="form-error" id="password-error"></div>
        </div>
        
        <button class="btn btn-primary btn-full" type="submit" name="btnLogin" id="loginBtn">
          <i class="fas fa-sign-in-alt"></i>
          <span>Đăng nhập</span>
          <div class="loading-spinner" id="loginSpinner" style="display: none;"></div>
        </button>
      </form>
      
      <div class="auth-footer">
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
        <a href="admin/login.php" class="admin-link">
          <i class="fas fa-user-shield"></i>
          Đăng nhập Admin
        </a>
      </div>
    </div>
  </div>
  
  

  <?php 

if(isset($_POST['btnLogin'])){
  $email = trim($_POST['user_email']);
  $upass  = trim($_POST['user_pass']);
  $h_upass = sha1($upass);
  
   if ($email == '' OR $upass == '') {

      message("Invalid Username and Password!", "error");
      redirect (web_root."login.php");
         
    } else {  
      //it creates a new objects of member
        $student = new Student();
        //make use of the static function, and we passed to parameters
        $res = $student::studentAuthentication($email, $h_upass);
        if ($res==true) {  
             redirect(web_root."index.php"); 

          echo $_SESSION['StudentID'];
        }else{
          message("Account does not exist! Please contact Administrator.", "error");
          redirect (web_root."login.php");
        }
   }
 } 
 ?> 

  <!-- Scripts -->
  <script src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap5.min.js"></script>
  <script src="<?php echo web_root; ?>assets/js/theme-manager.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Password visibility toggle
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('user_pass');
      const toggleIcon = togglePassword.querySelector('i');
      
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'password') {
          toggleIcon.className = 'fas fa-eye';
          togglePassword.setAttribute('title', 'Hiện mật khẩu');
        } else {
          toggleIcon.className = 'fas fa-eye-slash';
          togglePassword.setAttribute('title', 'Ẩn mật khẩu');
        }
      });
      
      // Form validation and loading state
      const loginForm = document.getElementById('loginForm');
      const loginBtn = document.getElementById('loginBtn');
      const loginSpinner = document.getElementById('loginSpinner');
      const btnText = loginBtn.querySelector('span');
      const btnIcon = loginBtn.querySelector('i');
      
      loginForm.addEventListener('submit', function(e) {
        // Clear previous errors
        document.getElementById('email-error').textContent = '';
        document.getElementById('password-error').textContent = '';
        
        const email = document.getElementById('user_email').value.trim();
        const password = document.getElementById('user_pass').value.trim();
        
        let hasError = false;
        
        // Client-side validation
        if (!email) {
          document.getElementById('email-error').textContent = 'Vui lòng nhập email hoặc tên đăng nhập';
          document.getElementById('user_email').classList.add('error');
          hasError = true;
        } else {
          document.getElementById('user_email').classList.remove('error');
        }
        
        if (!password) {
          document.getElementById('password-error').textContent = 'Vui lòng nhập mật khẩu';
          document.getElementById('user_pass').classList.add('error');
          hasError = true;
        } else {
          document.getElementById('user_pass').classList.remove('error');
        }
        
        if (hasError) {
          e.preventDefault();
          return;
        }
        
        // Show loading state
        loginBtn.disabled = true;
        btnIcon.style.display = 'none';
        btnText.textContent = 'Đang đăng nhập...';
        loginSpinner.style.display = 'inline-block';
      });
      
      // Auto-focus first input
      document.getElementById('user_email').focus();
      
      // Enhanced form interactions
      const formInputs = document.querySelectorAll('.form-input');
      formInputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
          this.parentElement.classList.remove('focused');
          if (this.classList.contains('error') && this.value.trim()) {
            this.classList.remove('error');
            const errorElement = document.getElementById(this.id + '-error');
            if (errorElement) {
              errorElement.textContent = '';
            }
          }
        });
      });
    });
  </script>

</body>
</html>