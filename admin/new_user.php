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
		<?php 
			if(isset($_POST['adduser'])){
				$username =cleaninputfield($mysql,$_POST['username']);
				$password =cleaninputfield($mysql,$_POST['password']);
				$conf_password =cleaninputfield($mysql,$_POST['conf_password']);
				$full_name =cleaninputfield($mysql,$_POST['full_name']);
				$email =cleaninputfield($mysql,$_POST['email']);
				$page_management = isset($_POST['page_management']) ? 1 : 0;
				$content_management = isset($_POST['content_management']) ? 1 : 0;
				$news_management = isset($_POST['news_management']) ? 1 : 0;
				$gallery_management = isset($_POST['gallery_management']) ? 1 : 0;
				$slideshow_management = isset($_POST['slideshow_management']) ? 1 : 0;
				$forms_management = isset($_POST['forms_management']) ? 1 : 0;
				$expand_management = isset($_POST['expand_management']) ? 1 : 0;
				$custom_management = isset($_POST['custom_management']) ? 1 : 0;
				$user_management = isset($_POST['user_management']) ? 1 : 0;
				$style_management = isset($_POST['style_management']) ? 1 : 0;
				$login_ip=$_SERVER['REMOTE_ADDR'];
				$creationdate = date('Y-m-d h:i:s');
				$status = isset($_POST['status']) ? 1 : 0;
				if($password != $conf_password){
					$msg= base64_encode('Password and Confirm Password doesnot match!');
					echo "<script> window.location='user_list.php?msge=$msg';</script>";
					exit();
				}
				$queryinsert = $mysql->record_insert("user_tbl",array('username' => $username,'password' => $password,'full_name' => $full_name,'email' => $email,'page_management' => $page_management,'content_management' => $content_management,'news_management' => $news_management,'gallery_management' => $gallery_management,'slideshow_management' => $slideshow_management,'forms_management' => $forms_management,'expandablecontent_management' => $expand_management,'custommodule_management' => $custom_management,'user_management' => $user_management,'style_management' => $style_management,'creationdate' => $creationdate,'status' => $status,'login_ip'=>$login_ip),false);
				if($queryinsert){
					$msg= base64_encode('User Added Successfully!');
					echo "<script> window.location='user_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='user_list.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updateuser'])){
				$username =cleaninputfield($mysql,$_POST['username']);
				$password =cleaninputfield($mysql,$_POST['password']);
				$newpassword =cleaninputfield($mysql,$_POST['newpassword']);
				$conf_password =cleaninputfield($mysql,$_POST['conf_password']);
				$full_name =cleaninputfield($mysql,$_POST['full_name']);
				$email =cleaninputfield($mysql,$_POST['email']);
				$page_management = isset($_POST['page_management']) ? 1 : 0;
				$content_management = isset($_POST['content_management']) ? 1 : 0;
				$news_management = isset($_POST['news_management']) ? 1 : 0;
				$gallery_management = isset($_POST['gallery_management']) ? 1 : 0;
				$slideshow_management = isset($_POST['slideshow_management']) ? 1 : 0;
				$forms_management = isset($_POST['forms_management']) ? 1 : 0;
				$expand_management = isset($_POST['expand_management']) ? 1 : 0;
				$custom_management = isset($_POST['custom_management']) ? 1 : 0;
				$user_management = isset($_POST['user_management']) ? 1 : 0;
				$style_management = isset($_POST['style_management']) ? 1 : 0;
				$login_ip=$_SERVER['REMOTE_ADDR'];
				$creationdate = date('Y-m-d h:i:s');
				$userid = $_POST['userid'];
				if($userid == 1){
					$status = 1;
				}else{
					$status = isset($_POST['status']) ? 1 : 0;
				}
				if(strlen($password) >0){
					$postrow = $mysql->fetch_row("user_tbl","id=$userid");
					$db_password = $postrow['password'];
					if($password == $db_password){
						if($newpassword == $conf_password && $newpassword!=""){
								$queryupdate = $mysql->record_update("user_tbl",array('username' => $username,'password' => $newpassword,'full_name' => $full_name,'email' => $email,'page_management' => $page_management,'content_management' => $content_management,'news_management' => $news_management,'gallery_management' => $gallery_management,'slideshow_management' => $slideshow_management,'forms_management' => $forms_management,'expandablecontent_management' => $expand_management,'custommodule_management' => $custom_management,'user_management' => $user_management,'style_management' => $style_management,'creationdate' => $creationdate,'status' => $status,'login_ip'=>$login_ip),"id=$userid");
								if($queryupdate){
									$msg= base64_encode('User Updated Successfully!');
									echo "<script> window.location='user_list.php?msg=$msg';</script>";
									exit();
								
								}else{
									$msg= base64_encode(mysqli_error($mysql->connection));
									echo "<script> window.location='user_list.php?msge=$msg';</script>";
									exit();
								}
						}else{
							$msg= base64_encode('New Password and Confirm Password doesnot match!');
							echo "<script> window.location='user_list.php?msge=$msg';</script>";
							exit();
						}
					
					}else{
						$msg= base64_encode('Old Password doesnot match!');
						echo "<script> window.location='user_list.php?msge=$msg';</script>";
						exit();
					}
				}else{
					$queryupdate = $mysql->record_update("user_tbl",array('username' => $username,'full_name' => $full_name,'email' => $email,'page_management' => $page_management,'content_management' => $content_management,'news_management' => $news_management,'gallery_management' => $gallery_management,'slideshow_management' => $slideshow_management,'forms_management' => $forms_management,'expandablecontent_management' => $expand_management,'custommodule_management' => $custom_management,'user_management' => $user_management,'style_management' => $style_management,'creationdate' => $creationdate,'status' => $status,'login_ip'=>$login_ip),"id=$userid");
					if($queryupdate){
						$msg= base64_encode('User Updated Successfully!');
						echo "<script> window.location='user_list.php?msg=$msg';</script>";
						exit();
					
					}else{
						$msg= base64_encode(mysqli_error($mysql->connection));
						echo "<script> window.location='user_list.php?msge=$msg';</script>";
						exit();
					}
				}	
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("user_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="user_form" id="user_form" >
		<div class="container">
			<h2>Add / Edit User</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="26%"><label for="username">Username</label></td>
					<td width="74%"><input name="username" id="username" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['username']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr> 	 	
					<td><label for="password"> <?php if(isset($postrow)){?> Old <?php  } ?> Password</label></td>
					<td><input name="password" id="password" type="password"/></td>
				  </tr>
				  <?php if(isset($postrow)){?> 
					  <tr> 	 	
						<td><label for="newpassword"> New Password</label></td>
						<td><input name="newpassword" id="newpassword" type="password" /></td>
					  </tr>
				   <?php  } ?>
				  <tr>
				    <td><label for="conf_password"> Confirm Password </label></td>
				    <td><input name="conf_password" id="conf_password" type="password"/></td>
		      </tr>
				  <tr>
					<td><label for="full_name">Full Name</label></td>
					<td>
					<input name="full_name" id="full_name" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['full_name']; ?>"<?php } ?>/>					</td>
				  </tr>
				  <tr>
					<td><label for="email">Email</label></td>
					<td>
					<input name="email" id="email" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['email']); ?>"<?php } ?>/>					</td>
				  </tr>
				  <tr>
					<td colspan="2"><label><strong> User Roles Management </strong></label></td>
				  </tr>
				  <tr>
					<td><label for="page_management">Allow Page Management</label></td>
					<td><input name="page_management" id="page_management" type="checkbox" value="1" class="checkbox" <?php if(isset($postrow) && $postrow['page_management']==1){?> checked="checked" <?php } ?>/> <label for="page_management"> Yes </label></td>
				  </tr>
				  <tr>
					<td><label for="content_management">Allow Content Management</label></td>
					<td><input name="content_management" id="content_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['content_management']==1){?> checked="checked" <?php } ?>/> <label for="content_management"> Yes </label></td>
				  </tr>
				    	 	 	 	 	 	 
				  <tr>
					<td><label for="news_management">Allow News Management </label></td>
					<td><input name="news_management" id="news_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['news_management']==1){?> checked="checked" <?php } ?>/> <label for="news_management"> Yes </label></td>
				  </tr>
				  <tr>
					<td><label for="gallery_management">Allow Gallery Management</label></td>
					<td><input name="gallery_management" id="gallery_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['gallery_management']==1){?> checked="checked" <?php } ?>/> <label for="gallery_management"> Yes </label></td>
				  </tr>
				  <tr>
					<td><label for="forms_management">Allow Forms Management</label></td>
					<td><input name="forms_management" id="forms_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['forms_management']==1){?> checked="checked" <?php } ?>/> <label for="forms_management"> Yes </label></td>
				  </tr>
				  <tr>
					<td><label for="slideshow_management">Allow Slideshow Management</label></td>
					<td><input name="slideshow_management" id="slideshow_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['slideshow_management']==1){?> checked="checked" <?php } ?>/> <label for="slideshow_management"> Yes </label></td>
				  </tr>
				 
				  <tr>
					<td><label for="expand_management">Allow Expandable Content Management</label></td>
					<td><input name="expand_management" id="expand_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['expandablecontent_management']==1){?> checked="checked" <?php } ?>/> <label for="expand_management"> Yes </label></td>
				  </tr>
				   <tr>
					<td><label for="custom_management">Allow Custom Module Management</label></td>
					<td><input name="custom_management" id="custom_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['custommodule_management']==1){?> checked="checked" <?php } ?>/> <label for="custom_management"> Yes </label></td>
				  </tr>
				  <tr>
					<td><label for="user_management">Allow User Management</label></td>
					<td><input name="user_management" id="user_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['user_management']==1){?> checked="checked" <?php } ?>/> <label for="user_management"> Yes </label></td>
				  </tr>  
				   <tr>
					<td><label for="style_management">Allow Style Management</label></td>
					<td><input name="style_management" id="style_management" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['style_management']==1){?> checked="checked" <?php } ?>/> <label for="style_management"> Yes </label></td>
				  </tr>   
				  <tr>
					<td><label for="status">Status</label></td>
					<td><input name="status" id="status" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['status']==1){?> checked="checked" <?php } ?>/> <label for="status"> Active </label></td>
				  </tr>  
			  </table>
		
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="userid" id="userid" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updateuser" id="updateuser" value="updateuser" />
				<input name="update" id="update" border="0" type="submit" value="Update User" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="adduser" id="adduser" value="adduser" />
				<input name="add" id="add" border="0" type="submit" value="Add User" class="addpagebtn" />
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
