<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include_once "bintypes.php";
include "bin.php";

if(isset($_POST["newStamp"])) //Imporant: Keep same variable names as set in 'function makeUser()' so users know what to set.
{
	$data = $_POST["newStamp"];
	
	$newId = isset($data["BinId"])? $data["BinId"] : "";
	$newWeight = isset($data["Weight"])? $data["Weight"] : "";
	$newTimestamp = isset($data["UnixTimestamp"])? $data["UnixTimestamp"] : "";
	
	$success = true;
	$errors = [];
	
	if($newId == "")
	{
		array_push($errors, "Bin ID not set");
		$success = false;
	}
	
	if($newWeight == "")
	{
		array_push($errors, "Weight not set");
		$success = false;
	}
	
	if($newTimestamp == "")
	{
		array_push($errors, "Timestamp not set");
		$success = false;
	}
	
	if($success)
	{
		RegisterNewHistory($newId, $newWeight, $newTimestamp);

		echo '{"success":"Stamp successfully registered"}';
	}
	else
	{
		echo '{"errors":' . json_encode($errors) . '}';
	}
}
else
{
	if(isset($_GET["id"]))
	{
		$histRaw = GetBinHistory($_GET["id"], isset($_GET["from"])? $_GET["from"] : 0, isset($_GET["to"])? $_GET["to"] : 0);
	
		$history = [];
		
		for($i = 0; $i < count($histRaw); $i++)
		{
			$newHist = new Collection();
			
			$newHist->BinID = (int)$histRaw[$i][1];
			$newHist->Weight = (int)$histRaw[$i][2];
			$newHist->UnixTimestamp = (int)$histRaw[$i][3];
			$newHist->Date = date("Y-m-d", $histRaw[$i][3]);
			$newHist->Time = date("H:i:s", $histRaw[$i][3]);
			
			array_push($history, $newHist);
		}

		echo json_encode($history);
	}
	else
	{
		echo json_encode(array("error" => "No id given"));
	}
}