<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_FORM']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
<script type="text/javascript" >
//Add more fields dynamically.
function addField(area) {

 if(!document.getElementById) return; //Prevent older browsers from getting any further.
 var field_area = document.getElementById(area);
 var all_inputs = field_area.getElementsByTagName("input"); //Get all the input fields in the given area.
 //Find the count of the last element of the list. It will be in the format '<field><number>'. If the 
 //  field given in the argument is 'friend_' the last id will be 'friend_4'.
 var last_item = all_inputs.length - 1;
 var last = all_inputs[last_item].id;
 var count = Number(last.split("_")[1]) + 1;
   
 if(document.createElement) { //W3C Dom method.
  var li = document.createElement("li");
  
  //create delete checkbox
  var del = document.createElement("input");
  del.id = "del_"+count;
  del.name ="del_"+count;
  del.type = "checkbox"; //Type of field 
  li.appendChild(del);
    
  //create order field
  var order = document.createElement("input");
  order.id = "order_"+count;
  order.name ="order_"+count;
  order.size = "4";
  order.value = count;
  order.className = "smallfield";
  order.type = "text"; //Type of field 
  li.appendChild(order);
  
  //create caption field
  var input = document.createElement("input");
  input.id = "engcap_"+count;
  input.name ="engcap_"+count;
  input.size = "20";
  input.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
  li.appendChild(input);
  
  //create caption field in Arabic
  var cninput = document.createElement("input");
  cninput.id = "cncap_"+count;
  cninput.name ="cncap_"+count;
  cninput.size = "20";
  cninput.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
  li.appendChild(cninput);
  
  //create input type
  var selection = document.createElement("select");
  selection.id = "type_"+count;
  selection.name = "type_"+count;
 	
	var inputopt1 = document.createElement('option');
	inputopt1.innerHTML = 'Checkbox';
	inputopt1.value = 'checkbox';
	selection.appendChild(inputopt1);
	
	var inputopt2 = document.createElement('option');
	inputopt2.innerHTML = 'Dropdown List';
	inputopt2.value = 'dropdown';
	selection.appendChild(inputopt2);
	
	var inputopt3 = document.createElement('option');
	inputopt3.innerHTML = 'Textbox';
	inputopt3.value = 'textbox';
	selection.appendChild(inputopt3);
	
	var inputopt4 = document.createElement('option');
	inputopt4.innerHTML = 'Password';
	inputopt4.value = 'password';
	selection.appendChild(inputopt4);
	
	var inputopt5 = document.createElement('option');
	inputopt5.innerHTML = 'Textarea';
	inputopt5.value = 'textarea';
	selection.appendChild(inputopt5);
	
	var inputopt6 = document.createElement('option');
	inputopt6.innerHTML = 'RadioButton';
	inputopt6.value = 'radio';
	selection.appendChild(inputopt6);
	
	
 //create validation
  var valid = document.createElement("select");
  valid.id = "valid_"+count;
  valid.name = "valid_"+count;
 	
	var validopt1 = document.createElement('option'); 	
	validopt1.innerHTML = 'Not Required';
	validopt1.value = '0';
	valid.appendChild(validopt1);
	
	var validopt2 = document.createElement('option'); 	
	validopt2.innerHTML = 'Required';
	validopt2.value = '1';
	valid.appendChild(validopt2);
	
	var validopt3 = document.createElement('option'); 	
	validopt3.innerHTML = 'Required email';
	validopt3.value = '2';
	valid.appendChild(validopt3);
	    //create caption field
	  var input1 = document.createElement("input");
	  input1.id = "option_"+count;
	  input1.name ="option_"+count;
	  input1.size = "20";
	  input1.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
	  
	  //create caption field in Arabic
	  var cninput1 = document.createElement("input");
	 cninput1.id = "cnoption_"+count;
	  cninput1.name ="cnoption_"+count;
	  cninput1.size = "20";
	  cninput1.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
	  	
  li.appendChild(input);
  li.appendChild(cninput);
  li.appendChild(selection);
  li.appendChild(valid);
  li.appendChild(input1);
  li.appendChild(cninput1);
  field_area.appendChild(li);
 } else { //Older Method
  alert("Old version");
  //field_area.innerHTML += "<li><input name='cap_"+(count)+"' id='cap_"+(count)+"' type='text' /></li>";
 }
}
</script>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		<div class="container-top"></div>
		<?php 
			if(isset($_POST['updateform'])){
			    $title = cleaninputfield($mysql,$_POST['title']);
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']);
				$mailto = cleaninputfield($mysql,$_POST['mailto']);
				$mailsubject = cleaninputfield($mysql,$_POST['mailsubject']);
				$ar_mailsubject = cleaninputfield($mysql,$_POST['ar_mailsubject']);
				$buttontext = cleaninputfield($mysql,$_POST['buttontext']);
				$ar_buttontext = cleaninputfield($mysql,$_POST['ar_buttontext']); 
				$responsetext = cleaninputfield($mysql,$_POST['responsetext']);
				$ar_responsetext = cleaninputfield($mysql,$_POST['ar_responsetext']);
				$form_id = $_POST['form_id'];
				
				$mysql->record_update("formconfig_tbl",array('title' => $title,'ar_title' => $ar_title,'mailto' => $mailto,'mailsubject' => $mailsubject,'ar_mailsubject' => $ar_mailsubject,'buttontext' => $buttontext,'ar_buttontext' => $ar_buttontext,'responsetext' => $responsetext,'ar_responsetext' => $ar_responsetext),"id=$form_id");
				 
				$mysql->record_delete("formfields_tbl","form_id = $form_id");
				$caption='';
				$del=false;
				foreach($_POST as $k=>$v){
					if(strpos($k, "del_")>-1){
						$del=true;
					}	
					if(strpos($k, "order_")>-1){
						$order=$v;
					}	
					if(strpos($k, "engcap_")>-1){
						$caption=$v;
					}	
					if(strpos($k, "cncap_")>-1){
						$ar_caption=$v;
					}	
					if(strpos($k, "type_")>-1){
						$type=$v;
					}
					if(strpos($k, "valid_")>-1){
						$valid=$v;
					}
					if(strpos($k, "engoption_")>-1){ 
						$option=$v;
					}
					if(strpos($k, "cnoption_")>-1){ 
						$ar_option=$v;
					if($del==false){
							$mysql->record_insert("formfields_tbl",array('fieldcaption' => $caption,'ar_fieldcaption' => $ar_caption,'fieldtype' => $type,'fieldoption' => $option,'ar_fieldoption' => $ar_option,'fieldvalid' => $valid,'sortorder' => $order,'form_id' => $form_id),false);	
							
						}else{
								$del=false;
						}
					}
				}
				$msg=base64_encode("Form Updated Successfully");		
				echo "<script> window.location='form_list.php?msg=$msg';</script>";
				exit();
			}

		if(isset($_GET['args1'])){
			$args1 =cleaninputfield($mysql,$_GET['args1']);
			$postrow = $mysql->fetch_row("formconfig_tbl","id=$args1");
		}
		?>
		<form action="" method="post" name="new_form" id="new_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Edit Form </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="20%"><label for="title">Tiltle</label></td>
					<td width="80%"><input name="title" id="title" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['title']); ?>" <?php } ?> /></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="title">Tiltle In Arabic</label></td>
					<td width="80%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['ar_title']); ?>" <?php } ?> /></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="mailto">Mail To </label></td>
					<td width="80%"><input name="mailto" id="mailto" type="text"<?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['mailto']); ?>" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="mailsubject">Mail Subject</label></td>
					<td width="80%"><input name="mailsubject" id="mailsubject" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['mailsubject']); ?>" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="mailsubject">Mail Subject In Arabic</label></td>
					<td width="80%"><input name="ar_mailsubject" id="ar_mailsubject" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['ar_mailsubject']); ?>" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="buttontext">Submit button text</label></td>
					<td width="80%"><input name="buttontext" id="buttontext" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['buttontext']); ?>" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="buttontext">Submit button text In Arabic</label></td>
					<td width="80%"><input name="ar_buttontext" id="ar_buttontext" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['ar_buttontext']); ?>" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="20%" valign="top"><label for="responsetext">Autoresponder text </label></td>
					<td width="80%"><textarea name="responsetext" id="responsetext" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['responsetext']); } ?></textarea></td>
				  </tr>
                  <tr>
					<td width="20%" valign="top"><label for="responsetext">Autoresponder text in Arabic</label></td>
					<td width="80%"><textarea name="ar_responsetext" id="ar_responsetext" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_responsetext']); } ?></textarea></td>
				  </tr>
				   <tr>
				     <td colspan="2">
					 <table width="830px" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="10px" align="center"><label>DEL </label></td>
                <td width="20px" align="left"><label>Order </label></td>
                <td width="50px" align="left"><label>Field Caption </label></td>
                <td width="50px" align="left"><label>Arabic </label></td>
                <td width="50px" align="left"><label>Field Type </label></td>
                <td width="50px" align="left"><label>Validation </label></td>
                <td width="50px" align="left"><label>Options </label></td>
                <td width="50px" align="left"><label>Arabic </label></td>
              </tr>
              <tr>
                <td colspan="6" align="left" class="tiny">
                <ol id="fields_area">
                        <?php
							$i=1;
							$postfields = $mysql->list_table("formfields_tbl","form_id=$args1",array('sortColumn' => 'sortorder','sortType'=>'ASC'));
							if($mysql->affected_rows>0){
								foreach($postfields as $value => $postfield){
							
									if($postfield['fieldtype']=="checkbox"){
										$sel_1="selected='selected'";
									}else{
										$sel_1="";
									}
									if($postfield['fieldtype']=="dropdown"){
										$sel_2="selected='selected'";
									}else{
										$sel_2="";
									}
									if($postfield['fieldtype']=="textbox"){
										$sel_3="selected='selected'";
									}else{
										$sel_3="";
									}
									if($postfield['fieldtype']=="password"){
										$sel_4="selected='selected'";
									}else{
										$sel_4="";
									}
									if($postfield['fieldtype']=="textarea"){
										$sel_5="selected='selected'";
									}else{
										$sel_5="";
									}
									if($postfield['fieldtype']=="radio"){
										$sel_6="selected='selected'";
									}else{
										$sel_6="";
									}
									
									if($postfield['fieldvalid']==0){
										$sel_a="selected='selected'";
									}else{
										$sel_a="";
									}
									if($postfield['fieldvalid']==1){
										$sel_b="selected='selected'";
									}else{
										$sel_b="";
									}
									if($postfield['fieldvalid']==2){
										$sel_c="selected='selected'";
									}else{
										$sel_c="";
									} ?>
                                    <li><input type="checkbox" name="del_<?php echo $i; ?>" id="del_<?php echo $i; ?>" /><input type="text" name="order_<?php echo $i; ?>" id="order_<?php echo $i; ?>" value="<?php echo $postfield['sortorder']; ?>" class="smallfield" size="4" /><input type="text" name="engcap_<?php echo $i; ?>" id="engcap_<?php echo $i; ?>" value="<?php echo $postfield["fieldcaption"]; ?>" size="20" /><input type="text" name="cncap_<?php echo $i; ?>" id="cncap_<?php echo $i; ?>" value="<?php echo $postfield["ar_fieldcaption"]; ?>" size="20" /><select name="type_<?php echo $i; ?>" id="type_<?php echo $i; ?>">
                                          <option value="checkbox" <?php echo $sel_1; ?> >Checkbox</option>
                                          <option value="dropdown" <?php echo $sel_2; ?> >Dropdown</option>
										  <option value="textbox" <?php echo $sel_3; ?> >Textbox</option>
                                          <option value="password" <?php echo $sel_4; ?> >Password</option>
										  <option value="textarea" <?php echo $sel_5; ?> >Textarea</option>
										  <option value="radio" <?php echo $sel_6; ?> >RadioButton</option>
                                      </select><select name="valid_<?php echo $i; ?>" id="valid_<?php echo $i; ?>">
                                          <option value="0" <?php echo $sel_a; ?> >Not Required</option>
                                          <option value="1" <?php echo $sel_b; ?> >Required</option>
                                          <option value="2" <?php echo $sel_c; ?> >Required email</option>
                                        </select><input type="text" name="engoption_<?php echo $i; ?>" id="engoption_<?php echo $i; ?>" value="<?php echo $postfield['fieldoption']; ?>" size="20" /><input type="text" name="cnoption_<?php echo $i; ?>" id="cnoption_<?php echo $i; ?>" value="<?php echo $postfield['ar_fieldoption']; ?>" size="20" />
                                    </li>
                                    <?php
                                    $i++;
                                }
                            }else{
                            ?>
								<li>
								<input type="checkbox" name="del_1" id="del_1" /><input type="text" name="order_1" id="order_1" value="1" size="4" /><input type="text" name="engcap_1" id="engcap_1" value="" size="20" /><input type="text" name="cncap_1" id="cncap_1" value="" size="20" /><select name="type_1" id="type_1">
									<option value="checkbox" >Checkbox</option>
									<option value="dropdown" >Dropdown List</option>
									<option value="textbox" >Textbox</option>
                                    <option value="password" >Password</option>
									<option value="textarea" >Textarea</option>
									<option value="radio" >RadioButton</option>
								</select><select name="valid_1" id="valid_1">
									<option value="0" >Not Required</option>
									<option value="1" >Required</option>
									<option value="2" >Required email</option>
								</select><input type="text" name="option_1" id="option_1" value="" size="20" />
								</li>
                            <?php
                            	} 
                        		?></ol>   </td>
              </tr>
            </table>			</td>
		     	 </tr>
				  
				   <tr>
					<td colspan="2" align="right"><input type="button" value="Add Field" onclick="addField('fields_area');"  class="loginbtns" />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;</td>
				  </tr>
			  </table>
		</div>
		<div class="addbtn-right">
		<input type="hidden" name="updateform" id="updateform" value="addform" />
		<input type="hidden" value="<?php echo $args1; ?>" id="form_id" name="form_id" />
		<input name="update" id="update" border="0" type="submit" value="Update Form" class="addpagebtn" />
			</div>
		</div>
		</form>	
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
	</div><!--wrap end here-->
</body>
</html>