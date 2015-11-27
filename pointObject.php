<?php

class PointObject
{
	var $Plastic = 0;
	var $Glass = 0;
	var $Biological = 0;
	var $Tin = 0;
	var $Paper = 0;
	var $Chemical = 0;
	
	function RemoveNegative()
	{
		if($this->Plastic < 0)
			$this->Plastic = 0;
			
		if($this->Glass < 0)
			$this->Glass = 0;
			
		if($this->Biological < 0)
			$this->Biological = 0;
			
		if($this->Tin < 0)
			$this->Tin = 0;
			
		if($this->Paper < 0)
			$this->Paper = 0;
			
		if($this->Chemical < 0)
			$this->Chemical = 0;
	}
	
	function Add($other)
	{
		if(isset($other->Plastic))
			$this->Plastic += (float)$other->Plastic;
		
		if(isset($other->Glass))
			$this->Glass += (float)$other->Glass;
		
		if(isset($other->Biological))
			$this->Biological += (float)$other->Biological;
		
		if(isset($other->Tin))
			$this->Tin += (float)$other->Tin;
			
		if(isset($other->Paper))
			$this->Paper += (float)$other->Paper;
			
		if(isset($other->Chemical))
			$this->Chemical += (float)$other->Chemical;
	}
	
	function AddFromArray($other)
	{
		if(isset($other["Plastic"]))
			$this->Plastic += (float)$other["Plastic"];
		
		if(isset($other["Glass"]))
			$this->Glass += (float)$other["Glass"];
		
		if(isset($other["Biological"]))
			$this->Biological += (float)$other["Biological"];
		
		if(isset($other["Tin"]))
			$this->Tin += (float)$other["Tin"];
			
		if(isset($other["Paper"]))
			$this->Paper += (float)$other["Paper"];
			
		if(isset($other["Chemical"]))
			$this->Chemical += (float)$other["Chemical"];
	}
}