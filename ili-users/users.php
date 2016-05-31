<?php 
include"../ili-functions/functions.php";
function UserGetList(){
	$query="SELECT * FROM users, usersrank WHERE users.idRank=usersrank.idRank";
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
Authorization('2');
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
					<h3 class="page-title"> Utilisateurs <small> Infos globales</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL ;?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li> <a href="<?php echo $URL ;?>ili-users/users">Utilisateurs du système</a><span class="divider-last">&nbsp;</span></li>
						<li class="pull-right search-wrap">
							<form class="hidden-phone">
								<div class="search-input-area">
									<input id=" " class="search-query" type="text" placeholder="Recherche ?">
									<i class="icon-search"></i> </div>
							</form>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB--> 
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
					<?php ErrorGet('message'); ?>
					<?php UserGetList(); ?>
				</div>
				<!-- END PAGE CONTENT--> 
			</div>
			<!-- END PAGE CONTAINER--> 
		</div>
		<!-- END PAGE --> 
	</div>
	<!-- END CONTAINER --> 
</div>
<!-- BEGIN FOOTER -->
<div id="footer"><?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
<!-- END FOOTER --> 
<!-- BEGIN JAVASCRIPTS --> 
<!-- Load javascripts at bottom, this will reduce page load time --> 
<script src="../ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="../ili-style/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="../ili-style/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
<script src="../ili-style/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script> 
<script src="../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="../ili-style/js/jquery.blockui.js"></script> 
<script src="../ili-style/js/jquery.cookie.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
        <script src="../ili-style/js/excanvas.js"></script>
        <script src="../ili-style/js/respond.js"></script>
        <![endif]--> 
<script src="../ili-style/assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jquery-knob/js/jquery.knob.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.resize.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.pie.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.stack.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.crosshair.js"></script> 
<script src="../ili-style/js/jquery.peity.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/data-tables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="../ili-style/assets/data-tables/DT_bootstrap.js"></script> 
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