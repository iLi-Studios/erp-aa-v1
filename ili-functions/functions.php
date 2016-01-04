<?php
/*SYSTEM INCLUDES*/
include"config.php";
include"alert.php";
include"database.php";

/*SYSTEM GLOBALS*/
if (!isset($_SESSION)){
	session_start();
	//duré de vie de la session 30min
	ini_set("session.lifetime",1800);
}
function age($date){
	return (int) ((time() - strtotime($date)) / 3600 / 24 / 365);
}
function diff_date($date){
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
function expire_dans($date){	
	$date2 = date("d-m-Y");
	$n = ((strtotime($date)) - strtotime($date2));
	$n = round($n / (60*60*24)); 
	if($n==1){echo '<span class="label label-warning">Expiration dans moins d\'un (1) jour<span>';}
	if( ($n>1)&&($n<=90) ){echo '<span class="label label-warning">Expiration dans moins de ('.abs($n).') jours<span>';} //Jaune
	if($n==0){echo '<span class="label label-important">Expire aujourd\'hui<span>';} //Rouge
	if($n==-1){echo '<span class="label label-important">Expiré depuis un ('.abs($n).') jours<span>';} //Rouge
	if( ($n>-90)&&($n<-1) ){echo '<span class="label label-important">Expiré depuis ('.abs($n).') jours<span>';} //Rouge
	if($n<-90){echo '<span class="label">Innactif</span>';} //Noire
	if($n>90){echo '<span class="label label-success">Actif</span>';} //Vers
}
function write_log($operation){
	$now= date("d-m-Y H:i:s"); 
	$id_user=$_SESSION['user_id'];
	$query="INSERT INTO `system_log` (`id`, `id_user`, `date_operation`, `operation`) VALUES (NULL, '$id_user', '$now', '$operation'); ";
	query_execute_insert($query);
}

/*SYSTEM REDERECTION*/
function redirect($page){
	global $site;
	header("Location: ".$site.$page);
}
function redirect_javascript($page){
	global $site;
	echo'<script language="Javascript">document.location.href="'.$site.$page.'"</script>';
}
function actualiser(){
	echo'<script language="Javascript">Javascript:history.go(-1)</script>';
}

/*SYSTEM NOTIFICATION*/
function get_all_notification(){
	$id_user=$_SESSION['user_id'];
	$query="SELECT * FROM `system_notif` WHERE `id_user`='$id_user' ORDER BY id DESC LIMIT 30";
	$result=query_excute_while($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
			<li> 
				'.$o->notification.' 
					<span class="small italic" style="margin-left:4%"><br>'?><?php diff_date($o->date_notif); echo'
						<br><br>
						<form action="" method="post" style="margin-bottom: -3%;margin-top: -10%;">
						</form>
					</span>
				</a>
			</li>				
		';
	}
}
function notif($user, $notif){
	$date_notif = date("d-m-Y H:i:s");
	$query="INSERT INTO `system_notif` VALUES (NULL, '$user', '$notif', '$date_notif', '0');";
	query_execute_insert($query);
}
function notif_all($user_dont_notif1, $user_dont_notif2, $notif){
	$query_users = "SELECT id_user FROM users WHERE id_user<>'$user_dont_notif1' AND id_user<>'$user_dont_notif2' ";
	$result_users=query_excute_while($query_users);
	while ($o=mysqli_fetch_object($result_users)){notif($o->id_user, $notif);}
}

/*SYSTEM MESSAGE*/
function etat_msg($id, $id_rep){
	$id_user=$_SESSION['user_id'];
	$q="SELECT * FROM system_msg WHERE id='$id' AND user_reception='$id_user';";
	$q1="SELECT * FROM system_msg, system_msg_rep WHERE id='$id' AND id_rep='$id_rep' AND user_reception_rep='$id_user';";
	$q2="SELECT * FROM system_msg, system_msg_rep WHERE id='$id' AND id_rep='$id_rep' AND user_envoie_rep='$id_user';";
	if($id_rep!=''){$q=$q1;}
	$o=query_execute("mysqli_fetch_object", $q);
	if($o){
		if($id_rep==''){if(($o->vu=='0')&&($o->user_reception==$id_user)){echo '<span class="label label label-success">Nouveau</span>';}}
		else{if(($o->vu_rep=='0')&&($o->user_reception_rep=$id_user)){echo '<span class="label label label-success">Nouveau</span>';}}
	}
}
function etat_msg2($id){
	$q="SELECT * FROM system_msg WHERE id='$id';";
	$o=query_execute("mysqli_fetch_object", $q);
	if($o->fermer_par!=''){echo '<span class="label label label-default">Verouiller</span>';}
}
function get_all_msg(){
	$id_user=$_SESSION['user_id'];
	$q="SELECT * FROM system_msg
			WHERE
			(user_envoie='$id_user' OR user_reception='$id_user')
			ORDER BY id DESC;";
	$r=query_excute_while($q);
	while ($o=mysqli_fetch_object($r)){
		$info_user=get_user_info($o->user_envoie);
		$id=$o->id;
		$q1="SELECT * FROM system_msg, system_msg_rep
			WHERE
			system_msg_rep.id_msg=system_msg.id
			AND
			system_msg.id='$id'
			AND
			id_rep=(SELECT MAX(id_rep) FROM system_msg_rep)
			;";
			$o1=query_execute("mysqli_num_rows", $q1);
			if($o1>='1'){$rx=query_excute_while($q1);$ox=mysqli_fetch_object($rx);}
			if($o1>='1'){$id_rep=$ox->id_rep;}else{$id_rep='';}
			echo'
			<tr>
				<th style="width:4%;"><input type="checkbox"></th>
				<th style="width:20%"> <a href="ili-users/user_profil?id='.$o->user_envoie.'">'.$info_user->nom.' '.$info_user->prenom.'</a> </th>
				<th style="width:46%"><strong> <a href="ili-messages/read?id='.$id.'&id2='.$id_rep.'">'.$o->subject.'</a> </strong></th>
				<th style="width:12%">'?><?php if($o1>='1'){etat_msg($ox->id, $id_rep);}		else{etat_msg($o->id, '');} etat_msg2($o->id); echo' </th>
				<th style="width:18%"> ';?><?php if($o1>='1'){diff_date($ox->date_msg_rep);}else{diff_date($o->date_msg);} echo' </th>
			</tr>
			';
	}		
}

/*AUTORISATION*/
function autorisation($id){
	if(!isset($_SESSION['user_id'])){session_destroy();redirect('login?message=1');}
	//revérifier
	else{if($_SESSION['user_id_rank']<$id){redirect('index?message=17');}
	}
}
function autorisation_double_check_privilege($bloc, $privilege){
	if($_SESSION['user_id_rank']==2){
		$up=user_privileges("$bloc", $_SESSION['user_id']);$s=$up->s;$c=$up->c;$u=$up->u;$d=$up->d;
		//S
		if($privilege=='S'){if(!$s){redirect_javascript('index?message=17');}}
		//C
		if($privilege=='C'){if(!$c){redirect_javascript('index?message=17');}}
		//U
		if($privilege=='U'){if(!$u){redirect_javascript('index?message=17');}}
		//D
		if($privilege=='D'){if(!$d){redirect_javascript('index?message=17');}}
	}
}

/*ETABLISSEMENT*/
function get_ets_info(){
	$query="SELECT * FROM etablissement;";
	if($o=(query_execute("mysqli_fetch_object", $query))){return $o;}
}

/*USER*/
function get_user_info($id){
	$query="SELECT * FROM users, users_rank WHERE users.id_user='$id' AND users.id_rank=users_rank.id_rank";
	if($o=(query_execute("mysqli_fetch_object", $query))){return $o;}
}
function user_privileges($bloc, $id_user){
	$query="SELECT * FROM `users_privileges` WHERE `id_user`='$id_user' AND `bloc`='$bloc';";
	$o = query_execute("mysqli_fetch_object", $query);
	return $o;
}

/*CLIENT*/
function nbr_client(){
	$q="SELECT * FROM client";
	$o=query_execute("mysqli_num_rows", $q);
	echo $o;
}
function get_client_info($id){
	$query="SELECT * FROM client WHERE id_clt='$id';";
	if($o=(query_execute("mysqli_fetch_object", $query))){return $o;}
}


/*ARTICLE*/
function nbr_cnt(){
	$q="SELECT * FROM `contrat`";
	$o=query_execute("mysqli_num_rows", $q);
	echo $o;
}

function nbr_rnv(){
	$q="SELECT * FROM `contrat_ren` ";
	$o=query_execute("mysqli_num_rows", $q);
	echo $o;
}

function nbr_msg(){
	$q="SELECT * FROM `system_msg` ";
	$o=query_execute("mysqli_num_rows", $q);
	echo $o;
}

function nbr_log(){
	$q="SELECT * FROM `system_log`";
	$o=query_execute("mysqli_num_rows", $q);
	echo $o;
}

function fond(){
	$q="SELECT (SUM(montant_ren)+(montant)) as total FROM contrat, contrat_ren WHERE contrat.id_cnt=contrat_ren.id_cnt_ren";
	$o=query_execute("mysqli_fetch_object", $q);
	echo sprintf("%.3f",$o->total);
}




























?>