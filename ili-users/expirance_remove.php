<?php 
include"../ili-functions/functions.php";
autorisation('2'); 
function remove($id){
	$query="DELETE FROM users_expirance WHERE id='$id';";
	if(query_execute("mysqli_fetch_object", $query)){return 1;}
}
remove($_GET['id_expirance']);
$company=$_GET['company'];
$id_user=$_GET['id_user'];
$user=get_user_info($id_user);
if($user==''){redirect('index?message=14');}
notif_all($id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$id_user.'">'.$user->nom.' '.$user->prenom.', suppression de l\'expérience dans l\'etablissement : '.$company);
write_log("Suppression du l\'expérience : ".$company.", de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id_user."\">".$id_user."</a>");
redirect('ili-users/user_edit?id='.$_GET['id_user']);
?>