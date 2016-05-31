<?php 
include"../../ili-functions/functions.php";
function ClientUpdateInfo($idClient, $Form, $Notification, $Log){
	echo"
	<script type='text/javascript'>
		$(document).on('submit', '#".$Form."', function()
		{
			var data = $(this).serialize();
			$.ajax({
				type : 'POST',
				url  : 'functions/ClientUpdateInfo.php?Form=".$Form."&idClient=".$idClient."&Notification=".$Notification."&Log=".$Log."',
				data : data,
				success:function(){location.reload();}
			});
			return false;
		});
	</script>
	";
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
<?php echo $META_description;?><?php echo $META_author;?>
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
<script type="text/javascript" src="../../ili-functions/jquery-1.11.3-jquery.min.js"></script>
</head>
<?php 
ClientUpdateInfo($id_client, 'FamilyName', 'a modifier le nom/désignation de client <b>'.$clt->FamilyName.'</b> <b>'.$clt->FirstName.'</b>, de <b>'.$clt->FamilyName.'</b> a', 'Modification du nom/designation de client ID:'.$id_client.', de '.$clt->FamilyName.' a');
ClientUpdateInfo($id_client, 'FirstName', 'a modifier le prénom/type de client <b>'.$clt->FamilyName.'</b> <b>'.$clt->FirstName.'</b>, de <b>'.$clt->FirstName.'</b> a', 'Modification du prenom/type de client ID:'.$id_client.', de '.$clt->FirstName.' a');
ClientUpdateInfo($id_client, 'Phone', 'a modifier le numéro du téléphone de client <b>'.$clt->FamilyName.'</b> <b>'.$clt->FirstName.'</b>, de <b>'.$clt->Phone.'</b> a', 'Modification du prenom/type de client ID:'.$id_client.', de '.$clt->Phone.' a');
ClientUpdateInfo($id_client, 'Adress', 'a modifier l`adresse de client <b>'.$clt->FamilyName.'</b> <b>'.$clt->FirstName.'</b>, de <b>'.$clt->Adress.'</b> a', 'Modification d`adresse de client ID:'.$id_client.', de '.$clt->Adress.' a');
?>
<style>
form {
	margin: 0;
}
input:focus {
     outline:  none;
}
.custom {
	border: none;
 box-shadow:nonewhite-space:nowrap;
	vertical-align: baseline;
	color: #32C2CD;
}
.custom_nom {
	font-size: 24.5px;
}
.custom_input {
	margin-top: -2px;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 14px;
	line-height: 20px;
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
					<div class="widget">
						<div class="widget-title">
							<h4><i class="icon-reorder"></i> Fiche Client</h4>
						</div>
						<div class="widget-body">
							<div class="span12">
								<h3>
									<form method="post" id="FamilyName">
										<input name="input" value="<?php echo $clt->FamilyName;?>" autofocus required class="custom_nom custom span10"/>
									</form>
									<form method="post" id="FirstName">
										<input name="input" value="<?php echo $clt->FirstName;?>" required class="custom_nom custom span10"/>
									</form>
								</h3>
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td class="span4"> CIN / N° PASPORT / MF / RC </td>
											<td><?php echo $clt->idClient; ?></td>
										</tr>
										<tr>
											<td class="span4">Tel :</td>
											<td><form method="post" id="Phone">
													<input name="input" value="<?php echo $clt->Phone;?>" data-mask="99.999.999" required required class="custom custom_input"/>
												</form></td>
										</tr>
									</tbody>
								</table>
								<h4>Addresse</h4>
								<div class="well">
									<address>
									<strong><?php echo $clt->FamilyName.' '.$clt->FirstName; ?></strong><br>
									<form method="post" id="Adress">
										<input name="input" value="<?php echo $clt->Adress;?>" required required class="custom custom_input span10"/>
									</form>
									<br>
									<br>
									<?php echo $clt->Phone; ?><br>
									</address>
								</div>
							</div>
							<div class="space5"></div>
							<?php echo'<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée par : <a href="'.$URL.'ili-users/user_profil?id='.$clt->CreatedBy.'">'.$createur->FamilyName.' '.$createur->FirstName.'</a></div>';?> </div>
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