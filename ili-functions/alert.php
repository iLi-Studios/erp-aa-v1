<?php
// tirer le message depuis le lien sous la forme get si'il existe et l'affichier
function get_message($message){
	if(isset($_GET['message'])){
		message($_GET['message']);
	}
}
//alert notification
//$type "", "alert-success", "alert-info", "alert-error"  
function alert_notif($type, $message){
	echo'
		<div class="alert '.$type.'">
			<button class="close" data-dismiss="alert">×</button>
			'.$message.'
		</div>	
	';
}

function message($code){
	switch($code){
		case "1";
		alert_notif("", "Vous devez être connecté!");
		break;
		case "2";
		alert_notif("alert-error", "Combinaison incorrect!");
		break;
		case "3";
		alert_notif("alert-error", "Compte suspendue!");
		break;
		case "4";
		alert_notif("alert-success", "Vous êtes déconnecté");
		break;
		case "5";
		alert_notif("alert-error", "Vous pouvez pas voire cette page");
		break;
		case "6";
		alert_notif("alert-error", "ERREUR : Opération echoué!");
		break;
		case "7";
		alert_notif("alert-success", "OK : Opération effectuer avec succée!");
		break;
		case "8";
		alert_notif("alert-error", "ERREUR : Un utilisateur avec cette <strong>CIN</strong> exisite dans la base de données");
		break;
		case "9";
		alert_notif("alert-error", "ERREUR : Un utilisateur avec cette <strong>EMAIL</strong> exisite dans la base de données");
		break;
		case "10";
		alert_notif("alert-error", "ERREUR : Le mot de passe actuel saisi est incorrect");
		break;
		case "11";
		alert_notif("alert-error", "ERREUR : les deux nouveaux mots de passe sont incohérent");
		break;
		case "12";
		alert_notif("alert-success", "OK : Votre mot de passe a été changé avec succès!");
		break;
		case "13";
		alert_notif("alert-error", "Combinaison incorrect!<br> Vous avez essayé plus de 3 fois, <br>La connexion ne sera possible qu'après 30 min");
		break;
		case "14";
		alert_notif("alert-error", "ERREUR : Utilisateur non disponible ! ");
		break;
		case "15";
		alert_notif("alert-error", "ERREUR : Message non disponible ! ");
		break;
		case "16";
		alert_notif("alert-error", "ERREUR : Un utilistateur avec le même identificateur unique exsite déjà dans la base de données ! ");
		break;
		case "17";
		alert_notif("alert-error", "ERREUR : Vous avez pas l'autorisation necessaire pour acceder a cette section ! ");
		break;
		case "18";
		alert_notif("alert-error", "ERREUR : Client non disponible ! ");
		break;
		case "19";
		alert_notif("alert-error", "ERREUR : Fournisseur non disponible ! ");
		break;
		case "20";
		alert_notif("alert-error", "ERREUR : Raison sociale founisseur existe déjà ! ");
		break;
		case "21";
		alert_notif("alert-error", "ERREUR : Matricule fiscale founisseur existe déjà ! ");
		break;
		case "21";
		alert_notif("alert-error", "ERREUR : Registre de commerce founisseur existe déjà ! ");
		break;
		case "22";
		alert_notif("alert-error", "ERREUR : Artcile non disponible ! ");
		break;
		case "23";
		alert_notif("alert-error", "ERREUR : Unité article non disponible ! ");
		break;
		case "24";
		alert_notif("alert-error", "ERREUR : Famille article non disponible ! ");
		break;
		case "24";
		alert_notif("alert-error", "ERREUR : TVA article non disponible ! ");
		break;
		case "25";
		alert_notif("alert-error", "ERREUR : Un contrat avec le même numéro existe déjà dans la base de donneés!");
		break;
		}
	}
?>
