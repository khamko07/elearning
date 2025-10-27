<?php  
require_once ("include/initialize.php"); 
if (isset($_SESSION['StudentID'])) {
  # code...
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
<title>Register</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet"> 
<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">  
  <style type="text/css">
    #title-header {
  background-color: rgba(0, 67, 200, 0.75); 
  border-bottom: 1px solid #ddd; 
  height: 130px;  
  padding: 10px 0px;
  text-align: center;
  color: #fff;
  font-size: 18px;
}
  body {
    background: url('assets/ued.jpg') no-repeat center center fixed;
    background-size: cover;
  }
  .register-container {
    background: rgba(255,255,255,0.92);
    border-radius: 12px;
    padding: 20px 20px 10px 20px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
  }
  .logo {
    max-height: 70px;
    height: 70px;
    width: auto;
    margin-right: 10px;
    vertical-align: middle;
  }
  </style>
</head>
<body>
<section id="title-header">
  <div class="title">  
     <img class="logo" src="images/text-ued-1.png">
  </div>
</section> 
 <div class="container" style="min-height: 500px; padding-top: 20px; padding-bottom: 20px;">  
   <div class="register-container">
      <p class="page-header" style="font-size: 30px; margin-top: 0;">Sign Up</p>
      <?php check_message(); ?>
    <div id="login-dp">
 <form class="form-horizontal span6" action="" method="POST" enctype="multipart/form-data" id="login-nav">
 

                <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "FNAME">First Name:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="FNAME" name="FNAME" placeholder=
                            "First Name" type="text" value="" required>
                      </div>
                    </div>
                  </div> 

                  <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "LNAME">Last Name:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="LNAME" name="LNAME" placeholder=
                            "Last Name" type="text" value=""  required>
                      </div>
                    </div>
                  </div>
  
                  <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "ADDRESS">Address:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="ADDRESS" name="ADDRESS" placeholder=
                            "Address" type="text" value=""  required>
                      </div>
                    </div>
                  </div> 
                 
                   <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "PHONE">Contact No.:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="PHONE" name="PHONE" placeholder=
                            "Contact Number" type="text" value="" required>
                      </div>
                    </div>
                  </div> 
                  
                   <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "USERNAME">Username:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="USERNAME" name="USERNAME" placeholder=
                            "Username" type="text" value="">
                      </div>
                    </div>
                  </div>

                   <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "PASS">Password:</label>

                      <div class="col-md-8">
                         <input class="form-control input-sm" id="PASS" name="PASS" placeholder=
                            "Password" type="password" value="">
                      </div>
                    </div>
                  </div>
  
                 <div class="form-group">
                    <div class="col-md-9">
                      <label class="col-md-4 control-label" for=
                      "idno"></label>

                      <div class="col-md-8">
                        <button type="submit" name="btnRegister" class="btn btn-primary btn-sm">Register</button>
                        <a href="login.php"><i class="fa fa-arrow-left"></i> Back to Login</a>
                           
                     </div>
                    </div>
                  </div> 
        
 
          
        </form>
       </div>
   </div>
</div>

<?php 
if (isset($_POST['btnRegister'])) {
    # code...  

    $student = New Student(); 
    $student->Fname         = $_POST['FNAME']; 
    $student->Lname         = $_POST['LNAME'];
    $student->Address       = $_POST['ADDRESS']; 
    $student->MobileNo         = $_POST['PHONE'];  
    $student->STUDUSERNAME      = $_POST['USERNAME'];
    $student->STUDPASS      = sha1($_POST['PASS']); 
    $student->create();  

    message("You are successfully registered. Please log in.","success");
    redirect("login.php");
}

?>
 </section>
 </body>
 </html>
 