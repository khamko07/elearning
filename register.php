<?php  
require_once ("include/initialize.php"); 
if (isset($_SESSION['StudentID'])) {
  redirect('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Register - eLearning</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Custom CSS -->
<link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
</head>
<body>
  <!-- Header -->
  <header class="student-header">
    <div class="container-fluid">
      <img class="logo" src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo">
    </div>
  </header>

  <!-- Registration Form -->
  <div class="container" style="min-height: calc(100vh - 200px); padding: var(--space-8) 0;">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title mb-0">
              <i class="fas fa-user-plus me-2"></i>Create Your Account
            </h3>
            <p class="text-muted mb-0" style="font-size: var(--text-sm);">Fill in the information below to register</p>
          </div>
          
          <div class="card-body">
            <?php check_message(); ?>
            
            <form action="" method="POST" enctype="multipart/form-data" id="registerForm">
              <div class="row">
                <!-- First Name -->
                <div class="col-md-6 mb-4">
                  <div class="form-group">
                    <label for="FNAME" class="form-label">
                      First Name <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <span class="input-icon">
                        <i class="fas fa-user"></i>
                      </span>
                      <input 
                        class="form-control" 
                        id="FNAME" 
                        name="FNAME" 
                        placeholder="Enter your first name" 
                        type="text" 
                        value="" 
                        required
                        autocomplete="given-name"
                      >
                    </div>
                  </div>
                </div>

                <!-- Last Name -->
                <div class="col-md-6 mb-4">
                  <div class="form-group">
                    <label for="LNAME" class="form-label">
                      Last Name <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <span class="input-icon">
                        <i class="fas fa-user"></i>
                      </span>
                      <input 
                        class="form-control" 
                        id="LNAME" 
                        name="LNAME" 
                        placeholder="Enter your last name" 
                        type="text" 
                        value="" 
                        required
                        autocomplete="family-name"
                      >
                    </div>
                  </div>
                </div>
              </div>

              <!-- Address -->
              <div class="row">
                <div class="col-12 mb-4">
                  <div class="form-group">
                    <label for="ADDRESS" class="form-label">
                      Address <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <span class="input-icon">
                        <i class="fas fa-map-marker-alt"></i>
                      </span>
                      <input 
                        class="form-control" 
                        id="ADDRESS" 
                        name="ADDRESS" 
                        placeholder="Enter your address" 
                        type="text" 
                        value="" 
                        required
                        autocomplete="street-address"
                      >
                    </div>
                  </div>
                </div>
              </div>

              <!-- Contact Number -->
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-group">
                    <label for="PHONE" class="form-label">
                      Contact Number <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <span class="input-icon">
                        <i class="fas fa-phone"></i>
                      </span>
                      <input 
                        class="form-control" 
                        id="PHONE" 
                        name="PHONE" 
                        placeholder="Enter your contact number" 
                        type="tel" 
                        value="" 
                        required
                        autocomplete="tel"
                      >
                    </div>
                  </div>
                </div>
              </div>

              <hr class="my-4">

              <!-- Username -->
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-group">
                    <label for="USERNAME" class="form-label">
                      Username <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <span class="input-icon">
                        <i class="fas fa-at"></i>
                      </span>
                      <input 
                        class="form-control" 
                        id="USERNAME" 
                        name="USERNAME" 
                        placeholder="Choose a username" 
                        type="text" 
                        value=""
                        required
                        autocomplete="username"
                      >
                    </div>
                    <small class="form-text text-muted">This will be used to log in to your account</small>
                  </div>
                </div>

                <!-- Password -->
                <div class="col-md-6 mb-4">
                  <div class="form-group">
                    <label for="PASS" class="form-label">
                      Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <span class="input-icon">
                        <i class="fas fa-lock"></i>
                      </span>
                      <input 
                        class="form-control" 
                        id="PASS" 
                        name="PASS" 
                        placeholder="Choose a password" 
                        type="password" 
                        value=""
                        required
                        autocomplete="new-password"
                        minlength="6"
                      >
                    </div>
                    <small class="form-text text-muted">Minimum 6 characters</small>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="row">
                <div class="col-12">
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="login.php" class="btn btn-outline-secondary">
                      <i class="fas fa-arrow-left me-2"></i>Back to Login
                    </a>
                    <button type="submit" name="btnRegister" class="btn btn-primary btn-lg">
                      <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    message("You are successfully registered. Please log in.","success");
    redirect("login.php");
  }
  ?>
</body>
</html>
