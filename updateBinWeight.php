<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";
include "bin.php";
include "pointObject.php";

if(isset($_POST["binId"]) && isset($_POST["newWeight"]) && isset($_POST["token"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	$id = $_POST["binId"];
	$weight = $_POST["newWeight"];
	
	if($_POST["token"] == $masterToken)
	{
		echo EditBinWeight($id, $weight);
		echo json_encode("Success"=>"Weight updated successfully");
	}
	else
	{
		echo json_encode("Error"=>"Invalid token given");
	}
}
else
{
	echo json_encode("Error"=>"Missing Parameters. Required: (binId, newWeight, token)");
}