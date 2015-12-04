<?php
function makeBinFromRaw($binRaw)
{
	include "bintypes.php";
	include_once "databasefunctions.php";
	
	$newBin = new Collection();
	$newBin->BinId = (int)$binRaw[0];
	$newBin->OwnerId = (int)$binRaw[1];
	$newBin->Name = $binRaw[2];
	$newBin->Type = $binTypes[$binRaw[3]];
	$newBin->ImageUrl = $binRaw[4];
	$newBin->BatteryLevel = (float)$binRaw[5];
	$newBin->CurrentWeight = 0;
	
	$history = GetBinHistory((int)$binRaw[0]);
	$highest = 0;
	
	for($i = 0; $i < count($history); $i++)
	{
		if($history[$i][3] > $highest)
		{
			$highest = $history[$i][3];
			$newBin->CurrentWeight = (int)$history[$i][2];
		}
	}
	
	return $newBin;
}