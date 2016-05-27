<?php
include"../functions.php";
function MessageGetAllHeader(){
	global $URL;
	//get message source
	$idUser=$_SESSION['user_id'];
	$q1="SELECT * FROM `message` WHERE `ToUser`='$idUser' AND `Seen`='0' ORDER BY `idMessage` DESC LIMIT 2 ";	
	$r1=QueryExcuteWhile($q1);
	if(mysqli_num_rows($r1)>'0'){		
		while ($o1=mysqli_fetch_object($r1)){
			$s1=UserGetInfo($o1->FromUser);
			if(isset($s1->ProfilePhoto)){$img1=$s1->ProfilePhoto;}else{$img1='';}
			echo'
			<li> 
				<a href="'.$URL.'ili-messages/read?id='.$o1->idMessage.'"> 
					<span class="photo">
						<img src="'.$img1.'" alt="avatar" />
					</span> 
					<span class="subject"> 
						<span class="from">'.$s1->FamilyName.' '.$s1->FirstName.'</span> 
					</span> 
					<span class="message"> '.$o1->Subject.' </span> 
					<span class="small italic">';?><?php DateDifference($o1->TimeStamp); ?><?php echo'</span>
				</a> 
			</li>
			';
		}
	}
	//get rep messages
	$q2="SELECT * FROM `message`, `discussion`
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
			`discussion`.`Seen`='0' LIMIT 2;
			";
	$r2=QueryExcuteWhile($q2);
	if(mysqli_num_rows($r2)>'0'){		
		while ($o2=mysqli_fetch_object($r2)){
			$s2=UserGetInfo($o2->FromUser);
			if(isset($s2->ProfilePhoto)){$img2=$s2->ProfilePhoto;}else{$img2='';}
			echo'
			<li> 
				<a href="'.$URL.'ili-messages/read?id='.$o2->idMessage.'&id2='.$o2->idDiscussion.'"> 
					<span class="photo">
						<img src="'.$img2.'" alt="avatar" />
					</span> 
					<span class="subject"> 
						<span class="from">'.$s2->FamilyName.' '.$s2->FirstName.'</span> 
					</span> 
					<span class="message"> '.$o2->Subject.' </span> 
					<span class="small italic">';?><?php DateDifference($o2->TimeStamp); ?><?php echo'</span>
				</a> 
			</li>
			';
		}
	}
}
MessageGetAllHeader();
?>