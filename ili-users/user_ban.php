<?php 
include"../ili-functions/functions.php";
autorisation('2'); 
function ban($id){
	$query="UPDATE users SET id_rank='1' WHERE id_user='$id' ;";
	query_execute_insert($query);
}
$id_user=$_GET['id'];
$user=get_user_info($id_user);
if($user==''){redirect('index?message=14');}
ban($id_user);
notif_all($id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$id_user.'">'.$user->nom.' '.$user->prenom.', a été banni');
write_log("Utilisateur : <a href=\"ili-users/user_profil?id=".$id_user."\">".$id_user."</a> a été <strong>banni</strong>");
redirect('ili-users/users');
?>