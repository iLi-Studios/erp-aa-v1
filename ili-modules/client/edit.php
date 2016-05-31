<?php 
include"../../ili-functions/functions.php";
function ClientUpdateInfo(){
	//Form
	if( (isset($_POST['idClient']))&&(isset($_POST['FamilyName']))&&(isset($_POST['FirstName']))&&(isset($_POST['Adress']))&&(isset($_POST['Phone'])) ){
		global $URL;
		$idClient 	= $_POST['idClient'];
		$FamilyName = $_POST['FamilyName'];
		$FirstName 	= $_POST['FirstName'];
		$Phone		= $_POST['Phone'];
		$Adress 	= $_POST['Adress'];
		$idUser		= $_SESSION['user_id'];
		$User		= $_SESSION['user_nom_prenom'];
		QueryExcute("", "UPDATE `client` SET `FamilyName` = '$FamilyName', `FirstName` = '$FirstName', `Phone` = '$Phone', `Adress` = '$Adress' WHERE `idClient` = '$idClient'");
		NotifAllWrite('$idUser', '', '<a href="'.$URL.'ili-modules/client/client?id='.$idClient.'">'.$User.' a modifié le client, '.$FamilyName.' '.$FirstName);
		LogWrite("Modification de client : <a href=\"ili-modules/client/client?id=".$idClient."\">".$FamilyName." ".$FirstName."</a>");
		Redirect('ili-modules/client/client?id='.$idClient);
	}
}
Authorization('2');
AuthorizedPrivileges('CLIENTS', 'U');
$id_client=$_GET['id'];
$clt=ClientGetInfo($id_client);
if($clt==''){Redirect('index?message=18');}
$createur=UserGetInfo($clt->CreatedBy);
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
<style>
#nom_clt 		{padding-left:9px;border-radius:4px;background-color:#32C2CD;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;font-size:24.5px;margin-left:-0.15%;margin-top:-0.5%;}
#activite_clt 	{padding-left:9px;border-radius:4px;background-color:#32C2CD;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;margin-left:-0.15%;margin-top:-0.2%;}
#id_clt 		{height:25px;padding-left:9px;border-radius:4px;background-color:#E74955;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;font-size:13px;margin-left:-0.15%;margin-top:-2.2%;margin-bottom:-2%;padding:-1%, -1%;}
#rc 			{height:25px;padding-left:9px;border-radius:4px;background-color:#32C2CD;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;font-size:13px;margin-left:-0.15%;margin-top:-2.2%;margin-bottom:-2%;padding:-1%, -1%;}
#con 			{height:25px;padding-left:9px;border-radius:4px;background-color:#32C2CD;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;font-size:13px;margin-left:-0.25%;margin-top:-2.2%;margin-bottom:-2%;padding:-1%, -1%;}
#Adress 		{height:25px;padding-left:9px;border-radius:4px;background-color:#32C2CD;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;font-size:13px;margin-left:-0.2%;margin-top:-0.8%;margin-bottom:-0.5%;width:100%;}
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
						<li><a href="client?id=<?php echo $id_client; ?>">Fiche</a><span class="divider">&nbsp;</span></li>
						<li><a href="edit?id=<?php echo $id_client; ?>">Modification</a><span class="divider-last">&nbsp;</span></li>
					</ul>
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
                    <!-- BEGIN EXAMPLE TABLE widget-->
					<form action="" method="post" name="form1">
						<div class="widget">
							<div class="widget-title">
								<h4><i class="icon-reorder"></i> Fiche Client</h4>
								<span class="tools"><a href="#" onClick="javascript:form1.submit();return false;" class="icon-save tooltips" data-original-title="Enregistrer"></a></span>
							</div>
							
							<div class="widget-body">
								<div class="span12">
									<h3>
										<input name="FamilyName" value="<?php echo $clt->FamilyName;?>" id="nom_clt" class="span12" autofocus required/>
										<input name="FirstName" value="<?php echo $clt->FirstName;?>" id="nom_clt" class="span12" required/>
									</h3>
				
									<table class="table table-borderless">
										<tbody>
										<tr>
											<td class="span4">
											CIN / N° PASPORT / MF / RC
											</td>
											<td><input name="idClient" value="<?php echo $clt->idClient; ?>" id="idClient" readonly required/></td>
										</tr>
										<tr>
											<td class="span4">Tel :</td>
											<td><input name="Phone" value="<?php echo $clt->Phone; ?>" data-mask="99.999.999" id="rc"/></td>
										</tr>
										</tbody>
									</table>
									<h4>Addresse</h4>
									<div class="well">
										<address>
											<strong><?php echo $clt->FamilyName.' '.$clt->FirstName; ?></strong><br>
											<input name="Adress" value="<?php echo $clt->Adress; ?>" id="Adress"/><br><br>
											<?php echo $clt->Phone; ?><br>
										</address>
                                	</div>
								</div>
								<div class="space5"></div>
								<?php echo'<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée par : <a href="'.$URL.'ili-users/user_profil?id='.$clt->CreatedBy.'">'.$createur->FamilyName.' '.$createur->FirstName.'</a></div>';?>
							</div>
						</div>
						<!-- END EXAMPLE TABLE widget-->
					</form>
					<?php ClientUpdateInfo(); ?>
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