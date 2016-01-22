<?php

	class Collection{}
	$masterToken = "45f17b19ad5527e8bd6a0b749bf412ac";

	function NavigateToPage($page)
	{
		header("Location: " . $page);
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $page . '">'; //failsafe
	}
	
	function GetBinHistory($binId, $unixFrom = 0, $unixTo = 0)
	{
		$link = Connect();
		
		$sql = "SELECT * FROM `history` WHERE `binId`=$binId AND `unixStamp`>$unixFrom";
		
		if($unixTo > 0)
			$sql .= " AND `unixStamp`<$unixTo";
		
		$result = mysqli_query($link, $sql); 
		
		if($result === false)
			return null;
		
		$obj = mysqli_fetch_all($result); 

		Disconnect($link);
		
		return $obj;
	}
	
	function GetBundledBinHistory($binIds, $unixFrom = 0, $unixTo = 0)
	{
		$link = Connect();
		
		$idstring = "";
		
		for($i = 0; $i < count($binIds); $i++)
		{
			$more = ($i+1) < count($binIds);
			$idstring .= "`binId`=" . $binIds[$i] . ($more? " OR" : "");
		}
		
		$sql = "SELECT * FROM `history` WHERE (" . $idstring . ") AND `unixStamp`>$unixFrom";
		 
		if($unixTo > 0)
			$sql .= " AND `unixStamp`<$unixTo";
		
		$result = mysqli_query($link, $sql); 
		
		if($result === false)
			return null;
		
		$obj = mysqli_fetch_all($result); 

		Disconnect($link);
		
		return $obj;
	}
	
	function GetAllBinHistory($binId, $unixFrom = 0, $unixTo = 0)
	{
		$link = Connect();
		
		$sql = "SELECT * FROM `history` WHERE `unixStamp`>$unixFrom";
		
		if($unixTo > 0)
			$sql .= " AND `unixStamp`<$unixTo";
		
		$result = mysqli_query($link, $sql); 
		
		if($result === false)
			return null;
		
		$obj = mysqli_fetch_all($result); 

		Disconnect($link);
		
		return $obj;
	}

	function StartSessionIfNeeded()
	{
		$shouldStart = false;
		
		if ( php_sapi_name() !== 'cli' ) 
		{
			if ( version_compare(phpversion(), '5.4.0', '>=') ) 
			{
				$shouldStart = !(session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE);
			} 
			else 
			{
				$shouldStart = !(session_id() === '' ? FALSE : TRUE);
			}
		}
	
		if ($shouldStart) //No session active? Start one.
			session_start();
	}
	
	function Connect()
	{
		include "config.php";
		
		$link = mysqli_connect($serverName, $databaseUserName, $databasePassword, $databaseName); 
	
		if(!$link)
			die( "Lol database failed" . mysql_error($link) ); //Er ging iets mis, dump de database-error op het scherm
			
		return $link;
	}
	
	function Email($to, $from, $title, $message)
	{
		StartSessionIfNeeded();
		return mail($to, $title, $message, "From: " . $from);
	}
	
	function GetCharacter($id)
	{
		$link = Connect();
		
		$result = mysqli_query($link, "SELECT * FROM `characters` WHERE `id`=$id"); 
		
		$obj = mysqli_fetch_row($result); 

		Disconnect($link);
		
		return $obj;
	}
	
	function Disconnect($toDisconnect)
	{
		mysqli_close($toDisconnect); //sluit de link
	}
	
	function EditUserPoints($idToEdit, $newPoints)
	{
		$link = Connect();
	
		$sql = "UPDATE `users` SET `points` = '$newPoints' WHERE `id` = '$idToEdit';";
		
		mysqli_query($link, $sql);
		
		echo mysql_error();
	}
	
	function EditBinWeight($id, $weight)
	{
		include_once "exchangeRates.php";
		include_once "pointObject.php";
		include_once "bin.php";
		
		$binOld = makeBinFromRaw(GetBin($id), "en");
		$oldWeight = $binOld->CurrentWeight;
		$weightDiff = max(0, $weight - $oldWeight);
		
		$link = Connect();
		
		$time = time();
		
		$sql = "INSERT INTO `history` (binId, weight, unixStamp) VALUES ('$id', '$weight', '$time')";
		
		mysqli_query($link, $sql);
		
		$bin = GetBin($id);
		$typeId = (int)$bin[3];
		$typeName = binTypes($bin[3], "en");
		// award points
		
		$toAward = new PointObject();
		
		$points = array();
		
		switch($typeName)
		{
			case "Waste": 
				$toAward->Waste = $weightDiff * getExchangeRates()->waste; 
				break;
			case "Plastic": 
				$toAward->Plastic = $weightDiff * getExchangeRates()->plastic; 
				break;
			case "Glass": 
				$toAward->Glass = $weightDiff * getExchangeRates()->glass; 
				break;
			case "Organic": 
				$toAward->Organic = $weightDiff * getExchangeRates()->organic; 
				break;
			case "Tin": 
				$toAward->Tin = $weightDiff * getExchangeRates()->tin; 
				break;
			case "Paper": 
				$toAward->Paper = $weightDiff * getExchangeRates()->paper; 
				break;
			case "Chemical": 
				$toAward->Chemical = $weightDiff * getExchangeRates()->chemical; 
				break;
		}
		
		$userId = (int)$bin[1];
		$user = makeUserFromRaw(GetUser($userId), "full");
		
		$newPoints = new PointObject();
		
		$newPoints->Add($user->Points);
		$newPoints->Add($toAward);
		
		$user->Points = $newPoints;
		$user->Points->RemoveNegative();
		
		EditUserPoints($user->UserId, json_encode($user->Points));
		//
		
		return $toAward;
	}
	
	function EditBinCharge($idToEdit, $newCharge)
	{
		$link = Connect();
	
		$sql = "UPDATE `bins` SET `batteryCharge` = '$newCharge' WHERE `id` = '$idToEdit';";
		
		mysqli_query($link, $sql);
		
		echo mysql_error();
	}
	
	function EditUserData($idToEdit, $newName, $newEmail, $newPassword, $thenLogin = true)
	{
		$link = Connect();
	
		$sql = "UPDATE `users` SET `name` = '$newName', `email` = '$newEmail', `password` = '$newPassword' WHERE `id` = '$idToEdit';";
		
		mysqli_query($link, $sql);
		
		echo mysql_error();
		
		if($thenLogin)
			AttemptLogin($newName, $newPassword);
			
		Email($newEmail, "robot@timfalken.com", "DnD Account", "Your info has been edited! Your new name is: " . $newName . ", your password is: " . $newPassword . ". Check all other stuff online on http://www.timfalken.com/dnd/");
	}
	
	function VerifyToken($userId, $token)
	{
		StartSessionIfNeeded();
	
		$link = Connect();
	
		$result = mysqli_query($link, "SELECT * FROM `users` WHERE id='$userId'");

		$user = mysqli_fetch_row($result);
		
		if($token == $user[3])
		{
			return true;
		}
		
		return false;
	}
	
	function Login($email, $password)
	{
		StartSessionIfNeeded();
	
		$link = Connect();
	
		$result = mysqli_query($link, "SELECT * FROM `users` WHERE email='$email'");

		$user = mysqli_fetch_row($result);
		
		if($password == $user[3])
		{
			$_SESSION["currentUser"] = $user;
			return $user;
		}
		
		return false;
	}
	
	function RegisterNewUser($username, $email, $password)
	{
		$success = false;
	
		$link  = Connect();
		
		$username = htmlentities(strip_tags($username), ENT_QUOTES);
			
		$sql = "INSERT INTO `users` (name, email, password) VALUES ('$username', '$email', '$password')";

		$result = mysqli_query($link, "SELECT * FROM `users` WHERE email='$email'"); 
		
		$existingUser = mysqli_fetch_row($result);
		
		if($existingUser == null)
		{
			mysqli_query($link, $sql);
			
			$result = mysqli_query($link, "SELECT * FROM `users` WHERE email='$email'"); 
		
			$success = mysqli_fetch_row($result);
		}
		
		Disconnect($link);
		
		return $success;
	}
	
	function RegisterNewBin($ownerId, $name, $type)
	{
		$success = false;
	
		$link  = Connect();
		
		$name = htmlentities(strip_tags($name), ENT_QUOTES);
		
		$sql = "INSERT INTO `bins` (ownerId, name, type, batteryCharge) VALUES ('$ownerId', '$name', '$type', '100')";

		mysqli_query($link, $sql);
		
		$result = mysqli_query($link, "SELECT max(id) FROM `bins`"); 
		$result = mysqli_fetch_row($result)[0];
		$result = mysqli_query($link, "SELECT * FROM `bins` WHERE id='$result'"); 
		
		Disconnect($link);
		
		return mysqli_fetch_row($result);
	}
	
	function RegisterNewHistory($binId, $weight, $time)
	{
		$success = false;
	
		$link  = Connect();
	
		$sql = "INSERT INTO `history` (binId, weight, unixStamp) VALUES ('$binId', '$weight', '$time')";

		mysqli_query($link, $sql);
		
		Disconnect($link);
		
		return $success;
	}
	
	function DeleteCharacter($id)
	{
		$link  = Connect();
	
		$sql = "DELETE FROM `characters` WHERE `id` = $id";

		mysqli_query($link, $sql);
			
		Disconnect($link);
	}
	
	function GetBinsFromUser($userId)
	{
		$link = Connect();
		
		$result = mysqli_query($link, "SELECT * FROM `bins` WHERE `ownerId`=$userId"); 
		
		$obj = mysqli_fetch_all($result); 

		Disconnect($link);
		
		return $obj;
	}
	
	function GetAllBins()
	{
		$link = Connect();
		
		$result = mysqli_query($link, "SELECT * FROM `bins`"); 
		
		$obj = mysqli_fetch_all($result); 

		Disconnect($link);
		
		return $obj;
	}
	
	function GetBin($binId)
	{
		$link = Connect();
		
		$result = mysqli_query($link, "SELECT * FROM `bins` WHERE `id`=$binId"); 
		
		$obj = mysqli_fetch_row($result); 

		Disconnect($link);
		
		return $obj;
	}
	
	function GetUser($id)
	{
		$link = Connect();
		
		$result = mysqli_query($link, "SELECT * FROM `users` WHERE `id`='$id'"); 
		
		if (false === $result)  //als de query misgaat;
		{
			die ('Error: ' . mysqli_error($link)); //Er ging iets mis, dump de database-error op het scherm
		}
		else
		{
			$results = mysqli_fetch_row($result); //haal alle rijen uit het query-result object
		}
		
		Disconnect($link);
		
		return $results;
	}
	
	function GetAllUsers()
	{
		$link = Connect();
		
		$result = mysqli_query($link, "SELECT * FROM `users`"); 
		
		if (false === $result)  //als de query misgaat;
		{
			die ('Error: ' . mysqli_error($link)); //Er ging iets mis, dump de database-error op het scherm
		}
		else
		{
			$results = mysqli_fetch_all($result); //haal alle rijen uit het query-result object
		}
		
		Disconnect($link);
		
		return $results;
	}
?>
