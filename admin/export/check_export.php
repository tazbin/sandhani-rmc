<?php
session_start();
include_once '../inc/database.php';

if (isset($_POST['export'])) {
  $pass = $_POST['password'];

  if (empty($pass)) {
    $_SESSION['export']='false';
    header('Location: index.php');
    exit();
  }

  $pass = MD5($pass);
  $matched = 'false';

  $sql = "SELECT * FROM admin;";
  $result = mysqli_query($conn, $sql);
  $result_check = mysqli_num_rows($result);
  if( $result_check > 0 ){
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['username']==$_SESSION['username'] && $row['pass']==$pass) {
        $_SESSION['export']='true';
        header('Location: export.php');
        exit();
      }
    }
 }

  $_SESSION['export']='false';
  header('Location: index.php');
  exit();
}
 ?>
