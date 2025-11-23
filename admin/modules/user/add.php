<?php 
  // if (!isset($_SESSION['TYPE'])=='Administrator'){
  //      redirect(web_root."index.php");
  //     }

  // $autonum = New Autonumber();
  // $res = $autonum->single_autonumber(2);
?> 

<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-user-plus me-2"></i>Add New User
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="controller.php?action=add" method="POST" onsubmit="return validatedpass()">
                    <!-- <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for=
                      "user_id">User Id:</label>

                      <div class="col-md-8"> --> 
                        <!--  <input class="form-control input-sm" id="user_id" name="user_id" placeholder=
                            "Account Id" type="hidden" value="<?php echo $res->AUTO; ?>"> -->
                    <!--   </div>
                    </div>
                  </div> -->           
          <input name="deptid" type="hidden" value="">
          
          <div class="mb-3">
            <label for="user_name" class="form-label">
              <i class="fas fa-user me-1"></i>Name <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="user_name" name="user_name" placeholder="Account Name" type="text" value="" required>
          </div>

          <div class="mb-3">
            <label for="user_email" class="form-label">
              <i class="fas fa-envelope me-1"></i>Username <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="user_email" name="user_email" placeholder="Username" type="text" value="" required>
          </div>

          <div class="mb-3">
            <label for="user_pass" class="form-label">
              <i class="fas fa-lock me-1"></i>Password <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="user_pass" name="user_pass" placeholder="Account Password" type="password" value="" required>
          </div>

          <div class="mb-3">
            <label for="retype_user_pass" class="form-label">
              <i class="fas fa-lock me-1"></i>Retype Password <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="retype_user_pass" name="retype_user_pass" placeholder="Retype Password" type="password" value="" required>
          </div>
            <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" id="usersave" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Save
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
       