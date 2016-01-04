<?php include"ili-functions/functions.php"; ?>
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
<link href="ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="ili-style/css/style.css" rel="stylesheet" />
<link href="ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
</head>
<!-- END HEAD -->
<?php
function connexion($email, $mdp){
	if($_SESSION['tentative']<=3){
		$query="SELECT * FROM users, users_rank WHERE users.email='$email' AND users.mdp='$mdp' AND users.id_rank=users_rank.id_rank";
		if( ($o=query_execute("mysqli_fetch_object", $query)) == true){
			if($o->id_rank=='1'){redirect("login?message=3");}
			else{
				$_SESSION['user_id']=$o->id_user;
				$_SESSION['user_nom']=$o->nom;
				$_SESSION['user_prenom']=$o->prenom; 
				$_SESSION['user_nom_prenom']=$_SESSION['user_nom'] . $_SESSION['user_prenom'];
				$_SESSION['user_id_rank']=$o->id_rank;
				$_SESSION['user_rank']=$o->rank;
				$_SESSION['user_img']=$o->img_link;
				write_log("Connexion");
				redirect("index");
			}
		}
		else{
			$_SESSION['tentative']=$_SESSION['tentative']+1;
			redirect("login?message=2");
			}
	}
	else{redirect("login?message=13");}
}
// forum login
if( (isset($_POST['email'])) && (isset($_POST['mdp'])) ){connexion($_POST['email'], md5($_POST['mdp']));}
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
						<input id="input-password" name="mdp" type="password" placeholder="Mot de passe" required />
					</div>
					<!--<div class="mtop10">
						<div class="block-hint pull-left small">
							<input type="checkbox" id="">
							Remember Me </div>
						<div class="block-hint pull-right"> <a href="javascript:;" class="" id="forget-password">Forgot Password?</a> </div>
					</div>-->
					<?php get_message('message'); ?>
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