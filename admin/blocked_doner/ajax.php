<?php
include_once '../inc/database.php';
session_start();

// view code
if (isset($_POST['action']) && $_POST['action']=='view') {
  $donor_id = $_POST['donor_id'];

  $sql = "SELECT * FROM donar_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $history_query = "SELECT * FROM donation_history WHERE donor_id='$donor_id' ORDER BY id DESC LIMIT 2;";
  $history_result = mysqli_query($conn, $history_query);

  $history = [];
  while ($histories = mysqli_fetch_assoc($history_result)){
    $history[] = $histories;
  };

  echo json_encode(['donor' => $row, 'history' => $history]);
}
// view code

// unmute donor
if (isset($_POST['action']) && $_POST['action']=='unmute') {
  $donor_id = $_POST['donor_id'];

  $sql = "UPDATE donar_list SET muted=0 WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['unmuted']='true';

  echo json_encode('unmuted');
}
//un mute donor

//delete donor
if (isset($_POST['action']) && $_POST['action']=='delete') {
  $donor_id = $_POST['donor_id'];

  $sql = "UPDATE donar_list SET del=1 WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['delete']='true';

  echo json_encode('delete');
}
//delete donor
?>
