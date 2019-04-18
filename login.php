<?php

error_reporting(E_ALL);

require_once("libs/solvemedia.php");
require_once("libs/brain.php");
require_once("libs/vb.php");
require_once("libs/ads.php");
require_once 'db/config.php';

//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);

// Define variables and initialize with empty values
$address = $password = $ban_error = "";
$address_err = $captcha_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $solvemedia_response = solvemedia_check_answer($solvemedia_priv_api,
              $_SERVER["REMOTE_ADDR"],
              $_POST["adcopy_challenge"],
              $_POST["adcopy_response"],
              $solvemedia_hash_api);
    if (!$solvemedia_response->is_valid) {
      $captcha_err = '<div class="ui negative message">
  <div class="header">
   Failed to verify captcha.
  </div></div>';
    }  else {

  
    // Check if address is empty
    if(empty(trim($_POST["address"]))){
        $address_err = '<div class="ui negative message">
  <div class="header">
   Please enter your address.
  </div></div>';
    } else{
        $address = trim($_POST["address"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = '<div class="ui negative message">
  <div class="header">
   Please enter your password.
  </div></div>';
    } else{
        $password = trim($_POST['password']);
    }

    //Check if user is banned
$sql = $link->query("SELECT username FROM banned_users WHERE username = '$address'");
if ($sql->num_rows == 1) {
     $ban_error = '<div class="ui negative message"><div class="header">Your Account Is Banned.</div></div>';
}
    
    // Validate credentials
    if(empty($username_err) && empty($password_err) && empty($ban_error)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_address);
            
            // Set parameters
            $param_address = $address;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if address exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $address, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the address to the session */
                            session_start();
                            $_SESSION['address'] = $address;      
                            header("location: dashboard");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = '<div class="ui negative message">
  <div class="header">
   The password you entered was not valid.
  </div></div>';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $address_err = '<div class="ui negative message">
  <div class="header">
   No account found with that Address.
  </div></div>';
                }
            } else{
                echo "<font color='red' size='1.5'>Oops! Something went wrong. Please try again later.</font>";
            }
        }
                // Close statement
        mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
        }
        
}
}

?>
<head>
  <!-- Website informations -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Faucet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="faucet script" />
  <meta name="keywords" content="faucet,faucethub,kswallet" />
  <meta name="author" content="LenzCreative" />
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
        <a class="nav-link" href="index"><i class="home icon"></i>Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
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
<br>
<br>
<br>
<!-- **3 Columns** -->
<div class="ui center aligned three column doubling stackable grid container">
  <!-- 1 Columns -->
  <div class="column">
    <!-- ads -->
<?php echo AdsFormat1(); ?>
  </div>
  <!-- 2 Columns -->
  <div class="column">
<br>
<br>
<h1 style="font-family:Helvetica; color: #310468;">Log In</h1>
<br>
<!-- errors -->
<?php
echo $address_err;
echo $password_err;
echo $captcha_err;
echo $ban_error;
?>
<br>
<br>
<!-- Form To Login -->
<form action="" method="post">
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="20" width="25" src="img/<?php echo $base_currency ?>.png"></span>
  </div>
  <input type="text" name="address" placeholder="Your <?php echo $base_currency_u; ?> Address" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="20" width="25" src="img/pass.png"></span>
  </div>
  <input type="password" name="password" placeholder="Your Password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<!-- captcha -->
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<br>
<button type="submit" class="fluid violet ui button">Log In</button>
</form>
  </div>
  <!-- 3 Columns -->
  <div class="column">
    <!-- ads -->
<?php echo AdsFormat1(); ?>
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
//Popads code
echo $popads;
?>
<!-- Anti AdBlock Code -->
<?php
require_once 'libs/anti_adblock.php'; 
?>
</body>