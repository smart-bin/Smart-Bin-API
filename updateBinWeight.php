<?php
include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";
include "bin.php";
include "pointObject.php";

if(isset($_POST["binId"]) && isset($_POST["newWeight"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	$id = $_POST["binId"];
	$weight = $_POST["newWeight"];
	
	echo EditBinWeight($id, $weight);
}