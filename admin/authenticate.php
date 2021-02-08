<?php 
	@session_start();
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	
	if($_POST['username']!="" && $_POST['password']!=""){
		$username= cleaninputfield($mysql,$_POST['username']);
		$password= cleaninputfield($mysql,$_POST['password']);
		$postrow = $mysql->fetch_row("user_tbl","username='$username' AND password='$password'");
		if($mysql->affected_rows>0){
			if($postrow['status']==1){
				$_SESSION['LOGGERID']= $postrow['id'];
				$_SESSION['LOGGER_NAME']= $postrow['full_name'];
				$_SESSION['LOGGER_EMAIL']= $postrow['email'];
				/// ROLES MANAGEMENT
				$_SESSION['MANAGE_PAGE']= $postrow['page_management'];
				$_SESSION['MANAGE_CONTENT']= $postrow['content_management'];
				$_SESSION['MANAGE_NEWS']= $postrow['news_management'];
				$_SESSION['MANAGE_GALLERY']= $postrow['gallery_management'];
				$_SESSION['MANAGE_SLIDE']= $postrow['slideshow_management'];
				$_SESSION['MANAGE_FORM']= $postrow['forms_management'];
				$_SESSION['MANAGE_EXPAND']= $postrow['expandablecontent_management'];
				$_SESSION['MANAGE_CUSTOM']= $postrow['custommodule_management'];
				$_SESSION['MANAGE_USER']= $postrow['user_management'];
				$_SESSION['MANAGE_STYLE']= $postrow['style_management'];
				/// END OF ROLES
				/// login updation
				$user_id = $postrow['id'];
				$date_time =  date('Y-m-d h:i:s');
				$ip_address =$_SERVER['REMOTE_ADDR'];
				$mysql->record_update("user_tbl",array('lastlogindate' => $date_time,'login_ip' => $ip_address),"id=$user_id");
				/// login updation ends
				if($_SESSION['MANAGE_PAGE']==1){
					 echo "<script> window.location='pages_list.php'; </script>";
					exit(); 
				}else{
					 echo "<script> window.location='welcome.php'; </script>";
					exit(); 
				}	
			}else{
				 $msg= base64_encode("Your account is inactive, please contact Admin!");
				echo "<script> window.location='index.php?msg=$msg'; </script>";
				exit(); 
			}	
		}else{
			 $msg= base64_encode("Invalid Username / Password!");
			echo "<script> window.location='index.php?msg=$msg'; </script>";
			exit();  
		}	
	}else{
		  $msg= base64_encode("Please login to access this page!");
		echo "<script> window.location='index.php?msg=$msg'; </script>";
		exit(); 
	} 
	?>