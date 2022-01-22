<?php
$current_page="excel";
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
        <h2>Download excel data</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="demo-form2" method="post" action="excel_check.php" data-parsley-validate class="form-horizontal form-label-left">

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
              <button type="submit" name="excel" class="btn btn-success" style="width: 200px"><i class="fa fa-download" style="padding-right: 10px"></i>Download excel file</button>
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

<!-- wrong pass -->
<?php
  if ($_SESSION['excel_pass']=='false') {
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
    $_SESSION['excel_pass']='';
  }
 ?>
<!-- wrong pass -->

</body>
</html>
