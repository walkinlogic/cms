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
				$header_css = cleaninputfield($mysql,$_POST['header_css']);
				$custom_js = cleaninputfield($mysql,$_POST['custom_js']);
				 
				
				$creation_date =  date('Y-m-d h:i:s');
				$created_by = $_SESSION['LOGGERID'];
				$pageid=1;
				$queryupdate = $mysql->record_update("config_tbl",array('header_css' => $header_css,'custom_js' => $custom_js),"id=$pageid");
				if($queryupdate){ 
					$msg= base64_encode('Site Config Updated Successfully!');
					echo "<script> window.location='custom.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='custom.php?msge=$msg';</script>";
					exit();
				}
			
			}	
				 
			$postrow = $mysql->fetch_row("config_tbl","id=1");
			$header_css = stripslashes($postrow['header_css']);  
			$custom_js = stripslashes($postrow["custom_js"]);
				
			 	
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
					<th>Custom CSS</th>
				  </tr>
				  <tr>
					<td><textarea name="header_css" id="header_css" style="width:98%" rows="10"><?php echo $header_css; ?></textarea></td>
				  </tr>
				   <tr class="separator"> <td>&nbsp;</td>
				   </tr>
                   <tr class="headerbar">
					<th>Custom JS</th>
				  </tr>
				  <tr>
					<td><textarea name="custom_js" id="custom_js" style="width:98%" rows="10"><?php echo $custom_js; ?></textarea></td>
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
