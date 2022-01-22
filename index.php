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
$_SESSION['forget_pass_email'] = '';

if ( isset($_SESSION['admin']) && $_SESSION['admin']=='admin') {
  header('Location: admin/home');
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

    <title>SANDHANI RMC | Log in </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <div class="text-center" style="margin-bottom: -20px">
            <h3> <text style="color: rgb(231, 10, 10)">SANDHANI</text> <text class="text-primary">RMC</text> </h3>
          </div>
          <section class="login_content">
            <?php

            // database connection
            include_once 'admin/inc/database.php';
            // database connection

            $fail='';

              if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (empty($email) || empty($password)) {
                  $fail = "empty";
                } else {

                  //echo $password;

                  $password = MD5($password);

                  // matching data
                  $sql = "SELECT * FROM admin;";
                  $result = mysqli_query($conn, $sql);
                  $result_check = mysqli_num_rows($result);
                  if( $result_check > 0 ){
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ( $row['email']==$email && $row['pass']==$password ) {
                          $_SESSION['email']=$row['email'];
                          $_SESSION['admin']='admin';
                          ?>
                          <script>
                          window.location = "admin/home";
                          </script>
                          <?php
                          exit();
                        }
                    }
                    // wrong data
                    $fail = "wrong";
                    
                  }
                  // matching data
                }
              }

             ?>
            <form method="POST" action="">
              <h1>Login Form</h1>

              <div>
                <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Email"  />
              </div>
              <div>
                <input type="password" autocomplete="off" name="password" class="form-control" placeholder="Password"  />
              </div>
              <div class="text-left">
                <button type="submit" name="login" class="btn btn-block btn-success"> <i class="fa fa-sign-in" style="padding-right: 5px"></i> Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />
                <a href="./credit">Developer credit</a>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>

<script src="sweetalert/sweet.js"></script>

<!-- empty data -->
<?php
  if ($fail=='empty') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Fill email & password!',
      })
    </script>
    <?php
  }
?>
<!-- empty data -->

<!-- wrong data -->
<?php
  if ($fail=='wrong') {
    ?>
    <script type="text/javascript">
      Swal.fire({
        position: 'center',
        type: 'error',
        title: 'Oops...',
        text: 'Wrong email & password!',
      })
    </script>
    <?php
  }
?>
<!-- wrong data -->

</html>
