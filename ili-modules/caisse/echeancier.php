<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CLIENTS', 'S');
$idUser=$_SESSION['user_id'];
if(isset($_GET['date1'])){$date1=$_GET['date1'];}else{$date1=$Now;}
if(isset($_GET['date2'])){$date2=$_GET['date2'];}else{$date2=$Now;}
if(isset($_GET['operation'])){$operation=$_GET['operation'];}else{$operation='ES';}

function CheckGetTotalOperation($date1, $date2, $operation){
	if($operation=='ES'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2';");
		echo $o[0];
	}
	elseif($operation=='E'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`>0;");
		echo $o[0];
	}
	elseif($operation=='S'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`<0;");
		echo $o[0];
	}
}
function CheckGetTotalOperationIn($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`>0;");
	echo $o[0];
}
function CheckGetTotalOperationOut($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`<0;");
	echo $o[0];
}
function CheckGetTotalAmmount($date1, $date2, $operation){
	if($operation=='ES'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2';");
		printf("%0.3f", $o[0]);
	}
	elseif($operation=='E'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`>0;");
		printf("%0.3f", $o[0]);
	}
	elseif($operation=='S'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`<0;");
		printf("%0.3f", $o[0]);
	}
}
function CheckGetTotalAmmountIn($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`>0;");
	printf("%0.3f", $o[0]);
}
function CheckGetTotalAmmountOut($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`<0;");
	printf("%0.3f", $o[0]);
}
function Check($date1, $date2, $operation){
	global $URL;
	$SQL_ES 	= "SELECT * FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2';";
	$SQL_E		= "SELECT * FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`>0;";
	$SQL_S		= "SELECT * FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `Amount`<0;";
	if($operation='ES'){$query=$SQL_ES;}elseif($operation='E'){$query=$SQL_E;}elseif($operation='S'){$query=$SQL_S;}
	$result=QueryExcuteWhile($query);
	echo'
	<center>
		<table width="100%" border="1">
			<tr>
				<th style="text-align:center;">#PAIEMENT</th>
				<th style="text-align:center;">#CHEQUE</th>
				<th style="text-align:center;">DATE</th>
				<th style="text-align:center;">ECHEANCE</th>
				<th style="text-align:center;">#OPERATEUR</th>
				<th style="text-align:center;">OPERATION</th>
				<th style="text-align:center;">MONTANT</th>
			</tr>';
	while ($o=mysqli_fetch_object($result)){
				$PaymentInfo=PaymentInfo($o->idPayment);
				echo'
			<tr>
				<td style="text-align:right;"><a href="'.$URL.'ili-caisse/DetailsPayement.php?idPayment='.$o->idPayment.'">'.$o->idPayment.'&nbsp;&nbsp;</a></td>
				<td style="text-align:right;"><a href="'.$URL.'ili-check/DetailsCheck.php?PaymentCode='.$o->PaymentCode.'">'.$o->PaymentCode.'&nbsp;&nbsp;</a></td>
				<td style="text-align:center;">'.$o->EncashmentDate.'</td>
				<td style="text-align:center;">'.$o->TransferDate.'</td>
				<td style="text-align:center;"><a href="'.$URL.'ili-users/DetailsUser.php?idUser='.$o->RecevedBy.'">'.$o->RecevedBy.'</a></td>
				<td style="text-align:center;">';?><?php if($o->Amount>0){echo 'CREDITS';}elseif($o->Amount<0){echo 'DEBITS';}?><?php echo'</td>
				<td style="text-align:right;">';?><?php printf('%0.3f', $o->Amount);?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
				';
			}		
	echo'		
			<tr>
				<th colspan="4" rowspan="5"></th>
				<th colspan="3" style="text-align:center;">TOTEAUX</th>
				</tr>
			<tr>

				<th></th>
				<th style="text-align:center;">NBR</th>
				<th style="text-align:center;">TOTAL</th>
			</tr>
			<tr>

				<th>CREDITS</th>
				<td style="text-align:right;">';?><?php CheckGetTotalOperationIn($date1, $date2) ;?><?php echo'&nbsp;&nbsp;</td>
				<td style="text-align:right;">';?><?php CheckGetTotalAmmountIn($date1, $date2) ;?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<th>DEBITS</th>
				<td style="text-align:right;">';?><?php CheckGetTotalOperationOut($date1, $date2) ;?><?php echo'&nbsp;&nbsp;</td>
				<td style="text-align:right;">';?><?php CheckGetTotalAmmountOut($date1, $date2) ;?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<th>SOLDE</th>
				<td style="text-align:right;">';?><?php CheckGetTotalOperation($date1, $date2, $operation) ;?><?php echo'&nbsp;&nbsp;</td>
				<td style="text-align:right;">';?><?php CheckGetTotalAmmount($date1, $date2, $operation) ;?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
		</table>
		</center>
		';
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
   <link rel="stylesheet" type="text/css" href="../../ili-style/assets/bootstrap-datepicker/css/datepicker.css" />
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
				<h3 class="page-title"> Caisse <small> Echéancier </small> </h3>
				<ul class="breadcrumb">
					<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
					<li><a href="echeancier">Echéancier </a><span class="divider-last">&nbsp;</span></li>
				</ul>
			</div>
		</div>
		<!-- END PAGE HEADER--> 
		<!-- BEGIN PAGE CONTENT-->
		<div class="row-fluid">
			<div class="span12"> 
				<!-- BEGIN EXAMPLE TABLE widget-->
				<div class="widget">
					<div class="widget-title">
						<h4><i class="icon-reorder"></i> Echéancier chèque</h4>
						<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span>
					</div>
					<div class="widget-body">
						<div class="span12">

							<form method="post" action="">
								<table width="100%">
									<tr>
										<th>Du</th>
										<th><input type="text" class=" m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" name="date1" value="<?php echo $date1;?>" required style="width:80%; margin-top:10px;"></th>
										<th>A</th>
										<th><input type="text" class=" m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" name="date2" value="<?php echo $date2;?>" required style="width:80%;margin-top:10px;"></th>
										<th>OPERATION</th>
										<th>
											<select name="operation" style="width:100%; margin-top:10px;">
												<option <?php if($operation=='ES'){echo'selected';}?>value="ES">DEBITS/CREDITS</option>
												<option <?php if($operation=='E'){echo'selected';}?>value="E">CREDITS</option>
												<option <?php if($operation=='S'){echo'selected';}?>value="S">DEBITS</option>
											</select>
										</th>
										<th><button class="btn btn-success"><i class="icon-search icon-white"></i> Chercher</button></th>
									</tr>
								</table>
							</form>
							<?php
							if( (isset($_POST['date1'])) && (isset($_POST['date2'])) && (isset($_POST['operation']))){
								$date1=$_POST['date1'];
								$date2=$_POST['date2'];
								$operation=$_POST['operation'];
								RedirectJS('ili-modules/caisse/echeancier?date1='.$date1.'&date2='.$date2.'&operation='.$operation);
							}
							Check($date1, $date2, $operation);
							?>
						</div>
						<div class="space5"></div>
					</div>
					<!-- END EXAMPLE TABLE widget--> 
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
<script>jQuery(document).ready(function(){App.init();});</script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>