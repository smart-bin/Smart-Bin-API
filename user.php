<?php
function makeUserFromRaw($userRaw)
{
	include "bintypes.php";
	
	$newUser = new Collection();
	$newUser->UserId = $userRaw[0];
	$newUser->Name = $userRaw[1];
	$newUser->Email = $userRaw[3];
	$newUser->Points = json_decode($userRaw[4]);
	$newUser->Bins = [];
	
	$binsRaw = GetBinsFromUser($userRaw[0]);
	
	for($b = 0; $b < count($binsRaw); $b++)
	{
		$newBin = new Collection();
		$newBin->Name = $binsRaw[$b][2];
		$newBin->Type = $binTypes[$binsRaw[$b][3]];
		$newBin->CurrentWeightInKG = $binsRaw[$b][4];
		$newBin->LastEmptied = $binsRaw[$b][5];
		array_push($newUser->Bins, $newBin);
	}
	
	return $newUser;
}