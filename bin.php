<?php
function makeBinFromRaw($binRaw)
{
	include "bintypes.php";
	
	$newBin = new Collection();
	$newBin->BinId = $binRaw[0];
	$newBin->OwnerId = $binRaw[1];
	$newBin->Name = $binRaw[2];
	$newBin->Type = $binTypes[$binRaw[3]];
	$newBin->CurrentWeight = $binRaw[4];
	$newBin->LastEmptiedDate = $binRaw[5];
	
	return $newBin;
}