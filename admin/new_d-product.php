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
	<!--<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="tiny.js"></script>-->
	<!-- /TinyMCE -->
	<script type="text/javascript">
	$(document).ready(function() {
		$("#slide_form").validate();
	});
	</script>
	<!-- TinyMCE -->
	<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="tiny.js"></script>
	<!-- /TinyMCE -->
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
				$title =cleaninputfield($mysql,$_POST['title']);
				$ar_title =cleaninputfield($mysql,$_POST['ar_title']);
				$sort_order =cleaninputfield($mysql,$_POST['sort_order']);
				$description =cleaninputfield($mysql,$_POST['description']);
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$collection_id =cleaninputfield($mysql,$_POST['collection_id']);
				$status = ($_POST['status']) ? 1 : 0;
				
				$tech_title_1 =cleaninputfield($mysql,$_POST['tech_title_1']);
				$tech_title_2 =cleaninputfield($mysql,$_POST['tech_title_2']);
				
				if($_FILES['tech_file_1']['tmp_name']!=''){
					$tech_file_name1=fileExists($_FILES['tech_file_1']['name'],"../products_tech_files/");
					if(copy($_FILES['tech_file_1']['tmp_name'],"../products_tech_files/".$tech_file_name1)) {	
						$tech_file_name1 = $tech_file_name1;
					}
				 } // end of image uploading	
				
				if($_FILES['tech_file_2']['tmp_name']!=''){
					$tech_file_name2=fileExists($_FILES['tech_file_2']['name'],"../products_tech_files/");
					if(copy($_FILES['tech_file_2']['tmp_name'],"../products_tech_files/".$tech_file_name2)) {	
						$tech_file_name2 = $tech_file_name2;
					}
				 } // end of image uploading
				$queryinsert = $mysql->record_insert("d_products_tbl",array('title' => $title,'ar_title' => $ar_title,'sort_order' => $sort_order,'status' => $status,'description' => $description,'ar_description' => $ar_description,'collection_id' => $collection_id,'tech_file_1' => $tech_file_name1,'tech_file_2' => $tech_file_name2 ,'tech_title_1' => $tech_title_1,'tech_title_2' => $tech_title_2),false);
				if($queryinsert){
					$msg= base64_encode('Product Added Successfully!');
					echo "<script> window.location='d-products_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='d-products_list.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updates'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$ar_title =cleaninputfield($mysql,$_POST['ar_title']);
				$sort_order =cleaninputfield($mysql,$_POST['sort_order']);
				$description =cleaninputfield($mysql,$_POST['description']);
				$ar_description =cleaninputfield($mysql,$_POST['ar_description']);
				$collection_id =cleaninputfield($mysql,$_POST['collection_id']);
				$status = ($_POST['status']) ? 1 : 0;
				$ids = $_POST['ids'];
				
				$tech_title_1 =cleaninputfield($mysql,$_POST['tech_title_1']);
				$tech_title_2 =cleaninputfield($mysql,$mysql,$_POST['tech_title_2']);
				
				$tech_file_name1 = cleaninputfield($mysql,$_POST['old_tech_file_1']);
				if($_FILES['tech_file_1']['tmp_name']!=''){
					@unlink("../products_tech_files/$tech_file_name1");
					$tech_file_name1=fileExists($_FILES['tech_file_1']['name'],"../products_tech_files/");
					if(copy($_FILES['tech_file_1']['tmp_name'],"../products_tech_files/".$tech_file_name1)) {	
						$tech_file_name1 = $tech_file_name1;
					}
				 } // end of image uploading	
				$tech_file_name2 = cleaninputfield($mysql,$_POST['old_tech_file_2']);
				if($_FILES['tech_file_2']['tmp_name']!=''){
					@unlink("../products_tech_files/$tech_file_name2");
					$tech_file_name2=fileExists($_FILES['tech_file_2']['name'],"../products_tech_files/");
					if(copy($_FILES['tech_file_2']['tmp_name'],"../products_tech_files/".$tech_file_name2)) {	
						$tech_file_name2 = $tech_file_name2;
					}
				 } // end of image uploading
				if($_POST['tech_del_2']){
					@unlink("../products_tech_files/$tech_file_name2");
					$tech_file_name2='';
				}
				if($_POST['tech_del_1']){
					@unlink("../products_tech_files/$tech_file_name1");
					$tech_file_name1='';
					
				}
				$queryupdate = $mysql->record_update("d_products_tbl",array('title' => $title,'ar_title' => $ar_title,'sort_order' => $sort_order,'status' => $status,'description' => $description,'ar_description' => $ar_description,'collection_id' => $collection_id,'tech_file_1' => $tech_file_name1,'tech_file_2' => $tech_file_name2 ,'tech_title_1' => $tech_title_1,'tech_title_2' => $tech_title_2),"id=$ids");
				if($queryupdate){
					$msg= base64_encode('Product Updated Successfully!');
					echo "<script> window.location='d-products_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='d-products_list.php?msge=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("d_products_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="slide_form" id="slide_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add / Edit Products</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="16%"><label for="title">Title</label></td>
					<td width="84%"><input name="title" id="title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['title']; ?>"<?php } ?> class="required"/></td>
				  </tr>
				  <tr>
					<td width="16%"><label for="ar_title">Title in Arabic</label></td>
					<td width="84%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_title']; ?>"<?php } ?> class="required"/></td>
				  </tr>
				  <tr>
					<td><label for="sort_order">Sort Order </label></td>
					<td>		
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sort_order'];
						}else{
							$max_value = $mysql->table_max_value("d_products_tbl","sort_order"); 
							$max_value += 1;
						}
						?>
					<input name="sort_order" id="sort_order" type="text" value="<?php echo $max_value; ?>" class="required" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"/>		</td>
				  </tr>
				  <tr>
					<td><label for="collection_id">Collections</label></td>
					<td>
					<select name="collection_id" id="collection_id" class="required">
					<option value=""> Select Collection </option>
					<?php 
						$postrows2 = $mysql->list_table("d_collections_tbl",false); 
						if($mysql->affected_rows > 0){
							foreach($postrows2 as $value => $postrow2){
							$sel_1=(isset($postrow) && $postrow2['id']==$postrow['collection_id'])? "selected='selected'" : ""; ?>
							<option value="<?php echo $postrow2['id']; ?>" <?php echo $sel_1; ?> > <?php echo $postrow2['name']; ?> </option>
					<?php 
							}
						} 
						?></select>
					</td>
				</tr>
				  <tr>
					<td><label for="status">Status</label></td>
					<td>&nbsp;<input name="status" id="status" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['status']==1){?> checked="checked" <?php } ?>/></td>
				  </tr>
				   <tr>
					<td><label for="tech_title_1">Technical File 1 Title</label></td>
					<td><input name="tech_title_1" id="tech_title_1" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['tech_title_1']; ?>"<?php } ?>/></td>
				  </tr>
				    <tr>
					<td><label for="tech_file_1">Technical File 1</label></td>
					<td>&nbsp;<input type="file" name="tech_file_1" id="tech_file_1"  <?php  if(!isset($postrow)){?> class="" <?php } ?> /><?php  if(isset($postrow)){?> <input type="hidden" name="old_tech_file_1"  id="old_tech_file_1" value="<?php echo $postrow['tech_file_1'] ?>" /><input type='checkbox' name='tech_del_1' value='1' /> <?php echo "(   $postrow[tech_file_1]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>
				   <tr>
					<td><label for="tech_title_2">Technical File 2 Title</label></td>
					<td><input name="tech_title_2" id="tech_title_2" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['tech_title_2']; ?>"<?php } ?>/></td>
				  </tr>
				   <tr>
					<td><label for="tech_file_2">Technical File 2</label></td>
					<td>&nbsp;<input type="file" name="tech_file_2" id="tech_file_2"  <?php  if(!isset($postrow)){?> class="" <?php } ?> /><?php  if(isset($postrow)){?> <input type="hidden" name="old_tech_file_2"  id="old_tech_file_2" value="<?php echo $postrow['tech_file_2'] ?>" /> <input type='checkbox' name='tech_del_2' value='1' /><?php echo "(   $postrow[tech_file_2]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>
				  <tr>
					<td valign="top"><label for="description">Description</label></td>
					<td><textarea name="description" id="description" style="width:95%; height:250px;"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>
				  </tr>   
				  <tr>
					<td valign="top"><label for="ar_description">Description in Arabic</label></td>
					<td><textarea name="ar_description" id="ar_description" style="width:95%; height:250px;"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_description']); } ?></textarea></td>
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
