<?php 
include"../../ili-functions/functions.php";
Authorization('3');
$ets=CompanyGetInfo();
function CompanyInfoUpdate(){
	global $URL;
	$idUser = $_SESSION['user_id'];
	$user=UserGetInfo($idUser);
	if( isset($_POST['RS']) && isset($_POST['Activity']) && isset($_POST['Phone1']) && isset($_POST['Adress']) ){
		if(isset($_POST['MF'])) 			{$MF=addslashes($_POST['MF']);} 					else{$MF='';}
		$RS 			= addslashes($_POST['RS']);
		if(isset($_POST['RC'])) 			{$RC=addslashes($_POST['RC']);} 					else{$RC='';}
		$Activity 		= addslashes($_POST['Activity']);
		$Adress 		= addslashes($_POST['Adress']);
		$Phone1 		= $_POST['Phone1'];
		if(isset($_POST['Phone2']))			{$Phone2=addslashes($_POST['Phone2']);} 			else{$Phone2='';}
		if(isset($_POST['Fax']))			{$Fax=addslashes($_POST['Fax']);} 					else{$Fax='';}
		if(isset($_POST['Email']))			{$Email=addslashes($_POST['Email']);} 				else{$Email='';}
		if(isset($_POST['WebSite']))		{$WebSite=addslashes($_POST['WebSite']);} 			else{$WebSite='';}
		if(isset($_POST['BankAccount1']))	{$BankAccount1=addslashes($_POST['BankAccount1']);} else{$BankAccount1='';}
		if(isset($_POST['BankAccount2']))	{$BankAccount2=addslashes($_POST['BankAccount2']);} else{$BankAccount2='';}
		
		QueryExcute("", "UPDATE `company` SET `MF`='$MF', `RC`='$RC', `RS`='$RS', `Activity`='$Activity', `Adress`='$Adress', `Phone1`='$Phone1', `Phone2`='$Phone2', `Fax`='$Fax',	`Email`='$Email', `WebSite`='$WebSite', `BankAccount1`='$BankAccount1', `BankAccount2`='$BankAccount2' WHERE `id`=1");
		NotifAllWrite('', '', '<a href="'.$URL.'ili-modules/ets/info">'.$user->FamilyName.' '.$user->FirstName.', a modifier les informations de l`entreprise');
		LogWrite("Modification des informations de l\'entreprise");
		RedirectJS('ili-modules/ets/info');
	}
}
CompanyInfoUpdate();
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
					<h3 class="page-title"> Configuration <small> Etablissement </small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="info">Configuration</a><span class="divider">&nbsp;</span></li>
						<li><a href="info">Etablissement</a><span class="divider-last">&nbsp;</span></li>
					</ul>
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
					<form action="" method="post" name="form1">
                    <!-- BEGIN EXAMPLE TABLE widget-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Fiche Etablissement</h4>
                            <span class="tools">
							<a href="#" onclick="javascript:form1.submit();return false;" class="icon-save tooltips" data-original-title="Enregistrer"></a>
							</span>
                        </div>
						
						<div class="widget-body">
                            <div class="span8">
                                <h3><input name="RS" value="<?php echo $ets->RS; ?>"id="nom_clt" class="span12" autofocus required/> <br/><small><input name="Activity" value="<?php echo $ets->Activity; ?>"id="nom_clt" class="span12" required/>, </small></h3>
                                <table class="table table-borderless">
                                    <tbody>
										<tr>
											<td>Tel1</td>
											<td><input name="Phone1" value="<?php echo $ets->Phone1;?>" id="rc" class="span12" required/></td>
										</tr>
										<tr>
											<td>Tel2</td>
											<td><input name="Phone2" value="<?php echo $ets->Phone2;?>" id="rc" class="span12"/></td>
										</tr>
                                        <tr>
											<td>Fax</td>
											<td><input name="Fax" value="<?php echo $ets->Fax;?>" id="rc" class="span12"/></td>
										</tr>
                                    <tr>
                                        <td class="span4">RIB 1:</td>
                                        <td><input name="BankAccount1" value="<?php echo $ets->BankAccount1;?>" id="rc" class="span12"/></td>
                                    </tr>
                                    <tr>
                                        <td class="span4">RIB2 :</td>
                                        <td><input name="BankAccount2" value="<?php echo $ets->BankAccount2;?>" id="rc" class="span12"/></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h4>Addresse</h4>
                                <div class="well">
                                    <address>
                                        <input name="Adress" value="<?php echo $ets->Adress;?>" id="rc" class="span12" required/><br><br>
                                    </address>
                                    <address>
                                    	<input name="WebSite" value="<?php echo $ets->WebSite;?>" id="rc" class="span12"/></a><br>
                                        <input name="Email" value="<?php echo $ets->Email;?>" id="rc" class="span12"/></a><br>
                                    </address>
                                </div>
                            </div>
                            <div class="span4">
								<ul class="unstyled">
									<table class="table table-borderless" width="100%">
										<tbody>
                                        	<tr>
                                                <td class="span3">MF :</td>
                                                <td><input name="MF" value="<?php echo $ets->MF;?>" id="rc" class="span12"/></td>
                                            </tr>
                                            <tr>
                                                <td>RC :</td>
                                                <td><input name="RC" value="<?php echo $ets->RC;?>" id="rc" class="span12"/></td>
                                            </tr>
										</tbody>
									</table>
                                </ul>
                            </div>
                            <div class="span4">
                            	<center><img src="<?php echo $URL; ?>/ili-upload/logo.png" width="300px" height="300px"/></center>
                            </div>
                            <div class="space5"></div>
                        </div>
						
                    </div>
                    <!-- END EXAMPLE TABLE widget-->
					</form>
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