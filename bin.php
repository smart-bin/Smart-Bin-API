<?php
function makeBinFromRaw($binRaw, $lang = "en")
{
	include_once "bintypes.php";
	include_once "databasefunctions.php";
	
	$newBin = new Collection();
	$newBin->BinId = (int)$binRaw[0];
	$newBin->OwnerId = (int)$binRaw[1];
	$newBin->Name = html_entity_decode($binRaw[2], ENT_QUOTES);
	$newBin->Type = new BinTypeAndIDPair((int)$binRaw[3], binTypes($binRaw[3], $lang));
	$newBin->BatteryLevel = (float)$binRaw[4];
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