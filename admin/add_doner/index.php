<?php
$current_page="add";
include_once '../inc/header.php';
include_once '../inc/sidebar.php';
include_once '../inc/middle.php';
include_once '../inc/database.php';
?>

<!-- page section -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add new doner</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <?php
        $err = '';

        $err = '';
        $nameErr = '';
        $groupErr = '';
        $dateErr = '';
        $phoneErr = '';
        $addressErr = '';
        $bdayErr = '';

        if (isset($_POST['add'])) {

          $name = nameValidate($_POST['name']);
          $group = groupValidate($_POST['group']);
          $last_donated = dateValidate($_POST['last_donated']);
          $phone = phoneValidate($_POST['phone']);
          $address = validate($_POST['address']);
          $bday = validate($_POST['bday']);
          $rmc = 0;
          if(isset($_POST['rmc'])){
            $rmc = 1;
          }

          $err = 'ok';

          // name validation
          if (empty($name)) {
            $nameErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> name must not be empty';
            $name = '';
            $err = 'empty';
          } else if(strlen($name)>255){
            $nameErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> name must be less then 225 charecter';
            $name = '';
            $err = 'empty';
          }
          // name validation

          // group validation
          if (empty($group)) {
            $groupErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> blood group must not be empty';
            $group = '';
            $err = 'empty';
          }
          // group validation

          // last donation date validation
          if (empty($last_donated)) {
            $dateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> date must not be empty';
            $err = 'empty';
          } else if(checkFormat($last_donated)){
            $dateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert date in <b> dd/mm/yyyy </b> format';
            $last_donated = date('d/m/Y');
            $err = 'empty';
          } else if(dateCheck($last_donated)){
            $dateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert valid date in <b> dd/mm/yyyy </b> format';
            $last_donated = date('d/m/Y');
            $err = 'empty';
          } else if(futuredate($last_donated)){
            $dateErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> future date can not be given';
            $last_donated = date('d/m/Y');
            $err = 'empty';
          }
          // last donation date validation

          // birth date validation
          if (empty($bday)) {
            $bdayErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> date must not be empty';
            $err = 'empty';
          } else if(checkFormat($bday)){
            $bdayErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert date in <b> dd/mm/yyyy </b> format';
            $bday = date('d/m/Y');
            $err = 'empty';
          } else if(dateCheck($bday)){
            $bdayErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> please insert valid date in <b> dd/mm/yyyy </b> format';
            $bday = date('d/m/Y');
            $err = 'empty';
          } else if(futuredate($bday)){
            $bdayErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> future date can not be given';
            $bday = date('d/m/Y');
            $err = 'empty';
          }
          // birth date validation

          // phone validation
          if (empty($phone)) {
            $phoneErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> phone must not be empty';
            $phone = '';
            $err = 'empty';
          } else if (strlen($phone)!=11) {
            $phoneErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> phone must be 11 digit number';
            $phone = '';
            $err = 'empty';
          } else if ($phone[0]!=0 || $phone[1]!=1) {
            $phoneErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> phone must start with 01';
            $phone = '';
            $err = 'empty';
          }
          // phone validation

          // address validation
          if(strlen($address)>225){
            $addressErr = '<i class="fa fa-warning" style="padding-right: 3px"></i> address must be less then 225 charecter or empty';
            $address = '';
            $err = 'empty';
          }
          // address validation

          if($err=='ok'){
            // adding doner
            $group = strtoupper($group);
            $last_donated = setFormat($last_donated);
            $bday = setFormat($bday);
            $count = 1;

            if (isset($_POST['never'])) {
              $last_donated = '01/01/2001';
              $count = 0;
            }

            if (isset($_POST['birth'])) {
              $bday = "01/01/1947";
            }

            $sql = "INSERT INTO donar_list(
              name,
              blood_group,
              last_donate_date,
              birthday,
              phone,
              address,
              donate_count,
              rmc)
              VALUES(
                '$name',
                '$group',
                '$last_donated',
                '$bday',
                '$phone',
                '$address',
                '$count',
                '$rmc');";
            mysqli_query($conn, $sql);

            $name = '';
            $group = '';
            $last_donated = '';
            $phone = '';
            $address = '';

            $err = 'success';
            // adding doner
          }

        }

         ?>
        <form id="demo-form2" method="post" action="" data-parsley-validate class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" autocomplete="off" id="first-name" name="name" required value="<?php echo isset($name)? $name: ''; ?>"  class="form-control col-md-7 col-xs-12">
              <i class="text-danger"> <?php echo $nameErr; ?> </i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Blood group <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select type="text" autocomplete="off" id="first-name" name="group" required class="form-control col-md-7 col-xs-12">
                <option value="">Select one</option>
                <option <?php echo isset($group) && $group=='A+'? 'selected' :''; ?> value="A+">A+</option>
                <option <?php echo isset($group) && $group=='A-'? 'selected' :''; ?> value="A-">A-</option>
                <option <?php echo isset($group) && $group=='B+'? 'selected' :''; ?> value="B+">B+</option>
                <option <?php echo isset($group) && $group=='B-'? 'selected' :''; ?> value="B-">B-</option>
                <option <?php echo isset($group) && $group=='O+'? 'selected' :''; ?> value="O+">O+</option>
                <option <?php echo isset($group) && $group=='O-'? 'selected' :''; ?> value="O-">O-</option>
                <option <?php echo isset($group) && $group=='AB+'? 'selected' :''; ?> value="AB+">AB+</option>
                <option <?php echo isset($group) && $group=='AB-'? 'selected' :''; ?> value="AB-">AB-</option>
              </select>
              <i class="text-danger"> <?php echo $groupErr; ?> </i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Last blood donated <span class="required">*</span> </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <div id="tazbinur">

                <input type="text" autocomplete="off" required value="<?php echo isset($last_donated)? $last_donated: ''; ?>" name="last_donated" class="form-control has-feedback-left date" placeholder="Enter date" aria-describedby="inputSuccess2Status3">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status2" class="sr-only">(success)</span>

                <i class="text-danger"> <?php echo $dateErr; ?> </i>
              </span>
              </div>

            <div class="checkbox">
              <label>
                <input type="checkbox" id="never" name="never"> Never donated
              </label>
            </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Birthday </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <div id="tazbinur_birth">

                <input type="text" autocomplete="off" required value="<?php echo isset($bday)? $bday: ''; ?>" name="bday" class="form-control has-feedback-left date" placeholder="Enter date" aria-describedby="inputSuccess2Status3">
                <i class="text-danger"> <?php echo $bdayErr; ?> </i>
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status2" class="sr-only">(success)</span>

                <i class="text-danger"> <?php echo $dateErr; ?> </i>
              </span>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="birth" name="birth"> No birthdate
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Student
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="rmc" name="rmc"> Student of RMC
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" autocomplete="off" id="first-name" required placeholder="01xxxxxxxxx" value="<?php echo isset($phone)? $phone: ''; ?>" name="phone"  class="form-control col-md-7 col-xs-12">
              <i class="text-danger"> <?php echo $phoneErr; ?> </i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" autocomplete="off" id="first-name" value="<?php echo isset($address)? $address: ''; ?>" name="address" class="form-control col-md-7 col-xs-12">
              <i class="text-danger"> <?php echo $addressErr; ?> </i>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button class="btn btn-default" type="reset"> Clear</button>
              <button type="submit" name="add" class="btn btn-success" style="width: 200px"><i class="fa fa-check" style="margin-right: 10px"></i>Add this donar</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<!-- page section -->

<?php
include_once '../inc/footer.php';
?>

<!-- bootstrap-daterangepicker -->
<script src="../../vendors/moment/min/moment.min.js"></script>
<script src="../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap-datetimepicker -->
<script src="../../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<!-- empty data -->
<?php
  if ($err=='empty') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Fill all fields!',
      })
    </script>
    <?php
  }
?>
<!-- empty data -->

<!-- success data -->
<?php
  if ($err=='success') {
    ?>
    <script type="text/javascript">
    Swal.fire({
      position: 'center',
      type: 'success',
      title: 'New donar added',
      showConfirmButton: false,
      timer: 1500
      })
    </script>
    <?php
  }
?>
<!-- success data -->

<!-- donation date or never -->
<script>
$('#tazbinur').show();
  $(document).on('click', '#never', function(){
    $('#tazbinur').toggle();
  });
</script>
<!-- donation date or never -->

<!-- no birthdate -->
<script>
$('#tazbinur_birth').show();
  $(document).on('click', '#birth', function(){
    $('#tazbinur_birth').toggle();
  });
</script>
<!-- no birthdate -->

</body>
</html>
