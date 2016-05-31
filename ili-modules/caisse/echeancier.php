<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CAISSE', 'U');
$idUser=$_SESSION['user_id'];
if(isset($_GET['date1'])){$date1=$_GET['date1'];}else{$date1=$NowEN;}
if(isset($_GET['date2'])){$date2=$_GET['date2'];}else{$date2=$NowEN;}
if(isset($_GET['operation'])){
	$operation=$_GET['operation'];
	if($operation!='DC'){
		if($operation!='C'){
			if($operation!='D'){
				Redirect('ili-modules/caisse/echeancier?date1='.$date1.'&date2='.$date2.'&operation=DC');
			}
		}
	}
}
else{$operation='DC';}

function CheckGetTotalOperation($date1, $date2, $operation){
	if($operation=='DC'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2';");
		echo $o[0];
	}
	elseif($operation=='C'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`>0;");
		echo $o[0];
	}
	elseif($operation=='D'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`<0;");
		echo $o[0];
	}
}
function CheckGetTotalOperationIn($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`>0;");
	echo $o[0];
}
function CheckGetTotalOperationOut($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT COUNT(*) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`<0;");
	echo $o[0];
}
function CheckGetTotalAmmount($date1, $date2, $operation){
	if($operation=='DC'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2';");
		printf("%0.3f", $o[0]);
	}
	elseif($operation=='C'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`>0;");
		printf("%0.3f", $o[0]);
	}
	elseif($operation=='D'){
		$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`<0;");
		printf("%0.3f", $o[0]);
	}
}
function CheckGetTotalAmmountIn($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`>0;");
	printf("%0.3f", $o[0]);
}
function CheckGetTotalAmmountOut($date1, $date2){
	$o=QueryExcute("mysqli_fetch_array", "SELECT SUM(`Amount`) FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate`>='$date1' AND `TransferDate`<='$date2' AND `Amount`<0;");
	printf("%0.3f", $o[0]);
}
function Check($date1, $date2, $operation){
	global $URL;
	$SQL_DC 	= "SELECT * FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate` BETWEEN '$date1' AND '$date2'";
	$SQL_D		= "SELECT * FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate` BETWEEN '$date1' AND 'date2' AND `Amount`>0;";
	$SQL_C		= "SELECT * FROM `payment` WHERE `PaymentKind`='CHEQUE' AND `TransferDate` BETWEEN '$date1' AND '$date2' AND `Amount`<0;";
	if($operation=='DC'){$query=$SQL_DC;}elseif($operation=='D'){$query=$SQL_C;}elseif($operation=='C'){$query=$SQL_D;}
	$result=QueryExcuteWhile($query);
	echo'<div class="row-fluid">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>#Paiement</th>
						<th>#Chéque</th>
						<th class="hidden-480">Date</th>
						<th class="hidden-480">Echéance</th>
						<th class="hidden-480">Opérateur</th>
						<th class="hidden-480">Type</th>
						<th class="hidden-480">Montant</th>
					</tr>
				</thead>';
	while ($o=mysqli_fetch_object($result)){
				$PaymentInfo=PaymentInfo($o->idPayment);
				echo'
				<tbody>
					<tr>
						<td>'.$o->idPayment.'</td>
						<td>'.$o->PaymentCode.'</td>
						<td class="hidden-480">';?><?php echo FormatEnDateToFr($o->EncashmentDate);?><?php echo'</td>
						<td class="hidden-480">';?><?php echo FormatEnDateToFr($o->TransferDate);?><?php echo'</td>
						<td class="hidden-480">'.$o->RecevedBy.'</td>
						<td class="hidden-480">';?><?php if($o->Amount>0){echo 'CREDITS';}elseif($o->Amount<0){echo 'DEBITS';}?><?php echo'</td>
						<td>';?><?php printf('%0.3f', $o->Amount);?><?php echo' TND</td>
					</tr>
				';
			}
			echo'
				</tbody>
			</table>
		</div>
		<div class="space20"></div>
		<div class="row-fluid">
			<div class="span4 invoice-block pull-right">
				<ul class="unstyled amounts">
					<li><strong>Total Crédit(';?><?php CheckGetTotalOperationIn($date1, $date2);?><?php echo') : </strong> ';?><?php CheckGetTotalAmmountIn($date1, $date2);?><?php echo' TND</li>
					<li><strong>Total Débit(';?><?php CheckGetTotalOperationOut($date1, $date2);?><?php echo') : </strong> ';?><?php CheckGetTotalAmmountOut($date1, $date2);?><?php echo' TND</li>
					<li><strong>Somme(';?><?php CheckGetTotalOperation($date1, $date2, $operation);?><?php echo') : </strong> ';?><?php CheckGetTotalAmmount($date1, $date2, $operation);?><?php echo' TND</li>
				</ul>
			</div>
		</div>
		';
}
$cmp=CompanyGetInfo();
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
   <link rel="stylesheet" type="text/css" href="../../ili-style/assets/bootstrap-datepicker/css/datepicker.css" />
</head>
<style>
@media print{
	#title{
		font-size:36px;
		text-align:center;
	}
	#entete{
		display:none;
	}
	.widget-body{
		font-size:10px;
	}
	.custom{
		text-align:left;
	}
	#cm{
		margin-top:5px;
	}
}
</style>
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
	<div class="container-fluid "> 
		<!-- BEGIN PAGE HEADER-->
		<div class="row-fluid hidden-print">
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
					<div class="widget-title hidden-print">
						<h4><i class="icon-reorder"></i> Echéancier chèque</h4>
						<span class="tools"><a onclick="javascript:window.print();" class="icon-print"></a></span>
					</div>
					<div class="widget-body">
						<div class="span12">
                            <div class="row-fluid invoice-list">
								<div class="span4"><img src="../../ili-upload/logo.png" width="150px" height="150px" alt="" class="hidden-print"></div>
								<div class="span4"><h2 style="margin-top:50px;" id="title">Echéancier chèque</h2></div>
								<div class="span4" style="margin-top:20px;" id="entete">
									<ul class="unstyled">
                                        <li>Agence		: <strong><?php echo $cmp->RS ;?></strong></li>
                                        <li>Tel			: <?php echo $cmp->Phone1 ;?></li>
                                        <li>Fax			: <?php echo $cmp->Fax ;?></li>
                                        <li>Email		: <?php echo $cmp->Email ;?></li>
										<li>Site		: <?php echo $cmp->WebSite ;?></li>
										<li>Adresse		: <?php echo $cmp->Adress ;?></li>
                                    </ul>
								</div>
                            </div>
							<div class="space20"></div>
							<div class="space20"></div>
							<div class="row-fluid invoice-list">
								<form action="" method="post">
									<div class="row-fluid">
										<div class="span4 invoice-block pull-right custom">
											<ul class="unstyled amounts">
												<li>
													DATE DEBUT : <input type="date" id="cm"  name="date1" value="<?php echo $date1;?>" onChange="this.form.submit();" style="width:60%; border:none;"><br>
													DATE FIN : <input type="date" id="cm" name="date2" value="<?php echo $date2;?>" onChange="this.form.submit();" style="width:60%; border:none;"><br>
													TYPE : <select name="operation" id="cm" onChange="this.form.submit();" style="width:63%; border:none;">
																	<option <?php if($operation=='DC'){echo'selected';}?> value="DC">DEBITS/CREDITS</option>
																	<option <?php if($operation=='C'){echo'selected';}?> value="C">CREDITS</option>
																	<option <?php if($operation=='D'){echo'selected';}?> value="D">DEBITS</option>
																</select></li>
											</ul>
										</div>
									</div>								
								</form>
                            </div>
							<?php
							if( (isset($_POST['date1'])) && (isset($_POST['date2'])) && (isset($_POST['operation']))){
								$date1=$_POST['date1'];
								$date2=$_POST['date2'];
								$operation=$_POST['operation'];
								Redirect('ili-modules/caisse/echeancier?date1='.$date1.'&date2='.$date2.'&operation='.$operation);
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
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up hidden-print"></i></span> </div>
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