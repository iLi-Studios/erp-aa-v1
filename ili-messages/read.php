<?php 
include"../ili-functions/functions.php";
autorisation('2');
$id_message=$_GET['id'];
function msg_info($id){
	$query="SELECT * FROM system_msg WHERE id='$id';";
	$result=query_excute_while($query);
	$o=mysqli_fetch_object($result);
	return $o;
}
$info_message=msg_info($id_message);
function msg_rep_info($id){
	$query="SELECT * FROM system_msg_rep WHERE id_rep='$id';";
	$result=query_excute_while($query);
	$o=mysqli_fetch_object($result);
	return $o;
}
if($info_message==''){redirect('index?message=15');}
if(isset($_GET['id2'])){
	$id_message_rep=$_GET['id2'];
	//$msg_rep_info=msg_rep_info($id_message_rep);
	//if($msg_rep_info==''){redirect('index?message=15');}
}else{$id_message_rep='';}
function vu_message($id){
	$query="UPDATE `system_msg` SET `vu` = '1' WHERE `system_msg`.`id` = $id;";
	query_execute_insert($query);
}
function vu_message_rep($id){
	$query="UPDATE `system_msg_rep` SET `vu_rep` = '1' WHERE `id_rep` = $id;";
	query_execute_insert($query);
}
if($id_message_rep!=false){vu_message_rep($id_message_rep);}
vu_message($id_message);
function receever_rep($id_message, $id_message_rep){
	$id_user=$_SESSION['user_id'];
	$q="SELECT user_envoie, user_reception FROM system_msg WHERE id='$id_message';";
	$q2="SELECT user_envoie_rep, user_reception_rep FROM system_msg_rep WHERE id_rep='$id_message_rep';";
	if($id_message_rep!=''){$q=$q2;}
	$o=query_execute("mysqli_fetch_row", $q);
	if($o[0]==$id_user){echo $o[1];}else{echo $o[0];}
}
function get_messages($id){
	global $site;
	$q1="SELECT * FROM `system_msg` WHERE `id`='$id';";
	$r1=query_excute_while($q1);
	while ($o1=mysqli_fetch_object($r1)){
		//msg_rep
		$q2="SELECT * FROM  system_msg, system_msg_rep WHERE system_msg_rep.id_msg=system_msg.id AND system_msg.id='$id' ORDER BY id_rep DESC;";
		$r2=query_excute_while($q2);
		while ($o2=mysqli_fetch_object($r2)){
			//envoi
			$sender2=get_user_info($o2->user_envoie_rep);
			if(isset($sender2->img_link)){$img2=$sender2->img_link;}else{$img2='';}
			echo'
			<div class="msg-time-chat"> <a href="#" class="message-img"><img class="avatar" src="'.$img2.'" alt=""></a>
				<div class="message-body msg-in">
					<div class="text">
						<p class="attribution"><a href="'.$site.'ili-users/user_profil?id='.$sender2->id_user.'">'.$sender2->nom.' '.$sender2->prenom.'</a> ';?><?php diff_date($o2->date_msg); ?><?php echo'</p>
						<p> '.$o2->message_rep.' </p>
					</div>
				</div>
			</div>
			';	
		}
		//msg
		$sender=get_user_info($o1->user_envoie);
		if(isset($sender->img_link)){$img=$sender->img_link;}else{$img='';}
		echo'
		<div class="msg-time-chat"> <a href="#" class="message-img"><img class="avatar" src="'.$img.'" alt=""></a>
			<div class="message-body msg-in">
				<div class="text">
					<p class="attribution"><a href="'.$site.'ili-users/user_profil?id='.$sender->id_user.'">'.$sender->nom.' '.$sender->prenom.'</a> ';?><?php diff_date($o1->date_msg); ?><?php echo'</p>
					<p> '.$o1->message.' </p>
				</div>
			</div>
		</div>
		';	
	}
}
if( isset($_POST['msg']) && isset($_POST['usr_recp'])){
	$msg = addslashes($_POST['msg']);
	$date= date("d-m-Y H:i:s");
	$user_envoie= $_SESSION['user_id'];
	$user_reception=$_POST['usr_recp'];
	$query = "INSERT INTO `system_msg_rep` VALUES (NULL, '$id_message', '$user_envoie', '$user_reception', '$msg', '$date', '0');";
	echo $query;
	query_execute_insert($query);
	redirect();
}
function verrouillage_msg($id_msg){
	$id_user=$_SESSION['user_id'];
	$query="UPDATE system_msg SET fermer_par='$id_user' WHERE id='$id_msg';";
	query_execute_insert($query);
	redirect();
}
if( isset($_POST['v_id_msg']) ){
	$v_id_msg=$_POST['v_id_msg'];
	verrouillage_msg($v_id_msg);
}
?>
<!DOCTYPE html>
<!--
iLi-ERP
Développer par : SAKLY AYOUB
Société	: iLi-Studios SARL
Site : http://www.ili-studios.com/
-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fr">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title><?php echo $sytem_title;?></title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../ili-style/css/style.css" rel="stylesheet" />
<link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link href="../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/uniform/css/uniform.default.css" />
<link href="../ili-style/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
<link href="../ili-style/assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<?php include"../ili-functions/fragments/page_header.php";?>
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
	<?php include"../ili-functions/fragments/sidebar.php";?>
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12"> 
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title"> Messagerie </h3>
					<ul class="breadcrumb">
						<li> <a href="#"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="../">Dashboard</a><span class="divider">&nbsp;</span></li>
						<li><a href="#">Messagerie</a><span class="divider-last">&nbsp;</span></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB--> 
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div id="page">
			<?php if($info_message->fermer_par==''){
				echo'
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN  widget-->
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-reorder"></i> Editeur de message </h4>
							<span class="tools">
							   <a href="javascript:;" class="icon-chevron-down"></a>
							   </span>
							</div>
							<div class="widget-body form">
								<!-- BEGIN FORM-->
								<form action="" method="post" class="form-vertical">
									<div class="control-group">
										<div class="controls">
											<textarea class="span12 ckeditor" name="msg" rows="6"></textarea>
											<br>
											<center>
												<input type="hidden" name="usr_recp" value="'; receever_rep($id_message, $id_message_rep); echo'"/>
												<input type="reset" value=" Annuler" class="btn btn-info"/>
												<input type="submit" value=" Rependre" class="btn btn-success"/>
												</form>
												<br><br>';
												if( ($_SESSION['user_id_rank']>=3)||($info_message->user_envoie==$id_user) ){
													echo'
														<form action="" method="post">
															<input type="hidden" name="v_id_msg" value="'.$id_message.'">
															<input type="submit" value=" Verrouiller" class="btn btn-warning"/>
														</form>
													';
												}
												echo'
											</center>
										</div>
									</div>
								<!-- END FORM-->
							</div>
						</div>
						<!-- END EXTRAS widget-->
					</div>
				</div>';}
				?>
				<div class="row-fluid">
					<div class="span12"> 
						<!-- BEGIN CHAT PORTLET-->
						<div class="widget" id="">
							<div class="widget-title">
								<h4><i class="icon-comments-alt"></i> Sujet : <?php echo $info_message->subject; ?></h4>
								<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a></a> </span> </div>
							<div class="widget-body">
								<div class="timeline-messages"> 
									<?php 
										if($info_message->fermer_par!=''){
											$info_user=get_user_info($info_message->fermer_par);
											echo'<center><h4>Message fermer par : '.$info_user->nom.' '.$info_user->prenom.'</h4></center>';
										}
										get_messages($id_message); 
									?>	
								</div>
							</div>
						</div>
						<!-- END CHAT PORTLET--> 
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT--> 
		</div>
		<!-- BEGIN PAGE CONTAINER--> 
	</div>
	<!-- END PAGE --> 
</div>
<!-- END CONTAINER --> 
<!-- BEGIN FOOTER -->
<div id="footer"><?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="../ili-style/js/jquery-1.8.2.min.js"></script>    
   <script type="text/javascript" src="../ili-style/assets/ckeditor/ckeditor.js"></script>
   <script src="../ili-style/assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="../ili-style/assets/bootstrap/js/bootstrap-fileupload.js"></script>
   <script src="../ili-style/js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../ili-style/assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="../ili-style/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="../ili-style/assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="../ili-style/assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="../ili-style/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="../ili-style/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>   
   <script type="text/javascript" src="../ili-style/assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="../ili-style/assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="../ili-style/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="../ili-style/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="../ili-style/assets/fancybox/source/jquery.fancybox.pack.js"></script>
   <script src="../ili-style/js/scripts.js"></script>
   <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>