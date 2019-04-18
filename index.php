<?php

error_reporting(E_ALL);

require_once("libs/solvemedia.php");
require_once("libs/brain.php");
require_once("libs/vb.php");
require_once("libs/ads.php");
require_once 'db/config.php';

//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);
//Check how much website paid
$PaidAmountToUsers = PaidAmountToUsers();
//Get Total Amount Of Users
$totalamountofusers = LastUserId();
//Get Total Amount Of User Intern Earnings
$GetTotalAmountOfInternEarnings = GetTotalAmountOfInternEarnings();

//Get referal settings
$referaal = $_GET['r'] ?? 'kscoins';
$referalpost = $_POST['referal'] ?? 'kscoins';

//Get User ip
$userip = getUserIP();
//Create random number
$uniqueid = RandomId();

//Null variables
$address_err = $multiple_ip_error = $reftrick = $referror = $ip_error = $addr_verify_err = $nastyhosts_err = $password_err = $captcha_err = "";

$address = $password = "";


// Processing form data when form is submitted
if(isset($_POST["register"])){

    $solvemedia_response = solvemedia_check_answer($solvemedia_priv_api,
              $_SERVER["REMOTE_ADDR"],
              $_POST["adcopy_challenge"],
              $_POST["adcopy_response"],
              $solvemedia_hash_api);
    if (!$solvemedia_response->is_valid) {
      $captcha_err = '<div class="ui negative message"><div class="header">Failed to verify captcha.</div></div>';
    }  else {

    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = '<div class="ui negative message"><div class="header">Please enter a address.</div></div>';
    } else{
     
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_address);
            
            // Set parameters
            $param_address = trim($_POST["address"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $address_err = '<div class="ui negative message"><div class="header">This address is already taken.</div></div>';
                } else{
                    $address = trim($_POST["address"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = '<div class="ui negative message"><div class="header">Please enter a password.</div></div>';     
    } elseif(strlen(trim($_POST['password'])) < 8){
        $password_err = '<div class="ui negative message"><div class="header">Password must have atleast 8 characters.</div></div>';  
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = '<div class="ui negative message"><div class="header">Please confirm password.</div></div>';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = '<div class="ui negative message"><div class="header">Password did not match.</div></div>';
        }
    }
//Dont allow to referal self    
    if ($referalpost == $address){
        $reftrick = '<div class="ui negative message"><div class="header">You can not referal yourself.</div></div>';
    }

//Check if given address in referal exists
$sql = $link->query("SELECT username FROM users WHERE username = '$referalpost'");
if ($sql->num_rows == 0) {
     $referror = '<div class="ui negative message"><div class="header">Sorry but the referal you requested does not exist.</div></div>';
}
//Check if this IP can register
$ip_verify = iphub();
if ($ip_verify == 'bad') {
  $ip_error = '<div class="ui negative message"><div class="header">Sorry but your IP is listed as bad IP at <b>IPHUB</b> so you can not register.</div></div>';
}
//Check if ip is a proxy via NastyHosts
$nastyhosts_verify = CheckNastyHosts();
if ($nastyhosts_verify == 'bad') {
  $nastyhosts_err = '<div class="ui negative message"><div class="header">Sorry but your IP is listed as proxy,VPN,VPS at <b>Nastyhosts</b> so you can not register.</div></div>';
}
//Check if user is trying to create multiple account (based in IP)
$sql = $link->query("SELECT ip FROM users WHERE ip = '$userip'");
if ($sql->num_rows == 1) {
     $multiple_ip_error = '<div class="ui negative message"><div class="header">You can not create multiple accounts.</div></div>';
}
$address_verify = CheckAddFh($address,$base_currency_u);
if ($address_verify == 'no') {
  $addr_verify_err = '<div class="ui negative message"><div class="header">This address is not listed to <b>Faucethub</b> or this address is not an '.$base_currency_u.' Address.</div></div>';
} 
    else {
    // Check input errors before inserting in database
    if(empty($address_err) && empty($ip_error) && empty($referror) && empty($reftrick) && empty($password_err) && empty($addr_verify_err) && empty($confirm_password_err) && empty($multiple_ip_error) && empty($nastyhosts_err)){

              // E shtin transaksionin ne databaz


$sql = "UPDATE users SET `refnumb`=(`refnumb`+1) where username = '$referalpost'";
if ($link->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
}

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, referal, ip, password, pubid) VALUES (?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_address, $param_referal, $param_userip ,$param_password, $param_pubidd);
            
            // Set parameters
            $param_address = $address;
            $param_referal = $referalpost;
            $param_userip = $userip;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_pubidd = $uniqueid;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))



            {
                // Redirect to login page
                header("location: login");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
}
}
                // Close connection
    mysqli_close($link);

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
      <li class="nav-item active">
        <a class="nav-link" href="index"><i class="home icon"></i>Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login"><i class="sign-in icon"></i>Login</a>
      </li>   
      <li class="nav-item">
        <a class="nav-link" href="index"><i class="user plus icon"></i>Register</a>
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
<!-- 2 Columns -->
<br>
<br>
<br>
<center>  
<div style="background-color: #e5d0ff;" class="ui two column doubling stackable grid container">
<!-- Column 1 -->   
  <div class="column">
<h1 style="font-family:Helvetica; color: #310468;">You are one step away of starting earning <?php echo $base_currency_u; ?> without any investment</h1>
<br>
<br>
<!-- Total Amount Paid To Users -->
<div class="ui violet small horizontal statistic">
  <div class="value">
   <i class="circular money bill alternate violet icon"></i> <?php echo number_decimal($PaidAmountToUsers); ?> <?php echo $base_currency_u; ?>
  </div>
  <div class="label">
    PAID
  </div>
</div>
<br>
<!-- Total Amount Of Internal Earnings -->
<div class="ui violet small horizontal statistic">
  <div class="value">
   <i class="circular money bill alternate violet icon"></i> <?php echo number_decimal($GetTotalAmountOfInternEarnings); ?> <?php echo $base_currency_u; ?>
  </div>
  <div class="label">
    Total User Earnings
  </div>
</div>
<br>
<!-- Total Amount Of Registred Users -->
<div class="ui violet small horizontal statistic">
  <div class="value">
   <i class="circular users violet icon"></i> <?php echo $totalamountofusers; ?>
  </div>
  <div class="label">
    Registred Users
  </div>
</div>
<br>
<br>
<!-- ads -->
<?php echo AdsFormat4(); ?>
<br>    
  </div>
<!-- Column 2 -->  
  <div style="background-color: #f0e3ff;" class="column">
<h1 style="font-family:Helvetica; color: #310468;">Register</h1>
<br>
<!-- errors -->
<?php
echo $address_err;
echo $password_err;
echo $captcha_err;
echo $reftrick;
echo $referror;
echo $ip_error;
echo $nastyhosts_err;
echo $addr_verify_err;
echo $multiple_ip_error;

?>
<br><p style="color: grey;">NOTE: <?php echo $base_currency_u; ?> Address should be linked with Faucethub.</p>
<br> 
<!-- Form For Register -->   
<form action="" method="post">
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="20" width="25" src="img/<?php echo $base_currency; ?>.png"></span>
  </div>
  <input type="text" name="address" placeholder="Your <?php echo $base_currency_u; ?> Address" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="20" width="25" src="img/pass.png"></span>
  </div>
  <input type="password" name="password" placeholder="Your Password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="20" width="25" src="img/pass.png"></span>
  </div>
  <input type="password" name="confirm_password" placeholder="Confirm Your Password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="20" width="35" src="img/ref_icon.png"></span>
  </div>
  <input type="text" name="referal" value="<?php echo $referaal; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" readonly="">
</div>
<!-- captcha -->
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<br>
<center>
  <!-- Button -->
<button type="submit" name="register" class="fluid violet ui button">Create Account</button>
<h4>Do you have account ? <b><a target="_BLANK" href="login">Click here to Login</a></b></h4>
</form>
  </div>
</div>
</center>
<br>
<br>
<hr>
<!-- Features Of Website -->
<center><b><h1 style="color: #55258d;">FEATURES : </h1></b></center>
<br>
<br>
<!-- 4 Columns --> 
<div class="ui center aligned four column doubling stackable grid container">
  <!-- 1 Columns --> 
  <div class="column">
<i class="circular inverted huge lock violet icon"></i><h3>Secure Payments</h3><hr>
<p>We are using automatic payment system , you will get paid whenever you want without any fee via <img alt="Faucethub" height="25" width="75" src="img/fhlogo.png"></p>
  </div>
  <!-- 2 Columns --> 
  <div class="column">
<i class="circular inverted huge users violet icon"></i><h3>Referral Program</h3><hr>
<p>We offer to our users enhanced statistics for their referals and different ad codes to implement in their sites , forums & social networks.Our Referral commission is <b><?php echo $referal_percentage; ?>%</b>. </p>
  </div>
  <!-- 3 Columns --> 
  <div class="column">
<i class="circular inverted huge shield alternate violet icon"></i><h3>Advanced Security</h3><hr>
<p>Your security is our privilege , so please feel safe we are here to protect your informations and your account. </p>
  </div>
  <!-- 4 Columns --> 
  <div class="column">
<i class="circular inverted huge mobile alternate violet icon"></i><h3>Mobile Friendly</h3><hr>
<p>Our design is compatible with all type of mobile devices.You can check your stats , claim from our faucet, play different games (cointale,roll game,LuckyNumber Game) etc.</p>
  </div>
</div>
<br>
<!-- 2 -->
<!-- 4 Columns --> 
<div class="ui center aligned four column doubling stackable grid container">
  <!-- 1 Columns --> 
  <div class="column">
<i class="circular inverted huge life ring violet icon"></i><h3>24/7 Support</h3><hr>
<p>Whenever you want help we are here for you , be sure to contact us via email for everything you need. </p>
  </div>
  <!-- 2 Columns --> 
  <div class="column">
<i class="circular inverted huge gem violet icon"></i><h3>Lucky Number Game</h3>
  </div>
  <!-- 3 Columns --> 
  <div class="column">
<i class="circular inverted huge trophy violet icon"></i><h3>Roll Game</h3>
  </div>
  <!-- 4 Columns --> 
  <div class="column">
<i class="circular inverted huge rocket violet icon"></i><h3>CoinTale Game</h3>
  </div>
</div>
<!-- 3 -->
<!-- 4 Columns --> 
<div class="ui center aligned four column doubling stackable grid container">
  <!-- 1 Columns --> 
  <div class="column">
<i class="circular inverted huge gift violet icon"></i><h3>Faucet</h3>    
  </div>
  <!-- 2 Columns --> 
  <div class="column">
  </div>
  <!-- 3 Columns --> 
  <div class="column">
  </div>
  <!-- 4 Columns --> 
  <div class="column">
  </div>
</div>
<!-- Footer -->
<br>
<br>
<br>
<!-- ads -->
<center><?php echo AdsFormat2(); ?></center>
<br>
<hr>
<!-- Footer -->
<div style="background-color: #491771;">
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
?>
<!-- Anti AdBlock Code -->
<?php
require_once 'libs/anti_adblock.php'; 
?>
</body>