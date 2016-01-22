<?php

function getExchangeRates()
{
	$returnObj = new stdClass();
	
	$returnObj->waste = 1;
	$returnObj->plastic = 2;
	$returnObj->glass = 0.95;
	$returnObj->organic = 1.3;
	$returnObj->tin = 1.4;
	$returnObj->paper = 2.8;
	$returnObj->chemical = 3;
	
	return $returnObj;
}