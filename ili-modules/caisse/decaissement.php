<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CAISSE', 'C');
function RecupIdPaiement(){
	$o=QueryExcute("mysqli_fetch_array", "SELECT Max(`idPayment`) FROM `payment`");
	return $o[0];
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
<meta content="iLi-ERP" name="description" />
<meta content="SAKLY AYOUB" name="author" />
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
<script type="text/javascript">
function showRadio(){
	 if(document.getElementById('C').checked == true){
		 document.getElementById('CHEQUE').style.display = 'block';
	 }
	 else{
		  document.getElementById('CHEQUE').style.display = 'none';
	 }
}
</script>
<style type="text/css">#CHEQUE {display: none;}</style>
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
					<h3 class="page-title"> Caisse <small> Décaissement</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="decaissement">Décaissement</a><span class="divider-last">&nbsp;</span></li>
					</ul>
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12"> 
					<!-- BEGIN EXAMPLE TABLE widget-->
					<form action="" method="post">
						<div class="widget">
							<div class="widget-title"><h4><i class="icon-reorder"></i> Décaissement</h4></div>
							<div class="widget-body">
								<div class="row-fluid">
									<div class="span7">
										<h3>Détail</h3>
										<div class="control-group">
											<label class="control-label" style="margin-top:65px;">Date : </label>
											<div class="controls">
												<input type="text" class="input-large" value="<?php echo $Now;?>" readonly required>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<input type="text" class="input-large" name="Amount" placeholder="Montant" autofocus required>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<input type="text" class="input-xxlarge" name="Description" placeholder="Désignation" required>
											</div>
										</div>
									</div>
									<div class="span5">
										<h3>Paiement</h3>
										<div class="control-group">
											<div class="controls">
												   <label><input type="radio" id="E" name="PaymentKind" value="ESPECE" onclick="showRadio()" checked/>Espèces</label>
												   <label><input type="radio" id="C" name="PaymentKind" value="CHEQUE" onclick="showRadio()" />Chéque</label>
										   </div>
										</div>
										<div id="CHEQUE">
											<div class="control-group">
											   <div class="controls">
												  <input type="text" name="Bank" class="input-xlarge" placeholder="Banque"/>
												  <span class="help-inline"></span>
											   </div>
											</div>
											<div class="control-group">
											   <div class="controls">
												  <input type="text" name="PaymentCode" class="input-xlarge" placeholder="N° Chéque"/>
												  <span class="help-inline"></span>
											   </div>
											</div>
											<div class="control-group">
											   <div class="controls">
											   	  <label>Echéance</label>
												  <input type="date" name="TransferDate" class="input-xlarge" placeholder="Echéance"/>
												  <span class="help-inline"></span>
											   </div>
											</div>
											<br>
										 </div><!-- Chéque --> 
									</div>
									<div class="span12">
										<center><button class="btn btn-success"><i class="icon-ok icon-white"></i> Enregistrer</button></center>
									</div>
								</div>
							</div>
						</div>
						<!-- END EXAMPLE TABLE widget-->
					</form>
<?php
if( (isset($_POST['Description'])) && (isset($_POST['Amount'])) && (isset($_POST['PaymentKind'])) ){
	$idUser 		= addslashes($_SESSION['user_id']);
	$Description 	= addslashes($_POST['Description']);
	$Amount 		= -addslashes($_POST['Amount']);
	$PaymentKind 	= addslashes($_POST['PaymentKind']);
	if(isset($_POST['PaymentCode']))	{$PaymentCode	=addslashes($_POST['PaymentCode']);} 	else{$PaymentCode='';}
	if(isset($_POST['Bank']))			{$Bank			=addslashes($_POST['Bank']);} 			else{$Bank='';}
	if(isset($_POST['TransferDate']))	{$TransferDate	=addslashes($_POST['TransferDate']);} 	else{$TransferDate='';}
	QueryExcute("", "INSERT INTO `payment` VALUES (NULL, '$NowEN', '$Description', '$PaymentKind', '$PaymentCode', '$Bank', '$TransferDate', '$Amount', '$idUser');");
	$RecupIdPaiement=RecupIdPaiement();
	$user=UserGetInfo($idUser);
	NotifAllWrite('', '', '<a href="'.$URL.'ili-modules/caisse/paiement?id='.$RecupIdPaiement.'">'.$user->FamilyName.' '.$user->FirstName.', a effectuer un décaissement : '.$Description.'</a>');
	LogWrite("Décaissement : ".$Description);
	Redirect("ili-modules/caisse/journal");
}
?>
				</div>
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