<?php

session_start();

if( isset( $_POST['submit_form'] ) )
{

$user_captcha = $_POST['captcha_text'];

if($user_captcha==$_SESSION['captcha'])
{
$name = $_POST['username'];
echo "okay";
}
else
{
echo "Wrong Captcha Please Try Again";
}
}
?>

