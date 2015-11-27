<?php
include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";

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
		RegisterNewUser($newName, $newEmail, $newPassword);

		echo '{"success":"User successfully registered"}';
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
			$newUser = makeUserFromRaw($usersRaw[$i]);
			
			array_push($users, $newUser);
		}

		echo json_encode($users);
	}
	else
	{
		for($i = 0; $i < count($usersRaw); $i++)
		{
			$newUser = makeUserFromRaw($usersRaw[$i]);
			
			if($newUser->UserId == $_GET["id"])
				echo json_encode($newUser);
		}
	}
}