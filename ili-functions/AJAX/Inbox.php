<?php
include"../functions.php";
function Inbox(){
	global $URL;
	$idUser=$_SESSION['user_id'];
	$q="SELECT * FROM `message`
			WHERE
			(`FromUser`='$idUser' OR `ToUser`='$idUser')
			ORDER BY `idMessage` DESC;";
	$r=QueryExcuteWhile($q);
	while ($o=mysqli_fetch_object($r)){
		$info_user=UserGetInfo($o->FromUser);
		$idMessage=$o->idMessage;
		$q1="SELECT * FROM `message`, `discussion`
			WHERE
			`discussion`.`idMessage`=`message`.`idMessage`
			AND
			`message`.`idMessage`='$idMessage'
			AND
			`idDiscussion`=(SELECT MAX(`idDiscussion`) FROM `discussion`)
			;";
			$o1=QueryExcute("mysqli_num_rows", $q1);
			if($o1>='1'){$rx=QueryExcuteWhile($q1);$ox=mysqli_fetch_object($rx);}
			if($o1>='1'){$idDiscussion=$ox->idDiscussion;}else{$idDiscussion='';}
			echo'
			<tr>
				<td></td>
				<td> <a href="'.$URL.'ili-users/user_profil?id='.$o->FromUser.'">'.$info_user->FamilyName.' '.$info_user->FirstName.'</a> </td>
				<td class="hidden-phone"> <strong> <a href="'.$URL.'ili-messages/read?id='.$idMessage.'&id2='.$idDiscussion.'">'.$o->Subject.'</a> </strong> </td>
				<td class="hidden-phone">' ?><?php if($o1>='1'){MessageStatus($ox->idMessage, $idDiscussion);}		else{MessageStatus($o->idMessage, '');} MessageStatusChekIfLocked($o->idMessage); echo' </td>
				<td class="hidden-phone">' ;?><?php if($o1>='1'){DateDifference($ox->TimeStamp);}else{DateDifference($o->TimeStamp);} echo' </td>
			</tr>
			';
	}		
}
Inbox();
?>