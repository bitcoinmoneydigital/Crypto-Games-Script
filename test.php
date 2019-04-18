https://ogads.com/
https://www.codester.com/items/comments/6381/?p=2
https://github.com/csev/wa4e/blob/master/code/rps/game.php
https://gist.github.com/mrliptontea/4c793ebdf72ed145bcbf
<?php

include 'libs/brain.php';
$message1 = "Kswallet first steps";


$time = time();
$timee = "30";

		$time_claim = "0";

		$rmn = $time - $time_claim;
		if ($rmn > $timee) {
			echo "okay you can claim";
			echo $time;
			return 'ok';
		} else {
			$wait  = $time_claim + $timee - $time;
			echo $wait;
			echo "You need to wait";
			return $wait;
		}

?>

<html>
<title>Kswallet - Best Cryptocurrency Microwallet</title>
<body>

<style type="text/css">
	body {
		background-color: #B0CBEC;
	}
</style>

<br>
<br>
<center><h1>Kswallet</h1></center>

<?php
echo $time;
?>

<?php

$v2 = '0';
$v3 = '1';

if (($v2 == '0') && ($v3 == '0')) {
	echo 'everything okay';
} else {
	echo 'not everything okay';
}

?>

</body>
</html>
?>

