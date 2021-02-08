<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_NEWS']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");       
	include_once("../includes/db_wrapper.php"); 
	include_once("includes/utility.php");    		include_once("includes/thumbnail_images.class.php");    
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
			if(isset($_POST['addnews'])){
				$heading = cleaninputfield($mysql,$_POST['heading']);  
				$description = cleaninputfield($mysql,$_POST['description']); 
				$newsdate = $_POST['newsdate'];
				$status = isset($_POST['status']) ? 1 : 0;								
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);				
				if($_FILES['image']['tmp_name']!=''){					
					@unlink("../uploaded/$oldimage");	 
					$times=time();		
					$imagename=fileExists($times.$_FILES['image']['name'],"../uploaded/");					
					copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename);				 
				}	 				 
				$queryinsert = $mysql->record_insert("newsletters_tbl",array('file' => $imagename,'heading' => $heading,'submition_date' => $newsdate,'description' => $description,'status' => $status),false);
				if($queryinsert){
					$msg= base64_encode('Newsletter Added Successfully!');
					echo "<script> window.location='newsletter_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='newsletter_list.php?msg=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['updatenews'])){
				$heading = cleaninputfield($mysql,$_POST['heading']); 
				$description = cleaninputfield($mysql,$_POST['description']); 
				$newsdate = $_POST['newsdate'];
				$status = isset($_POST['status']) ? 1 : 0; 
				$newsid = $_POST['newsid'];
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);				
				if($_FILES['image']['tmp_name']!=''){					
					@unlink("../uploaded/$oldimage");		 		
					$times=time();	
					$imagename=fileExists($times.$_FILES['image']['name'],"../uploaded/");					
					copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename);				 
				}		
  
				$queryupdate = $mysql->record_update("newsletters_tbl",array('file' => $imagename,'heading' => $heading,'submition_date' => $newsdate,'description' => $description,'status' => $status),"id=$newsid");
				if($queryupdate){
					$msg= base64_encode('Newsletter Updated Successfully!');
					echo "<script> window.location='newsletter_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='newsletter_list.php?msg=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("newsletters_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="news_form" id="news_form"  enctype="multipart/form-data">
		<div class="container">
			<h2>Add / Edit Newsletter</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="11%"><label for="heading">Heading</label></td>
					<td width="89%"><input name="heading" id="heading" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['heading']; ?>"<?php } ?>/></td>
				  </tr> 
				  <tr> 	 	
					<td><label for="newsdate">Date</label></td>
					<td><input name="newsdate" id="newsdate" readonly="readonly" type="text" value="<?php if(isset($postrow)){ echo $postrow['submition_date']; }else{ echo date('Y-m-d'); }?>" onfocus="displayCalendar(document.getElementById('newsdate'),'yyyy-mm-dd', document.getElementById('newsdate'));"> <img src="images/caldp.jpg" onClick="displayCalendar(document.getElementById('newsdate'),'yyyy-mm-dd', document.getElementById('newsdate'));" style="cursor:pointer;">
					</td>
				  </tr>
					 
				  <tr>					
				  <td width="11%"><label for="image">Image </label></td>					
				  <td>&nbsp;<input type="file" name="image" id="image" /><?php  if(isset($postrow)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['file'] ?>" /> <?php echo "( <a  href='".URL."uploaded/$postrow[file]' target='_blank'>$postrow[file]</a>   )"; }   ?>					</td>				  
				  </tr>					  
				   		 
				   <tr>
					<td width="11%"><label for="status">Status</label></td>
					<td width="89%"><input name="status" id="status" type="checkbox" <?php if(isset($postrow) && $postrow['status']==1){ ?> checked="checked" <?php } ?>/></td>
				  </tr> 
				  <tr>
					<td valign="top"><label for="description">Description</label></td>
					<td><textarea name="description" id="description" style="width:97%" rows="18"><?php if(isset($postrow)){ echo stripslashes($postrow['description']); } ?></textarea></td>
				  </tr>  
				    
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="newsid" id="newsid" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updatenews" id="updatenews" value="updateuser" />
				<input name="update" id="update" border="0" type="submit" value="Update Letter" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="addnews" id="addnews" value="addnews" />
				<input name="add" id="add" border="0" type="submit" value="Add Letter" class="addpagebtn" />
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
