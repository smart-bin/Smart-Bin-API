<?php

	class Collection{}

	function NavigateToPage($page)
	{
		header("Location: " . $page);
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $page . '">'; //failsafe
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
		$link = Connect();
	
		$sql = "UPDATE `bins` SET `currentWeight` = '$weight' WHERE `id` = '$id';";
		
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
	
	function AttemptLogin($email, $password)
	{
		StartSessionIfNeeded();
	
		$link = Connect();
	
		$result = mysqli_query($link, "SELECT * FROM `users` WHERE email='$email'");

		$user = mysqli_fetch_row($result);
		
		if($password == $user[3])
		{
			$_SESSION["currentUser"] = $user;
		}
		
		return $user;
	}
	
	function RegisterNewUser($username, $email, $password)
	{
		$success = false;
	
		$link  = Connect();
	
		$sql = "INSERT INTO `users` (name, email, password) VALUES ('$username', '$email', '$password')";

		$result = mysqli_query($link, "SELECT * FROM `users` WHERE email='$email'"); 
		
		$existingUser = mysqli_fetch_row($result);
		
		if($existingUser == null)
		{
			mysqli_query($link, $sql);
			
			//EmailAccountData();
			
			$success = true;
		}
		
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
		
		$result = mysqli_query($link, "SELECT * FROM `bins` WHERE `id`=$userId"); 
		
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
