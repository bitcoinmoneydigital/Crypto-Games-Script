<?php

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
//Get Total Number Of User Withdrawals
function WithdrawalsNumber()
{
		global $link;

	$check = $link->query("SELECT id FROM withdraw_transactions ORDER BY id DESC LIMIT 1");

	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$id1 = $check['id'];
		return $id1;
} else {
	return "not";
}
}
//Get Total Number Of User Intern Transactions
function InternTransactionNumber()
{
		global $link;

	$check = $link->query("SELECT id FROM transactions ORDER BY id DESC LIMIT 1");

	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$id1 = $check['id'];
		return $id1;
} else {
	return "not";
}
}
//Get Total Amount Of Users Balance
function TotalPay()
{
	global $link;

$result = $link->query('SELECT SUM(balance) AS balance FROM users'); 
$result = $result->fetch_assoc();
$sum = $result['balance'];
return $sum;
}
//Check total faucet claims
function TotalFaucetClaims()
{
	global $link;

$result = $link->query('SELECT SUM(claims) AS claims FROM users'); 
$result = $result->fetch_assoc();
$fclaims = $result['claims'];
return $fclaims;
}
//Get Total Amount of User Referal Earnings
function TotalRefEarnings()
{
	global $link;

$result = $link->query('SELECT SUM(refearning) AS refearning FROM users'); 
$result = $result->fetch_assoc();
$rearnings = $result['refearning'];
return $rearnings;
}
//Get Total Amount Of User Withdrawals
function TotalUserWithdrawed()
{
	global $link;

$result = $link->query('SELECT SUM(paid) AS paid FROM users'); 
$result = $result->fetch_assoc();
$uwithdrawals = $result['paid'];
return $uwithdrawals;
}
//Get Total Amount Of Refered Users
function TotalRefUsers()
{
	global $link;

$result = $link->query('SELECT SUM(refnumb) AS refnumb FROM users'); 
$result = $result->fetch_assoc();
$rusers = $result['refnumb'];
return $rusers;
}
//Update User Settings
function UpdateUserSettings($id,$balancee,$refearningss,$totalfaucetclaimss,$lastfaucetclaimm,$lastrollclaimm,$totaluserwithdraws,$userauthcodee)
{
	global $link;

$sql = "UPDATE users SET balance='$balancee', refearning='$refearningss', claims='$totalfaucetclaimss', lastclaim='$lastfaucetclaimm', lastclaim_roll='$lastrollclaimm', paid='$totaluserwithdraws', authcode='$userauthcodee' WHERE id=$id";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Delete User Function
function DeleteUser($id) 
{
	global $link;
	
$sql = "DELETE FROM users WHERE id=$id";
if ($link->query($sql) === TRUE) {
	return 'ok';
} else {
	return 'no';
}	
}
//Update Website Settings
function UpdateWebsiteSettings($web_title,$website_url,$web_description,$web_keywords,$contact_email,$contact_facebook,$contact_twitter,$contact_linkedin,$contact_googleplus,$referal_percentage,$min_withdraw_amount,$withdraw_status,$base_currency,$withdraw_status_r,$min_withdraw_amount_r)
{
	global $link;

$sql = "UPDATE admin SET web_title='$web_title', website_url='$website_url', web_desc='$web_description', web_keywords='$web_keywords', contact_email='$contact_email', contact_facebook='$contact_facebook', contact_twitter='$contact_twitter', contact_linkedin='$contact_linkedin', contact_googleplus='$contact_googleplus', referal_percentage='$referal_percentage', min_withdraw_amount='$min_withdraw_amount', withdraw_status='$withdraw_status', base_currency='$base_currency', withdraw_status_r='$withdraw_status_r', min_withdraw_amount_r='$min_withdraw_amount_r' WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Update CoinTale Settings
function UpdateCointale($min_amount_cointale)
{
	global $link;

$sql = "UPDATE admin SET min_amount_cointale='$min_amount_cointale'  WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Update Roll Settings
function UpdateRollSettings($roll_timer,$prize1,$prize2,$prize3,$prize4,$prize5,$prize6)
{
	global $link;

$sql = "UPDATE admin SET roll_timer='$roll_timer', prize1='$prize1', prize2='$prize2', prize3='$prize3', prize4='$prize4', prize5='$prize5', prize6='$prize6'  WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Update Faucet Settings
function UpdateFaucetSettings($faucet_reward,$faucet_timer)
{
	global $link;

$sql = "UPDATE admin SET faucet_reward='$faucet_reward', faucet_timer='$faucet_timer'  WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Update API Settings
function UpdateAPIsettings($faucethub_api,$iphub_api,$solvemedia_priv_api,$solvemedia_hash_api,$shortlink_api,$solvemedia_pub_api,$coinhive_api)
{
	global $link;

$sql = "UPDATE admin SET faucethub_api='$faucethub_api', iphub_api='$iphub_api', solvemedia_priv_api='$solvemedia_priv_api', solvemedia_hash_api='$solvemedia_hash_api', shortlink_api='$shortlink_api', solvemedia_pub_api='$solvemedia_pub_api', coinhive_api='$coinhive_api'  WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Last ID Of Banned User
function LastBannedUserId()
{
		global $link;

	$check = $link->query("SELECT id FROM banned_users ORDER BY id DESC LIMIT 1");

	if ($check->num_rows == 1) {
		$check = $check->fetch_assoc();
		$id1b = $check['id'];
		return $id1b;
} else {
	return "not";
}
}
//Add banned user to database
function AddBannedUserToDB($username, $reason, $ip)
{
	global $link;

	  $sql = "INSERT INTO banned_users (username, reason, ip) VALUES ('$username', '$reason', '$ip')";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Unban user and delete user informations from ban table in database
function UnbanUser($id)
{
	global $link;

	  $sql = "DELETE FROM banned_users WHERE id='$id'";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}	
}
//Turn number into decimal
function number_decimal($number) 
{
$number = $number / 100000000;
$number = number_format($number, 8);
return $number;
}
//Update LuckyNumber Settings
function UpdateLuckyNumber($min_amount_luckynumber)
{
	global $link;

$sql = "UPDATE admin SET min_amount_luckynumber='$min_amount_luckynumber'  WHERE id = '1' ";
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
//Update Admin Account Settings
function UpdateAdminAccountSettings($admin_username,$new_password)
{
	global $link;

$sql = "UPDATE admin SET username='$admin_username', password='$new_password'  WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
//Update Mining Settings        --NEW
function UpdateMiningSettings($satreward,$min_amount_mining,$mining_service_satus)
{
	global $link;

$sql = "UPDATE admin SET satreward='$satreward', min_amount_mining='$min_amount_mining', mining_service_satus='$mining_service_satus' WHERE id = '1' ";
if ($link->query($sql) === TRUE) {
return 'ok';
} else {
	return 'no';
}
}
?>