<?php

$encrypted = "0";

$encrypted = base64_encode($encrypted);

echo $encrypted;

$decrypted = base64_decode($encrypted);

echo $decrypted;

$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://v1.nastyhosts.com/185.67.177.26');
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result, true);
	if ($obj['suggestion'] == 'alloww') {
		echo  'a';
	} else {
		echo  'bad';
	}

	foreach($obj['country'] as $country ) { 
		echo "<br>";
		echo $country->code;
var_dump($country);
	}


?>
<head>
	</head>
	<body>

<script type="text/javascript">

function getcaptcha()
{
 $.ajax({
 type: 'post',
 url: 'libs/LenzCaptcha.php',
 success: function (response) {
  $('#captcha').attr('src','libs/LenzCaptcha.php')
 }
 });
}	
</script>


<form method="POST" action="testcaptcha.php" >
 <input type="text" name="username" >
 <img src="captcha.php" width="150" height="100" id="captcha">
 <input type="button" value="Reload Captcha" onclick="getcaptcha();" >
 <input type="text" name="captcha_text">
 <input type="submit" name="submit_form" value="Teest Captcha">
</form>

<?php

$satreward = '0.00000001';
$hashess = '10000000';

$math = $hashess/100000*$satreward;

//Rregullon numrin
$krik = number_format($math, 8);

//I kthen numrat ne decimal
$resultff2 = str_replace(".", "", $krik);

//Largon 0 perpara numrit
$resultf = ltrim($resultff2, '0');

echo $resultf;

?>



</body>