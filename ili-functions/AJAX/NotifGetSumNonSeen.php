<?php
include"../functions.php";
function NotifGetSumNonSeen(){
	$idUser=$_SESSION['user_id'];
	$query="SELECT * FROM `notificationsystem` WHERE `idUser`='$idUser' AND `Seen`='0'";
	$o=QueryExcute("mysqli_num_rows", $query);
	echo $o;
}
NotifGetSumNonSeen();
?>