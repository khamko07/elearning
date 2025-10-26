<?php
require_once("../include/initialize.php");

// login confirmation
if(isset($_SESSION['USERID'])){
  redirect(web_root."admin/index.php");
}
?>

<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
  <title>Đăng nhập Admin - Hệ thống E-Learning</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>

  <!-- Bootstrap 5 -->
  <link href="<?php echo web_root; ?>css/bootstrap5.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">  
  
  <!-- Our Design System -->
  <link href="<?php echo web_root; ?>assets/css/main.css" rel="stylesheet">
  
  <style>
    /* Admin-specific styling */
    .admin-auth-container {
      background: linear-gradient(135deg, var(--secondary-red) 0%, var(--secondary-red-dark) 100%);
    }
    
    .admin-auth-card {
      border-left: 4px solid var(--secondary-red);
    }
    
    .admin-auth-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--secondary-red), var(--secondary-orange), var(--secondary-red));
    }
    
    .admin-badge {
      display: inline-flex;
      align-items: center;
      gap: var(--space-2);
      background: var(--secondary-red-light);
      color: var(--secondary-red-dark);
      padding: var(--space-1) var(--space-3);
      border-radius: var(--radius-full);
      font-size: var(--text-xs);
      font-weight: var(--font-weight-semibold);
      margin-bottom: var(--space-4);
    }
    
    .admin-icon {
      background: var(--secondary-red-100);
      color: var(--secondary-red);
    }
    
    [data-theme="dark"] .admin-badge {
      background: var(--secondary-red-dark);
      color: var(--secondary-red-light);
    }
  </style>
</head>
<body>
  <!-- Theme Toggle Button -->
  <div class="fixed" style="top: 20px; right: 20px; z-index: 1000;">
    <button data-theme-toggle class="btn btn-ghost" title="Chuyển đổi giao diện">
      <i class="fas fa-moon"></i>
    </button>
  </div>

  <!-- Admin Authentication Container -->
  <div class="auth-container admin-auth-container">
    <?php check_message(); ?>
    
    <div class="auth-card admin-auth-card" style="position: relative;">
      <div class="admin-badge">
        <i class="fas fa-shield-alt"></i>
        <span>Khu vực quản trị</span>
      </div>
      
      <div class="auth-header">
        <div class="admin-icon" style="width: 4rem; height: 4rem; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-4);">
          <i class="fas fa-user-shield" style="font-size: var(--text-2xl);"></i>
        </div>
        <h1 class="auth-title">Đăng nhập Admin</h1>
        <p class="auth-subtitle">Truy cập hệ thống quản trị E-Learning</p>
      </div>
      
      <form class="auth-form" action="" method="POST" id="adminLoginForm"> 
        <div class="form-group">
          <label class="form-label required" for="user_email">Tên đăng nhập Admin</label>
          <div class="input-group">
            <div class="input-addon" style="border-right: 1px solid var(--border); border-top-right-radius: 0; border-bottom-right-radius: 0;">
              <i class="fas fa-user-tie"></i>
            </div>
            <input 
              class="form-input" 
              type="text" 
              id="user_email"
              name="user_email" 
              placeholder="Nhập tên đăng nhập admin..."
              required
              autocomplete="username"
              style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
            >
          </div>
          <div class="form-error" id="email-error"></div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="user_pass">Mật khẩu Admin</label>
          <div class="input-group">
            <div class="input-addon" style="border-right: 1px solid var(--border); border-top-right-radius: 0; border-bottom-right-radius: 0;">
              <i class="fas fa-lock"></i>
            </div>
            <input 
              class="form-input" 
              type="password" 
              id="user_pass"
              name="user_pass" 
              placeholder="Nhập mật khẩu admin..."
              required
              autocomplete="current-password"
              style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-right: 0;"
            >
            <button type="button" class="input-addon" id="togglePassword" title="Hiện/ẩn mật khẩu" style="border-left: 0;">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="form-error" id="password-error"></div>
        </div>
        
        <button class="btn btn-full" type="submit" name="btnLogin" id="loginBtn" style="background-color: var(--secondary-red); border-color: var(--secondary-red); color: white;">
          <i class="fas fa-sign-in-alt"></i>
          <span>Đăng nhập Admin</span>
          <div class="loading-spinner" id="loginSpinner" style="display: none;"></div>
        </button>
      </form>
      
      <div class="auth-footer">
        <p><a href="../login.php">Đăng nhập học viên</a> | <a href="../index.php">Về trang chủ</a></p>
        <div class="text-center mt-4">
          <small class="text-muted">
            <i class="fas fa-info-circle"></i>
            Chỉ dành cho quản trị viên hệ thống
          </small>
        </div>
      </div>
    </div>
  </div>
  
  

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
      const loginForm = document.getElementById('adminLoginForm');
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
          document.getElementById('email-error').textContent = 'Vui lòng nhập tên đăng nhập admin';
          document.getElementById('user_email').classList.add('error');
          hasError = true;
        } else {
          document.getElementById('user_email').classList.remove('error');
        }
        
        if (!password) {
          document.getElementById('password-error').textContent = 'Vui lòng nhập mật khẩu admin';
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
        btnText.textContent = 'Đang xác thực...';
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
      
      // Admin-specific security warning
      console.warn('🔒 Admin Area - Unauthorized access is prohibited');
    });
  </script>

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
      }else{
           redirect(web_root."admin/login.php");
      }
    }else{
      message("Account does not exist! Please contact Administrator.", "error");
       redirect(web_root."admin/login.php");
    }
 }
 }
 ?> 