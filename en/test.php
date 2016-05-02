<?php
$num = '13634859126';
$message = 'test';

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, "http://sms.unitel.mn/sendSMS.php?uname=NMTGtOUlLC&upass=fMT2Uni140SPlsJFhdsa&sms=".$message."&from=151510&mobile=88004624");
curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_PROXY, "183.177.102.95");
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>