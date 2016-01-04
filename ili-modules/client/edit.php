<?php 
include"../../ili-functions/functions.php";
autorisation('2');
autorisation_double_check_privilege('CLIENTS', 'U');
$id_client=$_GET['id'];
$clt=get_client_info($id_client);
if($clt==''){redirect('index?message=18');}
$createur=get_user_info($clt->created_by);
function mod_clt($id_clt, $nom_clt, $prenom_clt, $date_nais_clt, $adresse_clt, $fix_clt, $fax_clt, $portable_clt, $email_clt, $rc, $activite_clt, $nom_con_clt, $prenom_con_clt, $post_con_clt, $email_con_clt, $tel_con_clt, $tel2_con_clt){
	global $site;
	$user_nom=$_SESSION['user_nom'];
	$user_prenom=$_SESSION['user_prenom'];
	$q="UPDATE client SET 
	`nom_clt` 			= '$nom_clt', 
	`prenom_clt` 		= '$prenom_clt',
	`date_nais_clt` 	= '$date_nais_clt',
	`adresse_clt` 		= '$adresse_clt',
	`fix_clt`			= '$fix_clt',
	`fax_clt` 			= '$fax_clt',
	`portable_clt` 		= '$portable_clt',
	`email_clt` 		= '$email_clt',
	`rc`				= '$rc',
	`activite_clt` 		= '$activite_clt',
	`nom_con_clt`		= '$nom_con_clt',
	`prenom_con_clt` 	= '$prenom_con_clt',
	`post_con_clt` 		= '$post_con_clt',
	`email_con_clt` 	= '$email_con_clt',
	`tel_con_clt` 		= '$tel_con_clt',
	`tel2_con_clt` 		= '$tel2_con_clt'	
	WHERE `client`.`id_clt` = '$id_clt';";
	query_execute("mysqli_fetch_object", $q);
	notif_all('', '', '<a href="'.$site.'ili-modules/client/client?id='.$id_clt.'">'.$user_nom.' '.$user_prenom.' a modifié le client, '.$nom_clt.' '.$prenom_clt);
	write_log("Modification de client : <a href=\"ili-modules/client/client?id=".$id_clt."\">".$nom_clt." ".$prenom_clt."</a>");
	redirect('ili-modules/client/client?id='.$id_clt);
}
if( (isset($_POST['id_clt'])) ){
											$id_clt=addslashes($_POST['id_clt']);
	if(isset($_POST['nom_clt']))			{$nom_clt=addslashes($_POST['nom_clt']);}else{$nom_clt='';}
	if(isset($_POST['prenom_clt']))			{$prenom_clt=addslashes($_POST['prenom_clt']);}else{$prenom_clt='';}
	if(isset($_POST['date_nais_clt']))		{$date_nais_clt=addslashes($_POST['date_nais_clt']);}else{$date_nais_clt='';}
	if(isset($_POST['adresse_clt']))		{$adresse_clt=addslashes($_POST['adresse_clt']);}else{$adresse_clt='';}
	if(isset($_POST['fix_clt']))			{$fix_clt=addslashes($_POST['fix_clt']);}else{$fix_clt='';}
	if(isset($_POST['fax_clt']))			{$fax_clt=addslashes($_POST['fax_clt']);}else{$fax_clt='';}
	if(isset($_POST['portable_clt']))		{$portable_clt=addslashes($_POST['portable_clt']);}else{$portable_clt='';}
	if(isset($_POST['email_clt']))			{$email_clt=addslashes($_POST['email_clt']);}else{$email_clt='';}
	if(isset($_POST['rc']))					{$rc=addslashes($_POST['rc']);}else{$rc='';}
	if(isset($_POST['activite_clt']))		{$activite_clt=addslashes($_POST['activite_clt']);}else{$activite_clt='';}
	if(isset($_POST['nom_con_clt']))		{$nom_con_clt=addslashes($_POST['nom_con_clt']);}else{$nom_con_clt='';}
	if(isset($_POST['prenom_con_clt']))		{$prenom_con_clt=addslashes($_POST['prenom_con_clt']);}else{$prenom_con_clt='';}
	if(isset($_POST['post_con_clt']))		{$post_con_clt=addslashes($_POST['post_con_clt']);}else{$post_con_clt='';}
	if(isset($_POST['email_con_clt']))		{$email_con_clt=addslashes($_POST['email_con_clt']);}else{$email_con_clt='';}
	if(isset($_POST['tel_con_clt']))		{$tel_con_clt=addslashes($_POST['tel_con_clt']);}else{$tel_con_clt='';}
	if(isset($_POST['tel2_con_clt']))		{$tel2_con_clt=addslashes($_POST['tel2_con_clt']);}else{$tel2_con_clt='';}
	mod_clt($id_clt, $nom_clt, $prenom_clt, $date_nais_clt, $adresse_clt, $fix_clt, $fax_clt, $portable_clt, $email_clt, $rc, $activite_clt, $nom_con_clt, $prenom_con_clt, $post_con_clt, $email_con_clt, $tel_con_clt, $tel2_con_clt);
}
?>
<!DOCTYPE html>
<!--
iLi-ERP
Développer par : SAKLY AYOUB
Société	: iLi-Studios SARL
Site : http://www.ili-studios.com/
-->
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
<meta content="" name="description" />
<meta content="" name="author" />
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
#adresse 		{height:25px;padding-left:9px;border-radius:4px;background-color:#32C2CD;font-size:11.844px;font-weight:bold;line-height:14px;color:#FFF;white-space:nowrap;vertical-align:baseline; border:none;box-shadow:none;font-size:13px;margin-left:-0.2%;margin-top:-0.8%;margin-bottom:-0.5%;width:100%;}
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
						<li> <a href="<?php echo $site; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
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
								<div class="span8">
									<?php
									if($clt->activite_clt!=''){
										echo'
										<h3>
											<input name="nom_clt" value="'.$clt->nom_clt.'" id="nom_clt" class="span12" autofocus required/><br>
											<small>
												<input name="activite_clt" value="'.$clt->activite_clt.'" id="activite_clt" class="span12" required/>
											</small>
										</h3>
										';
									}
									else{
										echo'
										<h3>
											<input name="nom_clt" value="'.$clt->nom_clt.'" id="nom_clt" class="span12" autofocus required/>
											<input name="prenom_clt" value="'.$clt->prenom_clt.'" id="nom_clt" class="span12" required/>
										</h3>
										';
									}
									?>
									<table class="table table-borderless">
										<tbody>
										<tr>
											<td class="span4">
											<?php if($clt->activite_clt==''){echo'CIN : ';}else{echo'Matricule Fiscale :';}?>
											</td>
											<td><input name="id_clt" value="<?php echo $clt->id_clt; ?>" id="id_clt" readonly required/></td>
										</tr>
										<?php
										if($clt->activite_clt!=''){
											echo'
										<tr>
											<td class="span4">Registre du commerce :</td>
											<td><input name="rc" value="'.$clt->rc.'" data-mask="999aa9999999/a" id="rc"/></td>
										</tr>
											';
										}
										?>
										<?php
										if($clt->activite_clt==''){
											echo'
										<tr>
											<td class="span4">Date de naissance :</td>
											<td><input name="date_nais_clt" value="'.$clt->date_nais_clt.'" data-mask="99-99-9999" id="rc"/></td>
										</tr>
											';
										}
										?>
										<tr>
											<td class="span4">Tel FIX :</td>
											<td><input name="fix_clt" value="<?php echo $clt->fix_clt; ?>" data-mask="99.999.999" id="rc"/></td>
										</tr>
										<tr>
											<td class="span4">Tel FAX :</td>
											<td><input name="fax_clt" value="<?php echo $clt->fax_clt; ?>" data-mask="99.999.999" id="rc"/></td>
										</tr>
										<tr>
											<td class="span4">Email :</td>
											<td><input name="email_clt" value="<?php echo $clt->email_clt; ?>" id="rc"/></td>
										</tr>
										</tbody>
									</table>
									<h4>Addresse</h4>
									<div class="well">
										<address>
											<strong><?php echo $clt->nom_clt.' '.$clt->prenom_clt; ?></strong><br>
											<input name="adresse_clt" value="<?php echo $clt->adresse_clt; ?>" id="adresse"/><br><br>
											<?php echo $clt->fix_clt; ?><br>
										</address>
										<address><?php echo $clt->email_clt; ?></address>
                                	</div>
								</div>
								<div class="span4">
									<?php
									if($clt->activite_clt!=''){
										echo'
									<h4>Contact</h4>
									<ul class="unstyled">
										<table class="table-borderless" width="100%">
											<tbody>
												<tr>
													<td width="30%">Nom</td>
													<td width="70%"><input name="nom_con_clt" value="'.$clt->nom_con_clt.'" id="con"/></td>
												</tr>
												<tr>
													<td>Prénom</td>
													<td><input name="prenom_con_clt" value="'.$clt->prenom_con_clt.'" id="con"/></td>
												</tr>
												<tr>
													<td>Poste</td>
													<td><input name="post_con_clt" value="'.$clt->post_con_clt.'" id="con"/></td>
												</tr>
												<tr>
													<td>Tel1</td>
													<td><input name="tel_con_clt" value="'.$clt->tel_con_clt.'" data-mask="99.999.999" id="con"/></td>
												</tr>
												<tr>
													<td>Tel2</td>
													<td><input name="tel2_con_clt" value="'.$clt->tel2_con_clt.'" data-mask="99.999.999" id="con"/></td>
												</tr>
												<tr>
													<td>Email</td>
													<td><input name="email_con_clt" value="'.$clt->email_con_clt.'" id="con"/></td>
												</tr>
											</tbody>
										</table>
									</ul>
									';}?>
									<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée le, <?php echo $clt->created_date; ?> par : <a href="<?php echo $site; ?>ili-users/user_profil?id=<?php echo $clt->created_by; ?>"><?php echo $createur->nom.' '.$createur->prenom; ?></a></div>
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