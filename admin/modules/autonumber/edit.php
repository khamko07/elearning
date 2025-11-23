<?php
if(!isset($_SESSION['USERID'])){
  redirect(web_root."admin/index.php");
}
  $AUTOKEY = $_GET['id'];
  $autonumber = New Autonumber();
  $singleauto = $autonumber->single_autonumber($AUTOKEY);

?> 
<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-edit me-2"></i>Update Autonumber
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="controller.php?action=edit" method="POST"> 
          <input type="hidden" name="AUTOID" id="AUTOID" value="<?php echo $singleauto->AUTOID; ?>">
          
          <div class="mb-3">
            <label for="AUTOSTART" class="form-label">
              <i class="fas fa-play me-1"></i>Start <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="AUTOSTART" name="AUTOSTART" placeholder="Start number" type="text" value="<?php echo $singleauto->AUTOSTART; ?>" required>
          </div>

          <div class="mb-3">
            <label for="AUTOINC" class="form-label">
              <i class="fas fa-plus me-1"></i>Increment <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="AUTOINC" name="AUTOINC" placeholder="Increment value" type="text" value="<?php echo $singleauto->AUTOINC; ?>" required>
          </div>

          <div class="mb-3">
            <label for="AUTOEND" class="form-label">
              <i class="fas fa-stop me-1"></i>End <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="AUTOEND" name="AUTOEND" placeholder="End number" type="text" value="<?php echo $singleauto->AUTOEND; ?>" required>
          </div>

          <div class="mb-3">
            <label for="AUTOKEY" class="form-label">
              <i class="fas fa-key me-1"></i>Key <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="AUTOKEY" name="AUTOKEY" placeholder="Autonumber key" type="text" value="<?php echo $singleauto->AUTOKEY; ?>" required>
            <small class="form-text text-muted">Unique identifier for this autonumber sequence</small>
          </div>



            
          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Update
            </button>
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  