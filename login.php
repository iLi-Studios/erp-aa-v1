<?php include"ili-functions/functions.php"; ?>
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
<link href="ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="ili-style/css/style.css" rel="stylesheet" />
<link href="ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
</head>
<!-- END HEAD -->
<?php 
if( (isset($_POST['email'])) && (isset($_POST['Password'])) ){
	LogIn($_POST['email'], md5($_POST['Password']));
}
?>
<!-- BEGIN BODY -->
<body id="login-body">
<div class="login-header"> 
	<!-- BEGIN LOGO -->
	<div id="logo" class="center">
		<h4> <?php echo $sytem_title;?> </h4>
	</div>
	<!-- END LOGO --> 
</div>

<!-- BEGIN LOGIN -->
<div id="login"> 
	<!-- BEGIN LOGIN FORM -->
	<form id="loginform" class="form-vertical no-padding no-margin" action="" method="post">
		<div class="lock"> <i class="icon-lock"></i> </div>
		<div class="control-wrap">
			<h4>Authentification</h4>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend"> <span class="add-on"><i class="icon-user"></i></span>
						<input id="input-username" name="email" type="email" placeholder="email" required autofocus/>
					</div>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend"> <span class="add-on"><i class="icon-key"></i></span>
						<input id="input-password" name="Password" type="password" placeholder="Mot de passe" required />
					</div>
					<!--<div class="mtop10">
						<div class="block-hint pull-left small">
							<input type="checkbox" id="">
							Remember Me </div>
						<div class="block-hint pull-right"> <a href="javascript:;" class="" id="forget-password">Forgot Password?</a> </div>
					</div>-->
					<?php ErrorGet('message'); ?>
					<div class="clearfix space5"></div>
				</div>
			</div>
		</div>
		<input type="submit" id="login-btn" class="btn btn-block login-btn" value="Connexion" />
	</form>
	<!-- END LOGIN FORM --> 
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form id="forgotform" class="form-vertical no-padding no-margin hide" action="index.html">
		<p class="center">Enter your e-mail address below to reset your password.</p>
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend"> <span class="add-on"><i class="icon-envelope"></i></span>
					<input id="input-email" type="text" placeholder="Email"  />
				</div>
			</div>
			<div class="space20"></div>
		</div>
		<input type="button" id="forget-btn" class="btn btn-block login-btn" value="Submit" />
	</form>
	<!-- END FORGOT PASSWORD FORM --> 
</div>
<!-- END LOGIN --> 
<!-- BEGIN COPYRIGHT -->
<div id="login-copyright"><?php echo $copy_right;?></div>
<!-- END COPYRIGHT --> 
<!-- BEGIN JAVASCRIPTS --> 
<script src="ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="ili-style/js/jquery.blockui.js"></script> 
<script src="ili-style/js/scripts.js"></script> 
<script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>