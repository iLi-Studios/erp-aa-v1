<?php
function AletWrite($type, $message){
	//$type "", "alert-success", "alert-info", "alert-error" 
	echo'
		<div class="alert '.$type.'">
			<button class="close" data-dismiss="alert">×</button>
			'.$message.'
		</div>	
	';
}

function AlertGet($code){
	switch($code){
		case "1";AletWrite("", "Vous devez être connecté!");break;
		case "2";AletWrite("alert-error", "Combinaison incorrect!");break;
		case "3";AletWrite("alert-error", "Compte suspendue!");break;
		case "4";AletWrite("alert-success", "Vous êtes déconnecté");break;
		case "5";AletWrite("alert-error", "Vous pouvez pas voire cette page");break;
		case "6";AletWrite("alert-error", "ERREUR : Opération echoué!");break;
		case "7";AletWrite("alert-success", "OK : Opération effectuer avec succée!");break;
		case "8";AletWrite("alert-error", "ERREUR : Un utilisateur avec cette <strong>CIN</strong> exisite dans la base de données");break;
		case "9";AletWrite("alert-error", "ERREUR : Un utilisateur avec cette <strong>EMAIL</strong> exisite dans la base de données");break;
		case "10";AletWrite("alert-error", "ERREUR : Le mot de passe actuel est saisi incorrectement");break;
		case "11";AletWrite("alert-error", "ERREUR : les deux nouveaux mots de passe sont incohérent");break;
		case "12";AletWrite("alert-success", "OK : Votre mot de passe a été changé avec succès!");break;
		case "13";AletWrite("alert-error", "Combinaison incorrect!<br> Vous avez essayé plus de 3 fois, <br>La connexion ne sera possible qu'après 30 min");break;
		case "14";AletWrite("alert-error", "ERREUR : Utilisateur non disponible ! ");break;
		case "15";AletWrite("alert-error", "ERREUR : Message non disponible ! ");break;
		case "16";AletWrite("alert-error", "ERREUR : Un utilistateur avec le même identificateur unique exsite déjà dans la base de données ! ");break;
		case "17";AletWrite("alert-error", "ERREUR : Vous avez pas l'autorisation necessaire pour acceder a cette section ! ");break;
		case "18";AletWrite("alert-error", "ERREUR : Client non disponible ! ");break;
		case "19";AletWrite("alert-error", "ERREUR : Fournisseur non disponible ! ");break;
		case "20";AletWrite("alert-error", "ERREUR : Raison sociale founisseur existe déjà ! ");break;
		case "21";AletWrite("alert-error", "ERREUR : Matricule fiscale founisseur existe déjà ! ");break;
		case "21";AletWrite("alert-error", "ERREUR : Registre de commerce founisseur existe déjà ! ");break;
		case "22";AletWrite("alert-error", "ERREUR : Artcile non disponible ! ");break;
		case "23";AletWrite("alert-error", "ERREUR : Unité article non disponible ! ");break;
		case "24";AletWrite("alert-error", "ERREUR : Famille article non disponible ! ");break;
		case "24";AletWrite("alert-error", "ERREUR : TVA article non disponible ! ");break;
		case "25";AletWrite("alert-error", "ERREUR : Un contrat avec le même numéro existe déjà dans la base de donneés!");break;
		case "26";AletWrite("alert-error", "ERREUR : INSERTION CONTRACT CYCLE");break;
		case "27";AletWrite("alert-error", "ERREUR : RECUPERATION ID PAYMENT");break;
		case "28";AletWrite("alert-error", "ERREUR : INSERTION PAYMENT");break;
		case "29";AletWrite("alert-error", "ERREUR : INSERTION CONTRAT");break;
		case "30";AletWrite("alert-error", "ERREUR : Contrat non disponible ! ");break;
		case "31";AletWrite("alert-error", "ERREUR : INSERTION CONTRACT CYCLE !");break;
		case "32";AletWrite("alert-error", "ERREUR : INSERTION PAYMENT ! ");break;
		case "33";AletWrite("alert-error", "ERREUR : CONTRAT NON RENOUVELABLE ! ");break;
		case "34";AletWrite("alert-error", "ERREUR : CHEQUE NON DISPONIBLE! ");break;
		case "35";AletWrite("alert-error", "ERREUR : PAIEMENT NON DISPONIBLE ! ");break;
		case "36";AletWrite("alert-success", "OK : Pour applique ce changement, l'utilisateur doit déconnecté puis reconnecté!");break;
		case "38";AletWrite("alert-error", "ERREUR : Vous pouvez pas supprimer un client qui à des activités dans le système ! ");break;
		case "39";AletWrite("alert-error", "ERREUR : Vous pouvez pas supprimer un opérateur qui à des activités dans le système ! ");break;
		
		
		case "37";AletWrite("alert-success", "OK : Opération effectuer avec succée! Vous devez vous déconnecter pour appliquer les modifications!");}
	}
?>
