<!-- BEGIN NOTIFICATION DROPDOWN -->
<?php
//$link=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$id_user=$_SESSION['user_id'];
function num_notif(){
	$id_user=$_SESSION['user_id'];
	$query="SELECT * FROM `system_notif` WHERE `id_user`='$id_user' AND `vu`='0'";
	$o=query_execute("mysqli_num_rows", $query);
	if($o=='0'){echo '';}
	else{echo '<span class="badge badge-warning">'.$o.'</span>';}
}
function vu_notif($id){
	$query="UPDATE `system_notif` SET `vu` = '1' WHERE `id` ='$id';";
	query_execute_insert($query);
}
if(isset($_POST['vu'])){
	$id=$_POST['vu'];
	vu_notif($id);
}
function vu_tous_notif($id){
	$query="UPDATE `system_notif` SET `vu` = '1' WHERE `id_user` ='$id';";
	query_execute_insert($query);
}
if(isset($_POST['vu_tous'])){
	$id=$_POST['vu_tous'];
	vu_tous_notif($id);
}
function get_all_notification_non_vu(){
	$id_user=$_SESSION['user_id'];
	$query="SELECT * FROM `system_notif` WHERE `id_user`='$id_user' AND `vu`='0' ORDER BY id DESC LIMIT 3 ";
	$result=query_excute_while($query);
	if(mysqli_num_rows($result)>'0'){
		echo'<ul class="dropdown-menu extended notification">';
	}
	while ($o=mysqli_fetch_object($result)){
		echo'
			<li> 
				'.$o->notification.' 
					<span class="small italic" style="margin-left:4%"><br>'?><?php diff_date($o->date_notif); echo'
						<br>
						<form action="" method="post" style="margin-bottom: -3%;margin-top: -10%;">
							<input type="submit" value="Vu?" style="text-decoration:none;margin-left:80%;line-height: 100%;border: 0;background: none;text-decoration: underline;" class="small italic"/>
							<input type="hidden" name="vu" value="'.$o->id.'">
						</form>
					</span>
				</a>
			</li>				
		';
	}
	if(mysqli_num_rows($result)>'0'){
		echo'
			<li>
				<a href="#">
					<form action="" method="post" style="margin-bottom: 2%;">
						<input type="submit" value="Marquer tous comme Vus?" style="margin-left:10%;line-height: 100%;border: 0;background: none;text-decoration: underline;" class="small italic"/>
						<input type="hidden" name="vu_tous" value="'.$id_user.'">
					</form>
				</a>
			</li>';
		echo'</ul>';
	}
}
?>
<li class="dropdown" id="header_notification_bar">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-bell-alt"></i>
		<?php num_notif();?>
	</a>
		<?php get_all_notification_non_vu();?>
</li>
<!-- END NOTIFICATION DROPDOWN -->

