<?php
include"../functions.php";
function MessageGetSumHeader(){
	$idUser=$_SESSION['user_id'];
	$q1="SELECT COUNT(*) FROM `message` WHERE `ToUser`='$idUser' AND `Seen`='0';";
	$q2="SELECT COUNT(*) FROM `message`, `discussion`
			WHERE
			(`message`.`ToUser`='$idUser' OR `message`.`FromUser`='$idUser' )
             AND
			`discussion`.`ToUser`='$idUser'
			AND 
			`message`.`Seen`='1'
			AND
			`discussion`.`idMessage`=`message`.`idMessage`
			AND
			`discussion`.`ToUser`='$idUser'
			AND
			`discussion`.`Seen`='0';";

	$o1=QueryExcute("mysqli_fetch_row", $q1);
	$o2=QueryExcute("mysqli_fetch_row", $q2);
	$o=$o1[0]+$o2[0];
	echo $o;
}
MessageGetSumHeader();
?>
