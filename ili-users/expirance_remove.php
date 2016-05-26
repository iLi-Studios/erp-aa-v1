<?php 
include"../ili-functions/functions.php";
function UserExpiranceDrop($idExperience){
	$query="DELETE FROM `usersexperience` WHERE `idExperience`='$idExperience';";
	if(QueryExcute('', $query)){return 1;}
}
Authorization('2'); 
UserExpiranceDrop($_GET['id_expirance']);
$company=$_GET['Company'];
$idUser=$_GET['idUser'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
else{
	$idUserSession = $_SESSION['user_id'];
	if($idUserSession==$idUser){
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.' a supprimé expérance dans l`etablissement : '.$company);
	}
	else{
		$UserUpdated=UserGetInfo($idUser);
		$UserUpdater=UserGetInfo($idUserSession);
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.' a supprimer l`experiance dans l`etablissement : '.$company.' de '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
	}
	LogWrite("Suppression du l\'expérience : ".$company.", de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
	Redirect('ili-users/user_edit?id='.$idUser);
}
?>