<?php 
include"../ili-functions/functions.php";
Authorization('3');
function LogExport(){
	global $URL;
	$Timestamp_Log = date("Ymd_His");
	$result=QueryExcuteWhile("SELECT * FROM `logsystem`");
	while ($o=mysqli_fetch_object($result)){
		if($o){
			file_put_contents('./'.$Timestamp_Log.'.txt', $o->idLog.' '.$o->Timestamp.' '.$o->idUser.' '.$o->Description."\n", FILE_APPEND);
			QueryExcute('', 'TRUNCATE `logsystem`;');
		}
	}
	Redirect('log/index');
}
LogExport();
?>
