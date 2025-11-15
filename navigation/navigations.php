<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>eLearning</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen">  
<!-- <link href="<?php echo web_root; ?>css/kcctc.css" rel="stylesheet" media="screen">  -->
<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">  
  
<link rel="stylesheet" href="<?php echo web_root; ?>assets/iCheck/flat/blue.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo web_root; ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>css/jquery-ui.css">  
 <style type="text/css"> 
body {
  background: #f5f7fb;
}
 
#content {
  min-height: 550px;
  margin: 0;
  width: 100%;
}
#footer > div {
  background-color: #fff;
  min-height: 200px;
  padding: 10px 50px;
  margin-top: 30px;
  border-top: 1px solid #ddd;

}
.footer-links { 
  /*margin-left: 5px;*/
}
#footer > footer { 
    background-color: rgb(0, 67, 200);
  min-height: 50px;
  padding: 10px; 
  border-top: 1px solid #ddd;
  color:#fff;

}
.navbar-nav {
  float: right;
}
@media only screen and (max-width: 768px){
 .navbar-nav {
  float: none;
 }

}
#content { 
  margin-right: 0px;
  margin-left: 90px;
  width:90%;
}

#content:before,
#content:after {
  display: table;
  content: "";
}

#content:after {
  clear: both;
}

#content:before,
#content:after {
  display: table;
  content: "";
}

#content:after {
clear: both;
}

.sidenav {
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    height: 100%;
    width: 60px;
}

#mySidenav a {
    position: absolute;
    left: -130px;
    transition: all 0.3s ease;
    padding: 15px 20px;
    width: 190px;
    text-decoration: none;
    font-size: 18px;
    color: white;
    border-radius: 0 5px 5px 0;
    white-space: nowrap;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
}

#mySidenav a:hover {
    left: 0;
    text-decoration: none;
    color: white;
}

#mySidenav a:focus {
    left: -130px;
    text-decoration: none;
}

#learning {
    top: 180px;
    background-color: rgb(0, 67, 200);
}

#categories {
    top: 260px;
    background-color: rgb(0, 81, 242);
}

#about {
    top: 340px;
    background-color: rgb(79, 138, 255);
}

#login {
    top: 420px;
    background-color: rgb(137, 176, 255);
}

#title-header {
  background-color: rgba(0, 67, 200, 0.75); 
  border-bottom: 1px solid #ddd; 
  height: 100px;  
  padding: 10px 0px;
  text-align: center;
  color: #fff;
  font-size: 18px;
}
.logo { height: 70px; width: auto; vertical-align: middle; }
 

 </style>
 

<body >
<section id="title-header">
  <div class="title">  
     <img class="logo" src="images/text-ued-1.png">
  </div>
</section>  
<section id="navigation">
  <div id="mySidenav" class="sidenav">
    <a href="<?php echo web_root; ?>index.php?q=content" id="learning">Learning<i class="fa fa-book pull-right"></i></a>
    <a href="<?php echo web_root; ?>index.php?q=categories" id="categories">Exercises <i class="fa fa-check-square-o pull-right"></i></a>
    <a href="<?php echo web_root; ?>index.php?q=about" id="about">About Us <i class="fa fa-info-circle pull-right"></i></a>  
     <a href="logout.php" id="login">Logout <i class="fa fa-sign-out pull-right"></i></a> 
  </div>
</section>  

<section id="content"> 
<?php check_message(); ?> 
  <div class="container"> 
    <?php require_once $content; ?> 
  </div>  
</section>

<section id="footer"> 
<!--      <div > 

</div>   -->
<!-- <footer  >
    <!-- <p align="left">&copy; Capiz State Unversity</p> -->
</footer> -->
</section>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>jquery/jquery.min.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.dataTables.js"></script> 
  <script src="<?php echo web_root;?>assets/iCheck/icheck.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script type="text/javascript" src="<?php echo web_root; ?>js/jquery-ui.js"></script> 
  <script type="text/javascript" src="<?php echo web_root; ?>js/autofunc.js"></script> 
  <script src="<?php echo web_root;?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Page Script -->
<script>
 
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
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
        "scrollCollapse": true,

        //ordering start at column 1
        "order": [[ 1, 'desc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
$(document).ready(function() {
    var t = $('#example2').DataTable( {
      "bSort": false,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],

          //vertical scroll
         // "scrollY":        "300px",
        "scrollCollapse": true,

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

<script type="text/javascript"> 

$('#date_picker').datetimepicker({
  format: 'mm/dd/yyyy',
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
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
 

  // Sidebar behavior - auto hide after click
  $('#mySidenav a').on('click', function() {
    $(this).blur(); // Remove focus to trigger CSS hide
  });

  // Hide sidebar when clicking outside
  $(document).on('click', function(e) {
    if (!$(e.target).closest('#mySidenav').length) {
      $('#mySidenav a').blur();
    }
  });

  $(document).on("change",".radios",function(){

    var exerciseid = $(this).data('id');
    var value = $(this).val();

       // alert(value);
       if ($(this).is(':checked'))
        {
            $.ajax({
            type : "POST",
            url : "validation.php",
            dataType: "text",
            data: {ExerciseID:exerciseid,Value:value},
            success : function(data){
              // alert(data)
            }
           });
        }
  

  });

//    $(function(){
//   $('input[type="radio"]').change(function(){
//     if ($(this).is(':checked'))
//     {
//       alert($(this).val());
//       $(this).disabled=true;
//     }
//   });
// });
  </script>     

</body>
</html>