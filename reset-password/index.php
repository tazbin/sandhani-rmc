<?php
session_start();
$_SESSION['donate_today']='';
$_SESSION['muted']='';
$_SESSION['unmuted']='';
$_SESSION['delete']='';
$_SESSION['save_changes']='';
$_SESSION['export']='';
$_SESSION['export_pass']='';
$_SESSION['excel']='';
$_SESSION['excel_pass']='';
$_SESSION['chagne_pass']='';
$_SESSION['mail_pass']='';

if ( isset($_SESSION['admin']) && $_SESSION['admin']=='admin') {
  header('Location: ../');
  exit();
}

if( !isset($_SESSION['forget_pass_email']) || $_SESSION['forget_pass_email'] == ''  ) {
  ?>
  <script>
  window.location = "../forget-password";
  </script>
  <?php
}


?>
<!-- Template name: gentelella
Made by: Colorlib  -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="admin/img/logo-white.png" type="image/gif" sizes="16x16">

    <title>SANDHANI RMC | Forgot password </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <div class="text-center" style="margin-bottom: -20px">
            <img src="../admin/img/logo-white.png" style="width: 150px;margin-bottom: 10px" alt="">
            <h3> <text style="color: rgb(231, 10, 10)">SANDHANI</text> <text class="text-primary">RMC</text> </h3>
          </div>
          <section class="login_content">
            <?php

            // database connection
            include_once '../admin/inc/database.php';

            $fail='';

              if (isset($_POST['reset'])) {

                $code = $_POST['code'];
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];

                if (empty($code) || empty($pass1) || empty($pass2)) {

                  $fail = "empty";

                } else if( $pass1 != $pass2 ) {

                  $fail = "not-matched";

                } else {

                  // matching data
                  $sql = "SELECT * FROM admin WHERE code = '$code';";
                  $result = mysqli_query($conn, $sql);
                  $result_check = mysqli_num_rows($result);
                  if( $result_check > 0 ){

                    $pass1 = MD5($pass1);
                    $sql = "UPDATE admin SET pass = '$pass1', code = 0 WHERE email='".$_SESSION['forget_pass_email']."';";
                    $result = mysqli_query($conn, $sql);

                    $_SESSION['forget_pass_email'] == '';
                    $_SESSION['password_reset_success'] = true;
                    ?>
                    <script>
                    window.location = "../";
                    </script>
                    <?php

                  } else {
                    $fail = "wrong-code";
                  }

                }
              }

             ?>
            <form method="POST" action="">
              <h1>Reset Pass</h1>

              <div class="text-left" style="margin-bottom: 10px; margin-top: -10px;">
                <a class="" href="../forget-password">Send code again</a>
                <a class="" href="../">Login</a>
                <br>
                <i style="margin-top: 5px">
                  An email has been sent to your email containing a code. Please wait up to 10 minutes to get the email. Enter the code from email & your new password below.
                </i>
              </div>

              <div>
                <input type="text" autocomplete="off" name="code" class="form-control" placeholder="Enter code"  />
              </div>
              <div>
                <input type="password" autocomplete="off" name="pass1" class="form-control" placeholder="Enter new password"  />
              </div>
              <div>
                <input type="password" autocomplete="off" name="pass2" class="form-control" placeholder="Re-enter new password"  />
              </div>
              <div class="text-left">
                <button type="submit" name="reset" class="btn btn-block btn-success"> <i class="fa fa-envelope-o" style="padding-right: 5px"></i> Set new password </button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>

<script src="../sweetalert/sweet.js"></script>

<!-- empty data -->
<?php
  if ($fail=='empty') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Fill code & passwords!',
      })
    </script>
    <?php
  }
?>
<!-- empty data -->

<!-- not-matched -->
<?php
  if ($fail=='not-matched') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Wrong code entered!',
      })
    </script>
    <?php
  }
?>
<!-- not-matched -->

<!-- not-matched -->
<?php
  if ($fail=='not-matched') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Please enter same password twice!',
      })
    </script>
    <?php
  }
?>
<!-- not-matched -->

<!-- wrong-code -->
<?php
  if ($fail=='wrong-code') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Your entered wrong code!',
      })
    </script>
    <?php
  }
?>
<!-- wrong-code -->

</html>
