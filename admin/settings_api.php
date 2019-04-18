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

$updatemessage = '';

//If user Save Settings
if(isset($_POST["save"])){

      $faucethub_api = $_POST['faucethub_api'];
      $iphub_api = $_POST['iphub_api'];
      $solvemedia_priv_api = $_POST['solvemedia_priv_api'];
      $solvemedia_hash_api = $_POST['solvemedia_hash_api'];
      $solvemedia_pub_api = $_POST['solvemedia_pub_api'];
      $shortlink_api = $_POST['shortlink_api'];
      $coinhive_api = $_POST['coinhive_api'];

$updatewebsettings = UpdateAPIsettings($faucethub_api,$iphub_api,$solvemedia_priv_api,$solvemedia_hash_api,$shortlink_api,$solvemedia_pub_api,$coinhive_api);

if ($updatewebsettings == 'ok') {
  $updatemessage = '<div class="ui positive message">
  <div class="header">
    You Updated Succesfully
  </div>
</div>';
} else {
$updatemessage = '<div class="ui negative message">
  <div class="header">
   Something Happened , we can not save updates.
  </div></div>';
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
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="cogs loading icon"></i> Website Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="settings"><i class="cog icon"></i>Website Settings</a>
          <a class="dropdown-item active" href="settings_api"><i class="cogs icon"></i>API Settings</a>
        </div>
      </li>
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="gamepad loading icon"></i> Games Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="settings_cointale"><i class="rocket icon"></i>Cointale Settings</a>
          <a class="dropdown-item" href="settings_faucet"><i class="gift icon"></i>Faucet Settings</a>
          <a class="dropdown-item" href="settings_luckynumber"><i class="gem icon"></i>Lucky Number Settings</a>
          <a class="dropdown-item" href="settings_roll"><i class="trophy icon"></i>Roll Settings</a>
        </div>
      </li>  
       <li class="nav-item">
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
<br>
<br>
<br>
<div class="ui three column doubling stackable grid container">
  <div class="column">
    <h1>API Settings</h1>
    <center><?php echo $updatemessage; ?></center>
<br>
<br>
<form action="" method="post">
 <br> 
  <h5>Faucethub API :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Faucethub API" name="faucethub_api" value="<?php echo $faucethub_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
 <br>
 <br> 
  <h5>IPhub API :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="IPhub API" name="iphub_api" value="<?php echo $iphub_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Coinhive API :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Coinhive API" name="coinhive_api" value="<?php echo $coinhive_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>  
  </div>  
<div class='column'> 
<br>
<br>
<br>
<br>
<br>
<br>
<center>
  <h5>Solvemedia Private Key :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Solvemedia Private Key" name="solvemedia_priv_api" value="<?php echo $solvemedia_priv_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Solvemedia Hash Key :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Solvemedia Hash Key" name="solvemedia_hash_api" value="<?php echo $solvemedia_hash_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
</center>
</div>
<div class="column">
<br>
<br>
<br>
<br>
<br>
<br>
<center>
 <h5>Solvemedia Pub Key :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Solvemedia Pub Key" name="solvemedia_pub_api" value="<?php echo $solvemedia_pub_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
<br>
<br>
 <h5>Shortlink API :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Shortlink API" name="shortlink_api" value="<?php echo $shortlink_api; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
</center> 
</div>
<button name="save" class="fluid green ui button">Save Settings</button>
</form>
</body>