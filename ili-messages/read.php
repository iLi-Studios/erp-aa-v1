<?php 
include"../ili-functions/functions.php";
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
Authorization('2');
$idMessage=$_GET['id'];
$info_message=MessageGetInfo($idMessage);
if($info_message==''){Redirect('index?message=15');}
if(isset($_GET['id2'])){$idDiscussion=$_GET['id2'];}else{$idDiscussion='';}
if($idDiscussion!=false){DiscussionMakeSee($idDiscussion);}
MessageMakeSee($idMessage);
if(isset($_POST['Seen'])){$Seen=$_POST['Seen'];MessageLock($Seen);}
?>
<!DOCTYPE html>
<?php echo $author; ?>
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
<?php echo $META_description;?>
<?php echo $META_author;?>
<link rel="shortcut icon" href="ili-upload/favicon.png">
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
				<?php MessageRead($idMessage, $idDiscussion, $info_message); ?>
				<div class="row-fluid">
					<div class="span12"> 
						<!-- BEGIN CHAT PORTLET-->
						<div class="widget" id="">
							<div class="widget-title">
								<h4><i class="icon-comments-alt"></i> Sujet : <?php echo $info_message->Subject; ?></h4>
								<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a></a> </span> </div>
							<div class="widget-body">
								<div class="timeline-messages">
									<?php 
										if($info_message->ClosedBy!=''){
											$info_user=UserGetInfo($info_message->ClosedBy);
											echo'<center><h4>Message fermer par : '.$info_user->FamilyName.' '.$info_user->FirstName.'</h4></center>';
										}
										MessageGet($idMessage); 
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