<?php
$current_page="custom_top";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../inc/database.php';

$aPos = array();
$aNeg = array();
$bPos = array();
$bNeg = array();
$oPos = array();
$oNeg = array();
$abPos = array();
$abNeg = array();

$maxDonors = array(
  'a+'=>NULL,
  'a-'=>NULL,
  'b+'=>NULL,
  'b-'=>NULL,
  'o+'=>NULL,
  'o-'=>NULL,
  'ab+'=>NULL,
  'ab-'=>NULL,
);
// $maxDonate=0;
$maxDonate = array(
  'A+'=>0,
  'A-'=>0,
  'B+'=>0,
  'B-'=>0,
  'O+'=>0,
  'O-'=>0,
  'AB+'=>0,
  'AB-'=>0,
);

$from = '01-01-1900';
$from = strtotime($from);
$to = '01-01-1900';
$to = strtotime($to);

$range_date = '';
?>

<!-- form -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-trophy" style="padding-right: 5px"></i> Enter Range dates to find top donors</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <?php
        $startDateErr = '';
        $endDateErr = '';
        $err = 'ok';

        if (isset($_POST['show'])) {

          $start_date = dateValidate($_POST['start_date']);
          $end_date = dateValidate($_POST['end_date']);

          // start date validation
          if (empty($start_date)) {
            $startDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> date must not be empty';
            $err = 'empty';
          } else if(checkFormat($start_date)){
            $startDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert date in <b> dd/mm/yyyy </b> format';
            $start_date = date('d/m/Y');
            $err = 'empty';
          } else if(dateCheck($start_date)){
            $startDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert valid date in <b> dd/mm/yyyy </b> format';
            $start_date = date('d/m/Y');
            $err = 'empty';
          } else if(futuredate($start_date)){
            $startDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> future date can not be given';
            $start_date = date('d/m/Y');
            $err = 'empty';
          }
          // start date validation

          // end date validation
          if (empty($end_date)) {
            $endDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> date must not be empty';
            $err = 'empty';
          } else if(checkFormat($end_date)){
            $endDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert date in <b> dd/mm/yyyy </b> format';
            $end_date = date('d/m/Y');
            $err = 'empty';
          } else if(dateCheck($end_date)){
            $endDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert valid date in <b> dd/mm/yyyy </b> format';
            $end_date = date('d/m/Y');
            $err = 'empty';
          } else if(futuredate($end_date)){
            $endDateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> future date can not be given';
            $end_date = date('d/m/Y');
            $err = 'empty';
          }
          // end date validation

          if($err=='ok'){
            // set date range
            $range_date = '( '.$start_date.' -- '.$end_date.' )';
            $start_date = str_replace('/', '-', $start_date); // Replaces all slashes with hyphens.
            $from = strtotime($start_date);
            $start_date = str_replace('-', '/', $start_date); // Replaces all hyphens with slashes.

            $end_date = str_replace('/', '-', $end_date); // Replaces all slashes with hyphens.
            $to = strtotime($end_date);
            $end_date = str_replace('-', '/', $end_date); // Replaces all hyphens with slashes.
            // set date range
          }

        }

         ?>
        <form id="demo-form2" method="post" action="" data-parsley-validate class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Starting date <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <div id="tazbinur">
                <input type="text" autocomplete="off" required value="<?php echo isset($start_date)? $start_date: ''; ?>" name="start_date" class="form-control has-feedback-left date" placeholder="Enter date" aria-describedby="inputSuccess2Status3">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status2" class="sr-only">(success)</span>

                <i class="text-danger"> <?php echo $startDateErr; ?> </i>
              </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ending date <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <div id="tazbinur">

                <input type="text" autocomplete="off" required value="<?php echo isset($end_date)? $end_date: ''; ?>" name="end_date" class="form-control has-feedback-left date" placeholder="Enter date" aria-describedby="inputSuccess2Status3">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status2" class="sr-only">(success)</span>

                <i class="text-danger"> <?php echo $endDateErr; ?> </i>

              </span>
              </div>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <!-- <button class="btn btn-primary" type="reset"> Clear</button> -->
              <button type="submit" name="show" id="show" class="btn btn-success" style="width: 200px"><i class="fa fa-eye" style="padding-right: 5px"></i> Show top donors</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<!-- form -->

<!-- custom top donor -->
<div class="row" id="custom_table">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-trophy" style="padding-right: 5px"></i> Custom top donor list <?php echo $range_date; ?></h2>
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
              // hsitory table
              $sql = "SELECT * FROM donation_history LEFT JOIN donar_list on donation_history.donor_id=donar_list.id WHERE donar_list.muted=0 AND donar_list.del=0;";
              $result = mysqli_query($conn, $sql);
              $result_check = mysqli_num_rows($result);
              if( $result_check > 0 ){
                while ($row = mysqli_fetch_assoc($result)) {

                  $date = $row['donate_date'];
                  $date = str_replace('/', '-', $date); // Replaces all slashes with hyphens.
                  $date = strtotime($date);

                  //dontion histry
                  if ($to>=$date && $date>=$from) {

                    if ($row['blood_group']=='A+') {
                      if (isset( $aPos[$row['donor_id']] )) {
                        $aPos[$row['donor_id']]++;
                      } else{
                        $aPos[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='A-') {
                      if (isset( $aNeg[$row['donor_id']] )) {
                        $aNeg[$row['donor_id']]++;
                      } else{
                        $aNeg[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='B+') {
                      if (isset( $bPos[$row['donor_id']] )) {
                        $bPos[$row['donor_id']]++;
                      } else{
                        $bPos[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='B-') {
                      if (isset( $bNeg[$row['donor_id']] )) {
                        $bNeg[$row['donor_id']]++;
                      } else{
                        $bNeg[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='O+') {
                      if (isset( $oPos[$row['donor_id']] )) {
                        $oPos[$row['donor_id']]++;
                      } else{
                        $oPos[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='O-') {
                      if (isset( $oNeg[$row['donor_id']] )) {
                        $oNeg[$row['donor_id']]++;
                      } else{
                        $oNeg[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='AB+') {
                      if (isset( $abPos[$row['donor_id']] )) {
                        $abPos[$row['donor_id']]++;
                      } else{
                        $abPos[$row['donor_id']]=1;
                      }
                    } else if ($row['blood_group']=='AB-') {
                      if (isset( $abNeg[$row['donor_id']] )) {
                        $abNeg[$row['donor_id']]++;
                      } else{
                        $abNeg[$row['donor_id']]=1;
                      }
                    }

                  }
                  //donation histry
                }
              }
              // history table

              // persent table
              $sql = "SELECT * FROM donar_list WHERE muted=0 AND del=0;";
              $result = mysqli_query($conn, $sql);
              $result_check = mysqli_num_rows($result);
              if( $result_check > 0 ){
                while ($row = mysqli_fetch_assoc($result)) {

                  $date = $row['last_donate_date'];
                  $date = str_replace('/', '-', $date); // Replaces all slashes with hyphens.
                  $date = strtotime($date);

                  //donr list
                  if ($to>=$date && $date>=$from) {

                    if ($row['blood_group']=='A+') {
                      if (isset( $aPos[$row['id']] )) {
                        $aPos[$row['id']]++;
                      } else{
                        $aPos[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='A-') {
                      if (isset( $aNeg[$row['id']] )) {
                        $aNeg[$row['id']]++;
                      } else{
                        $aNeg[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='B+') {
                      if (isset( $bPos[$row['id']] )) {
                        $bPos[$row['id']]++;
                      } else{
                        $bPos[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='B-') {
                      if (isset( $bNeg[$row['id']] )) {
                        $bNeg[$row['id']]++;
                      } else{
                        $bNeg[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='O+') {
                      if (isset( $oPos[$row['id']] )) {
                        $oPos[$row['id']]++;
                      } else{
                        $oPos[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='O-') {
                      if (isset( $oNeg[$row['id']] )) {
                        $oNeg[$row['id']]++;
                      } else{
                        $oNeg[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='AB+') {
                      if (isset( $abPos[$row['id']] )) {
                        $abPos[$row['id']]++;
                      } else{
                        $abPos[$row['id']]=1;
                      }
                    } else if ($row['blood_group']=='AB-') {
                      if (isset( $abNeg[$row['id']] )) {
                        $abNeg[$row['id']]++;
                      } else{
                        $abNeg[$row['id']]=1;
                      }
                    }

                  }
                  //donar list
                }
              }
              // persent table

              // getting final top donors
              foreach ($aPos as $key => $value) {
                if ($value>$maxDonate['A+']) {
                  $maxDonate['A+']=$value;
                  $maxDonors['a+']=$key;
                }
              }

              foreach ($aNeg as $key => $value) {
                if ($value>$maxDonate['A-']) {
                  $maxDonate['A-']=$value;
                  $maxDonors['a-']=$key;
                }
              }

              foreach ($bPos as $key => $value) {
                if ($value>$maxDonate['B+']) {
                  $maxDonate['B+']=$value;
                  $maxDonors['b+']=$key;
                }
              }

              foreach ($bNeg as $key => $value) {
                if ($value>$maxDonate['B-']) {
                  $maxDonate['B-']=$value;
                  $maxDonors['b-']=$key;
                }
              }

              foreach ($oPos as $key => $value) {
                if ($value>$maxDonate['O+']) {
                  $maxDonate['O+']=$value;
                  $maxDonors['o+']=$key;
                }
              }

              foreach ($oNeg as $key => $value) {
                if ($value>$maxDonate['O-']) {
                  $maxDonate['O-']=$value;
                  $maxDonors['o-']=$key;
                }
              }

              foreach ($abPos as $key => $value) {
                if ($value>$maxDonate['AB+']) {
                  $maxDonate['AB+']=$value;
                  $maxDonors['ab+']=$key;
                }
              }

              foreach ($abNeg as $key => $value) {
                if ($value>$maxDonate['AB-']) {
                  $maxDonate['AB-']=$value;
                  $maxDonors['ab-']=$key;
                }
              }
              // getting final top donors

              foreach ($maxDonors as $key => $value) {
                $sql = "SELECT * FROM donar_list WHERE id='$value' AND muted=0 AND del=0;";
                $result = mysqli_query($conn, $sql);
                $result_check = mysqli_num_rows($result);
                if( $result_check > 0 ){
                  while ($row = mysqli_fetch_assoc($result)) {
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
                          echo '<span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">'.$maxDonate[$row['blood_group']].' times</span>';
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
<!-- custom top donor -->

<!-- view modal -->
<div class="modal fade bs-example-modal-lg view-tazbinur-rahaman" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Donor details</h4>
      </div>
      <div class="modal-body">
        <p>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <img src="../img/july_shot.gif" id="" style="width: 100%; height: 200px" alt="">
            </div>

            <div class="col-sm-12 col-md-6">
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

        $('#phone').html(data.donor.phone);
        $('#address').html(data.donor.address);

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
