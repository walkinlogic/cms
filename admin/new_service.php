<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_NEWS']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      
	include_once("../includes/db_wrapper.php"); 
	include_once("includes/utility.php");    		include_once("includes/thumbnail_images.class.php");    
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
	<!-- TinyMCE -->
	<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="tiny.js"></script>
	<!-- /TinyMCE -->
	<!---------Calendar Control------------>
	<link href="calendar/dhtmlgoodies_calendar.css" type="text/css" rel="stylesheet">
	<link href="calendar/CalendarControl.css" type="text/css" rel="stylesheet">
	<script language="JavaScript" type="text/javascript" src="calendar/dhtmlgoodies_calendar.js"></script>
	<script language="JavaScript" src="calendar/calendarcontrol.js"></script>
	<!---------Calendar Control end------------>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		<div class="container-top"></div>
		<?php 
			if(isset($_POST['addservice'])){
				$heading = cleaninputfield($mysql,$_POST['heading']);
				$ar_heading = cleaninputfield($mysql,$_POST['ar_heading']);
				$summary = cleaninputfield($mysql,$_POST['summary']);
				$ar_summary = cleaninputfield($mysql,$_POST['ar_summary']);
				$description = cleaninputfield($mysql,$_POST['description']);
				$ar_description = cleaninputfield($mysql,$_POST['ar_description']);
				$link = cleaninputfield($mysql,$_POST['link']);
				$newsdate = $_POST['newsdate'];
				$status = isset($_POST['status']) ? 1 : 0;								
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);				
				if($_FILES['image']['tmp_name']!=''){					
					@unlink("../uploaded/$oldimage");					
					@unlink("../uploaded/thumbs/$oldimage");					
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");					
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {						
						$obj_img = new thumbnail_images();						
						$obj_img->PathImgOld = "../uploaded/$imagename";						
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";						
						$obj_img->NewWidth = 141;						
						$obj_img->NewHeight = 141;						
						$obj_img->create_thumbnail_images();										
					}				 
				}				 
				$ar_imagename = cleaninputfield($mysql,$_POST['oldar_image']);				
				if($_FILES['ar_image']['tmp_name']!=''){					
					@unlink("../uploaded/$oldimage");					
					@unlink("../uploaded/thumbs/$oldimage");					
					$ar_imagename=fileExists($_FILES['ar_image']['name'],"../uploaded/");					
					if(copy($_FILES['ar_image']['tmp_name'],"../uploaded/".$imagename)) {						
						$obj_img = new thumbnail_images();						
						$obj_img->PathImgOld = "../uploaded/$imagename";						
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";						
						$obj_img->NewWidth = 141;						
						$obj_img->NewHeight = 141;						
						$obj_img->create_thumbnail_images();										
					}				 
				}				 
				$queryinsert = $mysql->record_insert("services_tbl",array('pageid' => $link,'ar_image' => $ar_imagename,'image' => $imagename,'heading' => $heading,'ar_heading' => $ar_heading,'newsdate' => $newsdate,'summary' => $summary,'ar_summary' => $ar_summary,'description' => $description,'ar_description' => $ar_description,'status' => $status),false);
				if($queryinsert){
					$msg= base64_encode('Service Added Successfully!');
					echo "<script> window.location='services_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='services_list.php?msg=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['updateservice'])){
				$heading = cleaninputfield($mysql,$_POST['heading']);
				$ar_heading = cleaninputfield($mysql,$_POST['ar_heading']);
				$summary = cleaninputfield($mysql,$_POST['summary']);
				$ar_summary = cleaninputfield($mysql,$_POST['ar_summary']);
				$description = cleaninputfield($mysql,$_POST['description']);
				$ar_description = cleaninputfield($mysql,$_POST['ar_description']);
				$newsdate = $_POST['newsdate'];
				$status = isset($_POST['status']) ? 1 : 0;
				$link = cleaninputfield($mysql,$_POST['link']);
				$serviceid = $_POST['serviceid'];
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);				
				if($_FILES['image']['tmp_name']!=''){					
					@unlink("../uploaded/$oldimage");					
					@unlink("../uploaded/thumbs/$oldimage");					
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");					
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {						
						$obj_img = new thumbnail_images();						
						$obj_img->PathImgOld = "../uploaded/$imagename";						
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";						
						$obj_img->NewWidth = 141;						
						$obj_img->NewHeight = 141;						
						$obj_img->create_thumbnail_images();										
					}				 
				}		 			
				$ar_imagename = cleaninputfield($mysql,$_POST['oldar_image']);				
				if($_FILES['ar_image']['tmp_name']!=''){					
					@unlink("../uploaded/$oldimage");					
					@unlink("../uploaded/thumbs/$oldimage");					
					$ar_imagename=fileExists($_FILES['ar_image']['name'],"../uploaded/");					
					if(copy($_FILES['ar_image']['tmp_name'],"../uploaded/".$ar_imagename)) {						
						$obj_img = new thumbnail_images();						
						$obj_img->PathImgOld = "../uploaded/$ar_imagename";						
						$obj_img->PathImgNew = "../uploaded/thumbs/$ar_imagename";						
						$obj_img->NewWidth = 141;						
						$obj_img->NewHeight = 141;						
						$obj_img->create_thumbnail_images();										
					}				 
				}
				$queryupdate = $mysql->record_update("services_tbl",array('pageid' => $link,'ar_image' => $ar_imagename,'image' => $imagename,'heading' => $heading,'ar_heading' => $ar_heading,'newsdate' => $newsdate,'summary' => $summary,'ar_summary' => $ar_summary,'description' => $description,'ar_description' => $ar_description,'status' => $status),"id=$serviceid");
				if($queryupdate){
					$msg= base64_encode('Service Updated Successfully!');
					echo "<script> window.location='services_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='services_list.php?msg=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("services_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="news_form" id="news_form"  enctype="multipart/form-data">
		<div class="container">
			<h2>Add / Edit Service</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="11%"><label for="heading">Heading</label></td>
					<td width="89%"><input name="heading" id="heading" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['heading']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="heading">Heading In Arabic</label></td>
					<td width="89%"><input name="ar_heading" id="ar_heading" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_heading']; ?>"<?php } ?>/></td>
				  </tr> 
					 <tr>
				    <td><label for="link">Link</label></td>
				    <td> 
					<select name="link" id="link">
							<option value="0"> &laquo; Parent Page &raquo;  </option>
							<?php 
								$rows = $mysql->list_table("content_tbl","parentpageid=0 and pagestatus = 1");
								if($mysql->affected_rows>0){
									foreach($rows as $value => $row){ 
										$parent_id = $row['id'];
										  if(strlen($row['internal_link'])>0){
												$toplevel_page = stripslashes($row['internal_link']);
											}else{
												$toplevel_page = stripslashes($row['pagename']);
											} 

										$sel_1 = (isset($postrow) && $row['id'] == $postrow['pageid']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo $sel_1; ?>> <?php echo $toplevel_page; ?> </option>			
							<?php 
										   
									}
								}
								?>
						</select>
					
					</td>
		        </tr>
				  <tr>					
				  <td width="11%"><label for="image">Image </label></td>					
				  <td>&nbsp;<input type="file" name="image" id="image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>					</td>				  
				  </tr>					  
				  <tr>					
				  <td width="11%"><label for="image">Arabic Image </label></td>					
				  <td>&nbsp;<input type="file" name="ar_image" id="ar_image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldar_image"  id="oldar_image" value="<?php echo $postrow['ar_image'] ?>" /> <?php echo "(   $postrow[ar_image]   )"; } /// end of the file uploading updation ?>					
				  </td>									  
				  </tr>
				   <tr>
					<td width="11%"><label for="status">Status</label></td>
					<td width="89%"><input name="status" id="status" type="checkbox" <?php if(isset($postrow) && $postrow['status']==1){ ?> checked="checked" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="summary">Summary </label></td>
					<td><textarea name="summary" id="summary" style="width:97%" rows="12"><?php if(isset($postrow)){ echo stripslashes($postrow['summary']); } ?></textarea></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="summary">Summary In Arabic</label></td>
					<td><textarea name="ar_summary" id="ar_summary" style="width:97%" rows="12"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_summary']); } ?></textarea></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="description">Description</label></td>
					<td><textarea name="description" id="description" style="width:97%" rows="18"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>
				  </tr>  
				   <tr>
					<td valign="top"><label for="description">Description In Arabic</label></td>
					<td><textarea name="ar_description" id="ar_description" style="width:97%" rows="18"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description']); } ?></textarea></td>
				  </tr>  
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="serviceid" id="serviceid" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updateservice" id="updateservice" value="updateservice" />
				<input name="update" id="update" border="0" type="submit" value="Update News" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="addservice" id="addservice" value="addservice" />
				<input name="add" id="add" border="0" type="submit" value="Add Service" class="addpagebtn" />
		<?php } ?>
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
