<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title : 'eLearning'; ?></title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Custom CSS -->
<link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
<!-- Additional CSS -->
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php echo web_root; ?>assets/iCheck/flat/blue.css">
<link rel="stylesheet" href="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>css/jquery-ui.css">

<style type="text/css">
body {
  background: var(--bg-body);
}

#content {
  min-height: 550px;
  margin: 0;
  width: 100%;
}

#footer > div {
  background-color: var(--bg-white);
  min-height: 200px;
  padding: var(--space-6) var(--space-10);
  margin-top: var(--space-8);
  border-top: 1px solid var(--gray-200);
}

#footer > footer {
  background-color: var(--primary-blue);
  min-height: 50px;
  padding: var(--space-4);
  border-top: 1px solid var(--gray-200);
  color: var(--text-white);
  text-align: center;
}
</style>

<body>
<!-- Student Header -->
<header class="student-header">
  <div class="container-fluid">
    <img class="logo" src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo">
  </div>
</header>

<!-- Student Navigation -->
<nav class="navbar navbar-expand-lg student-navbar">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['q']) && $_GET['q'] == 'content') ? 'active' : ''; ?>" href="<?php echo web_root; ?>index.php?q=content">
            <i class="fas fa-book me-2"></i>Learning Content
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['q']) && $_GET['q'] == 'categories' || isset($_GET['q']) && $_GET['q'] == 'topics') ? 'active' : ''; ?>" href="<?php echo web_root; ?>index.php?q=categories">
            <i class="fas fa-check-square me-2"></i>Exercises
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['q']) && $_GET['q'] == 'about') ? 'active' : ''; ?>" href="<?php echo web_root; ?>index.php?q=about">
            <i class="fas fa-info-circle me-2"></i>About
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="user-avatar me-2">
              <?php 
                if(isset($_SESSION['StudentID'])) {
                  $student = new Student();
                  $stud = $student->single_students($_SESSION['StudentID']);
                  if($stud) {
                    $fname = isset($stud->FNAME) ? $stud->FNAME : (isset($stud->Fname) ? $stud->Fname : '');
                    echo strtoupper(substr($fname, 0, 1));
                  } else {
                    echo 'S';
                  }
                } else {
                  echo 'S';
                }
              ?>
            </span>
            <span>
              <?php 
                if(isset($_SESSION['StudentID'])) {
                  $student = new Student();
                  $stud = $student->single_students($_SESSION['StudentID']);
                  if($stud) {
                    $fname = isset($stud->FNAME) ? $stud->FNAME : (isset($stud->Fname) ? $stud->Fname : '');
                    $lname = isset($stud->LNAME) ? $stud->LNAME : (isset($stud->Lname) ? $stud->Lname : '');
                    echo htmlspecialchars(trim($fname . ' ' . $lname));
                  } else {
                    echo 'Student';
                  }
                } else {
                  echo 'Student';
                }
              ?>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="<?php echo web_root; ?>index.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="<?php echo web_root; ?>logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<section id="content" class="student-content">
  <?php check_message(); ?>
  <div class="container-fluid">
    <?php require_once $content; ?>
  </div>
</section>

<!-- Footer -->
<section id="footer">
  <div>
    <!-- Footer content can be added here -->
  </div>
  <footer>
    <p>&copy; <?php echo date('Y'); ?> E-Learning System</p>
  </footer>
</section>

<!-- Scripts -->
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo web_root; ?>js/custom/main.js" defer></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.dataTables.js"></script>
<script src="<?php echo web_root; ?>assets/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/autofunc.js"></script>
<script src="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- Page Scripts -->
<script>
$(function () {
  // Add text editor
  $("#compose-textarea").wysihtml5();
});

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
  const navbarToggler = document.querySelector('.navbar-toggler');
  const navbarCollapse = document.querySelector('.navbar-collapse');
  
  if (navbarToggler) {
    navbarToggler.addEventListener('click', function() {
      navbarCollapse.classList.toggle('show');
    });
  }

  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    const isClickInsideNav = event.target.closest('.navbar');
    if (!isClickInsideNav && navbarCollapse.classList.contains('show')) {
      navbarCollapse.classList.remove('show');
    }
  });
});

// DataTables initialization
$(document).ready(function() {
  var t = $('#example').DataTable({
    "bSort": false,
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": 0
    }],
    "scrollCollapse": true,
    "order": [[1, 'desc']]
  });

  t.on('order.dt search.dt', function() {
    t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
});

$(document).ready(function() {
  var t = $('#example2').DataTable({
    "bSort": false,
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": 0
    }],
    "scrollCollapse": true,
    "order": [[1, 'desc']]
  });

  t.on('order.dt search.dt', function() {
    t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();
});

// Quiz radio button change handler
$(document).on("change", ".radios", function() {
  var exerciseid = $(this).data('id');
  var value = $(this).val();

  if ($(this).is(':checked')) {
    $.ajax({
      type: "POST",
      url: "validation.php",
      dataType: "text",
      data: {ExerciseID: exerciseid, Value: value},
      success: function(data) {
        // Handle response if needed
      }
    });
  }
});

// Date picker
$('#date_picker').datetimepicker({
  format: 'mm/dd/yyyy',
  language: 'en',
  weekStart: 1,
  todayBtn: 1,
  autoclose: 1,
  todayHighlight: 1,
  startView: 2,
  minView: 2,
  forceParse: 0
});
</script>

</body>
</html>
