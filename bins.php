<?php
include "databasefunctions.php";
include_once "bintypes.php";
include "bin.php";

if(isset($_POST["newBin"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	$data = $_POST["newBin"];
	
	$newOwner = isset($data["OwnerId"])? $data["OwnerId"] : ""; //TODO change from usercode -> bincode
	$newName = isset($data["Name"])? $data["Name"] : "";
	$newType = isset($data["Type"])? $data["Type"] : "";
	
	$success = true;
	$errors = [];
	
	if($newName == "")
	{
		array_push($errors, "Name not set");
		$success = false;
	}
	
	if($newOwner == "")
	{
		array_push($errors, "Owner not set");
		$success = false;
	}
	
	if($newType == "")
	{
		array_push($errors, "Type not set");
		$success = false;
	}
	
	if($success)
	{
		RegisterNewUser($newName, $newEmail, $newPassword);

		echo '{"success":"Bin successfully registered"}';
	}
	else
	{
		echo '{"errors":' . json_encode($errors) . '}';
	}
}
else
{
	$binsRaw = GetAllBins();
	
	if(!isset($_GET["id"]))
	{
		$users = [];
		
		for($i = 0; $i < count($binsRaw); $i++)
		{
			$newBin = makeBinFromRaw($binsRaw[$i]);
			
			array_push($users, $newBin);
		}

		echo json_encode($users);
	}
	else
	{
		for($i = 0; $i < count($binsRaw); $i++)
		{
			$newBin = makeBinFromRaw($binsRaw[$i]);
			
			if($newBin->BinId == $_GET["id"])
				echo json_encode($newBin);
		}
	}
}