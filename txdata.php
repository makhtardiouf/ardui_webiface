<?php
/** Makhtar Diouf
 * Test sending a remote command to the arduino board
 * $Id: txdata.php, e9007b347294  makhtar $
 */
$ARDUINO_ADDR = "http://192.168.0.139:9000";

$s = curl_init();
curl_setopt($s, CURLOPT_URL, $ARDUINO_ADDR);
curl_setopt($s,CURLOPT_TIMEOUT,10); 
$response = curl_exec($s);
$status = curl_getinfo($s, CURLINFO_HTTP_CODE);

echo "Command sent to Arduino...<br>";
echo $response . "<br>";
curl_close($s);
