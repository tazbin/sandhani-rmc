<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include_once '../inc/database.php';

if ($_SESSION['admin']!='admin' || $_SESSION['excel']!='true') {
  header('Location: ../../');
  exit();
}

$_SESSION['excel']='false';
$_SESSION['excel_pass'] = 'true';

$output = '';
 $query = "SELECT * FROM donar_list WHERE del=0";
 $result = mysqli_query($conn, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">
   <tr>
     <th>Id</th>
     <th>Name</th>
     <th>Blood group</th>
    <th>Last donated</th>
    <th>Phone no</th>
    <th>Address</th>
    <th>Total donation</th>
    <th>Muted</th>
    <th>Deleted</th>
  </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
    if ($row["muted"]==1) {
      $muted='Yes';
    } else {
      $muted='No';
    }

    if ($row["del"]==1) {
      $deleted='Yes';
    } else{
      $deleted='No';
    }

   $output .= '
    <tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["name"].'</td>
      <td>'.$row["blood_group"].'</td>
      <td>'.$row["last_donate_date"].'</td>
      <td>'.$row["phone"].'</td>
      <td>'.$row["address"].'</td>
      <td>'.$row["donate_count"].'</td>
      <td>'.$muted.'</td>
      <td>'.$deleted.'</td>
    </tr>
   ';
  }
  $output .= '</table>';
  $date = date('d-m-Y');
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=sondhani rmc ('.$date.').xls');
  echo $output;
 }
?>
