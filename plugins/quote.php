<div id="quote-contact" class="designcontact">	
	<div class="contact__line"></div>
	<div class="container"> 
		<div class="row"> 
		  <div class="col-md-12">
			<h2 class="text-center"><?php if($pre==''){?>Get Free Quote<?php }else{?>احصل على عرض أسعار مجاني<?php }?></h2>
			<p class="text-center"><?php if($pre==''){?>Ask your question | Tell us your story | Get Help<?php }else{?>اطرح سؤالك | أخبرنا قصتك | احصل على مساعدة<?php }?></p>
		  </div>
		  <form method="post" class="node-webform" name="quoteform" id="quoteform" action="" >
		  <?php 
		  if(isset($_POST['quotaform'])){
				$config = $mysql->fetch_row("config_tbl",false,array ('range' => '*'));
				 
			    $siteOwnersEmail =  $config["adminemail"];
				
				$name = trim(stripslashes($_POST['name']));
				$email = trim(stripslashes($_POST['email']));
				$subject = "Get A Quote";
				$contact_message = trim(stripslashes($_POST['message']));
				$callbacktime = trim(stripslashes($_POST['callbacktime']));
				$phone = trim(stripslashes($_POST['phone']));
				$service = trim(stripslashes($_POST['service']));

				// Check Name
				if (strlen($name) < 2) {
					$error['name'] = "Please enter your name.";
				}
				// Check Email
				if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
					$error['email'] = "Please enter a valid email address.";
				}
				// Check Message
				if (strlen($contact_message) < 15) {
					$error['message'] = "Please enter your message. It should have at least 15 characters.";
				}
				// Subject
				if ($subject == '') { $subject = "Contact Form Submission"; }


				// Set Message
				$message .= "Email from: " . $name . "<br />";
				$message .= "Email address: " . $email . "<br />";
				$message .= "Phone: " . $phone . "<br />";
				$message .= "Callback Time: " . $callbacktime . "<br />";
				$message .= "Service: " . $service . "<br />";
				$message .= "Message: <br />";
				$message .= $contact_message;
				$message .= "<br /> ----- <br /> This email was sent from your site's get a free quote form. <br />";

				// Set From: header
				$from =  $name . " <" . $email . ">";

				// Email Headers
				$headers = "From: " . $from . "\r\n";
				$headers .= "Reply-To: ". $email . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	
				if (!isset($error)) {
					try {
						
						require_once(dirname(dirname(__FILE__)).'/includes/php-mailer/PHPMailerAutoload.php');
					 
						$mail = new PHPMailer(true);
						$debug = 0;
						$mail->SMTPDebug = $debug;  
					 
						$mail->AddAddress($siteOwnersEmail);  
						$mail->SetFrom('info@'.DOMAIN,DOMAIN);
						$mail->AddReplyTo($email, $name);

						$mail->IsHTML(true);  

						$mail->CharSet = 'UTF-8';

						$mail->Subject = $subject;
						$mail->Body    = $message;
						$mail->Send();
						$arrResult = "Email send successfully";
						if($pre==''){$arrResult = "We will contect you soon";}else{$arrResult = "سوف نتصل بك قريبا";}
						
						/* ini_set("sendmail_from", $siteOwnersEmail); // for windows server
						$mail = mail($siteOwnersEmail, $subject, $message, $headers); */
						
					} catch (phpmailerException $e) {
						$arrResult = $e->errorMessage();
					} catch (Exception $e) {
						$arrResult = $e->getMessage();
					}
					
					echo '<p class="text-center">';
					echo $arrResult;
					echo '</p>';
				}else {

					$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
					$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
					$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
					echo '<p class="text-center">';
					echo $response;
					echo '</p>';
				}
		  }else{
		  ?>
		  
		  <div class="col-md-12">
			<div class="row"> 
				<div class="col-md-6">
					<div class="form-group">
					  <label class="form-label" for="name"><?php if($pre==''){?>Your Name<?php }else{?>اسمك<?php }?>:</label>
					  <input class="form-control" data-label="Name" required="" data-msg="Please enter name." type="text" name="name" id="name" placeholder="Enter your name" aria-required="true">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					  <label class="form-label" for="email"><?php if($pre==''){?>Your Email<?php }else{?>البريد الإلكتروني<?php }?>:</label>
					  <input class="form-control" data-label="Email" required="" data-msg="Please enter Email." type="text" name="email" id="email" placeholder="Enter your Email" aria-required="true">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					  <label class="form-label" for="phone"><?php if($pre==''){?>Your Phone Number<?php }else{?>رقم تليفونك<?php }?>:</label>
					  <input class="form-control" data-label="Phone" required="" data-msg="Please enter name." type="text" name="phone" id="phone" placeholder="Enter Your Phone Number" aria-required="true">
					</div>
				</div>
				<div class="col-md-6">	
					<div class="form-group">
					  <label class="form-label" for="name"><?php if($pre==''){?>Callback Timing<?php }else{?>توقيت رد الاتصال<?php }?>:</label>
					  <select class="form-control" name="callbacktime" data-label="Callback Timing" required="" data-msg="Please select Callback Timing.">
						<option value="">Please Select</option>
					 <?php 
						$time = new DateTime('09:00');
						$close = new DateTime('18:00');
						while ($time < $close) {
							$day[] = $time->format('H:i');
							?>
							<option value="<?php echo $time->format('H:i');; ?>"><?php echo $time->format('H:i');; ?></option>
							<?php
							$time->modify('+15 minutes');  
						}
					 ?>
					 </select>
					</div>
				</div>
				<div class="col-md-6">	
					<?php 
					$services = $mysql->list_table("services_tbl","status = '1'", array ('range' => '*','sortColumn'=>$pre."heading",'sortType'=>'ASC'));
					?>
					<div class="form-group">
					  <label class="form-label" for="name"><?php if($pre==''){?>Service<?php }else{?>الخدمات<?php }?>:</label>
					  <?php if(is_array($services)){?>
						<select class="form-control" name="service" data-label="Service" required="" data-msg="Please select Service.">
							<option value="">Please Select</option>
							<?php foreach($services as $servicepost){  ?>
								<option value="<?php echo $servicepost[$pre."heading"]; ?>"><?php echo $servicepost[$pre."heading"]; ?></option>
							<?php } ?>
						</select>
					  <?php } ?>
					</div>
				</div> 
			</div>	
			<div class="form-group">
			  <label class="form-label" for="message"><?php if($pre==''){?>Additional Details<?php }else{?>تفاصيل اضافية<?php }?>:</label>
			  <textarea class="form-control" data-label="Message" required="" data-msg="Please enter your message." name="message" id="message" placeholder="Ener Any Additional Details" cols="30" rows="10" aria-required="true"></textarea>
			</div>
			<input type="hidden" name="quotaform" value="quotaform" /> 
			<button type="submit" class="btn btn-primary btn-border"><?php if($pre==''){?>Get My Quote<?php }else{?>احصل على اقتباس الخاص بي<?php }?></button>
			<p class="three"><?php if($pre==''){?>*Your details are kept confidential<?php }else{?>* التفاصيل الخاصة بك تبقى سرية<?php }?></p>
		  </div>
		  </form>
		  <?php } ?> 
		</div>
	</div>
</div>
