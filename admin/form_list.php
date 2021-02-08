<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_FORM']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	if(isset($_GET['args1'])){
		$args1 = cleaninputfield($mysql,$_GET['args1']);
		$mysql->record_delete("formconfig_tbl","id = $args1");
		$mysql->record_delete("formfields_tbl","conf_pi_id = $args1");
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
			<h2>Form Management </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl">
				  <tr class="headerbar">
					<th width="21%" class="alignleft">Title</th>
					<th width="22%" class="alignleft">Subject</th>
					<th width="33%">Mail To</th>
					<th width="11%">Edit Form </th>
					<th width="13%">Delete Form </th>
				  </tr>
				  <?php 
					$i=1;
					$tbl_name="formconfig_tbl";		//your table name
					// How many adjacent pages should be shown on each side?
					$adjacents = ADJACENTS;
					$total_pages = $mysql->count_records("$tbl_name",false);
					
					/* Setup vars for query. */
					$targetpage = "{$_SERVER['PHP_SELF']}"; 	//your file name  (the name of this file)
					$limit = LIMIT; 								//how many items to show per page
					$page =0;
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
							$row_class= ($i%2==0)?"class='alttr'":'class="alignleft"';
							?>
					    <tr <?php echo $row_class; ?>>
						<td class="alignleft"><?php echo stripslashes($postrow['title']); ?></td>
						<td class="alignleft"><?php echo stripslashes($postrow['mailsubject']); ?></td>
						<td class="alignleft"><?php echo stripslashes($postrow['mailto']); ?></td>
						<td><a href="edit_form.php?args1=<?php echo $postrow['id']; ?>"><img src="images/edituser.png" border="0" alt="edit form" title="Edit" /></a></td>
						<td><a href="form_list.php?args1=<?php echo $postrow['id']; ?>" onclick="return confirm('Do you want to delete this?');"><img src="images/delete.png" border="0" title="Delete" alt="delete user" /></a></td>
					  </tr>
					  <?php 
							$i++;
							}  ?>
								<tr>
								<td class="aligncenter" colspan="5"><?php echo $pagination; ?></td>
							  </tr>
						<?php 
						 }else{ ?> 
							<tr>
							<td class="aligncenter" colspan="5"><strong>No Record Found!</strong></td>
						  </tr>
						 <?php } ?>
				</table>
			</div>
			<div class="addbtn-right">
				<a href="new_form.php" title="Add Form"><input name="add" id="add" border="0" type="submit" value="Add Form" class="addpagebtn" /></a> 
			</div>
		</div>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
		</div><!--wrap end here-->
	</body>
</html>