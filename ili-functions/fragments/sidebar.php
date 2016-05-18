<?php
function user_side_bar(){
	global $URL;
	// ADMIN
	if($_SESSION['user_idRank']>=3){
		echo'
		<li><a class="" href="'.$URL.'ili-modules/client/liste"><span class="icon-box"><i class="icon-user"></i></span>Client</a></li>
		<li class="has-sub">
			<a href="javascript:;" class="">
				<span class="icon-box"> <i class="icon-file"></i></span> Contrat
				<span class="arrow"></span>
			</a>
			<ul class="sub">
				<li><a class="" href="'.$URL.'ili-modules/contrat/liste">Liste</a></li>
				<li><a class="" href="'.$URL.'ili-modules/contrat/add/index">Ajouter</a></li>
				<li><a class="" href="'.$URL.'ili-modules/contrat/renew/search">Renouveler</a></li>
			</ul>
		</li>
		<li class="has-sub">
			<a href="javascript:;" class="">
				<span class="icon-box"> <i class="icon-money"></i></span> Caisse
				<span class="arrow"></span>
			</a>
			<ul class="sub">
				<li><a class="" href="'.$URL.'ili-modules/caisse/journal">Journal</a></li>
				<li><a class="" href="'.$URL.'ili-modules/caisse/echeancier">Echéancier</a></li>
				<li><a class="" href="'.$URL.'ili-modules/caisse/decaissement">Décaissement</a></li>
				<li><a class="" href="'.$URL.'ili-modules/caisse/recherche_paiement">Recherche Paiement</a></li>
				<li><a class="" href="'.$URL.'ili-modules/caisse/recherche_cheque">Recherche Chéque</a></li>
			</ul>
		</li>
		';
	}	
	if($_SESSION['user_idRank']==2){
		//CLIENT
		$up_clinet=UserPrivileges("CLIENTS", $_SESSION['user_id']);
		if($up_clinet->s){echo'<li><a class="" href="'.$URL.'ili-modules/client/liste"><span class="icon-box"><i class="icon-user"></i></span>Client</a></li>';}
		//CONTRAT
		$up_contrat=UserPrivileges("CONTRAT", $_SESSION['user_id']);
		if($up_contrat->s){
			echo'
			<li class="has-sub">
				<a href="javascript:;" class="">
					<span class="icon-box"> <i class="icon-file"></i></span> Contrat
					<span class="arrow"></span>
				</a>
				<ul class="sub">
					<li><a class="" href="'.$URL.'ili-modules/contrat/liste">Liste</a></li>';?>
					<?php if($up_contrat->c){echo'<li><a class="" href="'.$URL.'ili-modules/contrat/add/index">Ajouter</a></li>';}?>
					<?php if($up_contrat->u){echo'<li><a class="" href="'.$URL.'ili-modules/contrat/renew/search">Renouveler</a></li>';}?>
					<?php echo'
				</ul>
			</li>
		';}
		//CAISSE
		$up_caisse=UserPrivileges("CAISSE", $_SESSION['user_id']);
		if($up_caisse->s){
			echo'
			<li class="has-sub">
				<a href="javascript:;" class="">
					<span class="icon-box"> <i class="icon-money"></i></span> Caisse
					<span class="arrow"></span>
				</a>
				<ul class="sub">
					<li><a class="" href="'.$URL.'ili-modules/caisse/journal">Journal</a></li>';?>
					<?php if($up_caisse->u){echo'<li><a class="" href="'.$URL.'ili-modules/caisse/echeancier">Echéancier</a></li>';}?>
					<?php if($up_caisse->c){echo'<li><a class="" href="'.$URL.'ili-modules/caisse/decaissement">Décaissement</a></li>';}?>
					<?php echo'
					<li><a class="" href="'.$URL.'ili-modules/caisse/recherche_paiement">Recherche Paiement</a></li>
					<li><a class="" href="'.$URL.'ili-modules/caisse/recherche_cheque">Recherche Chéque</a></li>
				</ul>
			</li>
			';
		}
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
        <li><a class="" href="<?php echo $URL;?>aide"><span class="icon-box"><i class="icon-book"></i></span> Aide</a></li>
		<li><a class="" href="<?php echo $URL;?>ili-functions/logout"><span class="icon-box"><i class="icon-signout"></i></span> Déconexion</a></li>
	</ul>
	<!-- END SIDEBAR MENU --> 
</div>
<!-- END SIDEBAR --> 

