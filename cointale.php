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

//Get User Balance
$userbalance = GetUserBalance($id1);

//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);

//Leaving variables null so they do not show errors
$captcha_err = $user_balance_err = $min_c_error = $empty_choice = $nr_error = $you_won = $you_lost = $empty_betamount = '';

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

//Verifying Choice of User
if (empty($_POST["choice"])) {
        $empty_choice = '<div class="ui negative message"><div class="header">You need to choose.</div></div>';
      } else {      
$choice = htmlspecialchars(stripslashes($_POST["choice"]));
}
//Verifying Bet Amount
if (empty($_POST["bet_amount"])) {
  $empty_betamount = '<div class="ui negative message"><div class="header">You need to enter Bet Amount.</div></div>';
} elseif (!ctype_digit($_POST["bet_amount"])) {
  $nr_error = '<div class="ui negative message"><div class="header">Invalid input , please enter only numbers.</div></div>';
} else {
  $bet_amount = htmlspecialchars(stripslashes($_POST["bet_amount"]));
  $bet_amount = floor($bet_amount);

if ($bet_amount < $min_amount_cointale) {
  $min_c_error = '<div class="ui negative message"><div class="header">Minimum amount to play Cointail is '.number_decimal($min_amount_cointale).' '.$base_currency_u.' .</div></div>';
} elseif ($bet_amount > $userbalance) {
  $user_balance_err = '<div class="ui negative message"><div class="header">You dont have enough funds.</div></div>';
}  
}


//Verifying errors
if (empty($empty_betamount) && empty($empty_choice) && empty($nr_error) && empty($min_c_error) && empty($user_balance_err)) {
//Creating random number between 1 and 2
$randomized_nrr = (rand(1,2));
//Check if user won or lost
if ($choice == $randomized_nrr) {
//Get 50% of BET
$amount = $bet_amount / 2 ;
//Remove decimals from number
$amount = floor($amount);
//Type of transaction
$type = 'CoinTail';
//Staus of Transaction
$status = 'Won';
//Update User Balance
$pay = UpdateUserBalance($useraddress, $amount);
//Add Transaction in Database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);

//Verify Update User Balance and Transaction
if (($pay == 'ok') && ($add_db == 'ok')) {
  $you_won = '<div class="ui positive message"><div class="header">You won '.number_decimal($amount).' '.$base_currency_u.'.</div></div>';
} else {
  echo "Undefined Error";
}

} else {
//Type of Transaction
$type = 'Cointail';
//Status of Transaction
$status = 'Lost';
//Amount Lost
$amount = $bet_amount;
//Reduce user balance
$reduce = ReduceUserBalance($useraddress,$amount);
//Add the transaction in database
$add_db = AddTransactionToDB($useraddress, $amount, $type, $status);

//Check if User balance was reduced and added to database otherwise throw an error
if (($reduce == 'ok') && ($add_db == 'ok')){
  $you_lost = '<div class="ui negative message"><div class="header">You lost '.number_decimal($amount).' '.$base_currency_u.' from this session.</div></div>';
} else {
  echo "Undefined error";
}
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
          <a class="dropdown-item" href="roll"><i class="trophy icon"></i>Roll Game</a>
          <a class="dropdown-item active" href="cointale"><i class="rocket icon"></i>CoinTale</a>
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
<!-- Errors -->     
     <?php 
echo $captcha_err;
echo $empty_choice;
echo $you_won;
echo $you_lost;
echo $empty_betamount;
echo $nr_error;
echo $min_c_error;
echo $user_balance_err;
     ?>

<h3>CoinTail</h3>
<p>Earn <b>50 %</b> of your bet.</p>
<!-- Get's User Balance -->
<p>You have : <a class="ui purple label"><?php echo number_decimal($userbalance); ?> <?php echo $base_currency_u; ?></a></p>
<br>
<!-- ads -->
<center><?php echo AdsFormat3(); ?></center>
<br>
<!-- Images for Euro and Usd -->
<img height="150" width="150" alt="Euro" src="img/eur.png">
<img height="150" width="150" alt="Usd" src="img/usd.png">
<br>
<!-- Selection options -->
<form action="" method="post">
  <h3>Select EUR or USD : </h3>
<br>    
     <form action="" method="post">

<div class="custom-control custom-radio custom-control-inline">
  <input type="radio" value="1" id="customRadioInline1" name="choice" class="custom-control-input">
  <label class="custom-control-label" for="customRadioInline1">Eur</label>
</div>
<div class="custom-control custom-radio custom-control-inline">
  <input type="radio" value="2" id="customRadioInline2" name="choice" class="custom-control-input">
  <label class="custom-control-label" for="customRadioInline2">Usd</label>
</div>
<br>
<br>
<br>
<!-- Bet Amount Input -->
<h5>Bet Amount : </h5>
<p>Minimum is <b><?php echo number_decimal($min_amount_cointale); ?> <?php echo $base_currency_u; ?>.</b></p>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="25" width="25" src="img/<?php echo $base_currency; ?>.png"></span>
  </div>
  <input type="text" name="bet_amount" placeholder="Bet Amount" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div> 
<br> 
<!-- Captcha -->    
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<br>
<!-- ads -->
<center><?php echo AdsFormat4(); ?></center>
<br>
<center>
  <!-- Button -->
<button type="submit" name="claim" class="fluid violet ui button">Flip</button>
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