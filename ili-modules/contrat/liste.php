<?php 
include"../../ili-functions/functions.php";
Authorization('2');
AuthorizedPrivileges('CONTRAT', 'S');
function ListContract(){
	global $URL;
	$sql="
	SELECT `insurancecontract`.`idContract`, `FirstName`, `FamilyName`, `TypeContract`, `KindContract`, MAX(`StartDate`), MAX(`EndDate`), `Amount`, `idCycle`,`client`.`idClient`
	FROM `insurancecontract`,`contractcycle`,`payment`,`client`
	WHERE 
	`client`.`idClient`=`insurancecontract`.`idClient`
	AND
	`contractcycle`.`idContract`=`insurancecontract`.`idContract`
	AND 
	`payment`.`idPayment`=`contractcycle`.`idPayment`
	GROUP BY `insurancecontract`.`idContract`
	";
	$result=QueryExcuteWhile($sql);
	while ($o=mysqli_fetch_array($result)){
		$idContract=$o[0];
		echo'
		  <tr class="odd gradeX" id="tr" onclick="document.location=\''.$URL.'ili-modules/contrat/contrat?id='.$o[0].'\'">
			<td>'.$o[0].'</td>
			<td>'.$o[2].' '.$o[1].'</td>
			<td>'.$o[4].'</td>
			<td>'.$o[3].'</td>
			<td>'.$o[5].'</td>
			<td>'.$o[6].'</td>
			<td>'?><?php ExpireIn($o[6]); ?><?php echo'</td>
		  </tr>
		';
	}
}
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
	<?php echo $META_description;?>
<?php echo $META_author;?>
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
<style>
	#tr{cursor:pointer;}
	#tr:hover{
		text-decoration:underline;
		font-weight: bold;
		color: #3399ff;}
</style>
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
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="liste">Liste</a><span class="divider-last">&nbsp;</span></li>
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
                        </div>
                        <div class="widget-body">
                            <table class="table table-striped table-bordered" id="sample_1">
								<thead>
									<tr>
										<th><i class="icon-briefcase"></i> #Conrtat</th>
                                        <th><i class="icon-user"></i> Client</th>	
										<th><i class="icon-retweet"></i> NATURE</th>
										<th><i class="icon-wrench"></i> TYPE</th>
										<th><i class="icon-signin"></i> DATE DEBUT</th>
                                        <th><i class="icon-signout"></i> DATE FIN</th>
										<th><i class="icon-exclamation-sign"></i> Etat </th>
									</tr>
								</thead>
								<tbody><?php ListContract(); ?></tbody>
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