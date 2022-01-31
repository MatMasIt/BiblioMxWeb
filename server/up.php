<?php
require("processCsv.php");
if (!function_exists('getallheaders')) {
    function getallheaders() {
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
    }
}
$headers = getallheaders();
$f = file_get_contents($_FILES['file']['tmp_name']);
$AUTH="3";
file_put_contents("dump.txt",$f,FILE_APPEND);
if(trim($headers["Authorization"])!=$AUTH) echo "UNAUTHORIZED";
$nonce = md5($headers["X-Nonce"]);
$intent = $headers["X-Intent"];
switch($intent){
	case "W":
	    file_put_contents("data/".$nonce.".csv",FILE_APPEND);
		break;
	case "C":
		rename("data/".$nonce.".csv","data/current.csv");
		processCsv();
		echo "OK";
		break;
	default:
		echo "UNKNOWN";
		break;
	}
