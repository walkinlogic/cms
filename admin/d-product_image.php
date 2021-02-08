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
				$sortorder =cleaninputfield($mysql,$_POST['sortorder']);
				$product_id = $_POST['product_id'];
				$status = ($_POST['status']) ? 1 : 0;	
				////
				if($_FILES['image']['tmp_name']!=''){
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {	
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 199;
						$obj_img->NewHeight = 199;
						$obj_img->create_thumbnail_images();
					}
				 } // end of image uploading	
				$queryinsert = $mysql->record_insert("d_product_images_tbl",array('title' => $title,'alttext' => $alttext,'sortorder' => $sortorder,'image' => $imagename,'status' => $status,'product_id' => $product_id),false);
				if($queryinsert){
					$msg= base64_encode('Product Image Added Successfully!');
					echo "<script> window.location='d-product_gallery.php?msg=$msg&product_id=$product_id';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='d-product_gallery.php?msge=$msg&product_id=$product_id';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updateimage'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$alttext =cleaninputfield($mysql,$_POST['alttext']);
				$sortorder =cleaninputfield($mysql,$_POST['sortorder']);
				$product_id = $_POST['product_id'];
				$status = ($_POST['status']) ? 1 : 0;	
				$image_id = $_POST['image_id'];
				//// thumbnails updating
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);
				if($_FILES['image']['tmp_name']!=''){
					@unlink("../uploaded/$imagename");
					@unlink("../uploaded/thumbs/$imagename");
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 199;
						$obj_img->NewHeight = 199;
						$obj_img->create_thumbnail_images();					
					}
				 } /// end of updating image
				$queryupdate = $mysql->record_update("d_product_images_tbl",array('title' => $title,'alttext' => $alttext,'sortorder' => $sortorder,'image' => $imagename,'status' => $status,'product_id' => $product_id),"id=$image_id");
				if($queryupdate){
					$msg= base64_encode('Product Image Updated Successfully!');
					echo "<script> window.location='d-product_gallery.php?msg=$msg&product_id=$product_id';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='d-product_gallery.php?msge=$msg&product_id=$product_id';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args2'])){
				$args2 =cleaninputfield($mysql,$_GET['args2']);
				$postrow = $mysql->fetch_row("d_product_images_tbl","id=$args2");
			}
			?>
		<form action="" method="post" name="gallery_form" id="gallery_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add / Edit Product Gallery Image </h2>
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
					<td><label for="sort_order">Sort Order </label></td>
					<td>		
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("d_product_images_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
					<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>" class="required" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"/>		</td>
				  </tr>
				  <input type="hidden" name="product_id" id="product_id" value="<?php echo $_REQUEST['product_id']; ?>" />
				  <tr>
					<td><label for="image">Image</label></td>
					<td>&nbsp;<input type="file" name="image" id="image" <?php  if(!isset($postrow)){?> class="required" <?php } ?>/><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>					</td>
				  </tr>
				  	  
				  <tr>
					<td><label for="status">Status</label></td>
					<td><input name="status" id="status" type="checkbox" value="1" <?php if($postrow['status']==1){?> checked="checked" <?php } ?>/></td>
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