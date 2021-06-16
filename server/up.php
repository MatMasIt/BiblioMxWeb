<?php
require("processCsv.php");
function filterName($s){
	$arr=str_split($s);
	$fs="";
	$allowedChars=str_split("ABCDEFGHIJLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-");
	foreach($arr as $c){
		if(in_array($c,$allowedChars)) $fs.=$c;
	}
	return $fs;
}

$f=file("php://input");
$AUTH="xmeQCwqrQcSQ7TQX2Yyw";
if(trim($f[0])!=$AUTH) echo "UNAUTHORIZED";
$nonce=trim($f[1]);
$command=trim($f[2]);
switch($command){
	case "BEGIN":
		$files=glob("data/*.csv");
		array_diff($files,["data/current.csv"]);
		foreach($files as $ff){
			unlink($ff);
		}
		echo "BEGIN";
		break;
	case "WRITE":
		for($i=3;$i<count($f);$i++){
			file_put_contents("data/".filterName($nonce).".csv",$f[$i],FILE_APPEND);
		}
		echo "PROCEED";
		break;
	case "CONCLUDE":
		rename("data/".filterName($nonce).".csv","data/current.csv");
		processCsv();
		echo "OK";
		break;
	default:
		echo "UNKNOWN";
		break;
	}
