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

$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($link, $_POST["query"]);
 $query = "
  SELECT * FROM banned_users 
  WHERE username LIKE '%".$search."%'
  OR ip LIKE '%".$search."%' ORDER BY created_at DESC
 ";
}
else
{
 $query = "
  SELECT * FROM banned_users ORDER BY created_at DESC
 ";
}
$result = mysqli_query($link, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
<table class="ui blue table">
  <thead>
    <tr><th><i class="circular teal filter icon"></i>ID</th>
    <th><i class="circular teal trophy icon"></i>Username</th>
    <th><i class="circular teal comment check icon"></i>Reason</th>
    <th><i class="circular teal toggle on check icon"></i>IP</th>
    <th><i class="circular teal clock outline check icon"></i>Date</th>
 ';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
    <td>'.$row["id"].'</td>
    <td>'.$row["username"].'</td>
    <td>'.$row["reason"].'</td>
    <td><a class="ui teal label">'.$row["ip"].'</a></td>
    <td><a class="ui blue label">'.time_elapsed_string($row["created_at"]).'</a></td>
   </tr>';
 }
 echo $output;
}
else
{
 echo 'No banned user found.';
}




?>  </table>
  </thead>