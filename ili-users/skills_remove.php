<?php 
include"../ili-functions/functions.php";
autorisation('2'); 
function remove($id){
	$query="DELETE FROM users_skills WHERE id='$id';";
	query_execute_insert($query);
}
$id_skills=$_GET['id_skills'];
$skills_name=$_GET['skills_name'];
$id_user=$_GET['id_user'];
remove($id_skills);
$user=get_user_info($id_user);
if($user==''){redirect('index?message=14');}
notif_all($id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$id_user.'">'.$user->nom.' '.$user->prenom.', suppression de compétance : '.$skills_name);
write_log("Suppression du compétence : ".$skills_name." de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id_user."\">".$id_user."</a>");
redirect('ili-users/user_edit?id='.$id_user);
?>