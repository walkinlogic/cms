<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_NEWS']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");       
	include_once("../includes/db_wrapper.php");  
	include_once("includes/utility.php");     
	include_once("includes/thumbnail_images.class.php");    
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
			if(isset($_POST['addlocation'])){
				$name = cleaninputfield($mysql,$_POST['name']);
				$ar_name = cleaninputfield($mysql,$_POST['ar_name']);
				$description = cleaninputfield($mysql,$_POST['description']);
				$ar_description = cleaninputfield($mysql,$_POST['ar_description']);
				$contact = cleaninputfield($mysql,$_POST['contact']);
				$address = cleaninputfield($mysql,$_POST['address']);
				$ar_address = cleaninputfield($mysql,$_POST['ar_address']);
				$weblink = cleaninputfield($mysql,$_POST['weblink']);
				 
				$sort_order = cleaninputfield($mysql,$_POST['sort_order']);
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
				$queryinsert = $mysql->record_insert("tradeshows_tbl",array('ar_image' => $ar_imagename,'image' => $imagename,'name' => $name,'ar_name' => $ar_name,'description'=> $description,'ar_description'=> $ar_description,'contact'=> $contact,'address'=> $address,'ar_address'=> $ar_address ,'weblink'=> $weblink,'sort_order'=>$sort_order,'status'=>$status),false);
				if($queryinsert){
					$msg= base64_encode('Location Added Successfully!');
					echo "<script> window.location='tradeshows_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='tradeshows_list.php?msg=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['update_loc'])){
				$name = cleaninputfield($mysql,$_POST['name']);
				$ar_name = cleaninputfield($mysql,$_POST['ar_name']);
				$description = cleaninputfield($mysql,$_POST['description']);
				$ar_description = cleaninputfield($mysql,$_POST['ar_description']);
				$contact = cleaninputfield($mysql,$_POST['contact']);
				$address = cleaninputfield($mysql,$_POST['address']);
				$ar_address = cleaninputfield($mysql,$_POST['ar_address']);
				$weblink = cleaninputfield($mysql,$_POST['weblink']); 
				$sort_order = cleaninputfield($mysql,$_POST['sort_order']);
				$status = isset($_POST['status']) ? 1 : 0;
				$loc_id = $_POST['loc_id'];
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
				$queryupdate = $mysql->record_update("tradeshows_tbl",array('ar_image' => $ar_imagename,'image' => $imagename,'name' => $name,'ar_name' => $ar_name,'description'=> $description,'ar_description'=> $ar_description,'contact'=> $contact,'address'=> $address,'ar_address'=> $ar_address ,'weblink'=> $weblink,'sort_order'=>$sort_order,'status'=>$status),"id=$loc_id");
				if($queryupdate){
					$msg= base64_encode('Location Updated Successfully!');
					echo "<script> window.location='tradeshows_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='tradeshows_list.php?msg=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("tradeshows_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="news_form" id="news_form"   enctype="multipart/form-data">
		<div class="container">
			<h2>Add / Edit Trade Show</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="11%"><label for="name">Name</label></td>
					<td width="89%"><input name="name" id="name" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['name']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="name">Name In Arabic</label></td>
					<td width="89%"><input name="ar_name" id="ar_name" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_name']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="description">Description</label></td>
					<td><textarea name="description" id="description" style="width:97%" rows="10"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>
				  </tr>  
				   <tr>
					<td valign="top"><label for="description">Description In Arabic</label></td>
					<td><textarea name="ar_description" id="ar_description" style="width:97%" rows="10"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description']); } ?></textarea></td>
				  </tr>
				   <tr>
					<td width="11%"><label for="status">Status</label></td>
					<td width="89%"><input name="status" id="status" type="checkbox" <?php if(isset($postrow) && $postrow['status']==1){ ?> checked="checked" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="contact">Contact</label></td>
					<td width="89%"><input name="contact" id="contact" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['contact']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="address">Address</label></td>
					<td width="89%"><input name="address" id="address" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['address']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="ar_address">Address In Arabic</label></td>
					<td width="89%"><input name="ar_address" id="ar_address" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_address']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="weblink">Web address</label></td>
					<td width="89%"><input name="weblink" id="weblink" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['weblink']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>					
				  <td width="11%"><label for="image">Image </label></td>					
				  <td>&nbsp;<input type="file" name="image" id="image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>					</td>				  
				  </tr>					  
				  <tr>					
				  <td width="11%"><label for="image">Arabic Image </label></td>					
				  <td>&nbsp;<input type="file" name="ar_image" id="ar_image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldar_image"  id="oldar_image" value="<?php echo $postrow['ar_image'] ?>" /> <?php echo "(   $postrow[ar_image]   )"; } /// end of the file uploading updation ?>					
				  </td> 
				  <tr>
					<td width="11%"><label for="sort_order">Sort Order</label></td>
					<td width="89%"><input name="sort_order" id="sort_order" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['sort_order']; ?>"<?php } ?>/></td>
				  </tr>
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="loc_id" id="loc_id" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="update_loc" id="update_loc" value="updateuser" />
				<input name="update" id="update" border="0" type="submit" value="Update Location" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="addlocation" id="addlocation" value="addlocation" />
				<input name="add" id="add" border="0" type="submit" value="Add Location" class="addpagebtn" />
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