<?php 
include"../../ili-functions/functions.php";
autorisation('3');
$ets=get_ets_info();
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
						<li> <a href="<?php echo $site; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="info">Configuration</a><span class="divider">&nbsp;</span></li>
						<li><a href="info">Etablissement</a><span class="divider-last">&nbsp;</span></li>
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
                            <h4><i class="icon-reorder"></i> Fiche Etablissement</h4>
                            <span class="tools"><a href="javascript:;" class="icon-chevron-down"></a></span>
                        </div>
						
						<div class="widget-body">
                            <div class="span8">
                                <h3><?php echo $ets->rs_ets; ?> <br/><small><?php echo $ets->activites_principale_ets; ?>, </small><small><?php echo $ets->activites_secondaire_ets; ?></small></h3>
                                <table class="table table-borderless">
                                    <tbody>
										<tr>
											<td>Tel1</td>
											<td><?php echo $ets->tel1_ets; ?></td>
										</tr>
										<tr>
											<td>Tel2</td>
											<td><?php echo $ets->tel2_ets; ?></td>
										</tr>
                                        <tr>
											<td>Fax</td>
											<td><?php echo $ets->fax_ets; ?></td>
										</tr>
                                    <tr>
                                        <td class="span4">RIB 1:</td>
                                        <td><?php echo $ets->rib1_ets; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="span4">RIB2 :</td>
                                        <td><?php echo $ets->rib2_ets; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h4>Addresse</h4>
                                <div class="well">
                                    <address>
                                        <?php echo $ets->adresse_ets; ?><br><br>
                                    </address>
                                    <address>
                                    	<a href="<?php echo $ets->web_ets; ?>"><?php echo $ets->web_ets; ?></a><br>
                                        <a href="mailto:<?php echo $ets->email1_ets; ?>"><?php echo $ets->email1_ets; ?></a><br>
                                        <a href="mailto:<?php echo $ets->email2_ets; ?>"><?php echo $ets->email2_ets; ?></a>
                                    </address>
                                </div>
                            </div>
                            <div class="span4">
								<ul class="unstyled">
									<table class="table table-borderless" width="100%">
										<tbody>
                                        	<tr>
                                                <td class="span3">Matricule Fiscale :</td>
                                                <td><?php echo $ets->mf_ets; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Registre de commerce :</td>
                                                <td><?php echo $ets->rc_ets; ?></td>
                                            </tr>
											<tr>
												<td>Gérant</td>
												<td>
												<?php 
												$usr=get_user_info($ets->gerant_ets);
												echo '<a href="'.$site.'ili-users/user_profil?id='.$ets->gerant_ets.'">'.$usr->nom.' '.$usr->prenom.'</a>'; 
												?>
												</td>
											</tr>
                                            <tr>
												<td>Vente en gros</td>
												<td><?php if($ets->vente_en_gros){echo'OUI';} else{echo'NON';}?></td>
											</tr>
										</tbody>
									</table>
                                </ul>
                            </div>
                            <div class="span4">
                            	<center><img src="<?php echo $site; ?>/ili-upload/logo.png" width="300px" height="300px"/></center>
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


<!-- Modale de confirmation de suppression -->
<div id="myModal_del" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_del" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel_del">Confirmation de suppression</h3>
	</div>
	<div class="modal-body">
		<p>Vous êtes sur de vouloire supprimer le client <strong><?php echo $clt->nom_clt.' '.$clt->prenom_clt; ?></strong>? <br> Cette action est <strong>irréversible!</strong></p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
		<button onClick='document.location.href="remove?id=<?php echo $clt->id_clt; ?>";' data-dismiss="modal" class="btn btn-primary">Confirm</button>
	</div>
</div>
<!-- Modale de confirmation de suppression -->

<!-- Modale de banissement client -->
<div id="myModal_ban" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_ban" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel_ban">Confirmation de banissement</h3>
	</div>
	<div class="modal-body">
		<form action="" method="post">
		<p>Raison de banissement:</p>
		<textarea name="ban_raison" style="resize: vertical; width:90%; max-height:150px;" rows="4" required></textarea>
		<input type="hidden" name="id_clt" value="<?php echo $clt->id_clt; ?>">
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
		<input type="submit" class="btn btn-primary" value="Confirmer"/>
		</form>
	</div>
</div>
<!-- Modale de banissement client -->



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