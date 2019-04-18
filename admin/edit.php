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

//Get and variable ID
if(isset($_GET['id'])) {

$id = htmlspecialchars(stripslashes($_GET["id"]));

} else {
  $id = false;
}
//If user Save Settings
if(isset($_POST["save"])){

$balancee = $_POST['balance'];
$refearningss = $_POST['refearningss'];
$totalfaucetclaimss = $_POST['totalfaucetclaimss'];
$lastfaucetclaimm = $_POST['lastfaucetclaimm'];
$lastrollclaimm = $_POST['lastrollclaimm'];
$totaluserwithdraws = $_POST['totaluserwithdraws'];
$userauthcodee = $_POST['userauthcodee'];

$updateuser = UpdateUserSettings($id,$balancee,$refearningss,$totalfaucetclaimss,$lastfaucetclaimm,$lastrollclaimm,$totaluserwithdraws,$userauthcodee);

if ($updateuser == 'ok') {
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
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="users icon"></i> Users Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item active" href="users"><i class="users icon"></i>Total Users</a>
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
  </div>
<div class='column'> 
<?php echo $updatemessage;
 ?> 
<?php
$sql = "SELECT * FROM users WHERE id= '$id'";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      

      echo "
 <h2>Settings of User with <b><a class='ui teal big label'>".$row["id"]."</a></b> ID</h2>  
 <br>
 <br>   
<form action='' method='post'>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>ID</span>
  </div>
  <input type='text' value='".$row["id"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Username</span>
  </div>
  <input type='text' value='".$row["username"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Balance(".$base_currency_u.")</span>
  </div>
  <input type='text' name='balance' value='".$row["balance"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Referal</span>
  </div>
  <input type='text' value='".$row["referal"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Referal Earnings (".$base_currency_u.")</span>
  </div>
  <input type='text' name='refearningss' value='".$row["refearning"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' >
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Date of Registration</span>
  </div>
  <input type='text' value='".$row["created_at"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Total Faucet Claims</span>
  </div>
  <input type='text' name='totalfaucetclaimss' value='".$row["claims"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Last Faucet Claim</span>
  </div>
  <input type='text' name='lastfaucetclaimm' value='".$row["lastclaim"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' >
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Last Roll Claim</span>
  </div>
  <input type='text' name='lastrollclaimm' value='".$row["lastclaim_roll"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Total User Withdrawals(".$base_currency_u.")</span>
  </div>
  <input type='text' name='totaluserwithdraws' value='".$row["paid"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>User IP</span>
  </div>
  <input type='text' value='".$row["ip"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>User PubID</span>
  </div>
  <input type='text' value='".$row["pubid"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>Number Of User Referals</span>
  </div>
  <input type='text' value='".$row["refnumb"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' readonly>
</div>
<div class='input-group input-group-sm mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text' id='inputGroup-sizing-sm'>User Auth Code</span>
  </div>
  <input type='text' name='userauthcodee' value='".$row["authcode"]."' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' >
</div>
<br>
<button name='save' class='fluid green ui button'>Save Settings</button>
</form>
      ";

    }
} else {
  echo "<td>0 results</td>";
}
?>
</div>
  <div class="column">
  </div>
</div>        
 
</body>
