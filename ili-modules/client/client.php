<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CLIENTS', 'S');
$id_client=$_GET['id'];
$clt=ClientGetInfo($id_client);
if($clt==''){Redirect('index?message=18');}
$createur=UserGetInfo($clt->CreatedBy);
function ListContract($id_client){
	global $URL;
	$sql="
	SELECT `insurancecontract`.`idContract`, `FirstName`, `FamilyName`, `TypeContract`, `KindContract`, MAX(`StartDate`), MAX(`EndDate`), `Amount`, `idCycle`,`client`.`idClient`
	 
	 FROM `insurancecontract`,`contractcycle`,`payment`,`client`
	 
	 WHERE `client`.`idClient`=`insurancecontract`.`idClient`
		 AND
	   `contractcycle`.`idContract`=`insurancecontract`.`idContract`
		 AND 
	   `payment`.`idPayment`=`contractcycle`.`idPayment`
	     AND 
	   `client`.`idClient`='$id_client'
	GROUP BY `insurancecontract`.`idContract`
	";
	$result=QueryExcuteWhile($sql);
	while ($o=mysqli_fetch_array($result)){
		$idContract=$o[0];
		echo'
		  <tr class="odd gradeX" id="tr" onclick="document.location=\''.$URL.'ili-modules/contrat/contrat?id='.$o[0].'\'">
			<td>'.$o[0].'</td>
			<td>'.$o[4].'</td>
			<td>'.$o[3].'</td>
			<td>'.$o[5].'</td>
			<td>'.$o[6].'</td>
		  </tr>
		';
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
</head>
<style>
	#tr{cursor:pointer;}
	#tr:hover{
		text-decoration:underline;
		font-weight: bold;
		color: #3399ff;}
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
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title"> Client <small> Fiche Client</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="liste">Clients</a><span class="divider">&nbsp;</span></li>
						<li><a href="client?id=<?php echo $id_client; ?>">Fiche</a><span class="divider-last">&nbsp;</span></li>
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
                            <h4><i class="icon-reorder"></i> Fiche Client</h4>
                            <span class="tools">
								<?php GetUserPanel('CLIENTS', $id_client, '');?>
								<a href="javascript:;" class="icon-chevron-down"></a>
							</span>
                        </div>
						
						<div class="widget-body">
                            <div class="span12">
                                <h3><?php echo $clt->FamilyName.'<br>'.$clt->FirstName; ?></h3>
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td class="span4">
										CIN / N°PASPORT / MF / RC
										</td>
                                        <td><?php echo $clt->idClient; ?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Tel:</td>
                                        <td><?php echo $clt->Phone; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h4>Addresse</h4>
                                <div class="well">
                                    <address>
                                        <strong><?php echo $clt->FamilyName.' '.$clt->FirstName; ?></strong><br>
                                        <?php echo $clt->Adress; ?><br><br>
                                        <?php echo $clt->Phone; ?><br>
                                    </address>
                                </div>
                            </div>
                            <div class="space5"></div>
                            <?php echo'<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée par : <a href="'.$URL.'ili-users/user_profil?id='.$clt->CreatedBy.'">'.$createur->FamilyName.' '.$createur->FirstName.'</a></div>';?>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE widget-->
                </div>
			</div>
			<!-- END PAGE CONTENT--> 
            <!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
                    <!-- BEGIN EXAMPLE TABLE widget-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Contrat Client</h4>
                            <span class="tools">
								<a href="javascript:;" class="icon-chevron-down"></a>
							</span>
                        </div>
						
						<div class="widget-body">
                            <div class="span12">
                            <?php
							if($_SESSION['user_idRank']==2){
								$up_cnt=UserPrivileges("CONTRAT", $_SESSION['user_id']);
								if($up_cnt->s){
									echo' 
										<ul class="unstyled">
											<table class="table table-striped table-bordered table-advance table-hover" width="100%">
										   <thead>
											  <tr>
												 <th width="20%"><i class="icon-briefcase"></i> #Conrtat</th>
												 <th width="20%"><i class="icon-retweet"></i> Nature</th>
												 <th width="30%"><i class="icon-wrench"></i> Type</th>
												 <th width="15%"><i class="icon-signin"></i> Date Début</th>
												 <th width="15%"><i class="icon-signout"></i> Date Fin </th>
											  </tr>
										   </thead>
										   <tbody>';?><?php ListContract($id_client); ?><?php echo'</tbody>
										</table>
										</ul>
									';
								}
							}
							else{
								echo' 
										<ul class="unstyled">
											<table class="table table-striped table-bordered table-advance table-hover" width="100%">
										   <thead>
											  <tr>
												 <th width="20%"><i class="icon-briefcase"></i> #Conrtat</th>
												 <th width="20%"><i class="icon-retweet"></i> Nature</th>
												 <th width="30%"><i class="icon-wrench"></i> Type</th>
												 <th width="15%"><i class="icon-signin"></i> Date Début</th>
												 <th width="15%"><i class="icon-signout"></i> Date Fin </th>
											  </tr>
										   </thead>
										   <tbody>';?><?php ListContract($id_client); ?><?php echo'</tbody>
										</table>
										</ul>
									';
							}
                            ?>
                            </div>
                            <div class="space5"></div>
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

<?php ClientDropModal($id_client);?>

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