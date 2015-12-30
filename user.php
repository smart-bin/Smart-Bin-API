<?php
function makeUserFromRaw($userRaw, $type = "info", $lang = "en")
{
	include_once "bintypes.php";
	include_once "bin.php";
	include_once "pointObject.php";
	
	$newUser = new Collection();
	$newUser->UserId = (int)$userRaw[0];
	
	$validTypes = ["info", "full", "points", "bins"];
	$valid = false;
	
	for($i = 0; $i < count($validTypes); $i++)
	{
		if($type == $validTypes[$i])
			$valid = true;
	}
	
	if(!$valid)
		$type = "info";
	
	if($type == "info" || $type == "full")
	{
		$newUser->Name = html_entity_decode($userRaw[1]);
		$newUser->Email = $userRaw[3];
	}
	
	if($type == "points" || $type == "full")	
	{
		if(json_decode($userRaw[4]) == null)
			$newUser->Points = new PointObject();
		else
			$newUser->Points = json_decode($userRaw[4]);
	}
	
	if($type == "bins" || $type == "full")
	{
		$newUser->Bins = [];
		
		$binsRaw = GetBinsFromUser($userRaw[0]);
		
		for($b = 0; $b < count($binsRaw); $b++)
		{
			$newBin = makeBinFromRaw($binsRaw[$b], $lang);
			array_push($newUser->Bins, $newBin);
		}
	}
	
	return $newUser;
}