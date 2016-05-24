<?php 
include"../ili-functions/functions.php";
function UserDrop($id){
	QueryExcute('', "DELETE FROM usersprivilege WHERE idUser='$id'");
	QueryExcute('', "DELETE FROM users WHERE idUser='$id'");
}
Authorization('2'); 
$id=$_GET['id'];
UserDrop($id);
NotifAllWrite($id, '', 'L`utilisateur avec CIN :'.$id.' a été supprimer');
LogWrite("Suppression de l`utilisateur avec CIN=".$id);
Refresh();
?>