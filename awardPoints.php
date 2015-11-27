<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";
include "pointObject.php";

if(isset($_POST["userId"]) && isset($_POST["points"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
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