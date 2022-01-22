<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include_once '../inc/database.php';

if (isset($_POST['excel'])) {
  $pass = $_POST['password'];

  if (empty($pass)) {
    $_SESSION['excel_pass'] = 'false';
    
    header('Location: index.php');
    exit();
  } else{
    $pass = MD5($pass);
    $admin_mail = $_SESSION['email'];
    $sql = "SELECT * FROM admin WHERE email='$admin_mail' AND pass='$pass';";
    $result = mysqli_query($conn, $sql);
    $result_check = mysqli_num_rows($result);
    if( $result_check > 0 ){
      //download excel
      $_SESSION['excel']='true';
      $_SESSION['excel_pass'] = 'true';
      header('Location: excel.php');
      exit();
      //download excel
    } else{
      $_SESSION['excel_pass'] = 'false';
      // echo $_SESSION['excel_pass'];
      header('Location: index.php');
      exit();
    }
  }
  $_SESSION['excel_pass'] = '';
}

 ?>
