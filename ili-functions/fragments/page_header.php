<!-- BEGIN HEADER -->
<div id="header" class="navbar navbar-inverse navbar-fixed-top hidden-print"> 
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="navbar-inner">
		<div class="container-fluid"> 
			<!-- BEGIN LOGO --> 
			<a class="brand" href="<?php echo $URL;?>"> <img src="" alt="<?php echo $sytem_title;?>" /> </a> 
			<!-- END LOGO --> 
			<!-- BEGIN RESPONSIVE MENU TOGGLER --> 
			<a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="arrow"></span> </a> 
			<!-- END RESPONSIVE MENU TOGGLER -->
			<div id="top_menu" class="nav notify-row"> 
				<!-- BEGIN NOTIFICATION -->
				<ul class="nav top-menu">
					<!-- BEGIN SETTINGS -->
					<!--<li class="dropdown"> <a class="dropdown-toggle element" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Settings"> <i class="icon-cog"></i> </a> </li>-->
					<!-- END SETTINGS -->
					<?php include"message.php";?>
					<?php include"notification.php";?>
					
				</ul>
			</div>
			<!-- END  NOTIFICATION -->
			<div class="top-nav ">
				<ul class="nav pull-right top-menu" >
					
					<!-- BEGIN SUPPORT -->
					<?php if($_SESSION['user_idRank']>=3){echo'<li class="dropdown mtop5"> <a class="dropdown-toggle element" data-placement="bottom" data-toggle="tooltip" href="'.$URL.'log/index" data-original-title="Journal Systéme"> <i class="icon-tasks"></i> </a> </li>';}?>
					<li class="dropdown mtop5"> <a class="dropdown-toggle element" data-placement="bottom" data-toggle="tooltip" href="<?php echo $URL;?>ili-modules/ets/info" data-original-title="Configuration de la société"> <i class="icon-cog"></i> </a> </li>
                    <li class="dropdown mtop5"> <a class="dropdown-toggle element" data-placement="bottom" data-toggle="tooltip" href="<?php echo $URL;?>ili-users/users" data-original-title="Utilisateurs"> <i class="icon-group"></i> </a> </li>
					<!-- END SUPPORT --> 
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php if( $_SESSION['user_img']!=''){echo'<img src="'.$_SESSION['user_img'].'" width="29px" height="29px">';}?> <span class="username"><?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom'] ; ?></span> <b class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $URL; ?>ili-users/user_profil?id=<?php echo $_SESSION['user_id'];?>"><i class="icon-user"></i> Mon Profil</a></li>
							<!--<li><a href="#"><i class="icon-tasks"></i> Mes Taches</a></li>
							<li><a href="#"><i class="icon-calendar"></i> Calendrier</a></li>-->
							<li class="divider"></li>
							<li><a href="<?php echo $URL; ?>ili-functions/logout"><i class="icon-key"></i> Déconexion</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU --> 
			</div>
		</div>
	</div>
	<!-- END TOP NAVIGATION BAR --> 
</div>
<!-- END HEADER -->