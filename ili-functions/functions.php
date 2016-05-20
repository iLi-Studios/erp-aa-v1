<?php
/*INCLUDES*/
include"config.php";
include"alert.php";
include"database.php";

/*GLOBALS*/
if (!isset($_SESSION)){
	session_start();
	//duré de vie de la session 30min
	ini_set("session.lifetime",1800);
}

/*AUTHORIZATION*/
function LogIn($Email, $Password){
	/*if($_SESSION['tentative']<=3){*/
		$query="SELECT * FROM `users`, `usersRank` WHERE `users`.Email='$Email' AND `users`.Password='$Password' AND `users`.idRank=`usersRank`.idRank";
		if( ($o=QueryExcute("mysqli_fetch_object", $query)) == true){
			if($o->idRank=='1'){Redirect("login?message=3");}
			else{
				$_SESSION['user_id']=$o->idUser;
				$_SESSION['user_nom']=$o->FamilyName;
				$_SESSION['user_prenom']=$o->FirstName; 
				$_SESSION['user_nom_prenom']=$_SESSION['user_nom'].' '.$_SESSION['user_prenom'];
				$_SESSION['user_idRank']=$o->idRank;
				$_SESSION['user_Rank']=$o->Rank;
				$_SESSION['user_img']=$o->ProfilePhoto;
				LogWrite("Connexion");
				Redirect("index");
			}
		}
		else{
			$_SESSION['tentative']=$_SESSION['tentative']+1;
			Redirect("login?message=2");
			}
	/*}
	else{Redirect("login?message=13");}*/
}
function LogOut(){
	if (isset($_SESSION["user_id"])){
		session_destroy();
		LogWrite("Déconnexion");
		Redirect("login?message=4");
	}
}
function Authorization($id){
	if(!isset($_SESSION['user_id'])){
		session_destroy();
		Redirect('login?message=1');
	}
	else{
		if($_SESSION['user_idRank']<$id){
			Redirect('index?message=17');
		}
	}
}
function AuthorizedPrivileges($bloc, $privilege){
	if($_SESSION['user_idRank']==2){
		$up=UserPrivileges("$bloc", $_SESSION['user_id']);
		$s=$up->s;$c=$up->c;$u=$up->u;$d=$up->d;
		//S
		if($privilege=='S'){if(!$s){RedirectJS('index?message=17');}}
		//C
		if($privilege=='C'){if(!$c){RedirectJS('index?message=17');}}
		//U
		if($privilege=='U'){if(!$u){RedirectJS('index?message=17');}}
		//D
		if($privilege=='D'){if(!$d){RedirectJS('index?message=17');}}
	}
}
function GetUserPanel($page, $var1, $var2){
	global $URL;
	if($page=='USERS'){
		//ADMIN
		if($_SESSION['user_idRank']>=3){
			//C IN ALL
			echo'<a href="user_add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';	
			//U IN ALL
			echo'<a href="user_edit?id='.$var1.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
			//D IN ALL BUT HIM
			if($_SESSION['user_id']!=$var1){echo'<a href="#myModal_del'.$var1.'" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
			//B IN ALL BUT HIM 
			if($_SESSION['user_id']!=$var1){
				if($var2==1){echo'<a href="user_deban?id='.$var1.'" class="icon-repeat tooltips" data-original-title="Débannir"></a>';}
				if($var2==2){echo'<a href="user_ban?id='.$var1.'" class="icon-ban-circle tooltips" data-original-title="Bannir"></a>';}
			}
			//S IN ALL
			echo'<a href="user_profil?id='.$var1.'" class="icon-eye-open tooltips" data-original-title="Voir plus"></a>';
		}
		//USER
		if($_SESSION['user_idRank']==2){
			$up=UserPrivileges("USERS", $_SESSION['user_id']);$s=$up->s;$c=$up->c;$u=$up->u;$d=$up->d;
			//C IN ALL
			if($c){echo'<a href="user_add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';}
			//U IN ALL BUT ADMIN
			if( (($u) && ($_SESSION['user_idRank']>=$var2)) || ($_SESSION['user_id']==$var1) ){echo'<a href="user_edit?id='.$var1.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';}
			//D IN ALL BUT HIM && ADMIN
			if( ($d) && ($_SESSION['user_id']!=$var1) && ($_SESSION['user_idRank']>=$var2) ){echo'<a href="#myModal_del'.$var1.'" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
			//B IF HE CAN UPDATE HE CAN BAN ALL BUT HIM && ADMIN
			if( ($u) && ($_SESSION['user_id']!=$var1) && ($_SESSION['user_idRank']>=$var2) ){
				if($var2==1){echo'<a href="user_deban?id='.$var1.'" class="icon-repeat tooltips" data-original-title="Débannir"></a>';}
				if($var2==2){echo'<a href="user_ban?id='.$var1.'" class="icon-ban-circle tooltips" data-original-title="Bannir"></a>';}
			}
			//S IN ALL BUT ADMIN
			if( (($s) && ($_SESSION['user_idRank']>=$var2)) || ($_SESSION['user_id']==$var1)){echo'<a href="user_profil?id='.$var1.'" class="icon-eye-open tooltips" data-original-title="Voir plus"></a>';}	
		}
	}
	if($page=='USER_PROFILE'){
		if($_SESSION['user_idRank']>=3){
			echo'<a href="user_edit?id='.$var1.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
		}
		if($_SESSION['user_idRank']==2){
			$up=UserPrivileges("USERS", $_SESSION['user_id']);$u=$up->u;
			if( ($u)||($_SESSION['user_id']==$var1) ){
				echo'<a href="user_edit?id='.$var1.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
			}
		}
	}
	if($page=='CLIENTS'){
		$ObjectClient=ClientGetInfo($var1);
		// ADMIN
		if($_SESSION['user_idRank']>=3){
			//C
			echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';
			//U=B
			echo'<a href="edit?id='.$ObjectClient->idClient.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
			//D
			echo'<a href="#myModal_del" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';
			//B=U
		}
		// USER
		if($_SESSION['user_idRank']==2){
			$up=UserPrivileges("CLIENTS", $_SESSION['user_id']);$s=$up->s;$c=$up->c;$u=$up->u;$d=$up->d;
			//S
			if(!$s){echo'<script language="Javascript">document.location.href="../../index?message=17"</script>';}
			//C
			if($c){echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';}
			//U=B
			if($u){echo'<a href="edit?id='.$ObjectClient->idClient.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';}
			//D
			if($d){echo'<a href="#myModal_del" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
			//B=D
		}
	}
	if($page=='CLIENT_LIST'){
		//ADMIN
		if($_SESSION['user_idRank']>=3){
			//C
			echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';
		}
		//USER
		if($_SESSION['user_idRank']==2){
			$up=UserPrivileges("CLIENTS", $_SESSION['user_id']);$c=$up->c;
			//C
			if($c){echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';}
		}
	}
	if($page=='CLIENT_CONTRACT'){
		// ADMIN
		if($_SESSION['user_idRank']>=3){
			//Cree => IF C
			echo'<a href="'.$URL.'ili-modules/contrat/add/index" class="icon-file tooltips" data-toggle="modal" data-original-title="Nouveau Conrtat"></a>';
			//Renouveler => IF U
			if($var2=='Renouvelable'){echo'<a href="'.$URL.'ili-modules/contrat/renew/renew?id='.$var1.'" class="icon-repeat tooltips" data-toggle="modal" data-original-title="Renouveler Ce Contrat"></a>';}
		}
		// USER
		if($_SESSION['user_idRank']==2){
			$up_cnt=UserPrivileges("CONTRAT", $_SESSION['user_id']);$c=$up_cnt->c;$u=$up_cnt->u;
			//C
			if($c){echo'<a href="'.$URL.'ili-modules/contrat/add/add_existant?clt='.$var1.'" class="icon-file tooltips" data-toggle="modal" data-original-title="Nouveau Conrtat"></a>';}
			//Renouveler => IF U
			if($u){if($var2=='Renouvelable'){echo'<a href="'.$URL.'ili-modules/contrat/renew/renew?id='.$var1.'" class="icon-repeat tooltips" data-toggle="modal" data-original-title="Renouveler Ce Contrat"></a>';}}
		}
	}
}

/*REDERECTION*/
function Redirect($page){
	global $URL;
	header("Location: ".$URL.$page);
}
function RedirectJS($page){
	global $URL;
	echo'<script language="Javascript">document.location.href="'.$URL.$page.'"</script>';
}
function Refresh(){
	echo'<script language="Javascript">Javascript:history.go(-1)</script>';
}
function RedirectPrevious(){
	echo'<script language="Javascript">Javascript:history.go(-2)</script>';
}

/*DATE*/
function Age($date){
	return (int) ((time() - strtotime($date)) / 3600 / 24 / 365);
}
function DateDifference($date){
		if(!ctype_digit($date))
			$date = strtotime($date);
		
		if(date('Ymd', $date) == date('Ymd')){
			$diff = time()-$date;
				
			if($diff < 60) /* moins de 60 secondes */
				echo 'Il y a '.$diff.' sec';
			
			else if($diff < 3600) /* moins d'une heure */
				echo 'Il y a '.round($diff/60, 0).' minutes';
			
			else if($diff < 43200) /* moins de 12 heures */
				echo 'Il y a '.round($diff/3600, 0).' heures' ;
			
			else /*  plus de 12 heures ont affiche ajourd'hui à HH:MM:SS */
				echo 'Aujourd\'hui à '.date('H:i:s', $date);
		}
		
			else if(date('Ymd', $date) == date('Ymd', strtotime('- 1 DAY')))
				echo 'Hier à '.date('H:i:s', $date);
			
			else if(date('Ymd', $date) == date('Ymd', strtotime('- 2 DAY')))
				echo 'Il y a 2 jours à '.date('H:i:s', $date);
				
			else if(date('Ymd', $date) == date('Ymd', strtotime('- 3 DAY')))
				echo 'Il y a 3 jours à '.date('H:i:s', $date);
				
			else if(date('Ymd', $date) == date('Ymd', strtotime('- 4 DAY')))
				echo 'Il y a 4 jours à '.date('H:i:s', $date);
				
			else if(date('Ymd', $date) == date('Ymd', strtotime('- 5 DAY')))
				echo 'Il y a 5 jours à '.date('H:i:s', $date);
			
			else if(date('Ymd', $date) == date('Ymd', strtotime('- 6 DAY')))
				echo 'Il y a 6 jours à '.date('H:i:s', $date);
			
			else
				echo 'Le '.date('d/m/Y à H:i:s', $date);
}
function ExpireIn($date){	
	$date2 = date("d-m-Y");
	$n = ((strtotime($date)) - strtotime($date2));
	$n = round($n / (60*60*24)); 
	if($n==1)
	{echo '<span class="label label-warning">Expiration dans moins d\'un (1) jour<span>';}
	if(($n>1)&&($n<=90))
	{echo '<span class="label label-warning">Expiration dans moins de ('.abs($n).') jours<span>';} //Jaune
	if($n==0)
	{echo '<span class="label label-important">Expire aujourd\'hui<span>';} //Rouge
	if($n==-1)
	{echo '<span class="label label-important">Expiré depuis un ('.abs($n).') jours<span>';} //Rouge
	if(($n>-90)&&($n<-1))
	{echo '<span class="label label-important">Expiré depuis ('.abs($n).') jours<span>';} //Rouge
	if($n<-90)
	{echo '<span class="label">Innactif</span>';} //Noire
	if($n>90)
	{echo '<span class="label label-success">Actif</span>';} //Vers
}
$Now= date("d-m-Y");
$NowEN= date("Y-m-d");
function FormatEnDateToFr($dateEN){
	$dateFR=date_create($dateEN);
	echo date_format($dateFR, 'd-m-Y');
}
$Timestamp = date("d-m-Y H:i:s");

/*LOG*/
function LogWrite($Description){
	global $Timestamp;
	$idUser=$_SESSION['user_id'];
	QueryExcute("", "INSERT INTO `LogSystem` (`idLog`, `idUser`, `Timestamp`, `Description`) VALUES (NULL, '$idUser', '$Timestamp', '$Description');");
}
function LogRead(){
	$query="SELECT * FROM `LogSystem` ORDER BY idLog DESC";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
			<tr class="odd gradeX">
				<th><input type="checkbox" class="group-checkable"/></th>
				<th>'.$o->idLog.'</th>
				<th><a href="ili-users/user_profil?id='.$o->idUser.'">'.$o->idUser.'</a></th>
				<th class="hidden-phone">'.$o->Description.'</th>
				<th class="center hidden-phone">'.$o->Timestamp.'</th>
			</tr>
			';
	}
}
function ErrorGet($message){
	if(isset($_GET['message'])){
		AlertGet($_GET['message']);
	}
}

/*NOTIFICATION*/
function NotifGetAll(){
	$idUser=$_SESSION['user_id'];
	$query="SELECT * FROM `notificationsystem` WHERE `idUser`='$idUser' ORDER BY idNotification DESC LIMIT 30";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
			<li> 
				'.$o->Description.' 
					<span class="small italic" style="margin-left:4%"><br>'?><?php DateDifference($o->Timestamp); echo'
						<br><br>
						<form action="" method="post" style="margin-bottom: -3%;margin-top: -10%;">
						</form>
					</span>
				</a>
			</li>				
		';
	}
}
function NotificationGetWhile($o){
	
}
function NotifGetSumNonSeen(){
	$idUser=$_SESSION['user_id'];
	$query="SELECT * FROM `notificationsystem` WHERE `idUser`='$idUser' AND `Seen`='0'";
	$o=QueryExcute("mysqli_num_rows", $query);
	echo $o;
}
function NotifWrite($user, $Description){
	global $Timestamp;
	$query="INSERT INTO `notificationsystem` VALUES (NULL, '$user', '$Description', '$Timestamp', '0');";
	QueryExcute('', $query);
}
function NotifAllWrite($user_dont_notif1, $user_dont_notif2, $Description){
	$query = "SELECT idUser FROM users WHERE idUser<>'$user_dont_notif1' AND idUser<>'$user_dont_notif2' ";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		NotifWrite($o->idUser, $Description);
	}
}

/*MESSAGE*/
function MessageStatus($idMessage, $idDiscussion){
	$idUser=$_SESSION['user_id'];
	$q="SELECT * FROM `message` WHERE `idMessage`='$idMessage' AND `ToUser`='$idUser';";
	$q1="SELECT * FROM `message`, `discussion` WHERE `discussion`.`idMessage`='$idMessage' AND `idDiscussion`='$idDiscussion' AND `discussion`.`ToUser`='$idUser';";
	if($idDiscussion!=''){$q=$q1;}
	$o=QueryExcute("mysqli_fetch_object", $q);
	if($o){
		if($idDiscussion==''){if(($o->Seen=='0')&&($o->ToUser==$idUser)){echo '<span class="label label label-success">Nouveau</span>';}}
		else{if(($o->Seen=='0')&&($o->ToUser=$idUser)){echo '<span class="label label label-success">Nouveau</span>';}}
	}
}
function MessageStatusChekIfLocked($idMessage){
	$q="SELECT * FROM `message` WHERE `idMessage`='$idMessage';";
	$o=QueryExcute("mysqli_fetch_object", $q);
	if($o->ClosedBy!=''){echo '<span class="label label label-default">Verouiller</span>';}
}
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
				<th style="width:4%;"></th>
				<th style="width:20%"> <a href="'.$URL.'ili-users/user_profil?id='.$o->FromUser.'">'.$info_user->FamilyName.' '.$info_user->FirstName.'</a> </th>
				<th style="width:46%"><strong> <a href="'.$URL.'ili-messages/read?id='.$idMessage.'&id2='.$idDiscussion.'">'.$o->Subject.'</a> </strong></th>
				<th style="width:12%">'?><?php if($o1>='1'){MessageStatus($ox->idMessage, $idDiscussion);}		else{MessageStatus($o->idMessage, '');} MessageStatusChekIfLocked($o->idMessage); echo' </th>
				<th style="width:18%"> ';?><?php if($o1>='1'){DateDifference($ox->TimeStamp);}else{DateDifference($o->TimeStamp);} echo' </th>
			</tr>
			';
	}		
}
function MessageGet($idMessage){
	global $URL;
	$q1="SELECT * FROM `message` WHERE `idMessage`='$idMessage';";
	$r1=QueryExcuteWhile($q1);
	while ($o1=mysqli_fetch_object($r1)){
		//msg_rep
		$q2="SELECT * FROM `message`, `discussion` WHERE `discussion`.`idMessage`=`message`.`idMessage` AND `message`.`idMessage`='$idMessage' ORDER BY `idDiscussion` DESC;";
		$r2=QueryExcuteWhile($q2);
		while ($o2=mysqli_fetch_object($r2)){
			//envoi
			$sender2=UserGetInfo($o2->FromUser);
			if(isset($sender2->ProfilePhoto)){$img2=$sender2->ProfilePhoto;}else{$img2='';}
			echo'
			<div class="msg-time-chat"> <a href="#" class="message-img"><img class="avatar" src="'.$img2.'" alt=""></a>
				<div class="message-body msg-in">
					<div class="text">
						<p class="attribution"><a href="'.$URL.'ili-users/user_profil?id='.$sender2->idUser.'">'.$sender2->FamilyName.' '.$sender2->FirstName.'</a> ';?><?php DateDifference($o2->TimeStamp); ?><?php echo'</p>
						<p> '.$o2->Containt.' </p>
					</div>
				</div>
			</div>
			';	
		}
		//msg
		$sender=UserGetInfo($o1->FromUser);
		if(isset($sender->ProfilePhoto)){$img=$sender->ProfilePhoto;}else{$img='';}
		echo'
		<div class="msg-time-chat"> <a href="#" class="message-img"><img class="avatar" src="'.$img.'" alt=""></a>
			<div class="message-body msg-in">
				<div class="text">
					<p class="attribution"><a href="'.$URL.'ili-users/user_profil?id='.$sender->idUser.'">'.$sender->FamilyName.' '.$sender->FirstName.'</a> ';?><?php DateDifference($o1->TimeStamp); ?><?php echo'</p>
					<p> '.$o1->Containt.' </p>
				</div>
			</div>
		</div>
		';	
	}
}
function MessageLock($idMessage){
	$idUser=$_SESSION['user_id'];
	$query="UPDATE `message` SET `ClosedBy`='$idUser' WHERE `idMessage`='$idMessage';";
	QueryExcute('', $query);
	Refresh();
}
function MessageMakeSee($idMessage){
	$user_id = $_SESSION['user_id'];
	$query="UPDATE `message` SET `Seen` = '1' WHERE `idMessage`='$idMessage' AND `ToUser`='$user_id';";
	QueryExcute('', $query);
}
function MessageGetInfo($idMessage){
	$query="SELECT * FROM `message` WHERE `idMessage`='$idMessage';";
	$result=QueryExcuteWhile($query);
	$o=mysqli_fetch_object($result);
	return $o;
}
function DiscussionMakeSee($idDiscussion){
	$user_id = $_SESSION['user_id'];
	$query="UPDATE `discussion` SET `Seen`='1' WHERE `idDiscussion`='$idDiscussion' AND `ToUser`='$user_id';";
	QueryExcute('', $query);
}
function DiscussionGetInfo($idDiscussion){
	$query="SELECT * FROM `discussion` WHERE `idDiscussion`='$idDiscussion';";
	$result=QueryExcuteWhile($query);
	$o=mysqli_fetch_object($result);
	return $o;
}
function MessageGetReceever($idMessage, $idDiscussion){
	$idUser=$_SESSION['user_id'];
	if($idDiscussion==''){
		$O1=QueryExcute("mysqli_fetch_object", "SELECT `FromUser`, `ToUser` FROM `message` WHERE `idMessage`='$idMessage';");
		if($O1->FromUser!=$idUser){echo $O1->FromUser;}else{echo $O1->ToUser;}
	}
	else{
		//Get Last idDiscussion From idMessage
		$O=QueryExcute("mysqli_fetch_array", "SELECT MAX(`idDiscussion`) FROM `discussion` WHERE `idMessage`='$idMessage';");
		$MaxidDiscussion=$O[0];
		$O2=QueryExcute("mysqli_fetch_object", "SELECT `FromUser`, `ToUser` FROM `discussion` WHERE `idDiscussion`='$MaxidDiscussion';");
		if($O2->FromUser!=$idUser){echo $O2->FromUser;}else{echo $O2->ToUser;}
	}
}
function MessageDestinationGetList(){
	$idUser=$_SESSION['user_id'];
	$query="SELECT `idUser`, `FamilyName`, `FirstName` FROM `users` WHERE `idUser`<>'$idUser' ";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
			<option value="'.$o->idUser.'">'.$o->FamilyName.' '.$o->FirstName.'</option>
		';
	}
}
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
function MessageGetAllHeader(){
	global $URL;
	//get message source
	$idUser=$_SESSION['user_id'];
	$q1="SELECT * FROM `message` WHERE `ToUser`='$idUser' AND `Seen`='0' ORDER BY `idMessage` DESC LIMIT 3 ";	
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
			`discussion`.`Seen`='0';
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
function MessageStart($idUser){
	//Form
	echo'
	<form action="" method="post" class="form-vertical">
		<br>
		<div class="control-group">
			<div class="controls">
				<input name="Subject" style="margin-top:-14px" type="text" class="span6" placeholder="Sujet" autofocus required/><br>
				<select name="ToUser" class="span6">';?><?php MessageDestinationGetList();?><?php echo'</select>
			</div>
		</div>
		<!-- END SUJET DISTINATAIRE-->
		<div class="control-group">
			<div class="controls">
				<textarea class="span12 ckeditor" name="Containt" rows="4"></textarea><br>
				<center>
					<input type="reset" value=" Annuler" class="btn btn-info"/>
					<input type="submit" value=" Envoyer" class="btn btn-success"/>
				</center>
			</div>
		</div>
		<!-- END EDITEUR -->
	</form>
	';
	//Function
	if( (isset($_POST['Subject'])) && (isset($_POST['ToUser'])) && (isset($_POST['Containt'])) ){
		global $Timestamp;
		$Subject		=addslashes($_POST['Subject']);
		$ToUser			=addslashes($_POST['ToUser']);
		$Containt		=addslashes($_POST['Containt']);
		$QueryStartMessage="INSERT INTO `message` VALUES (NULL, '$idUser', '$ToUser', '$Subject', '$Containt', '$Timestamp', '0', NULL);";
		QueryExcute('', $QueryStartMessage);
		RedirectJS("index");
	}
}
function MessageRead($idMessage, $idDiscussion, $info_message){
	//Form
	if($info_message->ClosedBy==''){
		echo'
		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-title">
						<h4><i class="icon-reorder"></i> Editeur de message </h4>
						<span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span>
					</div>
					<div class="widget-body form">
						<form action="" method="post" class="form-vertical">
							<div class="control-group">
								<div class="controls">
									<textarea class="span12 ckeditor" name="ContaintDiscussion" rows="6"></textarea>
									<br>
									<center>
										<input type="hidden" name="ToUserDiscussion" value="';?><?php MessageGetReceever($idMessage, $idDiscussion);?><?php echo'"/>
										<input type="reset" value=" Annuler" class="btn btn-info"/>
										<input type="submit" value=" Rependre" class="btn btn-success"/>
						</form>
						<br><br>';
						if( ($_SESSION['user_idRank']>=3)||($info_message->FromUser==$_SESSION['user_id']) ){
							echo'
							<form action="" method="post">
								<input type="hidden" name="Seen" value="'.$idMessage.'">
								<input type="submit" value=" Verrouiller" class="btn btn-warning"/>
							</form>
							';
						}
						echo'
									</center>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		';
	}
	//Function
	if(isset($_POST['ContaintDiscussion']) && isset($_POST['ToUserDiscussion'])){
		global $Timestamp;
		$ContaintDiscussion 	= addslashes($_POST['ContaintDiscussion']);
		$FormUserDiscussion		= $_SESSION['user_id'];
		$ToUserDiscussion		= $_POST['ToUserDiscussion'];
		$QueryInsertDiscution = "INSERT INTO `discussion` VALUES (NULL, '$idMessage', '$FormUserDiscussion', '$ToUserDiscussion', '$ContaintDiscussion', '$Timestamp', '0');";
		QueryExcute('', $QueryInsertDiscution);
		Refresh();
	}
}

/*ENTREPRISE*/
function EntrepriseGetInfo(){
	$query="SELECT * FROM etablissement;";
	if($o=(QueryExcute("mysqli_fetch_object", $query))){return $o;}
}

/*USER*/
function UserDiplomaInsert($idUser){
	//Modal
	echo'
	<form action="" method="post">
		<div id="myModal_diploma_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_diploma_add_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_diploma_add_Label">Diplôme Ajout</h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td width="40%">Annee</td>
							<td width="60%"><input name="InsertDiplomaYear" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Lieux</td>
							<td><input name="InsertDiplomaLocation" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Diplôme</td>
							<td><input name="InsertDiplomaDiscription" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Etablissement</td>
							<td><input name="InsertDiplomaInstitute" required type="text" placeholder="" class="input-large" /></td>
						</tr>
					</table>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Ajouter"/>
			</div>
		</div>
	</form>
	';
	//Form
	if( (isset($_POST['InsertDiplomaYear'])) && (isset($_POST['InsertDiplomaLocation'])) && (isset($_POST['InsertDiplomaDiscription'])) && (isset($_POST['InsertDiplomaInstitute'])) ){	
		global $URL;
		$user=UserGetInfo($idUser);
		$InsertDiplomaYear	 			= addslashes($_POST['InsertDiplomaYear']);
		$InsertDiplomaLocation	 		= addslashes($_POST['InsertDiplomaLocation']);
		$InsertDiplomaDiscription 		= addslashes($_POST['InsertDiplomaDiscription']);
		$InsertDiplomaInstitute 		= addslashes($_POST['InsertDiplomaInstitute']);
		$QueryInsertDiploma			= "INSERT INTO `usersdiploma` (`idDiploma`, `idUser`, `Year`, `Location`, `Description`, `Institute`) VALUES ('', '$user->idUser', '$InsertDiplomaYear', '$InsertDiplomaLocation', '$InsertDiplomaDiscription', '$InsertDiplomaInstitute');";
		QueryExcute('', $QueryInsertDiploma);
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', ajout du diplôme : '.$InsertDiplomaDiscription);
		LogWrite("Ajout du diplôme : ".$InsertDiplomaDiscription.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserDiplomaUpdate($idUser){
	//Function
	$query="SELECT * FROM `usersdiploma` WHERE `idUser`='$idUser' ORDER BY `idDiploma` DESC;";
	if(QueryExcute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS DE DIPLOME!</strong>";}
	else{
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->Description.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#myModal_diploma_mod'.$o->idDiploma.'" data-toggle="modal" class="icon-edit tooltips" data-original-title="&nbsp;&nbsp;Modifier"></a>
						<a href="diploma_remove?idUser='.$_GET['id'].'&id_diploma='.$o->idDiploma.'&diploma_name='.$o->Description.'" class="icon-trash tooltips" data-original-title="&nbsp;&nbsp;Supprimer"></a>
						<br/>
						<em>'.$o->Location.', '.$o->Year.'</em><br/>
						<em><strong>'.$o->Institute.'</strong></em><br>
						<!-- Start myModal_diploma_mod -->
						<form action="" method="post">
							<div id="myModal_diploma_mod'.$o->idDiploma.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_diploma_mod'.$o->idDiploma.'_Label" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModal_diploma_mod'.$o->idDiploma.'_Label">Diplôme Modification</h3>
								</div>
								<div class="modal-body">
									<center>
										<table width="80%">
											<tr>
												<td width="40%">Annee</td>
												<td width="60%"><input name="UpdateDiplomaYear" required type="text" value="'.$o->Year.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Lieux</td>
												<td><input name="UpdateDiplomaLocation" required type="text" value="'.$o->Location.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Diplôme</td>
												<td><input name="UpdateDiplomaDescription" required type="text" value="'.$o->Description.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Etablissement</td>
												<td><input name="UpdateDiplomaInstitute" required type="text" value="'.$o->Institute.'" class="input-large" /></td>
											</tr>	
										</table>
									</center>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="UpdateDiplomaidDiploma" value="'.$o->idDiploma.'"/>
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
								</div>
							</div>
						</form><!-- End myModal_diploma_mod -->
					</li>
					';				
		}
	}
	//Form
	if( (isset($_POST['UpdateDiplomaidDiploma'])) && (isset($_POST['UpdateDiplomaYear'])) && (isset($_POST['UpdateDiplomaLocation'])) && (isset($_POST['UpdateDiplomaDescription'])) && (isset($_POST['UpdateDiplomaInstitute'])) ){	
		global $URL;
		$user=UserGetInfo($idUser);
		$UpdateDiplomaYear	 			= addslashes($_POST['UpdateDiplomaYear']);
		$UpdateDiplomaLocation	 		= addslashes($_POST['UpdateDiplomaLocation']);
		$UpdateDiplomaDescription 		= addslashes($_POST['UpdateDiplomaDescription']);
		$UpdateDiplomaInstitute 		= addslashes($_POST['UpdateDiplomaInstitute']);
		$UpdateDiplomaidDiploma			= addslashes($_POST['UpdateDiplomaidDiploma']);
		$QueryUpdateDiploma	= "UPDATE `usersdiploma` 
								SET 
										`Year`='$UpdateDiplomaYear',
										`Location`='$UpdateDiplomaLocation',
										`Description`='$UpdateDiplomaDescription',
										`Institute`='$UpdateDiplomaInstitute' 
								WHERE `idDiploma`='$UpdateDiplomaidDiploma';";
		QueryExcute('', $QueryUpdateDiploma);
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', modification du diplôme : '.$UpdateDiplomaDescription);
		LogWrite("Modification du diplôme : ".$UpdateDiplomaDescription.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserDiplomaDrop($idDiploma){
	$query="DELETE FROM `usersdiploma` WHERE `idDiploma`='$idDiploma';";
	if(QueryExcute('', $query)){return 1;}
}
function UserDiplomaGet($idUser, $OnlyLastOne){
	$QueryOnlyLastOne	="SELECT * FROM `usersdiploma` WHERE `idUser`='$idUser' ORDER BY `idDiploma` DESC LIMIT 1;";
	$QueryAll			="SELECT * FROM `usersdiploma` WHERE `idUser`='$idUser' ORDER BY `idDiploma` DESC";
	if($OnlyLastOne){$Query=$QueryOnlyLastOne;}else{$Query=$QueryAll;}
	if(QueryExcute('mysqli_num_rows', $Query)==0){echo"<strong>PAS DE DIPLOME!</strong>";}
	else{
		$Result=QueryExcuteWhile($Query);
		while ($O=mysqli_fetch_object($Result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$O->Description.'</strong><br/>
						<em>'.$O->Location.', '.$O->Year.'</em><br/>
						<em><strong>'.$O->Institute.'</strong></em><br>
					</li><br>';
		}
	}
}
function UserExpiranceInsert($idUser){
	//Modal
	echo'
	<form action="" method="post">
		<div id="myModal_expirance_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_expirance_add_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_expirance_add_Label">Expériance Ajout</h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td width="40%">Etablissement</td>
							<td width="60%"><input name="InsertCompany" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>URL Etablissement</td>
							<td><input name="InsertCompanyURL" type="url" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Durée</td>
							<td><input name="InsertPeriod" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Expériance</td>
							<td><textarea name="InsertDescription" style="resize: vertical; width:100%; max-height:150px;" rows="4"></textarea></td>
						</tr>
					</table>
				</center>
				<h6>NB: URL Teablissement doit être complet <br>
					EXP. http://www.ili-studios.com/<br>
					<strong>CONCEIL :</strong> Copiez-le directement depuis le navigateur</h6>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Ajouter"/>
			</div>
		</div>
	</form>
	';
	//Form
	if( (isset($_POST['InsertCompany'])) && (isset($_POST['InsertCompanyURL'])) && (isset($_POST['InsertPeriod'])) && (isset($_POST['InsertDescription'])) ){	
		global $URL;
		$user=UserGetInfo($idUser);
		$InsertCompany	 		= addslashes($_POST['InsertCompany']);
		$InsertCompanyURL	 	= addslashes($_POST['InsertCompanyURL']);
		$InsertPeriod 			= addslashes($_POST['InsertPeriod']);
		$InsertDescription 		= addslashes($_POST['InsertDescription']);
		$QueryInsertExperience	= "INSERT INTO `usersexperience` (`idExperience`, `idUser`, `Company`, `CompanyURL`, `Period`, `Description`) VALUES (NULL, '$user->idUser', '$InsertCompany', '$InsertCompanyURL', '$InsertPeriod', '$InsertDescription');";
		QueryExcute('', $QueryInsertExperience);
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', ajout de l\'expérence dans l\'etablissement : '.$InsertCompany);
		LogWrite("Ajout de l\'expérience dans l\'etablissement : ".$InsertCompany.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserExpiranceUpdate($idUser){
	$query="SELECT * FROM `usersexperience` WHERE `idUser`='$idUser' ORDER BY `idExperience` DESC;";
	if(QueryExcute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS D'EXPERIENCE!</strong>";}
	else{
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->Company.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#myModal_expirance_mod'.$o->idExperience.'" data-toggle="modal" class="icon-edit tooltips" data-original-title="&nbsp;&nbsp;Modifier"></a>
						<a href="expirance_remove?idUser='.$_GET['id'].'&id_expirance='.$o->idExperience.'&Company='.$o->Company.'" class="icon-trash tooltips" data-original-title="&nbsp;&nbsp;Supprimer"></a>
						<br/>
						<em>Durée : '.$o->Period.'</em><br/>
						<em>&nbsp;&nbsp;&nbsp;'.$o->Description.'</em><br>
						<a href="'.$o->CompanyURL.'" target="new">'.$o->CompanyURL.'</a>
						<!-- Start myModal_expirance_mod -->					
						<form action="" method="post">
							<div id="myModal_expirance_mod'.$o->idExperience.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_expirance_mod'.$o->idExperience.'_Label" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModal_expirance_mod'.$o->idExperience.'_Label">Expérience Modifier</h3>
								</div>
								<div class="modal-body">
									<center>
										<table width="80%">
											<tr>
												<td width="40%">Etablissement</td>
												<td width="60%"><input name="UpdateCompany" required type="text" value="'.$o->Company.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>URL Etablissement</td>
												<td><input name="UpdateCompanyURL" type="text" value="'.$o->CompanyURL.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Durée</td>
												<td><input name="UpdatePeriod" required type="text" value="'.$o->Period.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Expérience</td>
												<td><textarea name="UpdateDescription" style="resize: vertical; width:100%; max-height:150px;" rows="4">'.$o->Description.'</textarea></td>
											</tr>
										</table>
									</center>
									<h6>NB: URL Etablissement doit être complet <br>EXP: http://www.ili-studios.com/<br> <strong>CONCEIL :</strong> Copiez-le directement depuis le navigateur</h6>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="UpdateidExperience" value="'.$o->idExperience.'"/>
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
								</div>
							</div>
						</form><!-- End myModal_expirance_mod -->						
					</li>';
		}
		//formulaire d'update
		if( (isset($_POST['UpdateCompany'])) && (isset($_POST['UpdateCompanyURL'])) && (isset($_POST['UpdatePeriod'])) && (isset($_POST['UpdateDescription'])) && (isset($_POST['UpdateidExperience'])) ){	
			global $URL;
			$UpdateCompany	 	= addslashes($_POST['UpdateCompany']);
			$UpdateCompanyURL	= addslashes($_POST['UpdateCompanyURL']);
			$UpdatePeriod 		= addslashes($_POST['UpdatePeriod']);
			$UpdateDescription 	= addslashes($_POST['UpdateDescription']);
			$UpdateidExperience	= addslashes($_POST['UpdateidExperience']);
			$user				= UserGetInfo($idUser);
			QueryExcute("", "UPDATE usersexperience SET Company='$UpdateCompany', CompanyURL='$UpdateCompanyURL', Period='$UpdatePeriod', Description='$UpdateDescription' WHERE idExperience='$UpdateidExperience';");
			NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', Modification de l`experiance dans l`etablissement : '.$UpdateCompany);
			LogWrite("Modification de l\'expérience dans l\'etablissement : ".$UpdateCompany.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
			Refresh();
			
		}
	}
}
function UserExpiranceDrop($idExperience){
	$query="DELETE FROM `usersexperience` WHERE `idExperience`='$idExperience';";
	if(QueryExcute('', $query)){return 1;}
}
function UserExpiranceGet($idUser, $OnlyLastOne){
	$QueryOnlyLastOne	="SELECT * FROM `usersexperience` WHERE `idUser`='$idUser' ORDER BY `idExperience` DESC LIMIT 1;";
	$QueryAll			="SELECT * FROM `usersexperience` WHERE `idUser`='$idUser' ORDER BY `idExperience` DESC;";
	if($OnlyLastOne){$Query=$QueryOnlyLastOne;}else{$Query=$QueryAll;}
	if(QueryExcute('mysqli_num_rows', $Query)==0){echo"<strong>PAS D'EXPERIENCE!</strong>";}
	else{
		$Result=QueryExcuteWhile($Query);
		while ($O=mysqli_fetch_object($Result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$O->Company.'</strong><br/>
						<em>Durée : '.$O->Period.'</em><br/>
						<em>&nbsp;&nbsp;&nbsp;'.$O->Description.'</em><br>
						<a href="'.$O->CompanyURL.'" target="new">'.$O->CompanyURL.'</a>
					</li><br>';
		}
	}
}
function UserQualificationInsert($idUser){
	//Modal
	echo'
	<form action="" method="post">
		<div id="myModal_skills_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_skills_add_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_skills_add_Label"><center>Ajout de Compétance</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td width="40%">Compétance</td>
							<td width="60%"><input name="InsertQualificationDescription" required type="text" class="input-large" /></td>
						</tr>
						<tr>
							<td>Niveau</td>
							<td><input name="InsertQualificationLevel" required type="range" class="input-large" />%</td>
						</tr>
					</table>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Ajouter"/>
			</div>
		</div>
	</form>
	';
	//form
	if( (isset($_POST['InsertQualificationDescription'])) && (isset($_POST['InsertQualificationLevel'])) ){
		global $URL;
		$user=UserGetInfo($idUser);
		$InsertQualificationDescription 	= addslashes($_POST['InsertQualificationDescription']);
		$InsertQualificationLevel			= addslashes($_POST['InsertQualificationLevel']);
		$QueryInsertQualification = "INSERT INTO usersqualification VALUES ('', '$idUser', '$InsertQualificationDescription', '$InsertQualificationLevel');";
		QueryExcute('', $QueryInsertQualification);
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', ajout de compétence : '.$InsertQualificationDescription);
		LogWrite("Ajout du compétence : ".$InsertQualificationDescription.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
		Refresh();
	}	
}
function UserQualificationUpdate($idUser){
	// Function
	$Query="SELECT * FROM `usersqualification` WHERE idUser='$idUser' ORDER BY `idQualification` DESC;";
	if(QueryExcute('mysqli_num_rows', $Query)=='0'){echo"<strong>PAS DE COMPETANCE!</strong>";}
	else{
		$Result=QueryExcuteWhile($Query);
		while ($O=mysqli_fetch_object($Result)){
			if($O->Value >= '0' && $O->Value <= '33'){$Color='danger';}
			if($O->Value >'33' && $O->Value <= '66'){$Color='warning';}
			if($O->Value >'66' && $O->Value <= '100'){$Color='success';}
			echo'
				<tr>
					<td class="span1">
						<span class="label label-inverse">
							<a href="skills_remove?idUser='.$_GET['id'].'&id_skills='.$O->idQualification.'&skills_name='.$O->Label.'" class="icon-trash tooltips" data-original-title="Supprimer"></a>
							'.$O->Label.'
						</span>
					</td>
					<td>
						<div class="progress progress-'.$Color.' progress-striped">
							<div style="width: '.$O->Value.'%" class="bar"></div>
						</div>
					</td>
				</tr>				
				';				
		}
	}
}
function UserQualificationDrop($idQualification){
	$Query="DELETE FROM `usersqualification` WHERE `idQualification`='$idQualification';";
	QueryExcute('', $Query);
}
function UserQualificationGet($idUser){
	$Query="SELECT * FROM `usersqualification` WHERE `idUser`='$idUser' ORDER BY `idQualification` DESC;";
	if(QueryExcute('mysqli_num_rows', $Query)=='0'){echo"<strong>PAS DE COMPETANCE!</strong>";}
	else{
		$Result=QueryExcuteWhile($Query);
		while ($O=mysqli_fetch_object($Result)){
			if($O->Value >= '0' && $O->Value <= '33'){$Color='danger';}
			if($O->Value >'33' && $O->Value <= '66'){$Color='warning';}
			if($O->Value >'66' && $O->Value <= '100'){$Color='success';}
			echo'
				<tr>
					<td class="span1"><span class="label label-inverse">'.$O->Label.'</span></td>
					<td>
						<div class="progress progress-'.$Color.' progress-striped">
							<div style="width: '.$O->Value.'%" class="bar"></div>
						</div>
					</td>
				</tr>';
		}
	}
}
function UserInsert(){
	if((isset($_POST['cin']))&&(isset($_POST['FamilyName']))&&(isset($_POST['FirstName']))&&(isset($_POST['Email']))&&(isset($_POST['Phone']))&&(isset($_POST['Password']))&&(isset($_POST['FunctionPost']))&&(isset($_POST['Adress']))&&(isset($_POST['BirthDay']))){
		//Recup variable
		$cin						=addslashes($_POST['cin']);
		$FamilyName					=addslashes($_POST['FamilyName']);
		$FirstName					=addslashes($_POST['FirstName']);
		$Email						=addslashes($_POST['Email']);
		$FunctionPost				=addslashes($_POST['FunctionPost']);
		$Phone						=addslashes($_POST['Phone']);
		$Adress						=addslashes($_POST['Adress']);
		$BirthDay					=addslashes($_POST['BirthDay']);
		$Password					=addslashes($_POST['Password']);
		if(isset($_POST['fbAccount'])){$fbAccount=$_POST['fbAccount'];}else{$fbAccount='';}
		if(isset($_POST['githubAccount'])){$githubAccount=$_POST['githubAccount'];}else{$githubAccount='';}
		if(isset($_POST['linkedinAccount'])){$linkedinAccount=$_POST['linkedinAccount'];}else{$linkedinAccount='';}
		if(isset($_POST['img_url'])){$img_url=$_POST['img_url'];}else{$img_url='';}
		// Function
		global $Timestamp, $URL;
		$add_by= $_SESSION['user_nom_prenom'];
		if(QueryExcute('mysqli_fetch_object', "SELECT * FROM users WHERE idUser='$cin';")){Redirect('ili-users/user_add?message=8');}
		else{
			if(QueryExcute('mysqli_fetch_object', "SELECT * FROM users WHERE Email='$Email';")){Redirect('ili-users/user_add?message=9');}
			else{
				QueryExcute("", "INSERT INTO `users` VALUES ('$cin', '2', '$FamilyName', '$FirstName', '$Email', '$FunctionPost', '$Phone', '$Adress', '$BirthDay', MD5('$Password'), '$Timestamp', '$fbAccount', '$githubAccount', '$linkedinAccount', '$ProfilePhoto', '$add_by', '$Timestamp')");
				QueryExcute("", "INSERT INTO `usersprivilege` VALUES (NULL, '$cin', 'USERS', '1', '0', '0', '0'), (NULL, '$cin', 'CLIENTS', '1', '0', '0', '0'), (NULL, '$cin', 'CONTRAT', '1', '0', '0', '0'), (NULL, '$cin', 'CAISSE', '1', '0', '0', '0')");
				NotifAllWrite($cin, '', '<a href="'.$URL.'ili-users/user_profil?id='.$cin.'">Nouveau utilisateur, '.$FamilyName.' '.$FirstName);
				LogWrite("Création de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$cin."\">".$cin."</a>");
				RedirectJS('ili-users/users');
			}
		}	
	}
}
function UserDrop($id){
	QueryExcute('', "DELETE FROM usersprivilege WHERE idUser='$id'");
	QueryExcute('', "DELETE FROM users WHERE idUser='$id'");
}
function UserPasswordUpdate($idUser){
	$user=UserGetInfo($idUser);
	//Form
	echo'
	<form action="" method="post">
		<div id="myModal_Password_edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_Password_edit_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_Password_edit_Label"><center>Changement du mot de passe</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">';?>
						<?php
						if($_SESSION['user_idRank']>=3){
							echo'
								<input name="Password_now" type="hidden" class="input-large" value="'.$user->Password.'" />
								<tr>
									<td>Nouveau mot de passe</td>
									<td><input name="Password_new" required type="password" placeholder="" class="input-large" /></td>
								</tr>
								<tr>
									<td>Repeter votre nouveau mot de passe</td>
									<td><input name="Password_new2" required type="password" placeholder="" class="input-large" /></td>
								</tr>
							';
						}
						else{
							echo'
								<tr>
									<td width="40%">Mot de passe actuelle</td>
									<td width="60%"><input name="Password_now" required type="password" placeholder="" class="input-large" /></td>
								</tr>
								<tr>
									<td>Nouveau mot de passe</td>
									<td><input name="Password_new" required type="password" placeholder="" class="input-large" /></td>
								</tr>
								<tr>
									<td>Repeter votre nouveau mot de passe</td>
									<td><input name="Password_new2" required type="password" placeholder="" class="input-large" /></td>
								</tr>	
							';
						}
						?><?php echo'
					</table>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Changer"/>
			</div>
		</div>
	</form>
	';
	//Function
	if( (isset($_POST['Password_now'])) && (isset($_POST['Password_new'])) && (isset($_POST['Password_new2'])) ){
		if($_SESSION['user_idRank']>=3){$Password_now =($_POST['Password_now']);}else{$Password_now=md5($_POST['Password_now']);}
		global $Timestamp, $URL;
		$Password_new	=md5($_POST['Password_new']);
		$Password_new2	=md5($_POST['Password_new2']);
		if($Password_now==$user->Password){
			if($Password_new2==$Password_new){
				QueryExcute("mysqli_fetch_object", "UPDATE `users` SET `LastPasswordChangedDate`='$Timestamp', `Password`='$Password_new' WHERE `idUser`='$idUser';");
				LogWrite("Changement du mot de passe de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
				RedirectJS('ili-users/user_edit?message=36&id='.$idUser);
			}
			else{RedirectJS('ili-users/user_edit?message=11&id='.$idUser);}
		}
		else{RedirectJS('ili-users/user_edit?message=10&id='.$idUser);}
	}
}
function UserProfileInfoUpdate($idUser){
	//Form
	$user=UserGetInfo($idUser);
	global $URL;
	echo'
	<form action="" method="post">
		<div id="myModal_info_mod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_info_mod_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_info_mod_Label"><center>Modification des informations</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td width="40%">Nom</td>
							<td width="60%"><input name="FamilyName" required type="text" value="'.$user->FamilyName.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>Prénom</td>
							<td><input name="FirstName" required type="text" value="'.$user->FirstName.'" class="input-large" /></td>
						</tr>';?><?php if($_SESSION['user_idRank']>=3){echo'
						<tr>
							<td>Poste</td>
							<td><input name="FunctionPost" required type="text" value="'.$user->FunctionPost.'" class="input-large" /></td>
						</tr>
						';}
						else{echo'<input name="FunctionPost" type="hidden" value="'.$user->FunctionPost.'"/>';}?><?php echo'
						<tr>
							<td>Email</td>
							<td><input name="Email" required type="email" value="'.$user->Email.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td><input name="Phone" required type="text" value="'.$user->Phone.'" data-mask="99.999.999" class="input-large" /></td>
						</tr>
						<tr>
							<td>Adresse</td>
							<td><input name="Adress" required type="text" value="'.$user->Adress.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>Date de naissance</td>
							<td><input name="BirthDay" required type="text" value="'.$user->BirthDay.'" data-mask="99-99-9999" class="input-large" /></td>
						</tr>
					</table>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
			</div>
		</div>
	</form>
	';
		//Function
	if( (isset($_POST['FamilyName'])) && (isset($_POST['FirstName'])) && (isset($_POST['FunctionPost'])) && (isset($_POST['Email'])) && (isset($_POST['Phone'])) && (isset($_POST['BirthDay'])) && (isset($_POST['Adress'])) ){
		$FamilyName		=addslashes($_POST['FamilyName']);
		$FirstName		=addslashes($_POST['FirstName']);
		$FunctionPost	=addslashes($_POST['FunctionPost']);
		$Email			=addslashes($_POST['Email']);
		$Phone			=addslashes($_POST['Phone']);
		$Adress			=addslashes($_POST['Adress']);
		$BirthDay 		=addslashes($_POST['BirthDay']);						
		QueryExcute('', "UPDATE users SET FamilyName = '$FamilyName', FirstName='$FirstName', Email='$Email', FunctionPost='$FunctionPost', Phone='$Phone', BirthDay='$BirthDay', Adress='$Adress' WHERE idUser='$idUser'");
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', modification des informations');
		LogWrite("Modification des informations de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
		Refresh();
		
	}
}
function UserProfilePhotoUpdate($idUser){
	$user=UserGetInfo($idUser);
	//Form
	echo'
	<form action="" method="post">
		<div id="myModal_img_mod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_img_mod_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_img_mod_Label"><center>Modification du photo du profile</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td>URL Image</td>
							<td><input name="ProfilePhoto" type="url" value="'.$user->ProfilePhoto.'" class="input-large" /></td>
						</tr>
					</table>
				</center>
				<br>
				<h6><strong>Exp.</strong> http://www.ili-studios.com/img/test.png<br>
					<strong>INFO :</strong> Laissé vide si vous voulez pas affichié votre photo!</h6>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
			</div>
		</div>
	</form>
	';
	//Function
	if( isset($_POST['ProfilePhoto']) ){
		$ProfilePhoto				= addslashes($_POST['ProfilePhoto']);
		QueryExcute("mysqli_fetch_object", "UPDATE `users` SET `ProfilePhoto`='$ProfilePhoto' WHERE `idUser`='$user->idUser';");
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', modification de photo de profile');
		LogWrite("Changement de l\'image de profil de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		RedirectJS('ili-users/user_edit?message=36&id='.$idUser);
	}
}
function UserSocialeUpdate($idUser){
	$user=UserGetInfo($idUser);
	//Form
	echo'
	<form action="" method="post">
		<div id="myModal_social_edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_social_edit_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_social_edit_Label">URL Socieaux</h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td>URL Facebook</td>
							<td><input name="fbAccount" type="url" value="'.$user->fbAccount.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>URL LinkedinAccount</td>
							<td><input name="linkedinAccount" type="url" value="'.$user->linkedinAccount.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>URL Gitub</td>
							<td><input name="githubAccount" type="url" value="'.$user->githubAccount.'" class="input-large" /></td>
						</tr>
					</table>
				</center>
				<br>
				<h6><strong>Exp.</strong> http://www.facebook.com/<br>
					<strong>INFO :</strong> Laissé vide si vous voulez pas affichié vos lien socieaux!</h6>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
			</div>
		</div>
	</form>
	';
	//Function 
	if( (isset($_POST['fbAccount'])) && (isset($_POST['linkedinAccount'])) && (isset($_POST['githubAccount'])) ){
		global $URL;
		$fbAccount				= addslashes($_POST['fbAccount']);
		$linkedinAccount		= addslashes($_POST['linkedinAccount']);
		$githubAccount			= addslashes($_POST['githubAccount']);
		$QuerySocialInsert		= "UPDATE `users` SET `fbAccount`='$fbAccount', `githubAccount`='$githubAccount', `linkedinAccount`='$linkedinAccount' WHERE `idUser`='$idUser';";
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', modification des liens socieaux');
		QueryExcute('', $QuerySocialInsert);
		LogWrite("Modification des liens socieaux de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserSocialGet($idUser){
	$user=UserGetInfo($idUser);
	if($user->fbAccount){echo'<li><a href="'.$user->fbAccount.'" target="new"><i class="icon-facebook"></i> Compte Facebook</a></li>';}else{echo'<li><i class="icon-facebook"></i> Pas de Facebook </a></li>';}
	if($user->linkedinAccount){echo'<li><a href="'.$user->linkedinAccount.'" target="new"><i class="icon-linkedinAccount"></i> Compte Linkedin</a></li>';}else{echo'<li><i class="icon-linkedinAccount"></i> Pas de compte Linkedin </a></li>';}
	if($user->githubAccount){echo'<li><a href="'.$user->githubAccount.'" target="new"><i class="icon-github"></i> Compte github</a></li>';}else{echo'<li><i class="icon-github"></i> Pas de compte Github </a></li>';}
}
function UserGetList(){
	$query="SELECT * FROM users, usersRank WHERE users.idRank=usersRank.idRank";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
				<div class="widget">
					<div class="widget-title">
						<h4><i class="';?><?php UserGetIcon($o->idRank);?><?php echo'"></i> '.$o->FamilyName.' '.$o->FirstName.'</h4>
						<span class="tools" style="margin-top:-2px;">';
							GetUserPanel('USERS', $o->idUser, $o->idRank);
							echo'
							<!-- Modale de confirmation de suppression -->
							<div id="myModal_del'.$o->idUser.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_del'.$o->idUser.'" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel_del'.$o->idUser.'">Confirmation de suppression</h3>
								</div>
								<div class="modal-body">
									<p>Vous êtes sur de vouloire supprimer le compte du <strong>'.$o->FamilyName.' '.$o->FirstName.'</strong>? <br> Cette action est <strong>irréversible!</strong></p>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<button onClick=\'document.location.href="user_remove?id='.$o->idUser.'";\' data-dismiss="modal" class="btn btn-primary">Confirm</button>
								</div>
							</div>
							<!-- Modale de confirmation de suppression -->
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
					</div>
					<div class="widget-body">
						<div class="span3">
							<div class="text-center profil-pic">'; 
								if($o->ProfilePhoto!=''){echo'<img src="'.$o->ProfilePhoto.'" width="100%" height="226px;">';}
								echo'
							</div>
							<ul class="nav nav-tabs nav-stacked">';
									if($o->fbAccount){echo'<li><a href="'.$o->fbAccount.'" target="new"><i class="icon-facebook"></i> Facebook</a></li>';}
									if($o->linkedinAccount){echo'<li><a href="'.$o->linkedinAccount.'" target="new"><i class="icon-LinkedinAccount"></i> LinkedinAccount</a></li>';}
									if($o->githubAccount){echo'<li><a href="'.$o->githubAccount.'" target="new"><i class="icon-githubAccount"></i> githubAccount</a></li>';}						
					echo'	
							</ul>
						</div>
						<div class="span6">
							<h4>'.$o->FunctionPost.'<br/></h4>
							<table class="table table-borderless">
								<tbody>
									<tr>
										<td class="span2">Grade :</td>
										<td>'.$o->Level.'</td>
									</tr>
									<tr>
										<td class="span2">Age :</td>
										<td>'.age($o->BirthDay).' ans</td>
									</tr>
									<tr>
										<td class="span2"> Email :</td>
										<td>'.$o->Email.'</td>
									</tr>
									<tr>
										<td class="span2"> Mobile :</td>
										<td> '.$o->Phone.' </td>
									</tr>
								</tbody>
							</table>
							<h4>Compétances</h4>
							<table class="table table-borderless">
								<tbody>';UserQualificationGet($o->idUser); echo'</tbody>
							</table>
						</div>
						<div class="span3">
							<h4>Dérnier diplômes</h4>
							<ul class="icons push">';UserDiplomaGet($o->idUser, '1'); echo'</ul>
							<h4>Dériniére expérience</h4>
							<ul class="icons push">';UserExpiranceGet($o->idUser, '1');echo'</ul>
						</div>
						<div class="space5"></div>
					</div>
				</div>
			';}
}
function UserGetIcon($Rank){
	if($Rank==1){echo'icon-ban-circle';}
	if($Rank==2){echo'icon-user';}
	if($Rank==3){echo'icon-briefcase';}
}
function UserBan($idUser){
	$QueryUserBan="UPDATE users SET idRank='1' WHERE idUser='$idUser' ;";
	QueryExcute('', $QueryUserBan);
}
function UserDeban($idUser){
	$QueryUserDeban="UPDATE users SET idRank='2' WHERE idUser='$idUser' ;";
	QueryExcute('', $QueryUserDeban);
}
function RankGetList($Rank_user){
	if($_SESSION['user_idRank']==6){
		$query="SELECT * FROM `usersRank` ORDER BY idRank ASC";
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			if($Rank_user==$o->idRank){$selected='selected="selected"';}else{$selected='';}
			echo'<option '.$selected.' value="'.$o->idRank.'">'.$o->Rank.'</option>';
		}
	}
	else{
		$query="SELECT * FROM `usersRank` WHERE `idRank`<'6' ORDER BY idRank ASC";
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			if($Rank_user==$o->idRank){$selected='selected="selected"';}else{$selected='';}
			echo'<option '.$selected.' value="'.$o->idRank.'">'.$o->Rank.'</option>';
		}
	}
}
function UserGetInfo($idUser){
	$query="SELECT * FROM users, usersrank WHERE users.idUser='$idUser' AND users.idRank=usersrank.idRank";
	if($o=(QueryExcute("mysqli_fetch_object", $query))){return $o;}
}
function UserPrivileges($bloc, $idUser){
	$Query="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$bloc';";
	$O = QueryExcute("mysqli_fetch_object", $Query);
	return $O;
}
function UserPrivilegesGet($idUser, $Rank){
	if($Rank==2){
		echo'
		<ul class="nav nav-tabs nav-stacked" style="margin-left:-15%;">
			<div class="widget-body">
				<div class="space10"></div>
					<ul id="tree_2" class="tree">
						<li>
							<a data-toggle="branch" class="tree-toggle" data-role="branch" href="#">Autorisations</a>
							<ul class="branch in">
		';
		$query="SELECT `bloc` FROM `usersprivilege` WHERE `idUser`='$idUser'";
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			$query2="SELECT `s`, `c`, `u`, `d` FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			if(($o->bloc != 'CONTRAT') && ($o->bloc != 'CAISSE')){
				echo'
						<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
						$result2=QueryExcuteWhile($query2);
						while ($b=mysqli_fetch_object($result2)){
							echo'
								<ul class="branch">';
									if($b->s){echo'<li><a><p class="icon-eye-open"></p></a> Voir</li>';}
									if($b->c){echo'<li><a><p class="icon-plus"></p></a> Créer</li>';}
									if($b->u){echo'<li><a><p class="icon-edit"></p></a> Modifier</li>';}
									if($b->d){echo'<li><a><p class="icon-trash"></p></a> Supprimer</li>';}
							echo'</ul>';
						}		
					echo'</li>';
			}
			if($o->bloc == 'CONTRAT'){
				echo'
						<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
						$result2=QueryExcuteWhile($query2);
						while ($b=mysqli_fetch_object($result2)){
							echo'
								<ul class="branch">';
									if($b->s){echo'<li><a><p class="icon-eye-open"></p></a> Voir</li>';}
									if($b->c){echo'<li><a><p class="icon-file"></p></a> Créer</li>';}
									if($b->u){echo'<li><a><p class="icon-repeat"></p></a> Renouveler</li>';}
									if($b->d){echo'<li><a><p class="icon-trash"></p></a> Supprimer</li>';}
							echo'</ul>';
						}		
					echo'</li>';
			}
			if($o->bloc == 'CAISSE'){
				echo'
						<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
						$result2=QueryExcuteWhile($query2);
						while ($b=mysqli_fetch_object($result2)){
							echo'
								<ul class="branch">';
									if($b->s){echo'<li><a><p class="icon-book"></p></a> Journal</li>';}
									if($b->c){echo'<li><a><p class="icon-signout"></p></a> Décaissement</li>';}
									if($b->u){echo'<li><a><p class="icon-money"></p></a> Echéancier</li>';}
							echo'</ul>';
						}		
					echo'</li>';
			}

		}
		echo'</ul></li></ul></div></ul>';	
	}
}
function UserPrivilegesGetUpdate($idUser){
	global $URL;
	$user=UserGetInfo($idUser);
	if( ($_SESSION['user_idRank']>=3)&&($_SESSION['user_id']!=$idUser) ){
		echo'
		<ul class="nav nav-tabs nav-stacked" style="margin-left:-15%;">
			<div class="widget-body">
				<div class="space10"></div>
				<ul id="tree_2" class="tree">
					<li>
						<a data-toggle="branch" class="tree-toggle" data-role="branch" href="#">Autorisations</a>
						<ul class="branch in">';
	$query="SELECT `bloc` FROM `usersprivilege` WHERE `idUser`='$idUser'";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		if(($o->bloc != 'CONTRAT') && ($o->bloc != 'CAISSE')){
			echo'
							<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
			$query2="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			$result2=QueryExcuteWhile($query2);
			while ($b=mysqli_fetch_object($result2)){
				echo'
								<ul class="branch">
					';			
					if($b->s){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'s0" value="1">
											<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
								';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'s1" value="1" onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
							';
					}
					if($b->c){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'c0" value="1">
											<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-plus"></p></a> Créer
										</form>
									</li>
							';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'c1" value="1" onChange="this.form.submit()">
											<a><p class="icon-plus"></p></a> Créer
										</form>
									</li>
							';
					}
					if($b->u){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'u0" value="1">
											<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-edit"></p></a> Modifier
										</form>
									</li>
							';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'u1" value="1" onChange="this.form.submit()">
											<a><p class="icon-edit"></p></a> Modifier
										</form>
									</li>
							';
					}
					if($b->d){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'d0" value="1">
											<input type="checkbox" name="d0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
							';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'d1" value="1" onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
							';
					}
					if(isset($_POST[$b->idPrivilege.'s0'])){
						$query="UPDATE `usersprivilege` SET s='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'s1'])){
						$query="UPDATE `usersprivilege` SET s='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c0'])){
						$query="UPDATE `usersprivilege` SET c='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c1'])){
						$query="UPDATE `usersprivilege` SET c='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u0'])){
						$query="UPDATE `usersprivilege` SET u='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>MODIFIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>MODIFIER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u1'])){
						$query="UPDATE `usersprivilege` SET u='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>MODIFIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>MODIFIER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d0'])){
						$query="UPDATE `usersprivilege` SET d='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Suppression du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d1'])){
						$query="UPDATE `usersprivilege` SET d='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					echo'		
								</ul>
					';
				}
		}
		if($o->bloc == 'CONTRAT'){
			echo'
							<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
			$query2="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			$result2=QueryExcuteWhile($query2);
			while ($b=mysqli_fetch_object($result2)){
					echo'
								<ul class="branch">
						';			
					if($b->s){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'s0" value="1">
											<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'s1" value="1" onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
						';
					}
					if($b->c){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'c0" value="1">
											<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-file"></p></a> Créer
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'c1" value="1" onChange="this.form.submit()">
											<a><p class="icon-file"></p></a> Créer
										</form>
									</li>
						';
					}
					if($b->u){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'u0" value="1">
											<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-repeat"></p></a> Renouveler
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'u1" value="1" onChange="this.form.submit()">
											<a><p class="icon-repeat"></p></a> Renouveler
										</form>
									</li>
						';
					}
					if($b->d){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'d0" value="1">
											<input type="checkbox" name="d0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'d1" value="1" onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
						';
					}
					if(isset($_POST[$b->idPrivilege.'s0'])){
						$query="UPDATE `usersprivilege` SET s='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'s1'])){
						$query="UPDATE `usersprivilege` SET s='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c0'])){
						$query="UPDATE `usersprivilege` SET c='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c1'])){
						$query="UPDATE `usersprivilege` SET c='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u0'])){
						$query="UPDATE `usersprivilege` SET u='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>RENOUVELER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u1'])){
						$query="UPDATE `usersprivilege` SET u='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>RENOUVELER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d0'])){
						$query="UPDATE `usersprivilege` SET d='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Suppression du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d1'])){
						$query="UPDATE `usersprivilege` SET d='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					echo'		
								</ul>
					';
				}
		}
		if($o->bloc == 'CAISSE'){
			echo'
							<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
			$query2="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			$result2=QueryExcuteWhile($query2);
			while ($b=mysqli_fetch_object($result2)){
					echo'
								<ul class="branch">
						';			
					if($b->s){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'s0" value="1">
											<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-book"></p></a> Journal
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'s1" value="1" onChange="this.form.submit()">
											<a><p class="icon-book"></p></a> Journal
										</form>
									</li>
						';
					}
					if($b->c){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'c0" value="1">
											<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-signout"></p></a> Décaissement
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'c1" value="1" onChange="this.form.submit()">
											<a><p class="icon-signout"></p></a> Décaissement
										</form>
									</li>
						';
					}
					if($b->u){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'u0" value="1">
											<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-money"></p></a> Echéancier
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'u1" value="1" onChange="this.form.submit()">
											<a><p class="icon-money"></p></a> Echéancier
										</form>
									</li>
						';
					}
					if(isset($_POST[$b->idPrivilege.'s0'])){
						$query="UPDATE `usersprivilege` SET s='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>JOURNAL</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'s1'])){
						$query="UPDATE `usersprivilege` SET s='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>JOURNAL</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c0'])){
						$query="UPDATE `usersprivilege` SET c='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>DECAISSEMENT</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c1'])){
						$query="UPDATE `usersprivilege` SET c='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>DECAISSEMENT</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u0'])){
						$query="UPDATE `usersprivilege` SET u='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>ECHEANCIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u1'])){
						$query="UPDATE `usersprivilege` SET u='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>ECHEANCIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					echo'		
								</ul>
					';
				}
		}
		echo'
							</li>
		';
	}
						echo'	
						</ul>		
					</li>
				</ul>
			</div>
		</ul>
		';
	}
}

/*CLIENT*/
function ClientGetInfo($idClient){
	$QueryClientGetInfo="SELECT * FROM client WHERE idClient='$idClient';";
	if($o=(QueryExcute("mysqli_fetch_object", $QueryClientGetInfo))){return $o;}
}
function ClientDropModal($idClient){
	$ObjectClient=ClientGetInfo($idClient);
	echo'
	<div id="myModal_del" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_del" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel_del"><center>Confirmation de suppression</center></h3>
		</div>
		<div class="modal-body">
			<p>Vous êtes sur de vouloire supprimer le client <strong>'.$ObjectClient->FamilyName.' '.$ObjectClient->FirstName.'</strong>? <br> La supprission du client entraine la suprission de toutes ces activités, et cette action est <strong>irréversible!</strong></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<button onClick="document.location.href=\'remove?id='.$ObjectClient->idClient.'\'" data-dismiss="modal" class="btn btn-primary">Confirm</button>
		</div>
	</div>
	';
}
function ClientDrop($idClient, $O){
	$query="DELETE FROM `client` WHERE `idClient`='$idClient';";
	QueryExcute('', $query);
	$user_nom=$_SESSION['user_nom'];
	$user_prenom=$_SESSION['user_prenom'];
	NotifAllWrite('', '', '<a href="#">'.$user_nom.' '.$user_prenom.' a supprimé le client, '.$O->FamilyName.' '.$O->FirstName);
	LogWrite('Suppression de de client '.$O->FamilyName.' '.$O->FirstName);
	Redirect('ili-modules/client/liste');
}
function ClientUpdateInfo(){
	//Form
	if( (isset($_POST['idClient']))&&(isset($_POST['FamilyName']))&&(isset($_POST['FirstName']))&&(isset($_POST['Adress']))&&(isset($_POST['Phone'])) ){
		global $URL;
		$idClient 	= $_POST['idClient'];
		$FamilyName = $_POST['FamilyName'];
		$FirstName 	= $_POST['FirstName'];
		$Phone		= $_POST['Phone'];
		$Adress 	= $_POST['Adress'];
		$idUser		= $_SESSION['user_id'];
		$User		= $_SESSION['user_nom_prenom'];
		QueryExcute("", "UPDATE `client` SET `FamilyName` = '$FamilyName', `FirstName` = '$FirstName', `Phone` = '$Phone', `Adress` = '$Adress' WHERE `idClient` = '$idClient'");
		NotifAllWrite('$idUser', '', '<a href="'.$URL.'ili-modules/client/client?id='.$idClient.'">'.$User.' a modifié le client, '.$FamilyName.' '.$FirstName);
		LogWrite("Modification de client : <a href=\"ili-modules/client/client?id=".$idClient."\">".$FamilyName." ".$FirstName."</a>");
		RedirectJS('ili-modules/client/client?id='.$idClient);
	}
}
function ClientInsert(){
	//Form Variables
	if( (isset($_POST['idClient'])) && (isset($_POST['FamilyName'])) && (isset($_POST['FirstName'])) && (isset($_POST['Phone'])) && (isset($_POST['Adress'])) ){
		global $URL;
		$idClient	=addslashes($_POST['idClient']);
		$FamilyName	=addslashes($_POST['FamilyName']);
		$FirstName	=addslashes($_POST['FirstName']);
		$Phone		=addslashes($_POST['Phone']);
		$Adress		=addslashes($_POST['Adress']);
		$idUser		=$_SESSION['user_id'];
		$User		=$_SESSION['user_nom_prenom'];
		if((QueryExcute("mysqli_fetch_row", "SELECT * FROM client WHERE idClient='$idClient'"))==0){
			QueryExcute("", "INSERT INTO `client` VALUES ('$idClient', '$FamilyName', '$FirstName', '$Phone', '$Adress', '$idUser');");
			NotifAllWrite('', '', '<a href="'.$URL.'ili-modules/client/client?id='.$idClient.'">'.$User.' a creé un nouveau client , '.$FamilyName.' '.$FirstName);
			LogWrite("Création de client : <a href=\"ili-modules/client/client?id=".$idClient."\">".$idClient."</a>");
			RedirectJS('ili-modules/client/client?id='.$idClient);
		}
		else{RedirectJS('ili-modules/client/add?message=16');}
	}
}

/*CAISSE*/
function PaymentInfo($idPayment){
	$sql="
		SELECT * FROM `contractcycle`, `insurancecontract`, `payment` WHERE 
		contractcycle.idContract=insurancecontract.idContract 
		AND 
		payment.idPayment=contractcycle.idPayment 
		AND 
		payment.idPayment='$idPayment';
	";
	$o=QueryExcute("mysqli_fetch_object",$sql);
	if($o){return $o;}
}

/*STATISTIQUE*/
function StatisticClientGetSum(){
	$q="SELECT * FROM client";
	$o=QueryExcute("mysqli_num_rows", $q);
	echo $o;
}
function StatisticContractGetSum(){
	$q="SELECT * FROM `contrat`";
	$o=QueryExcute("mysqli_num_rows", $q);
	echo $o;
}
function StatisticContractRenewGetSum(){
	$q="SELECT * FROM `contrat_ren` ";
	$o=QueryExcute("mysqli_num_rows", $q);
	echo $o;
}
function StatisticMessageGetSum(){
	$q="SELECT * FROM `message` ";
	$o=QueryExcute("mysqli_num_rows", $q);
	echo $o;
}
function StatisticLogGetSum(){
	$q="SELECT * FROM `LogSystem`";
	$o=QueryExcute("mysqli_num_rows", $q);
	echo $o;
}
function StatisticSalesRevenuesGet(){
	$q="SELECT (SUM(montant_ren)+(montant)) as total FROM contrat, contrat_ren WHERE contrat.id_cnt=contrat_ren.id_cnt_ren";
	$o=QueryExcute("mysqli_fetch_object", $q);
	echo sprintf("%.3f",$o->total);
}
?>