<?php
$current_page="all_list";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../../admin/inc/database.php';
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-users" style="margin-right: 10px"></i>All Plasma Donar List</h2> <h2 class="covid-alert">COVID-19 Section</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="width: 50px">ID</th>
              <th style="width: 250px">Name</th>
              <th style="width: 50px">Blood Group</th>
              <th style="width: 70px">Available</th>
              <th style="width: 70px">Status</th>
              <th style="width: 100px">Phone</th>
              <th style="width: 270px">Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $days = 0;
            $status = 0;
              $sql = "SELECT * FROM codiv_plasma_donor_list WHERE muted=0 && del=0;";
              $result = mysqli_query($conn, $sql);
              $result_check = mysqli_num_rows($result);
              if( $result_check > 0 ){
                while ($row = mysqli_fetch_assoc($result)) {

                  // donate day count
                  $array = explode('/', $row['record_date']);
                  $day = $array[0];
                  $month = $array[1];
                  $year = $array[2];
                  $last_donated = $year.'-'.$month.'-'.$day;
                  $today = date('Y-m-d');
                  $date1 = date_create($last_donated);
                  $date2 = date_create($today);

                  $diff = date_diff($date1,$date2);

                  $days = $diff->format("%a");
                  $duration = $row['duration'];
                  if($days>=$duration){
                    $status = 1;
                  } else{
                    $status = 0;
                  }
                  $ready_in = $duration-$days;
                  if($ready_in<0){
                    $ready_in*=-1;
                    if($ready_in<=9){
                      $ready_in = '0'.$ready_in;
                    }
                    $ready_in = '<span class="badge badge-secondary" style="background-color:rgb(127, 132, 221); margin-left: 5px;"> <i class="fa fa-arrow-up"></i> '.$ready_in.' days</span>';
                  } else if($ready_in==0){
                    $ready_in*=-1;
                    if($ready_in<=9){
                      $ready_in = '0'.$ready_in;
                    }
                    $ready_in = '<span class="badge badge-secondary" style="background-color:rgb(127, 132, 221); margin-left: 5px; padding-left: 20px; padding-right: 20px;"> Today</span>';
                  }  else{
                    if($ready_in<=9){
                      $ready_in = '0'.$ready_in;
                    }
                    $ready_in = '<span class="badge badge-secondary" style="background-color:rgb(156, 156, 156); margin-left: 5px;"> <i class="fa fa-arrow-down"></i> '.$ready_in.' days</span>';
                  }
                  // donate day count
                    ?>
                    <tr>
                    <td> <?php echo '000000'.$row['id']; ?> </td>
                    <td>
                      <?php
                      if ($status==1) {
                        echo '<img src="../img/green.png" style="width: 6px; height: 6px; margin-top: -3px; margin-right: 5px" alt="">';
                      } else{
                        echo '<img src="../img/red.png" style="width: 6px; height: 6px; margin-top: -3px; margin-right: 5px" alt="">';
                      }

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
                       echo $ready_in;
                       ?>
                     </td>
                    <td class="text-center">
                      <?php
                      if ($status==1) {
                        echo '<span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">Ready</span>';
                      } else{
                        echo '<span class="badge badge-secondary" style="background-color:rgb(223, 82, 74);">Not ready</span>';
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
                      <button type="button" id="view" data-id="<?php echo $row['id']; ?>" class="btn btn-xs btn-primary" data-toggle="modal" data-target=".view-tazbinur-rahaman"><i class="fa fa-eye" style="margin-right: 5px"></i>View</button>
                      <button type="button" class="btn btn-xs btn-default" id="edit" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".edit-tazbinur-rahaman"><i class="fa fa-pencil" style="margin-right: 5px"></i>Edit</button>
                    </td>
                    </tr>
                    <?php
                }
              }
           ?>
          </tbody>
        </table>


      </div>
    </div>
  </div>
</div>

<!-- view modal -->
<div class="modal fade bs-example-modal-lg view-tazbinur-rahaman" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user" style="margin-right: 10px"></i>Plasma Donor details </h4>
      </div>
      <div class="modal-body">
        <p>
          <div class="row">
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
                      <tr>
                        <td>Blood group</td>
                        <td>
                        <span class="badge badge-secondary" id="group" style="background-color:rgb(223, 82, 74);">Not ready</span> </td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>
                          <span class="badge" id="ready" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">Ready</span>
                          <span class="badge badge-secondary" id="not_ready" style="background-color:rgb(223, 82, 74);">Not ready</span>
                        </td>
                      </tr>
                      <tr id="avaible_days">
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
                  <!--histry info -->
                  <table class="table" style="min-height: 85px;">
                    <thead>
                      <tr>
                        <th colspan="2">History</th>
                      </tr>
                    </thead>
                    <tbody id="history">
                      <tr>
                        <td>1st (+ve) RT,PCR Test: </td>
                        <td> <b id="positive_test_date"></b> </td>
                      </tr>
                      <tr>
                        <td>2nd (-ve) RT,PCR Test: </td>
                        <td> <b id="test_date"></b> </td>
                      </tr>
                      <tr>
                        <td>Donated: </td>
                        <td> <b id="donation_count"></b> </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- histry info -->

                  <!--histry info -->
                  <table class="table" id="activity_table" style="min-height: 85px; margin-top: -20px;">
                    <thead>
                      <tr>
                        <th colspan="2" id="activity_num"></th>
                      </tr>
                    </thead>
                    <tbody id="activity">
                      <tr>

                      </tr>
                    </tbody>
                  </table>
                  <!-- histry info -->
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="">
                <div class="x_content">
                  <!--action info -->
                  <table class="table" style="margin-top: -5px;">
                    <thead>
                      <tr>
                        <th colspan="2">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="2" id="donate_today">
                          <button class="btn btn-block btn-sm btn-success"><i class="fa fa-tint" style="margin-right: 5px"></i>Donate today</button>
                          <i>Donor will be "Not Ready" for 30 days.</i>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" id="test">
                          <button type="button" class="btn btn-sm btn-block btn-primary"><i class="fa fa-check" style="margin-right: 5px"></i>Titer level test fail</button>
                          <i>Donor will be "Not Ready" for 5 days.</i>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <button id="mute" class="btn btn-block btn-sm btn-danger"><i class="fa fa-ban" style="margin-right: 5px"></i>Mute this donor</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- action info -->
                </div>
              </div>
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

<!-- edit modal -->
<div class="modal fade bs-example-modal-sm edit-tazbinur-rahaman" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2"><i class="fa fa-user" style="margin-right: 10px"></i>Donor data edit</h4>
      </div>
      <div class="modal-body">
        <!-- <h4>Text in a modal</h4> -->
        <p>
          <form class="" >
          <div class="row container">
            <div class="col-12">
                  <!-- bsic info -->
                  <table class="table" style="min-width: 100%; margin-top: -20px">
                    <thead>
                      <tr>
                        <th colspan="2">Basic information</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Id</td>
                        <td> <b id="edit_id"></b> </td>
                        <input type="hidden" name="id" id="input_edit_id">
                        <input type="hidden" name="action" value="edit">
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td> <input type="text" autocomplete="off" name="name" id="edit_name"> </td>
                      </tr>
                      <tr>
                        <td>Blood group</td>
                        <td> <b id="edit_group"></b> </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- basic info -->

                  <!-- contact info -->
                  <table class="table" style="min-width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2">Contact information</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Phone</td>
                        <td> <input type="number" autocomplete="off" name="phone" id="edit_phone"> </td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td>
                          <textarea name="address" autocapitalize="off" id="edit_address" rows="3" cols="" style="padding: 0px"></textarea>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- contact info -->
            </div>
          </div>
          </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" id="save_changes" class="btn btn-sm btn-success"><i class="fa fa-check" style="margin-right: 5px"></i>Save changes</button>
      </div>

    </div>
  </div>
</div>
<!-- edit modal -->

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
        // document.getElementById("blood_group").src = "../img/"+data.donor.blood_group+'.png';
        $('#group').html(data.donor.blood_group);
        $('#positive_test_date').html(data.donor.first_positive_tested);
        $('#test_date').html(data.donor.test_date);
        $('#donation_count').html(data.donor.donation_count + ' times');

        $('#activity_table').hide();
        // console.log(data);

        var record_date = data.donor.record_date;
        var last_day = record_date[0]+record_date[1];
        var last_month = record_date[3]+record_date[4];
        var last_year = record_date[6]+record_date[7]+record_date[8]+record_date[9];
        var last_record_date = last_month+'/'+last_day+'/'+last_year;

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        var d1 = new Date(last_record_date);
      	var d2 = new Date(today);
      	var timeDiff = d2.getTime() - d1.getTime();
      	var DaysDiff = timeDiff / (1000 * 3600 * 24);
        DaysDiff<0 ? DaysDiff*=-1 : DaysDiff=DaysDiff;

        var duration = data.donor.duration;
        var ready_in = duration-DaysDiff;

        if (ready_in<0) {
          var avaible_days = `
          <td>Avaible since</td>
          <td>
            <span class="badge badge-secondary" style="background-color:rgb(127, 132, 221);"> <i class="fa fa-arrow-up"></i> ${-ready_in} days </span>
          </td>
          `;
        } else if (ready_in==0) {
          var avaible_days = `
          <td>Avaible since</td>
          <td>
            <span class="badge badge-secondary" style="background-color:rgb(127, 132, 221); padding-left: 18px; padding-right: 18px;"> Today </span>
          </td>
          `;
        } else{
          var avaible_days = `
          <td>Avaible in</td>
          <td>
            <span class="badge badge-secondary" style="background-color:rgb(156, 156, 156);"> <i class="fa fa-arrow-down"></i> ${ready_in} days </span>
          </td>
          `;
        }

        $('#avaible_days').html(avaible_days);

        if (DaysDiff>=duration) {
          $('#ready').show();
          $('#not_ready').hide();

          $('#donate_today').show();
          $('#test').show();
        } else{
          $('#ready').hide();
          $('#not_ready').show();

          $('#donate_today').hide();
          $('#test').hide();
        }

        $('#phone').html(data.donor.phone);
        $('#address').html(data.donor.address);

        var tr = '';
        if (!data.history.length) {
          tr +=  '<tr><td> No activities yet! </td><td> <b></b> </td></tr>';
        } else{
          var num = 1;
          $('#activity_table').show();
          $.each(data.history, function(k, v){
            num=k+1;
            tr +=  '<tr><td> '+v.activity+'</td><td> <b>'+v.history_date+'</b> </td></tr>';
          });
          $('#activity_num').html('Last '+num+' activities');
        }

        $('#activity').html(tr);

      }
    });

    // donate today
    $(document).on('click', '#donate_today', function(e){
      e.preventDefault();
        Swal.fire({
        title: 'Are you sure?',
        text: "Donor will be 'Not-ready' for 30 days",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, donate today!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'json',
            data: { donor_id: donor_id, action: 'donate_today' },

            success: function(data){
              console.log(data);
              window.location.href='';
            }
          });
        }
      })
    });
    // donate today

    // donate somewhere
    $(document).on('click', '#test', function(event){
      event.preventDefault();
        Swal.fire({
        title: 'Are you sure?',
        text: "Donor will be 'Not-ready' for 5 days",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Titer level test fail'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'json',
            data: {donor_id: donor_id, action: 'test_today'},

            success: function(data){
              console.log(data);
              window.location.href='';
            }
          });
        }
      })
    });
    // donate somewhere

    // mute donor
    $(document).on('click', '#mute', function(event){
      console.log(donor_id);
      event.preventDefault();
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, mute this donor!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'json',
            data: { donor_id: donor_id, action: 'mute'},

            success: function(data){
              window.location.href='';
            }
          });
        }
      })
    });
    // mute donor
  });
</script>
<!-- view -->

<!-- edit -->
<script>
  $(document).ready(function(){
    $(document).on('click', '#edit', function(){
      var donor_id = $(this).data('id');
      $.ajax({
        url: 'ajax.php',
        method: 'POST',
        dataType: 'json',

        data: {donor_id: donor_id, action: 'view_edit'},
        success: function(data){
          $('#edit_id').html(data.id);
          $('#input_edit_id').val(data.id);
          $('#edit_name').val(data.name);
          $('#edit_group').html(data.blood_group);
          $('#edit_phone').val(data.phone);
          $('#edit_address').val(data.address);
        }
      });
    });

    $(document).on('click', '#save_changes', function(ee){
      ee.preventDefault();
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, update donor data!'
    }).then((result) => {
      if (result.value) {
        var form = $('form')[0];
        var formData = new FormData(form);

        $.ajax({
          url: 'ajax.php',
          method: 'POST',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,

          success: function(){
            window.location.href='';
          }
        });
      }
    })
    });
  });
</script>
<!-- edit -->

<!-- donate today message -->
<?php
 if ($_SESSION['test_today']=='true') {
   ?>
   <script>
   Swal.fire({
  position: 'middle',
  type: 'success',
  title: 'Test accepted!',
  showConfirmButton: false,
  timer: 1500
  })
   </script>
   <?php
   $_SESSION['test_today']='false';
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
