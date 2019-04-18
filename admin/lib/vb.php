<?php

require_once("admin_brain.php");
require_once '../db/config.php';



$sql = "SELECT * FROM admin";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      //Account Settings
      $admin_username = $row["username"];
      $hashed_password = $row["password"];

      //Website Settings
      $web_title = $row["web_title"];
      $website_url = $row["website_url"];
      $web_description = $row["web_desc"];
      $web_keywords = $row["web_keywords"];
      $contact_email = $row["contact_email"];
      $script_version = "1.0";
      $contact_facebook = $row["contact_facebook"];
      $contact_twitter = $row["contact_twitter"];
      $contact_linkedin = $row["contact_linkedin"];
      $contact_googleplus = $row["contact_googleplus"];
      $referal_percentage = $row["referal_percentage"];
      $min_withdraw_amount = $row["min_withdraw_amount"];
      $withdraw_status = $row["withdraw_status"];
      $base_currency = $row["base_currency"];
      $withdraw_status_r = $row["withdraw_status_r"];
      $min_withdraw_amount_r = $row["min_withdraw_amount_r"];      
      $mining_service_satus = $row["mining_service_satus"]; //NEW

      //Api Keys 
      $solvemedia_priv_api = $row["solvemedia_priv_api"];
      $solvemedia_hash_api = $row["solvemedia_hash_api"];
      $solvemedia_pub_api = $row["solvemedia_pub_api"];
      $faucethub_api = $row["faucethub_api"];
      $iphub_api = $row["iphub_api"];
      $shortlink_api = $row["shortlink_api"];
      $coinhive_api = $row["coinhive_api"];

      //Timers for Faucet and Roll
      $faucet_timer = $row["faucet_timer"];
      $roll_timer = $row["roll_timer"];

      //Roll Prize
      //10000
      $prize1 = $row["prize1"];
      //9998 - 9999
      $prize2 = $row["prize2"];
      //9994 - 9997
      $prize3 = $row["prize3"];
      //9986 - 9993
      $prize4 = $row["prize4"];
      //9886 - 9985
      $prize5 = $row["prize5"];
      //0 - 9885
      $prize6 = $row["prize6"];

      //Minimum amount to bet and play CoinTale
      $min_amount_cointale = $row["min_amount_cointale"];

      //Faucet reward
      $faucet_reward = $row["faucet_reward"];

      //Minimum amount to bet and play Lucky Number
      $min_amount_luckynumber = $row["min_amount_luckynumber"]; 

      //Mining Reward for 100,000 hashes/solved
      $satreward = $row["satreward"];

      //Minimum amount to withdraw from mining earnings //NEW
      $min_amount_mining = $row["min_amount_mining"];

    }
} 
?> 