<?php 
include"../ili-functions/functions.php";
function UploadImage(){
	if(isset($_POST["UploadImage"])) {
		$target_dir = "../ili-upload/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]['name']);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$imageFilename = pathinfo($target_file,PATHINFO_FILENAME);
		$imageNewName = "logo";
		$NewTarget = $target_dir.$imageNewName.'.'.$imageFileType;
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			/*echo "Ce fichier est une image - " . $check["mime"] . ".";*/
			$uploadOk = 1;
		} else {
			echo "Ce fichier n'est pas une image.";
			$uploadOk = 0;
		}
		// Check if file already exists
		/*if (file_exists($target_file)) {
			echo "Fichier existe déjà.";
			$uploadOk = 0;
		}*/
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Le fichier est volumineux.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "png" /*&& $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jpg"*/) {
			echo "L'extension PNG uniquement est autorisé.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Erreur : Chargement!.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $NewTarget)) {
				/*echo "Fichier ". basename( $_FILES["fileToUpload"]["name"]). " Chargé.";*/
			} else {
				echo "Erreur : Chargement!.";
			}
		}
	}
}
function CompanyInsert(){
	if((isset($_POST['MF']))&&(isset($_POST['RC']))&&(isset($_POST['RS']))&&(isset($_POST['Activity']))&&(isset($_POST['Adress']))&&(isset($_POST['Phone1']))){
		//Recup variable
		$MF				=addslashes($_POST['MF']);
		$RC				=addslashes($_POST['RC']);
		$RS				=addslashes($_POST['RS']);
		$Activity		=addslashes($_POST['Activity']);
		$Adress			=addslashes($_POST['Adress']);
		$Phone1			=addslashes($_POST['Phone1']);
		if(isset($_POST['Phone2'])){$Phone2=$_POST['Phone2'];}else{$Phone2='';}
		if(isset($_POST['Fax'])){$Fax=$_POST['Fax'];}else{$Fax='';}
		if(isset($_POST['Email'])){$Email=$_POST['Email'];}else{$Email='';}
		if(isset($_POST['WebSite'])){$WebSite=$_POST['WebSite'];}else{$WebSite='';}
		if(isset($_POST['BankAccount1'])){$BankAccount1=$_POST['BankAccount1'];}else{$BankAccount1='';}
		if(isset($_POST['BankAccount2'])){$BankAccount2=$_POST['BankAccount2'];}else{$BankAccount2='';}
		UploadImage();
		QueryExcute("", "INSERT INTO `company` VALUES ('1', '$MF', '$RC', '$RS', '$Activity', '$Adress', '$Phone1', '$Phone2', '$Fax', '$Email', '$WebSite', '$BankAccount1', '$BankAccount2' );");
		Redirect('login');
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
<title>Installation Etape 4/4</title>
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
                        <h4><i class="icon-reorder"></i>Installation du système ETAPE 4/4 : Confuguration de l'entreprise</h4>
                     </div>
                     <div class="widget-body form">
                        <!-- BEGIN FORM-->
						<br>
                        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
								<div class="control-group">
									<label class="control-label">LOGO ENTREPRISE</label>
									<div class="controls">
										<input type="hidden" name="UploadImage">
										<input type="file" name="fileToUpload" id="fileToUpload" required class="span6  popovers">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Matricule Fiscal</label>
									<div class="controls">
										<input type="text" placeholder="Obligatoire*" required name="MF" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Registre du commerce</label>
									<div class="controls">
										<input type="text" placeholder="Obligatoire*" required name="RC" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Raison Social</label>
									<div class="controls">
										<input type="text" placeholder="Obligatoire*" required name="RS" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Activité</label>
									<div class="controls">
										<input type="text" placeholder="Obligatoire*" required name="Activity" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Adresse</label>
									<div class="controls">
										<input type="text" placeholder="Obligatoire*" required name="Adress" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Tel1</label>
									<div class="controls">
										<input type="text" placeholder="Obligatoire*" required name="Phone1" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Tel2</label>
									<div class="controls">
										<input type="text" name="Phone2" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Fax</label>
									<div class="controls">
										<input type="text" name="Fax" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Email</label>
									<div class="controls">
										<input type="email" name="Email" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Site Web</label>
									<div class="controls">
										<input type="text" name="WebSite" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">RIB1</label>
									<div class="controls">
										<input type="text" name="BankAccount1" class="span6  popovers"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">RIB2</label>
									<div class="controls">
										<input type="text" name="BankAccount2" class="span6  popovers"/>
									</div>
								</div>
								<?php CompanyInsert(); ?>
								<!--Mot de passe*-->
                           <div class="form-actions">
                              <button type="submit" class="btn btn-success">Enregistrer</button>
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