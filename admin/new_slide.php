<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_SLIDE']==0){
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
			if(isset($_POST['addslide'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$ar_title =cleaninputfield($mysql,$_POST['ar_title']);
				$alt_text =cleaninputfield($mysql,$_POST['alt_text']);
				$ar_alt_text =cleaninputfield($mysql,$_POST['ar_alt_text']);
				$image =cleaninputfield($mysql,$_POST['image']);
				$sort_order =cleaninputfield($mysql,$_POST['sort_order']);
				$pageid = $_POST['pageid'];
				$status = ($_POST['status']) ? 1 : 0;	
				////
				if($_FILES['image']['tmp_name']!=''){
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {	
						/* $obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 473;
						$obj_img->NewHeight = 238;
						$obj_img->create_thumbnail_images(); */
					}
				 } // end of image uploading	
				$queryinsert = $mysql->record_insert("slide_show_tbl",array('title' => $title,'ar_title' => $ar_title,'alt_text' => $alt_text,'ar_alt_text' => $ar_alt_text,'sort_order' => $sort_order,'image' => $imagename,'status' => $status,'pageid'=> $pageid),false);
				if($queryinsert){
					$msg= base64_encode('Slideshow Added Successfully!');
					echo "<script> window.location='slide_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='slide_list.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updateslide'])){
				$title =cleaninputfield($mysql,$_POST['title']);
				$ar_title =cleaninputfield($mysql,$_POST['ar_title']);
				$alt_text =cleaninputfield($mysql,$_POST['alt_text']);
				$ar_alt_text =cleaninputfield($mysql,$_POST['ar_alt_text']);
				
				$image =cleaninputfield($mysql,$_POST['image']);
				$sort_order =cleaninputfield($mysql,$_POST['sort_order']);
				$status = ($_POST['status']) ? 1 : 0;	
				$slide_id = $_POST['slide_id'];
				$pageid = $_POST['pageid'];
				//// thumbnails updating
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);
				if($_FILES['image']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 473;
						$obj_img->NewHeight = 238;
						$obj_img->create_thumbnail_images();					
					}
				 } /// end of updating image
				$queryupdate = $mysql->record_update("slide_show_tbl",array('title' => $title,'ar_title' => $ar_title,'alt_text' => $alt_text,'ar_alt_text' => $ar_alt_text,'sort_order' => $sort_order,'image' => $imagename,'status' => $status,'pageid' => $pageid),"id=$slide_id");
				if($queryupdate){
					$msg= base64_encode('Slideshow Updated Successfully!');
					echo "<script> window.location='slide_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='slide_list.php?msge=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("slide_show_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="slide_form" id="slide_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add / Edit FAQ </h2>
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
					<td><input name="alt_text" id="alt_text" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['alt_text']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr> 	 	
					<td><label for="alt_text">Alt Text In Arabic</label></td>
					<td><input name="ar_alt_text" id="ar_alt_text" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_alt_text']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td><label for="sort_order">Sort Order </label></td>
					<td>		
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sort_order'];
						}else{
							$max_value = $mysql->table_max_value("slide_show_tbl","sort_order"); 
							$max_value += 1;
						}
						?>
					<input name="sort_order" id="sort_order" type="text" value="<?php echo $max_value; ?>"/>		</td>
				  </tr>
				  <tr>
					<td><label for="pageid"> Page Name</label></td>
					<td>
						<select name="pageid" id="pageid">
							<option value="0"> &laquo; Page Name &raquo;  </option>
							<?php 
								$rows = $mysql->list_table("content_tbl",false);
								if($mysql->affected_rows>0){
									foreach($rows as $value => $row){ 
										$parent_id = $row['id'];
										  if(strlen($row['internal_link'])>0){
												$toplevel_page = stripslashes($row['internal_link']);
											}else{
												$toplevel_page = stripslashes($row['pagename']);
											} 

										$sel_1 = ($row['id'] == $postrow['pageid']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo $sel_1; ?>> <?php echo $toplevel_page; ?> </option>			
							<?php 
									}
								}
								?>
						</select>					</td>
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
				<input type="hidden" name="slide_id" id="slide_id" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updateslide" id="updateslide" value="updateslide" />
				<input name="update" id="update" border="0" type="submit" value="Update" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="addslide" id="addslide" value="addslide" />
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
