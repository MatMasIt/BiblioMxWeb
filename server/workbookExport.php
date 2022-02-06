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
