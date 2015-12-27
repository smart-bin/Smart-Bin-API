<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include "bin.php";

$lang = "en";
if(isset($_GET["lang"]))
	$lang = $_GET["lang"];
if(isset($_POST["lang"]))
	$lang = $_POST["lang"];

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
		RegisterNewBin($newOwner, $newName, $newType);
		
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
		$bins = [];
		
		for($i = 0; $i < count($binsRaw); $i++)
		{
			$newBin = makeBinFromRaw($binsRaw[$i], $lang);
				
			array_push($bins, $newBin);
		}

		echo json_encode($bins);
	}
	else
	{
		for($i = 0; $i < count($binsRaw); $i++)
		{
			$newBin = makeBinFromRaw($binsRaw[$i], $lang);
			
			if($newBin->BinId == $_GET["id"])
				echo json_encode($newBin);
		}
	}
}