<?php

error_reporting(E_ALL);

require_once("lib/admin_brain.php");
require_once("lib/vb.php");
require_once '../db/config.php';

//Starting the login Session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['adminuser']) || empty($_SESSION['adminuser'])){
  header("location: index");
  exit;
}

//Variabling the Session
$adminuser = $_SESSION['adminuser'];
//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);

$current_password_err = $current_admin_username_err = $new_password_err = $verify_password_err = $database_update_err = '';

//If user Save Settings
if(isset($_POST["save"])){

//Check if Username field is empty
    if(empty(trim($_POST["admin_username"]))){
        $current_admin_username_err = '<div class="ui negative message">
  <div class="header">
   Please do not leave empty username field.
  </div></div>';
    } else{
        $admin_username = trim($_POST["admin_username"]);
    } 
//Check if Current Password field is empty
    if(empty(trim($_POST["current_password"]))){
        $current_password_err = '<div class="ui negative message">
  <div class="header">
   Enter your current password.
  </div></div>';
    } else{
        $current_password = trim($_POST["current_password"]);
    }
//Check if New Password field is empty
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = '<div class="ui negative message">
  <div class="header">
   Enter your new password.
  </div></div>';
    } else{
        $new_password = trim($_POST["new_password"]);
    } 
//Verify errors
if (empty($current_password_err) && empty($new_password_err) && empty($current_admin_username_err)) {
        
//Verify Current Password
if(password_verify($current_password, $hashed_password)){
//Hash the new password
$new_password = password_hash($new_password, PASSWORD_DEFAULT);  
//Update Database with new informations
$updateaccountsettings = UpdateAdminAccountSettings($admin_username,$new_password);
//Check if database saved new informations
if ($updateaccountsettings == 'no') {
  $database_update_err = '<div class="ui negative message">
  <div class="header">
   Internt Database Error.
  </div></div>';
} else {
  $database_update_err = '<div class="ui positive message">
  <div class="header">
   Changed Account Settings.
  </div></div>';
}

}else {
//Give Error if verification of current password failed
$verify_password_err = '<div class="ui negative message">
  <div class="header">
   Looks like you do not know current password.
  </div></div>';

}

}       

}
?>
<head>
  <!-- Website informations -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <meta name="description" content="Cryptocurrency Games&Casino&Faucet Script" />
  <meta name="author" content="Cryptocurrency & Faucet & Games & Casino Script by LenzScripts" />
<!-- Semantic -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
<!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar navbar-dark" style="background-color: #05437b;">
  <a class="navbar-brand" href="#">ADMIN PANEL</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard"><i class="home icon"></i>Dashboard <span class="sr-only">(current)</span></a>
      </li>
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="users icon"></i> Users Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="users"><i class="users icon"></i>Total Users</a>
          <a class="dropdown-item" href="ban"><i class="user times icon"></i>Ban Users</a>
          <a class="dropdown-item" href="intern_transactions"><i class="exchange icon"></i>Users Internal Transactions</a>
          <a class="dropdown-item" href="users_withdrawals"><i class="exchange icon"></i>Users Withdrawals</a>
        </div>
      </li>            
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="cogs loading icon"></i> Website Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="settings"><i class="cog icon"></i>Website Settings</a>
          <a class="dropdown-item" href="settings_api"><i class="cogs icon"></i>API Settings</a>
        </div>
      </li>
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="gamepad loading icon"></i> Games Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="settings_cointale"><i class="rocket icon"></i>Cointale Settings</a>
          <a class="dropdown-item" href="settings_faucet"><i class="gift icon"></i>Faucet Settings</a>
          <a class="dropdown-item active" href="settings_luckynumber"><i class="gem icon"></i>Lucky Number Settings</a>
          <a class="dropdown-item" href="settings_roll"><i class="trophy icon"></i>Roll Settings</a>
        </div>
      </li> 
       <li class="nav-item active">
        <a class="nav-link" href="account_settings"><i class="user circle icon"></i>Admin Settings</a>
      </li>               
       <li class="nav-item">
        <a class="nav-link" href="out"><i class="sign-out icon"></i>Log out</a>
      </li>       
    </ul>
    <span class="navbar-text">
<button class="teal ui button"><i class="info icon"></i>Check Script Changelogs And News</button>
    </span>
  </div>
</nav>
</nav>
<br>
<br>
<br>
<div class="ui three column doubling stackable grid container">
  <div class="column">
  </div>
<div class='column'> 
<center><h1>Admin Account Settings</h1>
<br>
<br>
<form action="" method="post">
   <h5>Username :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Your Current Admin Username" name="admin_username" value="<?php echo $admin_username; ?>" type="text">
  <i class="user blue icon"></i>
</div>
<br>
<br>  
   <h5>Your <b>Current</b> Password :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Your Current Password" name="current_password" type="text">
  <i class="lock blue icon"></i>
</div>
<br>
<br>
   <h5>Your <b>New</b> Password :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Your New Password" name="new_password" type="text">
  <i class="lock blue icon"></i>
</div>
<br>
<br>
<br>
<?php
echo $current_password_err;
echo $current_admin_username_err;
echo $new_password_err;
echo $verify_password_err;
echo $database_update_err;
?>
<button name="save" class="fluid green ui button">Save Settings</button>  
</form>  
</div>
  <div class="column">
  </div>
  </center>
</div>
</body>