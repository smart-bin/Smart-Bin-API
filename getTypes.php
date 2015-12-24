<?php
header("Access-Control-Allow-Origin: *");
include "bintypes.php";

$lang = "en";
if(isset($_GET["lang"]))
	$lang = $_GET["lang"];
if(isset($_POST["lang"]))
	$lang = $_POST["lang"];

echo json_encode(allBinTypes($lang));