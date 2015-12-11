<?php
header("Access-Control-Allow-Origin: *");

include "databasefunctions.php";
include_once "bintypes.php";
include "user.php";

$success = true;
$errors = [];
	
$email = isset($data["Email"])? $data["Email"] : "";
$password = isset($data["Password"])? $data["Password"] : "";

if($email == "")
{
	array_push($errors, "Email not set");
	$success = false;
}

if($password == "")
{
	array_push($errors, "Password not set");
	$success = false;
}

if($success)
{
	$result = Login($email, md5($password));
	
	if($result !== false)
	{
		$user = makeUserFromRaw($result, "full");
		$user->passwordHash = md5($password);
		echo json_encode($user);
	}
	else
		echo json_encode(array("Error"=>"Username or password incorrect"));
}
else
{
	echo '{"errors":' . json_encode($errors) . '}';
}