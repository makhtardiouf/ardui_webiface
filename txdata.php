<?php
// Makhtar Diouf $Id: txdata.php, e9007b347294  makhtar $
// Send remote command data to arduino

$s = curl_init();
curl_setopt($s, CURLOPT_URL, "http://192.168.0.139:9000");
curl_setopt($s,CURLOPT_TIMEOUT,10); 
$response = curl_exec($s);
$status = curl_getinfo($s, CURLINFO_HTTP_CODE);

echo "Alert sent to Arduino...<br>";

echo $response . "<br>";
curl_close($s);
