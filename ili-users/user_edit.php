<?php 
include"../ili-functions/functions.php";
function UserDiplomaInsert($idUser){
	//Modal
	echo'
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
							<td width="60%"><input name="InsertDiplomaYear" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Lieux</td>
							<td><input name="InsertDiplomaLocation" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Diplôme</td>
							<td><input name="InsertDiplomaDiscription" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Etablissement</td>
							<td><input name="InsertDiplomaInstitute" required type="text" placeholder="" class="input-large" /></td>
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
	';
	//Form
	if( (isset($_POST['InsertDiplomaYear'])) && (isset($_POST['InsertDiplomaLocation'])) && (isset($_POST['InsertDiplomaDiscription'])) && (isset($_POST['InsertDiplomaInstitute'])) ){	
		global $URL;
		$user=UserGetInfo($idUser);
		$InsertDiplomaYear	 			= addslashes($_POST['InsertDiplomaYear']);
		$InsertDiplomaLocation	 		= addslashes($_POST['InsertDiplomaLocation']);
		$InsertDiplomaDiscription 		= addslashes($_POST['InsertDiplomaDiscription']);
		$InsertDiplomaInstitute 		= addslashes($_POST['InsertDiplomaInstitute']);
		$QueryInsertDiploma			= "INSERT INTO `usersdiploma` (`idDiploma`, `idUser`, `Year`, `Location`, `Description`, `Institute`) VALUES ('', '$user->idUser', '$InsertDiplomaYear', '$InsertDiplomaLocation', '$InsertDiplomaDiscription', '$InsertDiplomaInstitute');";
		QueryExcute('', $QueryInsertDiploma);
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', ajout du diplôme : '.$InsertDiplomaDiscription);
		LogWrite("Ajout du diplôme : ".$InsertDiplomaDiscription.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserDiplomaUpdate($idUser){
	//Function
	$query="SELECT * FROM `usersdiploma` WHERE `idUser`='$idUser' ORDER BY `idDiploma` DESC;";
	if(QueryExcute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS DE DIPLOME!</strong>";}
	else{
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->Description.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#myModal_diploma_mod'.$o->idDiploma.'" data-toggle="modal" class="icon-edit tooltips" data-original-title="&nbsp;&nbsp;Modifier"></a>
						<a href="diploma_remove?idUser='.$_GET['id'].'&id_diploma='.$o->idDiploma.'&diploma_name='.$o->Description.'" class="icon-trash tooltips" data-original-title="&nbsp;&nbsp;Supprimer"></a>
						<br/>
						<em>'.$o->Location.', '.$o->Year.'</em><br/>
						<em><strong>'.$o->Institute.'</strong></em><br>
						<!-- Start myModal_diploma_mod -->
						<form action="" method="post">
							<div id="myModal_diploma_mod'.$o->idDiploma.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_diploma_mod'.$o->idDiploma.'_Label" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModal_diploma_mod'.$o->idDiploma.'_Label">Diplôme Modification</h3>
								</div>
								<div class="modal-body">
									<center>
										<table width="80%">
											<tr>
												<td width="40%">Annee</td>
												<td width="60%"><input name="UpdateDiplomaYear" required type="text" value="'.$o->Year.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Lieux</td>
												<td><input name="UpdateDiplomaLocation" required type="text" value="'.$o->Location.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Diplôme</td>
												<td><input name="UpdateDiplomaDescription" required type="text" value="'.$o->Description.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Etablissement</td>
												<td><input name="UpdateDiplomaInstitute" required type="text" value="'.$o->Institute.'" class="input-large" /></td>
											</tr>	
										</table>
									</center>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="UpdateDiplomaidDiploma" value="'.$o->idDiploma.'"/>
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
								</div>
							</div>
						</form><!-- End myModal_diploma_mod -->
					</li>
					';				
		}
	}
	//Form
	if( (isset($_POST['UpdateDiplomaidDiploma'])) && (isset($_POST['UpdateDiplomaYear'])) && (isset($_POST['UpdateDiplomaLocation'])) && (isset($_POST['UpdateDiplomaDescription'])) && (isset($_POST['UpdateDiplomaInstitute'])) ){	
		global $URL;
		$user=UserGetInfo($idUser);
		$UpdateDiplomaYear	 			= addslashes($_POST['UpdateDiplomaYear']);
		$UpdateDiplomaLocation	 		= addslashes($_POST['UpdateDiplomaLocation']);
		$UpdateDiplomaDescription 		= addslashes($_POST['UpdateDiplomaDescription']);
		$UpdateDiplomaInstitute 		= addslashes($_POST['UpdateDiplomaInstitute']);
		$UpdateDiplomaidDiploma			= addslashes($_POST['UpdateDiplomaidDiploma']);
		$QueryUpdateDiploma	= "UPDATE `usersdiploma` 
								SET 
										`Year`='$UpdateDiplomaYear',
										`Location`='$UpdateDiplomaLocation',
										`Description`='$UpdateDiplomaDescription',
										`Institute`='$UpdateDiplomaInstitute' 
								WHERE `idDiploma`='$UpdateDiplomaidDiploma';";
		QueryExcute('', $QueryUpdateDiploma);
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', modification du diplôme : '.$UpdateDiplomaDescription);
		LogWrite("Modification du diplôme : ".$UpdateDiplomaDescription.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserExpiranceInsert($idUser){
	//Modal
	echo'
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
							<td width="60%"><input name="InsertCompany" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>URL Etablissement</td>
							<td><input name="InsertCompanyURL" type="url" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Durée</td>
							<td><input name="InsertPeriod" required type="text" placeholder="" class="input-large" /></td>
						</tr>
						<tr>
							<td>Expériance</td>
							<td><textarea name="InsertDescription" style="resize: vertical; width:100%; max-height:150px;" rows="4"></textarea></td>
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
	';
	//Form
	if( (isset($_POST['InsertCompany'])) && (isset($_POST['InsertCompanyURL'])) && (isset($_POST['InsertPeriod'])) && (isset($_POST['InsertDescription'])) ){	
		global $URL;
		$user=UserGetInfo($idUser);
		$InsertCompany	 		= addslashes($_POST['InsertCompany']);
		$InsertCompanyURL	 	= addslashes($_POST['InsertCompanyURL']);
		$InsertPeriod 			= addslashes($_POST['InsertPeriod']);
		$InsertDescription 		= addslashes($_POST['InsertDescription']);
		$QueryInsertExperience	= "INSERT INTO `usersexperience` (`idExperience`, `idUser`, `Company`, `CompanyURL`, `Period`, `Description`) VALUES (NULL, '$user->idUser', '$InsertCompany', '$InsertCompanyURL', '$InsertPeriod', '$InsertDescription');";
		QueryExcute('', $QueryInsertExperience);
		NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', ajout de l\'expérence dans l\'etablissement : '.$InsertCompany);
		LogWrite("Ajout de l\'expérience dans l\'etablissement : ".$InsertCompany.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserExpiranceUpdate($idUser){
	$query="SELECT * FROM `usersexperience` WHERE `idUser`='$idUser' ORDER BY `idExperience` DESC;";
	if(QueryExcute('mysqli_num_rows', $query)=='0'){echo"<strong>PAS D'EXPERIENCE!</strong>";}
	else{
		$result=QueryExcuteWhile($query);
		while ($o=mysqli_fetch_object($result)){
			echo'	<li><i class="icon-hand-right"></i>
						<strong>'.$o->Company.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#myModal_expirance_mod'.$o->idExperience.'" data-toggle="modal" class="icon-edit tooltips" data-original-title="&nbsp;&nbsp;Modifier"></a>
						<a href="expirance_remove?idUser='.$_GET['id'].'&id_expirance='.$o->idExperience.'&Company='.$o->Company.'" class="icon-trash tooltips" data-original-title="&nbsp;&nbsp;Supprimer"></a>
						<br/>
						<em>Durée : '.$o->Period.'</em><br/>
						<em>&nbsp;&nbsp;&nbsp;'.$o->Description.'</em><br>
						<a href="'.$o->CompanyURL.'" target="new">'.$o->CompanyURL.'</a>
						<!-- Start myModal_expirance_mod -->					
						<form action="" method="post">
							<div id="myModal_expirance_mod'.$o->idExperience.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_expirance_mod'.$o->idExperience.'_Label" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModal_expirance_mod'.$o->idExperience.'_Label">Expérience Modifier</h3>
								</div>
								<div class="modal-body">
									<center>
										<table width="80%">
											<tr>
												<td width="40%">Etablissement</td>
												<td width="60%"><input name="UpdateCompany" required type="text" value="'.$o->Company.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>URL Etablissement</td>
												<td><input name="UpdateCompanyURL" type="text" value="'.$o->CompanyURL.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Durée</td>
												<td><input name="UpdatePeriod" required type="text" value="'.$o->Period.'" class="input-large" /></td>
											</tr>
											<tr>
												<td>Expérience</td>
												<td><textarea name="UpdateDescription" style="resize: vertical; width:100%; max-height:150px;" rows="4">'.$o->Description.'</textarea></td>
											</tr>
										</table>
									</center>
									<h6>NB: URL Etablissement doit être complet <br>EXP: http://www.ili-studios.com/<br> <strong>CONCEIL :</strong> Copiez-le directement depuis le navigateur</h6>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="UpdateidExperience" value="'.$o->idExperience.'"/>
									<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
									<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
								</div>
							</div>
						</form><!-- End myModal_expirance_mod -->						
					</li>';
		}
		//formulaire d'update
		if( (isset($_POST['UpdateCompany'])) && (isset($_POST['UpdateCompanyURL'])) && (isset($_POST['UpdatePeriod'])) && (isset($_POST['UpdateDescription'])) && (isset($_POST['UpdateidExperience'])) ){	
			global $URL;
			$UpdateCompany	 	= addslashes($_POST['UpdateCompany']);
			$UpdateCompanyURL	= addslashes($_POST['UpdateCompanyURL']);
			$UpdatePeriod 		= addslashes($_POST['UpdatePeriod']);
			$UpdateDescription 	= addslashes($_POST['UpdateDescription']);
			$UpdateidExperience	= addslashes($_POST['UpdateidExperience']);
			$user				= UserGetInfo($idUser);
			QueryExcute("", "UPDATE usersexperience SET Company='$UpdateCompany', CompanyURL='$UpdateCompanyURL', Period='$UpdatePeriod', Description='$UpdateDescription' WHERE idExperience='$UpdateidExperience';");
			NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', Modification de l`experiance dans l`etablissement : '.$UpdateCompany);
			LogWrite("Modification de l\'expérience dans l\'etablissement : ".$UpdateCompany.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
			Refresh();
			
		}
	}
}
function UserQualificationInsert($idUser){
	//Modal
	echo'
	<form action="" method="post">
		<div id="myModal_skills_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_skills_add_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_skills_add_Label"><center>Ajout de Compétance</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td width="40%">Compétance</td>
							<td width="60%"><input name="InsertQualificationDescription" required type="text" class="input-large" /></td>
						</tr>
						<tr>
							<td>Niveau</td>
							<td><input name="InsertQualificationLevel" required type="range" class="input-large" />%</td>
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
	';
	//form
	if( (isset($_POST['InsertQualificationDescription'])) && (isset($_POST['InsertQualificationLevel'])) ){
		global $URL;
		$user=UserGetInfo($idUser);
		$InsertQualificationDescription 	= addslashes($_POST['InsertQualificationDescription']);
		$InsertQualificationLevel			= addslashes($_POST['InsertQualificationLevel']);
		$QueryInsertQualification = "INSERT INTO usersqualification VALUES ('', '$idUser', '$InsertQualificationDescription', '$InsertQualificationLevel');";
		QueryExcute('', $QueryInsertQualification);
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.', ajout de compétence : '.$InsertQualificationDescription);
		LogWrite("Ajout du compétence : ".$InsertQualificationDescription.", pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
		Refresh();
	}	
}
function UserQualificationUpdate($idUser){
	// Function
	$Query="SELECT * FROM `usersqualification` WHERE idUser='$idUser' ORDER BY `idQualification` DESC;";
	if(QueryExcute('mysqli_num_rows', $Query)=='0'){echo"<strong>PAS DE COMPETANCE!</strong>";}
	else{
		$Result=QueryExcuteWhile($Query);
		while ($O=mysqli_fetch_object($Result)){
			if($O->Value >= '0' && $O->Value <= '33'){$Color='danger';}
			if($O->Value >'33' && $O->Value <= '66'){$Color='warning';}
			if($O->Value >'66' && $O->Value <= '100'){$Color='success';}
			echo'
				<tr>
					<td class="span1">
						<span class="label label-inverse">
							<a href="skills_remove?idUser='.$_GET['id'].'&id_skills='.$O->idQualification.'&skills_name='.$O->Label.'" class="icon-trash tooltips" data-original-title="Supprimer"></a>
							'.$O->Label.'
						</span>
					</td>
					<td>
						<div class="progress progress-'.$Color.' progress-striped">
							<div style="width: '.$O->Value.'%" class="bar"></div>
						</div>
					</td>
				</tr>				
				';				
		}
	}
}
function UserPasswordUpdate($idUser){
	$user=UserGetInfo($idUser);
	//Form
	echo'
	<form action="" method="post">
		<div id="myModal_Password_edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_Password_edit_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_Password_edit_Label"><center>Changement du mot de passe</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">';?>
						<?php
						if($_SESSION['user_idRank']>=3){
							echo'
								<input name="Password_now" type="hidden" class="input-large" value="'.$user->Password.'" />
								<tr>
									<td>Nouveau mot de passe</td>
									<td><input name="Password_new" required type="password" placeholder="" class="input-large" /></td>
								</tr>
								<tr>
									<td>Repeter votre nouveau mot de passe</td>
									<td><input name="Password_new2" required type="password" placeholder="" class="input-large" /></td>
								</tr>
							';
						}
						else{
							echo'
								<tr>
									<td width="40%">Mot de passe actuelle</td>
									<td width="60%"><input name="Password_now" required type="password" placeholder="" class="input-large" /></td>
								</tr>
								<tr>
									<td>Nouveau mot de passe</td>
									<td><input name="Password_new" required type="password" placeholder="" class="input-large" /></td>
								</tr>
								<tr>
									<td>Repeter votre nouveau mot de passe</td>
									<td><input name="Password_new2" required type="password" placeholder="" class="input-large" /></td>
								</tr>	
							';
						}
						?><?php echo'
					</table>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Changer"/>
			</div>
		</div>
	</form>
	';
	//Function
	if( (isset($_POST['Password_now'])) && (isset($_POST['Password_new'])) && (isset($_POST['Password_new2'])) ){
		if($_SESSION['user_idRank']>=3){$Password_now =($_POST['Password_now']);}else{$Password_now=md5($_POST['Password_now']);}
		global $Timestamp, $URL;
		$Password_new	=md5($_POST['Password_new']);
		$Password_new2	=md5($_POST['Password_new2']);
		if($Password_now==$user->Password){
			if($Password_new2==$Password_new){
				QueryExcute("mysqli_fetch_object", "UPDATE `users` SET `LastPasswordChangedDate`='$Timestamp', `Password`='$Password_new' WHERE `idUser`='$idUser';");
				LogWrite("Changement du mot de passe de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
				Redirect('ili-users/user_edit?message=36&id='.$idUser);
			}
			else{Redirect('ili-users/user_edit?message=11&id='.$idUser);}
		}
		else{Redirect('ili-users/user_edit?message=10&id='.$idUser);}
	}
}
function UserProfileInfoUpdate($idUser){
	//Form
	global $URL;
	$user=UserGetInfo($idUser);
	echo'
	<form action="" method="post">
		<div id="myModal_info_mod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_info_mod_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_info_mod_Label"><center>Modification des informations</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td width="40%">Nom</td>
							<td width="60%"><input name="FamilyName" required type="text" value="'.$user->FamilyName.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>Prénom</td>
							<td><input name="FirstName" required type="text" value="'.$user->FirstName.'" class="input-large" /></td>
						</tr>';?><?php if($_SESSION['user_idRank']>=3){echo'
						<tr>
							<td>Poste</td>
							<td><input name="FunctionPost" required type="text" value="'.$user->FunctionPost.'" class="input-large" /></td>
						</tr>
						';}
						else{echo'<input name="FunctionPost" type="hidden" value="'.$user->FunctionPost.'"/>';}?><?php echo'
						<tr>
							<td>Email</td>
							<td><input name="Email" required type="email" value="'.$user->Email.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td><input name="Phone" required type="text" value="'.$user->Phone.'" data-mask="99.999.999" class="input-large" /></td>
						</tr>
						<tr>
							<td>Adresse</td>
							<td><input name="Adress" required type="text" value="'.$user->Adress.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>Date de naissance</td>
							<td><input name="BirthDay" required type="text" value="'.$user->BirthDay.'" data-mask="99-99-9999" class="input-large" /></td>
						</tr>
					</table>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
				<input type="submit" class="btn btn-primary" value="Mettre à jour ?"/>
			</div>
		</div>
	</form>
	';
		//Function
	if( (isset($_POST['FamilyName'])) && (isset($_POST['FirstName'])) && (isset($_POST['FunctionPost'])) && (isset($_POST['Email'])) && (isset($_POST['Phone'])) && (isset($_POST['BirthDay'])) && (isset($_POST['Adress'])) ){
		$FamilyName		=addslashes($_POST['FamilyName']);
		$FirstName		=addslashes($_POST['FirstName']);
		$FunctionPost	=addslashes($_POST['FunctionPost']);
		$Email			=addslashes($_POST['Email']);
		$Phone			=addslashes($_POST['Phone']);
		$Adress			=addslashes($_POST['Adress']);
		$BirthDay 		=addslashes($_POST['BirthDay']);						
		QueryExcute('', "UPDATE users SET FamilyName = '$FamilyName', FirstName='$FirstName', Email='$Email', FunctionPost='$FunctionPost', Phone='$Phone', BirthDay='$BirthDay', Adress='$Adress' WHERE idUser='$idUser'");
		$idUserSession = $_SESSION['user_id'];
		if($idUserSession==$idUser){
			NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$user->FamilyName.' '.$user->FirstName.' à modifier ces informations');
		}
		else{
			$UserUpdated=UserGetInfo($idUser);
			$UserUpdater=UserGetInfo($idUserSession);
			NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.' à modifier les informations de '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
		}
		LogWrite("Modification des informations de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
		Refresh();
		
	}
}
function UserProfilePhotoUpdate($idUser){
	$user=UserGetInfo($idUser);
	//Form
	echo'
	<form action="" method="post">
		<div id="myModal_img_mod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal_img_mod_Label" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModal_img_mod_Label"><center>Modification du photo du profile</center></h3>
			</div>
			<div class="modal-body">
				<center>
					<table width="80%">
						<tr>
							<td>URL Image</td>
							<td><input name="ProfilePhoto" type="url" value="'.$user->ProfilePhoto.'" class="input-large" /></td>
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
	';
	//Function
	if( isset($_POST['ProfilePhoto']) ){
		$ProfilePhoto				= addslashes($_POST['ProfilePhoto']);
		QueryExcute("mysqli_fetch_object", "UPDATE `users` SET `ProfilePhoto`='$ProfilePhoto' WHERE `idUser`='$user->idUser';");
		$idUserSession = $_SESSION['user_id'];
		if($idUserSession==$idUser){
			NotifAllWrite($user->idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', a modifier sa photo de profile');
		}
		else{
			$UserUpdated=UserGetInfo($idUser);
			$UserUpdater=UserGetInfo($idUserSession);
			NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$UserUpdater->idUser.'">'.$UserUpdater->FamilyName.' '.$UserUpdater->FirstName.', a modifier la photo de profile de '.$UserUpdated->FamilyName.' '.$UserUpdated->FirstName);
		}
		LogWrite("Changement de l\'image de profil de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$UserUpdated->idUser."\">".$UserUpdated->idUser."</a>");
		Redirect('ili-users/user_edit?message=36&id='.$idUser);
	}
}
function UserSocialeUpdate($idUser){
	$user=UserGetInfo($idUser);
	//Form
	echo'
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
							<td><input name="fbAccount" type="url" value="'.$user->fbAccount.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>URL LinkedinAccount</td>
							<td><input name="linkedinAccount" type="url" value="'.$user->linkedinAccount.'" class="input-large" /></td>
						</tr>
						<tr>
							<td>URL Gitub</td>
							<td><input name="githubAccount" type="url" value="'.$user->githubAccount.'" class="input-large" /></td>
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
	';
	//Function 
	if( (isset($_POST['fbAccount'])) && (isset($_POST['linkedinAccount'])) && (isset($_POST['githubAccount'])) ){
		global $URL;
		$fbAccount				= addslashes($_POST['fbAccount']);
		$linkedinAccount		= addslashes($_POST['linkedinAccount']);
		$githubAccount			= addslashes($_POST['githubAccount']);
		$QuerySocialInsert		= "UPDATE `users` SET `fbAccount`='$fbAccount', `githubAccount`='$githubAccount', `linkedinAccount`='$linkedinAccount' WHERE `idUser`='$idUser';";
		NotifAllWrite($idUser, '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idUser.'">'.$user->FamilyName.' '.$user->FirstName.', modification des liens socieaux');
		QueryExcute('', $QuerySocialInsert);
		LogWrite("Modification des liens socieaux de l\'utilisateur : <a href=\"ili-users/user_profil?id=".$user->idUser."\">".$user->idUser."</a>");
		Refresh();
	}
}
function UserPrivilegesGetUpdate($idUser){
	global $URL;
	$user=UserGetInfo($idUser);
	if( ($_SESSION['user_idRank']>=3)&&($_SESSION['user_id']!=$idUser) ){
		echo'
		<ul class="nav nav-tabs nav-stacked" style="margin-left:-15%;">
			<div class="widget-body">
				<div class="space10"></div>
				<ul id="tree_2" class="tree">
					<li>
						<a data-toggle="branch" class="tree-toggle" data-role="branch" href="#">Autorisations</a>
						<ul class="branch in">';
	$query="SELECT `bloc` FROM `usersprivilege` WHERE `idUser`='$idUser'";
	$result=QueryExcuteWhile($query);
	while ($o=mysqli_fetch_object($result)){
		if(($o->bloc != 'CONTRAT') && ($o->bloc != 'CAISSE')){
			echo'
							<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
			$query2="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			$result2=QueryExcuteWhile($query2);
			while ($b=mysqli_fetch_object($result2)){
				echo'
								<ul class="branch">
					';			
					if($b->s){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'s0" value="1">
											<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
								';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'s1" value="1" onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
							';
					}
					if($b->c){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'c0" value="1">
											<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-plus"></p></a> Créer
										</form>
									</li>
							';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'c1" value="1" onChange="this.form.submit()">
											<a><p class="icon-plus"></p></a> Créer
										</form>
									</li>
							';
					}
					if($b->u){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'u0" value="1">
											<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-edit"></p></a> Modifier
										</form>
									</li>
							';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'u1" value="1" onChange="this.form.submit()">
											<a><p class="icon-edit"></p></a> Modifier
										</form>
									</li>
							';
					}
					if($b->d){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'d0" value="1">
											<input type="checkbox" name="d0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
							';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'d1" value="1" onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
							';
					}
					if(isset($_POST[$b->idPrivilege.'s0'])){
						$query="UPDATE `usersprivilege` SET s='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'s1'])){
						$query="UPDATE `usersprivilege` SET s='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c0'])){
						$query="UPDATE `usersprivilege` SET c='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c1'])){
						$query="UPDATE `usersprivilege` SET c='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u0'])){
						$query="UPDATE `usersprivilege` SET u='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>MODIFIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>MODIFIER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u1'])){
						$query="UPDATE `usersprivilege` SET u='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>MODIFIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>MODIFIER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d0'])){
						$query="UPDATE `usersprivilege` SET d='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Suppression du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d1'])){
						$query="UPDATE `usersprivilege` SET d='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					echo'		
								</ul>
					';
				}
		}
		if($o->bloc == 'CONTRAT'){
			echo'
							<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
			$query2="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			$result2=QueryExcuteWhile($query2);
			while ($b=mysqli_fetch_object($result2)){
					echo'
								<ul class="branch">
						';			
					if($b->s){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'s0" value="1">
											<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'s1" value="1" onChange="this.form.submit()">
											<a><p class="icon-eye-open"></p></a> Voir
										</form>
									</li>
						';
					}
					if($b->c){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'c0" value="1">
											<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-file"></p></a> Créer
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'c1" value="1" onChange="this.form.submit()">
											<a><p class="icon-file"></p></a> Créer
										</form>
									</li>
						';
					}
					if($b->u){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'u0" value="1">
											<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-repeat"></p></a> Renouveler
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'u1" value="1" onChange="this.form.submit()">
											<a><p class="icon-repeat"></p></a> Renouveler
										</form>
									</li>
						';
					}
					if($b->d){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'d0" value="1">
											<input type="checkbox" name="d0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'d1" value="1" onChange="this.form.submit()">
											<a><p class="icon-trash"></p></a> Supprimer
										</form>
									</li>
						';
					}
					if(isset($_POST[$b->idPrivilege.'s0'])){
						$query="UPDATE `usersprivilege` SET s='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'s1'])){
						$query="UPDATE `usersprivilege` SET s='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>VOIR</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c0'])){
						$query="UPDATE `usersprivilege` SET c='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c1'])){
						$query="UPDATE `usersprivilege` SET c='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u0'])){
						$query="UPDATE `usersprivilege` SET u='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>RENOUVELER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u1'])){
						$query="UPDATE `usersprivilege` SET u='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>RENOUVELER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d0'])){
						$query="UPDATE `usersprivilege` SET d='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Suppression du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'d1'])){
						$query="UPDATE `usersprivilege` SET d='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>SUPPRIMER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>SUPPRIMER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					echo'		
								</ul>
					';
				}
		}
		if($o->bloc == 'CAISSE'){
			echo'
							<li><a data-toggle="branch" class="tree-toggle closed" data-role="branch" href="#">'.$o->bloc.'</a>';
			$query2="SELECT * FROM `usersprivilege` WHERE `idUser`='$idUser' AND `bloc`='$o->bloc';";
			$result2=QueryExcuteWhile($query2);
			while ($b=mysqli_fetch_object($result2)){
					echo'
								<ul class="branch">
						';			
					if($b->s){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'s0" value="1">
											<input type="checkbox" name="s0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-book"></p></a> Journal
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'s1" value="1" onChange="this.form.submit()">
											<a><p class="icon-book"></p></a> Journal
										</form>
									</li>
						';
					}
					if($b->c){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'c0" value="1">
											<input type="checkbox" name="c0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-signout"></p></a> Décaissement
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'c1" value="1" onChange="this.form.submit()">
											<a><p class="icon-signout"></p></a> Décaissement
										</form>
									</li>
						';
					}
					if($b->u){
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="hidden" name="'.$b->idPrivilege.'u0" value="1">
											<input type="checkbox" name="u0" value="0" checked onChange="this.form.submit()">
											<a><p class="icon-money"></p></a> Echéancier
										</form>
									</li>
						';
					}
					else{
						echo'
									<li>
										<form action="" method="post" style="margin-bottom:-2px;">
											<input type="checkbox" name="'.$b->idPrivilege.'u1" value="1" onChange="this.form.submit()">
											<a><p class="icon-money"></p></a> Echéancier
										</form>
									</li>
						';
					}
					if(isset($_POST[$b->idPrivilege.'s0'])){
						$query="UPDATE `usersprivilege` SET s='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>JOURNAL</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'s1'])){
						$query="UPDATE `usersprivilege` SET s='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>JOURNAL</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>VOIR</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c0'])){
						$query="UPDATE `usersprivilege` SET c='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>DECAISSEMENT</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'c1'])){
						$query="UPDATE `usersprivilege` SET c='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>DECAISSEMENT</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>CREER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u0'])){
						$query="UPDATE `usersprivilege` SET u='0' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Supprission du privilége <strong>ECHEANCIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Suppression de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
					}
					if(isset($_POST[$b->idPrivilege.'u1'])){
						$query="UPDATE `usersprivilege` SET u='1' WHERE idPrivilege='$b->idPrivilege';";
						QueryExcute('', $query);
						NotifAllWrite('', '', '<a href="'.$URL.'ili-users/user_profil?id='.$user->idPrivilege_user.'">Ajout du privilége <strong>ECHEANCIER</strong> sur le bloc <strong>'.$o->bloc.'</strong> de '.$user->FamilyName.' '.$user->FirstName);
						LogWrite("Ajout de privilége <strong>RENOUVELER</strong> sur le bloc <strong>".$o->bloc."</strong> pour l\'utilisateur : <a href=\"ili-users/user_profil?id=".$idUser."\">".$idUser."</a>");
						echo'<SCRIPT LANGUAGE="JavaScript">document.location.href="user_edit?id='.$idUser.'"</SCRIPT>';
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
Authorization('2');
AuthorizedPrivileges('USERS', 'U');
$idUser=$_GET['id'];
$user=UserGetInfo($idUser);
if($user==''){Redirect('index?message=14');}

/*$idUser_session = $_SESSION['user_id'];
$user_idRank = $_SESSION['user_idRank'];
if( ($idUser!=$idUser_session)&&($user_idRank<3) ){Redirect('index?message=17');}*/
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
					<h3 class="page-title"> Utilisateurs <small> Modification</small> </h3>
					<ul class="breadcrumb">
						<li> <a href="<?php echo $URL;?>"><i class="icon-home"></i></a><span class="divider">&nbsp;</span> </li>
						<li> <a href="users">Utilisateurs du système</a> <span class="divider">&nbsp;</span></li>
						<li> <a href="user_profil?id=<?php echo $user->idUser;?>">Profil </a><span class="divider">&nbsp;</span>
						<li> <a href="user_edit?id=<?php echo $user->idUser;?>">Modification</a><span class="divider-last">&nbsp;</span></li>
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
					<?php ErrorGet('message'); ?>
					<div class="widget">
						<div class="widget-title">
							<h4><i class="<?php UserGetIcon($user->idRank);?>"></i> Profil</h4>
							<span class="tools">
							<?php echo'<a href="user_profil?id='.$user->idUser.'" class="icon-lock tooltips" data-original-title="verrouiller"></a>';?>
							</span> </div>
						<div class="widget-body">
							<div class="span3">
								<div class="text-center profil-pic">
									<?php if($user->ProfilePhoto==''){echo'Pas de photo de profil';}else{echo'<img src="'.$user->ProfilePhoto.'" width="100%" height="226px;">';}?>
									<span><a href="#myModal_img_mod" data-toggle="modal" class="icon-edit tooltips" data-original-title="Modifier votre photo"></a></span> </div>
								<ul class="nav nav-tabs nav-stacked">
									<?php UserSocialGet($user->idUser);?>
									<a href="#myModal_social_edit" data-toggle="modal" class="icon-edit tooltips" data-original-title="Modifier vos lien socieaux"></a>
								</ul>
								<?php UserPrivilegesGetUpdate($user->idUser);?>
							</div>
							<div class="span6">
								<h4><?php echo $user->FamilyName; ?> <?php echo $user->FirstName; ?> <span><a href="#myModal_info_mod" data-toggle="modal" class="icon-edit tooltips" data-original-title="Modifier les informations personnelles"></a></span><br/>
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
										<tr>
											<td class="span2">Mot de passe mise à jour le : </td>
											<td><?php echo $user->LastPasswordChangedDate; ?> <span><a href="#myModal_Password_edit" data-toggle="modal" class="icon-edit tooltips" data-original-title="Changer votre mot de passe"></a></span></td>
										</tr>
									</tbody>
								</table>
								<h4>Compétances <span><a href="#myModal_skills_add" data-toggle="modal" class="icon-plus tooltips" data-original-title="Ajouter"></a></span></h4>
								<table class="table table-borderless">
									<tbody>
										<?php UserQualificationUpdate($user->idUser); ?>
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
								<h4>Diplômes <span><a href="#myModal_diploma_add" data-toggle="modal" class="icon-plus tooltips" data-original-title="Ajouter"></a></span></h4>
								<ul class="icons push">
									<?php UserDiplomaUpdate($user->idUser);?>
								</ul>
								<h4>Expériance <span><a href="#myModal_expirance_add" data-toggle="modal"  class="icon-plus tooltips" data-original-title="Ajouter"></a></span></h4>
								<ul class="icons push">
									<?php UserExpiranceUpdate($user->idUser);?>
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
<?php 
UserDiplomaInsert($user->idUser);
UserExpiranceInsert($user->idUser);
UserQualificationInsert($user->idUser);
UserPasswordUpdate($user->idUser);
UserProfileInfoUpdate($user->idUser);
UserProfilePhotoUpdate($user->idUser);
UserSocialeUpdate($user->idUser);
?>

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
   <script type="text/javascript" src="../ili-style/assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

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