<?php 
include"../../../ili-functions/functions.php";
$id_clt = $_GET['clt'];
$clt=ClientGetInfo($id_clt);
if($clt=='0'){RedirectJS('index?message=18');}
Authorization('2');
if((isset($_POST['idClient'])) && (isset($_POST['idContract'])) && (isset($_POST['TypeContract'])) && (isset($_POST['NatureContract'])) && (isset($_POST['StartDate'])) && (isset($_POST['EndDate'])) && (isset($_POST['Amount'])) && (isset($_POST['EncashmentDate'])) && (isset($_POST['PaymentKind']))){
	$idClient					=addslashes($_POST['idClient']);
	$idContract					=addslashes($_POST['idContract']);
	$TypeContract				=addslashes($_POST['TypeContract']);
	$NatureContract				=addslashes($_POST['NatureContract']);
	$StartDate					=addslashes($_POST['StartDate']);
	$EndDate					=addslashes($_POST['EndDate']);
	$Amount						=addslashes($_POST['Amount']);
	$EncashmentDate				=addslashes($_POST['EncashmentDate']);
	$PaymentKind				=addslashes($_POST['PaymentKind']);
	if(isset($_POST['PaymentCode']))	{$PaymentCode=addslashes($_POST['PaymentCode']);}else{$PaymentCode='';}
	if(isset($_POST['Bank']))			{$Bank=addslashes($_POST['Bank']);}else{$Bank='';}
	if(isset($_POST['TransferDate']))	{$TransferDate=addslashes($_POST['TransferDate']);}else{$TransferDate='';}
	$idUser=$_SESSION['user_id'];

	$ajout=QueryExcute("", "INSERT INTO `insurancecontract` VALUES ('$idContract', '$idClient', '$TypeContract', '$NatureContract');");
	if(!$ajout){
		$ajout2=QueryExcute("", "INSERT INTO `payment` VALUES (NULL, '$EncashmentDate', '', '$PaymentKind', '$PaymentCode', '$Bank', '$TransferDate', '$Amount', '$idUser');");
		if(!$ajout2){
			$ObjectPayement=QueryExcute("mysqli_fetch_array", "SELECT max(`idPayment`) FROM `payment`");
			if($ObjectPayement){
				$idPayment=$ObjectPayement[0];
				$ajout3=QueryExcute("", "INSERT INTO `contractcycle` VALUES(NULL, '$idPayment', '$idContract', '$StartDate', '$EndDate', '$idUser');");
					if(!$ajout3){
						NotifAllWrite("", "", "Ajout contract ID : ".$idContract);
						LogWrite("Ajout contract ID : ".$idContract);
						RedirectJS("ili-modules/contrat/liste");
					}else{RedirectJS('ili-modules/contrat/add/add?clt='.$id_clt.'&message=26');}
			}else{RedirectJS('ili-modules/contrat/add/add?clt='.$id_clt.'&message=27');}
		}else{RedirectJS('ili-modules/contrat/add/add?clt='.$id_clt.'&message=28');}
	}else{RedirectJS('ili-modules/contrat/add/add?clt='.$id_clt.'&message=29');}
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
	<meta content="iLi-ERP" name="description" />
	<meta content="SAKLY AYOUB" name="author" />
	<link href="../../../ili-style/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../../../ili-style/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="../../../ili-style/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../../../ili-style/css/style.css" rel="stylesheet" />
	<link href="../../../ili-style/css/style_responsive.css" rel="stylesheet" />
	<link href="../../../ili-style/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="../../../ili-style/assets/chosen-bootstrap/chosen/chosen.css" />
	<link href="../../../ili-style/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="../../../ili-style/assets/uniform/css/uniform.default.css" />
</head>
<script type="text/javascript">
function showRadio(){
	 if(document.getElementById('C').checked == true){
		 document.getElementById('CHEQUE').style.display = 'block';
	 }
	 else{
		  document.getElementById('CHEQUE').style.display = 'none';
	 }
}
</script>
<style type="text/css">#CHEQUE {display: none;}</style>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php include"../../../ili-functions/fragments/page_header.php";?>
<!-- END HEADER --> 
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid"> 
	<!-- BEGIN SIDEBAR -->
	<?php include"../../../ili-functions/fragments/sidebar.php";?>
	<!-- END SIDEBAR --> 
	<!-- BEGIN PAGE -->
	<div id="main-content"> 
		<!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid"> 
			<!-- BEGIN PAGE HEADER-->
			
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title"> Contrat <small> Creation</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL; ?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li><a href="../add">Creation</a><span class="divider-last">&nbsp;</span></li>
					</ul>
				</div>
			</div>
			<!-- END PAGE HEADER--> 
			<!-- BEGIN PAGE CONTENT-->
			<?php ErrorGet('message'); ?>
            <div class="row-fluid">
               <div class="span12">
                  <div class="widget box blue" id="form_wizard_1">
                     <div class="widget-title">
                        <h4>
                           <i class="icon-reorder"></i> Création du contrat - <span class="step-title">Etape 1/4</span>
                        </h4>
                        <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                     </div>
                     <div class="widget-body form">
                        <form name="form" action="#" method="post" class="form-horizontal">
                           <div class="form-wizard">
                              <div class="navbar steps">
                                 <div class="navbar-inner">
                                    <ul class="row-fluid">
                                       <li class="span3">
                                          <a href="#tab1" data-toggle="tab" class="step active">
                                          <span class="number">1</span>
                                          <span class="desc"><i class="icon-ok"></i> Client</span>
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab2" data-toggle="tab" class="step">
                                          <span class="number">2</span>
                                          <span class="desc"><i class="icon-ok"></i> Contrat</span>
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab3" data-toggle="tab" class="step">
                                          <span class="number">3</span>
                                          <span class="desc"><i class="icon-ok"></i> Dates</span>
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab4" data-toggle="tab" class="step">
                                          <span class="number">4</span>
                                          <span class="desc"><i class="icon-ok"></i> Paiement</span>
                                          </a> 
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div id="bar" class="progress progress-striped">
                                 <div class="bar"></div>
                              </div>
                              <div class="tab-content">
                                 <div class="tab-pane active" id="tab1">
                                    <h3>Détails du client</h3>
                                    <div class="control-group">
                                       <label class="control-label">Code Client</label>
                                       <div class="controls">
                                          <input type="text" name="idClient" class="span6" value="<?php echo $id_clt; ?>" required readonly/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Désignation</label>
                                       <div class="controls">
                                          <input type="text" class="span6" value="<?php echo $clt->FamilyName.' '.$clt->FirstName; ?>" readonly/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Téléphonne</label>
                                       <div class="controls">
                                          <input name="clt_portable" type="text" class="span6" value="<?php echo $clt->Phone; ?>" readonly/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab2">
                                    <h3>Details de contrat 1/2</h3>
                                    <div class="control-group">
                                       <label class="control-label">N° Contrat</label>
                                       <div class="controls">
                                          <input type="text" name="idContract" class="span6" required/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Nature du contrat</label>
                                       <div class="controls">
                                          <select name="NatureContract" class="span6">
                                            <option value="Ferme">Ferme</option>
                                            <option value="Renouvelable">Renouvelable</option>
                                          </select>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Type de Contrat</label>
                                       <div class="controls">
                                          <select name="TypeContract" class="span6">
										  <option value="Automobile">Automobile</option>
                                            <option value="Multirisque habitation">Multirisque habitation</option>
                                            <option value="Assurance voyage">Assurance voyage</option>
                                            <option value="Corps de plaisance">Corps de plaisance</option>
                                            <option value="Individuelle accidents">Individuelle accidents</option>
                                            <option value="Multirisque professionnelle">Multirisque professionnelle</option>
                                            <option value="Multirisque ordinateurs">Multirisque ordinateurs</option>
                                        </select>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab3">
                                    <h3>Details de contrat 2/2<h3>
                                    <div class="control-group">
                                       <label class="control-label">Date début du contrat</label>
                                       <div class="controls">
                                          <input type="text" name="StartDate" class="span6" data-mask="99-99-9999" value="<?php echo $Now;?>" required/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>

                                    <div class="control-group">
                                       <label class="control-label">Date fin du contrat</label>
                                       <div class="controls">
                                          <input type="text" name="EndDate" class="span6" data-mask="99-99-9999" required/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    
                                 </div>
                                 <div class="tab-pane" id="tab4">
                                    <h3>Detail de paiement</h3>
									<div class="control-group">
                                       <label class="control-label">Montnant du contrat</label>
                                       <div class="controls">
                                          <input type="text" name="Amount" class="span6" required/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Date de paiement</label>
                                       <div class="controls">
                                          <input type="text" name="EncashmentDate" class="span6" value="<?php echo $Now;?>" required readonly/>
                                          <span class="help-inline"></span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Mode de paiement</label>
                                       <div class="controls">
                                               <label><input type="radio" id="E" name="PaymentKind" value="ESPECE" onclick="showRadio()" checked/>Espèces</label>
                                               <label><input type="radio" id="C" name="PaymentKind" value="CHEQUE" onclick="showRadio()" />Chéque</label>
                                       </div>
                                    </div>
                                    <div id="CHEQUE">
                                   		<div class="control-group">
                                           <label class="control-label">Banque</label>
                                           <div class="controls">
                                              <input type="text" name="Bank" class="span6"/>
                                              <span class="help-inline"></span>
                                           </div>
                                        </div>
                                        <div class="control-group">
                                           <label class="control-label">N° Chéque</label>
                                           <div class="controls">
                                              <input type="text" name="PaymentCode" class="span6"/>
                                              <span class="help-inline"></span>
                                           </div>
                                        </div>
                                        <div class="control-group">
                                           <label class="control-label">Date de versement</label>
                                           <div class="controls">
                                              <input type="text" name="TransferDate" class="span6" data-mask="99-99-9999"/>
                                              <span class="help-inline"></span>
                                           </div>
                                        </div>
                                        <br>
                                     </div><!-- Chéque -->   
                                 </div>
                              </div>
                              <div class="form-actions clearfix">
                                 <a href="javascript:;" class="btn button-previous"><i class="icon-angle-left"></i> Précédent </a>
                                 <a href="javascript:;" class="btn btn-primary blue button-next"> Suivant <i class="icon-angle-right"></i></a>
								 <input type="submit" class="btn btn-success button-submit" value="Enregistrer"/>
                              </div>
                           </div>
                        </form>
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
<div id="footer"> <?php echo $copy_right;?>
	<div class="span pull-right"> <span class="go-top"><i class="icon-arrow-up"></i></span> </div>
</div>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="../../../ili-style/js/jquery-1.8.3.min.js"></script>
   <script src="../../../ili-style/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../../../ili-style/assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script src="../../../ili-style/js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="../../../ili-style/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../../../ili-style/assets/uniform/jquery.uniform.min.js"></script>
   <script src="../../../ili-style/js/scripts.js"></script>
   <script type="text/javascript" src="../../../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
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