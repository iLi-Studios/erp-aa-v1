<?php
$idUser=$_SESSION['user_id'];
?>
<script type="text/javascript"> 
	var auto_refresh = setInterval(function(){$('#LoadSumMessagesHeader').load('<?php echo $URL;?>/ili-functions/AJAX/MessageGetSumHeader.php').fadeIn("slow");}, 500); 
</script>
<script type="text/javascript"> 
	var auto_refresh = setInterval(function(){$('#MessageGetAllHeader').load('<?php echo $URL;?>/ili-functions/AJAX/MessageGetAllHeader.php').fadeIn("slow");}, 500); 
</script>
<!-- BEGIN INBOX DROPDOWN -->
<li class="dropdown" id="header_inbox_bar"> 
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
		<i class="icon-envelope-alt"></i>
		<span class="badge badge-important" id="LoadSumMessagesHeader"></span>
	</a>
	<ul class="dropdown-menu extended inbox">
		<li><center><a href="<?php echo $URL.'ili-messages/start';?>">Nouveau Message</a></center></li>
		<li id="MessageGetAllHeader"></li>
		<li><center><a href="<?php echo $URL.'ili-messages/inbox';?>">Boite de réception</a></center></li>
	</ul>
</li>






