<?php
include_once '../inc/database.php';
include_once '../inc/functions.php';
session_start();

// view code
if (isset($_POST['action']) && $_POST['action']=='view') {
  $donor_id = $_POST['donor_id'];

  $sql = "SELECT * FROM donar_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $history_query = "SELECT * FROM donation_history WHERE donor_id='$donor_id' ORDER BY id DESC LIMIT 2;";
  $history_result = mysqli_query($conn, $history_query);

  $history = [];
  while ($histories = mysqli_fetch_assoc($history_result)){
    $history[] = $histories;
  };

  echo json_encode(['donor' => $row, 'history' => $history]);
}
// view code
?>
