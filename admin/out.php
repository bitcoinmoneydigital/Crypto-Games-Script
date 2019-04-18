<?php

//Starting the login Session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
  header("location: index");
  exit;
}

//Variabling the Session
$useraddress = $_SESSION['adminuser'];

// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();


?>
  <meta http-equiv="refresh" content="0; url=index" />