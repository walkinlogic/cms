<?php 
require_once(dirname(__FILE__)."/includes/config.php");
include_once(dirname(__FILE__)."/includes/db_wrapper.php");
$statusMsg=''; 
$allowed = array('gif', 'png', 'jpg', 'jpeg', 'txt', 'docx', 'doc', 'pdf');
if(strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])){ 
	    $config = $mysql->fetch_row("config_tbl",false,array ('range' => '*'));
		$toemail =  $config["adminemail"];
		 
		$yourbudget = $_POST['yourbudget'];
	    $yourservice = implode(', ',$_POST['yourservice']);
		
		$yourname = $_POST['yourname'];
		$email = $_POST['youremail'];
		$message = $_POST['yourmessage'];
		$yournumber = $_POST['yournumber'];
		
		$subject="Hire Us Request Submitted - ".$_SERVER['HTTP_HOST'];
		
		
		$email_logo = URL."images/logo.png";
		 
		 $email_message = '<div class"email-template" style="margin:0px auto; display:block; width:600px;"><table cellspacing="0" cellpadding="0" border="0">
			<tbody>
			  <tr>
				<td valign="top" align="left">
					
					<table style="border-bottom:1px solid #dae4f5" width="500" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					  <tr>
						<td style="padding:15px;background:#f8f8f9" valign="middle" bgcolor="#fff" align="left"><img alt="NovateUS" src="'.$email_logo.'" class="CToWUd" height="30"></td>
					  </tr>
					</tbody>
				  </table></td>
			  </tr>
			  <tr>
				<td valign="top" align="left">
					<table width="500" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFF">
					<tbody>
					  <tr>
						<td style="font-family:Arial;font-size:14px"><table style="background:#f1f2f3" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
							  <tr>
								<th colspan="2" style="padding:15px;text-align:center" align="center">Hire us</th>
							  </tr>
							  <tr>
								<td style="padding:10px"><strong>Service:</strong></td>
								<td style="padding:10px">'.$yourservice.'</td>
							  </tr>
							  <tr>
								<td style="padding:10px"><strong>Budget in USD:</strong></td>
								<td style="padding:10px">'.$yourbudget.'</td>
							  </tr>
							 
							  <tr>
								<td style="padding:10px"><strong>Full Name:</strong></td>
								<td style="padding:10px">'.$yourname.'</td>
							  </tr>
							  <tr>
								<td style="padding:10px"><strong>Email:</strong></td>
								<td style="padding:10px"><a href="mailto:'.$email.'" target="_blank">'.$email.'</a></td>
							  </tr>
							  <tr>
								<td style="padding:10px"><strong>Phone:</strong></td>
								<td style="padding:10px">'.$yournumber.'</td>
							  </tr>
							  <tr>
								<td style="padding:10px"><strong>Message:</strong></td>
								<td style="padding:10px">'.$message.'</td>
							  </tr>
							  <tr>
								<td colspan="2" style="padding:8px;text-align:center" align="center"></td>
							  </tr>
							</tbody>
						  </table></td>
					  </tr>
					</tbody>
				  </table></td>
			  </tr>
			</tbody> 
	</table></div>';
 
		  
	 
		
		
		 
		 
		
		try {
			require_once(dirname(__FILE__).'/includes/php-mailer/PHPMailerAutoload.php');
			$mail = new PHPMailer(true);
			$debug = 0;
			$mail->SMTPDebug = $debug;  
  
			$mail->AddAddress($toemail);  
			$mail->SetFrom('info@'.$_SERVER['HTTP_HOST'],$_SERVER['HTTP_HOST']);
			$mail->AddReplyTo($email, $yourname);

			$mail->IsHTML(true);  

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $email_message;
			
			if($_FILES["yourfile"]["name"]!= ""){
		
				$filename = $_FILES['yourfile']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if (in_array($ext, $allowed)) { 
					$file_tmp  = $_FILES['yourfile']['tmp_name'];
					$strFilesName = time().$_FILES["yourfile"]["name"];  
					/* $strContent = chunk_split(base64_encode(file_get_contents($_FILES["yourfile"]["tmp_name"])));   */
					move_uploaded_file($file_tmp, dirname(__FILE__)."/uploaded/".$strFilesName);
					$mail->addAttachment(dirname(__FILE__)."/uploaded/".$strFilesName);  
				} 
			}
			
			
			
			$mail->Send();
			if(isset($strFilesName)){
				unlink(dirname(__FILE__)."uploaded/".$strFilesName);
			}
			
			$arrResult = "Email send successfully";
		
		} catch (phpmailerException $e) {
			$arrResult = $e->errorMessage();
		} catch (Exception $e) {
			$arrResult = $e->getMessage();
		}
		 
		echo $arrResult;
}else{
	header('location: '.URL.'/');
}

?>