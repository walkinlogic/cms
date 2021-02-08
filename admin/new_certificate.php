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
				 } // end of image uploading

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
				 } /// end of updating image
				
				 //// thumbnails updating
				$pdffilename = cleaninputfield($mysql,$_POST['oldpdffile']);
				if($_FILES['pdffile']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$pdffilename=fileExists($_FILES['pdffile']['name'],"../uploaded/");
					if(copy($_FILES['pdffile']['tmp_name'],"../uploaded/".$imagename)) {
						 					
					}
				 }
				 $ar_pdffilename = cleaninputfield($mysql,$_POST['oldar_pdffile']);
				if($_FILES['ar_pdffile']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$ar_pdffilename=fileExists($_FILES['ar_pdffile']['name'],"../uploaded/");
					if(copy($_FILES['ar_pdffile']['tmp_name'],"../uploaded/".$imagename)) {
						 					
					}
				 } /// end of updating image

				 
				$title = cleaninputfield($mysql,$_POST['title']);
				$link = cleaninputfield($mysql,$_POST['link']);		
				$image = cleaninputfield($mysql,$_POST['image']);
				$download_art_value = cleaninputfield($mysql,$_POST['download_art_value']);
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);								
				$description =cleaninputfield($mysql,$_POST['description']);				
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']);
				$queryinsert = $mysql->record_insert("certificates_tbl",array('download_art_value' => $download_art_value,'ar_files' => $ar_pdffilename,'files' => $pdffilename,'ar_title' => $ar_title,'ar_description' => $ar_description,'description' => $description ,'title' => $title,'link' => $link ,'image' => $imagename,'ar_image' => $ar_imagename,'sortorder' => $sortorder),false);
				if($queryinsert){
					$msg= base64_encode('Custom certificate Added Successfully!');
					echo "<script> window.location='certificates.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='certificates.php?msg=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['update'])){
				$title = cleaninputfield($mysql,$_POST['title']);
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']);
				$link = cleaninputfield($mysql,$_POST['link']);		
				$image = cleaninputfield($mysql,$_POST['image']);
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);
				
				$download_art_value = cleaninputfield($mysql,$_POST['download_art_value']);
				
				$description =cleaninputfield($mysql,$_POST['description']);				
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				
				$imageid = $_POST['imageid'];
				//// thumbnails updating
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
				 
				 //// thumbnails updating
				$pdffilename = cleaninputfield($mysql,$_POST['oldpdffile']);
				if($_FILES['pdffile']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$pdffilename=fileExists($_FILES['pdffile']['name'],"../uploaded/");
					if(copy($_FILES['pdffile']['tmp_name'],"../uploaded/".$imagename)) {
						 					
					}
				 }
				 $ar_pdffilename = cleaninputfield($mysql,$_POST['oldar_pdffile']);
				if($_FILES['ar_pdffile']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$ar_pdffilename=fileExists($_FILES['ar_pdffile']['name'],"../uploaded/");
					if(copy($_FILES['ar_pdffile']['tmp_name'],"../uploaded/".$imagename)) {
						 					
					}
				 } /// end of updating image


				 $description =cleaninputfield($mysql,$_POST['description']);				
				 $ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$queryupdate = $mysql->record_update("certificates_tbl",array('download_art_value' => $download_art_value,'ar_files' => $ar_pdffilename,'files' => $pdffilename,'ar_description' => $ar_description,'description' => $description ,'title' => $title,'ar_title' => $ar_title,'link' => $link ,'ar_image' => $ar_imagename,'image' => $imagename,'sortorder' => $sortorder),"id=$imageid");
				if($queryupdate){
					$msg= base64_encode('Custom certificate Updated Successfully!');
					echo "<script> window.location='certificates.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='certificates.php?msg=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("certificates_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="custom_form" id="custom_form" enctype="multipart/form-data">
		<div class="container">
			<h2>Add / Edit Downloads</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="11%"><label for="title">Title</label></td>
					<td width="89%"><input name="title" id="title" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['title']); ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="ar_title">Title in Arabic</label></td>
					<td width="89%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_title']); ?>"<?php } ?>/></td>
				  </tr>
				  
				  <tr>
					<td width="11%"><label for="ar_title">Title in Arabic</label></td>
					<td width="89%">
						<select id="download_art_value" name="download_art_value" class="form-select">
							<option value="All" selected="selected">- please choose -</option>
							<option value="0" <?php if(isset($postrow) && $postrow['download_art_value']==0){?> selected <?php } ?>>Image Brochure</option>
							<option value="1" <?php if(isset($postrow) && $postrow['download_art_value']==1){?> selected <?php } ?>>Screening Machines</option>
							<option value="2" <?php if(isset($postrow) && $postrow['download_art_value']==2){?> selected <?php } ?>>Dryer Systems</option>
							<option value="3" <?php if(isset($postrow) && $postrow['download_art_value']==3){?> selected <?php } ?>>Other</option>
						</select>
					</td>
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

										$sel_1 = ($row['id'] == $postrow['link']) ? "selected='selected'" : "";
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
				     <td><label for="sortorder">Sort Order</label></td>
				     <td><?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("certificates_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
				<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>"/></td>
		      </tr>
				<tr>
					<td width="11%"><label for="image">Image </label></td>
					<td>&nbsp;<input type="file" name="image" id="image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>	
				  <tr>
					<td width="11%"><label for="image">Arabic Image </label></td>
					<td>&nbsp;<input type="file" name="ar_image" id="ar_image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldar_image"  id="oldar_image" value="<?php echo $postrow['ar_image'] ?>" /> <?php echo "(   $postrow[ar_image]   )"; } /// end of the file uploading updation ?>
					</td>
					
				  </tr>
				  <tr>
					<td width="11%"><label for="image">PDF File </label></td>
					<td>&nbsp;<input type="file" name="pdffile" id="pdffile" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldpdffile" value="<?php echo $postrow['files'] ?>" /> <?php echo "(   $postrow[files]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>	
				  <tr>
					<td width="11%"><label for="image">Arabic Image </label></td>
					<td>&nbsp;<input type="file" name="ar_pdffile" id="ar_pdffile" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldar_pdffile"  id="oldar_image" value="<?php echo $postrow['ar_files'] ?>" /> <?php echo "(   $postrow[ar_files]   )"; } /// end of the file uploading updation ?>
					</td>
					
				  </tr>
				  
				  <tr>			<td valign="top"><label for="description">Top Text</label></td>			
					<td><textarea name="description" id="description" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>		  </tr> 		  <tr>			<td valign="top"><label for="ar_description">Top Text in Arabic</label></td>			<td><textarea name="ar_description" id="ar_description" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description']); } ?></textarea></td>		  </tr>
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
