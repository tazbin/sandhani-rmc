<?php
$current_page="upcomig_list";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../inc/database.php';
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-users" style="padding-right: 10px"></i>Upcoming Available Blood Donar List</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="width: 50px">Serial</th>
              <th style="width: 220px">Name</th>
              <th style="width: 50px">Group</th>
              <th style="width: 70px">Status</th>
              <th style="width: 70px">Student</th>
              <th style="width: 70px">Available in</th>
              <th style="width: 100px">Phone</th>
              <th style="width: 250px">Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $days = 0;
            $status = 0;
              $sql = "SELECT * FROM donar_list WHERE muted=0 && del=0;";
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

                  if($days>=105 && $days<120){

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
                      if ($status==1) {
                        echo '<span class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">Ready</span>';
                      } else{
                        echo '<span class="badge badge-secondary" style="background-color:rgb(223, 82, 74);">Not ready</span>';
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
                    <td>
                      <b style="color: rgb(38, 186, 152);">
                        <?php
                          echo 120-$days." days";
                        ?>
                      </b>
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
                      <button type="button" id="view" data-id="<?php echo $row['id']; ?>" class="btn btn-block btn-xs btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-eye" style="padding-right: 5px"></i>View</button>
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

<!-- modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
              <img src="" id="blood_group" style="width: 100%" alt="">
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
                        <td>Blood group</td>
                        <td> <b id="group"></b> </td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>
                          <span class="badge" id="ready" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px">Ready</span>
                          <span class="badge badge-secondary" id="not_ready" style="background-color:rgb(223, 82, 74);">Not ready</span>
                        </td>
                        <tr>
                          <td>Last donated</td>
                          <td> <b id="last_date"></b> </td>
                        </tr>
                        <tr>
                          <td> Duration </td>
                          <td> <b id="last_date_days_diff"></b> </td>
                        </tr>
                        <tr style="color: rgb(38, 186, 152);">
                          <td> <b>Available in</b> </td>
                          <td> <b id="available_in"></b> </td>
                        </tr>
                      </tr>
                    </tbody>
                  </table>
                  <!-- basic info -->

                  <!-- contact info -->
                  <table class="table" style="width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2">Contact information</th>
                      </tr>
                    </thead>
                    <tbody>
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
                  <!-- bcontact info -->
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="">
                <div class="x_content">
                  <!--histry info -->
                  <table class="table" style="min-height: 85px;">
                    <thead>
                      <tr>
                        <th colspan="2">History</th>
                      </tr>
                    </thead>
                    <tbody id="history">

                    </tbody>
                  </table>
                  <!-- histry info -->

                  <!--action info -->
                  <table class="table">
                    <thead>
                      <tr>
                        <th colspan="2">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <button id="donate_somewhere" class="btn btn-block btn-sm btn-primary"><i class="fa fa-calendar" style="padding-right: 5px"></i>Donated somewhere else</button>
                          <div class="donate_somewhere">
                            <label for="">Enter donated date:</label>

                            <input type="text" required class="form-control date" id="single_cal3"  placeholder="select date" aria-describedby="inputSuccess2Status3">
                            
                            <span id="inputSuccess2Status3" class="sr-only">(success)</span>

                            <button type="button" id="save_donation_somewhere" class="btn btn-sm btn-block btn-primary" style="margin-top: 10px"><i class="fa fa-check" style="padding-right: 5px"></i>Save donation date</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <button id="mute" class="btn btn-block btn-sm btn-danger"><i class="fa fa-ban" style="padding-right: 5px"></i>Mute this donor</button>
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
<!-- modal -->

<?php
include_once '../inc/footer.php';
?>

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
        document.getElementById("blood_group").src = "../img/"+data.donor.blood_group+'.png';
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

        if (DaysDiff>=120) {
          $('#ready').show();
          $('#not_ready').hide();

          $('#donate_today').show();
        } else{
          $('#ready').hide();
          $('#not_ready').show();

          $('#donate_today').hide();
        }

        $('#available_in').html(120-DaysDiff+' days');

        var tr = '';

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
           tr +=  '<tr><td> '+data.donor.donate_count+'th donation</td><td> <b id="">'+data.donor.last_donate_date+'</b> </td></tr>';
        }

        $.each(data.history, function(k, v){
         tr +=  '<tr><td> '+(data.donor.donate_count - (k+1))+'th donation</td><td> <b id="">'+v.donate_date+'</b> </td></tr>';
        })

        $('#history').html(tr);
      }
    });

    // donate somewhere
    $(document).on('click', '#donate_somewhere', function(){
      $('.donate_somewhere').show();
    });

    $(document).on('click', '#save_donation_somewhere', function(event){
      var last_donated_somewhere_date = $('#single_cal3').val();
      console.log(last_donated_somewhere_date);
      event.preventDefault();
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, record donated date!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'json',
            data: {last_donated_somewhere_date: last_donated_somewhere_date, donor_id: donor_id, action: 'donated_somewhere'},

            success: function(data){
              if (data=='empty_date') {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Oops...',
                  text: 'Date must not be empty!',
                })
              } else if (data=='invalied_format') {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Oops...',
                  text: 'Please insert date in dd/mm/yyyy format!',
                })
              } else if (data=='invalied_date') {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Oops...',
                  text: 'Please insert correct day, month, year!',
                })
              } else if (data=='future_date') {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Oops...',
                  text: 'Future date can not be given!',
                })
              } else if (data=='before_last_donation') {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: 'Oops...',
                  text: 'This date is before (or same) last donation date!',
                })
              } else{
                window.location.href='';
              }
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
