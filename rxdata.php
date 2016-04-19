<?php
/** Makhtar Diouf
 * Save monitoring data received from arduino
 * $Id: rxdata.php, e9007b347294  makhtar $
 */

$date = date("Y-m-d");
$dir = "output/" . $date . "/";
if (!is_dir($dir)) {
    $dirOk = mkdir($dir, 0777, true);
    if (!$dirOk) {
        echo "Warning: could not create output directory\n";
    }
}

$files = array("hum", "light", "sound", "temp", "dist");

foreach ($files as $file) {

    $val = $_GET["$file"];
    if (!empty($val)) {
        $json = array(strtotime('now'), $val);
        $data = json_encode($json) . "\n";
        file_put_contents($dir . $file . ".json", $data, FILE_APPEND);
    }
    
    if ($_GET["fromardui"])
        echo "$file@" . $date . " RX:$data\n";
    else
        echo "$file@" . $date . " RX:$data<br>";
}

// Save request to log file
file_put_contents($dir . "rxdata.log", date("Y-m-d h:i:s") . 
        " RX from " . $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'] .
        " " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
