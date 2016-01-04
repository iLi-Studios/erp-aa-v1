<?php 
include"../ili-functions/functions.php";
autorisation('2');
$id_user=$_SESSION['user_id'];
function liste_distinataire(){
	$id_user=$_SESSION['user_id'];
	$query="SELECT `id_user`, `nom`, `prenom` FROM `users` WHERE `id_user`<>'$id_user' ";
	$result=query_excute_while($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
			<option value="'.$o->id_user.'">'.$o->nom.' '.$o->prenom.'</option>
		';
	}
}
if( (isset($_POST['subject'])) && (isset($_POST['user_reception'])) && (isset($_POST['message'])) ){
	$subject		=addslashes($_POST['subject']);
	$user_reception	=addslashes($_POST['user_reception']);
	$message		=addslashes($_POST['message']);
	$date		 	= date("d-m-Y H:i:s");
	$query="INSERT INTO `system_msg` VALUES (NULL, '$id_user', '$user_reception', '$subject', '$message', '$date', '0', NULL);";
	query_execute_insert($query);
	redirect("index");
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
   <title>Form Components</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="../ili-style/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="../ili-style/css/style.css" rel="stylesheet" />
   <link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
   <link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />

   <link href="../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/jquery-tags-input/jquery.tagsinput.css" />    
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="../ili-style/assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="../ili-style/assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-daterangepicker/daterangepicker.css" />
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
					<h3 class="page-title"> Conversations <small>Interactive  conversations</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="#"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="#">Components</a><span class="divider">&nbsp;</span></li>
						<li><a href="#">Conversations</a><span class="divider-last">&nbsp;</span></li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB--> 
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div id="page">
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN  widget-->
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-reorder"></i> Editeur de message</h4>
							<span class="tools">
							   </span>
							</div>
							<div class="widget-body form">
								<!-- BEGIN FORM-->
								<form action="" method="post" class="form-vertical">
									<br>
									<div class="control-group">
										<div class="controls">
											<input name="subject" style="margin-top:-14px" type="text" class="span6" placeholder="Sujet" autofocus required/><br>
											<select name="user_reception" class="span6"><?php liste_distinataire(); ?></select>
										</div>
									</div>
									<!-- END SUJET DISTINATAIRE-->
									<div class="control-group">
										<div class="controls">
											<textarea class="span12 ckeditor" name="message" rows="4"></textarea><br>
											<center>
												<input type="reset" value=" Annuler" class="btn btn-info"/>
												<input type="submit" value=" Envoyer" class="btn btn-success"/>
											</center>
										</div>
									</div>
									<!-- END EDITEUR -->
								</form>
								<!-- END FORM-->
							</div>
						</div>
						<!-- END EXTRAS widget-->
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