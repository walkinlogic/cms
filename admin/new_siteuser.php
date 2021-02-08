<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_CUSTOM']==0){
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
				$name =cleaninputfield($mysql,$_POST['name']);
				$email =cleaninputfield($mysql,$_POST['email']);
				$phone =cleaninputfield($mysql,$_POST['phone']);
				$address =cleaninputfield($mysql,$_POST['address']);
				$login_ip=$_SERVER['REMOTE_ADDR'];
				$status = isset($_POST['status']) ? 1 : 0;
				if($password != $conf_password){
					$msg= base64_encode('Password and Confirm Password doesnot match!');
					echo "<script> window.location='siteuser_list.php?msge=$msg';</script>";
					exit();
				}
				$queryinsert = $mysql->record_insert("siteuser_tbl",array('username' => $username,'password' => $password,'name' => $name,'email' => $email,'phone' => $phone,'address' => $address,'status' => $status,'login_ip' => $login_ip),false);
				if($queryinsert){
					$msg= base64_encode('Site User Added Successfully!');
					echo "<script> window.location='siteuser_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='siteuser_list.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_POST['updateuser'])){
				$username =cleaninputfield($mysql,$_POST['username']);
				$password =cleaninputfield($mysql,$_POST['password']);
				$newpassword =cleaninputfield($mysql,$_POST['newpassword']);	
				$conf_password =cleaninputfield($mysql,$_POST['conf_password']);
				$name =cleaninputfield($mysql,$_POST['name']);
				$email =cleaninputfield($mysql,$_POST['email']);
				$phone =cleaninputfield($mysql,$_POST['phone']);
				$address =cleaninputfield($mysql,$_POST['address']);
				$login_ip=$_SERVER['REMOTE_ADDR'];
				$status = isset($_POST['status']) ? 1 : 0;
				$userid = $_POST['userid'];
				
				if(strlen($password) >0){
					$postrow = $mysql->fetch_row("siteuser_tbl","id=$userid");
					$db_password = $postrow['password'];
					if($password == $db_password){
						if($newpassword == $conf_password && $newpassword!=""){
							$queryupdate = $mysql->record_update("siteuser_tbl",array('username' => $username,'password' => $newpassword,'name' => $name,'email' => $email,'phone' => $phone,'address' => $address,'status' => $status,'login_ip' => $login_ip),"id=$userid");
							if($queryupdate){
								$msg= base64_encode('Site User Updated Successfully!');
								echo "<script> window.location='siteuser_list.php?msg=$msg';</script>";
								exit();
							
							}else{
								$msg= base64_encode(mysqli_error($mysql->connection));
								echo "<script> window.location='siteuser_list.php?msge=$msg';</script>";
								exit();
							}
						}else{
							$msg= base64_encode('New Password and Confirm Password doesnot match!');
							echo "<script> window.location='siteuser_list.php?msge=$msg';</script>";
							exit();
						}
					}else{
						$msg= base64_encode('Old Password doesnot match!');
						echo "<script> window.location='siteuser_list.php?msge=$msg';</script>";
						exit();
					}
				}else{
					$queryupdate = $mysql->record_update("siteuser_tbl",array('username' => $username,'name' => $name,'email' => $email,'phone' => $phone,'address' => $address,'status' => $status,'login_ip' => $login_ip),"id=$userid");
					if($queryupdate){
						$msg= base64_encode('Site User Updated Successfully!');
						echo "<script> window.location='siteuser_list.php?msg=$msg';</script>";
						exit();
					}else{
						$msg= base64_encode(mysqli_error($mysql->connection));
						echo "<script> window.location='siteuser_list.php?msge=$msg';</script>";
						exit();
					}
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("siteuser_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="user_form" id="user_form" >
		<div class="container">
			<h2>Add / Edit Site User</h2>
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
					<td><label for="password"><?php if(isset($postrow)){?> Old <?php } ?> Password</label></td>
					<td><input name="password" id="password" type="password" /></td>
				  </tr>
				  <?php if(isset($postrow)){?> 
				   <tr> 	 	
					<td><label for="newpassword"> New Password</label></td>
					<td><input name="newpassword" id="newpassword" type="password" /></td>
				  </tr>
				  <?php } ?>
				  <tr>
				    <td><label for="conf_password">Confirm Password </label></td>
				    <td><input name="conf_password" id="conf_password" type="password"/></td>
		      </tr>
				  <tr>
					<td><label for="name">Full Name</label></td>
					<td>
					<input name="name" id="name" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['name']; ?>"<?php } ?>/>					</td>
				  </tr>
				  <tr>
					<td><label for="email">Email</label></td>
					<td>
					<input name="email" id="email" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['email']); ?>"<?php } ?>/>					</td>
				  </tr>
				  
				  <tr>
					<td><label for="phone">Phone</label></td>
					<td><input name="phone" id="phone" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['phone']); ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td><label for="address">Address</label></td>
					<td><label>
					  <textarea name="address" id="address"><?php if(isset($postrow)){ echo stripslashes($postrow['address']); } ?></textarea>
					</label></td>
				  </tr>
				    	 	 	 	 	 	 
				  
				  <tr>
					<td><label for="status">Status</label></td>
					<td><input name="status" id="status" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['status']==1){?> checked="checked" <?php } ?>/></td>
				  </tr>  
			  </table>
		
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="userid" id="userid" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updateuser" id="updateuser" value="updateuser" />
				<input name="update" id="update" border="0" type="submit" value="Update Site User" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="adduser" id="adduser" value="adduser" />
				<input name="add" id="add" border="0" type="submit" value="Add Site User" class="addpagebtn" />
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
