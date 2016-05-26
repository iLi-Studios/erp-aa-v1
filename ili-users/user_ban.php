<?php 
include"../ili-functions/functions.php";
function UserBan($idUser){
	$QueryUserBan="UPDATE users SET idRank='1' WHERE idUser='$idUser' ;";
	QueryExcute('', $QueryUserBan);
}
Authorization('2');
AuthorizedPrivileges('USERS', 'U');  
$idUser=$_GET['id'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
else{
	UserBan($idUser);
	$idUserSession = $_SESSION['user_id'];
	$UserUpdated=UserGetInfo($idUser);
	$UserUpdater=UserGetInfo($idUserSession);
	NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.' a banni '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
	LogWrite("Utilisateur : ".$user->idUser." a ete banni");
	Redirect('ili-users/user_edit?id='.$idUser);
}
?>