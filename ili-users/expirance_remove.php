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
NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', suppression de l`expérience dans l`etablissement : '.$company);
LogWrite("Suppression du l\'expérience : ".$company.", de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
Refresh();
?>