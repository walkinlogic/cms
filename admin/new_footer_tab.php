<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_NEWS']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
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
			if(isset($_POST['add_footertab'])){
				$title = cleaninputfield($mysql,$_POST['title']);
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']); 
				$description = cleaninputfield($mysql,$_POST['description']);
				$ar_description = cleaninputfield($mysql,$_POST['ar_description']);
				$sort_order = cleaninputfield($mysql,$_POST['sort_order']);
				$icon = cleaninputfield($mysql,$_POST['icon']);
				$popup_description = cleaninputfield($mysql,$_POST['popup_description']);
				$ar_popup_description = cleaninputfield($mysql,$_POST['ar_popup_description']);
				$popup_readmore = cleaninputfield($mysql,$_POST['popup_readmore']);
				$ar_popup_readmore = cleaninputfield($mysql,$_POST['ar_popup_readmore']);
				$popup_image = cleaninputfield($mysql,$_POST['popup_image']);
				$form_id =cleaninputfield($mysql,$_POST['form_id']);
				$status = isset($_POST['status']) ? 1 : 0;
				if($_FILES['icon']['tmp_name']!=''){
					$iconname=fileExists($_FILES['icon']['name'],"../collections_pic/");
					if(copy($_FILES['icon']['tmp_name'],"../collections_pic/".$iconname)) {	
						$iconname = $iconname;
					}
				 } // end of icon uploading
				 if($_FILES['popup_image']['tmp_name']!=''){
					$imagename2=fileExists($_FILES['popup_image']['name'],"../collections_pic/");
					if(copy($_FILES['popup_image']['tmp_name'],"../collections_pic/".$imagename2)) {	
						$imagename2 = $imagename2;
					}
				 } // end of image uploading	
				$queryinsert = $mysql->record_insert("footer_tabs_tbl",array('title' => $title,'ar_title' => $ar_title,'description' => $description,'ar_description' => $ar_description,'sort_order'=>$sort_order,'icon' =>$icon,'popup_description' =>$popup_description, 'ar_popup_description' =>$ar_popup_description, 'popup_readmore' =>$popup_readmore, 'ar_popup_readmore' =>$ar_popup_readmore, 'popup_image' =>$popup_image,'form_id'=>$form_id,'status' => $status),false);
				if($queryinsert){
					$msg= base64_encode('Footer Tab Added Successfully!');
					echo "<script> window.location='footer_tab_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='footer_tab_list.php?msg=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['update_footertab'])){
				$title = cleaninputfield($mysql,$_POST['title']);
				$ar_title = cleaninputfield($mysql,$_POST['ar_title']); 
				$description = cleaninputfield($mysql,$_POST['description']);
				$ar_description = cleaninputfield($mysql,$_POST['ar_description']);
				$sort_order = cleaninputfield($mysql,$_POST['sort_order']);
				$icon = cleaninputfield($mysql,$_POST['icon']);
				$popup_description = cleaninputfield($mysql,$_POST['popup_description']);
				$ar_popup_description = cleaninputfield($mysql,$_POST['ar_popup_description']);
				$popup_readmore = cleaninputfield($mysql,$_POST['popup_readmore']);
				$ar_popup_readmore = cleaninputfield($mysql,$_POST['ar_popup_readmore']);
				$popup_image = cleaninputfield($mysql,$_POST['popup_image']);
				$form_id =cleaninputfield($mysql,$_POST['form_id']);
				$status = isset($_POST['status']) ? 1 : 0;
				$tab_id = $_POST['tab_id'];
				$iconname = cleaninputfield($mysql,$_POST['oldicon']);
				if($_FILES['icon']['tmp_name']!=''){
					@unlink("../collections_pic/$iconname");
					$iconname=fileExists($_FILES['icon']['name'],"../collections_pic/");
					if(copy($_FILES['icon']['tmp_name'],"../collections_pic/".$iconname)) {
						$iconname = $iconname;					
					}
				 } /// end of updating icon
				 $imagename2 = cleaninputfield($mysql,$_POST['oldpopup_image']);
				if($_FILES['popup_image']['tmp_name']!=''){
					@unlink("../collections_pic/$imagename2");
					$imagename2=fileExists($_FILES['popup_image']['name'],"../collections_pic/");
					if(copy($_FILES['popup_image']['tmp_name'],"../collections_pic/".$imagename2)) {
						$imagename2 = $imagename2;					
					}
				 } /// end of updating image 
				$queryupdate = $mysql->record_update("footer_tabs_tbl",array('title' => $title,'ar_title' => $ar_title,'description' => $description,'ar_description' => $ar_description,'sort_order'=>$sort_order,'icon' =>$icon,'popup_description' =>$popup_description, 'ar_popup_description' =>$ar_popup_description, 'popup_readmore' =>$popup_readmore, 'ar_popup_readmore' =>$ar_popup_readmore, 'popup_image' =>$popup_image,'form_id'=>$form_id,'status' => $status),"id=$tab_id");
				if($queryupdate){
					$msg= base64_encode('Footer Tab Updated Successfully!');
					echo "<script> window.location='footer_tab_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='footer_tab_list.php?msg=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("footer_tabs_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="news_form" id="news_form" >
		<div class="container">
			<h2>Add / Edit Footer Tabs</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="11%"><label for="title">Title</label></td>
					<td width="89%"><input name="title" id="title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['title']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="11%"><label for="title">Title In Arabic</label></td>
					<td width="89%"><input name="ar_title" id="ar_title" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_title']; ?>"<?php } ?>/></td>
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
					<td width="11%"><label for="sort_order">Sort Order</label></td>
					<td width="89%"><input name="sort_order" id="sort_order" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['sort_order']; ?>"<?php } ?>/></td>
				  </tr>
				 <tr>
					<td><label for="icon">Icon</label></td>
					<td>&nbsp;<input type="file" accept=".ico" name="icon" id="icon"  <?php  if(!isset($postrow)){?> class="required" <?php } ?> /><?php  if(isset($postrow)){?> <input type="hidden" name="oldicon"  id="oldicon" value="<?php echo $postrow['icon'] ?>" /> <?php echo "(   $postrow[icon]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr>
				<tr>
					<td valign="top"><label for="popup_description">Pop-up Description</label></td>
					<td><textarea name="popup_description" id="popup_description" style="width:97%" rows="10"><?php if(isset($postrow)){ echo stripslashes($postrow['popup_description']); } ?></textarea></td>
				  </tr>  
				   <tr>
					<td valign="top"><label for="popup_description">Pop-up Description In Arabic</label></td>
					<td><textarea name="ar_popup_description" id="ar_popup_description" style="width:97%" rows="10"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_popup_description']); } ?></textarea></td>
				  </tr> 
				  <tr>
					<td valign="top"><label for="popup_readmore">Pop-up Readmore</label></td>
					<td><textarea name="popup_readmore" id="popup_readmore" style="width:97%" rows="10"><?php if(isset($postrow)){ echo stripslashes($postrow['popup_readmore']); } ?></textarea></td>
				  </tr>  
				   <tr>
					<td valign="top"><label for="popup_readmore">Pop-up Readmore In Arabic</label></td>
					<td><textarea name="ar_popup_readmore" id="ar_popup_readmore" style="width:97%" rows="10"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_popup_readmore']); } ?></textarea></td>
				  </tr>
				  <tr>
					<td><label for="popup_image">Pop-up Image</label></td>
					<td>&nbsp;<input type="file" name="popup_image" id="popup_image"  accept="image/*" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldpopup_image"  id="oldpopup_image" value="<?php echo $postrow['popup_image'] ?>" /> <?php echo "(   $postrow[popup_image]   )"; } /// end of the file uploading updation ?>
					</td>
				  </tr> 
				   <tr>
					<td width="11%"><label for="status">Status</label></td>
					<td width="89%"><input name="status" id="status" type="checkbox" <?php if(isset($postrow) && $postrow['status']==1){ ?> checked="checked" <?php } ?>/></td>
				  </tr>
				  </tr> 
				   <tr>
					<td><label for="popup_form">Pop-up Form</label></td>
					<td>
					<select name="form_id" id="form_id">
					<option value=""> Select a form </option>
					<?php 
						$postrows2 = $mysql->list_table("formconfig_tbl",false); 
						if($mysql->affected_rows > 0){
							foreach($postrows2 as $value => $postrow2){
							$sel_1=(isset($postrow) && $postrow2['id']==$postrow['form_id'])? "selected='selected'" : ""; ?>
							<option value="<?php echo $postrow2['id']; ?>" <?php echo $sel_1; ?> > <?php echo $postrow2['title']; ?> </option>
					<?php 
							}
						} 
						?></select>
					</td>
				</tr>
			  </table>
		</div>
		<div class="addbtn-right">
		<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="tab_id" id="tab_id" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="update_footertab" id="update_footertab" value="update_footertab" />
				<input name="update" id="update" border="0" type="submit" value="Update Tab" class="addpagebtn" />
		<?php }else{ ?>
				<input type="hidden" name="add_footertab" id="add_footertab" value="add_footertab" />
				<input name="add" id="add" border="0" type="submit" value="Add Tab" class="addpagebtn" />
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
