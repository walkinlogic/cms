<?php 
	@session_start();
	@session_destroy();
	$msg = base64_encode("You are logoff successfully!");
	echo "<script> window.location='index.php?msg=$msg'; </script>";
	exit();
	?>