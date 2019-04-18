<?php

error_reporting(E_ALL);

require_once("../libs/solvemedia.php");
require_once '../db/config.php';
require_once 'lib/vb.php';

// Define variables and initialize with empty values
$address = $password = "";
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
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM admin WHERE username = ?";
        
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
                            $_SESSION['adminuser'] = $address;      
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
        }
        
       
        // Close statement
        mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
}
}

?>
<head>
	<!-- Website informations -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
	<meta name="description" content="faucet script" />
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
</head>
<body>
  <center>
<div class="ui three column doubling stackable grid container">
  <div class="column">
  </div>
  <div class="column">
    <br>
    <?php
echo $password_err;
echo $address_err;
echo $captcha_err;
    ?>
    <br>
    <h2>Admin Panel</h2>
    <br>
    <br>
  <form action="" method="post">
  <div class="form-group">
    <label for="formGroupExampleInput">Username</label>
  <input type="text" name="address" placeholder="Username" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
  </div>
<br>
  <div class="form-group">
    <label for="formGroupExampleInput">Pasword</label>
  <input type="password" name="password" placeholder="Password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
  </div>
<br>
<br>  
<?php echo solvemedia_get_html("$solvemedia_pub_api"); ?>
<br>
<br>
<center>
<div class="ui buttons">
  <button type="submit" class="ui button">Log In</button>
  <div class="or"></div>
  <button class="ui positive button">Register</button>
</form>

  </div>
  <div class="column">
  </div>
</div>
</center>
</body>