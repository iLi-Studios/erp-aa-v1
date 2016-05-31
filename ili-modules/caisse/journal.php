<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CAISSE', 'S');
function GetUserListeForSelect($User){
	if($_SESSION['user_idRank']='3'){
		echo'
			<option value="0">Tous...</option>
		';
		$result=QueryExcuteWhile("SELECT * FROM `users`");
		while ($o=mysqli_fetch_object($result)){
			if($User==$o->idUser){$selected='selected';}else{$selected='';}
			echo'
			<option value="'.$o->idUser.'" '.$selected.'>'.$o->FamilyName.' '.$o->FirstName.'</option>
			';
		}
	}
	else{
		$UserGetInfo=UserGetInfo($_SESSION['user_id']);
		echo'
		<option value="'.$User->idUser.'" "selected">#'.$User->idUser.', '.$User->FamilyName.' '.$User->FirstName.'</option>
		';
	}
}
function CheckoutGetAmmountTotal($date1, $date2, $idUser){
	$sql1="SELECT SUM(`Amount`) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `RecevedBy`='$idUser';";
	$sql2="SELECT SUM(`Amount`) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	printf("%0.3f", $o[0]);
}
function CheckoutGetAmmountTotalCash($date1, $date2, $idUser){
	$sql1="SELECT SUM(`Amount`) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='ESPECE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT SUM(`Amount`) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='ESPECE'";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	printf("%0.3f", $o[0]);
}
function CheckoutGetAmmountTotalCheck($date1, $date2, $idUser){
	$sql1="SELECT SUM(`Amount`) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='CHEQUE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT SUM(`Amount`) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='CHEQUE';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	printf("%0.3f", $o[0]);
}
function CheckoutGetTotalOperation($date1, $date2, $idUser){
	$sql1="SELECT COUNT(*) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `RecevedBy`='$idUser';";
	$sql2="SELECT COUNT(*) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	echo $o[0];
}
function CheckoutGetTotalOperationCash($date1, $date2, $idUser){
	$sql1="SELECT COUNT(*) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='ESPECE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT COUNT(*) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='ESPECE'";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	echo $o[0];
}
function CheckoutGetTotalOperationCheck($date1, $date2, $idUser){
	$sql1="SELECT COUNT(*) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='CHEQUE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT COUNT(*) FROM `payment` WHERE  `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `PaymentKind`='CHEQUE';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	echo $o[0];
}
function Checkout($date1, $date2, $idUser){
	global $URL;
	$sql1="SELECT * FROM `payment` WHERE `EncashmentDate` BETWEEN '$date1' AND '$date2' AND `RecevedBy`='$idUser';";
	$sql2="SELECT * FROM `payment` WHERE `EncashmentDate` BETWEEN '$date1' AND '$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$nobre_de_resultat=QueryExcute("mysqli_fetch_row", $query);
	$result=QueryExcuteWhile($query);
		echo'
		<div class="row-fluid">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Contrat</th>
						<th class="hidden-480">Designation</th>
						<th class="hidden-480">Type</th>
						<th class="hidden-480">Date</th>
						<th class="hidden-480">Operateur</th>
						<th>Total</th>
					</tr>
				</thead>
			';
			while ($o=mysqli_fetch_object($result)){
				$PaymentInfo=PaymentInfo($o->idPayment);
				$USER2=UserGetInfo($o->RecevedBy);
				echo'
				<tbody>
					<tr>
						<td>'.$o->idPayment.'</td>
						<td>';?><?php if($PaymentInfo){echo $PaymentInfo->idContract;}else{echo '#';}?><?php echo'</td>
						<td class="hidden-480">';?><?php if($o->Description){echo $o->Description;}else{echo '<center>##</center>';}?><?php echo'</td>
						<td class="hidden-480">'.$o->PaymentKind.'</td>
						<td class="hidden-480">';?><?php echo FormatEnDateToFr($o->EncashmentDate);?><?php echo'</td>
						<td class="hidden-480">';?><?php echo $USER2->FamilyName.' '.$USER2->FirstName ?><?php echo'</td>
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
					<li><strong>Total Chéque(';?><?php CheckoutGetTotalOperationCash($date1, $date2, $idUser)?><?php echo') : </strong> ';?><?php CheckoutGetAmmountTotalCash($date1, $date2, $idUser)?><?php echo' TND</li>
					<li><strong>Total Espéce(';?><?php CheckoutGetTotalOperationCheck($date1, $date2, $idUser)?><?php echo') : </strong> ';?><?php CheckoutGetAmmountTotalCheck($date1, $date2, $idUser)?><?php echo' TND</li>
					<li><strong>Somme(';?><?php CheckoutGetTotalOperation($date1, $date2, $idUser)?><?php echo') : </strong> ';?><?php CheckoutGetAmmountTotal($date1, $date2, $idUser)?><?php echo' TND</li>
				</ul>
			</div>
		</div>
		';
}
function CheckoutListForClient($idClient){
	global $URL;
	$result=QueryExcuteWhile("SELECT `idPayment` FROM `contractcycle`, `insurancecontract` WHERE `contractcycle`.`idContract`=`insurancecontract`.`idContract` AND `insurancecontract`.`idClient`='$idClient';");
	if($result){
		echo'<ol>';
		while($o=mysqli_fetch_object($result)){
			echo '<li> <a href="'.$URL.'ili-caisse/DetailsPayement.php?idPayment='.$o->idPayment.'">'.$o->idPayment.'</a> </li>';
		}
		echo'</ol>';
	}
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
				<h3 class="page-title"> Caisse <small> Journal</small> </h3>
				<ul class="breadcrumb">
					<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
					<li><a href="journal">Journal</a><span class="divider-last">&nbsp;</span></li>
				</ul>
			</div>
		</div>
		<!-- END PAGE HEADER--> 
		<!-- BEGIN PAGE CONTENT-->
		<div class="row-fluid">
			<div class="span12"> 
				<!-- BEGIN EXAMPLE TABLE widget-->
				<div class="widget">
					<div class="widget-title hidden-print"><h4><i class="icon-reorder"></i> Journal Du Caisse</h4>
						<span class="tools"><a onclick="javascript:window.print();" class="icon-print"></a></span>
					</div>
					<div class="widget-body">
						<div class="span12">
                            <div class="row-fluid invoice-list">
								<div class="span4"><img src="../../ili-upload/logo.png" width="150px" height="150px" alt="" class="hidden-print"></div>
								<div class="span4"><h2 style="margin-top:50px;" id="title">Journal Du Caisse</h2></div>
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
							<?php
							if(isset($_GET['DATE1'])){$DATE1=$_GET['DATE1'];}else{$DATE1=$NowEN;}
							if(isset($_GET['DATE2'])){$DATE2=$_GET['DATE2'];}else{$DATE2=$NowEN;}
							if(isset($_GET['idUser'])){$User=$_GET['idUser'];}else{$User='0';}
							?>
						    <div class="space20"></div>
							<div class="space20"></div>
                            <div class="row-fluid invoice-list">
								<form action="" method="post">
									<div class="row-fluid">
										<div class="span4 invoice-block pull-right custom">
											<ul class="unstyled amounts">
												<li>
													DATE DEBUT : <input type="date" id="cm"  name="DATE1" value="<?php echo $DATE1;?>" onChange="this.form.submit();" style="width:60%; border:none;"><br>
													DATE FIN : <input type="date" id="cm" name="DATE2" value="<?php echo $DATE2;?>" onChange="this.form.submit();" style="width:60%; border:none;"><br>
													OPERATEUR : <select name="idUser" id="cm" onChange="this.form.submit();" style="width:63%; border:none;"><?php GetUserListeForSelect($User);?></select></li>
											</ul>
										</div>
									</div>								
								</form>
                            </div>
                            <div class="space20"></div>
							<?php
							if( (isset($_POST['DATE1'])) && (isset($_POST['DATE2'])) && (isset($_POST['idUser']))){
								$DATE1=$_POST['DATE1'];
								$DATE2=$_POST['DATE2'];
								$User=$_POST['idUser'];
								Redirect('ili-modules/caisse/journal?DATE1='.$DATE1.'&DATE2='.$DATE2.'&idUser='.$User);
							}
							Checkout($DATE1, $DATE2, $User);
							?>
						</div>
						<div class="space5"></div>
					</div>
					<!-- END EXAMPLE TABLE widget--> 
				</div>
				
			</div>
			<!-- END PAGE CONTENT-->
			 </div>
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