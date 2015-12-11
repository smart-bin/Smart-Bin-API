<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";
include "pointObject.php";

if(isset($_POST["userId"]) && isset($_POST["points"]) && isset($_POST["token"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	if(VerifyToken($_POST["userId"], $_POST["token"]))
	{
		$id = $_POST["userId"];
		$points = $_POST["points"];
		
		$user = makeUserFromRaw(GetUser($id));
		
		$newPoints = new PointObject();
		
		$newPoints->AddFromArray($points); //add points given by user (positive)
		
		if(!$user->Points->StillPositiveWhenSubtractingOther($newPoints))
		{
			echo json_encode(array("Error" => "User does not have the points required."));
		}
		else
		{
			$newPoints->Invert(); //Invert, so we get negative values
			$newPoints->RemovePositive(); //Remove all positive numbers, adding points is not allowed from this page
		
			$newPoints->Add($user->Points); //add the new existing points
			
			$user->Points = $newPoints;
			$user->Points->RemoveNegative(); //Make sure user doesn't have a negative balance. (Should NEVER happen)
			
			echo EditUserPoints($user->UserId, json_encode($user->Points));
		}
	}
	else
	{
		$errorMsg = ["Error" => "No or invalid access token given"];
		echo json_encode($errorMsg);
		return;
	}
}
else
{
	$errorMsg = ["Error" => "Missing required parameters"];
	echo json_encode($errorMsg);
}