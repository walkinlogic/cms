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
<script language="JavaScript" type="text/javascript">
	function checkForm(form1) {
	  for (var i=0; i<form1.elements["restore_page"].length; i++) {
		var radio = form1.elements["restore_page"][i];
		if (radio.checked) {
		  return true;
		}
	  }
	  alert("Please select one option for Reinstate!");
	  return false;
	}
</script>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			
			////content updation	
			if(isset($_POST['updatepage'])){
				$pagecontent = cleaninputfield($mysql,$_POST['pagecontent']);
				$ar_pagecontent = cleaninputfield($mysql,$_POST['ar_pagecontent']);

				$pageid =$_POST['pageid'];
				$creation_date =  date('Y-m-d h:i:s');
				$created_by = $_SESSION['LOGGERID'];
				$queryupdate = $mysql->record_update("content_tbl",array('pagecontent' => $pagecontent, 'ar_pagecontent' => $ar_pagecontent),"id=$pageid");
				if($queryupdate){
					/// counting record
					$store_records = $mysql->count_records("content_history_tbl","page_id=$pageid");
					/// compairing 
					if($store_records >= 5){
						/// try to get last record
						$post = $mysql->fetch_row("content_history_tbl","page_id = $pageid",array ('range' => '*','sortColumn'=>"id",'sortType'=>'ASC'));
						$first_record_id = $post['id'];
						/// try to delete last record
						$mysql->record_delete("content_history_tbl","id = $first_record_id");
						/// try to insert new record
						$queryinsert = $mysql->record_insert("content_history_tbl",array('page_id' => $pageid,'page_content' => $pagecontent,'ar_page_content' => $ar_pagecontent,'creation_date' => $creation_date,'created_by' => $created_by),false);
					}else{
						/// try to insert new record
						$queryinsert = $mysql->record_insert("content_history_tbl",array('page_id' => $pageid,'page_content' => $pagecontent,'ar_page_content' => $ar_pagecontent,'creation_date' => $creation_date,'created_by' => $created_by),false);
					}
					$msg= base64_encode('Page Content Updated Successfully!');
					echo "<script> window.location='pages_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='pages_list.php?msg=$msg';</script>";
					exit();
				}
			}
			if(isset($_GET['args1'])){
				$args1 = cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("content_tbl","id=$args1");
				$pagename = stripslashes($postrow['pagename']); 
				$pagecontent = stripslashes($postrow['pagecontent']); 
				$ar_pagecontent = stripslashes($postrow['ar_pagecontent']); 
				$pageid = $postrow['id']; 
				
			}
			if(isset($_GET['args2'])){
				$args2 = cleaninputfield($mysql,$_GET['args2']);
				$postsrow = $mysql->fetch_row("content_history_tbl","id=$args2");
				if($_GET['c1']==1){
					$pagecontent = stripslashes($postsrow['page_content']);
				}if($_GET['c2']==1){
					$ar_pagecontent = stripslashes($postsrow['ar_page_content']); 	
				
				}
			}
			?>
		
		<div class="container-top"></div>
		
	  	<div class="container">
		<form action="" method="post" name="content_form" id="content_form" enctype="multipart/form-data">
			<h2> <?php echo stripslashes($postrow['pagename']); ?> Content</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblpagecont">
				  <tr class="headerbar">
					<th><?php echo $pagename; ?>  Content</th>
				  </tr>
				  <tr>
					<td><textarea name="pagecontent" id="pagecontent" style="width:100%" rows="20"><?php if(isset($args1)){ echo $pagecontent; } ?></textarea></td>
				  </tr>
                   <tr class="headerbar">
					<th><?php echo $pagename; ?>  Content in Arabic</th>
				  </tr>
				  <tr>
					<td><textarea name="ar_pagecontent" id="ar_pagecontent" style="width:100%" rows="20"><?php if(isset($args1)){ echo $ar_pagecontent; } ?></textarea></td>
				  </tr>
                  
				  <tr class="separator">
				  <td>&nbsp;</td>
				  </tr>
				</table>
			</div>
			<div class="addbtn-right">
				<input name="pageid" id="pageid" type="hidden" value="<?php echo $pageid; ?>" />
				<input name="updatepage" id="updatepage" border="0" type="submit" value="Update Content" class="addpagebtn" />
			</div>
			</form>
			
			<?php
				$i=0;
				$postrecents = $mysql->list_table("content_history_tbl"," page_id = '$args1' ",array ('range' => '*','sortColumn'=>"creation_date",'sortType'=>'DESC'));
				if($mysql->affected_rows>0){ ?>
					<div class="reinstate">
					<form action="update_content.php" method="post" name="form1" id="form1" onsubmit="return checkForm(this);" >
					<table border="0" cellpadding="0" cellspacing="0">
				<?php 
					foreach($postrecents as $postrecent){ ?>
					  <tr>
						<td><label for="restore_page_<?php echo $postrecent['id']; ?>"><?php echo date('d M, Y h:i',strtotime($postrecent['creation_date'])).". By ".getAdminName($postrecent['created_by'],$mysql); ?></label></td>
						<td><input type="radio" name="restore_page" id="restore_page_<?php echo $i; ?>" value="<?php echo $postrecent['id']; ?>" />
						</td>
					  </tr>
              <?php
			  		$i++;
			  		}?>
					<tr>
			  <td colspan="2" align="right"><input type="image" name="restore" id="restore" src="images/reinstate.png" border="0" alt="reinstate" value="restore"/></td>
			  </tr>
            </table>
			</form>
			</div>
				<?php
			  	} ?>
		 </div>
		
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
	</div><!--wrap end here-->
</body>
</html>
