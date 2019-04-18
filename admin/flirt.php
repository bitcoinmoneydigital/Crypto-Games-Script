<?php

//Starting the login Session
session_start();
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['adminuser']) || empty($_SESSION['adminuser'])){
  header("location: index");
  exit;
}

require_once ("lib/admin_brain.php");
require_once ("../db/config.php");
require_once ("lib/vb.php");

$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($link, $_POST["query"]);
 $query = "
  SELECT * FROM users 
  WHERE username LIKE '%".$search."%'
  OR ip LIKE '%".$search."%' 
 ";
}
else
{
 $query = "
  SELECT * FROM users ORDER BY id
 ";
}
$result = mysqli_query($link, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
<table class="ui blue table">
  <thead>
    <tr><th><i class="circular teal filter icon"></i>ID</th>
    <th><i class="circular teal user icon"></i>Username</th>
    <th><i class="circular teal money bill alternate check icon"></i>Balance</th>
    <th><i class="circular teal users check icon"></i>Referal</th>
    <th><i class="circular teal users check icon"></i>Referal Earnings</th>
    <th><i class="circular teal calendar on check icon"></i>Date</th>
    <th><i class="circular teal toggle on check icon"></i>IP</th>
    <th></th>
 ';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
    <td>'.$row["id"].'</td>
    <td>'.$row["username"].'</td>
    <td>'.$row["balance"].'</td>
    <td>'.$row["referal"].'</td>
    <td>'.$row["refearning"].'</td>
    <td><a class="ui blue label">'.time_elapsed_string($row["created_at"]).'</a></td>
    <td><a class="ui blue label">'.$row["ip"].'</a></td>
        <td><a class="ui green button" href="'.$website_url.'/admin/edit?id='.$row["id"].'">Edit</a></td>
   </tr>';
 }
 echo $output;
}
else
{
 echo 'No data found.';
}




?>  </table>
  </thead>