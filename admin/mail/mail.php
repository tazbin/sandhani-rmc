<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include_once '../inc/database.php';

if (isset($_POST['mail'])) {
  $pass = $_POST['password'];
  $new_email = $_POST['email'];

  if (empty($pass) || empty($new_email)) {
    $_SESSION['mail_pass'] = 'empty';
    header('Location: index.php');
    exit();
  } else if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {

    $_SESSION['mail_pass'] = 'invalid';
    header('Location: index.php');
    exit();

  } else{
    $pass = MD5($pass);
    $admin_mail = $_SESSION['email'];
    $sql = "SELECT * FROM admin WHERE email='$admin_mail' AND pass='$pass';";
    $result = mysqli_query($conn, $sql);
    $result_check = mysqli_num_rows($result);
    if( $result_check > 0 ){
      $sql = "UPDATE admin SET email='$new_email' WHERE email='$admin_mail' AND pass='$pass';";
      mysqli_query($conn, $sql);
      $_SESSION['mail_pass'] = 'true';
      header('Location: ../logout/logout.php');
      exit();
    } else{
      $_SESSION['mail_pass'] = 'false';
      header('Location: index.php');
      exit();
    }
  }
  $_SESSION['mail_pass'] = '';
}
?>
