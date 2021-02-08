<?php 
	@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Content Management System</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
	function getfocus(){
		document.getElementById('username').focus();	
	}
</script>
</head>
<body >
	<div class="wrap">
	<div class="loginbg-container">
		<div class="container-top"></div>
		<div class="container">
		<div class="mainlogin">
			<?php /* <div class="sidelogo"></div> */ ?>
			<?php  if(isset($_GET['msg'])){ ?> <div class="topbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div> <?php } ?> 
			<div class="loginbox">
			<form method="post" name="loginform" id="loginform" action="authenticate.php">
			  <table width="67%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="34%"><label for="username"> Username </label></td>
					<td width="66%"><input type="text" name="username" id="username"/></td>
				  </tr>
				  <tr>
					<td><label for="password"> Password </label></td>
					<td><input type="password" name="password" id="password"/>																										
					</td>
				  </tr>
				  <tr>
					  <td>&nbsp;</td>
					  	<td><input name="remember" id="remember" type="checkbox" value="1" /><label for="remember">Remember me</label></td>
					  </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td><br /><input name="submit" id="submit" type="submit" value="Login" class="loginbtns"/>&nbsp;
					  <input name="reset" id="reset" type="reset" value="Clear" class="loginbtns"/>
					  </td>
					  </tr>
			  </table>
			  </form>		
			</div>
		</div>
		</div>
		<div class="container-bottom"></div>
	</div>
	</div><!--wrap end here-->
</body>
</html>