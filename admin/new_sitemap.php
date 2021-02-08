<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_PAGE']==0){
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
	<script language="javascript">
	function Validate(){
		var page_name=document.getElementById('pagename').value;
		var internal_link=document.getElementById('internal_link').value;
		if(page_name==""){
			alert('Please enter page name!');
			return false;
		}
		if(internal_link==""){
			document.getElementById('internal_link').value=page_name;
		}
	}
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
		
		 
		if(isset($_POST['addpage'])){
				 
				$parentpageid = cleaninputfield($mysql,$_POST['parentpageid']);
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);
				  
				 
				$queryupdate = $mysql->record_insert("sitemap_tbl",array('sortorder' => $sortorder,'pageid' => $parentpageid));
				if($queryupdate){
					$msg= base64_encode('Page Updated Successfully!');
					echo "<script> window.location='sitemap.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='sitemap.php?msge=$msg';</script>";
					exit();
				}
			}
			if(isset($_GET['args1'])){
				$args1 = cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("content_tbl","id=$args1");
				
			}
			?>
		<form action="" method="post" name="page_form" id="page_form" enctype="multipart/form-data" onsubmit="return Validate()">
		<div class="container">
			<h2> Edit Page</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				   	 	 	 	 	 	 	 	
				  <tr>
					<td><label for="parentpageid">Page of</label></td>
					<td>
						<select name="parentpageid" id="parentpageid" class="required">
							<option value="0"> &laquo; Select Page &raquo;  </option>
							<?php 
								$rows = $mysql->list_table("content_tbl","parentpageid=0");
								if($mysql->affected_rows>0){
									foreach($rows as $value => $row){ 
										$parent_id = $row['id'];
										  if(strlen($row['internal_link'])>0){
												$toplevel_page = stripslashes($row['internal_link']);
											}else{
												$toplevel_page = stripslashes($row['pagename']);
											} 

										$sel_1 = (isset($postrow) && $row['id'] == $postrow['parentpageid']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo $sel_1; ?>> <?php echo $toplevel_page; ?> </option>			
							<?php 
										/* $subrows = $mysql->list_table("content_tbl","parentpageid=$parent_id");
										if($mysql->affected_rows>0){
											foreach($subrows as $value => $subrow){ 
												$subpage_id= $subrow['id'];
												if(strlen($subrow['internal_link'])>0){
													$sel_2 = ($subrow['id'] == $postrow['parentpageid']) ? "selected='selected'" : "";
													$sublevel_page = stripslashes($subrow['internal_link']);
												}else{
													$sublevel_page = stripslashes($subrow['pagename']);
												} ?>
												<option value="<?php echo $subrow['id']; ?>" <?php echo $sel_2; ?>> &nbsp;  &nbsp; <?php echo $sublevel_page; ?> </option>			
												
											<?php 
											$childrows = $mysql->list_table("content_tbl","parentpageid=$subpage_id");
											if($mysql->affected_rows>0){
												foreach($childrows as $value => $childrow){ 
													if(strlen($childrow['internal_link'])>0){
														$sel_3 = ($childrow['id'] == $postrow['parentpageid']) ? "selected='selected'" : "";
														$childlevel_page = stripslashes($childrow['internal_link']);
													}else{
														$childlevel_page = stripslashes($childrow['pagename']);
													} ?>
													<option value="<?php echo $childrow['id']; ?>" <?php echo $sel_3; ?>> &nbsp;  &nbsp; &nbsp; &nbsp; <?php echo $childlevel_page; ?> </option>		
													<?php
													}
												}	
											}
										} */
									}
								}
								?>
						</select>					</td>
				  </tr>
				   
				  <tr>
					<td><label for="sortorder">Page Order</label></td>
					<td>
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("sitemap_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
				<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>"/></td>
				  </tr>
				  
				  
			 </table>
		
		</div>
		<div class="addbtn-right">
		<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="pageid" id="pageid" value="<?php echo $_GET['args1']; ?>" />
				<input type="hidden" name="updatepage" id="updatepage" value="updatepage" />
				<input name="update" id="update" border="0" type="submit" value="Update Page" class="addpagebtn"/>
	  <?php }else{ ?>
				<input type="hidden" name="addpage" id="addpage" value="addpage" />
				<input name="add" id="add" border="0" type="submit" value="Add Page" class="addpagebtn" />
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
