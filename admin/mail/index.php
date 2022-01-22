<?php
$current_page="mail";
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
        <h2>Change admin Email</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="demo-form2" method="post" action="mail.php" data-parsley-validate class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Email <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <input type="email" autocomplete="off" id="first-name" name="email" placeholder="Enter new email" class="form-control col-md-7 col-xs-12"> <br>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <input type="password" id="first-name" name="password" placeholder="Enter password" class="form-control col-md-7 col-xs-12"> <br>
            </div>
          </div>
          <span class="text-danger"></span>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-3">
              <button class="btn btn-default" type="reset"> Clear</button>
              <button type="submit" name="mail" class="btn btn-success" style="width: 200px"><i class="fa fa-exchange" style="padding-right: 10px"></i>Change Username</button>
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

<!-- empty -->
<?php
  if ($_SESSION['mail_pass']=='empty') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'top',
        type: 'error',
        title: 'Oops...',
        text: 'Fill al fields!'
      })
    </script>
    <?php
    $_SESSION['mail_pass']='';
  }
 ?>
<!-- empty -->

<!-- invalid -->
<?php
  if ($_SESSION['mail_pass']=='invalid') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'top',
        type: 'error',
        title: 'Oops...',
        text: 'You entered an invalid email!'
      })
    </script>
    <?php
    $_SESSION['mail_pass']='';
  }
 ?>
<!-- invalid -->

<!-- wrong pass -->
<?php
  if ($_SESSION['mail_pass']=='false') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'top',
        type: 'error',
        title: 'Oops...',
        text: 'Wrong password!'
      })
    </script>
    <?php
    $_SESSION['mail_pass']='';
  }
 ?>
<!-- wrong pass -->

<!-- invalied mail -->
<?php
  if ($_SESSION['mail_pass']=='mail') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'top',
        type: 'error',
        title: 'Oops...',
        text: 'Invalied Username!'
      })
    </script>
    <?php
    $_SESSION['mail_pass']='';
  }
 ?>
<!-- invalied mail -->

</body>
</html>
