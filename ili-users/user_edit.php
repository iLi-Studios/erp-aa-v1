<?php 
include"../ili-functions/functions.php";
autorisation('2');
$id_user=$_GET['id'];
$user=get_user_info($id_user);
if($user==''){redirect('index?message=14');}
$id_user_session = $_SESSION['user_id'];
$user_id_rank = $_SESSION['user_id_rank'];
if( ($id_user!=$id_user_session)&&($user_id_rank<3)){redirect('index?message=17');}
if( (isset($_POST['skills_name'])) && (isset($_POST['skills'])) ){
	$skills_name 	= addslashes($_POST['skills_name']);
	$skills			= addslashes($_POST['skills']);
	$query_skill_insert = "INSERT INTO users_skills (`id`, `id_user`, `skills`, `pourcentage`) VALUES ('', '$user->id_user', '$skills_name', '$skills');";
	query_execute_insert($query_skill_insert);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', ajout de compétence : '.$skills_name);
	write_log("Ajout du compétence : ".$skills_name.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}
if( (isset($_POST['diploma_annee'])) && (isset($_POST['diploma_lieux'])) && (isset($_POST['diploma_diplome'])) && (isset($_POST['diploma_etablissement'])) ){	
	$diploma_annee	 		= addslashes($_POST['diploma_annee']);
	$diploma_lieux	 		= addslashes($_POST['diploma_lieux']);
	$diploma_diplome 		= addslashes($_POST['diploma_diplome']);
	$diploma_etablissement 	= addslashes($_POST['diploma_etablissement']);
	$query_diploma_insert	= "INSERT INTO `users_diploma` (`id`, `id_user`, `annee`, `lieux`, `diplome`, `etablissement`) VALUES ('', '$user->id_user', '$diploma_annee', '$diploma_lieux', '$diploma_diplome', '$diploma_etablissement');";
	query_execute_insert($query_diploma_insert);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', ajout du diplôme : '.$diploma_diplome);
	write_log("Ajout du diplôme : ".$diploma_diplome.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}
if( (isset($_POST['diploma_id_mod'])) && (isset($_POST['diploma_annee_mod'])) && (isset($_POST['diploma_lieux_mod'])) && (isset($_POST['diploma_diplome_mod'])) && (isset($_POST['diploma_etablissement_mod'])) ){	
	$diploma_annee_mod	 		= addslashes($_POST['diploma_annee_mod']);
	$diploma_lieux_mod	 		= addslashes($_POST['diploma_lieux_mod']);
	$diploma_diplome_mod 		= addslashes($_POST['diploma_diplome_mod']);
	$diploma_etablissement_mod 	= addslashes($_POST['diploma_etablissement_mod']);
	$diploma_id_mod				= addslashes($_POST['diploma_id_mod']);
	$query_diploma_mod	= "UPDATE `users_diploma` 
							SET 
									`annee`			= '$diploma_annee_mod',
									`lieux`			= '$diploma_lieux_mod',
									`diplome` 		= '$diploma_diplome_mod',
									`etablissement`	= '$diploma_etablissement_mod' 
							WHERE `users_diploma`.`id` ='$diploma_id_mod';";
	query_execute("mysqli_fetch_object", $query_diploma_mod);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', modification du diplôme : '.$diploma_diplome);
	write_log("Modification du diplôme : ".$diploma_diplome_mod.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}
if( (isset($_POST['exp_company_add'])) && (isset($_POST['exp_companyurl_add'])) && (isset($_POST['exp_duration_add'])) && (isset($_POST['exp_experance_add'])) ){	
	$exp_company_add	 		= addslashes($_POST['exp_company_add']);
	$exp_companyurl_add	 		= addslashes($_POST['exp_companyurl_add']);
	$exp_duration_add 			= addslashes($_POST['exp_duration_add']);
	$exp_experance_add 			= addslashes($_POST['exp_experance_add']);
	$query_experance_add		= "INSERT INTO `users_expirance` (`id`, `id_user`, `company`, `company_url`, `duration`, `experience`) VALUES (NULL, '$user->id_user', '$exp_company_add', '$exp_companyurl_add', '$exp_duration_add', '$exp_experance_add');";
	query_execute_insert($query_experance_add);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', ajout de l\'expérence dans l\'etablissement : '.$exp_company_add);
	write_log("Ajout de l\'expérience dans l\'etablissement : ".$exp_company_add.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}
if( (isset($_POST['exp_company_mod'])) && (isset($_POST['exp_companyurl_mod'])) && (isset($_POST['exp_duration_mod'])) && (isset($_POST['exp_experance_mod'])) && (isset($_POST['epx_id_mod'])) ){	
	$exp_company_mod	 		= addslashes($_POST['exp_company_mod']);
	$exp_companyurl_mod	 		= addslashes($_POST['exp_companyurl_mod']);
	$exp_duration_mod 			= addslashes($_POST['exp_duration_mod']);
	$exp_experance_mod 			= addslashes($_POST['exp_experance_mod']);
	$epx_id_mod					= addslashes($_POST['epx_id_mod']);
	$query_experance_mod		= " UPDATE users_expirance
									SET 
										id_user='$user->id_user',
										company='$exp_company_mod',
										company_url='$exp_companyurl_mod',
										duration='$exp_duration_mod',
										experience='$exp_experance_mod'
									WHERE id='$epx_id_mod';";
	query_execute_insert($query_experance_mod);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', modification de l\'expérence dans l\'etablissement : '.$exp_company_add);
	write_log("Modification de l\'expérience dans l\'etablissement : ".$exp_company_mod.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}
if( (isset($_POST['mdp_now'])) && (isset($_POST['mdp_new'])) && (isset($_POST['mdp_new2'])) ){
	if($_SESSION['user_id_rank']>=3){$mdp_now =($_POST['mdp_now']);}else{$mdp_now=md5($_POST['mdp_now']);}
	$mdp_new	=md5($_POST['mdp_new']);
	$mdp_new2	=md5($_POST['mdp_new2']);
	if($mdp_now==$user->mdp){
		if($mdp_new2==$mdp_new){
			$query_update_mdp ="UPDATE users SET mdp_update_date=NOW(), mdp='$mdp_new' WHERE id_user='$user->id_user';";
			query_execute("mysqli_fetch_object", $query_update_mdp);
			write_log("Changement du mot de passe de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
			redirect('ili-users/user_edit?message=7&id='.$user->id_user);
		}
		else{redirect('ili-users/user_edit?message=11&id='.$user->id_user);}
	}
	else{redirect('ili-users/user_edit?message=10&id='.$user->id_user);}
}
if( (isset($_POST['nom'])) && (isset($_POST['prenom'])) && (isset($_POST['poste'])) && (isset($_POST['email'])) && (isset($_POST['tel'])) && (isset($_POST['rank'])) && (isset($_POST['date_naissance'])) && (isset($_POST['adresse'])) ){
	$nom			=addslashes($_POST['nom']);
	$prenom			=addslashes($_POST['prenom']);
	$poste			=addslashes($_POST['poste']);
	$email			=addslashes($_POST['email']);
	$tel			=addslashes($_POST['tel']);
	$rank			=addslashes($_POST['rank']);
	$adresse		=addslashes($_POST['adresse']);
	$date_naissance =addslashes($_POST['date_naissance']);
	$query_info_update="UPDATE `users` 
						SET
							`id_rank` 		='$rank',
							`nom`			='$nom',
							`prenom`		='$prenom',
							`email`			='$email',
							`poste`			='$poste',
							`tel`			='$tel',
							`date_naissance`='$date_naissance',
							`adresse`		='$adresse'
						WHERE `id_user`='$user->id_user';";
	query_execute("mysqli_fetch_object", $query_info_update);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', modification des informations');
	write_log("Modification des informations de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);	
}
if( isset($_POST['img_url_mod']) ){
	$img_url_mod				= addslashes($_POST['img_url_mod']);
	$query_img_url_mod			= "UPDATE `users` SET `img_link`='$img_url_mod' WHERE `id_user`='$user->id_user';";
	query_execute("mysqli_fetch_object", $query_img_url_mod);
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', modification de photo de profile');
	write_log("Changement de l\'image de profil de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}
if( (isset($_POST['fb_url'])) && (isset($_POST['linkedin_url'])) && (isset($_POST['github_url'])) ){
	$fb_url				= addslashes($_POST['fb_url']);
	$linkedin_url		= addslashes($_POST['linkedin_url']);
	$github_url			= addslashes($_POST['github_url']);
	$query_socieaux_edit= "UPDATE `users` SET `fb`='$fb_url', `github`='$linkedin_url', `linkedin`='$github_url' WHERE `id_user`='$user->id_user';";
	notif_all($user->id_user, '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">'.$user->nom.' '.$user->prenom.', modification des liens socieaux');
	query_execute("mysqli_fetch_object", $query_socieaux_edit);
	write_log("Modification des liens socieaux de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->id_user."\">".$user->id_user."</a>");
	redirect('ili-users/user_edit?id='.$user->id_user);
}

function get_users_expirance($id){
	$query="SELECT * FROM users_expirance WHERE id_user='$id' ORDER BY id DESC;";
	if(query_execute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS D'EXPERIENCE!</strong>";}
	else{
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->company.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#myModal_expirance_mod'.$o->id.'" data-toggle="modal" class="icon-edit tooltips" data-original-title="&nbsp;&nbsp;Modifier"></a>
						<a href="expirance_remove?id_user='.$_GET['id'].'&id_expirance='.$o->id.'&company='.$o->company.'" class="icon-trash tooltips" data-original-title="&nbsp;&nbsp;Supprimer"></a>
						<br/>
						<em>Durée : '.$o->duration.'</em><br/>
						<em>&nbsp;&nbsp;&nbsp;'.$o->experience.'</em><br>
						<a href="'.$o->company_url.'" target="new">'.$o->company_url.'</a>
						<!-- Start myModal_expirance_mod -->					
						<form action="" method="post">
							<div id="myModal_expirance_mod'.$o->id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_expirance_mod'.$o->id.'_Label" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModal_expirance_mod'.$o->id.'_Label">Expérience Modifier</h3>
								</div>
								<div class="modal-body">
									<center>
										<table width="80%">
											<tr>
												<td width="40%">Etablissement</td>
												<td width="60%"><input name="exp_company_mod" required type="text" value="'.$o->company.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>URL Etablissement</td>
												<td><input name="exp_companyurl_mod" type="text" value="'.$o->company_url.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Durée</td>
												<td><input name="exp_duration_mod" required type="text" value="'.$o->duration.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Expérience</td>
												<td><textarea name="exp_experance_mod" style="resize: vertical; width:100%; max-height:150px;" rows="4">'.$o->experience.'</textarea></td>
											</tr>
										</table>
									</center>
									<h6>NB: URL Etablissement doit être complet <br>EXP: http://www.ili-studios.com/<br> <strong>CONCEIL :</strong> Copiez-le directement depuis le navigateur</h6>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="epx_id_mod" value="'.$o->id.'"/>
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
								</div>
							</div>
						</form><!-- End myModal_expirance_mod -->						
					</li>';
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
					<td class="span1">
						<span class="label label-inverse">
							<a href="skills_remove?id_user='.$_GET['id'].'&id_skills='.$o->id.'&skills_name='.$o->skills.'" class="icon-trash tooltips" data-original-title="Supprimer"></a>
							'.$o->skills.'
						</span>
					</td>
					<td>
						<div class="progress progress-'.$color.' progress-striped">
							<div style="width: '.$o->pourcentage.'%" class="bar"></div>
						</div>
					</td>
				</tr>				
				';				
		}
	}
}
function get_users_diploma($id){
	$query="SELECT * FROM users_diploma WHERE id_user='$id' ORDER BY id DESC;";
	if(query_execute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS DE DIPLOME!</strong>";}
	else{
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->diplome.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#myModal_diploma_mod'.$o->id.'" data-toggle="modal" class="icon-edit tooltips" data-original-title="&nbsp;&nbsp;Modifier"></a>
						<a href="diploma_remove?id_user='.$_GET['id'].'&id_diploma='.$o->id.'&diploma_name='.$o->diplome.'" class="icon-trash tooltips" data-original-title="&nbsp;&nbsp;Supprimer"></a>
						<br/>
						<em>'.$o->lieux.', '.$o->annee.'</em><br/>
						<em><strong>'.$o->etablissement.'</strong></em><br>
						<!-- Start myModal_diploma_mod -->
						<form action="" method="post">
							<div id="myModal_diploma_mod'.$o->id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_diploma_mod'.$o->id.'_Label" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModal_diploma_mod'.$o->id.'_Label">Diplôme Modification</h3>
								</div>
								<div class="modal-body">
									<center>
										<table width="80%">
											<tr>
												<td width="40%">Annee</td>
												<td width="60%"><input name="diploma_annee_mod" required type="text" value="'.$o->annee.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Lieux</td>
												<td><input name="diploma_lieux_mod" required type="text" value="'.$o->lieux.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Diplôme</td>
												<td><input name="diploma_diplome_mod" required type="text" value="'.$o->diplome.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Etablissement</td>
												<td><input name="diploma_etablissement_mod" required type="text" value="'.$o->etablissement.'" class="input-large" /></td>
											</tr>	
										</table>
									</center>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="diploma_id_mod" value="'.$o->id.'"/>
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
								</div>
							</div>
						</form><!-- End myModal_diploma_mod -->
					</li>
					';				
		}
	}
}
function grade_list($rank_user){
	if($_SESSION['user_id_rank']==6){
		$query="SELECT * FROM `users_rank` ORDER BY id_rank ASC";
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			if($rank_user==$o->id_rank){$selected='selected="selected"';}else{$selected='';}
			echo'<option '.$selected.' value="'.$o->id_rank.'">'.$o->rank.'</option>';
		}
	}
	else{
		$query="SELECT * FROM `users_rank` WHERE `id_rank`<'6' ORDER BY id_rank ASC";
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			if($rank_user==$o->id_rank){$selected='selected="selected"';}else{$selected='';}
			echo'<option '.$selected.' value="'.$o->id_rank.'">'.$o->rank.'</option>';
	}
}
}
function user_icon($rank){
	if($rank==1){echo'icon-ban-circle';}
	if($rank==2){echo'icon-user';}
	if($rank==3){echo'icon-briefcase';}
}
function priviléges($id){
	global $site;
	$user=get_user_info($id);
	if( ($_SESSION['user_id_rank']>=3)&&($_SESSION['user_id']!=$id) ){
		echo'
		<ul class="nav nav-tabs nav-stacked" style="margin-left:-15%;">
			<div class="widget-body">
				<div class="space10"></div>
				<ul id="tree_2" class="tree">
					<li>
						<a data-toggle="branch" class="tree-toggle" data-role="branch" href="#">Autorisations</a>
						<ul class="branch in">';
		$query="SELECT `bloc` FROM `users_privileges` WHERE `id_user`='$id'";
		$result=query_excute_while($query);
		while ($o=mysqli_fetch_object($result)){
			if($o->bloc != 'CONTRAT'){
				echo'
								<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
				$query2="SELECT * FROM `users_privileges` WHERE `id_user`='$id' AND `bloc`='$o->bloc';";
				$result2=query_excute_while($query2);
				while ($b=mysqli_fetch_object($result2)){
					echo'
									<ul class="branch">
						';			
										if($b->s){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'s0" value="1">
												<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-eye-open"></p></a> Voir
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'s1" value="1" onChange="this.form.submit()">
												<a><p class="icon-eye-open"></p></a> Voir
											</form>
										</li>
										';}
										if($b->c){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'c0" value="1">
												<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-plus"></p></a> Créer
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'c1" value="1" onChange="this.form.submit()">
												<a><p class="icon-plus"></p></a> Créer
											</form>
										</li>
										';}
										if($b->u){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'u0" value="1">
												<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-edit"></p></a> Modifier
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'u1" value="1" onChange="this.form.submit()">
												<a><p class="icon-edit"></p></a> Modifier
											</form>
										</li>
										';}
										if($b->d){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'d0" value="1">
												<input type="checkbox" name="d0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-trash"></p></a> Supprimer
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'d1" value="1" onChange="this.form.submit()">
												<a><p class="icon-trash"></p></a> Supprimer
											</form>
										</li>
										';}
										if(isset($_POST[$b->id.'s0'])){
											$query="UPDATE users_privileges SET s='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Supprission du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'s1'])){
											$query="UPDATE users_privileges SET s='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'c0'])){
											$query="UPDATE users_privileges SET c='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Supprission du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'c1'])){
											$query="UPDATE users_privileges SET c='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'u0'])){
											$query="UPDATE users_privileges SET u='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Supprission du privilége <strong>MODIFIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>MODIFIER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'u1'])){
											$query="UPDATE users_privileges SET u='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>MODIFIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>MODIFIER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'d0'])){
											$query="UPDATE users_privileges SET d='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Suppression du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'d1'])){
											$query="UPDATE users_privileges SET d='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
		
					echo'		
									</ul>
					';
				}
			}
			if($o->bloc == 'CONTRAT'){
				echo'
								<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
				$query2="SELECT * FROM `users_privileges` WHERE `id_user`='$id' AND `bloc`='$o->bloc';";
				$result2=query_excute_while($query2);
				while ($b=mysqli_fetch_object($result2)){
					echo'
									<ul class="branch">
						';			
										if($b->s){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'s0" value="1">
												<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-eye-open"></p></a> Voir
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'s1" value="1" onChange="this.form.submit()">
												<a><p class="icon-eye-open"></p></a> Voir
											</form>
										</li>
										';}
										if($b->c){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'c0" value="1">
												<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-file"></p></a> Créer
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'c1" value="1" onChange="this.form.submit()">
												<a><p class="icon-file"></p></a> Créer
											</form>
										</li>
										';}
										if($b->u){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'u0" value="1">
												<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-repeat"></p></a> Renouveler
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'u1" value="1" onChange="this.form.submit()">
												<a><p class="icon-repeat"></p></a> Renouveler
											</form>
										</li>
										';}
										if($b->d){echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="hidden" name="'.$b->id.'d0" value="1">
												<input type="checkbox" name="d0" value="0" checked onChange="this.form.submit()">
												<a><p class="icon-trash"></p></a> Supprimer
											</form>
										</li>
										';}
										else{echo'
										<li>
											<form action="" method="post" style="margin-bottom:-2px;">
												<input type="checkbox" name="'.$b->id.'d1" value="1" onChange="this.form.submit()">
												<a><p class="icon-trash"></p></a> Supprimer
											</form>
										</li>
										';}
										if(isset($_POST[$b->id.'s0'])){
											$query="UPDATE users_privileges SET s='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Supprission du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'s1'])){
											$query="UPDATE users_privileges SET s='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'c0'])){
											$query="UPDATE users_privileges SET c='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Supprission du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'c1'])){
											$query="UPDATE users_privileges SET c='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'u0'])){
											$query="UPDATE users_privileges SET u='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Supprission du privilége <strong>RENOUVELER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'u1'])){
											$query="UPDATE users_privileges SET u='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>RENOUVELER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'d0'])){
											$query="UPDATE users_privileges SET d='0' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Suppression du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Suppression de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
										if(isset($_POST[$b->id.'d1'])){
											$query="UPDATE users_privileges SET d='1' WHERE id='$b->id';";
											query_execute_insert($query);
											notif_all('', '', '<a href="'.$site.'ili-users/user_profil?id='.$user->id_user.'">Ajout du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->nom.' '.$user->prenom);
											write_log("Ajout de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$id."\">".$id."</a>");
											echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$id.'"</SCRIPT>';
										}
		
					echo'		
									</ul>
					';
				}
			}
			echo'
							</li>
				';
		}
						echo'	
						</ul>		
					</li>
				</ul>
			</div>
		</ul>
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
   <meta content="" name="description" />
   <meta content="" name="author" />
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
					<h3 class="page-title"> Utilisateurs <small> Modification</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $site;?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li> <a href="users">Utilisateurs du système</a> <span class="divider">&nbsp;</span></li>
						<li> <a href="user_profil?id=<?php echo $user->id_user;?>">Profil </a><span class="divider">&nbsp;</span>
						<li> <a href="user_edit?id=<?php echo $user->id_user;?>">Modification</a><span class="divider-last">&nbsp;</span></li>
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
					<div class="widget">
						<div class="widget-title">
							<h4><i class="<?php user_icon($user->id_rank);?>"></i> Profil</h4>
							<span class="tools">
							<?php echo'<a href="user_profil?id='.$user->id_user.'" class="icon-lock tooltips" data-original-title="verrouiller"></a>';?>
							</span> </div>
						<div class="widget-body">
							<div class="span3">
								<div class="text-center profil-pic">
									<?php if($user->img_link==''){echo'Pas de photo de profil';}else{echo'<img src="'.$user->img_link.'" width="100%" height="226px;">';}?>
									<span><a href="#myModal_img_mod" data-toggle="modal" class="icon-edit tooltips" data-original-title="Modifier votre photo"></a></span> </div>
								<ul class="nav nav-tabs nav-stacked">
									<?php
									if($user->fb){echo'<li><a href="'.$user->fb.'" target="new"><i class="icon-facebook"></i> Facebook</a></li>';}else{echo'<li><i class="icon-facebook"></i> Pas de Facebook </a></li>';}
									if($user->linkedin){echo'<li><a href="'.$user->linkedin.'" target="new"><i class="icon-linkedin"></i> LinkedIn</a></li>';}else{echo'<li><i class="icon-linkedin"></i> Pas de LinkedIn </a></li>';}
									if($user->github){echo'<li><a href="'.$user->github.'" target="new"><i class="icon-github"></i> Github</a></li>';}else{echo'<li><i class="icon-github"></i> Pas de Github </a></li>';}
									?>
									<a href="#myModal_social_edit" data-toggle="modal" class="icon-edit tooltips" data-original-title="Modifier vos lien socieaux"></a>
								</ul>
								<?php priviléges($user->id_user);?>
							</div>
							<div class="span6">
								<h4><?php echo $user->nom; ?> <?php echo $user->prenom; ?> <span><a href="#myModal_info_mod" data-toggle="modal" class="icon-edit tooltips" data-original-title="Modifier les informations personnelles"></a></span><br/>
									<small><?php echo $user->poste; ?></small></h4>
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td class="span2">CIN :</td>
											<td><?php echo $user->id_user ;?></td>
										</tr>
										<tr>
											<td class="span2">Nom :</td>
											<td><?php echo $user->nom; ?></td>
										</tr>
										<tr>
											<td class="span2">Prénom :</td>
											<td><?php echo $user->prenom; ?></td>
										</tr>
										<tr>
											<td class="span2">Age :</td>
											<td><?php echo age($user->date_naissance);?> ans</td>
										</tr>
										<tr>
											<td class="span2">Poste :</td>
											<td><?php echo $user->poste; ?></td>
										</tr>
										<tr>
											<td class="span2"> Email :</td>
											<td><?php echo $user->email; ?></td>
										</tr>
										<tr>
											<td class="span2"> Mobile :</td>
											<td><?php echo $user->tel; ?></td>
										</tr>
										<tr>
											<td class="span2">Grade :</td>
											<td><?php echo $user->rank; ?></td>
										</tr>
										<tr>
											<td class="span2">Ajouté le :</td>
											<td><?php echo $user->created_date; ?> Par <?php echo $user->created_by; ?></td>
										</tr>
										<tr>
											<td class="span2">Mot de passe mise à jour le : </td>
											<td><?php echo $user->mdp_update_date; ?> <span><a href="#myModal_mdp_edit" data-toggle="modal" class="icon-edit tooltips" data-original-title="Changer votre mot de passe"></a></span></td>
										</tr>
									</tbody>
								</table>
								<h4>Compétances <span><a href="#myModal_skills_add" data-toggle="modal" class="icon-plus tooltips" data-original-title="Ajouter"></a></span></h4>
								<table class="table table-borderless">
									<tbody>
										<?php get_users_skills($user->id_user); ?>
									</tbody>
								</table>
								<h4>Adresse</h4>
								<div class="well">
									<address>
									<strong><?php echo $user->nom; ?> <?php echo $user->prenom; ?></strong><br>
									<?php echo $user->adresse; ?><br>
									</address>
									<address>
									<abbr title="Phone">P:</abbr><?php echo $user->tel; ?><br>
									<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
									</address>
								</div>
							</div>
							<div class="span3">
								<h4>Diplômes <span><a href="#myModal_diploma_add" data-toggle="modal" class="icon-plus tooltips" data-original-title="Ajouter"></a></span></h4>
								<ul class="icons push">
									<?php get_users_diploma($user->id_user);?>
								</ul>
								<h4>Expériance <span><a href="#myModal_expirance_add" data-toggle="modal"  class="icon-plus tooltips" data-original-title="Ajouter"></a></span></h4>
								<ul class="icons push">
									<?php get_users_expirance($user->id_user);?>
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
<form action="" method="post">
	<div id="myModal_skills_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_skills_add_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_skills_add_Label">Compétance Ajout</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<tr>
						<td width="40%">Compétance</td>
						<td width="60%"><input name="skills_name" required type="text" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>Niveau</td>
						<td><input name="skills" required type="range" class="input-large" />
							%</td>
					</tr>
				</table>
			</center>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Ajouter"/>
		</div>
	</div>
</form>
<!-- End myModal_skills_add -->
<form action="" method="post">
	<div id="myModal_diploma_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_diploma_add_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_diploma_add_Label">Diplôme Ajout</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<tr>
						<td width="40%">Annee</td>
						<td width="60%"><input name="diploma_annee" required type="text" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>Lieux</td>
						<td><input name="diploma_lieux" required type="text" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>Diplôme</td>
						<td><input name="diploma_diplome" required type="text" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>Etablissement</td>
						<td><input name="diploma_etablissement" required type="text" placeholder="" class="input-large" /></td>
					</tr>
				</table>
			</center>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Ajouter"/>
		</div>
	</div>
</form>
<!-- End myModal_diploma_add -->
<form action="" method="post">
	<div id="myModal_expirance_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_expirance_add_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_expirance_add_Label">Expériance Ajout</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<tr>
						<td width="40%">Etablissement</td>
						<td width="60%"><input name="exp_company_add" required type="text" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>URL Etablissement</td>
						<td><input name="exp_companyurl_add" type="url" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>Durée</td>
						<td><input name="exp_duration_add" required type="text" placeholder="" class="input-large" /></td>
					</tr>
					<tr>
						<td>Expériance</td>
						<td><textarea name="exp_experance_add" style="resize: vertical; width:100%; max-height:150px;" rows="4"></textarea></td>
					</tr>
				</table>
			</center>
			<h6>NB: URL Teablissement doit être complet <br>
				EXP. http://www.ili-studios.com/<br>
				<strong>CONCEIL :</strong> Copiez-le directement depuis le navigateur</h6>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Ajouter"/>
		</div>
	</div>
</form>
<!-- End myModal_expirance_add -->
<form action="" method="post">
	<div id="myModal_mdp_edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_mdp_edit_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_mdp_edit_Label">Changer votre mot de passe</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<?php
					if($_SESSION['user_id_rank']>=3){
						echo'
							<input name="mdp_now" type="hidden" placeholder="" class="input-large" value="'.$user->mdp.'" />
							<tr>
								<td>Nouveau mot de passe</td>
								<td><input name="mdp_new" required type="password" placeholder="" class="input-large" /></td>
							</tr>
							<tr>
								<td>Repeter votre nouveau mot de passe</td>
								<td><input name="mdp_new2" required type="password" placeholder="" class="input-large" /></td>
							</tr>
						';
					}
					else{
						echo'
							<tr>
								<td width="40%">Mot de passe actuelle</td>
								<td width="60%"><input name="mdp_now" required type="password" placeholder="" class="input-large" /></td>
							</tr>
							<tr>
								<td>Nouveau mot de passe</td>
								<td><input name="mdp_new" required type="password" placeholder="" class="input-large" /></td>
							</tr>
							<tr>
								<td>Repeter votre nouveau mot de passe</td>
								<td><input name="mdp_new2" required type="password" placeholder="" class="input-large" /></td>
							</tr>	
						';
					}
					?>
				</table>
			</center>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Changer"/>
		</div>
	</div>
</form>
<!-- End myModal_mdp_edit -->
<form action="" method="post">
	<div id="myModal_info_mod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_info_mod_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_info_mod_Label">Modifier les informations personnelles</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<tr>
						<td width="40%">Nom</td>
						<td width="60%"><input name="nom" required type="text" value="<?php echo $user->nom;?>" class="input-large" /></td>
					</tr>
					<tr>
						<td>Prénom</td>
						<td><input name="prenom" required type="text" value="<?php echo $user->prenom;?>" class="input-large" /></td>
					</tr>
					<?php if($_SESSION['user_id_rank']>=3){echo'
					<tr>
						<td>Poste</td>
						<td><input name="poste" required type="text" value="';?>
					<?php echo $user->poste;?><?php echo'" class="input-large" /></td>
					</tr>
					';}
					else{echo'<input name="poste" type="hidden" value="'.$user->poste.'"/>';}?>
					<tr>
						<td>Email</td>
						<td><input name="email" required type="email" value="<?php echo $user->email;?>" class="input-large" /></td>
					</tr>
					<tr>
						<td>Mobile</td>
						<td><input name="tel" required type="text" value="<?php echo $user->tel;?>" data-mask="99.999.999" class="input-large" /></td>
					</tr>
					<tr>
						<td>Adresse</td>
						<td><input name="adresse" required type="text" value="<?php echo $user->adresse;?>" class="input-large" /></td>
					</tr>
					<tr>
						<td>Date de naissance</td>
						<td><input name="date_naissance" required type="text" value="<?php echo $user->date_naissance;?>" data-mask="99-99-9999" class="input-large" /></td>
					</tr>
					<?php if($_SESSION['user_id_rank']==6){echo'
					<tr>
						<td>Grade</td>
						<td><select name="rank" required tabindex="1">';?>
					<?php grade_list($user->id_rank);?>
					<?php echo'</select></td>
					</tr>
					';}else{echo'<input name="rank" type="hidden" value="'.$user->id_rank.'"/>';}?>
				</table>
			</center>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
		</div>
	</div>
</form>
<!-- End myModal_info_mod -->
<form action="" method="post">
	<div id="myModal_img_mod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_img_mod_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_img_mod_Label">Photo de profil</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<tr>
						<td>URL Image</td>
						<td><input name="img_url_mod" type="url" value="<?php echo $user->img_link;?>" class="input-large" /></td>
					</tr>
				</table>
			</center>
			<br>
			<h6><strong>Exp.</strong> http://www.ili-studios.com/img/test.png<br>
				<strong>INFO :</strong> Laissé vide si vous voulez pas affichié votre photo!</h6>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
		</div>
	</div>
</form>
<!-- End myModal_img_mod -->
<form action="" method="post">
	<div id="myModal_social_edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_social_edit_Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModal_social_edit_Label">URL Socieaux</h3>
		</div>
		<div class="modal-body">
			<center>
				<table width="80%">
					<tr>
						<td>URL Facebook</td>
						<td><input name="fb_url" type="url" value="<?php echo $user->fb;?>" class="input-large" /></td>
					</tr>
					<tr>
						<td>URL LinkedIn</td>
						<td><input name="linkedin_url" type="url" value="<?php echo $user->linkedin;?>" class="input-large" /></td>
					</tr>
					<tr>
						<td>URL Gitub</td>
						<td><input name="github_url" type="url" value="<?php echo $user->github;?>" class="input-large" /></td>
					</tr>
				</table>
			</center>
			<br>
			<h6><strong>Exp.</strong> http://www.facebook.com/<br>
				<strong>INFO :</strong> Laissé vide si vous voulez pas affichié vos lien socieaux!</h6>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
			<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
		</div>
	</div>
</form>
<!-- End myModal_social_edit -->

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