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

// donate today
if (isset($_POST['action']) && $_POST['action']=='donate_today') {
  $donor_id = $_POST['donor_id'];
  $old_date = '';

  $sql = "SELECT * FROM donar_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $result_check = mysqli_num_rows($result);
  if( $result_check > 0 ){
    while ($row = mysqli_fetch_assoc($result)) {
        $old_date = $row['last_donate_date'];
        $donation_count = $row['donate_count']+1;
    }
  }

  $today = date('d/m/Y');

  $sql = "INSERT INTO donation_history(donor_id, donate_date) VALUES ('$donor_id','$old_date');";
  mysqli_query($conn, $sql);

  $sql = "DELETE FROM donation_history WHERE donor_id='$donor_id' AND donate_date='01/01/2001';";
  mysqli_query($conn, $sql);

  $sql = "UPDATE donar_list SET last_donate_date='$today', donate_count='$donation_count' WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['donate_today']='true';

  echo json_encode($old_date);
}
// donate today

// donated somewhere
if (isset($_POST['action']) && $_POST['action']=='donated_somewhere') {
  $donor_id = $_POST['donor_id'];
  $last_donated_somewhere_date = $_POST['last_donated_somewhere_date'];

  // last donation date validation
  if (empty($last_donated_somewhere_date)) {
    echo json_encode('empty_date');
    exit();
  } else if(checkFormat($last_donated_somewhere_date)){
    echo json_encode('invalied_format');
    exit();
  } else if(dateCheck($last_donated_somewhere_date)){
    echo json_encode('invalied_date');
    exit();
  } else if(futuredate($last_donated_somewhere_date)){
    echo json_encode('future_date');
    exit();
  }

  $sql = "SELECT * FROM donar_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $result_check = mysqli_num_rows($result);
  if( $result_check > 0 ){
    while ($row = mysqli_fetch_assoc($result)) {
        $previous_donated_date = $row['last_donate_date'];

        $date1 = str_replace('/', '-', $last_donated_somewhere_date); // Replaces all slashes with hyphens.
        $date1 = strtotime($date1);

        $date2 = str_replace('/', '-', $previous_donated_date); // Replaces all slashes with hyphens.
        $date2 = strtotime($date2);

        if ( $date1<=$date2 ) {
          echo json_encode('before_last_donation');
          exit();
        }
    }
  }
  // last donation date validation

  $old_date = '';

  $sql = "SELECT * FROM donar_list WHERE id='$donor_id';";
  $result = mysqli_query($conn, $sql);
  $result_check = mysqli_num_rows($result);
  if( $result_check > 0 ){
    while ($row = mysqli_fetch_assoc($result)) {
        $old_date = $row['last_donate_date'];
        $donation_count = $row['donate_count']+1;
    }
  }

  $sql = "INSERT INTO donation_history(donor_id, donate_date) VALUES ('$donor_id','$old_date');";
  mysqli_query($conn, $sql);

  $sql = "DELETE FROM donation_history WHERE donor_id='$donor_id' AND donate_date='01/01/2001';";
  mysqli_query($conn, $sql);

  $last_donated_somewhere_date = setFormat($last_donated_somewhere_date);

  $sql = "UPDATE donar_list SET last_donate_date='$last_donated_somewhere_date', donate_count='$donation_count' WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['donate_today']='true';
  $_SESSION['dateErr'] = '';

  echo json_encode($old_date);
}
// donated somewhere

// mute donor
if (isset($_POST['action']) && $_POST['action']=='mute') {
  $donor_id = $_POST['donor_id'];

  $sql = "UPDATE donar_list SET muted=1 WHERE id='$donor_id';";
  mysqli_query($conn, $sql);

  $_SESSION['muted']='true';

  echo json_encode('muted');
}
// mute donor
?>
