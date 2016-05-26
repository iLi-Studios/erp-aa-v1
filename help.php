<?php 
include"ili-functions/functions.php";
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
<meta content="iLi-ERP" name="description" />
<meta content="SAKLY AYOUB" name="author" />
<link rel="shortcut icon" href="ili-modules/caisse/ili-upload/favicon.png">
<link href="ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="ili-style/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
<link href="ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="ili-style/css/style.css" rel="stylesheet" />
<link href="ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link rel="stylesheet" type="text/css" href="ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
<link href="ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="ili-style/assets/uniform/css/uniform.default.css" />
<link rel="stylesheet" type="text/css" href="ili-style/assets/bootstrap-datepicker/css/datepicker.css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php include"ili-functions/fragments/page_header.php";?>
<!-- END HEADER --> 
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
<!-- BEGIN SIDEBAR -->
<?php include"ili-functions/fragments/sidebar.php";?>
<!-- END SIDEBAR --> 
<!-- BEGIN PAGE -->
<div id="main-content"> 
	<!-- BEGIN PAGE CONTAINER-->
	<div class="container-fluid"> 
		<!-- BEGIN PAGE HEADER-->
		<div class="row-fluid">
			<div class="span12">
				<h3 class="page-title"> Dashboard <small> Aide</small> </h3>
				<ul class="breadcrumb">
					<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
					<li><a href="<?php echo $URL;?>aide">Aide</a><span class="divider-last">&nbsp;</span></li>
				</ul>
			</div>
		</div>
		<!-- END PAGE HEADER--> 
		<!-- BEGIN PAGE CONTENT-->
		<div class="row-fluid">
			<div class="span12">
<?php
	$r1=QueryExcuteWhile("SELECT `Category` FROM `help` GROUP BY `Category`");
	while ($o1=mysqli_fetch_object($r1)){
		$Category=$o1->Category;
		echo'
				<div class="widget">
					<div class="widget-title">
						<h4><i class="icon-reorder"></i> '.$Category.'</h4>
						<span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span>
					</div>
					<div class="widget-body" style="display: block;">
						<div class="accordion in collapse" id="accordion1" style="height: auto;">';
						$r2=QueryExcuteWhile("SELECT * FROM `help` WHERE `Category`='$Category'");
							while ($o2=mysqli_fetch_object($r2)){
								echo'
							<div class="accordion-group">
								<div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$o1->Category.'" href="#'.$o1->Category.'_collapse_'.$o2->idHelp.'"> <i class=" icon-plus"></i> '.$o2->Question.'</a> 
								</div>
								<div id="'.$o1->Category.'_collapse_'.$o2->idHelp.'" class="accordion-body collapse" style="height: 0px;">
									<div class="accordion-inner"> '.$o2->Answer.'</div>
								</div>
							</div>';
							}
						echo'
						</div>
					</div>
					<!-- END EXAMPLE TABLE widget--> 
				</div>
		';
	}
?>
				
			</div>
			<!-- END PAGE CONTENT--> 
		</div>
		<!-- END PAGE CONTAINER--> 
	</div>
	<!-- END PAGE --> 
</div>
<!-- END CONTAINER --> 
<!-- BEGIN FOOTER -->
<div id="footer"> <?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
<!-- END FOOTER --> 
<!-- BEGIN JAVASCRIPTS --> 
<!-- Load javascripts at bottom, this will reduce page load time --> 
<script src="ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script src="ili-style/js/scripts.js"></script> 
<script type="text/javascript" src="ili-style/assets/ckeditor/ckeditor.js"></script> 
<script src="ili-style/js/jquery.blockui.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]--> 
<script type="text/javascript" src="ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script type="text/javascript" src="ili-style/assets/clockface/js/clockface.js"></script> 
<script type="text/javascript" src="ili-style/assets/jquery-tags-input/jquery.tagsinput.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-daterangepicker/date.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script> 
<script src="ili-style/assets/fancybox/source/jquery.fancybox.pack.js"></script> 
<script>jQuery(document).ready(function(){App.init();});</script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>