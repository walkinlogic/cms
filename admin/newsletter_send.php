<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_NEWS']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	if(isset($_GET['args2'])){ 
		$args1=  cleaninputfield($mysql,$_GET['args2']);
		$newsletter = $mysql->fetch_row("newsletters_tbl","id=$args1",array('status' => $args2));
		$config = $mysql->fetch_row("config_tbl",false,array ('range' => '*'));
		$siteOwnersEmail =  $config["adminemail"];
		
		$subscribers = $mysql->list_table("subscription_tbl",false, array ('range' => '*',));
		require_once(dirname(dirname(__FILE__)).'/includes/php-mailer/PHPMailerAutoload.php');
		
		if(is_array($subscribers) && !empty($subscribers)){
			foreach($subscribers as $subscriber){
				$mailto=$subscriber['email'];
				$path=dirname(dirname(__FILE__))."/uploaded/";
				 
				
				
				$to          = $subscriber['email'];; // addresses to email pdf to
				$from        = $siteOwnersEmail; // address message is sent from
				$subject     = $newsletter['heading']." - ebtikaraty.com";; // email subject
				$body        = $newsletter['description'];; // email body
				
				
				
				$mail = new PHPMailer(true);
				$debug = 0;
				$mail->SMTPDebug = $debug;  
	  
				$mail->AddAddress($to);
				
				$mail->SetFrom($from,DOMAIN);
				$mail->AddReplyTo($from,DOMAIN);

				$mail->IsHTML(true);  

				$mail->CharSet = 'UTF-8';

				$mail->Subject = $subject;
				$mail->Body    = $body;
				
				if($newsletter['file']!=''){
					$pdfLocation = $path.$newsletter['file'];  
					$pdfName     = $newsletter['file'];  
					$mail->addAttachment($pdfLocation); 
				}
				$mail->Send();
				
				
				 
			}	 
		}	 
	}	
	  $msg= base64_encode('Newsletter submit Successfully!');
			echo "<script> window.location='newsletter_list.php?msg=$msg';</script>";
			exit();  
	 