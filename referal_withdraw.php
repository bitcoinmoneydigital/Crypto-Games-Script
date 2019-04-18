<?php

//Showing all errors
error_reporting(E_ALL);

//Head of the script
require_once("libs/solvemedia.php");
require_once("libs/brain.php");
require_once ("libs/vb.php");
require_once 'db/config.php';
require_once("libs/ads.php");

//Starting the login Session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
  header("location: index");
  exit;
}

//Anti adblock script
require_once 'libs/anti_adblock.php';


//Variabling the Session
$useraddress = $_SESSION['address'];

//Get user id
$id1 = getUserid($useraddress);
//Get User Ip
$userip = getUserIP();
//Create a random Id
$randomid = RandomId();
//Get user Balance
$balance = GetUserReferalBalance($id1);
//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);
//Check Balance In Faucethub
$faucethub_balance = FaucethubBalance($base_currency_u);

//Leaving variables null so they do not show errors
$captcha_err = $withdraw_stauts_err = $unsupportedfhcurrency = $paidfh = $no_funds_faucethub = $empty_withdrawalamount = $user_balance_err = $min_w_error = $nrformat_error = '';


// Processing form data when form is submitted
if(isset($_POST["claimfh"])){
    $solvemedia_response = solvemedia_check_answer($solvemedia_priv_api,
              $_SERVER["REMOTE_ADDR"],
              $_POST["adcopy_challenge"],
              $_POST["adcopy_response"],
              $solvemedia_hash_api);
    if (!$solvemedia_response->is_valid) {
      $captcha_err = '<div class="ui negative message"><div class="header">Failed to verify captcha.</div></div>';
    }  else {

//Check Withdrawal Status
if ($withdraw_status_r == '1') {
        $withdraw_stauts_err = '<div class="ui negative message"><div class="header">Withdrawal process is disabled from Admin.</div></div>';
      }      

//Verifying Withdrawal Amount
if (empty($_POST["withdraw_amount"])) {
  $empty_withdrawalamount = '<div class="ui negative message"><div class="header">You need to enter Withdrawal Amount.</div></div>';
} elseif (!ctype_digit($_POST["withdraw_amount"])) {
  $nrformat_error = '<div class="ui negative message"><div class="header">Invalid input , please enter only numbers.</div></div>';
}  else {
  $withdraw_amount = htmlspecialchars(stripslashes($_POST["withdraw_amount"]));
  $withdraw_amount = floor($withdraw_amount);

if ($withdraw_amount < $min_withdraw_amount_r) {
  $min_w_error = '<div class="ui negative message"><div class="header">Minimum amount to Withdraw is '.number_decimal($min_withdraw_amount_r).' '.$base_currency_u.' .</div></div>';
} elseif ($withdraw_amount > $balance) {
  $user_balance_err = '<div class="ui negative message"><div class="header">You dont have enough funds.</div></div>';
} elseif ($faucethub_balance == 'no') {
  $unsupportedfhcurrency = '<div class="ui negative message"><div class="header">Sorry Faucethub does not support '.$base_currency.'.</div></div>';
} elseif ($withdraw_amount > $faucethub_balance) {
  $no_funds_faucethub = '<div class="ui negative message"><div class="header">Sorry we do not have enough funds in Faucethub to proceed this transaction.</div></div>';
}  
}
//Verifying Errors And Completing Withdrawal
if (empty($empty_withdrawalamount) && empty($nrformat_error) && empty($min_w_error) && empty($user_balance_err) && empty($no_funds_faucethub) && empty($unsupportedfhcurrency) && empty($withdraw_stauts_err)) {
//Define needed variables
$amount = $withdraw_amount;
$type = 'Faucethub Withdrawal';
$status = 'Paid';
//Get Withdrawed amount ref percentage
$percentInDecimal = $referal_percentage / 100;
$refamount = $percentInDecimal * $amount;

//Functions To Pay User, Reduce User Balance , Add Transaction to database , And provide admin panel with stats
$payuserfh = PayUserFH($useraddress,$amount,$base_currency_u,$userip);
$reduceuserbalance = ReduceUserReferalBalance($useraddress, $amount);
$addtransaction = AddWithdrawTransactionToDB($useraddress, $amount, $type, $status);
$addwithdrawedamounttostats = WithdrawedAmountPaid($useraddress, $amount);
$userreferal = GetUserReferal($useraddress);
$updaterefearnings = UpdateUserRefBalance($userreferal, $refamount);

//Check if all functions worked otherwise throw an error
if (($payuserfh == 'ok') && ($reduceuserbalance == 'ok') && ($addtransaction == 'ok') && ($addwithdrawedamounttostats == 'ok') && ($updaterefearnings == 'ok')) {
  $paidfh = '<div class="ui positive message"><div class="header">You got paid  '.number_decimal($amount).' '.$base_currency_u.' via Faucethub.</div></div>';
} else {
  echo 'Internal Error';
}
  
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
      <li class="nav-item active">
        <a class="nav-link" href="referal_withdraw"><i class="exchange icon"></i>Withdraw Referal Balance</a>
      </li>      
       <li class="nav-item">
        <a class="nav-link" href="affiliate"><i class="users icon"></i>Affiliate</a>
      </li>     
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="gamepad loading icon"></i> Games
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="faucet"><i class="gift icon"></i>Faucet</a>
          <a class="dropdown-item" href="roll"><i class="trophy icon"></i>Roll Game</a>
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
    <div class="col-sm">
<h2 style="color: purple;">Withdraw Your Earnings From Referal Balance</h2>
      <br>
      <!-- This Message Have Balance Of User -->
<div class="ui olive icon message">
  <i class="gift circle loading icon"></i>
  <div class="content">
    <div class="header">
      You have a balance of <b><?php echo number_decimal($balance);?> <?php echo $base_currency_u; ?></b>
    </div>
  </div>
</div>
<!-- errors -->
<?php echo $captcha_err; 
echo $empty_withdrawalamount;
echo $user_balance_err;
echo $min_w_error;
echo $nrformat_error;
echo $no_funds_faucethub;
echo $paidfh;
echo $unsupportedfhcurrency;
echo $withdraw_stauts_err;
?> 
<!-- ads -->  
<center><?php echo AdsFormat3(); ?></center>  
<br>
<!-- Form To Complete in case of withdrawal -->
     <form action="" method="post">
<h5>Amount You Want To Withdraw :</h5>
<p>Minimum Withdrawal Amount is : <a class="ui violet label"<b><?php echo number_decimal($min_withdraw_amount_r); ?> <?php echo $base_currency_u; ?></b></a></p>
<br>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="25" width="25" src="img/<?php echo $base_currency; ?>.png"></span>
  </div>
  <input type="text" name="withdraw_amount" placeholder="Withdrawal Amount" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div> 
<!-- captcha -->     
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<br>
<center>
  <p>You will recieve funds in this address : <a class="ui orange label"><b><?php echo $useraddress; ?></b></a></p>
  <br>
  <!-- ads -->
  <center><?php echo AdsFormat4(); ?></center>
  <br>
  <!-- Button -->
<button type="submit" name="claimfh" class="fluid violet ui button">Withdraw Via Faucethub</button>
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