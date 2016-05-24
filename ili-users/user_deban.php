<?php 
include"../ili-functions/functions.php";
function UserDeban($idUser){
	$QueryUserDeban="UPDATE users SET idRank='2' WHERE idUser='$idUser' ;";
	QueryExcute('', $QueryUserDeban);
}
Authorization('2'); 
$idUser=$_GET['id'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
UserDeban($idUser);
NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', a été débanni');
LogWrite("Utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a> a été <strong>débanni</strong>");
Refresh();
?>