<?php 
include"../ili-functions/functions.php";
function UserBan($idUser){
	$QueryUserBan="UPDATE users SET idRank='1' WHERE idUser='$idUser' ;";
	QueryExcute('', $QueryUserBan);
}
Authorization('2'); 
$idUser=$_GET['id'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
UserBan($idUser);
NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', a été banni');
LogWrite("Utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a> a été <strong>banni</strong>");
Refresh();
?>