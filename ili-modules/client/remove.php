<?php 
include"../../ili-functions/functions.php";
function ClientDrop($idClient, $O){
	$query="DELETE FROM `client` WHERE `idClient`='$idClient';";
	QueryExcute('', $query);
	$user_nom=$_SESSION['user_nom'];
	$user_prenom=$_SESSION['user_prenom'];
	NotifAllWrite('', '', '<a href="#">'.$user_nom.' '.$user_prenom.' a supprimé le client, '.$O->FamilyName.' '.$O->FirstName);
	LogWrite('Suppression de de client '.$O->FamilyName.' '.$O->FirstName);
	Redirect('ili-modules/client/liste');
}
Authorization('2');
AuthorizedPrivileges('CLIENTS', 'D'); 
$idClient=$_GET['id'];
$IfClientHasActivity=IfClientHasActivity($idClient);
if(!$IfClientHasActivity){
	$O=ClientGetInfo($idClient);
	if($O==''){Redirect('index?message=18');}
	else{ClientDrop($idClient, $O);}
}
else{Redirect('index?message=38');}
?>