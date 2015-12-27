<?php
header("Access-Control-Allow-Origin: *");
include "bintypes.php";

$lang = "en";
if(isset($_GET["lang"]))
	$lang = $_GET["lang"];
if(isset($_POST["lang"]))
	$lang = $_POST["lang"];

$returnVal = array();
$raw = allBinTypes($lang);

for($i = 0; $i < count($raw); $i++)
{
	array_push($returnVal, new BinTypeAndIDPair($i, $raw[$i]));
}
	
echo json_encode($returnVal);