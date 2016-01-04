<?php 
include"../../ili-functions/functions.php";
autorisation('2');
autorisation_double_check_privilege('CONTRAT', 'S');
function get_cnt_list(){
	global $site;
	$q="
	SELECT * FROM 
		contrat, client 
	WHERE
		contrat.id_clt=client.id_clt
	";
	$r=query_excute_while($q);
	while ($o=mysqli_fetch_object($r)){
		//test le contrat a été renouvelé
		$q_test_ren="SELECT * FROM `contrat_ren` WHERE `id_cnt_ren`='$o->id_cnt';";
		$o_test_ren=query_execute("mysqli_num_rows", $q_test_ren);
		
		//collect du somme depensé sur le contrat X dans le cas ou il a été renouvelé
		$q_somme="
			SELECT (SUM(montant_ren)+(montant)) as total
				FROM contrat, contrat_ren
				WHERE
				contrat.id_cnt='$o->id_cnt'
				AND
				contrat.id_cnt=contrat_ren.id_cnt_ren		
		";
		$o_somme=query_execute("mysqli_fetch_object", $q_somme);
		
		// Titrer la nouvelle date d'expiration d'un contart X dans le cas ou il a été renouvelé
		$q_nouvelle_date_expiration="SELECT * FROM `contrat_ren` WHERE `id_cnt_ren`='$o->id_cnt' ORDER BY id_ren DESC LIMIT 1";
		$o_nouvelle_date_expiration=query_execute("mysqli_fetch_object", $q_nouvelle_date_expiration);
		
		echo'
		<tr>
			<th><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
			<th>'.$o->id_cnt.'</th>
			<th><a href="'.$site.'ili-modules/client/client?id='.$o->id_clt.'">'.$o->nom_clt.' '.$o->prenom_clt.'</a></th>
			<th>';?><?php if($o_test_ren){echo sprintf("%.3f",$o_somme->total);}else{echo $o->montant;}?> TND<?php echo'</th>
			<th>';?><?php
			if($o_test_ren){echo'<span class="label label-success">Renouvelé '.$o_test_ren.'x</span>';}else{echo'<span class="label label-info">Nouveau</span>';}
			?><?php echo'
            </th>
			<th>';?><?php if($o_test_ren){expire_dans($o_nouvelle_date_expiration->date_expiration_ren);}else{expire_dans($o->date_expiration);}?><?php echo'</th>
			<th>';?><?php if($o_test_ren){echo $o_nouvelle_date_expiration->date_expiration_ren;}else{echo $o->date_expiration;}?><?php echo'</th>
			
			
		</tr>
		';
	}
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
	<meta content="iLi-ERP" name="description" />
	<meta content="SAKLY AYOUB" name="author" />
	<link href="../../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="../../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../ili-style/css/style.css" rel="stylesheet" />
	<link href="../../ili-style/css/style_responsive.css" rel="stylesheet" />
	<link href="../../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="../../ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
	<link href="../../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="../../ili-style/assets/uniform/css/uniform.default.css" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php include"../../ili-functions/fragments/page_header.php";?>
<!-- END HEADER --> 
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid"> 
	<!-- BEGIN SIDEBAR -->
	<?php include"../../ili-functions/fragments/sidebar.php";?>
	<!-- END SIDEBAR --> 
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title"> Contrat <small> Liste</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $site; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="liste">Contats</a><span class="divider-last">&nbsp;</span></li>
					</ul>
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
                    <!-- BEGIN EXAMPLE TABLE widget-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>Liste des contrats</h4>
                            <span class="tools"></span>
                        </div>
                        <div class="widget-body">
                            <table class="table table-striped table-bordered" id="sample_1">
								<thead>
									<tr>
										<th width="1%"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
										<th width="12%"><i class="icon-briefcase"></i> Conrtat</th>
                                        <th width="31%"><i class="icon-briefcase"></i> Client</th>	
										<th width="11%"><i class="icon-shopping-cart"></i> Mont.Total</th>
										<th width="13%"><i class="icon-sitemap"></i> Historique</th>
										<th width="20%"><i class="icon-signout"></i> Etat</th>
                                        <th width="12%"><i class="icon-signout"></i> Expiration</th>
									</tr>
								</thead>
								<tbody><?php get_cnt_list(); ?></tbody>
                        	</table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE widget-->
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
<div id="footer"> <?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
<!-- END FOOTER --> 
<!-- BEGIN JAVASCRIPTS --> 
<!-- Load javascripts at bottom, this will reduce page load time --> 
<script src="../../ili-style/js/jquery-1.8.3.min.js"></script>  
<script src="../../ili-style/js/scripts.js"></script> 
<script src="../../ili-style/assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="../../ili-style/js/jquery.blockui.js"></script> 
<!-- ie8 fixes --> 
<!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]--> 
<script type="text/javascript" src="../../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/uniform/jquery.uniform.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/jquery-tags-input/jquery.tagsinput.min.js"></script>  
<script type="text/javascript" src="../../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/data-tables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="../../ili-style/assets/data-tables/DT_bootstrap.js"></script>
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