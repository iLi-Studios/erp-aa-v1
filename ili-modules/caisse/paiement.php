<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CAISSE', 'S');
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$o=QueryExcute("mysqli_fetch_object", "SELECT * FROM `payment` WHERE `idPayment`='$id';");
	if(!$o){Redirect('index?message=35');}
}
else{Redirect('index?message=35');}
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
<link href="../../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../../ili-style/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
<link href="../../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../ili-style/css/style.css" rel="stylesheet" />
<link href="../../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link rel="stylesheet" type="text/css" href="../../ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
<link href="../../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../ili-style/assets/uniform/css/uniform.default.css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php include"../../ili-functions/fragments/page_header.php";?>
<!-- END HEADER --> 
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
<!-- BEGIN SIDEBAR -->
<?php include"../../ili-functions/fragments/sidebar.php";?>
<!-- END SIDEBAR --> 
<!-- BEGIN PAGE -->
<div id="main-content"> 
	<!-- BEGIN PAGE CONTAINER-->
	<div class="container-fluid"> 
		<!-- BEGIN PAGE HEADER-->
		<div class="row-fluid">
			<div class="span12">
				<h3 class="page-title"> Caisse <small> Paiement</small> </h3>
				<ul class="breadcrumb">
					<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
					<li><a href="paiement?id=<?php echo $id;?>">Détail du paiement</a><span class="divider-last">&nbsp;</span></li>
				</ul>
			</div>
		</div>
		<!-- END PAGE HEADER--> 
		<!-- BEGIN PAGE CONTENT-->
		 <div class="row-fluid">
				<div class="span12"> 
					<!-- BEGIN EXAMPLE TABLE widget-->
						<div class="widget">
							<div class="widget-title"><h4><i class="icon-reorder"></i> Détails du paiement</h4></div>
							<div class="widget-body">
								<div class="span12">
									<table class="table table-borderless">
										<tbody>
										<tr>
											<td class="span4">CODE PAIEMENT</td>
											<td><?php echo $id;?></td>
										</tr>
										<tr>
											<td class="span4">DESCRIPTION</td>
											<td><?php echo $o->Description;?></td>
										</tr>
										<tr>
											<td class="span4">TYPE</td>
											<td>
											<?php 
											if($o->PaymentKind=='CHEQUE'){echo 'CHEQUE <a href="'.$URL.'ili-modules/caisse/cheque?id='.$o->PaymentCode.'">#'.$o->PaymentCode.'</a>';}
											else{echo $o->PaymentKind;}
											?>
											</td>
										</tr>
										<tr>
											<td class="span4">DATE</td>
											<td><?php echo FormatEnDateToFr($o->EncashmentDate);?></td>
										</tr>
										<tr>
											<td class="span4">REçUE PAR</td>
											<td><?php echo '<a href="'.$URL.'ili-users/user_profil?id='.$o->RecevedBy.'">'.$o->RecevedBy.'</a>';?></td>
										</tr>
										</tbody>
									</table>
								</div>
								<div class="space5"></div>
								
							</div>
						</div>
						<!-- END EXAMPLE TABLE widget-->
				</div>
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
<script src="../../ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="../../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script src="../../ili-style/js/scripts.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/ckeditor/ckeditor.js"></script> 
<script src="../../ili-style/js/jquery.blockui.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]--> 
<script type="text/javascript" src="../../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/clockface/js/clockface.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/jquery-tags-input/jquery.tagsinput.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-daterangepicker/date.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script> 
<script src="../../ili-style/assets/fancybox/source/jquery.fancybox.pack.js"></script> 
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