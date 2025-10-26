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
  <meta name="description" content="Đăng nhập vào hệ thống E-Learning để truy cập các khóa học và bài tập">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

  <!-- Bootstrap 5 -->
  <link href="<?php echo web_root; ?>css/bootstrap5.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">  
  
  <!-- Our Design System -->
  <link href="<?php echo web_root; ?>assets/css/main.css" rel="stylesheet">
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
        <img src="images/text-ued-1.png" alt="Logo Đại học Sư phạm" class="auth-logo">
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
  <script src="<?php echo web_root; ?>assets/js/keyboard-navigation.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Password visibility toggle with accessibility
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('user_pass');
      const toggleIcon = togglePassword.querySelector('i');
      
      togglePassword.addEventListener('click', function() {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        const newType = isPassword ? 'text' : 'pa
        
        passwordInput.setAttributee);
        
        if (isPassword) {
          // Sho
          toggleIcon.className = 'fas fa-eye-slash';
          togglePassword.setAttribute('aria-label', 'Ẩn mật kh
         true');
         ật khẩu');
      lse {
          // Hiding password
          toggleIcon.className = 'fas fa-eye';
          togglePassword.setAttribute('aria-label', 'Hiện m
          togglePassword.setAttribute('aria-pressed', 'false');
          togglePassword.setAttribute('title', 'Hiện ;
        }
      
      
      // Form validation with acsibility
      const form = document.getElementById('loginForm');
      const emailInput = document.getElementById('user_email');
      co');
      const passwordError = document.getElementById('password-error');
      const loginStatus = document.getElementById('login-status');
      
      // Real-time validation
      em{
        validateEmail();
      });
      
      passwordInput.addEventListener('blur', function() {
        validatePassword();
      });
      
      // k
      fo) {
        const isValid = 
        
        if (!isValid) {
          e.preventDefault();
          announ);
          return false;
        }
        
        // Show loadingtate
        const loginBtn = docu);
        const log
        
        e;
        loginBtn.setAttributerue');
        loginSpinner.style.displa
        loginSpinner.setAttribute('aria
        
        loginStatus.textContent = 'Đang xử lý đăng n...';
      });
      
      function validateEmail() {
        const email = emailInput.value.trim();
       
        if (!email) {
          showError(emailInput, emailError, 'Vui lòng nhập email h
          return false;
        }
        
        if  {
        );
          return false;
        }
        
        clearError(emailInput, emailError);
        return true;
      }
      
      functiord() {
        con
        
        i{
       
          r
}
        
        });     }
  ';
       't =tConteninStatus.tex     logor);
     dErrut, passworswordInprError(pas       clea);
   mailErrorInput, er(emailrrolearE         c
  {'Escape')ey ===    if (e.k
     r errorscleacape key to     // Ese) {
    tion(down', funcstener('keytLiddEven  document.ant
    nceme enha navigationboard // Key
     
         }     }
    }
        
    cus();put.fo passwordIn          t) {
 .textContenrorswordErlse if (pas e
          }t.focus();emailInpu     
       {extContent) r.tf (emailErro        i
  rror fieldfirst eocus on // F    
         );
       s.join('. 'or+ err form: ' i tronglỗnt = 'Có textConteloginStatus.        ) {
   > 0s.lengthrorif (er
             }
         nt);
  nter.textCoswordErropas+ ật khẩu: ' 'Lỗi merrors.push(          ent) {
or.textContswordErr  if (pas      
   
      };
       Content)ilError.text + emal: ''Lỗi emaiush( errors.p       nt) {
  r.textConteailErro(emf 
        i     
   = [];nst errors   co{
      () ounceErrorsfunction ann   
      
    }ne';
      = 'noplaye.disylement.st  errorEl '';
      tContent =rElement.tex     error');
   'errost.remove(ut.classLi      inp  e');
d', 'falsalie('aria-invtribut input.setAt      {
 ) ementorEl, errputinlearError(  function c         

      }
 = 'block';play e.disylt.stmen    errorElesage;
    ent = mesConttextnt.rEleme        erro);
'error'assList.add(    input.cl;
    d', 'true')invalibute('aria-tAttriut.se   inp) {
     , messagerElementinput, error(rrohowE  function s   
       }
     Valid;
 asswordilValid && purn ema ret
           ;
    rd()sswo validatePardValid =onst passwo        c;
l()dateEmai valiemailValid = const  {
       lidateForm()unction va  
      f   }
    
   eturn true;   r
     ror); passwordErnput,sswordIrError(paclea             
         }
 
 e;alseturn f      r
     6 ký tự'); có ít nhấtảihẩu phật kr, 'MswordErrordInput, pasor(passwo  showErr
         < 6) {d.lengthwor if (pass        se;aleturn ft khẩu');ng nhập mậui lòordError, 'Vnput, passwr(passwordIhowErro  s ssword) f (!pa.value;Input = password passwordstswolidatePasn vaký tự'hất 3 t nải có íng nhập ph hoặc tên đăilEmamailError, 't, enpurror(emailI  showE.length < 3)(emailg nhập');tên đănoặc  hậplse');n', 'fa-hiddee-block';= 'inliny y', 't('aria-bus = truisabledloginBtn.der');innd('loginSpetElementByIument.gner = docinSpinginBtn'loById('t.getElementmen seErrors(corm();validateFion(e', functr('submitListenem.addEventredbac feityibilth access wibmissionm suFornction() r('blur', fustenet.addEventLiailInpuemail-errorById('ntent.getElemeumror = docnst emailErces}); khẩu')mật khẩu');ật  } e', 'Ẩn m'titlee(ttributrd.setAasswoePoggl t
      
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