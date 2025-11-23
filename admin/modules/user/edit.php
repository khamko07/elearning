<?php  
   // if (!isset($_SESSION['TYPE'])=='Administrator'){
   //    redirect(web_root."index.php");
   //   }

  @$user_id = $_GET['id'];
    if($user_id==''){
  redirect("index.php");
}
  $user = New User();
  $singleuser = $user->single_user($user_id);

?> 

<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-user-edit me-2"></i>Update User
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="controller.php?action=edit" method="POST">
                    <!-- <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "user_id">User Id:</label> -->

                      <!-- <div class="col-md-8"> -->
                        
          <input class="form-control" id="user_id" name="user_id" type="hidden" value="<?php echo $singleuser->USERID; ?>">
          <input name="deptid" type="hidden" value="">
          
          <div class="mb-3">
            <label for="user_name" class="form-label">
              <i class="fas fa-user me-1"></i>Name <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="user_name" name="user_name" placeholder="Account Name" type="text" value="<?php echo $singleuser->NAME; ?>" required>
          </div>

          <div class="mb-3">
            <label for="user_email" class="form-label">
              <i class="fas fa-envelope me-1"></i>Username <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="user_email" name="user_email" placeholder="Username" type="text" value="<?php echo $singleuser->UEMAIL; ?>" required>
          </div>

          <div class="mb-3">
            <label for="user_pass" class="form-label">
              <i class="fas fa-lock me-1"></i>Password
            </label>
            <input class="form-control" id="user_pass" name="user_pass" placeholder="Leave blank to keep current password" type="password" value="">
            <small class="form-text text-muted">Leave blank if you don't want to change the password</small>
          </div>

          <div class="mb-3">
            <label for="retype_user_pass" class="form-label">
              <i class="fas fa-lock me-1"></i>Retype Password
            </label>
            <input class="form-control" id="retype_user_pass" name="retype_user_pass" placeholder="Retype Password" type="password" value="">
          </div>
          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" id="usersave" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Update
            </button>
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
      
 