<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_USER']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	if(isset($_GET['args1'])){
		$args1 = cleaninputfield($mysql,$_GET['args1']);
		$args2 = cleaninputfield($mysql,$_GET['args2']);
		if($args1 !=1){
			$mysql->record_update("user_tbl",array('status' => $args2),"id=$args1");
		}
		//print_r($check);
	}	
	if(isset($_GET['args3'])){
		$args3 = cleaninputfield($mysql,$_GET['args3']);
		if($args3 !=1){
			$mysql->record_delete("user_tbl","id = $args3");
		}
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
			<h2>Users Management</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl">
				  <tr class="headerbar">
					<th width="14%" class="alignleft">User Name</th>
					<th width="25%" class="alignleft">Email Address</th>
					<th width="18%">Last Login</th>
					<th width="14%">IP Address </th>
					<th width="11%">Status</th>
					<th width="8%">Edit User</th>
					<th width="10%">Delete User</th>
				  </tr>
				  <?php 
					$i=1;
					$tbl_name="user_tbl";		//your table name
					// How many adjacent pages should be shown on each side?
					$adjacents = ADJACENTS;
					$total_pages = $mysql->count_records("$tbl_name",false);
					
					/* Setup vars for query. */
					$targetpage = "{$_SERVER['PHP_SELF']}"; 	//your file name  (the name of this file)
					$limit = LIMIT; 								//how many items to show per page
					$page = 0;
					if(isset($_GET['page'])){
						$page = $_GET['page'];
					}
					if($page) 
						$start = ($page - 1) * $limit; 			//first item to display on this page
					else
						$start = 0;								//if no page var is given, set start to 0
					/* Get data. */
					$postrows = $mysql->list_table("$tbl_name",false, array ('range' => '*','limitOffset'=>$start,'rowCount'=>$limit,'sortColumn'=>"id",'sortType'=>'ASC'));
					if($mysql->affected_rows>0){
					/* Setup page vars for display. */
					if ($page == 0) $page = 1;					//if no page var is given, default to 1.
					$prev = $page - 1;							//previous page is page - 1
					$next = $page + 1;							//next page is page + 1
					$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
					$lpm1 = $lastpage - 1;						//last page minus 1
					
					$pagination = "";
					if($lastpage > 1){	
						$pagination .= "<div class=\"pagination\">";
						//previous button
						if ($page > 1) 
							$pagination.= "<a href=\"$targetpage?page=$prev\">&laquo; prev</a>";
						else
							$pagination.= "<span class=\"disabled\">&laquo; prev</span>";	
						
						//pages	
						if ($lastpage < 7 + ($adjacents * 2)){	//not enough pages to bother breaking it up
							for ($counter = 1; $counter <= $lastpage; $counter++){
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
							}
						}
						else if($lastpage > 5 + ($adjacents * 2)){	//enough pages to hide some
							//close to beginning; only hide later pages
							if($page < 1 + ($adjacents * 2)){
								for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
								}
								$pagination.= "...";
								$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
								$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
							}
							//in middle; hide some front and some back
							else if($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
									$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
									$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
									$pagination.= "...";
									for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
										if ($counter == $page)
											$pagination.= "<span class=\"current\">$counter</span>";
										else
											$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
									}
									$pagination.= "...";
									$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
									$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
								}
							//close to end; only hide early pages
							else{
								$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
								$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
								$pagination.= "...";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
									if ($counter == $page)
										$pagination.= "<span class=\"current\">$counter</span>";
									else
										$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
								}
							}
						}
						
						//next button
						if ($page < $counter - 1) 
							$pagination.= "<a href=\"$targetpage?page=$next\">next &raquo;</a>";
						else
							$pagination.= "<span class=\"disabled\">next &raquo;</span>";
						$pagination.= "</div>\n";		
					}
						foreach($postrows as $value => $postrow){
							$row_class= ($i%2==0) ? 'class="alttr"' : 'class="alignleft"';
							?>
				  <tr <?php echo $row_class; ?>>
					<td class="alignleft"><?php echo $postrow['full_name']; ?></td>
					<td class="alignleft"><?php echo stripslashes($postrow['email']); ?></td>
					<td><?php echo $postrow['lastlogindate']; ?></td>
					<td><?php echo $postrow['login_ip']; ?></td>
					<td align="left">
					<?php 
						$status=$postrow['status'];
						if($i==1){
							echo "&nbsp; &nbsp; <img src='images/active.png' border='0' alt='active' title='Always Active'/> Active &nbsp; &nbsp;";
						}else{
							if($status == 1){ 
								echo "<a href='user_list.php?args1=$postrow[id]&args2=0'> &nbsp; &nbsp; <img src='images/active.png' border='0' alt='active' /> Active &nbsp; &nbsp;</a>";
							}else{ 
								echo "<a href='user_list.php?args1=$postrow[id]&args2=1'> &nbsp; &nbsp; <img src='images/hidden.png' border='0' alt='hidden' /> Inactive</a>";
							}	
						} ?> </td>
					<td><a href="new_user.php?args1=<?php echo $postrow['id']; ?>"><img src="images/edituser.png" border="0" alt="edit user" title="Edit" /></a></td>
					<td>
					<?php 
						if($i > 1){ ?>
					<a href="user_list.php?args3=<?php echo $postrow['id']; ?>" onclick="return confirm('Do you want to delete this?');"><img src="images/delete.png" border="0" title="Delete" alt="delete user" /></a> <?php } ?></td>
				  </tr>
				  <?php 
				  		$i++;
				  		}  ?>
							<tr>
							<td class="aligncenter" colspan="7"><?php echo $pagination; ?></td>
						  </tr>
						<?php 
					 }else{ ?> 
					 	<tr>
						<td class="aligncenter" colspan="7"><strong>No Record Found!</strong></td>
					  </tr>
					 <?php } ?>
				</table>
			</div>
			<div class="addbtn-right">
				<a href="new_user.php" title="Add User"><input name="add" id="add" border="0" type="submit" value="Add User" class="addpagebtn" /></a> 
			</div>
		</div>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
		</div><!--wrap end here-->
	</body>
</html>