<?php 
include"../../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CLIENTS', 'C');
function ClientInsertToContrat(){
	//Form Variables
	if( (isset($_POST['idClient'])) && (isset($_POST['FamilyName'])) && (isset($_POST['FirstName'])) && (isset($_POST['Phone'])) && (isset($_POST['Adress'])) ){
		global $URL;
		$idClient	=addslashes($_POST['idClient']);
		$FamilyName	=addslashes($_POST['FamilyName']);
		$FirstName	=addslashes($_POST['FirstName']);
		$Phone		=addslashes($_POST['Phone']);
		$Adress		=addslashes($_POST['Adress']);
		$idUser		=$_SESSION['user_id'];
		$User		=$_SESSION['user_nom_prenom'];
		if((QueryExcute("mysqli_fetch_row", "SELECT * FROM client WHERE idClient='$idClient'"))==0){
			QueryExcute("", "INSERT INTO `client` VALUES ('$idClient', '$FamilyName', '$FirstName', '$Phone', '$Adress', '$idUser');");
			NotifAllWrite('', '', '<a href="'.$URL.'ili-modules/client/client?id='.$idClient.'">'.$User.' a creé un nouveau client , '.$FamilyName.' '.$FirstName);
			LogWrite("Création de client : <a href=\"ili-modules/client/client?id=".$idClient."\">".$idClient."</a>");
			Redirect('ili-modules/contrat/add/add?clt='.$idClient);
		}
		else{Redirect('ili-modules/client/add?message=16');}
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
<link rel="shortcut icon" href="../../client/ili-upload/favicon.png">
<link href="../../../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../../../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../../../ili-style/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
<link href="../../../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../../ili-style/css/style.css" rel="stylesheet" />
<link href="../../../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../../../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link rel="stylesheet" type="text/css" href="../../../ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
<link href="../../../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../../../ili-style/assets/uniform/css/uniform.default.css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php include"../../../ili-functions/fragments/page_header.php";?>
<!-- END HEADER --> 
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid"> 
	<!-- BEGIN SIDEBAR -->
	<?php include"../../../ili-functions/fragments/sidebar.php";?>
	<!-- END SIDEBAR --> 
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title"> Client <small> Forme ajout</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="index">Ajout</a><span class="divider">&nbsp;</span></li>
						<li><a href="new">Nouveau Client</a><span class="divider-last">&nbsp;</span></li>
					</ul>
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<?php ErrorGet('message'); ?>
				<div class="widget">
					<div class="widget-title">
						<h4><i class="icon-reorder"></i> Informations globales</h4>
						<!--<span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> <a href="javascript:;" class="icon-remove"></a> </span>--> </div>
					<div class="widget-body form">
						<br>
						<form action="" class="form-horizontal" method="post">
							<div class="control-group">
								<label class="control-label">CIN / MF / RC*</label>
								<div class="controls">
									<input class="span8" type="text" name="idClient" required autofocus/>
									<span class="help-inline"> N°PASPORT : Pour les étrangers</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Nom *</label>
								<div class="controls">
									<input type="text" name="FamilyName" class="span8" placeholder="Exemple : BEN MAHMOUD / STE : BFCO" required />
									<span class="help-inline">Etb / Ets / Ste : Pour les professionnel</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Prenom*</label>
								<div class="controls">
									<input type="text" name="FirstName" class="span8" placeholder="Exemple : AMINE / SARL" required />
									<span class="help-inline">SARL / SUARL : Pour les professionnel</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Téléphonne*</label>
								<div class="controls">
									<input class="span8" type="text" name="Phone" required/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Adress*</label>
								<div class="controls">
									<textarea name="Adress" class="span8" rows="6" required ></textarea>
								</div>
							</div>
							<br>
							<br>
							<center>
								<button type="reset" class="btn btn-info"><i class="icon-ban-circle icon-white"></i> Annuler</button>
								<button type="submit" class="btn btn-warning"><i class="icon-plus icon-white"></i> Créer</button>
							</center>
							<br>
							<br>
						</form>
						<?php ClientInsertToContrat(); ?>
					</div>
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
<script src="../../../ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="../../../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script src="../../../ili-style/js/scripts.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/ckeditor/ckeditor.js"></script> 
<script src="../../../ili-style/js/jquery.blockui.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]--> 
<script type="text/javascript" src="../../../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/clockface/js/clockface.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/jquery-tags-input/jquery.tagsinput.min.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-daterangepicker/date.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="../../../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script> 
<script src="../../../ili-style/assets/fancybox/source/jquery.fancybox.pack.js"></script> 
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