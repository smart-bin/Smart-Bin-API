<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";
include "pointObject.php";

if(isset($_POST["userId"]) && isset($_POST["points"]) && isset($_POST["token"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	if($_POST["token"] !== $masterToken)
	{
		$errorMsg = ["Error" => "No or invalid access token given"];
		echo json_encode($errorMsg);
		return;
	}
	else
	{
		$id = $_POST["userId"];
		$points = $_POST["points"];
		
		$user = makeUserFromRaw(GetUser($id));
		
		$newPoints = new PointObject();
		
		$newPoints->Add($user->Points);
		$newPoints->AddFromArray($points);
		
		$user->Points = $newPoints;
		$user->Points->RemoveNegative();
		
		echo EditUserPoints($user->UserId, json_encode($user->Points));
	}
}
else
{
	$errorMsg = ["Error" => "Missing required parameters"];
	echo json_encode($errorMsg);
}