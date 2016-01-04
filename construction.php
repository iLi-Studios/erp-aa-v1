<?php 
include"ili-functions/functions.php";
autorisation('2');
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
	<meta content="iLi-ERP" name="description" />
	<meta content="SAKLY AYOUB" name="author" />
	<link href="ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="ili-style/css/style.css" rel="stylesheet" />
	<link href="ili-style/css/style_responsive.css" rel="stylesheet" />
	<link href="ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
	<link href="ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="ili-style/assets/uniform/css/uniform.default.css" />
	<link href="ili-style/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="ili-style/assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<?php include"ili-functions/fragments/page_header.php";?>
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
	<?php include"ili-functions/fragments/sidebar.php";?>
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12"> 
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title"> Dashboard <small> Informations Générales </small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $site ; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="<?php echo $site ; ?>">Dashboard</a><span class="divider-last">&nbsp;</span></li>
						<li class="pull-right search-wrap">
							<form class="hidden-phone">
								<div class="search-input-area">
									<input id=" " class="search-query" type="text" placeholder="Search">
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
                     <div class="space20"></div>
                     <div class="space20"></div>
                     <div class="widget-body">
                         <div class="error-page" style="min-height: 800px">
                             <img src="ili-style/img/500.png" alt="500 error">
                             <h1>
                                 <strong>ERREUR : !</strong> <br/>
                                 Page en cours de constructions.
                             </h1>
                         </div>
                     </div>
                 </div>
             </div>
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
<script src="ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="ili-style/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="ili-style/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
<script src="ili-style/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script> 
<script src="ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="ili-style/js/jquery.blockui.js"></script> 
<script src="ili-style/js/jquery.cookie.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
        <script src="js/excanvas.js"></script>
        <script src="js/respond.js"></script>
        <![endif]--> 
<script src="ili-style/assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="ili-style/assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="ili-style/assets/jquery-knob/js/jquery.knob.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.resize.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.pie.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.stack.js"></script> 
<script src="ili-style/assets/flot/jquery.flot.crosshair.js"></script> 
<script src="ili-style/js/jquery.peity.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="ili-style/assets/data-tables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="ili-style/assets/data-tables/DT_bootstrap.js"></script> 
<script src="ili-style/js/scripts.js"></script> 
<script>
            jQuery(document).ready(function() {
                // initiate layout and plugins
                App.setMainPage(true);
                App.init();
            });
        </script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>