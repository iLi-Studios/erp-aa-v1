<?php 
include"../../ili-functions/functions.php";
autorisation('2');
autorisation_double_check_privilege('CLIENTS', 'S');
$id_client=$_GET['id'];
$clt=get_client_info($id_client);
if($clt==''){redirect('index?message=18');}
$createur=get_user_info($clt->created_by);
function users_pannel($id, $clt){
	// ADMIN
	if($_SESSION['user_id_rank']>=3){
		//C
		echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';
		//U=B
		echo'<a href="edit?id='.$clt->id_clt.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
		//D
		echo'<a href="#myModal_del" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';
		//B=U
	}
	// USER
	if($_SESSION['user_id_rank']==2){
		$up=user_privileges("CLIENTS", $_SESSION['user_id']);$s=$up->s;$c=$up->c;$u=$up->u;$d=$up->d;
		//S
		if(!$s){echo'<script language="Javascript">document.location.href="../../index?message=17"</script>';}
		//C
		if($c){echo'<a href="add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';}
		//U=B
		if($u){echo'<a href="edit?id='.$clt->id_clt.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';}
		//D
		if($d){echo'<a href="#myModal_del" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
		//B=D
	}
}
if($_SESSION['user_id_rank']==2){$up_cnt=user_privileges("CONTRAT", $_SESSION['user_id']);}
function liste_des_conrtat_client($id){
	global $up_cnt;	
	$q="SELECT * FROM `contrat` WHERE `id_clt`='$id';";
	$result=query_excute_while($q);
	while ($o=mysqli_fetch_object($result)){
		$q1="
				SELECT * FROM contrat, contrat_ren
						WHERE
						contrat.id_cnt='$o->id_cnt'
						AND
						contrat.id_cnt=contrat_ren.id_cnt_ren
		";
		$q2="SELECT * FROM `contrat_ren` WHERE `id_cnt_ren`='$o->id_cnt' ORDER BY id_ren DESC LIMIT 1";	
		$o1=query_execute("mysqli_num_rows", $q1);
		$o2=query_execute("mysqli_fetch_object", $q2);
		$q_somme="
			SELECT (SUM(montant_ren)+(montant)) as total
				FROM contrat, contrat_ren
				WHERE
				contrat.id_cnt='$o->id_cnt'
				AND
				contrat.id_cnt=contrat_ren.id_cnt_ren		
		";
		$o_somme=query_execute("mysqli_fetch_object", $q_somme);
		echo'
		<tr>
			<td><a href="#">'.$o->id_cnt.'</a></td>
			<td>'.$o->montant.'</td>
			<td>';?><?php if($o1){echo sprintf("%.3f",$o_somme->total);}else{echo $o->montant;}?><?php echo'</td>
			<td>';?><?php
			if($o1){echo'<span class="label label-success">Renouvelé '.$o1.'x</span>';}else{echo'<span class="label label-info">Nouveau</span>';}?><?php echo'
            </td>
			<td>';?><?php if($o1){echo $o2->date_expiration_ren;}else{echo $o->date_expiration;}?><?php echo'</td>
			<td>';?><?php
			if($_SESSION['user_id_rank']==2){
				if($up_cnt->d){echo'<a href="#myModal_drop'.$o->id_cnt.'" data-toggle="modal" class="icon-trash tooltips" data-original-title="Supprimer ce conrtat"></a>';} echo'|';
				if($up_cnt->u){echo'<a href="#myModal_ren'.$o->id_cnt.'" data-toggle="modal" class="icon-repeat tooltips" data-original-title="Renouveler ce conrtat"></a>';}			
			}
			if($_SESSION['user_id_rank']>2){
				echo'
				<a href="#myModal_drop'.$o->id_cnt.'" data-toggle="modal" class="icon-trash tooltips" data-original-title="Supprimer ce conrtat"></a> | 
				<a href="#myModal_ren'.$o->id_cnt.'" data-toggle="modal" class="icon-repeat tooltips" data-original-title="Renouveler ce conrtat"></a>
				';
			}
				?><?php echo'
			</td>
		</tr>
		
		<div id="myModal_ren'.$o->id_cnt.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_ren'.$o->id_cnt.'" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel_ren'.$o->id_cnt.'">Renouvellement du contrat</h3>
			</div>
			<div class="modal-body">
				<form action="" method="post">
				<center>
					<span>Contrat N° :</span><br><input class="input-xlarge" name="ren_id_cnt" value="'.$o->id_cnt.'" readonly required/><br>
					<span>CIN / MF N° :</span><br><input class="input-xlarge" name="ren_id_clt" value="'.$id.'" readonly required/><br>
					<span>Monatant :</span><br><input class="input-xlarge" name="ren_montant" required/><br>
					<span>Date expiration :</span><br><input class="input-xlarge" name="ren_expiration" data-mask="99-99-9999" required/><br>
				</center>
			</div>
			<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
					<input type="submit" class="btn btn-primary" value="Confirmer ?"/>
				</form>
			</div>
		</div>
				
		<div id="myModal_drop'.$o->id_cnt.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_drop'.$o->id_cnt.'" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel_drop'.$o->id_cnt.'">Confirmation de suppression</h3>
			</div>
			<div class="modal-body">
				<p>Vous êtes sur de vouloire supprimer le contrat n° '.$o->id_cnt.' ? <br> NB: et cette action est <strong>irréversible!</strong></p>
			</div>
			<div class="modal-footer">
				<form action="" method="post">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
					<input type="hidden" name="contrat_supp_clt" value="'.$id.'"/>
					<input type="hidden" name="contrat_supp_cnt" value="'.$o->id_cnt.'"/>
					<input type="submit" class="btn btn-primary" value="Confirmer ?"/>
				</form>
			</div>
		</div>
		';
	}
}
if( (isset($_POST['ren_id_cnt'])) && (isset($_POST['ren_montant'])) && (isset($_POST['ren_expiration'])) ){
	$id_user=$_SESSION['user_id'];
	$user_nom=$_SESSION['user_nom'];
	$user_prenom=$_SESSION['user_prenom'];
	$ren_id_cnt = addslashes($_POST['ren_id_cnt']);
	$ren_id_clt = addslashes($_POST['ren_id_clt']);
	$ren_montant = addslashes($_POST['ren_montant']);
	$ren_expiration = addslashes($_POST['ren_expiration']);
	$q_ren="INSERT INTO `contrat_ren` (`id_ren`, `id_cnt_ren`, `montant_ren`, `date_expiration_ren`) VALUES (NULL, '$ren_id_cnt', '$ren_montant', '$ren_expiration');";
	query_execute_insert($q_ren);
	notif_all('', '', '<a href="'.$site.'ili-modules/client/client?id='.$ren_id_clt.'">'.$user_nom.' '.$user_prenom.' a renouvelé le  conrtat n° '.$ren_id_cnt.' du client '.$ren_id_clt);
	write_log("Renouvellement du conrtat n°".$ren_id_cnt." du client : <a href=\"ili-modules/client/client?id=".$ren_id_clt."\">".$ren_id_clt."</a>");
}
if( (isset($_POST['id_clt'])) && (isset($_POST['id_cnt'])) && (isset($_POST['montant'])) && (isset($_POST['expiration'])) ){
	$id_user=$_SESSION['user_id'];
	$user_nom=$_SESSION['user_nom'];
	$user_prenom=$_SESSION['user_prenom'];
	$id_clt=addslashes($_POST['id_clt']);
	$id_cnt=addslashes($_POST['id_cnt']);
	$montant=addslashes($_POST['montant']);
	$expiration=addslashes($_POST['expiration']);
	$q_ferif="SELECT * FROM `contrat` WHERE `id_cnt`='$id_cnt'";
	$o=query_execute("mysqli_num_rows", $q_ferif);
	 if(!$o){
	 	$q="INSERT INTO `contrat` (`id_cnt`, `id_clt`, `montant`, `date_expiration`) VALUES ('$id_cnt', '$id_clt', '$montant', '$expiration');";
		query_execute_insert($q);
		notif_all('', '', '<a href="'.$site.'ili-modules/client/client?id='.$id_clt.'">'.$user_nom.' '.$user_prenom.' a creé un nouveau conrtat '.$id_cnt.' pour le client '.$id_clt);
		write_log("Création de conrtat ".$id_cnt." pour le client : <a href=\"ili-modules/client/client?id=".$id_clt."\">".$id_clt."</a>");
	 }
	 else{redirect('index?message=25');}
}
if( (isset($_POST['contrat_supp_cnt'])) && (isset($_POST['contrat_supp_clt']))){
	$id_user=$_SESSION['user_id'];
	$user_nom=$_SESSION['user_nom'];
	$user_prenom=$_SESSION['user_prenom'];
	
	$id_contart_a_supp = $_POST['contrat_supp_cnt'];
	$id_clt_du_contrat_supp = $_POST['contrat_supp_clt'];
	$q_contart_a_supp = "DELETE FROM `contrat` WHERE `id_cnt` = '$id_contart_a_supp';";
	
	query_execute_insert($q_contart_a_supp);
	notif_all('', '', '<a href="'.$site.'ili-modules/client/client?id='.$id_clt_du_contrat_supp.'">'.$user_nom.' '.$user_prenom.' a supprimer le  conrtat n° '.$id_contart_a_supp.' du client '.$id_clt_du_contrat_supp);
	write_log("Suppression du conrtat n°".$id_contart_a_supp." du client : <a href=\"ili-modules/client/client?id=".$id_clt_du_contrat_supp."\">".$id_clt_du_contrat_supp."</a>");
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
								<?php users_pannel($_SESSION['user_id'], $clt);?>
								<a href="javascript:;" class="icon-chevron-down"></a>
							</span>
                        </div>
						
						<div class="widget-body">
                            <div class="span5">
                                <h3><?php echo $clt->nom_clt; ?><?php if($clt->activite_clt==''){echo '<br>'.$clt->prenom_clt; }?> <br/><small><?php echo $clt->activite_clt; ?></small></h3>
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td class="span4">
										<?php if($clt->activite_clt==''){echo'CIN : ';}else{echo'Matricule Fiscale :';}?>
										</td>
                                        <td><?php echo $clt->id_clt; ?></td>
                                    </tr>
									<?php if(($clt->activite_clt=='')&&($clt->date_nais_clt!='')){echo'
									<tr>
                                        <td class="span4">Age :</td>
                                        <td>'.age($clt->date_nais_clt).'</td>
                                    </tr>
									';}?>
									<?php if($clt->activite_clt!=''){echo'
									<tr>
                                        <td class="span4">Registre du commerce :</td>
                                        <td>'.$clt->rc.'</td>
                                    </tr>
									';}?>
									<tr>
                                        <td class="span4">Tel FIX :</td>
                                        <td><?php echo $clt->fix_clt; ?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Tel FAX :</td>
                                        <td><?php echo $clt->fax_clt; ?></td>
                                    </tr>
									<tr>
                                        <td class="span4">Email :</td>
                                        <td><a href="mailto:<?php echo $clt->email_clt; ?>"><?php echo $clt->email_clt; ?></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h4>Addresse</h4>
                                <div class="well">
                                    <address>
                                        <strong><?php echo $clt->nom_clt.' '.$clt->prenom_clt; ?></strong><br>
                                        <?php echo $clt->adresse_clt; ?><br><br>
                                        <?php echo $clt->fix_clt; ?><br>
                                    </address>
                                    <address>
                                        <a href="mailto:<?php echo $clt->email_clt; ?>"><?php echo $clt->email_clt; ?></a>
                                    </address>
                                </div>
                            </div>
                            <div class="span7">
                            <?php
							if($_SESSION['user_id_rank']==2){
								if($up_cnt->s){
									echo' 
										<h4>Suivie des contrats</h4>
										<ul class="unstyled">
											<table class="table table-striped table-bordered table-advance table-hover" width="100%">
										   <thead>
											  <tr>
												 <th width="20%"><i class="icon-briefcase"></i> Conrtat</th>
												 <th width="17%"><i class="icon-money"></i> Mont.Base</th>
												 <th width="17%"><i class="icon-shopping-cart"></i> Mont.Total</th>
												 <th width="17%"><i class="icon-sitemap"></i> Historique</th>
												 <th width="17%"><i class="icon-signout"></i> Expiration</th>
												 <th width="12%">';?><?php if($up_cnt->c){echo'<a href="#myModal_add" class="icon-file tooltips" data-toggle="modal" data-original-title="Nouveau Conrtat"></a>';};?><?php echo'</th>
											  </tr>
										   </thead>
										   <tbody>';?><?php liste_des_conrtat_client($id_client) ;?><?php echo'</tbody>
										</table>
										</ul>
										<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée le, '.$clt->created_date.' par : <a href="'.$site.'ili-users/user_profil?id='.$clt->created_by.'">'.$createur->nom.' '.$createur->prenom.'</a></div>
									';
								}
							}
							else{
								echo' 
										<h4>Suivie des contrats</h4>
										<ul class="unstyled">
											<table class="table table-striped table-bordered table-advance table-hover" width="100%">
										   <thead>
											  <tr>
												 <th width="20%"><i class="icon-briefcase"></i> Conrtat</th>
												 <th width="17%"><i class="icon-money"></i> Mont.Base</th>
												 <th width="17%"><i class="icon-shopping-cart"></i> Mont.Total</th>
												 <th width="17%"><i class="icon-sitemap"></i> Historique</th>
												 <th width="17%"><i class="icon-signout"></i> Expiration</th>
												 <th width="12%"><a href="#myModal_add" class="icon-file tooltips" data-toggle="modal" data-original-title="Nouveau Conrtat"></a></th>
											  </tr>
										   </thead>
										   <tbody>';?><?php liste_des_conrtat_client($id_client) ;?><?php echo'</tbody>
										</table>
										</ul>
										<div class="alert alert-success"><i class="icon-ok-sign"></i> Crée le, '.$clt->created_date.' par : <a href="'.$site.'ili-users/user_profil?id='.$clt->created_by.'">'.$createur->nom.' '.$createur->prenom.'</a></div>
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

<!-- Modale de confirmation de suppression -->
<div id="myModal_del" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_del" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel_del">Confirmation de suppression</h3>
	</div>
	<div class="modal-body">
		<p>Vous êtes sur de vouloire supprimer le client <strong><?php echo $clt->nom_clt.' '.$clt->prenom_clt; ?></strong>? <br> La supprission du client entraine la suprission de toutes ces activités, et cette action est <strong>irréversible!</strong></p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
		<button onClick='document.location.href="remove?id=<?php echo $clt->id_clt; ?>";' data-dismiss="modal" class="btn btn-primary">Confirm</button>
	</div>
</div>
<!-- Modale de confirmation de suppression -->

<!-- Modale de creation contrat -->
<div id="myModal_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel_add">Création du contrat</h3>
	</div>
	<div class="modal-body">
    <form action="" method="post">
		<table width="100%">
        	<tr>
            	<td width="30%">CIN / MF</td>
                <td width="70%"><input class="input-xlarge" name="id_clt" value="<?php echo $clt->id_clt; ?>" readonly/></td>
            </tr>
            <tr>
            	<td>Client</td>
                <td><input class="input-xlarge" value="<?php echo $clt->nom_clt; ?> <?php echo $clt->prenom_clt; ?>" readonly/></td>
            </tr>
            <tr>
            	<td>Conrtat N°</td>
                <td><input class="input-xlarge" name="id_cnt" value="" required/></td>
            </tr>
            <tr>
            	<td>Montant</td>
                <td><input class="input-xlarge" name="montant" value="" required/></td>
            </tr>
            <tr>
            	<td>Date Expiration</td>
                <td><input class="input-xlarge" name="expiration" value="" data-mask="99-99-9999" required/></td>
            </tr>
        </table>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
		<input type="submit" class="btn btn-primary" value="Enregistrer ?"/>
	</div>
    </form>
</div>
<!-- Modale de creation contrat -->

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