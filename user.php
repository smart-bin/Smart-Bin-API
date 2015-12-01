<?php
function makeUserFromRaw($userRaw, $type = "info")
{
	include "bintypes.php";
	include_once "bin.php";
	include_once "pointObject.php";
	
	$newUser = new Collection();
	$newUser->UserId = (int)$userRaw[0];
	
	if($type == "info" || $type == "full")
	{
		$newUser->Name = $userRaw[1];
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
			$newBin = makeBinFromRaw($binsRaw[$b]);
			array_push($newUser->Bins, $newBin);
		}
	}
	
	return $newUser;
}