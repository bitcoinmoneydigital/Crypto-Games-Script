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

$roll_timer = $_POST['roll_timer'];
$prize1 = $_POST['prize1'];
$prize2 = $_POST['prize2'];
$prize3 = $_POST['prize3'];
$prize4 = $_POST['prize4'];
$prize5 = $_POST['prize5'];
$prize6 = $_POST['prize6'];

$prize1 = floor($prize1);
$prize2 = floor($prize2);
$price3 = floor($prize3);
$prize4 = floor($prize4);
$prize5 = floor($prize5);
$prize6 = floor($prize6);

$updateuser = UpdateRollSettings($roll_timer,$prize1,$prize2,$prize3,$prize4,$prize5,$prize6);

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
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="cogs loading icon"></i> Website Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="settings"><i class="cog icon"></i>Website Settings</a>
          <a class="dropdown-item" href="settings_api"><i class="cogs icon"></i>API Settings</a>
        </div>
      </li>
 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="gamepad loading icon"></i> Games Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="settings_cointale"><i class="rocket icon"></i>Cointale Settings</a>
          <a class="dropdown-item" href="settings_faucet"><i class="gift icon"></i>Faucet Settings</a>
          <a class="dropdown-item" href="settings_luckynumber"><i class="gem icon"></i>Lucky Number Settings</a>
          <a class="dropdown-item active" href="settings_roll"><i class="trophy icon"></i>Roll Settings</a>
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
<center><h1>Roll Settings</h1>
<br>
<br>
<form action="" method="post">
  <h5>Roll Timer (In seconds) :</h5>
  <p>Example : <b>1 minute = 60 seconds.</b></p>
<div class="ui large left icon input">
  <input placeholder="Roll Timer" name="roll_timer" value="<?php echo $roll_timer; ?>" type="text">
  <i class="time blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Roll Prize 1 (10000):</h5>
  <p>Example : <b>100 <?php echo $base_currency_u; ?>.</b></p>
<div class="ui large left icon input">
  <input placeholder="Prize 1" name="prize1" value="<?php echo $prize1; ?>" type="text">
  <i class="gift blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Roll Prize 2 (9998 - 9999):</h5>
  <p>Example : <b>90 <?php echo $base_currency_u; ?>.</b></p>
<div class="ui large left icon input">
  <input placeholder="Prize 2" name="prize2" value="<?php echo $prize2; ?>" type="text">
  <i class="gift blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Roll Prize 3 (9994 - 9997):</h5>
  <p>Example : <b>80 <?php echo $base_currency_u; ?>.</b></p>
<div class="ui large left icon input">
  <input placeholder="Prize 3" name="prize3" value="<?php echo $prize3; ?>" type="text">
  <i class="gift blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Roll Prize 4 (9986 - 9993):</h5>
  <p>Example : <b>70 <?php echo $base_currency_u; ?>.</b></p>
<div class="ui large left icon input">
  <input placeholder="Prize 4" name="prize4" value="<?php echo $prize4; ?>" type="text">
  <i class="gift blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Roll Prize 5 (9886 - 9985):</h5>
  <p>Example : <b>60 <?php echo $base_currency_u; ?>.</b></p>
<div class="ui large left icon input">
  <input placeholder="Prize 5" name="prize5" value="<?php echo $prize5;  ?>" type="text">
  <i class="gift blue icon"></i>
</div>
 <br>
 <br> 
  <h5>Roll Prize 6 (0 - 9885):</h5>
  <p>Example : <b>50 <?php echo $base_currency_u; ?>.</b></p>
<div class="ui large left icon input">
  <input placeholder="Prize 6" name="prize6" value="<?php echo $prize6; ?>" type="text">
  <i class="gift blue icon"></i>
</div>
<br>
<br>
<br>
<?php echo $updatemessage; ?>
<button name="save" class="fluid green ui button">Save Settings</button>  
</form>  
</div>
  <div class="column">
  </div>
  </center>
</div>        
</body>
