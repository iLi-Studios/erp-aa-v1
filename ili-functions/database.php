<?php
//database manipulation
function QueryExcute($mysqli_result_type, $query){
	$link=mysqli_connect(MYSQL_SERVEUR, MYSQL_UTILISATEUR, MYSQL_MOTDEPASSE, MYSQL_BASE);
	//Vérification de la connexion
	if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
	}
	else{
		//correction de problémes des accents
		mysqli_query($link, "SET NAMES UTF8"); 
		//Execution de requêtte
		if ($result=mysqli_query($link, $query)){
			//Détermine le nombre de lignes du jeu de résultats
			if($mysqli_result_type){
				$sortie=$mysqli_result_type($result);
				return $sortie;
				//Fermer le jeu de résultats
				//mysqli_free_result($result);
			}
		}
		else{
			return $result='ERREUR : %s\n, '.mysqli_error();
			mysqli_close($link);
		}
		mysqli_close($link);
	}
}
//while ($sortie=mysqli_fetch_object($result)){}
function QueryExcuteWhile($query){
	$link=mysqli_connect(MYSQL_SERVEUR, MYSQL_UTILISATEUR, MYSQL_MOTDEPASSE, MYSQL_BASE);
	//Vérification de la connexion
	if (mysqli_connect_errno()) {
    	printf("Échec de la connexion : %s\n", mysqli_connect_error());
    	exit();
	}
	else{//correction de problémes des accents
		mysqli_query($link, "SET NAMES UTF8");
		if($result=mysqli_query($link, $query)){return $result;}
	}
}
?>