<?php 
include"../ili-functions/functions.php";
Authorization('2');
$idUser=$_GET['id'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}
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
<link rel="shortcut icon" href="ili-upload/favicon.png">
   <link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="../ili-style/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="../ili-style/css/style.css" rel="stylesheet" />
   <link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
   <link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />

   <link href="../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="../ili-style/assets/uniform/css/uniform.default.css" />

   <link rel="stylesheet" type="text/css" href="../ili-style/assets/bootstrap-tree/bootstrap-tree/css/bootstrap-tree.css" />

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<?php include"../ili-functions/fragments/page_header.php";?>
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
	<?php include"../ili-functions/fragments/sidebar.php";?>
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12"> 
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title"> Utilisateurs <small> Profil</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL;?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li> <a href="users">Utilisateurs du système</a> <span class="divider">&nbsp;</span></li>
						<li> <a href="user_profil?id=<?php echo $user->idUser;?>">Profil</a><span class="divider-last">&nbsp;</span></li>
						<li class="pull-right search-wrap">
							<form class="hidden-phone">
								<div class="search-input-area">
									<input id=" " class="search-query" type="text" placeholder="Recherche ?">
									<i class="icon-search"></i> </div>
							</form>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB--> 
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
					<div class="widget">
						<div class="widget-title">
							<h4><i class="<?php UserGetIcon($user->idRank);?>"></i> Profil</h4>
							<span class="tools">
							<?php GetUserPanel('USER_PROFILE', $user->idUser, '');?>
							</span> 
						</div>
						<div class="widget-body">
							<div class="span3">
								<div class="text-center profil-pic">
									<?php if($user->ProfilePhoto!=''){echo'<img src="'.$user->ProfilePhoto.'" width="100%" height="226px;">';}?>
								</div>
								<ul class="nav nav-tabs nav-stacked">
									<?php UserSocialGet($user->idUser); ?>
								</ul>
								<?php UserPrivilegesGet($user->idUser, $user->idRank);?>			
							</div>
							<div class="span6">
								<h4><?php echo $user->FamilyName; ?> <?php echo $user->FirstName; ?><br/>
									<small><?php echo $user->FunctionPost; ?></small></h4>
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td class="span2">CIN :</td>
											<td><?php echo $user->idUser;?></td>
										</tr>
										<tr>
											<td class="span2">FamilyName :</td>
											<td><?php echo $user->FamilyName; ?></td>
										</tr>
										<tr>
											<td class="span2">Prénom :</td>
											<td><?php echo $user->FirstName; ?></td>
										</tr>
										<tr>
											<td class="span2">Age :</td>
											<td><?php echo Age($user->BirthDay);?> ans</td>
										</tr>
										<tr>
											<td class="span2">FunctionPost :</td>
											<td><?php echo $user->FunctionPost; ?></td>
										</tr>
										<tr>
											<td class="span2"> Email :</td>
											<td><?php echo $user->Email; ?></td>
										</tr>
										<tr>
											<td class="span2"> Mobile :</td>
											<td><?php echo $user->Phone; ?></td>
										</tr>
										<tr>
											<td class="span2">Grade :</td>
											<td><?php echo $user->Level; ?></td>
										</tr>
										<tr>
											<td class="span2">Ajouté le :</td>
											<td><?php echo $user->CreatedDate; ?> Par <?php echo $user->CreatedBy; ?></td>
										</tr>
									</tbody>
								</table>
								<h4>Compétances</h4>
								<table class="table table-borderless">
									<tbody>
										<?php UserQualificationGet($user->idUser); ?>
									</tbody>
								</table>
								<h4>Adress</h4>
								<div class="well">
									<address>
									<strong><?php echo $user->FamilyName; ?> <?php echo $user->FirstName; ?></strong><br>
									<?php echo $user->Adress; ?><br>
									</address>
									<address>
									<abbr title="Phone">P:</abbr><?php echo $user->Phone; ?><br>
									<a href="mailto:<?php echo $user->Email; ?>"><?php echo $user->Email; ?></a>
									</address>
								</div>
							</div>
							<div class="span3">
								<h4>Diplômes</h4>
								<ul class="icons push">
									<?php UserDiplomaGet($user->idUser, '0');?>
								</ul>
								<h4>Expérience</h4>
								<ul class="icons push">
									<?php UserExpiranceGet($user->idUser, '0');?>
								</ul>
							</div>
							<div class="space5"></div>
						</div>
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
<div id="footer"><?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
<!-- END FOOTER --> 
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="../ili-style/js/jquery-1.8.3.min.js"></script>
   <script src="../ili-style/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../ili-style/js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../ili-style/assets/uniform/jquery.uniform.min.js"></script>

   <script src="../ili-style/assets/bootstrap-tree/bootstrap-tree/js/bootstrap-tree.js"></script>

   <script src="../ili-style/js/scripts.js"></script>
   <script src="../ili-style/js/ui-tree.js"></script>

   <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
         UITree.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>