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
        <h2>Change admin password</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="demo-form2" method="post" action="pass.php" data-parsley-validate class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New password <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <input type="password" id="first-name" name="new_pass" placeholder="Enter new password" class="form-control col-md-7 col-xs-12"> <br>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Retype new password <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <input type="password" id="first-name" name="new_pass1" placeholder="Re enter new password" class="form-control col-md-7 col-xs-12"> <br>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Old Password <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <input type="password" id="first-name" name="old_password" placeholder="Enter old password" class="form-control col-md-7 col-xs-12"> <br>
            </div>
          </div>
          <span class="text-danger"></span>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-3">
              <button class="btn btn-default" type="reset"> Clear</button>
              <button type="submit" name="set_pass" class="btn btn-success" style="width: 200px"><i class="fa fa-exchange" style="padding-right: 10px"></i>Change password</button>
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
  if ($_SESSION['chagne_pass']=='empty') {
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
    $_SESSION['chagne_pass']='';
  }
 ?>
<!-- empty -->

<!-- un matched pass -->
<?php
  if ($_SESSION['chagne_pass']=='not_matched') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'top',
        type: 'error',
        title: 'Oops...',
        text: 'Enter same new password!'
      })
    </script>
    <?php
    $_SESSION['chagne_pass']='';
  }
 ?>
<!-- un matched pass -->

<!-- wrong mail -->
<?php
  if ($_SESSION['chagne_pass']=='false') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'top',
        type: 'error',
        title: 'Oops...',
        text: 'Wrong old password!'
      })
    </script>
    <?php
    $_SESSION['chagne_pass']='';
  }
 ?>
<!-- wrong mail -->

</body>
</html>
