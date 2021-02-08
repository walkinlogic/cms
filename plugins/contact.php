<?php
	$config = $mysql->fetch_row("formconfig_tbl","id ='$isform'",array ('range' => '*'));
	$mailto = $config["mailto"];
	$subject =$config[$pre."mailsubject"];     //get company info (this is hard coded) change to what you need
	$companyName = $config[$pre."title"];  //change to your company name 
	$btntext=$config[$pre.'buttontext'];
	
	if(isset($_POST['bform'])){
		
		  if(strpos($_SERVER['HTTP_REFERER'],DOMAIN)){  
			$current_time = strftime("Request was sent on %B %d, at %H:%M%p "); 	
			$from=$mailto; 
			$msg ="This is an automated response sent from the " . $companyName . " web site" . "<br />" .$current_time . "<br />" ."<br />"."Client Submitted the Following Information "."<br />"."-------------------------------START------------------------------" . "<br />" ."<br />" .
		"--------------------Submitted Info----------------------" . "<br />" . "<br />" ;
			foreach($_POST as $k=>$v){
				if(!($k=='bform' ||  $k=='Submit_x' || $k=='Submit_y'))
					$msg.=$k."  ----   ".$v."<br />";
			}
		  
			
			try {
				require_once(dirname(dirname(__FILE__)).'/includes/php-mailer/PHPMailerAutoload.php');
				
				$mail = new PHPMailer(true);
				$debug = 0;
				$mail->SMTPDebug = $debug;  
	  
				$mail->AddAddress($mailto);
				
				$mail->SetFrom('info@'.DOMAIN,DOMAIN); 

				$mail->IsHTML(true);  

				$mail->CharSet = 'UTF-8';

				$mail->Subject = $subject;
				$mail->Body    = $msg;
				$mail->Send(); 
				if($pre==''){$arrResult = "We will contect you soon";}else{$arrResult = "سوف نتصل بك قريبا";}
				 
				
			} catch (phpmailerException $e) {
				$arrResult = $e->errorMessage();
			} catch (Exception $e) {
				$arrResult = $e->getMessage();
			} 
				?>
		<div id="design-contact" class="designcontact">	
			<div class="contact__line"></div>
			<div class="container">
				<div class="row">	
					<div class="col-md-10 col-md-offset-1 animate-box">
						<?php echo $config[$pre."responsetext"]; ?>
					</div>
				</div>
			</div>	
		</div>		
		<?php  }  

	 
 		}else{
 			?>
	<?php 
	$i=1;
	$validjs=''; 
	$fieldsrow = $mysql->list_table("formfields_tbl"," form_id='$isform' ",array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
	if($mysql->affected_rows>0){
	?>	
	 
	<div id="design-contact" class="designcontact">	
		<div class="contact__line"></div>
	<div class="container">
		<div class="row">		
			<div class="col-md-10 col-md-offset-1 animate-box">
				<h2 class="text-center"><?php echo $companyName;?></h2>
				<p class="text-center"><?php if($pre==''){?>Ask your question | Tell us your story | Get Help<?php }else{?>اطرح سؤالك | أخبرنا قصتك | احصل على مساعدة<?php }?></p>
				<form method="post" class="node-webform" name="contactform" id="contactform" action="" >
					<div class="row form-group">
					<?php  
					foreach($fieldsrow as $fieldrow){
						$fieldname=str_replace(" ","_",$fieldrow[$pre."fieldcaption"]);
						$caption=$fieldrow[$pre."fieldcaption"];	
						if($fieldrow["fieldvalid"]=="1"){
							$validjs .="frmvalidator.addValidation(\"$fieldname\",\"req\",\"$caption is a required field\");\n";
						} 
						if($fieldrow["fieldvalid"]=="2"){
							$validjs .="frmvalidator.addValidation(\"$fieldname\",\"req\",\"$caption is a required field\");\n";
							$validjs .="frmvalidator.addValidation(\"$fieldname\",\"email\");\n";
						}
						?>
						
						
						<div class="col-md-6">
							<label for="<?php echo $fieldname; ?>"><?php echo $caption; ?></label>
							<?php 
							if($fieldrow['fieldtype']=="checkbox"){ 
								$check_val=explode(",",$fieldrow[$pre.'fieldoption']);
								if(isset($check_val)){ 
									foreach($check_val as $val){ ?>
									<input class="form-control" <?php if($fieldrow["fieldvalid"]=="1"){ ?>required<?php }?> name="<?php echo $val; ?>" id="<?php echo $val; ?>" type="checkbox" value="Yes" /><label for="<?php echo $val; ?>"><?php echo $val; ?></label><br />
							<?php	
									}
								}
							}
							if($fieldrow['fieldtype']=="dropdown"){ 
								$options_val=explode(",",$fieldrow[$pre.'fieldoption']); 
							?>
								<select class="form-control" <?php if($fieldrow["fieldvalid"]=="1"){ ?>required<?php }?> name="<?php echo $fieldname; ?>" id="<?php echo $fieldname; ?>" >
								<?php 
									if(isset($options_val)){ 
										foreach($options_val as $option_val){?>
									<option value="<?php echo $option_val; ?>"><?php echo $option_val; ?></option>
								<?php
										} 
									}?>
								</select>
							<?php 
							}
							
							if($fieldrow['fieldtype']=="textbox"){ ?>
								 <input  class="form-control"  <?php if($fieldrow["fieldvalid"]=="1"){ ?>required<?php }?> name="<?php echo $fieldname; ?>" id="<?php echo $fieldname; ?>" type="text"    />
							<?php 	 
							}
							if($fieldrow['fieldtype']=="password"){ ?>
								 <input class="form-control"  <?php if($fieldrow["fieldvalid"]=="1"){ ?>required<?php }?> name="<?php echo $fieldname; ?>" id="<?php echo $fieldname; ?>" type="password"  />
							<?php 	 
							}
							if($fieldrow['fieldtype']=="textarea"){ ?>
								 <textarea class="form-control" <?php if($fieldrow["fieldvalid"]=="1"){ ?>required<?php }?> name="<?php echo $fieldname; ?>" id="<?php echo $fieldname; ?>"  ></textarea> 
							<?php
							}
							if($fieldrow['fieldtype']=="radio"){ 
								$groups_val=explode(",",$fieldrow[$pre.'fieldoption']); 
								if(isset($groups_val)){ 
									foreach($groups_val as $group_val){ ?>
							   <input name="<?php echo $fieldname; ?>" <?php if($fieldrow["fieldvalid"]=="1"){ ?>required<?php }?> type="radio" value="<?php echo $group_val; ?>" id="<?php echo $group_val; ?>" class="form-control" /> <label for="<?php echo $group_val; ?>"><?php echo $group_val; ?></label><br />
								<?php
									}
								}
							}
							?>
						</div> 	
						<?php }  ?>
					</div>	
					
					<div class="form-group">
						<input type="hidden" name="bform" value="bform" /> 
						<input type="submit" value="<?php echo $btntext;?>" class="btn btn-primary btn-border">
					</div>
					
				</form>
			</div>
		</div>	
	</div>
</div>		
	<?php } ?>	
<?php } ?>	 