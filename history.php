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
	if(isset($_GET["id"]) && !is_array($_GET["id"]))
	{
		$histRaw = GetBinHistory($_GET["id"], isset($_GET["from"])? $_GET["from"] : 0, isset($_GET["to"])? $_GET["to"] : 0);
	
		$history = [];
		
		$returnObject = new Collection();
		
		for($i = 0; $i < count($histRaw); $i++)
		{
			$newHist = new Collection();
			
			$newHist->BinId = (int)$histRaw[$i][1];
			$newHist->Weight = (int)$histRaw[$i][2];
			$newHist->UnixTimestamp = (int)$histRaw[$i][3];
			$newHist->Date = date("Y-m-d", $histRaw[$i][3]);
			$newHist->Time = date("H:i:s", $histRaw[$i][3]);
			
			array_push($history, $newHist);
		}
		
		$returnObject->BinId = (int)$_GET["id"];
		$returnObject->History = $history;
		
		echo json_encode($returnObject);
	}
	else
	{
		if(isset($_GET["id"]) && is_array($_GET["id"]))
			$histRaw = GetBundledBinHistory($_GET["id"], isset($_GET["from"])? $_GET["from"] : 0, isset($_GET["to"])? $_GET["to"] : 0);
		else
			$histRaw = GetAllBinHistory(isset($_GET["from"])? $_GET["from"] : 0, isset($_GET["to"])? $_GET["to"] : 0);
	
		$history = [];
		
		$returnObject = new Collection();
		$returnObject->BinHistories = array();
		
		for($i = 0; $i < count($histRaw); $i++)
		{	
			$newHist = new Collection();
			
			$newHist->BinId = (int)$histRaw[$i][1];
			$newHist->Weight = (int)$histRaw[$i][2];
			$newHist->UnixTimestamp = (int)$histRaw[$i][3];
			$newHist->Date = date("Y-m-d", $histRaw[$i][3]);
			$newHist->Time = date("H:i:s", $histRaw[$i][3]);
			
			$makeNew = true;
			
			for($h = 0; $h < count($returnObject->BinHistories); $h++)
			{
				if($returnObject->BinHistories[$h]->BinId == (int)$histRaw[$i][1])
				{
					$makeNew = false;
					array_push($returnObject->BinHistories[$h]->History, $newHist);
				}
			}
			
			if($makeNew)
			{
				$newHistContainer = new Collection();
				$newHistContainer->BinId = (int)$histRaw[$i][1];
				$newHistContainer->History = [$newHist];
				
				array_push($returnObject->BinHistories, $newHistContainer);
			}
		}
		
		$returnObject->UnixFrom = isset($_GET["from"])? $_GET["from"] : 0;
		$returnObject->UnixTo = isset($_GET["to"])? $_GET["to"] : 0;
		
		if(isset($_GET["id"]) && is_array($_GET["id"]))
		{
			$returnObject->IdsRequested = array();
			
			for($i = 0; $i < count($_GET["id"]); $i++)
			array_push($returnObject->IdsRequested, (int)$_GET["id"][$i]);
		}
		
		echo json_encode($returnObject);
	}
}