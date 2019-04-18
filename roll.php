<?php

//Showing all errors
error_reporting(E_ALL);

//Head of the script
require_once("libs/solvemedia.php");
require_once("libs/brain.php");
require_once("libs/vb.php");
require_once 'db/config.php';
require_once ("libs/ads.php");

//Starting the login Session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
  header("location: index");
  exit;
}

//Variabling the Session
$useraddress = $_SESSION['address'];

//Get user id
$id1 = getUserid($useraddress);

//Get the real time now
$time = getTime();

//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);


//Leaving variables null so they do not show errors
$yes = $lucky_number  = $auth = $randomized_nr = $message  = $verify_invalid = $success_earning = $stswrong = $verify_done = $verify_auth = $shortenedurl = $okclaim = $shortener_error = $shortthislink  = $captcha_err = $wait = $need = "";

//Check if the user can claim
$checkaddressRoll = checkaddressRoll($useraddress);

// Processing form data when form is submitted
if(isset($_POST["claim"])){
    $solvemedia_response = solvemedia_check_answer($solvemedia_priv_api,
              $_SERVER["REMOTE_ADDR"],
              $_POST["adcopy_challenge"],
              $_POST["adcopy_response"],
              $solvemedia_hash_api);
    if (!$solvemedia_response->is_valid) {
      $captcha_err = '<div class="ui negative message"><div class="header">Failed to verify captcha.</div></div>';
    }  else {

 if ($checkaddressRoll == "ok") {

//Creating a random number from 1 to 10000
$randomized_nr = RandomNumberRoll();

if ($randomized_nr >= 1 && $randomized_nr <= 9885) {

//Type of transaction
$type = 'Roll';
//Staus of Transaction
$status = 'Won';
//Variabling prize1
$amount = $prize6;
$amount = floor($amount);
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);
//Add claim time in database so user can not claim until timer is down
$updatelactclaim_roll = UpdateLastClaimRoll($id1, $time);

$lucky_number = '<div class="ui violet statistic">
  <div class="label">
    Lucky Number is :
  </div>
  <div class="value">
    '.$randomized_nr.'
  </div>
</div>';

//Verifying Process
if (($pay == 'ok') && ($add_db == 'ok') && ($updatelactclaim_roll == 'ok')) {
  
  $message = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Internal Error";
}

}
if ($randomized_nr >= 9886 && $randomized_nr <= 9985) {
//Type of transaction
$type = 'Roll';
//Staus of Transaction
$status = 'Won';
//Variabling prize1
$amount = $prize5;
$amount = floor($amount);
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);
//Add claim time in database so user can not claim until timer is down
$updatelactclaim_roll = UpdateLastClaimRoll($id1, $time);

$lucky_number = '<div class="ui violet statistic">
  <div class="label">
    Lucky Number is :
  </div>
  <div class="value">
    '.$randomized_nr.'
  </div>
</div>';

//Verifying Process
if (($pay == 'ok') && ($add_db == 'ok') && ($updatelactclaim_roll == 'ok')) {
  
  $message = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Internal Error";
}

}
if ($randomized_nr >= 9986 && $randomized_nr <= 9993) {
  //Type of transaction
$type = 'Roll';
//Staus of Transaction
$status = 'Won';
//Variabling prize1
$amount = $prize4;
$amount = floor($amount);
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);
//Add claim time in database so user can not claim until timer is down
$updatelactclaim_roll = UpdateLastClaimRoll($id1, $time);

$lucky_number = '<div class="ui violet statistic">
  <div class="label">
    Lucky Number is :
  </div>
  <div class="value">
    '.$randomized_nr.'
  </div>
</div>';

//Verifying Process
if (($pay == 'ok') && ($add_db == 'ok') && ($updatelactclaim_roll == 'ok')) {
  
  $message = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Internal Error";
}

}
if ($randomized_nr >= 9994 && $randomized_nr <= 9997) {
  //Type of transaction
$type = 'Roll';
//Staus of Transaction
$status = 'Won';
//Variabling prize1
$amount = $prize3;
$amount = floor($amount);
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);
//Add claim time in database so user can not claim until timer is down
$updatelactclaim_roll = UpdateLastClaimRoll($id1, $time);

$lucky_number = '<div class="ui violet statistic">
  <div class="label">
    Lucky Number is :
  </div>
  <div class="value">
    '.$randomized_nr.'
  </div>
</div>';

//Verifying Process
if (($pay == 'ok') && ($add_db == 'ok') && ($updatelactclaim_roll == 'ok')) {
  
  $message = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Internal Error";
}

}
if ($randomized_nr >= 9998 && $randomized_nr <= 9999) {
  //Type of transaction
$type = 'Roll';
//Staus of Transaction
$status = 'Won';
//Variabling prize1
$amount = $prize2;
$amount = floor($amount);
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);
//Add claim time in database so user can not claim until timer is down
$updatelactclaim_roll = UpdateLastClaimRoll($id1, $time);

$lucky_number = '<div class="ui violet statistic">
  <div class="label">
    Lucky Number is :
  </div>
  <div class="value">
    '.$randomized_nr.'
  </div>
</div>';

//Verifying Process
if (($pay == 'ok') && ($add_db == 'ok') && ($updatelactclaim_roll == 'ok')) {
  
  $message = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Internal Error";
}

}
if ($randomized_nr == 10000) {
  //Type of transaction
$type = 'Roll';
//Staus of Transaction
$status = 'Won';
//Variabling prize1
$amount = $prize1;
$amount = floor($amount);
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);
//Add claim time in database so user can not claim until timer is down
$updatelactclaim_roll = UpdateLastClaimRoll($id1, $time);

$lucky_number = '<div class="ui violet statistic">
  <div class="label">
    Lucky Number is :
  </div>
  <div class="value">
    '.$randomized_nr.'
  </div>
</div>';

//Verifying Process
if (($pay == 'ok') && ($add_db == 'ok') && ($updatelactclaim_roll == 'ok')) {
  
  $message = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Internal Error";
}

}

} else {
  //Throw Wait Time If User Already Got Reward
  $checkaddressRoll = gmdate("H:i:s", $checkaddressRoll);
  $need = "<div class='ui violet icon message'>
  <i class='notched circle loading icon'></i>
  <div class='header'>
    <div class='header'>
      Please Wait
    </div>
    <p>You need to wait <b>$checkaddressRoll</b> minutes.</p>
  </div>
</div>";
}     

      }
    }

   

?>
<head>
  <!-- Website informations -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $web_title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo $web_description; ?>" />
  <meta name="keywords" content="<?php echo $web_keywords; ?>" />
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
<!-- Google Analystics Code -->
<?php echo $google_analystics; ?>    
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar navbar-dark" style="background-color: #5d1e8f;">
  <a class="navbar-brand" href="#"><img height="70" width="270" src="img/logo.png"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard"><i class="home icon"></i>Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="withdraw"><i class="exchange icon"></i>Withdraw Balance</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="referal_withdraw"><i class="exchange icon"></i>Withdraw Referal Balance</a>
      </li>      
       <li class="nav-item">
        <a class="nav-link" href="affiliate"><i class="users icon"></i>Affiliate</a>
      </li>     
 <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="gamepad loading icon"></i> Games
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="faucet"><i class="gift icon"></i>Faucet</a>
          <a class="dropdown-item active" href="roll"><i class="trophy icon"></i>Roll Game</a>
          <a class="dropdown-item" href="cointale"><i class="rocket icon"></i>CoinTale</a>
          <a class="dropdown-item" href="lucky_number"><i class="gem icon"></i>Lucky Number</a>
        </div>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="logout"><i class="sign-out icon"></i>Log out</a>
      </li>       
    </ul>
    <span class="navbar-text">
      <a target="_BLANK" href="<?php echo $contact_facebook; ?>"><button class="ui circular facebook icon button">
  <i class="facebook icon"></i>
</button></a>
<a target="_BLANK" href="<?php echo $contact_twitter; ?>"><button class="ui circular twitter icon button">
  <i class="twitter icon"></i>
</button></a>
<a target="_BLANK" href="<?php echo $contact_linkedin; ?>"><button class="ui circular linkedin icon button">
  <i class="linkedin icon"></i>
</button></a>
<a target="_BLANK" href="<?php echo $contact_googleplus; ?>"><button class="ui circular google plus icon button">
  <i class="google plus icon"></i>
</button></a>
    </span>
  </div>
</nav>
<!-- ads -->	
<br>
<center><?php echo AdsFormat2(); ?></center>
<br>
<br>
<center>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <!-- ads -->
      <center><?php echo AdsFormat1(); ?></center>
    </div>
    <!-- This Message Tell How To Play This Game -->
    <div class="col-sm">
<h2 style="color: purple;">ROLL GAME</h2>
<div class="ui info message">
  <ul class="list">
    <p>Please fill the captcha below and press the Roll button to receive your free <?php echo $base_currency_u; ?>. The amount of <?php echo $base_currency_u; ?> you win is depends upon the number you roll, and its paid according to its corresponding position in the payout table at bottom.</p>
  </ul>
</div>
<br>
<!-- ads -->
<center><?php echo AdsFormat3(); ?></center>
<br>
<!-- errors -->
     <?php 
echo $need;
echo $okclaim;
echo $stswrong;
echo $success_earning;
echo $verify_invalid;
echo $lucky_number;
echo $message;
     ?>
     <!-- This Message Have Information About Timer Of This Game -->
<div class="ui icon purple message">
  <i class="gift icon"></i>
  <div class="content">
    <div class="header">
      ROLL TIME
    </div>
    <p>You Can Roll Every <b><?php echo gmdate("H:i:s", $roll_timer); ?> minutes</b>.</p>
  </div>
</div>     
     <br>
     <!-- Table with lucky numbers and gift amount -->
<table class="ui striped table purple">
  <thead>
    <tr>
      <th></th>
      <th>LUCKY NUMBER</th>
      <th>PAYOUT AMOUNT</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><i class="yellow big trophy circle loading icon"></i></td>
      <td>10000</td>
      <td><?php echo number_decimal($prize1); ?> <?php echo $base_currency_u; ?></td>
    </tr>
    <tr>
      <td><i class="orange big trophy circle loading icon"></i></td>
      <td>9998 - 9999</td>
      <td><?php echo number_decimal($prize2); ?> <?php echo $base_currency_u; ?></td>
    </tr>
    <tr>
      <td><i class="grey big trophy circle loading icon"></i></td>
      <td>9994 - 9997</td>
      <td><?php echo number_decimal($prize3); ?> <?php echo $base_currency_u; ?></td>
    </tr> 
    <tr>
      <td><i class="brown big trophy icon"></i></td>
      <td>9986 - 9993</td>
      <td><?php echo number_decimal($prize4); ?> <?php echo $base_currency_u; ?></td>
    </tr>
    <tr>
      <td><i class="brown big trophy icon"></i></td>
      <td>9886 - 9985 </td>
      <td><?php echo number_decimal($prize5); ?> <?php echo $base_currency_u; ?></td>
    </tr>
    <tr>
      <td><i class="brown big trophy icon"></i></td>
      <td>0 - 9885</td>
      <td><?php echo number_decimal($prize6); ?> <?php echo $base_currency_u; ?></td>
    </tr>                 
  </tbody>
</table>
<!-- ads -->
<center><?php echo AdsFormat3(); ?></center>
<br>
<!-- captcha -->
<?php echo $captcha_err; ?>     
     <form action="" method="post">
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<!-- ads -->
<center><?php echo AdsFormat4(); ?></center>
<br>
<center>
  <!-- Button -->
<button type="submit" name="claim" class="fluid violet ui button">Roll</button>
</form>
</center>
    </div>
    <div class="col-sm">
      <!-- ads -->
      <center><?php echo AdsFormat1(); ?></center>
    </div>
  </div>
</div>
</center>
<br>
<hr>
<!-- Footer -->
<div style="background-color: #491771  ;">
  <br>
<br>
<center>
<div class="ui four column doubling stackable grid container">
  <div class="column">
    <h4 style="color: white;">Services</h4>
    <div class="ui list">
  <a class="item">Faucet Game</a>
  <a class="item">Roll Game</a>
  <a class="item">Cointale Game</a>
  <a class="item">Mining Game</a>
  <a class="item">Lucky Number Game</a>
</div>
  </div>
  <div class="column">
    <h4 style="color: white;">Information</h4>
    <div class="ui list">
  <a class="item">Payment Options</a>
  <a class="item">Fee Schedule</a>
  <a class="item">Getting Started</a>
  </div> 
  </div>
  <div class="column">
    <h4 style="color: white;">About</h4>
    <div class="ui list">
  <a class="item">About Us</a>
  <a class="item">Legal & Security</a>
  <a class="item">Terms of Use</a>
  <a class="item">Refund Policy</a>
  </div>  
  </div>
  <div class="column">
    <h4 style="color: white;">Payments</h4>
<img height="50" width="160" src="img/fhlogo.png">
   <br>
   <br>
   <h4 style="color: white;">Contact Us</h4>
   <button class="ui circular facebook icon button">
  <i class="facebook icon"></i>
</button>
<button class="ui circular twitter icon button">
  <i class="twitter icon"></i>
</button>
<button class="ui circular linkedin icon button">
  <i class="linkedin icon"></i>
</button>
<button class="ui circular google plus icon button">
  <i class="google plus icon"></i>
</button>
<br>
<a class="item" ><i class="envelope outline blue big icon"></i><h5 style="color: white;"><?php echo $contact_email ?></h5></a>
<br>
<br>
<br>
  </div>
</div>
</div>
</center>
<!-- Footer 2 --> 
<div style="background-color:  #320e4f ;">
  <center><a target="_BLANK" href="https://bitcointalk.org/index.php?topic=5054734"><p style="color:  #85929e ;">Cryptocurrency Casino and Games script by: LenzScripts - 2018 - version <?php echo $script_version; ?></p></a></center>
</div>
<!-- Chat Code and Google Analystics Code -->
<?php 
//Chat Code
echo $tawk_chat; 
//Google Analystics Code
echo $google_analystics;
//Popads code
echo $popads;
?>
<!-- Anti AdBlock Code -->
<?php
require_once 'libs/anti_adblock.php'; 
?>
</body>