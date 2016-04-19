<?php 
include"../../ili-functions/functions.php"; 
Authorization('2');
AuthorizedPrivileges('CLIENTS', 'D'); 
$idClient=$_GET['id'];
$O=ClientGetInfo($idClient);
if($O==''){Redirect('index?message=18');}
else{ClientDrop($idClient, $O);}
?>