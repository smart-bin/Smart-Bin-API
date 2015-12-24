<?php
include "localization.php";
//WARNING
//Never use these as key values, as they are translated
//according to user preferences. Always use their integer ID.

function binTypes($id, $lang = "en")
{
	return allBinTypes($lang)[$id];
}

function allBinTypes($lang)
{
	if(!isset($lang) || $lang == "")
		$lang = "en";
	
	return [
	GetLocalized("binType_Waste", $lang),
	GetLocalized("binType_Plastic", $lang),
	GetLocalized("binType_Glass", $lang),
	GetLocalized("binType_Organic", $lang),
	GetLocalized("binType_Tin", $lang),
	GetLocalized("binType_Paper", $lang),
	GetLocalized("binType_Chemical", $lang)
	];
}