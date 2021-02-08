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
	include_once("includes/resize-class.php"); 
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#gallery_form").validate();
	});
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
			if(isset($_POST['addimage'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$alttext =cleaninputfield($mysql,$_POST['alttext']);
				$image =cleaninputfield($mysql,$_POST['image']);
				$sortorder =cleaninputfield($mysql,$_POST['sortorder']);
				$youtube =cleaninputfield($mysql,$_POST['youtube']);
				$album_id = $_POST['album_id'];
				$status = ($_POST['status']) ? 1 : 0;	
				////
				if($_FILES['image']['tmp_name']!=''){
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {	
						$resizeObj = new resize("../uploaded/$imagename");
						$resizeObj -> resizeImage(674, 450, 'auto');
						$resizeObj -> saveImage("../uploaded/thumbs/$imagename", 100);
						
						$resizeObj = new resize("../uploaded/$imagename");
						$resizeObj -> resizeImage(169, 148, 'crop');
						$resizeObj -> saveImage("../uploaded/minthumbs/$imagename", 100);
						
						$resizeObj = new resize("../uploaded/$imagename");
						$resizeObj -> resizeImage(115, 80, 'crop');
						$resizeObj -> saveImage("../uploaded/smallthumbs/$imagename", 100);
					}
				 } // end of image uploading	
				$queryinsert = $mysql->record_insert("images_tbl",array('title' => $title,'alttext' => $alttext,'sortorder' => $sortorder,'youtube' => $youtube,'image' => $imagename,'status' => $status,'album_id' => $album_id),false);
				if($queryinsert){
					$msg= base64_encode('Gallery Image Added Successfully!');
					echo "<script> window.location='gallery.php?msg=$msg&args1=$album_id';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='gallery.php?msge=$msg&args1=$album_id';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updateimage'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$alttext =cleaninputfield($mysql,$_POST['alttext']);
				$image =cleaninputfield($mysql,$_POST['image']);
				$sortorder =cleaninputfield($mysql,$_POST['sortorder']);
				$youtube =cleaninputfield($mysql,$_POST['youtube']);
				$album_id = $_POST['album_id'];
				$status = ($_POST['status']) ? 1 : 0;	
				$image_id = $_POST['image_id'];
				//// thumbnails updating
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);
				if($_FILES['image']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					@unlink("../uploaded/minthumbs/$oldimage");
					@unlink("../uploaded/smallthumbs/$oldimage");
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {
						$resizeObj = new resize("../uploaded/$imagename");
						$resizeObj -> resizeImage(674, 450, 'auto');
						$resizeObj -> saveImage("../uploaded/thumbs/$imagename", 100);
						
						$resizeObj = new resize("../uploaded/$imagename");
						$resizeObj -> resizeImage(169, 148, 'crop');
						$resizeObj -> saveImage("../uploaded/minthumbs/$imagename", 100);
						
						$resizeObj = new resize("../uploaded/$imagename");
						$resizeObj -> resizeImage(115, 80, 'crop');
						$resizeObj -> saveImage("../uploaded/smallthumbs/$imagename", 100);			
					}
				 } /// end of updating image
				$queryupdate = $mysql->record_update("images_tbl",array('title' => $title,'alttext' => $alttext,'sortorder' => $sortorder,'youtube' => $youtube,'image' => $imagename,'status' => $status,'album_id' => $album_id),"id=$image_id");
				if($queryupdate){
					$msg= base64_encode('Gallery Image Updated Successfully!');
					echo "<script> window.location='gallery.php?msg=$msg&args1=$album_id';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='gallery.php?msge=$msg&args1=$album_id';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args2'])){
				$args2 =cleaninputfield($mysql,$_GET['args2']);
				$postrow = $mysql->fetch_row("images_tbl","id=$args2");
			}
			?>
		<form action="" method="post" name="gallery_form" id="gallery_form" enctype="multipart/form-data" >
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
					<td width="74%"><input name="title" id="title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['title']; ?>"<?php } ?> class="required"/></td>
				  </tr>
				  <tr> 	 	
					<td><label for="alt_text">Alt Text </label></td>
					<td><input name="alttext" id="alttext" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['alttext']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr> 	 	
					<td><label for="alt_text">Link </label></td>
					<td><input name="youtube" id="youtube" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['youtube']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td><label for="sort_order">Sort Order </label></td>
					<td>		
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("images_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
					<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>" class="required" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"/>		</td>
				  </tr>
				  <tr>
				    <td><label for="sort_order">Album Name </label></td>
				    <td>
					<select name="album_id" id="album_id">
					<option value="0"> Select Album </option>
					<?php 
						if(isset($_GET['args1'])){
							$args1 = $_GET['args1'];
						}else{
							$args1="";
						}
						$postrows2 = $mysql->list_table("album_tbl ",false,array('sortColumn' => 'sortorder','sortType'=>'ASC'));
						if($mysql->affected_rows > 0){
							foreach($postrows2 as $value => $postrow2){
							$sel_1=($postrow2['id']==$args1)? "selected='selected'" : "";
						?>
					<option value="<?php echo $postrow2['id']; ?>" <?php echo $sel_1; ?> > <?php echo $postrow2['title']; ?> </option>
					<?php 
							}
						} 
						?></select></td>
		      </tr>
				  <tr>
					<td><label for="image">Image</label></td>
					<td>&nbsp;<input type="file" name="image" id="image" <?php  if(!isset($postrow)){?> class="required" <?php } ?>/><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>					</td>
				  </tr>
				  	  
				  <tr>
					<td><label for="status">Status</label></td>
					<td><input name="status" id="status" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['status']==1){?> checked="checked" <?php } ?>/></td>
				  </tr>  
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
		if(isset($_GET['args2'])){ ?>
			<input type="hidden" name="image_id" id="image_id" value="<?php echo $postrow['id']; ?>" />
			<input type="hidden" name="updateimage" id="updateimage" value="updateimage" />
			<input name="update" id="update" border="0" type="submit" value="Update Image" class="addpagebtn" />
  <?php }else{ ?>
			<input type="hidden" name="addimage" id="addimage" value="addimage" />
			<input name="add" id="add" border="0" type="submit" value="Add Image" class="addpagebtn" />
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