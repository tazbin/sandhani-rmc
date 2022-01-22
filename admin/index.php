<?php
session_start();

if ($_SESSION['admin']=='admin') {
  header('Location: home');
  exit();
} else{
  header('Location: ../');
  exit();
}
?>
