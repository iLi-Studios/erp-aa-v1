<?php
include"../functions.php";
function MessageGetAll(){
	$idUser=$_SESSION['user_id'];
	$q="SELECT * FROM `message`
			WHERE
			(`FromUser`='$idUser' OR `ToUser`='$idUser')
			ORDER BY `idMessage` DESC limit 5;";
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
				<th style="width:4%;"></th>
				<th style="width:20%"> <a href="ili-users/user_profil?id='.$o->FromUser.'">'.$info_user->FamilyName.' '.$info_user->FirstName.'</a> </th>
				<th style="width:46%"><strong> <a href="ili-messages/read?id='.$idMessage.'&id2='.$idDiscussion.'">'.$o->Subject.'</a> </strong></th>
				<th style="width:12%">'?><?php if($o1>='1'){MessageStatus($ox->idMessage, $idDiscussion);}		else{MessageStatus($o->idMessage, '');} MessageStatusChekIfLocked($o->idMessage); echo' </th>
				<th style="width:18%"> ';?><?php if($o1>='1'){DateDifference($ox->TimeStamp);}else{DateDifference($o->TimeStamp);} echo' </th>
			</tr>
			';	
	}
	echo '<span>Voire plus ...</span>';		
}
MessageGetAll();
?>