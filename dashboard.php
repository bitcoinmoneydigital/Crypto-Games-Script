<?php

error_reporting(E_ALL);

require_once("libs/solvemedia.php");
require_once("libs/brain.php");
require_once("libs/vb.php");
require_once 'db/config.php';
require_once ("libs/ads.php");

session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['address']) || empty($_SESSION['address'])){
  header("location: index");
  exit;
}


//Get user address
$useraddress = $_SESSION['address'];
//Get user ID
$id1 = getUserid($useraddress);
//Uppercasse Currency
$base_currency_u = strtoupper($base_currency);
//Get User Balance
$userbalance = GetUserBalance($id1);
//Get user Referal Balance
$userreferalbalance = GetUserReferalBalance($id1);
//Get User Total Paid Balance
$totalpaidbalance = GetUserPaidBalance($id1);

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
        <a class="nav-link" href="#"><i class="home icon"></i>Dashboard <span class="sr-only">(current)</span></a>
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
<hr>
<br>
<!-- Account Informations -->  
<center>
  <h2>Dashboard</h2>
  <br>
<div class="container">
  <div class="row">
    <!-- Column 1 -->
    <div class="col-sm">
<div class="ui card">
  <div class="content">
    <i class="huge icons">
  <i class="violet big circle outline icon"></i>
  <i class="purple trophy icon"></i>
</i>
    <div class="center aligned description">
      <h4>Balance</h4>
    </div>
  </div>
  <div class="extra content">
    <div class="center aligned author">
      <h5><?php echo number_decimal($userbalance); ?> <?php echo $base_currency_u; ?></h5>
      <br>
      <br>
      <a href="withdraw" ><button class="purple ui button">Withdraw</button></a>
    </div>
  </div>
</div>
    </div>
    <!-- Column 2 -->
    <div class="col-sm">
<div class="ui card">
  <div class="content">
    <i class="huge icons">
  <i class="violet big circle outline icon"></i>
  <i class="purple users icon"></i>
</i>
    <div class="center aligned description">
      <h4>Referal Earnings</h4>
    </div>
  </div>
  <div class="extra content">
    <div class="center aligned author">
      <h5><?php echo number_decimal($userreferalbalance); ?> <?php echo $base_currency_u; ?></h5>
      <br>
      <br>
      <a href="referal_withdraw" ><button class="purple ui button">Withdraw</button></a>
    </div>
  </div>
</div>
    </div>
    <!-- Column 3 -->
    <div class="col-sm">
<div class="ui card">
  <div class="content">
    <i class="huge icons">
  <i class="violet big circle outline icon"></i>
  <i class="purple money bill alternate outline icon"></i>
</i>
    <div class="center aligned description">
      <h4>Total Withdrawals</h4>
    </div>
  </div>
  <div class="extra content">
    <div class="center aligned author">
      <h5><?php echo number_decimal($totalpaidbalance); ?> <?php echo $base_currency_u; ?></h5>
    </div>
  </div>
</div>
    </div>
  </div>
</div>
</center>
<br>
<!-- ads -->
<center><?php echo AdsFormat3(); ?></center>
<br>
<br>
<hr>
<br>
<br>
<!-- Column 1 -->
<div class="ui four column doubling stackable grid container">
  <div class="column">
<div class="violet ui link cards">
  <div class="card">
    <div class="image">
      <img src="img/faucet.jpg">
    </div>
    <div class="content">
      <center><h4>Faucet Game</h4></center>
      <br>
      <div class="description">
        <center>
          <a href="faucet">
        <div class="ui animated button" tabindex="0">
  <div class="visible content">Go to Faucet</div>
  <div class="hidden content">
    <i class="right arrow icon"></i>
  </div>
</a>
</div>
</center>
      </div>
    </div>
  </div>
</div>
  </div>
  <!-- Column 2 -->
  <div class="column">  
<div class="purple ui link cards">
  <div class="card">
    <div class="image">
      <img src="img/cointalegame.jpg">
    </div>
    <div class="content">
      <center><h4>CoinTail Game</h4></center>
      <br>
      <div class="description">
        <center>
          <a href="cointale">
        <div class="ui animated button" tabindex="0">
  <div class="visible content">Go to CoinTail</div>
  <div class="hidden content">
    <i class="right arrow icon"></i>
  </div>
  </a>
</div>
</center>
      </div>
    </div>
  </div>
</div>
  </div>
  <!-- Column 3 -->
  <div class="column">
<div class="violet ui link cards">
  <div class="card">
    <div class="image">
      <img src="img/rollgame.jpg">
    </div>
    <div class="content">
      <center><h4>Roll Game</h4></center>
      <br>
      <div class="description">
        <center>
          <a href="roll">
        <div class="ui animated button" tabindex="0">
  <div class="visible content">Go to Roll Game</div>
  <div class="hidden content">
    <i class="right arrow icon"></i>
  </div>
  </a>
</div>
</center>
      </div>
    </div>
  </div>
</div>
  </div>
  <!-- Column 4 -->
  <div class="column">
<div class="purple ui link cards">
  <div class="card">
    <div class="image">
      <img src="img/luckynumbergame.jpg">
    </div>
    <div class="content">
      <center><h4>LuckyNumber Game</h4></center>
      <br>
      <div class="description">
        <center>
          <a href="lucky_number">
        <div class="ui animated button" tabindex="0">
  <div class="visible content">Go to LuckyNumber Game</div>
  <div class="hidden content">
    <i class="right arrow icon"></i>
  </div>
  </a>
</center>
      </div>
    </div>
  </div>
</div>
  </div>  
<!-- Table for Intern Transactions -->
<h3>Your latest <b>10</b> Intern Transactions : </h3>
<table class="ui violet table">
  <thead>
    <tr><th><i class="circular purple filter icon"></i>ID</th>
    <th><i class="circular purple trophy icon"></i>Amount</th>
    <th><i class="circular purple calendar check icon"></i>Date</th>
    <th><i class="circular purple sort up check icon"></i>Type</th>
    <th><i class="circular purple toggle on check icon"></i>Status</th>
  </tr></thead><tbody>
    <tr> 
<?php
$sql = "SELECT * FROM transactions WHERE username = '$useraddress' ORDER BY created_at DESC LIMIT 10 ";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      if ($row["status"] == 'Won') {
        $status = "<a class='ui green label'>". $row["status"]. "</a>";
      } else {
        $status = "<a class='ui red label'>". $row["status"]. "</a>";
      }
      echo " 
    <tr>
      <td>". $row["id"]. "</td>
      <td>". number_decimal($row["amount"]). " <b>$base_currency_u</b></td>
      <td>". time_elapsed_string($row["created_at"]). "</td>
      <td><a class='ui purple label'>". $row["type"]. "</a></td>
      <td>$status</td>      
    </tr>
      ";
    }
} else {
  echo "<td>You don't have any internal transaction.</td>";
}
?>        
    </tr>
  </tbody>
</table>
<!-- Table for Withdraw Transactions -->
<h3>Your latest <b>5</b> Withdrawal Transactions : </h3>
<table class="ui violet table">
  <thead>
    <tr><th><i class="circular purple filter icon"></i>ID</th>
    <th><i class="circular purple trophy icon"></i>Amount</th>
    <th><i class="circular purple calendar check icon"></i>Date</th>
    <th><i class="circular purple sort up check icon"></i>Type</th>
    <th><i class="circular purple toggle on check icon"></i>Status</th>
    <th></th>
  </tr></thead><tbody>
    <tr> 
<?php
$sql = "SELECT * FROM withdraw_transactions WHERE username = '$useraddress' ORDER BY created_at DESC LIMIT 5 ";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo " 
    <tr>
      <td>". $row["id"]. "</td>
      <td>". number_decimal($row["amount"]). " <b>$base_currency_u</b></td>
      <td>". time_elapsed_string($row["created_at"]). "</td>
      <td><a class='ui violet label'>". $row["type"]. "</a></td>
      <td><a class='ui green label'>". $row["status"]. "</a></td>
      <td><a target='_BLANK' href='http://www.faucethub.io/balance/".$row["username"]."'>Check Transaction In Faucethub</a></td>      
    </tr>
      ";
    }
} else {
  echo "<td>You don't have any withdrawal.</td>";
}
?>   
    </tr>
  </tbody>
</table>   
</div>
<br>
<br>
<br>
<!-- ads -->
<center><?php echo AdsFormat2(); ?></center>
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