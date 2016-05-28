<?php 
if(file_exists('../ili-functions/config.php')){header('Location: ../index');}
include"../ili-functions/functions.php";
function AdminInsert(){
	if((isset($_POST['cin']))&&(isset($_POST['FamilyName']))&&(isset($_POST['FirstName']))&&(isset($_POST['Email']))&&(isset($_POST['Phone']))&&(isset($_POST['Password']))&&(isset($_POST['Adress']))){
		//Recup variable
		$cin						=addslashes($_POST['cin']);
		$FamilyName					=addslashes($_POST['FamilyName']);
		$FirstName					=addslashes($_POST['FirstName']);
		$Email						=addslashes($_POST['Email']);
		$FunctionPost				='ADMINISTRATEUR';
		$Phone						=addslashes($_POST['Phone']);
		$Adress						=addslashes($_POST['Adress']);
		$Password					=addslashes($_POST['Password']);
		$BirthDay					=addslashes($_POST['BirthDay']);
		// Function
		global $Timestamp, $URL, $sytem_title;
		QueryExcute("", "INSERT INTO `users` VALUES ('$cin', '3', '$FamilyName', '$FirstName', '$Email', '$FunctionPost', '$Phone', '$Adress', '$BirthDay', MD5('$Password'), '$Timestamp', '', '', '', '', '$sytem_title', '$Timestamp')");
		Redirect('INSTALL/4');
	}
}
?>
<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fr">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title>Installation Etape 3/4</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<?php echo $META_description;?>
<?php echo $META_author;?>
<link rel="shortcut icon" href="ili-upload/favicon.png">
<link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../ili-style/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
<link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../ili-style/css/style.css" rel="stylesheet" />
<link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link href="../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/gritter/css/jquery.gritter.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/uniform/css/uniform.default.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/jquery-tags-input/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/clockface/css/clockface.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="../ili-style/assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
<link rel="stylesheet" href="../ili-style/assets/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-daterangepicker/daterangepicker.css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body id="coming-body">
<div class="lock-header"> 
	<!-- BEGIN LOGO --> 
	<h2><?php echo $sytem_title;?></h2>
	<!-- END LOGO --> 
</div>

<!-- BEGIN COMING SOON -->
<div class="coming-soon">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12 responsive" data-tablet="span4" data-desktop="span12">


				<div class="widget">
                     <div class="widget-title">
                        <h4><i class="icon-reorder"></i>Installation du système ETAPE 3/4 : Confuguration du compte ADMINISTRATEUR</h4>
                     </div>
                     <div class="widget-body form">
                        <!-- BEGIN FORM-->
						<br>
                        <form action="" class="form-horizontal" method="post">
								<div class="control-group">
									<label class="control-label">N° CIN</label>
									<div class="controls">
										<input type="text" required name="cin" class="span6  popovers" data-trigger="hover" data-content="Numéro de Carte Identité Nationnale 8 chiffres" data-mask="99999999"/>
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<!--N° CIN*-->
								<div class="control-group">
									<label class="control-label">Nom</label>
									<div class="controls">
										<input type="text" required name="FamilyName" class="span6  popovers" />
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<!--Nom*-->
								<div class="control-group">
									<label class="control-label">Prénom</label>
									<div class="controls">
										<input type="text" required name="FirstName" class="span6  popovers" />
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<!--Prénom*-->
								<div class="control-group">
									<label class="control-label">Date de naissance</label>
									<div class="controls">
										<input type="text" required name="BirthDay" class="span6  popovers" data-mask="99-99-9999" data-content="jj/mm/aaaa" />
										<span class="help-inline">Champ obligatoire</span> </div>
								</div>
								<!--Date de naissance-->
								<div class="control-group">
									<label class="control-label">Email</label>
									<div class="controls">
										<input type="email" required name="Email" class="span6 popovers" />
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<!--Email*-->
								<div class="control-group">
									<label class="control-label">Tel</label>
									<div class="controls">
										<input type="text" required name="Phone" class="span6  popovers" data-mask="99.999.999"/>
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<!--Tel*-->
								<div class="control-group">
									<label class="control-label">Adress</label>
									<div class="controls">
										<textarea class="span6 " rows="3" name="Adress" required></textarea>
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<!--Adress*-->
								<div class="control-group">
									<label class="control-label">Mot de passe</label>
									<div class="controls">
										<input type="text" required name="Password" class="span6  popovers" data-trigger="hover" data-content="Essayé une mot de passe complex de 5 caractéres au minimume, genre X2€n!" data-original-title="Mot de passe par defaut" />
										<span class="help-inline"> Champ obligatoire</span> </div>
								</div>
								<?php AdminInsert(); ?>
								<!--Mot de passe*-->
                           <div class="form-actions">
                              <button type="submit" class="btn btn-success">Etape suivante ?</button>
                              <button type="button" class="btn">Annuler</button>
                           </div>
                        </form>
                        <!-- END FORM-->           
                     </div>
                  </div>


			</div>
		</div>
	</div>
</div>
<!-- END COMING SOON --> 
<script type="text/javascript" src="../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script type="text/javascript" src="../ili-style/assets/clockface/js/clockface.js"></script> 
<script type="text/javascript" src="../ili-style/assets/jquery-tags-input/jquery.tagsinput.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-daterangepicker/date.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script> 
<script src="../ili-style/assets/fancybox/source/jquery.fancybox.pack.js"></script> 
<script src="../ili-style/js/scripts.js"></script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>