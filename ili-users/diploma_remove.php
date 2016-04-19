<?php 
include"../ili-functions/functions.php";
Authorization('2'); 
UserDiplomaDrop($_GET['id_diploma']);
$idUser=$_GET['idUser'];
$diploma_name=$_GET['diploma_name'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', suppression du diplôme : '.$diploma_name);
LogWrite("Suppression du diplôme : ".$diploma_name.", de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
Refresh();
?>