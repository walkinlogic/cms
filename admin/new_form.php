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
  order.type = "text"; //Type of field 
  li.appendChild(order);
  
  //create caption field
  var input = document.createElement("input");
  input.id = "cap_"+count;
  input.name ="cap_"+count;
  input.size = "20";
  input.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
  li.appendChild(input);
  //create caption field
  var arinput = document.createElement("input");
  input.id = "arcap_"+count;
  input.name ="arcap_"+count;
  input.size = "20";
  input.type = "text"; //Type of field - can be any valid input type like text,file,checkbox etc.
  li.appendChild(arinput);
  
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
	  	
  li.appendChild(input);
  li.appendChild(selection);
  li.appendChild(valid);
  li.appendChild(input1);
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
	if(isset($_POST['addform'])){
		$title =cleaninputfield($mysql,$_POST['title']);
		$mailto =cleaninputfield($mysql,$_POST['mailto']);
		$mailsubject =cleaninputfield($mysql,$_POST['mailsubject']);
		$buttontext =cleaninputfield($mysql,$_POST['buttontext']);
		$responsetext =cleaninputfield($mysql,$_POST['responsetext']);
		$ar_title = cleaninputfield($mysql,$_POST['ar_title']);
		$ar_responsetext = cleaninputfield($mysql,$_POST['ar_responsetext']);
		$queryinsert = $mysql->record_insert("formconfig_tbl",array('ar_title' => $ar_title,'ar_responsetext' => $ar_responsetext,'title' => $title,'mailto' => $mailto,'mailsubject' => $mailsubject,'buttontext' => $buttontext,'responsetext' => $responsetext),false);
		
		if(isset($queryinsert)){
			$form_id=mysql_insert_id();		
			//delete all fields first
			$caption='';
			$arcaption='';
			$i=0;
			$del=false;
			foreach($_POST as $k=>$v){
			if(strpos($k, "del_")>-1){
				$del=true;
			}	
			if(strpos($k, "order_")>-1){
				$order=$v;
			}	
			if(strpos($k, "cap_")>-1){
				$caption=$v;
			}
			if(strpos($k, "arcap_")>-1){
				$arcaption=$v;
			}	
			if(strpos($k, "type_")>-1){
				$type=$v;
			}
			if(strpos($k, "valid_")>-1){
				$valid=$v;
			}
			if(strpos($k, "option_")>-1){ 
				$option=$v;
				if($del==false){
					$mysql->record_insert("formfields_tbl",array('ar_fieldcaption' => $arcaption,'fieldcaption' => $caption,'fieldtype' => $type,'fieldoption' => $option,'fieldvalid' => $valid,'sortorder' => $order,'form_id' => $form_id),false);	
				}else{
						$del=false;
				}
			}
		}
				$msg=base64_encode("Form Add Successfully");	
				echo "<script> window.location='form_list.php?msg=$msg';</script>";
				exit();		
		}
	}
	?>
		<form action="" method="post" name="new_form" id="new_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add Form </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="20%"><label for="title">Title</label></td>
					<td width="90%"><input name="title" id="title" type="text" /></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="title">Tiltle In Arabic</label></td>
					<td width="80%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['ar_title']); ?>" <?php } ?> /></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="mailto">Mail To </label></td>
					<td width="90%"><input name="mailto" id="mailto" type="text"/></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="mailsubject">Mail Subject</label></td>
					<td width="90%"><input name="mailsubject" id="mailsubject" type="text" /></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="buttontext">Submit button text</label></td>
					<td width="90%"><input name="buttontext" id="buttontext" type="text" /></td>
				  </tr>
				  <tr>
					<td width="20%"><label for="buttontext">Submit button text In Arabic</label></td>
					<td width="80%"><input name="ar_buttontext" id="ar_buttontext" type="text" <?php if(isset($postrow)){ ?> value="<?php echo stripslashes($postrow['ar_buttontext']); ?>" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="20%" valign="top"><label for="responsetext">Autoresponder text </label></td>
					<td width="90%"><textarea name="responsetext" id="responsetext" rows="3"></textarea></td>
				  </tr>
				  <tr>
					<td width="20%" valign="top"><label for="responsetext">Autoresponder text in Arabic</label></td>
					<td width="80%"><textarea name="ar_responsetext" id="ar_responsetext" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_responsetext']); } ?></textarea></td>
				  </tr>
				   <tr>
				     <td colspan="2" align="left">
					 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="addpage">
              <tr>
                <td width="30" align="center"><label>DEL</label></td>
                <td width="50px" align="left"><label>Order</label></td>
                <td width="50px" align="left"><label>Field Caption</label></td>
				<td width="70px" align="left"><label>Arabic Field Caption</label></td>
                <td width="70px" align="left"><label>Field Type</label></td>
                <td width="70px" align="left"><label>Validation</label></td>
                <td width="70px" align="left"><label>Options</label></td>
              </tr>
              <tr>
                <td colspan="6" align="left" class="tiny">
                <ol id="fields_area">
					<li><input type="checkbox" name="del_1" id="del_1" /><input type="text" name="order_1" id="order_1" value="1" size="4" /><input type="text" name="cap_1" id="cap_1" value="" size="20" /><input type="text" name="arcap_1" id="arcap_1" value="" size="20" /><select name="type_1" id="type_1">
							<option value="checkbox" >Checkbox</option>
							<option value="dropdown" >Dropdown List</option>
							<option value="textbox" >Textbox</option>
							<option value="password" >Password</option>
							<option value="textarea" >Textarea</option>
							<option value="radio" >RadioButton</option>
						</select><select name="valid_1" id="valid_1"> <option value="0" >Not Required</option>
			  <option value="1" >Required</option>
			  <option value="2" >Required email</option>
			  </select><input type="text" name="option_1" id="option_1" value="" size="20" /></li></ol> </td>
              </tr>
            </table>					 
			</td>
		     	 </tr>
				  
				   <tr>
					<td align="right" colspan="2"><input type="button" value="Add Field" onclick="addField('fields_area');" class="loginbtns"/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
				  </tr>
			  </table>
		</div>
		<div class="addbtn-right">
		<input type="hidden" name="addform" id="addform" value="addform" />
		<input name="add" id="add" border="0" type="submit" value="Add Form" title="Add Form" class="addpagebtn" />
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