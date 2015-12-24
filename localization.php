<?php


function GetLocalized($stringName, $lang) //stringName corresponds to variable name in LocalizationBundle
{
	//build localization bundles here
	$En = new LocalizationBundle("en"); //default

	$Nl = new LocalizationBundle("nl");
	$Nl->binType_Waste = "Restafval";
	$Nl->binType_Plastic = "Plastic";
	$Nl->binType_Glass = "Glas";
	$Nl->binType_Organic = "GFT";
	$Nl->binType_Tin = "Blik";
	$Nl->binType_Paper = "Papier";
	$Nl->binType_Chemical = "Chemisch";
	
	switch($lang)
	{
		case "en":
			return $En->getString($stringName);
		break;
		case "nl":
			return $Nl->getString($stringName);
		break;
		default:
			//return "UNKNOWN_LANG " . $lang; //optional alternative
			return $En->getString($stringName);
		break;
	}
}

class LocalizationBundle
{
	var $language = "en";
	
	var $binType_Waste = "Waste";
	var $binType_Plastic = "Plastic";
	var $binType_Glass = "Glass";
	var $binType_Organic = "Organic";
	var $binType_Tin = "Tin";
	var $binType_Paper = "Paper";
	var $binType_Chemical = "Chemical";
	
	function __construct($lang)
	{
		$this->language = $lang;
	}
	
	function getString($keyToFind)
	{
		foreach($this as $key=> $value)
		{
			if($key === $keyToFind)
			{
				return $value;
			}
		}

		return "Localization_String_Not_Found";		
	}
}