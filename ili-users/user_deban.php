<?php 
include"../ili-functions/functions.php";
function UserDeban($idUser){
	$QueryUserDeban="UPDATE users SET idRank='2' WHERE idUser='$idUser' ;";
	QueryExcute('', $QueryUserDeban);
}
Authorization('2');
AuthorizedPrivileges('USERS', 'U'); 
$idUser=$_GET['id'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
else{
	UserDeban($idUser);
	$idUserSession = $_SESSION['user_id'];
	$UserUpdated=UserGetInfo($idUser);
	$UserUpdater=UserGetInfo($idUserSession);
	NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.' a banni '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
	LogWrite("Utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a> a été <strong>débanni</strong>");
	Redirect('ili-users/user_edit?id='.$idUser);
}
?>