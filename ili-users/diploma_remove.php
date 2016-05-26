<?php 
include"../ili-functions/functions.php";
function UserDiplomaDrop($idDiploma){
	$query="DELETE FROM `usersdiploma` WHERE `idDiploma`='$idDiploma';";
	if(QueryExcute('', $query)){return 1;}
}
Authorization('2'); 
UserDiplomaDrop($_GET['id_diploma']);
$idUser=$_GET['idUser'];
$diploma_name=$_GET['diploma_name'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
else{
	$idUserSession = $_SESSION['user_id'];
	if($idUserSession==$idUser){
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.' a supprimé son diplôme : '.$diploma_name);
	}
	else{
		$UserUpdated=UserGetInfo($idUser);
		$UserUpdater=UserGetInfo($idUserSession);
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.' a supprimer le diplôme : '.$diploma_name.' de '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
	}	
	LogWrite("Suppression du diplome : ".$diploma_name.", de l\'utilisateur : ".$idUser);
	Redirect('ili-users/user_edit?id='.$idUser);
}
?>