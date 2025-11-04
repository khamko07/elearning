<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>COMPUTER AIDED INSTRUCTION IN WORLD LITERATURE</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"/>
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen"/>  
<link href="<?php echo web_root; ?>css/alumni.css" rel="stylesheet" media="screen"/>
<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet"/>   
<!-- <link href="<?php echo web_root; ?>admin/adminMenu/dist/metisMenu.min.css" rel="stylesheet"/>   -->

<link rel="stylesheet" href="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>css/jquery-ui.css"> 
<!-- <link rel="stylesheet" href="<?php echo web_root; ?>web/viewer.css">  -->
<!-- Plugins -->

 <style type="text/css">
/* Admin Layout Styles */
body {
    margin: 0;
    padding: 0;
}

/* Top Navigation Bar */
.navbar-default {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    margin-bottom: 0;
}

.navbar-default .navbar-brand {
    color: white !important;
    font-weight: 600;
}

.navbar-default .navbar-nav > li > a {
    color: rgba(255, 255, 255, 0.9) !important;
}

.navbar-default .navbar-nav > li > a:hover {
    color: white !important;
    background-color: rgba(255, 255, 255, 0.1) !important;
}

/* Sidebar - Fixed on Left */
.navbar-default.sidebar {
    position: fixed;
    top: 51px; /* Height of top navbar */
    left: 0;
    width: 260px;
    height: calc(100vh - 51px);
    background-color: #ffffff;
    border-radius: 0;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1000;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.06);
}

.sidebar-nav {
    padding: 0;
    margin: 0;
}

.sidebar .sidebar-nav.navbar-collapse {
    padding: 0;
}

.sidebar ul {
    padding: 0;
    margin: 0;
    list-style: none;
}

.sidebar ul li {
    border-bottom: 1px solid #f0f0f0;
}

.sidebar ul li a {
    display: block;
    padding: 15px 20px;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.sidebar ul li a:hover,
.sidebar ul li a:focus {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
    text-decoration: none;
    border-left: 4px solid #667eea;
    padding-left: 16px;
}

.sidebar ul li a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

/* Page Content - Adjusted for Sidebar */
#page-wrapper {
    margin-left: 260px;
    padding: 20px;
    min-height: calc(100vh - 51px);
    background: #f5f7fb;
}

#page-wrapper > div {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    min-height: calc(100vh - 150px);
}

/* Page Footer */
#page-footer {
    margin-left: 260px;
    border-top: 1px solid #e5e7eb;
    padding: 15px;
    background: #f5f7fb;
}

#page-footer footer {
    background: transparent;
    border: none;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar-default.sidebar {
        position: fixed;
        top: 51px;
        left: -260px;
        width: 260px;
        height: calc(100vh - 51px);
        transition: left 0.3s ease;
        z-index: 1050;
    }

    .navbar-default.sidebar.show-mobile {
        left: 0;
    }

    #page-wrapper {
        margin-left: 0;
        padding: 15px;
    }

    #page-footer {
        margin-left: 0;
    }

    .sidebar ul li a {
        padding: 12px 15px;
    }

    /* Overlay for mobile sidebar */
    .navbar-default.sidebar.show-mobile::before {
        content: '';
        position: fixed;
        top: 51px;
        left: 260px;
        width: calc(100vw - 260px);
        height: calc(100vh - 51px);
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
}

/* Scrollbar Styling for Sidebar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #999;
}

/* Active Menu Item */
.sidebar ul li.active a,
.sidebar ul li a.active {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
    border-left: 4px solid #667eea;
    padding-left: 16px;
    font-weight: 600;
}
 </style>
<!-- Custom styles for this template -->
<!-- <link href="<?php echo web_root; ?>css/offcanvas.css" rel="stylesheet"> -->
   <?php
   admin_confirm_logged_in();
  ?>
<body style="background:#f5f7fb;">
  <section id="navigation">
<nav class="navbar navbar-default" role="navigation">

<div class="navbar-header">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="<?php echo web_root; ?>admin/index.php">
    <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo" style="height:36px; display:inline-block; vertical-align:middle; margin-right:8px;"> Admin Panel
  </a>
</div>

  <ul class="nav navbar-top-links navbar-right">
   <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['NAME']; ?>  
            </a> 

    </li>
         <li><a href="<?php echo web_root; ?>admin/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
  </ul>
</nav>

<!-- Sidebar Navigation -->
<div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                     <a href="<?php echo web_root; ?>admin/modules/content/index.php"><i class="fa fa-file-text-o fa-fw"></i> Content </a> 
                </li>
                 <li>
                     <a href="<?php echo web_root; ?>admin/modules/exercises/index.php"><i class="fa fa-question-circle fa-fw"></i> Questions Management </a> 
                </li>
                 <li>
                     <a href="<?php echo web_root; ?>admin/modules/modstudent/index.php"><i class="fa fa-user fa-fw"></i> Student </a> 
                </li>
                <li><a href="<?php echo web_root; ?>admin/modules/user/index.php"><i class="fa fa-user fa-fw"></i> Manage Users</a></li>
            </ul>
        </div>
</div>
</section>


<section id="page-wrapper"> 
  <?php  check_message(); ?> 
  <div>
    <?php  require_once $content;?>  
  </div>
 </section> 

<section id="page-footer"> 
      <footer>
        <p align="center" style="color:#999;">&copy; Admin Panel</p>
      </footer>
</section>
<!-- Plugins -->

<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script> 
<script src="<?php echo web_root; ?>js/bootstrap.min.js"></script>
<script src="<?php echo web_root; ?>admin/adminMenu/dist/metisMenu.min.js"></script>
  
<script src="<?php echo web_root; ?>js/jquery.dataTables.min.js"></script>/
<script src="<?php echo web_root; ?>js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/kcctc.js"></script>
<script src="<?php echo web_root;?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo web_root; ?>js/autofunc.js"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    var t = $('#example').DataTable( {
        "bSort": false,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
 

          //vertical scroll
         // "scrollY":        "300px",

        // "scrollCollapse": true,

        //ordering start at column 1
        "order": [[ 1, 'desc' ]]
    } );

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );

</script>


<script>

$(function(){
  $(".tds").each(function(i){
    len=$(this).text().length;
    if(len>80)
    {
      $(this).text($(this).text().substr(0,80)+'...');
    }
  });
});
  $(function () {
    //Add text editor 
     $("#ANNOUNCEMENT_WHAT").wysihtml5();
     $("#EVENT_WHAT").wysihtml5();
     $("#compose-textarea").wysihtml5();
  });
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker2').datetimepicker({
            locale: 'ru',
             autoclose: 1,
        });
    });
</script>

<script type="text/javascript">

$("#retype_user_pass").focusout(function(){

        var pass = $("#user_pass").val();
        var repass = $(this).val();
        if (pass != repass) {
            alert("Password does not match");
        };
});

function validatedpass(){

     var pass = $("#user_pass").val();
        var repass = $("#retype_user_pass").val();
        if (pass != repass) {
            alert("Password does not match");
            return false
        }else{
            return true
        };
}

$('#date_pickerfrom').datetimepicker({
  format: 'yyyy',
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 4,
    minView: 4,
    forceParse: 0
    });


$('#date_pickerto').datetimepicker({
  format: 'yyyy',
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 4,
    minView: 4,
    forceParse: 0
    });



</script>


<script>
  function checkall(selector)
  {
    if(document.getElementById('chkall').checked==true)
    {
      var chkelement=document.getElementsByName(selector);
      for(var i=0;i<chkelement.length;i++)
      {
        chkelement.item(i).checked=true;
      }
    }
    else
    {
      var chkelement=document.getElementsByName(selector);
      for(var i=0;i<chkelement.length;i++)
      {
        chkelement.item(i).checked=false;
      }
    }
  }
   function checkNumber(textBox){
        while (textBox.value.length > 0 && isNaN(textBox.value)) {
          textBox.value = textBox.value.substring(0, textBox.value.length - 1)
        }
        textBox.value = trim(textBox.value);
      }
      //
      function checkText(textBox)
      {
        var alphaExp = /^[a-zA-Z]+$/;
        while (textBox.value.length > 0 && !textBox.value.match(alphaExp)) {
          textBox.value = textBox.value.substring(0, textBox.value.length - 1)
        }
        textBox.value = trim(textBox.value);
      }

  </script>

<script type="text/javascript">
 
// Admin Sidebar Active Menu Highlighting
$(document).ready(function() {
    // Get current page URL
    var currentUrl = window.location.href;
    
    // Highlight active menu item
    $('#side-menu li a').each(function() {
        var linkUrl = $(this).attr('href');
        if (currentUrl.indexOf(linkUrl) > -1 && linkUrl.length > 10) {
            $(this).parent().addClass('active');
        }
    });
    
    // Mobile sidebar toggle
    $('.navbar-toggle').on('click', function() {
        $('.navbar-default.sidebar').toggleClass('show-mobile');
    });
});


// function truncateText(selector, maxLength) {
//     var element = document.querySelector(selector),
//         truncated = element.innerText;

//     if (truncated.length > maxLength) {
//         truncated = truncated.substr(0,maxLength) + '...';
//     }
//     return truncated;
// }
// //You can then call the function with something like what i have below.
// document.querySelector('#tds').innerText = truncateText('#tds', 107);
    </script>

</body>
</html>
