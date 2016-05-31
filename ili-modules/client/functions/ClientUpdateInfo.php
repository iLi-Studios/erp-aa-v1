<?php
include"../../../ili-functions/functions.php";
if($_POST)
{
	//Récupération des variable depuis le lien
	$idClient		= $_GET['idClient'];
	$Notification	= $_GET['Notification'];
	$Log			= $_GET['Log'];
	$Form			= $_GET['Form'];
	
	//Récupération des varibales depuis la formulaire
	$input = $_POST['input'];
	
	//Exécution de requette
	QueryExcute("", "UPDATE `client` SET $Form = '$input' WHERE `idClient` = '$idClient';");
	
	//Récupération des variables pour le log & notification
	$idUser	=$_SESSION['user_id'];
	
	//Construction des objets pour le log & notification
	$User	=UserGetInfo($idUser);
	$Client	=ClientGetInfo($idClient);
	
	//Execution des fonctions
	NotifAllWrite('', '', '<a href="'.$URL.'ili-modules/client/client?id='.$idClient.'"><b>'.$User->FamilyName.' '.$User->FirstName.'</b> '.$Notification.' <b>'.$input.'</b>');
	LogWrite($Log.' '.$input);
}
?>