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
			<h2>Account Information</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl">
				  <?php 
					$id = $_SESSION['LOGGERID'];
					$postrow = $mysql->fetch_row("user_tbl","id=$id",array('sortColumn' => 'id','sortType'=>'ASC'));
					if($mysql->affected_rows>0){
							?>
							<tr class="headerbar">
							<th colspan="2" align="left"> &nbsp; Welcome, <?php echo ucfirst($_SESSION['LOGGER_NAME']); ?></th>
							</tr>
							<tr class="alignleft" height="30px;">
							<td class="alignleft">Full Name</td>
							<td class="alignleft"><?php echo $postrow['full_name']; ?></td>
							</tr>
							
							<tr class="alttr" height="30px;">
							<td class="alignleft"> Username</td>
							<td class="alignleft"><?php echo $postrow['full_name']; ?></td>
							</tr>
							
							<tr class="alignleft" height="30px;">
							<td class="alignleft">Password</td>
							<td class="alignleft"><?php echo $postrow['password']; ?></td>
							</tr>
							
							<tr class="alttr" height="30px;">
							<td class="alignleft">Email </td>
							<td class="alignleft"><?php echo $postrow['email']; ?></td>
							</tr>
							<tr class="alignleft" height="30px;">
							<td class="alignleft">Account Creation Date</td>
							<td class="alignleft"><?php echo $postrow['creationdate']; ?></td>
							</tr>
							
							<tr class="alttr" height="30px;">
							<td class="alignleft">Last Login Info </td>
							<td class="alignleft"><?php echo $postrow['lastlogindate']; ?></td>
							</tr>
							<tr class="alignleft" height="30px;">
							<td class="alignleft">IP Address</td>
							<td class="alignleft"><?php echo $postrow['login_ip']; ?></td>
							</tr>
							<tr class="alttr" height="30px;">
							<td class="alignleft">Account Status</td>
							<td class="alignleft"><?php echo ($postrow['status']==1)? "Active" :"Inactive"; ?></td>
							</tr>
				  		<?php } ?> 
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