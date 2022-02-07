<?php
require("vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
$spreadsheet = new Spreadsheet();
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();

$reader->setInputEncoding('CP1252');
$reader->setDelimiter(',');
$reader->setEnclosure('"');
$reader->setSheetIndex(0);


$spreadsheet = $reader->load("data/current.csv");
$writer = new Xlsx($spreadsheet);
$writer->save("data/current.xlsx");

$writer = new Ods($spreadsheet);
$writer->save("data/current.ods");

$spreadsheet->disconnectWorksheets();
unset($spreadsheet);

$db = new SQLite3(dirname(__FILE__)."/db");
$db->busyTimeout(5000);

$sql="";

$tables=$db->query("SELECT name FROM sqlite_master WHERE type ='table' AND name NOT LIKE 'sqlite_%';");

while ($table=$tables->fetchArray(SQLITE3_NUM)) {
	$sql.=$db->querySingle("SELECT sql FROM sqlite_master WHERE name = '{$table[0]}'").";\n\n";
	$rows=$db->query("SELECT * FROM {$table[0]}");
	$sql.="INSERT INTO {$table[0]} (";
	$columns=$db->query("PRAGMA table_info({$table[0]})");
	$fieldnames=array();
	while ($column=$columns->fetchArray(SQLITE3_ASSOC)) {
		$fieldnames[]=$column["name"];
	}
	$sql.=implode(",",$fieldnames).") VALUES";
	while ($row=$rows->fetchArray(SQLITE3_ASSOC)) {
		foreach ($row as $k=>$v) {
			$row[$k]="'".SQLite3::escapeString($v)."'";
		}
		$sql.="\n(".implode(",",$row)."),";
	}
	$sql=rtrim($sql,",").";\n\n";
}

file_put_contents("data/current.sql",$sql);
