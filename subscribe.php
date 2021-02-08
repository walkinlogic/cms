<?php
	include_once("includes/config.php");      /// db setting
	include_once("includes/db_wrapper.php"); /// db wrapper
	include_once("admin/includes/utility.php");      /// general functions
	include_once("admin/includes/thumbnail_images.class.php"); 
	 
	 if(strpos($_SERVER['HTTP_REFERER'],DOMAIN)){  
			
			$email =cleaninputfield($mysql,$_POST['email']);
			if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
				echo "Please enter a valid email address.";
				exit;
			}
			$mysql->record_insert("subscription_tbl",array('email' => $email,'sub_date' => date('Y-m-d H:i:s')),false);
?>Subscript successfully!<?php   }  