<?php
	 if (!isset($_SESSION['TYPE'])=='Administrator'){
      redirect(web_root."index.php");
     }

?>
<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-chart-bar me-2"></i>Reports
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body text-center py-5">
        <i class="fas fa-tools fa-3x text-muted mb-3"></i>
        <h3 class="text-muted">Under Development</h3>
        <p class="text-muted">This feature is currently being developed and will be available soon.</p>
        <a href="<?php echo web_root; ?>admin/home.php" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
      </div>
    </div>
  </div>
</div>