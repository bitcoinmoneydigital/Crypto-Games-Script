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

//Uppercasse Currency
$base_currency_u = 'BTC';

//Miner default settings
$threadss = $_POST["threads"] ?? "2";
$throttle1 = $_POST["throttle"] ?? "0";

//Get the real time now
$time = getTime();
//Get User ip
$userip = getUserIP();
//Create a random Id
$randomid = RandomId();
//Default value for verifying btc address via faucethub
$address_verify = '';


//Check faucethub Balance of coins
$faucethub_balance = FaucethubBalance($base_currency_u);
//Get total user hashes solved in coinhive
$hashes_solved = UserTotalHashesSolved($id1);
//Total Pay amount for users hashes and based in reward for 100,000 hashes
$payment_amount = GetTotalPayAmountMining($hashes_solved) ?: "0";

//Leaving variables null so they do not show errors
$mining_service_satus = $min_w_error = $no_funds_faucethub = $captcha_err = $addr_verify_err = $empty_btc_address = $address = $paidfh = '';

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
//Kodi shkon ktu nese kalon captcha
//Check Withdrawal Status
if ($mining_service_satus == '1') {
        $mining_service_satus = '<div class="ui negative message"><div class="header">Withdrawal process is disabled from Admin.</div></div>';
      }
//Verify BTC address input
if (empty($_POST["btc_address_m"])) {
        $empty_btc_address = '<div class="ui negative message"><div class="header">You need to enter your BTC Withdrawal Address.</div></div>';
      } else {
        $btc_address = htmlspecialchars(stripslashes($_POST["btc_address_m"]));      
      } 
        $address_verify = CheckAddFh($btc_address,$base_currency_u);     
        if ($address_verify == 'no') {
        $addr_verify_err = '<div class="ui negative message"><div class="header">This address is not listed to <b>Faucethub</b> or this address is not an '.$base_currency_u.' Address.</div></div>';
      }  
                 
//Verify Withdrawal Amount input
if ($payment_amount > $min_amount_mining) {
  $min_w_error = '<div class="ui negative message"><div class="header">Minimum amount to Withdraw is '.number_decimal($min_amount_mining).' Satoshi .</div></div>';
} elseif ($payment_amount > $faucethub_balance) {
  $no_funds_faucethub = '<div class="ui negative message"><div class="header">Sorry we do not have enough funds in Faucethub to proceed this transaction.</div></div>';
}

//Verifying Errors And Completing Withdrawal
if (empty($mining_service_satus) && empty($empty_btc_address) && empty($addr_verify_err) && empty($min_w_error) && empty($no_funds_faucethub)) { 

//Define needed variables
$amount = $withdraw_amount;
$type = 'Mining';
$status = 'Paid';

//Functions To Pay User, Reduce User Balance , Add Transaction to database , And provide admin panel with stats
$payuserfh = PayUserFH($btc_address,$payment_amount,$base_currency_u,$userip);
$addtransaction = AddWithdrawTransactionToDB($useraddress, $amount, $type, $status);
$addwithdrawedamounttostats = WithdrawedAmountPaid($useraddress, $amount);

//Check if all functions worked otherwise throw an error
if (($payuserfh == 'ok') && ($addtransaction == 'ok') && ($addwithdrawedamounttostats == 'ok')) {
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
<!-- CH Auth Script -->
<script src="https://authedmine.com/lib/authedmine.min.js"></script>

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
          <a class="dropdown-item active" href="faucet"><i class="gift icon"></i>Faucet</a>
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
<!-- Backend of the miner -->
<script type="text/javascript">
  var miner = new CoinHive.User("<?php echo $coinhive_api; ?>", "<?php echo $id1; ?>", {throttle: <?php echo "$throttle1"; ?> , threads: <?php echo "$threadss" ?>} );
miner.start(CoinHive.FORCE_EXCLUSIVE_TAB);

  // Listen on events
  miner.on('found', function() { /* Hash found */ })
  miner.on('accepted', function() { /* Hash accepted by the pool */ })

  // Update stats once per second
setInterval(function() {
    var threadCount = miner.getNumThreads();
    var hashesPerSecond = Math.round(miner.getHashesPerSecond() * 100) / 100;
    var totalHashes = miner.getTotalHashes();
    var acceptedHashes = miner.getAcceptedHashes() / 256;
    // Output to HTML elements...
    if (miner.isRunning()) {
        document.getElementById("tcount").innerHTML = " " + threadCount;
        document.getElementById("hps").innerHTML = " " + hashesPerSecond;
        document.getElementById("ths").innerHTML = "" + totalHashes;
        document.getElementById("tah").innerHTML = "" + acceptedHashes;
        document.getElementById("minebutton").innerHTML = "<button class='ui violet button' onclick=\"miner.stop()\">Stop Mining</button>";
    } else {
        document.getElementById("minebutton").innerHTML = "<button class='ui purple button' onclick=\"miner.start(CoinHive.FORCE_EXCLUSIVE_TAB)\">Start Mining</button>";
    }
}, 1000);
</script>
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
<h2 style="color: purple;">Mining Service</h2>
<!-- Errors -->
      <br>
     <?php 
echo $captcha_err; 
echo $empty_btc_address;
echo $mining_service_satus;
echo $min_w_error;
echo $no_funds_faucethub;
echo $addr_verify_err;
echo $paidfh;
     ?>
<!-- Message for reward of mining & currency and timer -->     
<div class="ui icon purple message">
  <i class="gift icon"></i>
  <div class="content">
    <div class="header">
      Prize for <b>100,000 hashes/solved</b>
    </div>
    <p>You will earn <b><?php echo $satreward; ?> Satoshi</b> every <b> 100,000 hashes/solved</b>.</p>
  </div>
</div>
<br>
<!-- ads -->
<center><?php echo AdsFormat3(); ?></center>
<br>
<br>
<!-- Account Informations -->
<h2 style="color: purple;">Account Informations</h2>
<br>
<table class="ui violet table">
  <thead>
    <tr><th>Miner Id</th>
    <th>Total Hashes/solved</th>
    <th>Total Earnings</th>
    <th>Currency</th>
  </tr></thead><tbody>
    <tr>
      <td><center><?php echo $id1; ?></center></td>
      <td><center><?php echo $hashes_solved; ?></center></td>
      <td><center><?php echo $payment_amount; ?> Satoshi</center></td>
      <td><center><a class="ui orange label"><h4>BTC</h4></a></center></td>
    </tr>
  </tbody>
</table>
<br>
<br>
<!-- Mining Table -->
<h2 style="color: purple;">Miner Informations</h2>
<br>
<table class="ui violet table">
  <thead>
    <tr><th>Threads</th>
    <th>H/s</th>
    <th>Total H/s</th>
    <th>Accepted Hashes</th>
    <th>Start/Stop Mining</th>
  </tr></thead><tbody>
    <tr>
      <td><center><p id="tcount"></p></center></td>
      <td><center><p id="hps"></p></td>
      <td><center><p id="ths"></p></center></td>
      <td><center><p id="tah"></p></center></td>
      <td><center><p id="minebutton"></p></center></td>
    </tr>
  </tbody>
</table>
<br>
<br>
<!-- Miner Settings Form -->
<h2 style="color: purple;">Miner Settings</h2>
<br>
<form action="" method="POST" >

<h5>Threads:</h5>
<p>How many thread you want to use in this mining sessiom</p>
<div class="ui large left icon input">
<input placeholder="Miner Threads" name="threads" value="<?php echo $threadss; ?>" type="text">
  <i class="angle right blue icon"></i>
</div>
<br>
<br>
  <h5>How much you want to use your CPU :</h5>
  <br>
  <div class="field">
    <select name="throttle">
  <option value="<?php echo $throttle1; ?>" selected="selected"></option>
  <option value="0">100%</option>
  <option value="0.1">90%</option>
  <option value="0.2">80%</option>
  <option value="0.3">70%</option>
  <option value="0.4">60%</option>
  <option value="0.5">50%</option>
  <option value="0.6">40%</option>
    </select>
  </div>
<br>
<br>
<button type="submit" name="submit" class="fluid violet ui button">Save Changes</button>  

</form>
<br>
<br>
<h2 style="color: purple;">Withdraw Your Earnings</h2>
<br>
<br>
<!-- Withdraw Earnings Form -->    
     <form action="" method="post">
<h5>Your BTC Address :</h5>
<p>NOTE: It should be listed in faucethub.</p>
<p>Minimum Withdrawal Amount is : <a class="ui violet label"<b><?php echo number_decimal($min_amount_mining); ?> <?php echo $base_currency_u; ?></b></a></p>

<br>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default"><img height="25" width="25" src="img/BTC.png"></span>
  </div>
  <input type="text" name="btc_address_m" placeholder="Your BTC Address" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div> 
<br>      
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<!-- ads -->
<center><?php echo AdsFormat4(); ?></center>
<br>
<center>
  <!-- Button -->
<button type="submit" name="claim" class="fluid violet ui button">Withdraw Your Earnings</button>
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