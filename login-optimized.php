<?php 
require_once ("include/initialize.php");
require_once ("include/asset-loader.php");

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
  <meta name="description" content="Đăng nhập vào hệ thống E-Learning để truy cập các khóa học và bài tập">
  
  <!-- Resource Hints -->
  <?php echo asset_hints(); ?>
  
  <!-- Preload Critical Resources -->
  <?php echo asset_preload(); ?>
  
  <!-- Critical CSS Inline -->
  <?php echo asset_css(true); ?>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo asset_url('images/icons/favicon.ico'); ?>"/>
  
  <!-- Bootstrap 5 -->
  <link href="<?php echo asset_url('css/bootstrap5.min.css'); ?>" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="<?php echo asset_url('fonts/font-awesome.min.css'); ?>" rel="stylesheet" media="screen">
  
  <!-- Non-Critical CSS (Async Loading) -->
  <link rel="preload" href="<?php echo asset_url('assets/css/main.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="<?php echo asset_url('assets/css/main.css'); ?>"></noscript>
</head>
<body>
  <!-- Skip to main content link for screen readers -->
  <a href="#main-content" class="skip-link">Bỏ qua đến nội dung chính</a>

  <!-- Theme Toggle Button -->
  <div class="fixed" style="top: 20px; right: 20px; z-index: 1000;">
    <button 
      data-theme-toggle 
      class="btn btn-ghost" 
      aria-label="Chuyển đổi giao diện sáng/tối"
      title="Chuyển đổi giao diện">
      <i class="fas fa-moon" aria-hidden="true"></i>
    </button>
  </div>

  <!-- Main Content -->
  <main id="main-content" class="auth-container" role="main">
    <!-- Status Messages -->
    <div role="alert" aria-live="polite" id="status-messages">
      <?php check_message(); ?>
    </div>
    
    <section class="auth-card" aria-labelledby="login-heading">
      <header class="auth-header">
        <img src="<?php echo asset_url('images/text-ued-1.png'); ?>" alt="Logo Đại học Sư phạm" class="auth-logo" loading="lazy">
        <h1 id="login-heading" class="auth-title">Đăng nhập</h1>
        <p class="auth-subtitle">Chào mừng trở lại hệ thống E-Learning!</p>
      </header>
      
      <form 
        class="auth-form" 
        action="" 
        method="POST" 
        id="loginForm"
        aria-labelledby="login-heading"
        novalidate> 
        
        <fieldset>
          <legend class="sr-only">Thông tin đăng nhập</legend>
          
          <div class="form-group">
            <label class="form-label required" for="user_email">
              Email hoặc Tên đăng nhập
              <span aria-hidden="true">*</span>
            </label>
            <input 
              class="form-input" 
              type="text" 
              id="user_email"
              name="user_email" 
              placeholder="Nhập email hoặc tên đăng nhập..."
              required
              autocomplete="username"
              aria-describedby="email-error email-help"
              aria-invalid="false"
            >
            <div id="email-help" class="form-help sr-only">
              Nhập địa chỉ email hoặc tên đăng nhập của bạn
            </div>
            <div class="form-error" id="email-error" role="alert" aria-live="polite"></div>
          </div>

          <div class="form-group">
            <label class="form-label required" for="user_pass">
              Mật khẩu
              <span aria-hidden="true">*</span>
            </label>
            <div class="input-group">
              <input 
                class="form-input" 
                type="password" 
                id="user_pass"
                name="user_pass" 
                placeholder="Nhập mật khẩu..."
                required
                autocomplete="current-password"
                aria-describedby="password-error password-help"
                aria-invalid="false"
              >
              <button 
                type="button" 
                class="input-addon" 
                id="togglePassword" 
                aria-label="Hiện mật khẩu"
                aria-pressed="false"
                title="Hiện/ẩn mật khẩu">
                <i class="fas fa-eye" aria-hidden="true"></i>
              </button>
            </div>
            <div id="password-help" class="form-help sr-only">
              Nhập mật khẩu của bạn để đăng nhập
            </div>
            <div class="form-error" id="password-error" role="alert" aria-live="polite"></div>
          </div>
        </fieldset>
        
        <button 
          class="btn btn-primary btn-full" 
          type="submit" 
          name="btnLogin" 
          id="loginBtn"
          aria-describedby="login-status">
          <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
          <span>Đăng nhập</span>
          <div class="loading-spinner" id="loginSpinner" style="display: none;" aria-hidden="true"></div>
        </button>
        <div id="login-status" class="sr-only" aria-live="polite"></div>
      </form>
      
      <footer class="auth-footer">
        <nav aria-label="Liên kết liên quan">
          <p>Chưa có tài khoản? <a href="register.php" aria-label="Đi đến trang đăng ký">Đăng ký ngay</a></p>
          <a href="admin/login.php" class="admin-link" aria-label="Đăng nhập với quyền quản trị viên">
            <i class="fas fa-user-shield" aria-hidden="true"></i>
            Đăng nhập Admin
          </a>
        </nav>
      </footer>
    </section>
  </main>
  
  <?php 
  if(isset($_POST['btnLogin'])){
    $email = trim($_POST['user_email']);
    $upass  = trim($_POST['user_pass']);
    $h_upass = sha1($upass);
    
    if ($email == '' OR $upass == '') {
      message("Invalid Username and Password!", "error");
      redirect (web_root."login.php");
    } else {  
      $student = new Student();
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
  <script src="<?php echo asset_url('js/jquery.js'); ?>"></script>
  <script src="<?php echo asset_url('js/bootstrap5.min.js'); ?>"></script>
  
  <!-- Optimized JavaScript Assets -->
  <?php echo asset_js(); ?>
  
  <!-- Performance Monitoring -->
  <script>
    // Performance monitoring
    window.addEventListener('load', function() {
      if ('performance' in window) {
        const perfData = performance.getEntriesByType('navigation')[0];
        const loadTime = perfData.loadEventEnd - perfData.fetchStart;
        
        console.log('Page Load Time:', loadTime + 'ms');
        
        // Send to analytics (if implemented)
        if (typeof gtag !== 'undefined') {
          gtag('event', 'timing_complete', {
            'name': 'load',
            'value': Math.round(loadTime)
          });
        }
      }
    });
    
    // Critical resource loading
    document.addEventListener('DOMContentLoaded', function() {
      // Lazy load non-critical CSS
      const nonCriticalCSS = document.createElement('link');
      nonCriticalCSS.rel = 'stylesheet';
      nonCriticalCSS.href = '<?php echo asset_url("assets/css/main.css"); ?>';
      document.head.appendChild(nonCriticalCSS);
    });
  </script>
</body>
</html>