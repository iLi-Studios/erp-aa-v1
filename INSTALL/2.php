<?php 
if(file_exists('../ili-functions/config.php')){header('Location: ../index');}
include"../ili-functions/functions.php";
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
<title>Installation Etape 2/4</title>
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
                        <h4><i class="icon-reorder"></i>Installation du système ETAPE 2/4 : Installation de base des données</h4>
                     </div>
                     <div class="widget-body form">
                        <!-- BEGIN FORM-->
						<br>
                        <form action="" class="form-horizontal" method="post">
						   <div class="control-group">
                              <h3>NB ! Veillez svp ne pas interrompre cette opération</h3>
							  <h4>Si l'installation de base de données est effectuer avec succé vous serais automatiquement rediriger a l'étape suivante</h4>
                           </div>

<?php echo'<img src="../ili-style/img/loading.gif">'; ?>
<?php
$sql=file_get_contents("db.sql");
$sql_array = explode (";",$sql); 
foreach ($sql_array as $val) {QueryExcuteWhile($val);}
Redirect('INSTALL/3');
?>
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