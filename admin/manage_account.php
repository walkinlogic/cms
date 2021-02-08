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
		<div class="container">
			<h2>Account Management</h2>
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
					<th width="8%">Edit </th>
				  </tr>
				<?php
					if(isset($_SESSION['LOGGERID'])){
						$args1 = $_SESSION['LOGGERID'];
						$postrow = $mysql->fetch_row("user_tbl","id=$args1");
					}
					?>			
				
				  <tr <?php echo $row_class; ?>>
					<td class="alignleft"><?php echo $postrow['full_name']; ?></td>
					<td class="alignleft"><?php echo stripslashes($postrow['email']); ?></td>
					<td><?php echo $postrow['lastlogindate']; ?></td>
					<td><?php echo $postrow['login_ip']; ?></td>
					<td align="left"><img src='images/active.png' border='0' alt='active' /> Active </td>
					<td><a href="update_account.php?args1=<?php echo base64_encode($postrow['id']); ?>"><img src="images/edituser.png" border="0" alt="edit user" title="Edit" /></a></td>
				  </tr>

				</table>
			</div>
		</div>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php");
			?>
		</div><!--wrap end here-->
	</body>
</html>