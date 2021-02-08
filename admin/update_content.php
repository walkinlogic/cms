<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_CONTENT']==0){
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
</head>

<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			
			////content updation	
			if(isset($_POST['updatepage'])){
				$id = $_POST['pageid'];
				$postcontent = $mysql->fetch_row("content_history_tbl","id = $id",array ('range' => '*','sortColumn'=>"id",'sortType'=>'ASC'));
				
				$c1 = isset($_POST['checkbox_1']) ? 1 : 0;
				$c2 = isset($_POST['checkbox_2']) ? 1 : 0;
				$c3 = isset($_POST['checkbox_3']) ? 1 : 0;
				$args2 = $id; //// history table id
				$args1 = $postcontent['page_id']; //// content table id
				if(isset($args1)){
					echo "<script>window.location='page_content.php?args1=$args1&args2=$args2&c1=$c1&c2=$c2&c3=$c3';</script>";
					exit();
				}
			}
			if(isset($_POST['restore_page'])){
				$args1 = $_POST['restore_page'];
				$postrow = $mysql->fetch_row("content_history_tbl","id=$args1");
			}
			?>
		
		<div class="container-top"></div>
		<form action="" method="post" name="content_form" id="content_form" enctype="multipart/form-data">
	  	<div class="container">
			<h2> Recent Content</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblpagecont">
				  <tr class="headerbar">
					<th> Page  Content  &nbsp;  <input name="checkbox_1" id="checkbox_1" type="checkbox" value="1" checked="checked" /><label for="checkbox_1" style="color:#FFFFFF"> Reinstate </label></th>
				  </tr> 
				  <tr style="background:#737374;">
					<td><?php if(isset($args1)){ echo stripslashes($postrow['page_content']); } ?></td>
				  </tr>
                  
                  <tr class="headerbar">
					<th> Page  Content  in Arabic  <input name="checkbox_2" id="checkbox_2" type="checkbox" value="1" checked="checked" /><label for="checkbox_2" style="color:#FFFFFF"> Reinstate </label></th>
				  </tr> 
				  <tr style="background:#737374;">
					<td><?php if(isset($args1)){ echo stripslashes($postrow['ar_page_content']); } ?></td>
				  </tr>
				  
				</table>
			</div>
			<div class="addbtn-right">
				<input name="pageid" id="pageid" type="hidden" value="<?php echo $postrow['id']; ?>" />
				<input name="updatepage" id="updatepage" border="0" type="submit" value="View Content" class="addpagebtn" />
			</div>
			<div class="reinstate"> &nbsp;</div>    
		</div>
		</form>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
	</div><!--wrap end here-->
</body>
</html>
