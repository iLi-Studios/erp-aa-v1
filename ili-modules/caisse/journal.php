<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CAISSE', 'S');
function GetUserListeForSelect($User){
	if($_SESSION['user_Rank']='3'){
		echo'
			<option value="0"> TOUS LES OPERATEURS </option>
		';
		$result=QueryExcuteWhile("SELECT * FROM `users`");
		while ($o=mysqli_fetch_object($result)){
			if($User==$o->idUser){$selected='selected';}else{$selected='';}
			echo'
			<option value="'.$o->idUser.'" '.$selected.'>#'.$o->idUser.', '.$o->FamilyName.' '.$o->FirstName.'</option>
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
	$sql1="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `RecevedBy`='$idUser';";
	$sql2="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	printf("%0.3f", $o[0]);
}
function CheckoutGetAmmountTotalCash($date1, $date2, $idUser){
	$sql1="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `PaymentKind`='ESPECE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `PaymentKind`='ESPECE' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	printf("%0.3f", $o[0]);
}
function CheckoutGetAmmountTotalCheck($date1, $date2, $idUser){
	$sql1="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `PaymentKind`='CHEQUE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT SUM(`Amount`) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `PaymentKind`='CHEQUE' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	printf("%0.3f", $o[0]);
}
function CheckoutGetTotalOperation($date1, $date2, $idUser){
	$sql1="SELECT COUNT(*) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `RecevedBy`='$idUser';";
	$sql2="SELECT COUNT(*) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	echo $o[0];
}
function CheckoutGetTotalOperationCash($date1, $date2, $idUser){
	$sql1="SELECT COUNT(*) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `PaymentKind`='ESPECE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT COUNT(*) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `PaymentKind`='ESPECE' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	echo $o[0];
}
function CheckoutGetTotalOperationCheck($date1, $date2, $idUser){
	$sql1="SELECT COUNT(*) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `PaymentKind`='CHEQUE' AND `RecevedBy`='$idUser';";
	$sql2="SELECT COUNT(*) FROM `payment` WHERE `EncashmentDate`>='$date1' AND `PaymentKind`='CHEQUE' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$o=QueryExcute("mysqli_fetch_array", $query);
	echo $o[0];
}
function Checkout($date1, $date2, $idUser){
	global $URL;
	$USER=UserGetInfo($idUser);
	$sql1="SELECT * FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2' AND `RecevedBy`='$idUser';";
	$sql2="SELECT * FROM `payment` WHERE `EncashmentDate`>='$date1' AND `EncashmentDate`<='$date2';";
	if($idUser){$query=$sql1;}else{$query=$sql2;}
	$nobre_de_resultat=QueryExcute("mysqli_fetch_row", $query);
	$result=QueryExcuteWhile($query);
		echo'
		<center>
		<table width="100%" border="1">
			<tr>
				<th>#</th>
				<th>#CONTRAT</th>
				<th>#CLIENT</th>
				<th>DESIGNATION</th>
				<th>TYPE</th>
				<th width="10%">DATE</th>
				<th width="10%">#OPERATEUR</th>
				<th>MONTANT</th>
			</tr>
			';
			while ($o=mysqli_fetch_object($result)){
				$PaymentInfo=PaymentInfo($o->idPayment);
				echo'
				<tr>
					<td style="text-align:right;"><a href="'.$URL.'ili-modules/caisse/paiement?id='.$o->idPayment.'">'.$o->idPayment.'&nbsp;&nbsp;</a></td>
					<td style="text-align:right;">';?><?php if($PaymentInfo){echo'<a href="'.$URL.'ili-modules/contrat/contrat?id='.$PaymentInfo->idContract.'">'.$PaymentInfo->idContract.'</a>';}else{echo '#';}?><?php echo'&nbsp;&nbsp;</td>
					<td style="text-align:center;">';?><?php if($PaymentInfo){echo'<a href="'.$URL.'ili-modules/client/client?id='.$PaymentInfo->idClient.'">'.$PaymentInfo->idClient.'</a>';}else{echo '<center>##</center>';}?><?php echo'</td>
					<td>';?><?php if($o->Description){echo $o->Description;}else{echo '<center>##</center>';}?><?php echo'</td>
					<td style="text-align:center;">'.$o->PaymentKind.'</td>
					<td style="text-align:center;">'.$o->EncashmentDate.'</td>
					<td style="text-align:center;"><a href="'.$URL.'ili-users/user_profil?id='.$o->RecevedBy.'">'.$o->RecevedBy.'</a></td>
					<td style="text-align:right;">';?><?php printf('%0.3f', $o->Amount);?><?php echo' TND&nbsp;&nbsp;</td>
				</tr>
				';
			}
			echo'
			<tr>
				<th colspan="5" rowspan="5"></th>
				<th colspan="3" style="text-align:center;">TOTEAUX</th>
				</tr>
			<tr>

				<th>TYPE</th>
				<th style="text-align:center;">NBR</th>
				<th style="text-align:center;">TOTAL</th>
			</tr>
			<tr>

				<th>ESPECES</th>
				<td style="text-align:right;">';?><?php CheckoutGetTotalOperationCash($date1, $date2, $idUser)?><?php echo'&nbsp;&nbsp;</td>
				<td style="text-align:right;">';?><?php CheckoutGetAmmountTotalCash($date1, $date2, $idUser)?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<th>CHEQUES</th>
				<td style="text-align:right;">';?><?php CheckoutGetTotalOperationCheck($date1, $date2, $idUser)?><?php echo'&nbsp;&nbsp;</td>
				<td style="text-align:right;">';?><?php CheckoutGetAmmountTotalCheck($date1, $date2, $idUser)?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<th>SOMME</th>
				<td style="text-align:right;">';?><?php CheckoutGetTotalOperation($date1, $date2, $idUser)?><?php echo'&nbsp;&nbsp;</td>
				<td style="text-align:right;">';?><?php CheckoutGetAmmountTotal($date1, $date2, $idUser)?><?php echo' TND&nbsp;&nbsp;</td>
			</tr>
		</table>
		</center>
		<br><br><br>
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
					<div class="widget-title">
						<h4><i class="icon-reorder"></i> Jounral du caisse</h4>
						<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> </span>
					</div>
					<div class="widget-body">
						<div class="span12">
							<?php
							if(isset($_GET['DATE1'])){$DATE1=$_GET['DATE1'];}else{$DATE1=$Now;}
							if(isset($_GET['DATE2'])){$DATE2=$_GET['DATE2'];}else{$DATE2=$Now;}
							if(isset($_GET['idUser'])){$User=$_GET['idUser'];}else{$User='0';}
							?>
							<br>
							<form method="post" action="">
								<table width="100%">
									<tr>
										<th>Du</th>
										<th><input type="text" class=" m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" name="DATE1" value="<?php echo $DATE1;?>" required style="width:80%; margin-top:10px;"></th>
										<th>A</th>
										<th><input type="text" class=" m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" name="DATE2" value="<?php echo $DATE2;?>" required style="width:80%;margin-top:10px;"></th>
										<th>CAISSE/UTILISATEUR
										<th> <select name="idUser" style="width:100%; margin-top:10px;"><?php GetUserListeForSelect($User);?></select>
										</th>
										<th><button class="btn btn-success"><i class="icon-search icon-white"></i> Chercher</button></th>
									</tr>
								</table>
							</form>
							<?php
							if( (isset($_POST['DATE1'])) && (isset($_POST['DATE2'])) && (isset($_POST['idUser']))){
								$DATE1=$_POST['DATE1'];
								$DATE2=$_POST['DATE2'];
								$User=$_POST['idUser'];
								RedirectJS('ili-modules/caisse/journal?DATE1='.$DATE1.'&DATE2='.$DATE2.'&idUser='.$User);
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