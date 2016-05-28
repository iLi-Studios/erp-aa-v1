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
		if($privilege=='S'){if(!$s){Redirect('index?message=17');}}
		//C
		if($privilege=='C'){if(!$c){Redirect('index?message=17');}}
		//U
		if($privilege=='U'){if(!$u){Redirect('index?message=17');}}
		//D
		if($privilege=='D'){if(!$d){Redirect('index?message=17');}}
	}
}
function GetUserPanel($page, $var1, $var2){
	global $URL;
	if($page=='USERS'){
		$IfUserHasActivity=IfUserHasActivity($var1);
		//ADMIN
		if($_SESSION['user_idRank']>=3){
			//C IN ALL
			echo'<a href="user_add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';	
			//U IN ALL
			echo'<a href="user_edit?id='.$var1.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
			//D IN ALL BUT HIM
			if($IfUserHasActivity){if($_SESSION['user_id']!=$var1){echo'<a href="#myModal_del'.$var1.'" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}}
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
			if($IfUserHasActivity){if( ($d) && ($_SESSION['user_id']!=$var1) && ($_SESSION['user_idRank']>=$var2) ){echo'<a href="#myModal_del'.$var1.'" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}}
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
		$IfClientHasActivity=IfClientHasActivity($var1);
		// ADMIN
		if($_SESSION['user_idRank']>=3){
			//C
			echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';
			//U=B
			echo'<a href="edit?id='.$ObjectClient->idClient.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
			//D
			if(!$IfClientHasActivity){echo'<a href="#myModal_del" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
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
			if(!$IfClientHasActivity){if($d){echo'<a href="#myModal_del" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}}
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
	echo'<script language="Javascript">document.location.href="'.$URL.$page.'"</script>';
}
function Refresh(){
	echo'<script language="Javascript">Javascript:history.go(-1)</script>';
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
function FormatEnDateToFr($dateEN){
	$dateFR=date_create($dateEN);
	echo date_format($dateFR, 'd-m-Y');
}
$Now= date("d-m-Y");
$NowEN= date("Y-m-d");
$Timestamp = date("d-m-Y H:i:s");

/*LOG*/
function LogWrite($Description){
	global $Timestamp;
	$idUser=$_SESSION['user_id'];
	QueryExcute("", "INSERT INTO `logsystem` (`idLog`, `idUser`, `Timestamp`, `Description`) VALUES (NULL, '$idUser', '$Timestamp', '$Description');");
}
function ErrorGet($message){
	if(isset($_GET['message'])){
		AlertGet($_GET['message']);
	}
}

/*NOTIFICATION*/
function NotifGetAll(){
	$idUser=$_SESSION['user_id'];
	$result=QueryExcuteWhile("SELECT * FROM `notificationsystem` WHERE `idUser`='$idUser' ORDER BY idNotification DESC LIMIT 30");
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
function NotifWrite($user, $Description){
	global $Timestamp;
	QueryExcute('', "INSERT INTO `notificationsystem` VALUES (NULL, '$user', '$Description', '$Timestamp', '0');");
}
function NotifAllWrite($user_dont_notif1, $user_dont_notif2, $Description){
	$result=QueryExcuteWhile("SELECT idUser FROM users WHERE idUser<>'$user_dont_notif1' AND idUser<>'$user_dont_notif2' ");
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

/*USER*/
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
function UserSocialGet($idUser){
	$user=UserGetInfo($idUser);
	if($user->fbAccount){echo'<li><a href="'.$user->fbAccount.'" target="new"><i class="icon-facebook"></i> Compte Facebook</a></li>';}else{echo'<li><i class="icon-facebook"></i> Pas de Facebook </a></li>';}
	if($user->linkedinAccount){echo'<li><a href="'.$user->linkedinAccount.'" target="new"><i class="icon-linkedinAccount"></i> Compte Linkedin</a></li>';}else{echo'<li><i class="icon-linkedinAccount"></i> Pas de compte Linkedin </a></li>';}
	if($user->githubAccount){echo'<li><a href="'.$user->githubAccount.'" target="new"><i class="icon-github"></i> Compte github</a></li>';}else{echo'<li><i class="icon-github"></i> Pas de compte Github </a></li>';}
}
function UserGetIcon($Rank){
	if($Rank==1){echo'icon-ban-circle';}
	if($Rank==2){echo'icon-user';}
	if($Rank==3){echo'icon-briefcase';}
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
function IfUserHasActivity($idUser){
	$o1=QueryExcute('mysqli_fetch_row', "SELECT * FROM `client` WHERE `CreatedBy`='$idUser';");
	$o2=QueryExcute('mysqli_fetch_row', "SELECT * FROM `message` WHERE `FromUser` or `ToUser` ='$idUser';");
	$o3=QueryExcute('mysqli_fetch_row', "SELECT * FROM `contractcycle` WHERE `CreatedBy`='$idUser';");
	$o4=QueryExcute('mysqli_fetch_row', "SELECT * FROM `payment` WHERE `RecevedBy`='$idUser';");
	$o5=QueryExcute('mysqli_fetch_row', "SELECT * FROM `notificationsystem` WHERE `idUser`='$idUser';");
	$o6=QueryExcute('mysqli_fetch_row', "SELECT * FROM `logsystem` WHERE `idUser`='$idUser';");	
	if($o1||$o2||$o3||$o4||$o5||$o6){return 1;}else{return 0;}
}

/*CLIENT*/
function ClientGetInfo($idClient){
	$QueryClientGetInfo="SELECT * FROM client WHERE idClient='$idClient';";
	if($o=(QueryExcute("mysqli_fetch_object", $QueryClientGetInfo))){return $o;}
}
function IfClientHasActivity($idClient){
	$o=QueryExcute('mysqli_fetch_row', "SELECT * FROM `insurancecontract` WHERE `idClient`='$idClient';");
	if($o){return 1;}else{return 0;}
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

/*Company*/
function CompanyGetInfo(){
	$query="SELECT * FROM `company`";
	if($o=(QueryExcute("mysqli_fetch_object", $query))){return $o;}
}
?>