<?php
function user_side_bar(){
	global $URL;
	// ADMIN
	if($_SESSION['user_idRank']>=3){
		echo'
		<li><a class="" href="'.$URL.'ili-modules/client/liste"><span class="icon-box"><i class="icon-user"></i></span> Clients</a></li>
		<!--<li><a class="" href="'.$URL.'ili-modules/contrat/liste"><span class="icon-box"><i class="icon-file"></i></span> Contrat</a></li>-->
		';
	}	
	if($_SESSION['user_idRank']==2){
		$up_clt=UserPrivileges("CLIENTS", $_SESSION['user_id']);$s_clt=$up_clt->s;
		if($s_clt){echo'<li><a class="" href="'.$URL.'ili-modules/client/liste"><span class="icon-box"><i class="icon-user"></i></span> Clients</a></li>';}
		//$up_cnt=UserPrivileges("CONTRAT", $_SESSION['user_id']);$s_cnt=$up_cnt->s;
		//if($s_cnt){echo'<li><a class="" href="'.$URL.'ili-modules/contrat/liste"><span class="icon-box"><i class="icon-file"></i></span> Contrat</a></li>';}
	}
}
?>

<!-- BEGIN SIDEBAR -->
<div id="sidebar" class="nav-collapse collapse"> 
	<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
	<div class="sidebar-toggler hidden-phone"></div>
	<!-- BEGIN SIDEBAR TOGGLER BUTTON --> 
	
	<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
	<div class="navbar-inverse">
		<form class="navbar-search visible-phone">
			<input type="text" class="search-query" placeholder="Search" />
		</form>	</div>
	<!-- END RESPONSIVE QUICK SEARCH FORM --> 
	<!-- BEGIN SIDEBAR MENU -->
	<ul class="sidebar-menu">
		<li class="has-sub active"> <a href="<?php echo $URL;?>" class=""> <span class="icon-box"> <i class="icon-dashboard"></i></span> Dashboard </a> </li>
		<?php user_side_bar();?>
		<li class="has-sub">
					<a href="javascript:;" class="">
					    <span class="icon-box"> <i class="icon-file"></i></span> Contrat
					    <span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?php echo $URL;?>ili-modules/contrat/liste">Liste</a></li>
						<li><a class="" href="<?php echo $URL;?>ili-modules/contrat/add/index">Ajouter</a></li>
                        <li><a class="" href="<?php echo $URL;?>ili-modules/contrat/renew/search">Renouveler</a></li>
					</ul>
				</li>
        <li><a class="" href="<?php echo $URL;?>construction"><span class="icon-box"><i class="icon-money"></i></span> Caisse</a></li>
        <li><a class="" href="<?php echo $URL;?>construction"><span class="icon-box"><i class="icon-book"></i></span> Aide</a></li>
		<li><a class="" href="<?php echo $URL;?>ili-functions/logout"><span class="icon-box"><i class="icon-signout"></i></span> Déconexion</a></li>
	</ul>
	<!-- END SIDEBAR MENU --> 
</div>
<!-- END SIDEBAR --> 

