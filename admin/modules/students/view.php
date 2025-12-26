<?php
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($studentId <= 0) {
  message('Invalid student ID','error');
  redirect('index.php');
}

global $mydb;
$mydb->setQuery("SELECT * FROM tblstudent WHERE StudentID = {$studentId}");
$student = $mydb->loadSingleResult();

if (!$student) {
  message('Student not found','error');
  redirect('index.php');
}

check_message();
?>

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="page-header mb-0">
        <i class="fas fa-user-graduate me-2"></i>Student Details
      </h1>
      <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to List
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <i class="fas fa-user me-2"></i>Student Information
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Student ID</label>
            <p class="form-control-plaintext"><strong>#<?php echo str_pad($student->StudentID, 6, '0', STR_PAD_LEFT); ?></strong></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Username</label>
            <p class="form-control-plaintext"><code><?php echo htmlspecialchars($student->STUDUSERNAME); ?></code></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">First Name</label>
            <p class="form-control-plaintext"><?php echo htmlspecialchars($student->Fname); ?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Last Name</label>
            <p class="form-control-plaintext"><?php echo htmlspecialchars($student->Lname); ?></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Full Name</label>
            <p class="form-control-plaintext"><strong><?php echo htmlspecialchars($student->Fname . ' ' . $student->Lname); ?></strong></p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Contact Number</label>
            <p class="form-control-plaintext"><?php echo htmlspecialchars($student->MobileNo ? $student->MobileNo : 'N/A'); ?></p>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label text-muted">Address</label>
            <p class="form-control-plaintext"><?php echo htmlspecialchars($student->Address ? $student->Address : 'N/A'); ?></p>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="index.php" class="btn btn-secondary">
          <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
      </div>
    </div>
  </div>
</div>

