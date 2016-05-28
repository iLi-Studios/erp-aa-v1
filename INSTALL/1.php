<?php
if(file_exists('../ili-functions/config.php')){header('Location: ../index');}
$sytem_title="iLi-Manager1.0";
$copy_right ='2016 &copy; '.$sytem_title.'  By <a href="http://www.ili-studios.tn/" target="new" style="none"> <strong>iLi-Studios</strong> </a>';
$author=
"
<!--
iLi-ERP
Société	: iLi-Studios SARL
Site : http://www.ili-studios.tn/
-->
";
$META_description = '<meta content="iLi-ERP" name="description" />';
$META_author 	  = '<meta content="SAKLY AYOUB" name="author" />';
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
<title>Installation Etape 1/4</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<?php echo $META_description;?>
<?php echo $META_author;?>
<link rel="shortcut icon" href="../ili-style/ili-upload/favicon.png">
<link href="../ili-style/assets/coming_soon/demo/css/style.css" rel="stylesheet">
<link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../ili-style/css/style.css" rel="stylesheet" />
<link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />

<!-- jQuery and Modernizr-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Alex+Brush' rel='stylesheet' type='text/css'>
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
                        <h4><i class="icon-reorder"></i>Installation du système ETAPE 1/4 : Confuguration des information de base des données</h4>
                     </div>
                     <div class="widget-body form">
                        <!-- BEGIN FORM-->
						<br>
                        <form action="" class="form-horizontal" method="post">
                           <div class="control-group">
                              <label class="control-label">Adresse du serveur de base des données</label>
                              <div class="controls">
                                 <input type="text" name="MYSQL_SERVEUR" class="span6 " required autofocus/>
                                 <span class="help-inline"></span>
                              </div>
                           </div>
						   <div class="control-group">
                              <label class="control-label">Nom de base des données</label>
                              <div class="controls">
                                 <input type="text" name="MYSQL_BASE" class="span6 " required/>
                                 <span class="help-inline"></span>
                              </div>
                           </div>
						   <div class="control-group">
                              <label class="control-label">Utilisateur de base des donneés</label>
                              <div class="controls">
                                 <input type="text" name="MYSQL_UTILISATEUR" class="span6 " required/>
                                 <span class="help-inline"></span>
                              </div>
                           </div>
						   <div class="control-group">
                              <label class="control-label">Mot de passe de base des donneés</label>
                              <div class="controls">
                                 <input type="password" name="MYSQL_MOTDEPASSE" class="span6 "/>
                                 <span class="help-inline"></span>
                              </div>
                           </div>

<?php
if( isset($_POST['MYSQL_SERVEUR']) && isset($_POST['MYSQL_UTILISATEUR']) && isset($_POST['MYSQL_MOTDEPASSE']) && isset($_POST['MYSQL_BASE']) ){
	ini_set("display_errors",0);error_reporting(0); //desactivation d'erreur php sur cette page
	$Server_URL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //recupération du lien actif
	
	$URL = str_replace("INSTALL/1", "", $Server_URL); // formatage de lien et suppression de "INSTALL/1"
	$MYSQL_SERVEUR = $_POST['MYSQL_SERVEUR'];
	$MYSQL_UTILISATEUR = $_POST['MYSQL_UTILISATEUR'];
	$MYSQL_MOTDEPASSE = $_POST['MYSQL_MOTDEPASSE'];
	$MYSQL_BASE = $_POST['MYSQL_BASE'];
	
	$link=mysqli_connect($MYSQL_SERVEUR, $MYSQL_UTILISATEUR, $MYSQL_MOTDEPASSE, $MYSQL_BASE);
	//Vérification de la connexion
	if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	}
	else{
		file_put_contents('../ili-functions/config.php', '<?php'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', 'define(\'MYSQL_SERVEUR\', \''.$MYSQL_SERVEUR.'\');'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', 'define(\'MYSQL_UTILISATEUR\', \''.$MYSQL_UTILISATEUR.'\');'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', 'define(\'MYSQL_MOTDEPASSE\', \''.$MYSQL_MOTDEPASSE.'\');'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', 'define(\'MYSQL_BASE\', \''.$MYSQL_BASE.'\');'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$URL = \''.$URL.'\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$sytem_title = \''.$sytem_title.'\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$MinLigneLogToArchive=\'100\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$META_description=\''.$META_description.'\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$META_author=\''.$META_author.'\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$copy_right=\''.$copy_right.'\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '$author=\''.$author.'\';'."\n", FILE_APPEND);
		file_put_contents('../ili-functions/config.php', '?>'."\n", FILE_APPEND);
		echo'<script language="Javascript">document.location.href="'.$URL.'INSTALL/2"</script>';
	}
}
?>
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

<!-- BEGIN JAVASCRIPTS --> 
<script src="../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 

<!--coming soon js--> 
<script src="../ili-style/assets/coming_soon/demo/js/style.js"></script> 

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>