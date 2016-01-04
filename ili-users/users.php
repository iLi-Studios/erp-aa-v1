<?php 
include"../ili-functions/functions.php"; 
autorisation('2');
function user_icon($rank){
	if($rank==1){echo'icon-ban-circle';}
	if($rank==2){echo'icon-user';}
	if($rank==3){echo'icon-briefcase';}
}
function get_users_last_diploma($id){
	$query="SELECT * FROM users_diploma WHERE id_user='$id' ORDER BY id DESC LIMIT 1;";
	if(query_execute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS DE DIPLOME!</strong>";}
	else{
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->diplome.'</strong><br/>
						<em>'.$o->lieux.', '.$o->annee.'</em><br/>
						<em><strong>'.$o->etablissement.'</strong></em><br>
					</li><br>';
		}
	}
}	
function get_users_last_expirance($id){
	$query="SELECT * FROM users_expirance WHERE id_user='$id' ORDER BY id DESC LIMIT 1;";
	if(query_execute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS D'EXPERIENCE!</strong>";}
	else{
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->company.'</strong><br/>
						<em>Durée : '.$o->duration.'</em><br/>
						<em>&nbsp;&nbsp;&nbsp;'.$o->experience.'</em><br>
						<a href="'.$o->company_url.'" target="new">'.$o->company_url.'</a>
					</li><br>';
		}
	}
}
function get_users_skills($id){
	$query="SELECT * FROM users_skills WHERE id_user='$id' ORDER BY id DESC;";
	if(query_execute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS DE COMPETANCE!</strong>";}
	else{
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			if($o->pourcentage >= '0' && $o->pourcentage <= '33'){$color='danger';}
			if($o->pourcentage >'33' && $o->pourcentage <= '66'){$color='warning';}
			if($o->pourcentage >'66' && $o->pourcentage <= '100'){$color='success';}
			echo'
				<tr>
					<td class="span1"><span class="label label-inverse">'.$o->skills.'</span></td>
					<td>
						<div class="progress progress-'.$color.' progress-striped">
							<div style="width: '.$o->pourcentage.'%" class="bar"></div>
						</div>
					</td>
				</tr>';
		}
	}
}
function users_pannel($id, $rank){
	//ADMIN
	if($_SESSION['user_id_rank']>=3){
		//C IN ALL
		echo'<a href="user_add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';	
		//U IN ALL
		echo'<a href="user_edit?id='.$id.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';
		//D IN ALL BUT HIM
		if($_SESSION['user_id']!=$id){echo'<a href="#myModal_del'.$id.'" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
		//B IN ALL BUT HIM 
		if($_SESSION['user_id']!=$id){
			if($rank==1){echo'<a href="user_deban?id='.$id.'" class="icon-repeat tooltips" data-original-title="Débannir"></a>';}
			if($rank==2){echo'<a href="user_ban?id='.$id.'" class="icon-ban-circle tooltips" data-original-title="Bannir"></a>';}
		}
		//S IN ALL
		echo'<a href="user_profil?id='.$id.'" class="icon-eye-open tooltips" data-original-title="Voir plus"></a>';
	}
	//USER
	if($_SESSION['user_id_rank']==2){
		$up=user_privileges("USERS", $_SESSION['user_id']);$s=$up->s;$c=$up->c;$u=$up->u;$d=$up->d;
		//C IN ALL
		if($c){echo'<a href="user_add" class="icon-plus tooltips" data-original-title="Ajouter"></a>';}
		//U IN ALL BUT ADMIN
		if( (($u) && ($_SESSION['user_id_rank']>=$rank)) || ($_SESSION['user_id']==$id) ){echo'<a href="user_edit?id='.$id.'" class="icon-edit tooltips" data-original-title="Modifier"></a>';}
		//D IN ALL BUT HIM && ADMIN
		if( ($d) && ($_SESSION['user_id']!=$id) && ($_SESSION['user_id_rank']>=$rank) ){echo'<a href="#myModal_del'.$id.'" class="icon-trash tooltips" data-toggle="modal" data-original-title="Supprimer"></a>';}
		//B IF HE CAN UPDATE HE CAN BAN ALL BUT HIM && ADMIN
		if( ($u) && ($_SESSION['user_id']!=$id) && ($_SESSION['user_id_rank']>=$rank) ){
			if($rank==1){echo'<a href="user_deban?id='.$id.'" class="icon-repeat tooltips" data-original-title="Débannir"></a>';}
			if($rank==2){echo'<a href="user_ban?id='.$id.'" class="icon-ban-circle tooltips" data-original-title="Bannir"></a>';}
		}
		//S IN ALL BUT ADMIN
		if( (($s) && ($_SESSION['user_id_rank']>=$rank)) || ($_SESSION['user_id']==$id)){echo'<a href="user_profil?id='.$id.'" class="icon-eye-open tooltips" data-original-title="Voir plus"></a>';}	
	}
}
function get_users_list(){
	$query="SELECT * FROM users, users_rank WHERE users.id_rank=users_rank.id_rank";
	$result=query_excute_while($query);
	while ($o=mysqli_fetch_object($result)){
		echo'
				<div class="widget">
					<div class="widget-title">
						<h4><i class="';?><?php user_icon($o->id_rank);?><?php echo'"></i> '.$o->nom.' '.$o->prenom.'</h4>
						<span class="tools" style="margin-top:-2px;">';
							users_pannel($o->id_user, $o->id_rank);
							echo'
							<!-- Modale de confirmation de suppression -->
							<div id="myModal_del'.$o->id_user.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_del'.$o->id_user.'" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel_del'.$o->id_user.'">Confirmation de suppression</h3>
								</div>
								<div class="modal-body">
									<p>Vous êtes sur de vouloire supprimer le compte du <strong>'.$o->nom.' '.$o->prenom.'</strong>? <br> Cette action est <strong>irréversible!</strong></p>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<button onClick=\'document.location.href="user_remove?id='.$o->id_user.'";\' data-dismiss="modal" class="btn btn-primary">Confirm</button>
								</div>
							</div>
							<!-- Modale de confirmation de suppression -->
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
					</div>
					<div class="widget-body">
						<div class="span3">
							<div class="text-center profil-pic">'; 
								if($o->img_link!=''){echo'<img src="'.$o->img_link.'" width="100%" height="226px;">';}
								echo'
							</div>
							<ul class="nav nav-tabs nav-stacked">';
									if($o->fb){echo'<li><a href="'.$o->fb.'" target="new"><i class="icon-facebook"></i> Facebook</a></li>';}
									if($o->linkedin){echo'<li><a href="'.$o->linkedin.'" target="new"><i class="icon-linkedin"></i> LinkedIn</a></li>';}
									if($o->github){echo'<li><a href="'.$o->github.'" target="new"><i class="icon-github"></i> Github</a></li>';}						
					echo'	
							</ul>
						</div>
						<div class="span6">
							<h4>'.$o->poste.'<br/></h4>
							<table class="table table-borderless">
								<tbody>
									<tr>
										<td class="span2">Grade :</td>
										<td>'.$o->rank.'</td>
									</tr>
									<tr>
										<td class="span2">Age :</td>
										<td>'.age($o->date_naissance).' ans</td>
									</tr>
									<tr>
										<td class="span2"> Email :</td>
										<td>'.$o->email.'</td>
									</tr>
									<tr>
										<td class="span2"> Mobile :</td>
										<td> '.$o->tel.' </td>
									</tr>
								</tbody>
							</table>
							<h4>Compétances</h4>
							<table class="table table-borderless">
								<tbody>';get_users_skills($o->id_user); echo'</tbody>
							</table>
						</div>
						<div class="span3">
							<h4>Dérnier diplômes</h4>
							<ul class="icons push">';get_users_last_diploma($o->id_user); echo'</ul>
							<h4>Dériniére expérience</h4>
							<ul class="icons push">';get_users_last_expirance($o->id_user);echo'</ul>
						</div>
						<div class="space5"></div>
					</div>
				</div>
			';}
}
?>
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
<link href="../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link href="../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../ili-style/css/style.css" rel="stylesheet" />
<link href="../ili-style/css/style_responsive.css" rel="stylesheet" />
<link href="../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
<link href="../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../ili-style/assets/uniform/css/uniform.default.css" />
<link href="../ili-style/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
<link href="../ili-style/assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
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
					<h3 class="page-title"> Utilisateurs <small> Infos globales</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $site ;?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li> <a href="<?php echo $site ;?>ili-users/users">Utilisateurs du système</a><span class="divider-last">&nbsp;</span></li>
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
					<?php get_message('message'); ?>
					<?php get_users_list(); ?>
				</div>
				<!-- END PAGE CONTENT--> 
			</div>
			<!-- END PAGE CONTAINER--> 
		</div>
		<!-- END PAGE --> 
	</div>
	<!-- END CONTAINER --> 
</div>
<!-- BEGIN FOOTER -->
<div id="footer"><?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
<!-- END FOOTER --> 
<!-- BEGIN JAVASCRIPTS --> 
<!-- Load javascripts at bottom, this will reduce page load time --> 
<script src="../ili-style/js/jquery-1.8.3.min.js"></script> 
<script src="../ili-style/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="../ili-style/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script> 
<script src="../ili-style/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script> 
<script src="../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="../ili-style/js/jquery.blockui.js"></script> 
<script src="../ili-style/js/jquery.cookie.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
        <script src="../ili-style/js/excanvas.js"></script>
        <script src="../ili-style/js/respond.js"></script>
        <![endif]--> 
<script src="../ili-style/assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="../ili-style/assets/jquery-knob/js/jquery.knob.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.resize.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.pie.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.stack.js"></script> 
<script src="../ili-style/assets/flot/jquery.flot.crosshair.js"></script> 
<script src="../ili-style/js/jquery.peity.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="../ili-style/assets/data-tables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="../ili-style/assets/data-tables/DT_bootstrap.js"></script> 
<script src="../ili-style/js/scripts.js"></script> 
<script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
        </script> 
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>