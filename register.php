<?php  
require_once ("include/initialize.php"); 
if (isset($_SESSION['StudentID'])) {
  redirect('index.php');
}
?>

<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Đăng ký tài khoản hệ thống E-Learning">
  <title>Đăng ký - Hệ thống E-Learning</title>
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
    
    <div class="auth-card" style="max-width: 500px;">
      <div class="auth-header">
        <img src="images/text-ued-1.png" alt="Logo UED" class="auth-logo">
        <h1 class="auth-title">Đăng ký tài khoản</h1>
        <p class="auth-subtitle">Tạo tài khoản mới để truy cập hệ thống E-Learning</p>
      </div>
      
      <form class="auth-form" action="" method="POST" id="registerForm"> 
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label required" for="FNAME">Họ</label>
              <input 
                class="form-input" 
                type="text" 
                id="FNAME"
                name="FNAME" 
                placeholder="Nhập họ..."
                required
                autocomplete="given-name"
              >
              <div class="form-error" id="fname-error"></div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label required" for="LNAME">Tên</label>
              <input 
                class="form-input" 
                type="text" 
                id="LNAME"
                name="LNAME" 
                placeholder="Nhập tên..."
                required
                autocomplete="family-name"
              >
              <div class="form-error" id="lname-error"></div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="ADDRESS">Địa chỉ</label>
          <input 
            class="form-input" 
            type="text" 
            id="ADDRESS"
            name="ADDRESS" 
            placeholder="Nhập địa chỉ..."
            required
            autocomplete="street-address"
          >
          <div class="form-error" id="address-error"></div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="PHONE">Số điện thoại</label>
          <input 
            class="form-input" 
            type="tel" 
            id="PHONE"
            name="PHONE" 
            placeholder="Nhập số điện thoại..."
            required
            autocomplete="tel"
          >
          <div class="form-error" id="phone-error"></div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="USERNAME">Tên đăng nhập</label>
          <input 
            class="form-input" 
            type="text" 
            id="USERNAME"
            name="USERNAME" 
            placeholder="Nhập tên đăng nhập..."
            required
            autocomplete="username"
          >
          <div class="form-error" id="username-error"></div>
          <div class="form-help">Tên đăng nhập phải có ít nhất 3 ký tự</div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="PASS">Mật khẩu</label>
          <div class="input-group">
            <input 
              class="form-input" 
              type="password" 
              id="PASS"
              name="PASS" 
              placeholder="Nhập mật khẩu..."
              required
              autocomplete="new-password"
            >
            <button type="button" class="input-addon" id="togglePassword" title="Hiện/ẩn mật khẩu">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="form-error" id="password-error"></div>
          <div class="form-help">Mật khẩu phải có ít nhất 6 ký tự</div>
        </div>

        <div class="form-group">
          <label class="form-label required" for="CONFIRM_PASS">Xác nhận mật khẩu</label>
          <div class="input-group">
            <input 
              class="form-input" 
              type="password" 
              id="CONFIRM_PASS"
              name="CONFIRM_PASS" 
              placeholder="Nhập lại mật khẩu..."
              required
              autocomplete="new-password"
            >
            <button type="button" class="input-addon" id="toggleConfirmPassword" title="Hiện/ẩn mật khẩu">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="form-error" id="confirm-password-error"></div>
        </div>
        
        <button class="btn btn-primary btn-full" type="submit" name="btnRegister" id="registerBtn">
          <i class="fas fa-user-plus"></i>
          <span>Đăng ký</span>
          <div class="loading-spinner" id="registerSpinner" style="display: none;"></div>
        </button>
      </form>
      
      <div class="auth-footer">
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap5.min.js"></script>
  <script src="<?php echo web_root; ?>assets/js/theme-manager.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Password visibility toggles
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('PASS');
      const toggleIcon = togglePassword.querySelector('i');
      
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
      const confirmPasswordInput = document.getElementById('CONFIRM_PASS');
      const toggleConfirmIcon = toggleConfirmPassword.querySelector('i');
      
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
      
      toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        
        if (type === 'password') {
          toggleConfirmIcon.className = 'fas fa-eye';
          toggleConfirmPassword.setAttribute('title', 'Hiện mật khẩu');
        } else {
          toggleConfirmIcon.className = 'fas fa-eye-slash';
          toggleConfirmPassword.setAttribute('title', 'Ẩn mật khẩu');
        }
      });
      
      // Form validation
      const registerForm = document.getElementById('registerForm');
      const registerBtn = document.getElementById('registerBtn');
      const registerSpinner = document.getElementById('registerSpinner');
      const btnText = registerBtn.querySelector('span');
      const btnIcon = registerBtn.querySelector('i');
      
      // Real-time validation
      const inputs = {
        FNAME: { element: document.getElementById('FNAME'), error: document.getElementById('fname-error') },
        LNAME: { element: document.getElementById('LNAME'), error: document.getElementById('lname-error') },
        ADDRESS: { element: document.getElementById('ADDRESS'), error: document.getElementById('address-error') },
        PHONE: { element: document.getElementById('PHONE'), error: document.getElementById('phone-error') },
        USERNAME: { element: document.getElementById('USERNAME'), error: document.getElementById('username-error') },
        PASS: { element: document.getElementById('PASS'), error: document.getElementById('password-error') },
        CONFIRM_PASS: { element: document.getElementById('CONFIRM_PASS'), error: document.getElementById('confirm-password-error') }
      };
      
      // Phone number validation
      inputs.PHONE.element.addEventListener('input', function() {
        const phoneRegex = /^[0-9+\-\s()]+$/;
        if (this.value && !phoneRegex.test(this.value)) {
          this.classList.add('error');
          inputs.PHONE.error.textContent = 'Số điện thoại không hợp lệ';
        } else {
          this.classList.remove('error');
          inputs.PHONE.error.textContent = '';
        }
      });
      
      // Username validation
      inputs.USERNAME.element.addEventListener('input', function() {
        if (this.value.length > 0 && this.value.length < 3) {
          this.classList.add('error');
          inputs.USERNAME.error.textContent = 'Tên đăng nhập phải có ít nhất 3 ký tự';
        } else {
          this.classList.remove('error');
          inputs.USERNAME.error.textContent = '';
        }
      });
      
      // Password validation
      inputs.PASS.element.addEventListener('input', function() {
        if (this.value.length > 0 && this.value.length < 6) {
          this.classList.add('error');
          inputs.PASS.error.textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
        } else {
          this.classList.remove('error');
          inputs.PASS.error.textContent = '';
        }
        
        // Check confirm password match
        if (inputs.CONFIRM_PASS.element.value) {
          validatePasswordMatch();
        }
      });
      
      // Confirm password validation
      inputs.CONFIRM_PASS.element.addEventListener('input', validatePasswordMatch);
      
      function validatePasswordMatch() {
        if (inputs.CONFIRM_PASS.element.value !== inputs.PASS.element.value) {
          inputs.CONFIRM_PASS.element.classList.add('error');
          inputs.CONFIRM_PASS.error.textContent = 'Mật khẩu xác nhận không khớp';
        } else {
          inputs.CONFIRM_PASS.element.classList.remove('error');
          inputs.CONFIRM_PASS.error.textContent = '';
        }
      }
      
      // Form submission
      registerForm.addEventListener('submit', function(e) {
        let hasError = false;
        
        // Clear all errors
        Object.values(inputs).forEach(input => {
          input.error.textContent = '';
          input.element.classList.remove('error');
        });
        
        // Validate all fields
        Object.entries(inputs).forEach(([key, input]) => {
          if (!input.element.value.trim()) {
            input.element.classList.add('error');
            input.error.textContent = 'Trường này là bắt buộc';
            hasError = true;
          }
        });
        
        // Additional validations
        if (inputs.USERNAME.element.value.length < 3) {
          inputs.USERNAME.element.classList.add('error');
          inputs.USERNAME.error.textContent = 'Tên đăng nhập phải có ít nhất 3 ký tự';
          hasError = true;
        }
        
        if (inputs.PASS.element.value.length < 6) {
          inputs.PASS.element.classList.add('error');
          inputs.PASS.error.textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
          hasError = true;
        }
        
        if (inputs.CONFIRM_PASS.element.value !== inputs.PASS.element.value) {
          inputs.CONFIRM_PASS.element.classList.add('error');
          inputs.CONFIRM_PASS.error.textContent = 'Mật khẩu xác nhận không khớp';
          hasError = true;
        }
        
        if (hasError) {
          e.preventDefault();
          return;
        }
        
        // Show loading state
        registerBtn.disabled = true;
        btnIcon.style.display = 'none';
        btnText.textContent = 'Đang đăng ký...';
        registerSpinner.style.display = 'inline-block';
      });
      
      // Auto-focus first input
      document.getElementById('FNAME').focus();
      
      // Enhanced form interactions
      const formInputs = document.querySelectorAll('.form-input');
      formInputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
          this.parentElement.classList.remove('focused');
        });
      });
    });
  </script>

<?php 
if (isset($_POST['btnRegister'])) {
    $student = New Student(); 
    $student->Fname         = $_POST['FNAME']; 
    $student->Lname         = $_POST['LNAME'];
    $student->Address       = $_POST['ADDRESS']; 
    $student->MobileNo      = $_POST['PHONE'];  
    $student->STUDUSERNAME  = $_POST['USERNAME'];
    $student->STUDPASS      = sha1($_POST['PASS']); 
    $student->create();  

    message("Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.","success");
    redirect("login.php");
}
?>

</body>
</html>
 