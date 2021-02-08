<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_GALLERY']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	include_once("../includes/config.php");      /// db setting
	include_once("../includes/db_wrapper.php"); /// db wrapper
	include_once("includes/utility.php");      /// general functions
	if(isset($_GET['args2'])){
		$args2 = cleaninputfield($mysql,$_GET['args2']);
		$args3 = cleaninputfield($mysql,$_GET['args3']);
		$mysql->record_update("d-product_images_tbl",array('status' => $args3),"id=$args2");
		//print_r($check);
	}	
	if(isset($_GET['sortorder'])){
		$sortorder = cleaninputfield($mysql,$_GET['sortorder']);
		$id = cleaninputfield($mysql,$_GET['id']);
		$mysql->record_update("d_product_images_tbl",array('sortorder' => $sortorder),"id=$id");
		//print_r($check);
	}	
	
	if(isset($_GET['args4'])){
		$args4 = cleaninputfield($mysql,$_GET['args4']);
		$gallery_images = cleaninputfield($mysql,$_GET['args5']);
		//$gallery_images = getGalleryImage($args3,$mysql);
		@unlink("../uploaded/$gallery_images");
		@unlink("../uploaded/thumbs/$gallery_images");
		$mysql->record_delete("d_product_images_tbl","id = $args4");
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
	<!-- gallery file starts -->
	<link rel="stylesheet" type="text/css" href="gallery_js/highslide.css" />
	<script type="text/javascript" src="gallery_js/highslide-with-gallery.js"></script>
	<script type="text/javascript" src="gallery_js/initial.js"></script>
	<!-- gallery files ends -->
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		
		<div class="container-top"></div>
		<div class="container">
			<h2>Decorative Product Images Management </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl">
				  <tr class="headerbar">
					<th width="100%" class="alignleft" colspan="4"> Manage Gallery</th>
				  </tr>
				  <tr>
				  <?php 
					$i=1;
					if(isset($_GET['product_id'])){
						$product_id = $_GET['product_id'];
						$args1 ="&product_id=".$product_id;
						$where="product_id=$product_id";
					}else{
						$args1="";
						$where=false;
					}
					$postrows = $mysql->list_table("d_product_images_tbl ",$where,array('sortColumn' => 'sortorder','sortType'=>'ASC'));
					if($mysql->affected_rows > 0){
						foreach($postrows as $value => $postrow){
							if($i%4==0){
								echo "</tr> <tr>";
							}
							?>
					<td align="center" style="padding-top:8px">	
						<a href='d-product_gallery.php?id=<?php echo $postrow[id].'&sortorder='.($postrow['sortorder']-1).$args1; ?>' title='Move Up'><img src='images/up-arrow.png' title='Move Up'/></a>
						<a href='d-product_gallery.php?id=<?php echo $postrow[id].'&sortorder='.($postrow['sortorder']+1).$args1; ?>' title='Move Down'><img src='images/down-arrow.png' title='Move Down'/></a>
					
					  <a href="../uploaded/<?php echo stripslashes($postrow['image']); ?>" class="highslide" onclick="return hs.expand(this)"> <img src="../uploaded/thumbs/<?php echo $postrow['image']; ?>" alt="<?php echo stripslashes($postrow['alttext']); ?>" title="<?php echo stripslashes($postrow['title']); ?>" /> </a><div class="highslide-caption"> <?php echo  stripslashes($postrow['title']); ?></div><br />
					<?php  
						if($postrow['status'] == 1){ 
							echo "<a href='d-product_gallery.php?args2=$postrow[id]&args3=0$args1'> &nbsp; &nbsp; <img src='images/active.png' border='0' alt='active' title='Active' /></a>";
						}else{ 
							echo "<a href='d-product_gallery.php?args2=$postrow[id]&args3=1$args1'> &nbsp; &nbsp; <img src='images/hidden.png' border='0' alt='hidden' title='Inactive' /></a>";
						}	
						?>						
					<a href="d-product_image.php?args2=<?php echo $postrow['id'].$args1; ?>"><img src="images/edituser.png" border="0" alt="edit user" title="Edit" /></a>
					<a href="d-product_gallery.php?args4=<?php echo $postrow['id'].$args1."&args5=".$postrow['image']; ?>" onclick="return confirm('Do you want to delete this?');"><img src="images/delete.png" border="0" title="Delete" alt="delete Image" /></a></td> 
				  <?php 
				  		$i++;
				  		} 
						echo "</tr>";
					 }else{ ?> 
					 	<tr>
						<td class="aligncenter" colspan="4"><strong>No Album Image Found!</strong></td>
					  </tr>
					 <?php } ?>
				</table>
			</div>
			<!--<a class="addpagebtn_link" title="Add Image" href="d-product_image.php?<?php echo $args1; ?>">Add Image</a>-->
			<div class="addbtn-right">
				<a href="d-product_image.php?<?php echo $args1; ?>" title="Add Image"><input name="add" id="add" border="0" type="submit" value="Add Image" class="addpagebtn" /></a> 
			</div>
		</div>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
		</div><!--wrap end here-->
	</body>
</html>