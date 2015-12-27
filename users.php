<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include "user.php";

$lang = "en";
if(isset($_GET["lang"]))
	$lang = $_GET["lang"];
if(isset($_POST["lang"]))
	$lang = $_POST["lang"];

if(isset($_POST["newUser"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	$data = $_POST["newUser"];
	
	$newName = isset($data["Name"])? $data["Name"] : "";
	$newEmail = isset($data["Email"])? $data["Email"] : "";
	$newPassword = isset($data["Password"])? $data["Password"] : "";
	
	$success = true;
	$errors = [];
	
	if($newName == "")
	{
		array_push($errors, "Username not set");
		$success = false;
	}
	
	if($newEmail == "")
	{
		array_push($errors, "Email not set");
		$success = false;
	}
	
	if($newPassword == "")
	{
		array_push($errors, "Password not set");
		$success = false;
	}
	
	if($success)
	{
		$result = RegisterNewUser($newName, $newEmail, md5($newPassword));
		
		if($result !== false)
			echo json_encode(makeUserFromRaw($result, "info", $lang));
		else
			echo json_encode(array("Error"=>"User with this email already exists"));
	}
	else
	{
		echo '{"errors":' . json_encode($errors) . '}';
	}
}
else
{
	$usersRaw = GetAllUsers();
	
	if(!isset($_GET["id"]))
	{
		$users = [];
		
		for($i = 0; $i < count($usersRaw); $i++)
		{
			if(isset($_GET['type']))
				$newUser = makeUserFromRaw($usersRaw[$i], $_GET['type'], $lang);
			else
				$newUser = makeUserFromRaw($usersRaw[$i], "info", $lang);
			
			array_push($users, $newUser);
		}

		echo json_encode($users);
	}
	else
	{
		for($i = 0; $i < count($usersRaw); $i++)
		{
			if(isset($_GET['type']))
				$newUser = makeUserFromRaw($usersRaw[$i], $_GET['type'], $lang);
			else
				$newUser = makeUserFromRaw($usersRaw[$i], "info", $lang);
			
			if($newUser->UserId == $_GET["id"])
				echo json_encode($newUser);
		}
	}
}