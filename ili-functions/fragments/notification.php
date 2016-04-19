<!-- BEGIN NOTIFICATION DROPDOWN -->
<?php
function NotifGetAllNonSeen(){
	$idUser=$_SESSION['user_id'];
	$query="SELECT * FROM `notificationsystem` WHERE `idUser`='$idUser' AND `Seen`='0' ORDER BY `idNotification` DESC LIMIT 3 ";
	$result=QueryExcuteWhile($query);
	if(mysqli_num_rows($result)>'0'){
		echo'<ul class="dropdown-menu extended notification">';
	}
	while ($o=mysqli_fetch_object($result)){
		echo'
			<li> 
				'.$o->Description.' 
					<span class="small italic" style="margin-left:4%"><br>'?><?php DateDifference($o->Timestamp); echo'
						<br>
						<form action="" method="post" style="margin-bottom:-3%;margin-top:-10%;">
							<input type="submit" value="Vu?" style="text-decoration:none;border:0;background:none;float:right; margin-left:10px;color:#22878E;line-height: 100%;font-size:12px;margin-top:5px;"/>
							<input type="hidden" name="vu" value="'.$o->idNotification.'">
						</form>
					</span>
				</a>
			</li>				
		';
	}
	if(mysqli_num_rows($result)>'0'){
		echo'
			<li>
					<form action="" method="post">
						<input type="hidden" name="vu_tous" value="'.$idUser.'">
						<center><input type="submit" value="Marquer tous comme Vus?" style="border:none;background: none;line-height: 100%;color:#22878E;font-size:12px;margin-bottom:0px;margin-top:15px;"></center>
					</form>
			</li>
			';
		echo'</ul>';
	}
}
function NotifMakeSeeAll($idUser){
	$query="UPDATE `notificationsystem` SET `Seen` = '1' WHERE `idUser` ='$idUser';";
	QueryExcute('', $query);
}
function NotifMakeSee($idNotification){
	$query="UPDATE `notificationsystem` SET `Seen` = '1' WHERE `idNotification` ='$idNotification';";
	QueryExcute('', $query);
}
if(isset($_POST['vu'])){
	$id=$_POST['vu'];
	NotifMakeSee($id);
}
if(isset($_POST['vu_tous'])){
	$id=$_POST['vu_tous'];
	NotifMakeSeeAll($id);
}
?>

<script type="text/javascript"> 
	var auto_refresh = setInterval(function(){$('#NotifGetSumNonSeen').load('<?php echo $URL;?>/ili-functions/AJAX/NotifGetSumNonSeen.php').fadeIn("slow");}, 500); 
</script>
<script type="text/javascript"> 
	var auto_refresh = setInterval(function(){$('#NotifGetAllNonSeen').load('<?php echo $URL;?>/ili-functions/AJAX/NotifGetAllNonSeen.php').fadeIn("slow");}, 500); 
</script>
<li class="dropdown" id="header_notification_bar">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-bell-alt" ></i>
		<span class="badge badge-warning" id="NotifGetSumNonSeen"></span>
	</a>
	<?php NotifGetAllNonSeen();?>
</li>
<!-- END NOTIFICATION DROPDOWN -->

