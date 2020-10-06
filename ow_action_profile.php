<?php
include_once 'ow_classes.php';
$objConn = new Connection;
$pdoConn = $objConn->openConnection();
session_start();

	if(isset($_POST['saveProfile'])){
		$objUser = new User;
	
		$objUser->setFirstName($_POST['firstname']);
		$objUser->setLastName($_POST['lastname']);
		$objUser->setBirthdate($_POST['birthdate']);
		$objUser->setBirthdate($_POST['gender']);
		$objUser->setAddress($_POST['address']);
		$objUser->setUserID($_SESSION['UserID']);

	
		//short version for passing member variables from $_POST
		$objUser->setProfileMembers($_POST['firstname'],$_POST['lastname'], $_POST['birthdate'], $_POST['address'], $_SESSION['UserID']);


		$objUser->updateProfile($pdoConn);
	}

	else{

	}

	/*
	$objUser = new User;
	echo $objUser->buildQueryUpdate('tb_users', ['FirstName', 'LastName', 'Birthdate', 'Address'], "UserID");
	*/
?>