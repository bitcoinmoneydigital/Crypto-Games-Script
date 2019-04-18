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
  SELECT * FROM transactions 
  WHERE username LIKE '%".$search."%'
  OR type LIKE '%".$search."%' OR status LIKE '%".$search."%' ORDER BY created_at DESC
 ";
}
else
{
 $query = "
  SELECT * FROM transactions ORDER BY created_at DESC
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
    <th><i class="circular teal money bill alternate check icon"></i>Amount</th>
    <th><i class="circular teal clock outline check icon"></i>Date</th>
    <th><i class="circular teal sort check icon"></i>Type</th>
    <th><i class="circular teal calendar on check icon"></i>Status</th>
 ';
 while($row = mysqli_fetch_array($result))
 {

if ($row["status"] == 'Won') {
  $status = '<a class="ui green label">Won</a>';
} elseif ($row["status"] == 'Lost') {
  $status = '<a class="ui red label">Lost</a>';
} elseif ($row["status"] == 'Paid') {
  $status = '<a class="ui red label">Paid</a>';
}

  $output .= '
   <tr>
    <td>'.$row["id"].'</td>
    <td>'.$row["username"].'</td>
    <td>'.$row["amount"].'</td>
    <td>'.time_elapsed_string($row["created_at"]).'</td>
    <td><a class="ui blue label">'.$row["type"].'</a></td>
    <td>'.$status.'</td>
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