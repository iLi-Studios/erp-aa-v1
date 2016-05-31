<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CONTRAT', 'S');
function ContractGetInfoLastCycle($idContract){
	$query="
	SELECT * FROM `insurancecontract`, `contractcycle`, `payment`, `client`
	WHERE
	`client`.`idClient`=`insurancecontract`.`idClient`
	AND
	`contractcycle`.`idContract`=`insurancecontract`.`idContract`
	AND 
	`payment`.`idPayment`=`contractcycle`.`idPayment`
	AND
	`insurancecontract`.`idContract`='$idContract'
	ORDER By `EndDate` DESC LIMIT 1
	";
	if($o=(QueryExcute("mysqli_fetch_object", $query))){return $o;}
}
function ContractGetInfoFisrtCycle($idContract){
	$query="
	SELECT * FROM `insurancecontract`, `contractcycle`, `payment`, `client` 
	WHERE 
	`client`.`idClient`=`insurancecontract`.`idClient` 
	AND 
	`contractcycle`.`idContract`=`insurancecontract`.`idContract` 
	AND 
	`payment`.`idPayment`=`contractcycle`.`idPayment` 
	AND 
	`insurancecontract`.`idContract`='$idContract' 
	ORDER BY `idCycle` LIMIT 1
	";
	if($o=(QueryExcute("mysqli_fetch_object", $query))){return $o;}
}
function ContractGetRenewTimes($idContract){
	$q="SELECT * FROM `insurancecontract`, `contractcycle`, `payment`, `client` 
	WHERE 
	`client`.`idClient`=`insurancecontract`.`idClient` 
	AND 
	`contractcycle`.`idContract`=`insurancecontract`.`idContract` 
	AND 
	`payment`.`idPayment`=`contractcycle`.`idPayment` 
	AND 
	`insurancecontract`.`idContract`='$idContract' 
	ORDER BY `idCycle`";
	$o=QueryExcute("mysqli_num_rows", $q);
	echo $o-1;
}
function ContractGetAllAmount($idContract){
	$q="SELECT (SUM(Amount)) as total FROM `insurancecontract`, `contractcycle`, `payment`, `client` 
	WHERE 
	`client`.`idClient`=`insurancecontract`.`idClient` 
	AND 
	`contractcycle`.`idContract`=`insurancecontract`.`idContract` 
	AND 
	`payment`.`idPayment`=`contractcycle`.`idPayment` 
	AND 
	`insurancecontract`.`idContract`='$idContract'";
	$o=QueryExcute("mysqli_fetch_object", $q);
	echo sprintf("%.3f",$o->total).' TND';
}
$idContract=$_GET['id'];
$cnt=ContractGetInfoLastCycle($idContract);
$cnt1=ContractGetInfoFisrtCycle($idContract);
if(!$cnt){Redirect('index?message=30');}
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
<link rel="shortcut icon" href="../client/ili-upload/favicon.png">
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
					<h3 class="page-title"> Contrat <small> Détails</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="contrat?id=">Détails</a><span class="divider-last">&nbsp;</span></li>
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
                            <h4><i class="icon-reorder"></i> Détails du contrat</h4>
                            <span class="tools">
								<?php GetUserPanel('CLIENT_CONTRACT', $cnt->idContract, $cnt->KindContract);?>
								<a href="javascript:;" class="icon-chevron-down"></a>
							</span>
                        </div>
						
						<div class="widget-body">
                            <div class="span12">
                                <h3>#CONTRAT : <?php echo $cnt->idContract; ?></h3>
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td class="span4">Nature :</td>
                                        <td><?php echo $cnt->KindContract; ?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Type :</td>
                                        <td><?php echo $cnt->TypeContract; ?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Date de creation :</td>
                                        <td><?php echo $cnt1->StartDate; ?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Montant Total :</td>
                                        <td><?php ContractGetAllAmount($idContract);?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Renouvellement :</td>
                                        <td><?php ContractGetRenewTimes($idContract);?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Etat :</td>
                                        <td><?php ExpireIn($cnt->EndDate); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h3>#Client : <a href="<?php echo $URL;?>ili-modules/client/client?id=<?php echo $cnt->idClient; ?>"><?php echo $cnt->idClient; ?></a></h3>
                                <div class="well">
                                    <address>
                                        <strong><?php echo $cnt->FamilyName.' '.$cnt->FirstName; ?></strong><br>
                                        <?php echo $cnt->Adress; ?><br><br>
                                        <?php echo $cnt->Phone; ?><br>
                                    </address>
                                </div>
                            </div>
                            <div class="space5"></div>
							<?php $createur=UserGetInfo($cnt->CreatedBy);?>
                            <?php echo'<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée par : <a href="'.$URL.'ili-users/user_profil?id='.$cnt->CreatedBy.'">'.$createur->FamilyName.' '.$createur->FirstName.'</a></div>';?>
                        </div>
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