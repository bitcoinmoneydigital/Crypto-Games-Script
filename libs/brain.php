<?php

//Get the user IP
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
//Create a random and unique ID
function RandomId()
{
	$str = "";
	$length = "20";
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
}
//Check if address belongs to any faucethub account
function CheckAddFh($address,$base_currency_u) 
{
$url = 'https://faucethub.io/api/v1/checkaddress?';
$data = array('api_key' => '4a3194b14efe1630caeea902c67a3997', 'address' => "$address", 'currency' => "$base_currency_u");
// use key 'http' even if you send the request to https://...
$options = array(
  'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query($data),
  ),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$json_data = json_decode($result, true);

$statusi = $json_data["status"];

if ($statusi == 200 ) {
	return 'ok';
} else {
	return 'no';
}

}
//Check if user ip is blocked in iphub
function iphub() {
	global $userip;
	global $iphub_api;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://v2.api.iphub.info/ip/'.$userip);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Key: ' . $iphub_api));
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result, true);
	if ($obj['block'] == '1') {
		return 'bad';
	} else {
		return 'good';
	}
}
//Check if user clan claim from faucet
function checkaddress($address) 
{
	global $link;
	global $faucet_timer;
	global $time;
	$check = $link->query("SELECT * FROM users WHERE username = '$address'");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$time_claim = $check['lastclaim'];
		$rmn = $time - $time_claim;
		if ($rmn > $faucet_timer) {
			return 'ok';
		} else {
			$wait  = $time_claim + $faucet_timer - $time;
			return $wait;
		}	
	} else {
		return 'ok';
	} 
	return 'no';
}
//Get Current Time
function getTime()
{
$time = time();
return $time;
}
//Short faucet claim url
function shortFurl($shortthislink) 
{
	global $shortlink_api;

  $result = @json_decode(file_get_contents('http://onlinebee.in/api?api=' . $shortlink_api . '&url=' . urlencode($shortthislink)), true);

  if($result['status'] === 'error')
    return "not";
  else
    return $result['shortenedUrl'];	
}
//Get user ID
function getUserid($useraddress)
{
	global $link;

	$check = $link->query("SELECT id FROM users WHERE username = '$useraddress' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$id1 = $check['id'];
		return $id1;
} else {
	return "not";
}
}
//Get user Auth Code
function getAuthCode($useraddress)
{
	global $link;

	$check = $link->query("SELECT authcode FROM users WHERE username = '$useraddress' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$authcode = $check['authcode'];
		return $authcode;
} else {
	return "not";
}	
}
//Verify if auth code is valid
function VerifyAuthCode()
{
	global $link;
	global $useraddress;
	global $get_authcode;

	$check = $link->query("SELECT authcode FROM users WHERE username = '$useraddress' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$authcode = $check['authcode'];
		}
if ($authcode == $get_authcode) {
	return 'ok';
} else {
	return 'no';
}		
}
//Update Auth Code of user 
function UpdateAuthCode($id1 , $randomid)
{
	global $link;

	  $sql = "UPDATE users SET authcode='$randomid' WHERE id=$id1";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}	
//Update user balance
function UpdateUserBalance($useraddress, $amount)
{
	global $link;

	  $sql = "UPDATE users SET `balance`=(`balance`+$amount) where username = '$useraddress'";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Update user last claim faucet in database
function UpdateLastClaim($id1, $time)
{
	global $link;

	  $sql = "UPDATE users SET lastclaim='$time' WHERE id=$id1";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Add the transaction to Database (transactions)
function AddTransactionToDB($useraddress, $amount, $type, $status)
{
	global $link;

	  $sql = "INSERT INTO transactions (username, amount, type, status) VALUES ('$useraddress', '$amount', '$type', '$status')";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Randomize a number from 1 - 10000
function RandomNumberRoll()
{
	$randomized_nr = (rand(1,10000));

	return $randomized_nr;
}
//Check if user can roll 
function checkaddressRoll($address) 
{
	global $link;
	global $time;
	global $roll_timer;
	$check = $link->query("SELECT * FROM users WHERE username = '$address'");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$time_claim = $check['lastclaim_roll'];
		$rmn = $time - $time_claim;
		if ($rmn > $roll_timer) {
			return 'ok';
		} else {
			$wait  = $time_claim + $roll_timer - $time;
			return $wait;
		}	
	} else {
		return 'ok';
	} 
	return 'no';
}
//Update user last claim roll in database
function UpdateLastClaimRoll($id1, $time)
{
	global $link;

	  $sql = "UPDATE users SET lastclaim_roll='$time' WHERE id=$id1";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Get User Balance
function GetUserBalance($id1)
{
	global $link;

	$check = $link->query("SELECT balance FROM users WHERE id = '$id1' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$balance = $check['balance'];
		return $balance;
} else {
	return "not";
}	
}
//Reduce User Balance Cointale
function ReduceUserBalance($useraddress, $amount)
{
	global $link;

	  $sql = "UPDATE users SET `balance`=(`balance`-$amount) where username = '$useraddress'";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Get User Total Number Of Referals
function GetReferalNumb($useraddress)
{
	global $link;

	$check = $link->query("SELECT refnumb FROM users WHERE username = '$useraddress' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$refnumb = $check['refnumb'];
		return $refnumb;
} else {
	return "no";
}
}
//Check Faucethub Balance
function FaucethubBalance($base_currency_u) 
{
    global $faucethub_api;

    $param = array(
        'api_key' => $faucethub_api,
        'currency' => $base_currency_u
    );
    $url = 'https://faucethub.io/api/v1/balance';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($param));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param); 

    $result = curl_exec($ch);

    curl_close($ch);
    $jsonhis = json_decode($result, TRUE);
    $message = $jsonhis['message']; 
    if ($message == 'OK') {
    	return $jsonhis['balance'];
    } else {
    	return 'no';
    }
}
//Send Payment To User (Faucethub)
function PayUserFH($useraddress,$amount,$base_currency_u,$userip)
{
	global $faucethub_api;

$url = 'https://faucethub.io/api/v1/send?';
$data = array('api_key' => "$faucethub_api", 'to' => "$useraddress", 'amount' => "$amount", 'currency' => "$base_currency_u", 'ip_address' => "$userip");
// use key 'http' even if you send the request to https://...
$options = array(
  'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query($data),
  ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$json_data = json_decode($result, true);

$fhresp = $json_data['message'];

if ($fhresp == "OK") {
return 'ok';
} else {
	return 'no';
}
}
//Register Withdrawed amount in user stats
function WithdrawedAmountPaid($useraddress, $amount)
{
	global $link;

	  $sql = "UPDATE users SET `paid`=(`paid`+$amount) where username = '$useraddress'";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Get User Referal
function GetUserReferal($useraddress)
{
	global $link;

	$check = $link->query("SELECT referal FROM users WHERE username = '$useraddress' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$referal = $check['referal']; 
		return $referal;
} else {
	return "no";
}
}
//Update referal balance of a user
function UpdateUserRefBalance($userreferal, $refamount)
{
	global $link;

	  $sql = "UPDATE users SET `refearning`=(`refearning`+$refamount) where username = '$userreferal'";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Get User Referal Balance
function GetUserReferalBalance($id1)
{
	global $link;

	$check = $link->query("SELECT refearning FROM users WHERE id = '$id1' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$refearning = $check['refearning'];
		return $refearning;
} else {
	return "not";
}	
}
//Add the transaction to Database (withdraw_transactions)
function AddWithdrawTransactionToDB($useraddress, $amount, $type, $status)
{
	global $link;

	  $sql = "INSERT INTO withdraw_transactions (username, amount, type, status) VALUES ('$useraddress', '$amount', '$type', '$status')";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Get time when an action was done
function time_elapsed_string($datetime, $full = false) 
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
//Turn number into decimal
function number_decimal($number) 
{
$number = $number / 100000000;
$number = number_format($number, 8);
return $number;
}
//Reduce User Referal Balance Cointale
function ReduceUserReferalBalance($useraddress, $amount)
{
	global $link;

	  $sql = "UPDATE users SET `refearning`=(`refearning`-$amount) where username = '$useraddress'";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Rotative Ads Format 1
function AdsFormat1()
{
	global $format_1_1;
	global $format_1_2;
	global $format_1_3;
	global $format_1_4;

 $ads = array("$format_1_1","$format_1_2","$format_1_3","$format_1_4");
 shuffle($ads);
 foreach ($ads as $ads) {
 	return $ads;
 }
}
//Rotative Ads Format 2
function AdsFormat2()
{
	global $format_2_1;
	global $format_2_2;
	global $format_2_3;
	global $format_2_4;

 $ads = array("$format_2_1","$format_2_2","$format_2_3","$format_2_4");
 shuffle($ads);
 foreach ($ads as $ads) {
 	return $ads;
 }
}
//Rotative Ads Format 3
function AdsFormat3()
{
	global $format_3_1;
	global $format_3_2;
	global $format_3_3;
	global $format_3_4;

 $ads = array("$format_3_1","$format_3_2","$format_3_3","$format_3_4");
 shuffle($ads);
 foreach ($ads as $ads) {
 	return $ads;
 }
}
//Rotative Ads Format 4
function AdsFormat4()
{
	global $format_4_1;
	global $format_4_2;
	global $format_4_3;
	global $format_4_4;

 $ads = array("$format_4_1","$format_4_2","$format_4_3","$format_4_4");
 shuffle($ads);
 foreach ($ads as $ads) {
 	return $ads;
 }
}
//Get User Total Paid Balance
function GetUserPaidBalance($id1)
{
	global $link;

	$check = $link->query("SELECT paid FROM users WHERE id = '$id1' LIMIT 1");
	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$paiduser = $check['paid'];
		return $paiduser;
} else {
	return "not";
}	
}
//Check how much website paid
function PaidAmountToUsers()
{
	global $link;

$result = $link->query('SELECT SUM(amount) AS amount FROM withdraw_transactions'); 
$result = $result->fetch_assoc();
$sum = $result['amount'];
return $sum;
}
//Get Users last id
function LastUserId()
{
		global $link;

	$check = $link->query("SELECT id FROM users ORDER BY id DESC LIMIT 1");

	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$id1 = $check['id'];
		return $id1;
} else {
	return "not";
}
}
//Get Total Amount Of User Internal Earnings
function GetTotalAmountOfInternEarnings()
{
	global $link;

$result = $link->query('SELECT SUM(balance) AS balance FROM users'); 
$result = $result->fetch_assoc();
$sum = $result['balance'];
return $sum;
}
//Check if User is using proxy (Nastyhosts)    NEW
function CheckNastyHosts()
{
	global $userip;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://v1.nastyhosts.com/'.$userip);
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result, true);
	if ($obj['suggestion'] == 'allow') {
		return 'good';
	} else {
		return 'bad';
	}
}
//Get current hashes solved in coinhive from user      NEW
function UserTotalHashesSolved($id1)
{
   global $coinhive_api;

$url = "https://api.coinhive.com/user/balance?secret=$coinhive_api&name=$id1";
$json = file_get_contents($url);
$json_data = json_decode($json, true);

return $json_data["balance"] ?? '0';
}
//Get total amount to pay for user hashed solved     NEW
function GetTotalPayAmountMining($hashes_solved)
{
	global $satreward;

$math = $hashes_solved/100000*$satreward;

$krik = number_format($math, 8);

$resultff2 = str_replace(".", "", $krik);

return  ltrim($resultff2, '0');
}
//Withdraw hashes of user in Coinhive
function WithdrawCoinHiveHashes($id1)
{
	global $coinhive_api;
	global $hashes_solved;

//Largon shumen qe ka ber personi withdraw nga coinhive
      $url = 'https://api.coinhive.com/user/withdraw?';
$data = array('secret' => "$coinhive_api", 'name' => "$id1", 'amount' => "$hashes_solved");
// use key 'http' even if you send the request to https://...
$options = array(
  'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query($data),
  ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$json_data = json_decode($result, true);
}
?>