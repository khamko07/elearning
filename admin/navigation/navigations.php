<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo isset($title) ? $title : 'Admin Panel - eLearning'; ?></title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Custom CSS -->
<link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
<!-- Additional CSS -->
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"/>
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen"/>
<link rel="stylesheet" href="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>css/jquery-ui.css">

<?php
admin_confirm_logged_in();
?>

<body style="background: var(--bg-body);">
  <section id="navigation">
    <!-- Admin Top Navigation Bar -->
    <nav class="navbar navbar-default admin-topbar" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle d-md-none" id="sidebarToggle" aria-label="Toggle sidebar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo web_root; ?>admin/index.php">
            <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo">
            <span>Admin Panel</span>
          </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
          <li class="nav-item">
            <a href="<?php echo web_root; ?>admin/logout.php" class="nav-link">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Admin Sidebar Navigation -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-header">
        <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo">
        <h5>Admin Panel</h5>
      </div>
      <nav class="sidebar-nav">
        <ul class="nav" id="side-menu">
          <li>
            <a href="<?php echo web_root; ?>admin/modules/content/index.php" class="nav-link">
              <i class="fas fa-file-text"></i>
              <span>Content</span>
            </a>
          </li>
          <li>
            <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="nav-link">
              <i class="fas fa-question-circle"></i>
              <span>Questions Management</span>
            </a>
          </li>
          <li>
            <a href="<?php echo web_root; ?>admin/modules/students/index.php" class="nav-link">
              <i class="fas fa-user-graduate"></i>
              <span>Registered Students</span>
            </a>
          </li>
          <li>
            <a href="<?php echo web_root; ?>admin/modules/user/index.php" class="nav-link">
              <i class="fas fa-users"></i>
              <span>Manage Users</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
  </section>

  <!-- Main Content Area -->
  <section id="page-wrapper" class="admin-main-content">
    <?php check_message(); ?>
    <div class="admin-page-wrapper">
      <?php require_once $content; ?>
    </div>
  </section>

  <!-- Footer -->
  <section id="page-footer">
    <footer>
      <p align="center" style="color: var(--text-muted);">&copy; <?php echo date('Y'); ?> Admin Panel</p>
    </footer>
  </section>

  <!-- Scripts -->
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo web_root; ?>js/custom/main.js" defer></script>
  <script src="<?php echo web_root; ?>admin/adminMenu/dist/metisMenu.min.js"></script>
  <script src="<?php echo web_root; ?>js/jquery.dataTables.min.js"></script>
  <script src="<?php echo web_root; ?>js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/kcctc.js"></script>
  <script src="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>js/jquery-ui.js"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>js/autofunc.js"></script>

  <!-- Page Scripts -->
  <script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    // Initialize DataTables for #example (legacy tables)
    if ($('#example').length && !$.fn.DataTable.isDataTable('#example')) {
      var t = $('#example').DataTable({
        "bSort": false,
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": 0
        }],
      "order": [[1, 'desc']]
    });

      t.on('order.dt search.dt', function() {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
          cell.innerHTML = i + 1;
        });
      }).draw();
    }
    
    // Initialize DataTables for #contentTable (content list)
    if ($('#contentTable').length && !$.fn.DataTable.isDataTable('#contentTable')) {
      $('#contentTable').DataTable({
        "order": [[ 3, "desc" ]], // Sort by Created date descending
        "pageLength": 25,
        "language": {
          "search": "Search:",
          "lengthMenu": "Show _MENU_ entries",
          "info": "Showing _START_ to _END_ of _TOTAL_ entries",
          "infoEmpty": "No entries to show",
          "infoFiltered": "(filtered from _MAX_ total entries)"
        }
      });
    }
    
    // Initialize DataTables for #studentsTable (registered students list)
    if ($('#studentsTable').length && !$.fn.DataTable.isDataTable('#studentsTable')) {
      $('#studentsTable').DataTable({
        "order": [[ 0, "desc" ]], // Sort by # descending
        "pageLength": 25,
        "language": {
          "search": "Search:",
          "lengthMenu": "Show _MENU_ entries",
          "info": "Showing _START_ to _END_ of _TOTAL_ students",
          "infoEmpty": "No students to show",
          "infoFiltered": "(filtered from _MAX_ total students)"
        }
      });
    }
  });

  // Text truncation
  $(function() {
    $(".tds").each(function(i) {
      len = $(this).text().length;
      if (len > 80) {
        $(this).text($(this).text().substr(0, 80) + '...');
      }
    });
  });

  // WYSIHTML5 Editor
  $(function() {
    $("#ANNOUNCEMENT_WHAT").wysihtml5();
    $("#EVENT_WHAT").wysihtml5();
    $("#compose-textarea").wysihtml5();
  });

  // Date picker
  $(function() {
    $('#datetimepicker2').datetimepicker({
      locale: 'ru',
      autoclose: 1,
    });
  });

  // Password validation
  $("#retype_user_pass").focusout(function() {
    var pass = $("#user_pass").val();
    var repass = $(this).val();
    if (pass != repass) {
      alert("Password does not match");
    }
  });

  function validatedpass() {
    var pass = $("#user_pass").val();
    var repass = $("#retype_user_pass").val();
    if (pass != repass) {
      alert("Password does not match");
      return false;
    } else {
      return true;
    }
  }

  $('#date_pickerfrom').datetimepicker({
    format: 'yyyy',
    language: 'en',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 4,
    minView: 4,
    forceParse: 0
  });

  $('#date_pickerto').datetimepicker({
    format: 'yyyy',
    language: 'en',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 4,
    minView: 4,
    forceParse: 0
  });

  // Admin Sidebar Active Menu Highlighting
  $(document).ready(function() {
    // Get current page URL
    var currentUrl = window.location.href;

    // Highlight active menu item
    $('#side-menu li a').each(function() {
      var linkUrl = $(this).attr('href');
      if (currentUrl.indexOf(linkUrl) > -1 && linkUrl.length > 10) {
        $(this).addClass('active');
        $(this).parent().addClass('active');
      }
    });

    // Mobile sidebar toggle
    $('#sidebarToggle').on('click', function() {
      $('#adminSidebar').toggleClass('show-mobile');
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
      if ($(window).width() < 992) {
        if (!$(e.target).closest('#adminSidebar, #sidebarToggle').length) {
          $('#adminSidebar').removeClass('show-mobile');
        }
      }
    });
  });

  // Utility functions
  function checkall(selector) {
    if (document.getElementById('chkall').checked == true) {
      var chkelement = document.getElementsByName(selector);
      for (var i = 0; i < chkelement.length; i++) {
        chkelement.item(i).checked = true;
      }
    } else {
      var chkelement = document.getElementsByName(selector);
      for (var i = 0; i < chkelement.length; i++) {
        chkelement.item(i).checked = false;
      }
    }
  }

  function checkNumber(textBox) {
    while (textBox.value.length > 0 && isNaN(textBox.value)) {
      textBox.value = textBox.value.substring(0, textBox.value.length - 1);
    }
    textBox.value = trim(textBox.value);
  }

  function checkText(textBox) {
    var alphaExp = /^[a-zA-Z]+$/;
    while (textBox.value.length > 0 && !textBox.value.match(alphaExp)) {
      textBox.value = textBox.value.substring(0, textBox.value.length - 1);
    }
    textBox.value = trim(textBox.value);
  }
  </script>

</body>
</html>
