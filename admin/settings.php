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

      $web_title = $_POST['web_title'];
      $website_url = $_POST['website_url'];
      $web_description = $_POST['web_description'];
      $web_keywords = $_POST['web_keywords'];
      $contact_email = $_POST['contact_email'];
      $contact_facebook = $_POST['contact_facebook'];
      $contact_twitter = $_POST['contact_twitter'];
      $contact_linkedin = $_POST['contact_linkedin'];
      $contact_googleplus = $_POST['contact_googleplus'];
      $referal_percentage = $_POST['referal_percentage'];
      $min_withdraw_amount = $_POST['min_withdraw_amount'];
      $withdraw_status = $_POST['withdraw_status'];
      $base_currency = $_POST['base_currency'];
      $withdraw_status_r = $_POST['withdraw_status_r'];
      $min_withdraw_amount_r = $_POST['min_withdraw_amount_r'];

      $referal_percentage = floor($referal_percentage);
      $min_withdraw_amount = floor($min_withdraw_amount);

$updatewebsettings = UpdateWebsiteSettings($web_title,$website_url,$web_description,$web_keywords,$contact_email,$contact_facebook,$contact_twitter,$contact_linkedin,$contact_googleplus,$referal_percentage,$min_withdraw_amount,$withdraw_status,$base_currency,$withdraw_status_r,$min_withdraw_amount_r);

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
          <a class="dropdown-item active" href="settings"><i class="cog icon"></i>Website Settings</a>
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
    <h1>Website Settings</h1>
    <?php echo $updatemessage; ?>
<br>
<br>
<form action="" method="post">
 <br> 
  <h5>Website Name :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Website Name" name="web_title" value="<?php echo $web_title; ?>" type="text">
  <i class="i cursor blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Website Url :</h5>
  <p>Please include http:// or https://</p>
<div class="ui large left icon input">
  <input placeholder="Website Url" name="website_url" value="<?php echo $website_url; ?>" type="text">
  <i class="i cursor blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Facebook Page (link) :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Facebook Link" name="contact_facebook" value="<?php echo $contact_facebook; ?>" type="text">
  <i class="facebook blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Google Plus Page (link) :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Google Plus Link" name="contact_googleplus" value="<?php echo $contact_googleplus; ?>" type="text">
  <i class="google plus g blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Withdrawal Page Status :</h5>
  <br>
  <div class="field">
    <select name="withdraw_status">
      <option value="<?php echo $withdraw_status; ?>" selected="selected"></option>
      <option value="0">Active</option>
      <option value="1">Disabled</option>
    </select>
  </div>
  <br>
  <?php 
if ($withdraw_status == '1') {
    $withdraw_status_l = '<a class="ui red label">Disabled</a>';
  } else {
    $withdraw_status_l = '<a class="ui green label">Active</a>';
  }  
echo "Current Status is : $withdraw_status_l ";
  ?>
 <br>
<br>
 <br> 
  <h5>Minimum Withdrawal Amount (Referal) :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Minimum Withdrawal Amount Referal" name="min_withdraw_amount_r" value="<?php echo $min_withdraw_amount_r; ?>" type="text">
  <i class="i cursor blue icon"></i>
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
  <h5>Website Description :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Website Description" name="web_description" value="<?php echo $web_description; ?>" type="text">
  <i class="i cursor blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Website Keywords :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Website Keywords" name="web_keywords" value="<?php echo $web_keywords; ?>" type="text">
  <i class="i cursor blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Twitter Page (link) :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Twitter Link" name="contact_twitter" value="<?php echo $contact_twitter; ?>" type="text">
  <i class="twitter blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Minimum Withdrawal Amount :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Minimum Withdrawal Amount" name="min_withdraw_amount" value="<?php echo $min_withdraw_amount; ?>" type="text">
  <i class="money bill alternate outline blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Supported Currency :</h5>
  <br>
  <div class="field">
    <select name="base_currency">
      <option value="<?php echo $base_currency; ?>" selected="selected"></option>
      <option value="btc">Bitcoin</option>
      <option value="eth">Ethereum</option>
      <option value="xmr">Monero</option>
      <option value="ltc">Litecoin</option>
      <option value="doge">Dogecoin</option>
      <option value="bch">Bitcoin Cash</option>
      <option value="zec">Zcash</option>
      <option value="dgb">Digibyte</option>
      <option value="btx">Bitcore</option>
      <option value="blk">Blackcoin</option>
      <option value="dash">DASH</option>
      <option value="ppc">Peercoin</option>
      <option value="xpm">Primecoin</option>
      <option value="pot">Potcoin</option>
    </select>
  </div>
  <br>
  <?php 
if ($base_currency == 'btc') {
    $withdraw_status_l = '<a class="ui green label">Bitcoin</a>';
  } elseif ($base_currency == 'eth') {
    $withdraw_status_l = '<a class="ui green label">Ethereum</a>';
  }  elseif ($base_currency == 'xmr') {
    $withdraw_status_l = '<a class="ui green label">Monero</a>';
  }  elseif ($base_currency == 'ltc') {
    $withdraw_status_l = '<a class="ui green label">Litecoin</a>';
  }  elseif ($base_currency == 'doge') {
    $withdraw_status_l = '<a class="ui green label">Dogecoin</a>';
  }  elseif ($base_currency == 'bch') {
    $withdraw_status_l = '<a class="ui green label">Bitcoin Cash</a>';
  }  elseif ($base_currency == 'zec') {
    $withdraw_status_l = '<a class="ui green label">Zcash</a>';
  }  elseif ($base_currency == 'dgb') {
    $withdraw_status_l = '<a class="ui green label">Digibyte</a>';
  }  elseif ($base_currency == 'btx') {
    $withdraw_status_l = '<a class="ui green label">Bitcore</a>';
  }  elseif ($base_currency == 'blk') {
    $withdraw_status_l = '<a class="ui green label">Blackcoin</a>';
  }  elseif ($base_currency == 'dash') {
    $withdraw_status_l = '<a class="ui green label">DASH</a>';
  }  elseif ($base_currency == 'ppc') {
    $withdraw_status_l = '<a class="ui green label">Peercoin</a>';
  }  elseif ($base_currency == 'xpm') {
    $withdraw_status_l = '<a class="ui green label">Primecoin</a>';
  }  elseif ($base_currency == 'pot') {
    $withdraw_status_l = '<a class="ui green label">Potcoin</a>';
  } else {
    $withdraw_status_l = 'Undefined';
  }
echo "Current Supported Currency Is : $withdraw_status_l ";
  ?>
<br>
<br>
<br>
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
 <h5>Contact Email :</h5>
<br>
<div class="ui large left icon input">
  <input placeholder="Contact Email" name="contact_email" value="<?php echo $contact_email; ?>" type="text">
  <i class="envelope blue icon"></i>
</div>
<br>
<br>
 <h5>Script Version :</h5>
 <br>
<div class="ui large left icon input">
  <input placeholder="Script Version" value="<?php echo $script_version; ?>" type="text" >
  <i class="i cursor blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Linkedin Page (link) :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Linkedin Link" name="contact_linkedin" value="<?php echo $contact_linkedin; ?>" type="text">
  <i class="linkedin blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Referal Percentage :</h5>
  <br>
<div class="ui large left icon input">
  <input placeholder="Referal Percentage" name="referal_percentage" value="<?php echo $referal_percentage; ?>" type="text">
  <i class="percent blue icon"></i>
</div>
<br>
<br>
 <br> 
  <h5>Withdrawal Referal Page Status :</h5>
  <br>
  <div class="field">
    <select name="withdraw_status_r">
      <option value="<?php echo $withdraw_status_r; ?>" selected="selected"></option>
      <option value="0">Active</option>
      <option value="1">Disabled</option>
    </select>
  </div>
  <br>
  <?php 
if ($withdraw_status_r == '1') {
    $withdraw_status_ri = '<a class="ui red label">Disabled</a>';
  } else {
    $withdraw_status_ri = '<a class="ui green label">Active</a>';
  }  
echo "Current Status is : $withdraw_status_ri ";
  ?>
<br>
<br>
<br>
</center> 
</div>
<button name="save" class="fluid green ui button">Save Settings</button>
</form>
</body>