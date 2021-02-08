<?php 
	include_once("includes/security.php");        /// security check
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
			if(isset($_POST['updateuser'])){
				$full_name =cleaninputfield($mysql,$_POST['full_name']);
				$email =cleaninputfield($mysql,$_POST['email']);
				$userid =$_POST['userid'];
				$login_ip=$_SERVER['REMOTE_ADDR'];	
				$oldpassword = $_POST['oldpassword'];
				$newpassword = $_POST['newpassword'];
				$conf_password = $_POST['conf_password'];
				
				if(strlen($oldpassword) >0){
				    $postrow = $mysql->fetch_row("user_tbl","id=$userid");
					$db_password = $postrow['password'];
					if($oldpassword == $db_password){
						if($newpassword == $conf_password && $newpassword != ""){
							$queryupdate = $mysql->record_update("user_tbl",array('password' => $newpassword,'full_name' => $full_name,'email' => $email,'login_ip'=>$login_ip),"id=$userid");
							if($queryupdate){
								$msg= base64_encode('Account Updated Successfully!');
								echo "<script> window.location='manage_account.php?msg=$msg';</script>";
								exit();
							
							}else{
								$msg= base64_encode(mysqli_error($mysql->connection));
								echo "<script> window.location='manage_account.php?msge=$msg';</script>";
								exit();
							}
							
						}else{
							$msg= base64_encode('New Password and Confirm Password doesnot match!');
							echo "<script> window.location='manage_account.php?msge=$msg';</script>";
							exit();
						}
					}else{
						$msg= base64_encode('Old Password doesnot match!');
						echo "<script> window.location='manage_account.php?msge=$msg';</script>";
						exit();
					}
				
				}else{
						$queryupdate = $mysql->record_update("user_tbl",array('full_name' => $full_name,'email' => $email,'login_ip'=>$login_ip),"id=$userid");
					if($queryupdate){
						$msg= base64_encode('Account Updated Successfully!');
						echo "<script> window.location='manage_account.php?msg=$msg';</script>";
						exit();
					
					}else{
						$msg= base64_encode(mysqli_error($mysql->connection));
						echo "<script> window.location='manage_account.php?msge=$msg';</script>";
						exit();
					}
				
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 = base64_decode($_GET['args1']);
				$postrow = $mysql->fetch_row("user_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="user_form" id="user_form" >
		<div class="container">
			<h2>Account Updation</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
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
					<td width="26%"><label for="oldpassword">Old Password</label></td>
					<td width="74%"><input name="oldpassword" id="oldpassword" type="password"/></td>
				  </tr>
				  <tr> 	 	
					<td width="26%"><label for="newpassword">New Password</label></td>
					<td width="74%"><input name="newpassword" id="newpassword" type="password"/></td>
				  </tr>
				  <tr>
				    <td><label for="conf_password">Confirm Password </label></td>
				    <td><input name="conf_password" id="conf_password" type="password"/></td>
		      </tr>
				  
			  </table>
		
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="userid" id="userid" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updateuser" id="updateuser" value="updateuser" />
				<input name="update" id="update" border="0" type="submit" value="Update" class="addpagebtn" />
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
