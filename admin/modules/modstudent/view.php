<?php  
  @$IDNO = $_GET['id'];
  @$syid = $_GET['sy'];
    if($IDNO=='' OR $syid==''){
      redirect("index.php");
    }
  $student = New Student();
  $singlestudent = $student->single_students($IDNO); 
  ?>
<?php   
  $parent = New Parents();
  $singleparents = $parent->single_parents($IDNO);

  ?>  
  <?php   
  $sy = New Schoolyear();
  $singlesy = $sy->single_sy($syid);

  ?>
 <?php   
  $course = New Course();
  $singlecourse = $course->single_course($singlesy->COURSEID); 
  ?>
  
<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-user-graduate me-2"></i>Student Profile
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body text-center">
        <img class="img-fluid rounded mb-3" 
             title="profile image" 
             src="<?php echo web_root.'admin/modules/modstudent/'.$singlestudent->PROIMAGE ?>" 
             alt="Student Photo"
             style="max-height: 250px; object-fit: cover;">
        <h5 class="card-title"><?php echo $singlestudent->FNAME .'  '.$singlestudent->LNAME; ?></h5>
        <p class="text-muted mb-0">Student ID: <?php echo $singlestudent->IDNO; ?></p>
      </div>
    </div>
  </div> 
  <div class="col-md-9">
    <?php
    check_message();
    ?>

    <div class="card">
      <div class="card-header">
        <h3 class="mb-0"><?php echo $singlestudent->FNAME .' '.$singlestudent->MNAME.' '.$singlestudent->LNAME; ?></h3>
      </div>
      <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="basicInfo-tab" data-bs-toggle="tab" data-bs-target="#basicInfo" type="button" role="tab">
              <i class="fas fa-info-circle me-1"></i>Information
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="workstat-tab" data-bs-toggle="tab" data-bs-target="#workstat" type="button" role="tab">
              <i class="fas fa-briefcase me-1"></i>Work Status
            </button>
          </li>
        </ul>
        <div class="tab-content mt-3" id="myTabContent">
          <div class="tab-pane fade show active" id="basicInfo" role="tabpanel">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="mb-3">
                  <strong><i class="fas fa-id-card me-1 text-primary"></i>Id Number</strong>
                  <p class="mb-0"><?php echo $singlestudent->IDNO; ?></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <strong><i class="fas fa-graduation-cap me-1 text-success"></i>Course</strong>
                  <p class="mb-0"><?php echo $singlecourse->DESCRIPTION.' ('.$singlecourse->COURSE.')'; ?></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <strong><i class="fas fa-calendar me-1 text-info"></i>School Year</strong>
                  <p class="mb-0"><?php echo $singlesy->SYFROM .'-'.$singlesy->SYTO; ?></p>
                </div>
              </div> 

              <div class="col-md-4">
                <div class="mb-3">
                  <strong><i class="fas fa-user me-1"></i>First Name</strong>
                  <p class="mb-0"><?php echo $singlestudent->FNAME; ?></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <strong><i class="fas fa-user me-1"></i>Last Name</strong>
                  <p class="mb-0"><?php echo $singlestudent->LNAME; ?></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <strong><i class="fas fa-user me-1"></i>Middle Name</strong>
                  <p class="mb-0"><?php echo $singlestudent->MNAME; ?></p>
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="mb-3">
                  <strong><i class="fas fa-map-marker-alt me-1 text-danger"></i>Address</strong>
                  <p class="mb-0"><?php echo $singlestudent->ADDRESS; ?></p>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-envelope me-1 text-primary"></i>Email Address</strong>
                  <p class="mb-0"><?php echo $singlestudent->EMAILADD; ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-phone me-1 text-success"></i>Contact Number</strong>
                  <p class="mb-0"><?php echo $singlestudent->PHONE; ?></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-male me-1"></i>Father</strong>
                  <p class="mb-0"><?php echo $singleparents->FATHER; ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-briefcase me-1"></i>Father's Occupation</strong>
                  <p class="mb-0"><?php echo $singleparents->FOCCUPATION; ?></p>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-female me-1"></i>Mother</strong>
                  <p class="mb-0"><?php echo $singleparents->MOTHER; ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-briefcase me-1"></i>Mother's Occupation</strong>
                  <p class="mb-0"><?php echo $singleparents->MOCCUPATION; ?></p>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-sort-numeric-up me-1"></i>Rank in the Family</strong>
                  <p class="mb-0"><?php echo $singleparents->RANKFAMILY; ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <strong><i class="fas fa-wheelchair me-1"></i>Disability</strong>
                  <p class="mb-0"><?php echo $singleparents->DISABILITY; ?></p>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="workstat" role="tabpanel">
            <div class="table-responsive">
              <form action="controller.php?action=delete" Method="POST">                      
                <table class="table table-hover admin-table"> 
                  <thead> 
                        <!-- <th>No.</th> -->
                        <th>Company</th>
                        <th >Address</th>                       
                        <th  >Status</th>
                        <th >Hired Date</th>
                        <th >Annual Income</th>   
                   
                  </thead>   
              <tbody>
                    <?php 
                        $query = "SELECT * FROM `tblworkstats`  
                                WHERE  `IDNO` = '". $IDNO."'";
                        $mydb->setQuery($query);
                        $cur = $mydb->loadResultList();

                        if($cur<=0){
                          $btn= '<button type="submit" class="btn btn-default" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
           ';

                        }else{
                         foreach ($cur as $result) {
                        echo '<tr>';
                        // echo '<td width="5%" align="center"></td>';
                        echo '<td> ' . $result->COMPANY.'</td>';
                        echo '<td>'. $result->COMADDRESS.'</td>';
                        echo '<td>'. $result->STATUS.'</td>';
                        echo '<td>'.date_format(date_create($result->DATEHIRED), "m/d/Y").'</td>';
                        echo '<td>&#8369 '. $result->ANNUALINCOME.'</td>'; 
                        echo '</tr>';
                        }

                  
                    } 
                    ?>
                  </tbody>
                    
                    
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
 
 
         <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type=
                                    "button">×</button>

                                    <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                                </div>

                                <form action="controller.php?action=photos" enctype="multipart/form-data" method=
                                "post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="rows">
                                                <div class="col-md-12">
                                                    <div class="rows">
                                                        <div class="col-md-8">
                                                            <input type="hidden" name="MIDNO" id="MIDNO" value="<?php echo $IDNO; ?>">
                                                             <input type="hidden" name="SYID" id="SYID" value="<?php echo $syid; ?>">
                                                            <input name="MAX_FILE_SIZE" type=
                                                            "hidden" value="1000000"> <input id=
                                                            "photo" name="photo" type=
                                                            "file">
                                                        </div>

                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-default" data-dismiss="modal" type=
                                        "button">Close</button> <button class="btn btn-primary"
                                        name="savephoto" type="submit">Upload Photo</button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
  