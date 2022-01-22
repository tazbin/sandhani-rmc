<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include_once '../inc/database.php';

if (isset($_POST['set_pass'])) {
  $new_pass = $_POST['new_pass'];
  $new_pass1 = $_POST['new_pass1'];
  $old_pass = $_POST['old_password'];

  if (empty($new_pass) || empty($new_pass1) || empty($old_pass)) {
    $_SESSION['chagne_pass'] = 'empty';
    header('Location: index.php');
    exit();
  } else{
    $old_pass = MD5($old_pass);
    $admin_mail = $_SESSION['email'];
    $sql = "SELECT * FROM admin WHERE email='$admin_mail' AND pass='$old_pass';";
    $result = mysqli_query($conn, $sql);
    $result_check = mysqli_num_rows($result);
    if( $result_check > 0 ){
      $new_pass = trim($new_pass);
      $new_pass1 = trim($new_pass1);
      if ($new_pass!=$new_pass1) {
        $_SESSION['chagne_pass'] = 'not_matched';
        header('Location: index.php');
        exit();
      }
      //update password
      $new_pass = MD5($new_pass);
      $sql = "UPDATE admin SET pass='$new_pass' WHERE email='$admin_mail' AND pass='$old_pass';";
      mysqli_query($conn, $sql);
      header('Location: ../logout/logout.php');
      exit();
      //update password
    } else{
      $_SESSION['chagne_pass'] = 'false';
      header('Location: index.php');
      exit();
    }
  }
}
?>
