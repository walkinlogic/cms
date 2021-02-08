<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_GALLERY']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	include_once("includes/thumbnail_images.class.php"); 
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		<div class="container-top"></div>
		<?php 
			if(isset($_POST['addalbum'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$ar_title =cleaninputfield($mysql,$_POST['ar_title']);
				$alttext =cleaninputfield($mysql,$_POST['alttext']);
				$ar_alttext =cleaninputfield($mysql,$_POST['ar_alttext']);
				$image =cleaninputfield($mysql,$_POST['image']);
				$sortorder =cleaninputfield($mysql,$_POST['sortorder']);
				$service_id =cleaninputfield($mysql,$_POST['service_id']); 
				$status = ($_POST['status']) ? 1 : 0;	
				 
				////
				if($_FILES['image']['tmp_name']!=''){
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {	
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 213;
						$obj_img->NewHeight = 146;
						$obj_img->create_thumbnail_images();
					}
				 } // end of image uploading	
				$queryinsert = $mysql->record_insert("album_tbl",array('service_id' => $service_id,'title' => $title,'ar_title' => $ar_title,'alttext' => $alttext,'ar_alttext' => $ar_alttext,'sortorder' => $sortorder,'image' => $imagename,'status' => $status),false);
				if($queryinsert){
					$msg= base64_encode('Album Added Successfully!');
					echo "<script> window.location='album_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='album_list.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updatealbum'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$ar_title =cleaninputfield($mysql,$_POST['ar_title']);
				$alttext =cleaninputfield($mysql,$_POST['alttext']);
				$ar_alttext =cleaninputfield($mysql,$_POST['ar_alttext']);
				$image =cleaninputfield($mysql,$_POST['image']);
				$sortorder =cleaninputfield($mysql,$_POST['sortorder']);
				$service_id =cleaninputfield($mysql,$_POST['service_id']);
				$status = ($_POST['status']) ? 1 : 0;	
				$album_id = $_POST['album_id'];
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
						$obj_img->NewWidth = 213;
						$obj_img->NewHeight = 146;
						$obj_img->create_thumbnail_images();					
					}
				 } /// end of updating image
				$queryupdate = $mysql->record_update("album_tbl",array('service_id' => $service_id,'title' => $title,'ar_title' => $ar_title,'alttext' => $alttext,'ar_alttext' => $ar_alttext,'sortorder' => $sortorder,'image' => $imagename,'status' => $status),"id=$album_id");
				if($queryupdate){
					$msg= base64_encode('Album Updated Successfully!');
					echo "<script> window.location='album_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='album_list.php?msge=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("album_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="album_form" id="album_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add / Edit Album </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="26%"><label for="title">Title</label></td>
					<td width="74%"><input name="title" id="title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['title']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="26%"><label for="title">Title In Arabic</label></td>
					<td width="74%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_title']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr> 	 	
					<td><label for="alt_text">Alt Text </label></td>
					<td><input name="alttext" id="alttext" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['alttext']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr> 	 	
					<td><label for="alt_text">Alt Text In Arabic</label></td>
					<td><input name="ar_alttext" id="ar_alttext" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_alttext']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td><label for="service_id"> Service Name</label></td>
					<td>
						<select name="service_id" id="service_id">
							<option value="0"> &laquo; Service Name &raquo;  </option>
							<?php 
								$rows = $mysql->list_table("services_tbl",false);
								if($mysql->affected_rows>0){
									foreach($rows as $value => $row){ 
										$parent_id = $row['id'];
										 $toplevel_page = stripslashes($row['heading']);
										 
										$sel_1 = ($row['id'] == $postrow['service_id']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo $sel_1; ?>> <?php echo $toplevel_page; ?> </option>			
							<?php 
									}
								}
								?>
						</select>					</td>
				  </tr>
				  <tr>
					<td><label for="sort_order">Sort Order </label></td>
					<td>		
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("album_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
					<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>"/>		</td>
				  </tr>
				  <tr>
					<td><label for="image">Image</label></td>
					<td>&nbsp;<input type="file" name="image" id="image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>
				  	  
				  <tr>
					<td><label for="status">Status</label></td>
					<td><input name="status" id="status" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['status']==1){?> checked="checked" <?php } ?>/></td>
				  </tr>  
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
		if(isset($_GET['args1'])){ ?>
			<input type="hidden" name="album_id" id="album_id" value="<?php echo $postrow['id']; ?>" />
			<input type="hidden" name="updatealbum" id="updatealbum" value="updatealbum" />
			<input name="update" id="update" border="0" type="submit" value="Update Album" class="addpagebtn" />
  <?php }else{ ?>
			<input type="hidden" name="addalbum" id="addalbum" value="addalbum" />
			<input name="add" id="add" border="0" type="submit" value="Add Album" class="addpagebtn" />
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