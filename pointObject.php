<?php

class PointObject
{
	var $Waste = 0;
	var $Plastic = 0;
	var $Glass = 0;
	var $Organic = 0;
	var $Tin = 0;
	var $Paper = 0;
	var $Chemical = 0;
	
	function Invert()
	{
		$this->Waste *= -1;		
		$this->Plastic *= -1;
		$this->Glass *= -1;
		$this->Organic *= -1;
		$this->Tin *= -1;
		$this->Paper *= -1;
		$this->Chemical *= -1;
	}
	
	function StillPositiveWhenSubtractingOther($other)
	{
		if($this->Waste < $other->Waste)
			return false;
			
		if($this->Plastic < $other->Plastic)
			return false;
			
		if($this->Glass < $other->Glass)
			return false;
			
		if($this->Organic < $other->Organic)
			return false;
			
		if($this->Tin < $other->Tin)
			return false;
			
		if($this->Paper < $other->Paper)
			return false;
			
		if($this->Chemical < $other->Chemical)
			return false;
			
		return true;
	}
	
	function RemoveNegative()
	{
		if($this->Waste < 0)
			$this->Waste = 0;
			
		if($this->Plastic < 0)
			$this->Plastic = 0;
			
		if($this->Glass < 0)
			$this->Glass = 0;
			
		if($this->Organic < 0)
			$this->Organic = 0;
			
		if($this->Tin < 0)
			$this->Tin = 0;
			
		if($this->Paper < 0)
			$this->Paper = 0;
			
		if($this->Chemical < 0)
			$this->Chemical = 0;
	}
	
	function RemovePositive()
	{
		if($this->Waste > 0)
			$this->Waste = 0;
			
		if($this->Plastic > 0)
			$this->Plastic = 0;
			
		if($this->Glass > 0)
			$this->Glass = 0;
			
		if($this->Organic > 0)
			$this->Organic = 0;
			
		if($this->Tin > 0)
			$this->Tin = 0;
			
		if($this->Paper > 0)
			$this->Paper = 0;
			
		if($this->Chemical > 0)
			$this->Chemical = 0;
	}
	
	function Add($other)
	{
		if(isset($other->Waste))
			$this->Waste += (float)$other->Waste;
	
		if(isset($other->Plastic))
			$this->Plastic += (float)$other->Plastic;
		
		if(isset($other->Glass))
			$this->Glass += (float)$other->Glass;
		
		if(isset($other->Organic))
			$this->Organic += (float)$other->Organic;
		
		if(isset($other->Tin))
			$this->Tin += (float)$other->Tin;
			
		if(isset($other->Paper))
			$this->Paper += (float)$other->Paper;
			
		if(isset($other->Chemical))
			$this->Chemical += (float)$other->Chemical;
	}
	
	function AddFromArray($other)
	{
		if(isset($other["Waste"]))
			$this->Waste += (float)$other["Waste"];
	
		if(isset($other["Plastic"]))
			$this->Plastic += (float)$other["Plastic"];
		
		if(isset($other["Glass"]))
			$this->Glass += (float)$other["Glass"];
		
		if(isset($other["Organic"]))
			$this->Organic += (float)$other["Organic"];
		
		if(isset($other["Tin"]))
			$this->Tin += (float)$other["Tin"];
			
		if(isset($other["Paper"]))
			$this->Paper += (float)$other["Paper"];
			
		if(isset($other["Chemical"]))
			$this->Chemical += (float)$other["Chemical"];
	}
}