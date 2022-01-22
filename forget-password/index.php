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

include 'mail.php';

if( !isset($_SESSION['forget_pass_email']) ) {
  $_SESSION['forget_pass_email'] = '';
}

if ( isset($_SESSION['admin']) && $_SESSION['admin']=='admin') {
  header('Location: ../');
  exit();
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
            <h3> <text style="color: rgb(231, 10, 10)">SANDHANI</text> <text class="text-primary">RMC Unit</text> </h3>
          </div>
          <section class="login_content">
            <?php

            // random string generator
            function generateRandomString($length) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%$#@!&';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

            // database connection
            include_once '../admin/inc/database.php';

            $fail='';

              if (isset($_POST['forgot'])) {
                $email = $_POST['email'];

                if (empty($email)) {

                  $fail = "empty";

                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                  $fail = "invalid";

                } else {

                  // matching data
                  $sql = "SELECT * FROM admin WHERE email = '$email';";
                  $result = mysqli_query($conn, $sql);
                  $result_check = mysqli_num_rows($result);
                  if( $result_check > 0 ){

                    $code = generateRandomString(6);
                    $sql = "UPDATE admin SET code = '$code' WHERE email = '$email';";
                    $result = mysqli_query($conn, $sql);

                    $_SESSION['forget_pass_email'] = $email;
                    
                    // send code via email -------------------------------------------------
                    $to   = $email;
                    $from = '***';
                    $name = '***';
                    $subj = 'password reset code';
                    $msg = "
                    <html>
                    <head>
                    <title>reset password</title>
                    </head>
                    <body>
                    <div style='max-width: 800px;'>
                      <h3>As-salamu alaykum!</h3>
                      <p>
                      We've got activity on our website *** that you might forget your password & want to reset it now. For verification, we've sent a code with this email body.
                      </p>
                      <p>
                        Your code is: <b> ".$code." </b>
                      </p>
                      <p>
                        Use this code in the <i>reset password form</i> to reset your password.
                      </p>
                      <hr>
                      <p>
                        THIS IS NOT YOU? you did not request for a code or forget your password? Then someone else who knows this email is trying to get in your website. We recommend you change your password immediately & do not share with anyone else that this email is used on your website except the admins.
                        <br> <br>
                        Regards, <br>
                        Webmaster <br>
                        ***
                      </p>
                      <i>Note: This email doesn't read replies. For any query, contact your admins.</i>
                    </div>
                    </body>
                    </html>
                    ";

                      $error=smtpmailer($to,$from, $name ,$subj, $msg);
                      if( $error == true ) {
                          $fail = "error";
                      }
                    // send code via email -------------------------------------------------

                  } else {
                    // wrong email
                    $fail = "wrong";
                  }

                }
              }

             ?>
            <form method="POST" action="">
              <h1>Forgot Pass</h1>
              <div>
                <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Email"  />
              </div>
              <div class="text-left">
                <button type="submit" name="forgot" class="btn btn-block btn-success"> <i class="fa fa-envelope-o" style="padding-right: 5px"></i> Send code</button>
                <a class="" href="../">I remember password</a>
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
        text: 'Fill email!',
      })
    </script>
    <?php
  }
?>
<!-- empty data -->

<!-- invalid data -->
<?php
  if ($fail=='invalid') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Invalid email!',
      })
    </script>
    <?php
  }
?>
<!-- invalid data -->

<!-- wrong data -->
<?php
  if ($fail=='wrong') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Wrong email!',
      })
    </script>
    <?php
  }
?>
<!-- wrong data -->

<!-- error data -->
<?php
  if ($fail=='error') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Server error! Try again...',
      })
    </script>
    <?php
  }
?>
<!-- error data -->

</html>
