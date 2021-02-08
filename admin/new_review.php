<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_CUSTOM']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	include_once("includes/thumbnail_images.class.php");      /// thumbnail class
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>	<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>	<script type="text/javascript" src="tiny.js"></script>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		<div class="container-top"></div>
		<?php 
			if(isset($_POST['add'])){
				////
				if($_FILES['image']['tmp_name']!=''){
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
				$title = cleaninputfield($mysql,$_POST['title']);				
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']);
				$link = cleaninputfield($mysql,$_POST['link']);		
				$image = cleaninputfield($mysql,$_POST['image']);
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);												
				$description =cleaninputfield($mysql,$_POST['description']); 
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$queryinsert = $mysql->record_insert("clientreviews_tbl",array('ar_title' => $ar_title,'ar_description' => $ar_description,'description' => $description ,'title' => $title,'link' => $link ,'image' => $imagename,'sortorder' => $sortorder),false);
				if($queryinsert){
					$msg= base64_encode('Custom Image Added Successfully!');
					echo "<script> window.location='client_reviews.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='client_reviews.php?msg=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['update'])){
				$title = cleaninputfield($mysql,$_POST['title']);
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']);
				$link = cleaninputfield($mysql,$_POST['link']);		
				$image = cleaninputfield($mysql,$_POST['image']);
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);								
				$description =cleaninputfield($mysql,$_POST['description']);								
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);				
				$imageid = $_POST['imageid'];
				 
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
				 $description =cleaninputfield($mysql,$_POST['description']);				
				 $ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$queryupdate = $mysql->record_update("clientreviews_tbl",array('ar_description' => $ar_description,'description' => $description ,'title' => $title,'ar_title' => $ar_title,'link' => $link ,'image' => $imagename,'sortorder' => $sortorder),"id=$imageid");
				if($queryupdate){
					$msg= base64_encode('Custom Image Updated Successfully!');
					echo "<script> window.location='client_reviews.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='client_reviews.php?msg=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("clientreviews_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="custom_form" id="custom_form" enctype="multipart/form-data">
		<div class="container">
			<h2>Add / Edit Staff</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="11%"><label for="title">Name</label></td>
					<td width="89%"><input name="title" id="title" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['title']); ?>"<?php } ?>/></td>
				  </tr>
				<tr>
					<td width="11%"><label for="ar_title">Name in Arabic</label></td>
					<td width="89%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_title']); ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
				    <td><label for="link">Link</label></td>
				    <td><input name="link" id="link" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['link']); ?>"<?php } ?>/></td>
		        </tr>
				   <tr>
				     <td><label for="sortorder">Sort Order</label></td>
				     <td><?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("clientreviews_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
				<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>"/></td>
		      </tr>
			  <tr>
					<td width="11%"><label for="image">Image </label></td>
					<td>&nbsp;<input type="file" name="image" id="image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>			<tr>			<td valign="top"><label for="description">Description</label></td>			
				  <td><textarea name="description" id="description" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>
				  </tr> 		  
				  <tr>			
				  <td valign="top"><label for="ar_description">Description in Arabic</label></td>			
				  <td><textarea name="ar_description" id="ar_description" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description']); } ?></textarea></td>
				  </tr>
			  </table>
		</div>		 
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="imageid" id="imageid" value="<?php echo $postrow['id']; ?>" />
				<input name="update" id="update" border="0" type="submit" value="Update" class="addpagebtn" />
	  <?php }else{ ?>
				<input name="add" id="add" border="0" type="submit" value="Add" class="addpagebtn" />
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
