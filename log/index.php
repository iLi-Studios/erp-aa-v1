<?php 
include"../ili-functions/functions.php";
Authorization('3');
function LogRead(){
	$result=QueryExcuteWhile("SELECT * FROM `logsystem` ORDER BY idLog DESC");
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
function LogArchiveListing(){
	$nb_fichier = 0;
	echo '<ul class="item-list scroller padding" data-height="300" data-always-visible="1">';
	if($dossier = opendir('./')){
		while(false !== ($fichier = readdir($dossier))){
			if($fichier != '.' && $fichier != '..' && $fichier != 'index.php' && $fichier != 'export.php'){
				$nb_fichier++; // On incrémente le compteur de 1
				echo '
					<li>
					<a href="./' . $fichier . '" download="'.$fichier.'"><i class="icon-save"></i></a>
					<a href="./' . $fichier . '" target="new" >' . $fichier . '</a>
					</li>';
			} // On ferme le if (qui permet de ne pas afficher index.php, etc.)
		} // On termine la boucle
		echo '</ul><br />';
		echo 'Il y a <strong>' . $nb_fichier .'</strong> fichier(s) dans le dossier';
		closedir($dossier);
	}
	else echo 'Le dossier n\' a pas pu être ouvert';
}
function LogExportButton($MinLagneLog){
	$o=QueryExcute('mysqli_num_rows', 'SELECT * FROM `logsystem`;');
	if($o>=$MinLagneLog){
		echo'<span class="tools"> <a href="export" class="icon-upload-alt" data-original-title="Archivage du log"></a></span>';
	}
}
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
<link rel="shortcut icon" href="../ili-upload/favicon.png">
<link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../ili-style/css/style.css" rel="stylesheet" />
<link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link href="../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/uniform/css/uniform.default.css" />
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
					<h3 class="page-title"> Utilisateurs <small> Profil</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL;?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li> <a href="">Journal du système</a><span class="divider-last">&nbsp;</span></li>
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
			<!-- BEGIN ADVANCED TABLE widget-->
			<div class="row-fluid">
				<div class="span9"> 
					<!-- BEGIN EXAMPLE TABLE widget-->
					<div class="widget">
						<div class="widget-title">
							<h4><i class="icon-reorder"></i> Journal système</h4>
							<?php LogExportButton($MinLigneLogToArchive); ?>
						</div>
						<div class="widget-body">
							<table class="table table-striped table-bordered" id="sample_1">
								<thead>
									<tr>
										<th width="2%"></th>
										<th width="3%">Id</th>
										<th width="10%">Opératuer</th>
										<th class="hidden-phone" width="65%">Opération</th>
										<th class="hidden-phone" width="20%">Date</th>
									</tr>
								</thead>
								<tbody>
									<?php LogRead();?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE widget--> 
				</div>
				<div class="span3">
					<div class="widget">
						<div class="widget-title">
							<h4><i class="icon-book"></i>Archive</h4>
							<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a></span> </div>
						<div class="widget-body"><?php LogArchiveListing();?></div>
					</div>
					<!-- END ORDERED LISTS PORTLET--> 					
				</div>
			</div>
			
			<!-- END ADVANCED TABLE widget--> 
			
			<!-- END PAGE CONTENT--> 
		</div>
		<!-- END PAGE CONTAINER--> 
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
<script src="../ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="../ili-style/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="../ili-style/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
<script src="../ili-style/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script> 
<script src="../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="../ili-style/js/jquery.blockui.js"></script> 
<script src="../ili-style/js/jquery.cookie.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
        <script src="js/excanvas.js"></script>
        <script src="js/respond.js"></script>
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
</body>
<!-- END BODY -->
</html>
