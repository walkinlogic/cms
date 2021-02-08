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
	if(isset($_GET['args1'])){
		$args1=cleaninputfield($mysql,$_GET['args1']);
		$args2=cleaninputfield($mysql,$_GET['args2']);
		$mysql->record_update("content_tbl",array('pagestatus' => $args2),"id=$args1");
	}	
	if(isset($_GET['args3'])){
		$args3 =cleaninputfield($mysql,$_GET['args3']);
		$mysql->record_delete("content_tbl","id = $args3");
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		
		<div class="container-top"></div>
		<div class="container">
			<h2>Site Overview</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl">
				  <tr class="headerbar">
					<th width="25%" class="alignleft">Page Name</th>
					<th width="10%">Page Order</th>
					<th width="10%">Page Display</th>
					<th width="10%">Edit Settings</th>
					<th width="10%">Edit Content</th>
					<th width="10%">Delete Page</th>
				  </tr>
				  <?php 
					$p=1;
					$postrows = $mysql->list_table("content_tbl","parentpageid=0",array('sortColumn' => 'sortorder','sortType'=>'ASC'));
					if($mysql->affected_rows>0){
						foreach($postrows as $value => $postrow){
							$row_class= ($p%2==0) ? 'class="alttr"' : 'class="alignleft"';/// class="selected" //td class="subpage"
							$parent_id = $postrow['id']; ?>
							<tr <?php echo $row_class; ?>>
							<td class="alignleft"><?php echo $postrow['pagename'];?> </td>
							<td><?php echo $postrow['sortorder'];?></td>
							<td>
							<?php 
								$status=$postrow['pagestatus'];
								if($status==1){ 
									echo "<a href='pages_list.php?args1=$postrow[id]&args2=0'><img src='images/active.png' border='0' alt='active' />&nbsp;&nbsp;Visible</a>";
								}else{ 
									echo "<a href='pages_list.php?args1=$postrow[id]&args2=1'><img src='images/hidden.png' border='0' alt='hidden' />&nbsp;&nbsp;Hidden</a>";
								}	
								?> </td>
							<td><a href="new_page.php?args1=<?php echo $postrow['id']; ?>"><img src="images/editsetting.png" border="0" title="Edit" alt="edit setting" /></a></td>
							<td><?php if($_SESSION['MANAGE_CONTENT']==1){ ?><a href="page_content.php?args1=<?php echo $postrow['id']; ?>"><img src="images/editcontent.png" border="0" title="Content" alt="edit content" /></a><?php }else{ ?> <img src='images/hidden.png' border='0' alt='hidden' title="Suspended" /> Suspended<?php } ?></td>
							<td><a href="pages_list.php?args3=<?php echo $postrow['id']; ?>" onclick="return confirm('Do you want to delete this?');"><img src="images/delete.png" border="0" title="Delete" alt="delete page" /></a></td>
						  </tr>
						  <?php 
							$postsubrows = $mysql->list_table("content_tbl","parentpageid=$parent_id",array('sortColumn' => 'sortorder','sortType'=>'ASC'));
							if($mysql->affected_rows>0){
								foreach($postsubrows as $value => $postsubrow){ 
								$sub_row_class= 'class="selected"'; 
									$subpage_id = $postsubrow['id']; ?>
									<tr <?php echo $sub_row_class; ?>>
									<td class="subpage"><?php echo $postsubrow['pagename'];?> </td>
									<td><?php echo $postsubrow['sortorder'];?></td>
									<td>
									<?php 
										$status=$postsubrow['pagestatus'];
										if($status==1){ 
											echo "<a href='pages_list.php?args1=$postsubrow[id]&args2=0'><img src='images/active.png' border='0' alt='active' />&nbsp;&nbsp;Visible</a>";
										}else{ 
											echo "<a href='pages_list.php?args1=$postsubrow[id]&args2=1'><img src='images/hidden.png' border='0' alt='hidden' />&nbsp;&nbsp;Hidden</a>";
										}	
										?> </td>
									<td><a href="new_page.php?args1=<?php echo $postsubrow['id']; ?>"><img src="images/editsetting.png" border="0" title="Edit" alt="edit setting" /></a></td>
									<td><?php if($_SESSION['MANAGE_CONTENT']==1){ ?><a href="page_content.php?args1=<?php echo $postsubrow['id']; ?>"><img src="images/editcontent.png" border="0" title="Content" alt="edit content" /></a><?php }else{ ?> <img src='images/hidden.png' border='0' alt='hidden' title="Suspended" /> Suspended <?php } ?></td>
									<td><a href="pages_list.php?args3=<?php echo $postsubrow['id']; ?>" onclick="return confirm('Do you want to delete this?');"><img src="images/delete.png" border="0" title="Delete" alt="delete page" /></a></td>
								  </tr>
								  
								   <?php 
									$postchildrows = $mysql->list_table("content_tbl","parentpageid=$subpage_id",array('sortColumn' => 'sortorder','sortType'=>'ASC'));
									if($mysql->affected_rows>0){
										foreach($postchildrows as $value => $postchildrow){ 
											$child_row_class= 'class="childrow"';	?>
											<tr <?php echo $child_row_class; ?>>
											<td class="childpage"><?php echo $postchildrow['pagename'];?> </td>
											<td><?php echo $postchildrow['sortorder'];?></td>
											<td>
											<?php 
												$cstatus=$postchildrow['pagestatus'];
												if($cstatus==1){ 
													echo "<a href='pages_list.php?args1=$postchildrow[id]&args2=0'><img src='images/active.png' border='0' alt='active' />&nbsp;&nbsp;Visible</a>";
												}else{ 
													echo "<a href='pages_list.php?args1=$postchildrow[id]&args2=1'><img src='images/hidden.png' border='0' alt='hidden' />&nbsp;&nbsp;Hidden</a>";
												}	
												?> </td>
											<td><a href="new_page.php?args1=<?php echo $postchildrow['id']; ?>"><img src="images/editsetting.png" border="0" title="Edit" alt="edit setting" /></a></td>
											<td><?php if($_SESSION['MANAGE_CONTENT']==1){ ?><a href="page_content.php?args1=<?php echo $postchildrow['id']; ?>"><img src="images/editcontent.png" border="0" title="Content" alt="edit content" /></a><?php }else{ ?> <img src='images/hidden.png' border='0' alt='hidden' title="Suspended" /> Suspended <?php } ?></td>
											<td><a href="pages_list.php?args3=<?php echo $postchildrow['id']; ?>" onclick="return confirm('Do you want to delete this?');"><img src="images/delete.png" border="0" title="Delete" alt="delete page" /></a></td>
										  </tr>
										<?php 
										}
									}
								}
							}	
						$p++;
						}
					}else{
					?>
				    	<tr>
							<td align="center"><strong>No Record Found!</strong></td>
						  </tr>	
				  <?php } ?>
				</table>

			</div>
			<div class="addbtn-right">
								<a href="new_page.php"><input name="add" id="add" border="0" type="submit" value="Add New" class="addpagebtn"></a>
			</div>
		</div>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
	</div><!--wrap end here-->
</body>
</html>