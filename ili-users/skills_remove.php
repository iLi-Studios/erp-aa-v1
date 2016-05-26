<?php 
include"../ili-functions/functions.php";
function UserQualificationDrop($idQualification){
	$Query="DELETE FROM `usersqualification` WHERE `idQualification`='$idQualification';";
	QueryExcute('', $Query);
}
Authorization('2'); 
$id_skills=$_GET['id_skills'];
$skills_name=$_GET['skills_name'];
$idUser=$_GET['idUser'];
UserQualificationDrop($id_skills);
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
else{
	$idUserSession = $_SESSION['user_id'];
	if($idUserSession==$idUser){
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.' a supprimé son compétance : '.$skills_name);
	}
	else{
		$UserUpdated=UserGetInfo($idUser);
		$UserUpdater=UserGetInfo($idUserSession);
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.' a supprimer la compétance : '.$skills_name.' de '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
	}
	LogWrite("Suppression du compétence : ".$skills_name." de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
	Refresh();
}
?>