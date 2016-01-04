<?php
$id_user=$_SESSION['user_id'];
function num_message(){
	$id_user=$_SESSION['user_id'];
	$q1="SELECT COUNT(*) FROM system_msg WHERE user_reception='$id_user' AND vu='0';";
	$q2="SELECT COUNT(*) FROM system_msg, system_msg_rep
			WHERE
			(system_msg.user_envoie='$id_user' OR system_msg.user_reception='$id_user')
			AND 
			system_msg.vu='1'
			AND
			system_msg_rep.id_msg=system_msg.id
			AND
			system_msg_rep.user_reception_rep='$id_user'
			AND
			system_msg_rep.vu_rep='0';";

	$o1=query_execute("mysqli_fetch_row", $q1);
	$o2=query_execute("mysqli_fetch_row", $q2);
	$o=$o1[0]+$o2[0];
	if($o=='0'){echo '';}
	else{echo '<span class="badge badge-warning">'.$o.'</span>';}
}
function get_all_message(){
	global $site;
	//get message source
	$id_user=$_SESSION['user_id'];
	$q1="SELECT * FROM `system_msg` WHERE `user_reception`='$id_user' AND `vu`='0' ORDER BY id DESC LIMIT 3 ";	
	$r1=query_excute_while($q1);
	if(mysqli_num_rows($r1)>'0'){		
		while ($o1=mysqli_fetch_object($r1)){
			$s1=get_user_info($o1->user_envoie);
			if(isset($s1->img_link)){$img1=$s1->img_link;}else{$img1='';}
			echo'
			<li> 
				<a href="'.$site.'ili-messages/read?id='.$o1->id.'"> 
					<span class="photo">
						<img src="'.$img1.'" alt="avatar" />
					</span> 
					<span class="subject"> 
						<span class="from">'.$s1->nom.' '.$s1->prenom.'</span> 
					</span> 
					<span class="message"> '.$o1->subject.' </span> 
					<span class="small italic">';?><?php diff_date($o1->date_msg); ?><?php echo'</span>
				</a> 
			</li>
			';
		}
	}
	//get rep messages
	$q2="SELECT * FROM system_msg, system_msg_rep
			WHERE
			(system_msg.user_envoie='$id_user' OR system_msg.user_reception='$id_user')
			AND 
			system_msg.vu='1'
			AND
			system_msg_rep.id_msg=system_msg.id
			AND
			system_msg_rep.user_reception_rep='$id_user'
			AND
			system_msg_rep.vu_rep='0';
			";
	$r2=query_excute_while($q2);
	if(mysqli_num_rows($r2)>'0'){		
		while ($o2=mysqli_fetch_object($r2)){
			$s2=get_user_info($o2->user_envoie_rep);
			if(isset($s2->img_link)){$img2=$s2->img_link;}else{$img2='';}
			echo'
			<li> 
				<a href="'.$site.'ili-messages/read?id='.$o2->id.'&id2='.$o2->id_rep.'"> 
					<span class="photo">
						<img src="'.$img2.'" alt="avatar" />
					</span> 
					<span class="subject"> 
						<span class="from">'.$s2->nom.' '.$s2->prenom.'</span> 
					</span> 
					<span class="message"> '.$o2->subject.' </span> 
					<span class="small italic">';?><?php diff_date($o2->date_msg_rep); ?><?php echo'</span>
				</a> 
			</li>
			';
		}
	}
}
if( isset($_POST['nouveau_message']) ){
	redirect('ili-messages/start');
}
?>
<!-- BEGIN INBOX DROPDOWN -->
<li class="dropdown" id="header_inbox_bar"> 
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
		<i class="icon-envelope-alt"></i> <?php num_message(); ?> 
	</a>
	<ul class="dropdown-menu extended inbox">
		<li>
			<a href="#">
				<form action="" method="post" style="margin-bottom: 2%;">
					<input type="submit" value="Ecrire un nouveu message" style="margin-left:10%;line-height: 100%;border: 0;background: none;text-decoration: underline;" class="small italic"/>
					<input type="hidden" name="nouveau_message" value="nouveau_message">
				</form>
			</a>
		</li><!-- nouveau message-->
		<?php get_all_message(); ?>
		<li> <a href="<?php echo $site.'index';?>">Voire tous les messages</a> </li>
	</ul>
</li>






