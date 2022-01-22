<?php
$current_page="birthday";
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
        <h2> <i class="fa fa-birthday-cake" style="padding-right: 5px"></i> Donor's birthday</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th style="width: 50px">Serial</th>
              <th style="width: 220px">Name</th>
              <th style="width: 50px">Group</th>
              <th style="width: 70px">Student</th>
              <th style="width: 70px">Total donation</th>
              <th style="width: 70px">Last donated</th>
              <th style="width: 100px">Phone</th>
              <th style="width: 250px">Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $days = 0;
            $status = 0;

              $sql = "SELECT * FROM donar_list WHERE birthday<>'01/01/1947' AND muted=0 AND del=0 ORDER BY donate_count DESC;";
              $result = mysqli_query($conn, $sql);
              $result_check = mysqli_num_rows($result);
              if( $result_check > 0 ){
                while ($row = mysqli_fetch_assoc($result)) {

                  if (!empty($row['birthday'])) {
                    $ami = explode('/', $row['birthday']);
                    $b_day = $ami[0];
                    $b_month = $ami[1];
                    $b_year = $ami[2];

                    $t_day = date('d');
                    $t_month = date('m');

                  if ($b_day==$t_day && $b_month==$t_month) {
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
                        <i class="fa fa-birthday-cake" style="padding-right: 5px; color: rgb(228, 49, 149)"></i>
                        <b>
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
                        </b>
                      </td>
                      <td> <?php echo '<b>'.$row['blood_group'].'</b>'; ?> </td>
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
                      <td> <?php echo '<span class="badge" style="background-color:rgb(228, 49, 149); padding-right: 17px; padding-left: 17px">'.$row['phone'].'</span>'; ?> </td>

                      <!-- <td> <?php echo '<span class="badge" style="background-color:rgb(228, 49, 149); padding-right: 17px; padding-left: 17px">'.$row['birthday'].'</span>'; ?> </td> -->

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
        <h4 class="modal-title" id="myModalLabel">Donor details</h4>
      </div>
      <div class="modal-body">
        <p>
          <div class="row">
            <div class="col-sm-12 col-md-4">
              <img src="../img/cake.gif" id="blood_group" style="width: 100%" alt="">
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
                      </tr>
                      <tr>
                        <td>Last donated</td>
                        <td> <b id="last_date"></b> </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- basic info -->
            </div>

            <div class="col-sm-12 col-md-4">
                  <!--other info -->
                  <table class="table" style="min-width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2">Other information</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Birthday</td>
                        <td> <span id="birthday" class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px"></span> </td>
                      </tr>
                      <tr>
                        <td>Age</td>
                        <td> <b id="age"></b> </td>
                      </tr>
                      <tr>
                        <td>Phone</td>
                        <td> <span id="phone" class="badge" style="background-color:rgb(38, 186, 152); padding-right: 17px; padding-left: 17px"></span> </td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td> <b id="address"></b> </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- other info -->
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

        var tr = '';

        if (data.donor.last_donate_date=='01/01/2001') {
          $('#last_date').html('Never donated');
          $('#last_date_days_diff').html('Never donated');
          tr += `<tr><td>Donated</td><td><b>Never donated</b></td></tr>`;
        } else{
          $('#last_date').html(data.donor.last_donate_date);
          $('#last_date_days_diff').html(DaysDiff+' days ago');
        }

        $('#birthday').html(data.donor.birthday);

        // age calculation
        function calculateAge (birthDate, otherDate) {
          birthDate = new Date(birthDate);
          otherDate = new Date(otherDate);

          var years = (otherDate.getFullYear() - birthDate.getFullYear());

          if (otherDate.getMonth() < birthDate.getMonth() ||
              otherDate.getMonth() == birthDate.getMonth() && otherDate.getDate() < birthDate.getDate()) {
              years--;
          }

          return years;
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        var my_birthday_day= data.donor.birthday[0]+data.donor.birthday[1];
        console.log(my_birthday_day);
        var my_birthday_month= data.donor.birthday[3]+data.donor.birthday[4];
        console.log(my_birthday_month);
        var my_birthday_year= data.donor.birthday[6]+data.donor.birthday[7]+data.donor.birthday[8]+data.donor.birthday[9];
        console.log(my_birthday_year);
        var my_birthday = my_birthday_month + '/' + my_birthday_day + '/' + my_birthday_year;
        console.log(my_birthday);

        var age = calculateAge(my_birthday, today); // Format: MM/DD/YYYY
        console.log(age);
        $('#age').html(age+' years old');
        // age calculation

        $('#phone').html(data.donor.phone);
        $('#address').html(data.donor.address);

        if(data.donor.donate_count==0){
           var total_donate =  'Not yet donated';
        } else{
           var total_donate = data.donor.donate_count+" time(s)";
        }
        tr += `<tr><td>Donated</td><td><b>`+total_donate+`</b></td></tr>`;

        $('#history').html(tr);
      }
    });
  });
</script>
<!-- view -->

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
