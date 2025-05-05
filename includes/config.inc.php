<?php
  session_start();
  $servername = "localhost"; 
  $dBUsername = "root";
  $dbPassword = "";
  $dBName = "hostel_management_system";
 // session_start();
  $conn=mysqli_connect($servername, $dBUsername, $dbPassword, $dBName);

  if (!$conn) {
    die("Connection Failed: ".mysqli_connect_error());
  }
?>