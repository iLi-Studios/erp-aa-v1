<?php 
include"../ili-functions/functions.php";
Authorization('2'); 
$id_skills=$_GET['id_skills'];
$skills_name=$_GET['skills_name'];
$idUser=$_GET['idUser'];
UserQualificationDrop($id_skills);
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', suppression de compétance : '.$skills_name);
LogWrite("Suppression du compétence : ".$skills_name." de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
Refresh();
?>