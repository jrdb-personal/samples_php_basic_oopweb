<?php
include_once 'ow_classes.php';
$objConn = new Connection;
$pdoConn = $objConn->openConnection();
session_start();


$objUser = new User;
$objUser->setUserEmail($_SESSION['UserEmail']);
$objUser->setUserPassword($_SESSION['UserPassword']);

$objQBuilder = new QueryBuilder;
$query = $objQBuilder->buildQueryRead('tb_users', ['UserID', 'UserEmail', 'UserPassword'], ['UserEmail = ?', 'AND UserPassword = ?']);

$result = $objUser->getCurrentUser($pdoConn, $query, [$objUser->getUserEmail(), $objUser->getUserPassword()]);
$objUser->setUserID($result['UserID']);

if($result){
	$_SESSION['UserID'] = $result['UserID'];
	$_SESSION['UserEmail'] = $result['UserEmail'];
	$_SESSION['UserPassword'] = $result['UserPassword'];

	$query = $objQBuilder->buildQueryRead('tb_profiles', ['ProfilesID', 'UserID', 'UserFirstName', 'UserLastName', 'UserGender', 'UserBirthdate', 'UserDeliveryAddress', 'UserBillingAddress' ], ['UserID = ?']);

	$objProfile = new Profile;
	$result = $objProfile->getCurrentProfile($pdoConn, $query, [$objUser->getUserID()]);
}
/*
else{
	header("Location :index.php");
}
*/
?>






