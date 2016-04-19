<?php

/**
 * Makhtar Diouf - Arduino project
 * Process received data stored in json files: humidity, sound, temperature...etc
 * $Id$
 */
class ArduiData {

    public $data;

    function __construct() {
        $this->data = [];
    }

    public function getData($target) {
        $this->processData($target);
    }

    protected function processData($file) {

        $date = date("Y-m-d");
        $dir = "output/" . $date . "/";
        $jsDateTime = function ($arg) {
            echo '[new Date(' . $arg[0] * 1000 . "), $arg[1] ],";
        };

        $target = $dir . $file . ".json";
        $fp = fopen($target, "r");
        if (!$fp) {
            $_SESSION["error_msg"] = "Could not open $target";
            return;
        }

        $output = "";
        while ($line = fgets($fp)) {
            $temp = json_decode($line);
            if (!feof($fp) || (!empty($temp[0]))) {
                $output .= $jsDateTime($temp);
            }
        }
        echo $output;
        fclose($fp);
    }

    public static function readLastData($file) {
        try {
            $date = date("Y-m-d");
            $dir = "output/" . $date . "/";
            $target = $dir . $file . ".json";
            $fp = fopen($target, "r");
            if (!$fp) {
                $_SESSION["error_msg"] = "Could not open $target";
                return;
            }

            $pos = -1;
            $t = " ";
            while ($t != "\n") {
                fseek($fp, $pos, SEEK_END);
                $t = fgetc($fp);
                $pos += -1;
            }
            echo fgets($fp);
            fclose($fp);
        } catch (Exception $ex) {
            $_SESSION["error_msg"] = "Could not open $target: " . $ex->getMessage();
        }
    }

}
