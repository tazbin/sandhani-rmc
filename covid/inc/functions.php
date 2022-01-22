<?php
date_default_timezone_set('Asia/Dhaka');
// name validation
function nameValidate($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  $data = str_replace(' ', '-', $data); // Replaces all spaces with hyphens.
  $data = preg_replace('/[^A-Za-z0-9\-]/', '', $data); // Removes special chars.
  $data = str_replace('-', ' ', $data); // Replaces all hypens with spaces.

  return trim($data); //eliminating spaces
}
// name validation

// blood group validation
function groupValidate($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return trim($data); //eliminating spaces
}

function groupCheck($data){
  $data = strtolower($data);
  if ( $data=='a+' || $data=='a-' || $data=='b+' || $data=='b-' || $data=='o+' || $data=='o-' || $data=='ab+' || $data=='ab-' ){
    return 0;
  } else{
    return 1;
  }

}
// blood group validation

// last donate date validate
function dateValidate($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return trim($data); //eliminating spaces
}

function checkFormat($data) {
  if(strlen($data)<6 || strlen($data)>10){
    return 1;
  }

  $length = strlen($data);
  $slash_count=0;
  for ($i=0; $i < $length; $i++) {
    if($data[$i] == '/'){
      $slash_count++;
    }
  }
  if ($slash_count!=2) {
    return 1;
  }
  if ($slash_count==2) {
    $array = explode('/', $data);
    if( !is_numeric($array[0]) || !is_numeric($array[1]) || !is_numeric($array[2]) ){
      return 1;
    }
  }

}

function setFormat($data){
  $array = explode("/", $data);

  $day = $array[0];
  $month = $array[1];
  $year = $array[2];

  if(strlen($day)==1){
    $day='0'.$day;
  }
  if(strlen($month)==1){
    $month='0'.$month;
  }
  if(strlen($year)==2){
    $year='20'.$year;
  }

  $data = $day.'/'.$month.'/'.$year;

  return $data;
}

function dateCheck($data){
  $array = explode("/", $data);

  $day = $array[0];
  $month = $array[1];
  $year = $array[2];

  if ( !checkdate($month,$day,$year) ) {
    return 1;
  }
}

function futuredate($data){

  $data = setFormat($data);

  $data = str_replace('/', '-', $data); // Replaces all slashes with hyphens.
  $today = date('d-m-Y');
  $date1 = strtotime($data);
  $date2 = strtotime($today);

  if ( ($date1-$date2) > 0 ) {
    return 1;
  }
}
// last donate date validate

// phone validate
function phoneValidate($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  $data = str_replace(' ', '-', $data); // Replaces all spaces with hyphens.
  $data = preg_replace('/[^0-9\-]/', '', $data); // Removes special chars.
  $data = str_replace('-', ' ', $data); // Replaces all hypens with spaces.

  return trim($data); //eliminating spaces
}
// phone validate

function validate($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return trim($data); //eliminating spaces
}


 ?>
