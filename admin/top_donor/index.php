<?php
$current_page="top_donor";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../inc/database.php';
?>

<!-- life time top donor -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-trophy" style="padding-right: 5px"></i> Life-time top donor list</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="width: 50px">Serial</th>
              <th style="width: 220px">Name</th>
              <th style="width: 50px">Group</th>
              <th style="width: 70px">Total donation</th>
              <th style="width: 70px">Last donated</th>
              <th style="width: 70px">Student</th>
              <th style="width: 100px">Phone</th>
              <th style="width: 250px">Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $days = 0;
            $status = 0;
              // $sql = "SELECT * FROM donar_list WHERE muted=0 AND del=0 ORDER BY donate_count DESC;";
              $sql = "SELECT * FROM donar_list WHERE muted=0 AND del=0 ORDER BY donate_count DESC;";
              $top_donors = array(
                'A+'=>0,
                'A-'=>0,
                'B+'=>0,
                'B-'=>0,
                'O+'=>0,
                'O-'=>0,
                'AB+'=>0,
                'AB-'=>0
              );
              $exit = 0;
              $result = mysqli_query($conn, $sql);
              $result_check = mysqli_num_rows($result);
              if( $result_check > 0 ){
                while ($row = mysqli_fetch_assoc($result)) {

                  if (
                    $top_donors['A+']==1 &&
                    $top_donors['A-']==1 &&
                    $top_donors['B+']==1 &&
                    $top_donors['B-']==1 &&
                    $top_donors['O+']==1 &&
                    $top_donors['O-']==1 &&
                    $top_donors['AB+']==1 &&
                    $top_donors['AB-']==1
                  ) {
                    break;
                  }

                  if ($row['blood_group']=='A+') {
                    if ($top_donors['A+']==0) {
                      $top_donors['A+']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='A-') {
                    if ($top_donors['A-']==0) {
                      $top_donors['A-']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='B+') {
                    if ($top_donors['B+']==0) {
                      $top_donors['B+']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='B-') {
                    if ($top_donors['B-']==0) {
                      $top_donors['B-']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='O+') {
                    if ($top_donors['O+']==0) {
                      $top_donors['O+']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='O-') {
                    if ($top_donors['O-']==0) {
                      $top_donors['O-']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='AB+') {
                    if ($top_donors['AB+']==0) {
                      $top_donors['AB+']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  } else if ($row['blood_group']=='AB-') {
                    if ($top_donors['AB-']==0) {
                      $top_donors['AB-']=1;
                      $exit=0;
                    } else{
                      $exit = 1;
                    }
                  }

                  if ($exit==0) {
                    // donate day count
                    $array = explode('/', $row['last_donate_date']);
                    $day = $array[0];
                    $month = $array[1];
                    $year = $array[2];
                    $last_donated = $year.'-'.$month.'-'.$day;
                    $today = date('Y-m-d');
                    $date1 = date_create($last_donated);
                    $date2 = date_create($today);

                    $diff = date_diff($date1,$date2);

                    $days = $diff->format("%a");
                    if($days>=120){
                      $status = 1;
                    } else{
                      $status = 0;
                    }
                    // donate day count
                      ?>
                      <tr>
                      <td> <?php echo '000000'.$row['id']; ?> </td>
                      <td>
                        <i class="fa fa-trophy" style="padding-right: 5px; color: rgb(237, 194, 37)"></i>
                        <?php

                        if (strlen($row['name'])>=27) {
                          for ($i=0; $i < 24; $i++) {
                            echo $row['name'][$i];
                          }
                          echo "...";
                        } else{
                          echo $row['name'];
                        }
                        ?>
                      </td>
                      <td> <?php echo '<b>'.$row['blood_group'].'</b>'; ?> </td>
                      <td>
                        <?php
                          echo '<span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">'.$row['donate_count'].' times</span>';
                         ?>
                      </td>
                      <td>
                        <?php
                          if ($row['last_donate_date']=='01/01/2001') {
                            echo "<b>Never donated</b>";
                          } else{
                            echo $row['last_donate_date']."<br><b>".$days." days ago</b>";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if ($row['rmc']==1) {
                            echo '<span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px"><i class="fa fa-graduation-cap" style="margin-right: 3px;"></i> RMC</span>';
                          } else{
                            echo '<span class="badge" style="background-color:rgb(207, 212, 211); padding-right: 17px; padding-left: 17px"><i class="fa fa-ban" style="margin-right: 3px;"></i> none</span>';
                          }
                         ?>
                      </td>
                      <td> <?php echo $row['phone']; ?> </td>
                      <td>
                        <?php
                        if (strlen($row['address'])>=37) {
                          for ($i=0; $i < 34; $i++) {
                            echo $row['address'][$i];
                          }
                          echo "...";
                        } else{
                          echo $row['address'];
                        }
                        ?>
                      </td>
                      <td>
                        <button type="button" id="view" data-id="<?php echo $row['id']; ?>" class="btn btn-block btn-xs btn-primary" data-toggle="modal" data-target=".view-tazbinur-rahaman"><i class="fa fa-eye" style="padding-right: 5px"></i>View</button>
                      </td>
                      </tr>
                      <?php
                  }

                }
              }
           ?>
          </tbody>
        </table>


      </div>
    </div>
  </div>
</div>
<!-- life time top donor -->

<!-- view modal -->
<div class="modal fade bs-example-modal-lg view-tazbinur-rahaman" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user" style="padding-right: 10px"></i>Donor details</h4>
      </div>
      <div class="modal-body">
        <p>
          <div class="row">
            <div class="col-sm-12 col-md-4">
              <img src="../img/july_shot.gif" id="" style="width: 100%" alt="">
            </div>

            <div class="col-sm-12 col-md-4">
                  <!-- bsic info -->
                  <table class="table" style="min-width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2">Basic information</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Id</td>
                        <td> <b id="id"></b> </td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td> <b id="name"></b> </td>
                      </tr>
                      <tr id="rmc_student">
                        <td>Student</td>
                        <td> <span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px"><i class="fa fa-graduation-cap" style="margin-right: 3px;"></i> RMC</span> </td>
                      </tr>
                      <tr>
                        <td>Group</td>
                        <td> <b id="group"></b> </td>
                      </tr>
                      <tr>
                        <td>Phone</td>
                        <td> <b id="phone"></b> </td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td> <b id="address"></b> </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- basic info -->
            </div>

            <div class="col-sm-12 col-md-4">
                  <!-- bsic info -->
                  <table class="table" style="min-width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2">Basic information</th>
                      </tr>
                    </thead>
                    <tbody id="history">
                      <tr>
                        <td>Id</td>
                        <td> <b id="id"></b> </td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td> <b id="name"></b> </td>
                      </tr>
                      <tr>
                        <td>Group</td>
                        <td> <b id="group"></b> </td>
                      </tr>
                      <tr>
                        <td>Phone</td>
                        <td> <b id="phone"></b> </td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td> <b id="address"></b> </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- basic info -->
            </div>
          </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- view modal -->

<?php
include_once '../inc/footer.php';
?>

<!-- view  -->
<script>
  $(document).on('click', '#view', function(){
    $('.donate_somewhere').hide();
    var donor_id = $(this).data('id');
    // console.log(donor_id);
    $.ajax({
      url: 'ajax.php',
      dataType: 'json',
      data: { donor_id: donor_id, action: 'view' },
      method: 'POST',

      success: function(data){
        $('#id').html(data.donor.id);
        $('#name').html(data.donor.name);
        if (data.donor.rmc==1) {
          $('#rmc_student').show();
        } else{
          $('#rmc_student').hide();
        }
        // document.getElementById("blood_group").src = "";
        $('#group').html(data.donor.blood_group);
        console.log(data);
        var last_donated = data.donor.last_donate_date;
        var last_day = last_donated[0]+last_donated[1];
        var last_month = last_donated[3]+last_donated[4];
        var last_year = last_donated[6]+last_donated[7]+last_donated[8]+last_donated[9];
        var last_donate_date = last_month+'/'+last_day+'/'+last_year;

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        var d1 = new Date(last_donate_date);
      	var d2 = new Date(today);
      	var timeDiff = d2.getTime() - d1.getTime();
      	var DaysDiff = timeDiff / (1000 * 3600 * 24);
      	// document.write("Days of difference between <br>"+d1+"<br> and <br>"+d2+" is:<br> " +DaysDiff);

        var tr = '';

        if (DaysDiff>=120) {
          tr += '<tr><td> Status</td><td><span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">Ready</span></td></tr>';
        } else{
          tr += '<tr><td>Status</td><td><span class="badge badge-secondary" style="background-color:rgb(223, 82, 74);">Not ready</span></td></tr>';
        }

        if (data.donor.last_donate_date=='01/01/2001') {
          $('#last_date').html('Never donated');
          $('#last_date_days_diff').html('Never donated');
          tr += `<tr><td>Donated</td><td><b>Never donated</b></td></tr>`;
        } else{
          $('#last_date').html(data.donor.last_donate_date);
          $('#last_date_days_diff').html(DaysDiff+' days ago');
        }

        $('#phone').html(data.donor.phone);
        $('#address').html(data.donor.address);

        if(data.donor.donate_count==0){
           var total_donate =  'Not yet donated';
        } else{
           var total_donate = data.donor.donate_count+" time(s)";
           tr += `<tr><td>Donated</td><td><b>`+total_donate+`</b></td></tr>`;
           if (data.donor.donate_count==1) {
             tr +=  '<tr><td> '+data.donor.donate_count+'st donation</td><td> <b id="">'+data.donor.last_donate_date+'</b> </td></tr>';
           } else if (data.donor.donate_count==2) {
             tr +=  '<tr><td> '+data.donor.donate_count+'nd donation</td><td> <b id="">'+data.donor.last_donate_date+'</b> </td></tr>';
           } else if (data.donor.donate_count==3) {
             tr +=  '<tr><td> '+data.donor.donate_count+'rd donation</td><td> <b id="">'+data.donor.last_donate_date+'</b> </td></tr>';
           } else {
             tr +=  '<tr><td> '+data.donor.donate_count+'th donation</td><td> <b id="">'+data.donor.last_donate_date+'</b> </td></tr>';
           }

        }

        $.each(data.history, function(k, v){
          if ( ((data.donor.donate_count - (k+1))) == 1 ) {
            tr +=  '<tr><td> '+(data.donor.donate_count - (k+1))+'st donation</td><td> <b id="">'+v.donate_date+'</b> </td></tr>';
          } else if ( ((data.donor.donate_count - (k+1))) == 2 ) {
            tr +=  '<tr><td> '+(data.donor.donate_count - (k+1))+'nd donation</td><td> <b id="">'+v.donate_date+'</b> </td></tr>';
          } else if ( ((data.donor.donate_count - (k+1))) == 3 ) {
            tr +=  '<tr><td> '+(data.donor.donate_count - (k+1))+'rd donation</td><td> <b id="">'+v.donate_date+'</b> </td></tr>';
          } else {
            tr +=  '<tr><td> '+(data.donor.donate_count - (k+1))+'th donation</td><td> <b id="">'+v.donate_date+'</b> </td></tr>';
          }
        })

        $('#history').html(tr);
      }
    });
  });
</script>
<!-- view -->

<!-- donate today message -->
<?php
 if ($_SESSION['donate_today']=='true') {
   ?>
   <script>
   Swal.fire({
  position: 'middle',
  type: 'success',
  title: 'Donation received!',
  showConfirmButton: false,
  timer: 1500
  })
   </script>
   <?php
   $_SESSION['donate_today']='false';
 }
 ?>
<!-- donate today message -->

<!-- muted message -->
<?php
 if ($_SESSION['muted']=='true') {
   ?>
   <script>
   Swal.fire({
  position: 'middle',
  type: 'success',
  title: 'Donor muted!',
  showConfirmButton: false,
  timer: 1500
  })
   </script>
   <?php
   $_SESSION['muted']='false';
 }
 ?>
<!-- muted message -->

<!-- save changes message -->
<?php
 if ($_SESSION['save_changes']=='true') {
   ?>
   <script>
   Swal.fire({
  position: 'middle',
  type: 'success',
  title: 'Donor data updated!',
  showConfirmButton: false,
  timer: 1500
  })
   </script>
   <?php
   $_SESSION['save_changes']='false';
 }
 ?>
<!-- save changes message -->

<!-- iCheck -->
<script src="../../vendors/iCheck/icheck.min.js"></script>
<!-- Datatables -->
<script src="../../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="../../vendors/jszip/dist/jszip.min.js"></script>

<!-- bootstrap-daterangepicker -->
<script src="../../vendors/moment/min/moment.min.js"></script>
<script src="../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap-datetimepicker -->
<script src="../../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
</body>
</html>
