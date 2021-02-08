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
	<script type="text/javascript">
	$(document).ready(function() {
		$("#slide_form").validate();
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
			if(isset($_POST['adds'])){
				$name =cleaninputfield($mysql,$_POST['name']);
				$ar_name =cleaninputfield($mysql,$_POST['ar_name']);
				$meta_title=cleaninputfield($mysql,$_POST['meta_title']);
				$ar_meta_title=cleaninputfield($mysql,$_POST['ar_meta_title']);
				$meta_keyword=cleaninputfield($mysql,$_POST['meta_keyword']);
				$ar_meta_keyword=cleaninputfield($mysql,$_POST['ar_meta_keyword']);
				$meta_desc=cleaninputfield($mysql,$_POST['meta_desc']);
				$ar_meta_desc=cleaninputfield($mysql,$_POST['ar_meta_desc']);
				$sort_order =cleaninputfield($mysql,$_POST['sort_order']);
				$description =cleaninputfield($mysql,$_POST['description']);
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$description2 =cleaninputfield($mysql,$_POST['description2']);
				$ar_description2 =cleaninputfield($mysql,$_POST['ar_description2']);
				$status = ($_POST['status']) ? 1 : 0;	
				if($_FILES['image']['tmp_name']!=''){
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {	
						$imagename = $imagename;
					}
				 } // end of image uploading	
				 if($_FILES['image2']['tmp_name']!=''){
					$imagename2=fileExists($_FILES['image2']['name'],"../uploaded/");
					if(copy($_FILES['image2']['tmp_name'],"../uploaded/".$imagename2)) {	
						$imagename2 = $imagename2;
					}
				 } // end of image uploading	
				$queryinsert = $mysql->record_insert("d_collections_tbl",array('name' => $name,'ar_name' => $ar_name,'meta_title'=>$meta_title,'ar_meta_title'=>$ar_meta_title,'meta_keyword' => $meta_keyword,'ar_meta_keyword' => $ar_meta_keyword,'meta_desc' => $meta_desc,'ar_meta_desc' => $ar_meta_desc,'sort_order' => $sort_order,'image' => $imagename,'image2' => $imagename2,'status' => $status,'description' => $description,'ar_description' => $ar_description,'description2' => $description2,'ar_description2' => $ar_description2),false);
				if($queryinsert){
					$msg= base64_encode('Collection Added Successfully!');
					echo "<script> window.location='d-collections_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='d-collections_list.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updates'])){
				$name =cleaninputfield($mysql,$_POST['name']);
				$ar_name =cleaninputfield($mysql,$_POST['ar_name']);
				$meta_title=cleaninputfield($mysql,$_POST['meta_title']);
				$ar_meta_title=cleaninputfield($mysql,$_POST['ar_meta_title']);
				$meta_keyword=cleaninputfield($mysql,$_POST['meta_keyword']);
				$ar_meta_keyword=cleaninputfield($mysql,$_POST['ar_meta_keyword']);
				$meta_desc=cleaninputfield($mysql,$_POST['meta_desc']);
				$ar_meta_desc=cleaninputfield($mysql,$_POST['ar_meta_desc']);
				$sort_order =cleaninputfield($mysql,$_POST['sort_order']);
				$description =cleaninputfield($mysql,$_POST['description']);
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$description2 =cleaninputfield($mysql,$_POST['description2']);
				$ar_description2 =cleaninputfield($mysql,$_POST['ar_description2']);
				$status = ($_POST['status']) ? 1 : 0;
				$ids = $_POST['ids'];
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);
				if($_FILES['image']['tmp_name']!=''){
					@unlink("../uploaded/$imagename");
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {
						$imagename = $imagename;					
					}
				 } /// end of updating image
				$imagename2 = cleaninputfield($mysql,$_POST['oldimage2']);
				if($_FILES['image2']['tmp_name']!=''){
					@unlink("../uploaded/$imagename2");
					$imagename2=fileExists($_FILES['image2']['name'],"../uploaded/");
					if(copy($_FILES['image2']['tmp_name'],"../uploaded/".$imagename2)) {
						$imagename2 = $imagename2;					
					}
				 } /// end of updating image meta_title
				$queryupdate = $mysql->record_update("d_collections_tbl",array('name' => $name,'ar_name' => $ar_name,'meta_title'=>$meta_title,'ar_meta_title'=>$ar_meta_title,'meta_keyword' => $meta_keyword,'ar_meta_keyword' => $ar_meta_keyword,'meta_desc' => $meta_desc,'ar_meta_desc' => $ar_meta_desc,'sort_order' => $sort_order,'image' => $imagename,'image2' => $imagename2,'status' => $status,'description' => $description,'ar_description' => $ar_description,'description2' => $description2,'ar_description2' => $ar_description2),"id=$ids");
				if($queryupdate){
					$msg= base64_encode('Collection Updated Successfully!');
					echo "<script> window.location='d-collections_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='d-collections_list.php?msge=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("d_collections_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="slide_form" id="slide_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add / Edit Decorative Collection </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="15%"><label for="name">Name</label></td>
					<td width="85%"><input name="name" id="name" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['name']); ?>"<?php } ?> class="required"/></td>
				  </tr>
				  <tr>
					<td width="15%"><label for="ar_name">Name in Arabic</label></td>
					<td width="85%"><input name="ar_name" id="ar_name" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_name']); ?>"<?php } ?> class="required"/></td>
				  </tr>
				<tr>
					<td><label for="meta_title">Meta Title</label></td>
					<td><input name="meta_title" id="meta_title" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['meta_title']); ?>"<?php } ?> /></td>
				</tr>
				<tr>
					<td><label for="ar_meta_title">Meta Title in Arabic</label></td>
					<td><input name="ar_meta_title" id="ar_meta_title" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_meta_title']); ?>"<?php } ?> /></td>
				  </tr>
				<tr>
					<td><label for="meta_keyword">Meta Keyword</label></td>
					<td><input name="meta_keyword" id="meta_keyword" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['meta_keyword']); ?>"<?php } ?> /></td>
				</tr>
				<tr>
					<td><label for="ar_meta_keyword">Meta Keyword in Arabic</label></td>
					<td><input name="ar_meta_keyword" id="ar_meta_keyword" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_meta_keyword']); ?>"<?php } ?> /></td>
				  </tr> 
				<tr>
					<td><label for="meta_desc">Meta Description</label></td>
					<td><input name="meta_desc" id="meta_desc" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['meta_desc']); ?>"<?php } ?> /></td>
				</tr>
				<tr>
					<td><label for="ar_meta_desc">Meta Description in Arabic</label></td>
					<td><input name="ar_meta_desc" id="ar_meta_desc" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_meta_desc']); ?>"<?php } ?> /></td>
				  </tr>
				  <tr>
					<td><label for="sort_order">Sort Order </label></td>
					<td>		
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sort_order'];
						}else{
							$max_value = $mysql->table_max_value("d_collections_tbl","sort_order"); 
							$max_value += 1;
						}
						?>
					<input name="sort_order" id="sort_order" type="text" value="<?php echo $max_value; ?>" class="required" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"/>		</td>
				  </tr>
				  <tr>
					<td><label for="image">Thumbnail Image</label></td>
					<td>&nbsp;<input type="file" name="image" id="image"  <?php  if(!isset($postrow)){?> class="required" <?php } ?> /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> <?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>
				  	<tr>
					<td><label for="image2">Large Image</label></td>
					<td>&nbsp;<input type="file" name="image2" id="image2"  /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage2"  id="oldimage2" value="<?php echo $postrow['image2'] ?>" /> <?php echo "(   $postrow[image2]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>  
				  <tr>
					<td><label for="status">Status</label></td>
					<td>&nbsp;<input name="status" id="status" type="checkbox" value="1" <?php if($postrow['status']==1){?> checked="checked" <?php } ?>/></td>
				  </tr>
				  
				  
				  <tr>
					<td valign="top"><label for="description">Top Text</label></td>
					<td><textarea name="description" id="description" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>
				  </tr> 
				  <tr>
					<td valign="top"><label for="ar_description">Top Text in Arabic</label></td>
					<td><textarea name="ar_description" id="ar_description" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description']); } ?></textarea></td>
				  </tr> 
                   <tr>
					<td valign="top"><label for="description2">Bottom Text</label></td>
					<td><textarea name="description2" id="description2" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['description2']); } ?></textarea></td>
				  </tr>   
				  <tr>
					<td valign="top"><label for="ar_description2">Bottom Text in Arabic</label></td>
					<td><textarea name="ar_description2" id="ar_description2" style="width:97%; height:100px;"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description2']); } ?></textarea></td>
				  </tr>  
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="ids" id="ids" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updates" id="updates" value="updates" />
				<input name="update" id="update" border="0" type="submit" value="Update" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="adds" id="adds" value="adds" />
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
