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
			?>
		<div class="container-top"></div>
		<?php 
			if(isset($_POST['updateconfig'])){
				$header = cleaninputfield($mysql,$_POST['header']);
				$footer = cleaninputfield($mysql,$_POST['footer']);
				$copyright = cleaninputfield($mysql,$_POST['copyright']);
				
				$ar_header = cleaninputfield($mysql,$_POST['ar_header']);
				$ar_footer = cleaninputfield($mysql,$_POST['ar_footer']);
				$ar_copyright = cleaninputfield($mysql,$_POST['ar_copyright']);
				$whatsapp = cleaninputfield($mysql,$_POST['whatsapp']);
				$whatsappmessage = cleaninputfield($mysql,$_POST['whatsappmessage']);
				$adminemail = cleaninputfield($mysql,$_POST['adminemail']);
				
				
				$facebook = cleaninputfield($mysql,$_POST['facebook']);
				$linkedin = cleaninputfield($mysql,$_POST['linkedin']);
				$instagram = cleaninputfield($mysql,$_POST['instagram']);
				$twitter = cleaninputfield($mysql,$_POST['twitter']);
				$youtube = cleaninputfield($mysql,$_POST['youtube']);
				$vimeo = cleaninputfield($mysql,$_POST['vimeo']);
				$pinterest = cleaninputfield($mysql,$_POST['pinterest']);
				$google = cleaninputfield($mysql,$_POST['google']);
				
				$creation_date =  date('Y-m-d h:i:s');
				$created_by = $_SESSION['LOGGERID'];
				$pageid=1;
				$queryupdate = $mysql->record_update("config_tbl",array('adminemail' => $adminemail,'google' => $google,'pinterest' => $pinterest,'vimeo' => $vimeo,'youtube' => $youtube,'facebook' => $facebook,'linkedin' => $linkedin,'instagram' => $instagram,'twitter' => $twitter,'header' => $header,'footer' => $footer,'copyright' => $copyright,'ar_header' => $ar_header,'ar_footer' => $ar_footer,'ar_copyright' => $ar_copyright,'whatsappmessage' => $whatsappmessage,'whatsapp' => $whatsapp),"id=$pageid");
				if($queryupdate){
					/// counting record
					$store_records = $mysql->count_records("config_history_tbl","page_id=$pageid");
					/// compairing 
					if($store_records >= 5){
						/// try to get last record
						$post = $mysql->fetch_row("config_history_tbl","page_id = $pageid",array ('range' => '*','sortColumn'=>"id",'sortType'=>'ASC'));
						$first_record_id = $post['id'];
						/// try to delete last record
						$mysql->record_delete("config_history_tbl","id = $first_record_id");
						/// try to insert new record
						$queryinsert = $mysql->record_insert("config_history_tbl",array('google' => $google,'pinterest' => $pinterest,'vimeo' => $vimeo,'youtube' => $youtube,'facebook' => $facebook,'linkedin' => $linkedin,'instagram' => $instagram,'twitter' => $twitter,'page_id' => $pageid,'header' => $header,'footer' => $footer,'copyright' => $copyright,'ar_header' => $ar_header,'ar_footer' => $ar_footer,'ar_copyright' => $ar_copyright,'whatsappmessage' => $whatsappmessage,'whatsapp' => $whatsapp,'creation_date' => $creation_date,'created_by' => $created_by),false);
					}else{
						/// try to insert new record
						$queryinsert = $mysql->record_insert("config_history_tbl",array('google' => $google,'pinterest' => $pinterest,'vimeo' => $vimeo,'youtube' => $youtube,'facebook' => $facebook,'linkedin' => $linkedin,'instagram' => $instagram,'twitter' => $twitter,'page_id' => $pageid,'header' => $header,'footer' => $footer,'ar_header' => $ar_header,'ar_footer' => $ar_footer,'ar_copyright' => $ar_copyright,'whatsapp' => $whatsapp,'whatsappmessage' => $whatsappmessage,'copyright' => $copyright,'creation_date' => $creation_date,'created_by' => $created_by),false);
					}
					$msg= base64_encode('Site Config Updated Successfully!');
					echo "<script> window.location='siteconfig.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='siteconfig.php?msge=$msg';</script>";
					exit();
				}
			
			}	$args1 = $_GET['args1'];
				$postrow = $mysql->fetch_row("config_tbl","id=1");
				$header = stripslashes($postrow['header']); 
				$whatsapp = stripslashes($postrow['whatsapp']); 
				$whatsappmessage = stripslashes($postrow['whatsappmessage']); 
				$footer = stripslashes($postrow['footer']); 
				$copyright = stripslashes($postrow['copyright']); 
				$ar_header = stripslashes($postrow['ar_header']); 
				$ar_footer = stripslashes($postrow['ar_footer']); 
				$ar_copyright = stripslashes($postrow['ar_copyright']);
				$facebook = stripslashes($postrow['facebook']); 
				$linkedin = stripslashes($postrow['linkedin']); 
				$instagram = stripslashes($postrow['instagram']); 
				$twitter = stripslashes($postrow['twitter']); 
				$youtube = stripslashes($postrow['youtube']); 
				$adminemail = stripslashes($postrow['adminemail']); 
				
				$vimeo = stripslashes($postrow["vimeo"]);
				$pinterest = stripslashes($postrow["pinterest"]);
				$google = stripslashes($postrow["google"]);
				
				
			if(isset($_GET['args2'])){
				$args2 = cleaninputfield($mysql,$_GET['args2']);
				$postsrow = $mysql->fetch_row("config_history_tbl","id=$args2");
				if($_GET['c1']==1){
					$header = stripslashes($postsrow['header']); 
				}
				if($_GET['c1']==1){
					$whatsapp = stripslashes($postsrow['whatsapp']); 
				}
				if($_GET['c1']==1){
					$youtube = stripslashes($postsrow['youtube']); 
				}
				if($_GET['c1']==1){
					$google = stripslashes($postsrow['google']); 
				}
				if($_GET['c1']==1){
					$pinterest = stripslashes($postsrow['pinterest']); 
				}
				if($_GET['c1']==1){
					$vimeo = stripslashes($postsrow['vimeo']); 
				}
				if($_GET['c1']==1){
					$twitter = stripslashes($postsrow['twitter']); 
				}
				if($_GET['c1']==1){
					$instagram = stripslashes($postsrow['instagram']); 
				}
				if($_GET['c1']==1){
					$linkedin = stripslashes($postsrow['linkedin']); 
				}
				if($_GET['c1']==1){
					$facebook = stripslashes($postsrow['facebook']); 
				}
				if($_GET['c1']==1){
					$whatsappmessage = stripslashes($postsrow['whatsappmessage']); 
				}
				if($_GET['c2']==1){
					$ar_header = stripslashes($postsrow['ar_header']); 
				}
				if($_GET['c3']==1){
					$footer = stripslashes($postsrow['footer']); 
				}
				if($_GET['c4']==1){
					$ar_footer = stripslashes($postsrow['ar_footer']); 
				}
				if($_GET['c5']==1){
					$copyright = stripslashes($postsrow['copyright']); 
				}
				if($_GET['c6']==1){
					$ar_copyright = stripslashes($postsrow['ar_copyright']); 
				}

			}	
			?>
		
		<div class="container">
		<form action="" method="post" name="config_form" id="config_form" enctype="multipart/form-data" >
			<h2>  Site Config Management</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblpagecont">
				  <tr class="headerbar">
					<th>Admin Email</th>
				  </tr>
				  <tr>
					<td><input type="text" name="adminemail" style="width: 98%;" id="adminemail" value="<?php echo $adminemail; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Whatsapp Number</th>
				  </tr>
				  <tr>
					<td><input type="text" name="whatsapp" style="width: 98%;" id="whatsapp" value="<?php echo $whatsapp; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Whatsapp Short Message</th>
				  </tr>
				  <tr>
					<td><input type="text" name="whatsappmessage" style="width: 98%;" id="whatsappmessage" value="<?php echo $whatsappmessage; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Facebook</th>
				  </tr>
				  <tr>
					<td><input type="text" name="facebook" style="width: 98%;" id="facebook" value="<?php echo $facebook; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Linkedin</th>
				  </tr>
				  <tr>
					<td><input type="text" name="linkedin" style="width: 98%;" id="linkedin" value="<?php echo $linkedin; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Instagram</th>
				  </tr>
				  <tr>
					<td><input type="text" name="instagram" style="width: 98%;" id="instagram" value="<?php echo $instagram; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Twitter</th>
				  </tr>
				  <tr>
					<td><input type="text" name="twitter" style="width: 98%;" id="twitter" value="<?php echo $twitter; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Youtube</th>
				  </tr>
				  <tr>
					<td><input type="text" name="youtube" style="width: 98%;" id="youtube" value="<?php echo $youtube; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Vimeo</th>
				  </tr>
				  <tr>
					<td><input type="text" name="vimeo" style="width: 98%;" id="vimeo" value="<?php echo $vimeo; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Pinterest</th>
				  </tr>
				  <tr>
					<td><input type="text" name="pinterest" style="width: 98%;" id="pinterest" value="<?php echo $pinterest; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Google</th>
				  </tr>
				  <tr>
					<td><input type="text" name="google" style="width: 98%;" id="google" value="<?php echo $google; ?>"></td>
				  </tr>
				  <tr class="headerbar">
					<th>Footer About</th>
				  </tr>
				  <tr>
					<td><textarea name="header" id="header" style="width:100%" rows="10"><?php echo $header; ?></textarea></td>
				  </tr>
				  <tr class="separator">
				  <td>&nbsp;</td>
				  </tr>
                  <tr class="headerbar">
					<th>Footer About in Arabic</th>
				  </tr>
				  <tr>
					<td><textarea name="ar_header" id="ar_header" style="width:100%" rows="10"><?php echo $ar_header; ?></textarea></td>
				  </tr>
				  <tr class="separator">
				  <td>&nbsp;</td>
				  </tr>
				  <tr class="headerbar">
					<th>Footer Contact Text</th>
				  </tr>
				  <tr>
					<td><textarea name="footer" id="footer" style="width:100%" rows="10"><?php echo $footer; ?></textarea></td>
				  </tr>
				  <tr class="separator">
				  <td>&nbsp;</td>
				  </tr>
                   <tr class="headerbar">
					<th>Footer Contact Text in Arabic</th>
				  </tr>
				  <tr>
					<td><textarea name="ar_footer" id="ar_footer" style="width:100%" rows="10"><?php echo $ar_footer; ?></textarea></td>
				  </tr>
				  <tr class="separator">
				  <td>&nbsp;</td>
				  </tr>
				  <tr class="headerbar">
					<th>Copyright</th>
				  </tr>
				  <tr>
					<td><textarea name="copyright" id="copyright" style="width:100%" rows="10"><?php echo $copyright; ?></textarea></td>
				  </tr>
				   <tr class="separator"> <td>&nbsp;</td>
				   </tr>
                   <tr class="headerbar">
					<th>Copyright in Arabic</th>
				  </tr>
				  <tr>
					<td><textarea name="ar_copyright" id="ar_copyright" style="width:100%" rows="10"><?php echo $ar_copyright; ?></textarea></td>
				  </tr> 
				   <tr class="separator"> <td>&nbsp;</td>
				   </tr>
				</table>
			</div>
			<div class="addbtn-right">
				<input type="hidden" name="updateconfig" id="updateconfig" value="updateconfig" />
				<input name="update" id="update" border="0" type="submit" value="Update Config" class="addpagebtn" />
			</div>
			</form>	
			<?php
				$i=0;
				$postrecents = $mysql->list_table("config_history_tbl"," page_id = '1' ",array ('range' => '*','sortColumn'=>"creation_date",'sortType'=>'DESC'));
				if($mysql->affected_rows>0){ ?>
					<div class="reinstate">
					<form action="update_config.php" method="post" name="form1" id="form1" onsubmit="return checkForm(this);" >
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
