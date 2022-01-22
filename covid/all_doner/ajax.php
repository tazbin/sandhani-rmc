<?php
include_once '../../admin/inc/database.php';
include_once '../inc/functions.php';
session_start();

// view code
if (isset($_POST['action']) && $_POST['action']=='view') {
  $donor_id = $_POST['donor_id'];

  $sql = "SELECT * FROM codiv_plasma_donor_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $history_query = "SELECT * FROM covid_plasma_donor_history WHERE donor_id='$donor_id' ORDER BY id DESC LIMIT 3;";
  $history_result = mysqli_query($conn, $history_query);

  $history = [];
  while ($histories = mysqli_fetch_assoc($history_result)){
    $history[] = $histories;
  };

  echo json_encode(['donor' => $row, 'history' => $history]);

  // echo json_encode(['donor' => $row]);
}
// view code

// donate today
if (isset($_POST['action']) && $_POST['action']=='donate_today') {
  $donor_id = $_POST['donor_id'];
  $old_date = 'donation received';

  $sql = "SELECT * FROM codiv_plasma_donor_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $result_check = mysqli_num_rows($result);
  if( $result_check > 0 ){
    while ($row = mysqli_fetch_assoc($result)) {
        $donation_count = $row['donation_count']+1;
    }
  }

  $today = date('d/m/Y');

  $sql = "UPDATE codiv_plasma_donor_list SET record_date='$today', duration=30, donation_count='$donation_count' WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $sql = "INSERT INTO covid_plasma_donor_history(donor_id, history_date, activity) VALUES ('$donor_id','$today','Plasma donation');";
  mysqli_query($conn, $sql);

  $_SESSION['donate_today']='true';

  echo json_encode($old_date);
}
// donate today

// test_today
if (isset($_POST['action']) && $_POST['action']=='test_today') {
  $donor_id = $_POST['donor_id'];

  $old_date = 'test_accepted';
  $today = date('d/m/Y');

  $sql = "UPDATE codiv_plasma_donor_list SET record_date='$today', duration=5, tested=1 WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $sql = "INSERT INTO covid_plasma_donor_history(donor_id, history_date, activity) VALUES ('$donor_id','$today','Titer level tested');";
  mysqli_query($conn, $sql);

  $_SESSION['test_today']='true';

  echo json_encode($old_date);
}
// test_today

// mute donor
if (isset($_POST['action']) && $_POST['action']=='mute') {
  $donor_id = $_POST['donor_id'];

  $sql = "UPDATE codiv_plasma_donor_list SET muted=1 WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['muted']='true';

  echo json_encode('muted');
}
// mute donor

// view edit code
if (isset($_POST['action']) && $_POST['action']=='view_edit') {
  $donor_id = $_POST['donor_id'];

  $sql = "SELECT * FROM codiv_plasma_donor_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  echo json_encode($row);
}
if (isset($_POST['action']) && $_POST['action']=='edit') {
  $donor_id = $_POST['id'];
  $new_name = $_POST['name'];
  $new_phone = $_POST['phone'];
  $new_address = $_POST['address'];

  $sql = "UPDATE codiv_plasma_donor_list SET name='$new_name',phone='$new_phone',address='$new_address' WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['save_changes']='true';

  echo json_encode('updated');
}
// view edit code
?>
