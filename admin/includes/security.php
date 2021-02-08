<?php 
	@session_start();
	if($_SESSION['LOGGERID']==FALSE || $_SESSION['LOGGER_NAME']==FALSE || $_SESSION['LOGGER_EMAIL']==FALSE){
		$msg = base64_encode("Please login to access this page!");
		echo "<script>window.location='index.php?msg=$msg'</script>";
		echo 'Unauthorised Access';
		exit();
	}
	?>