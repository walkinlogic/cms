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
	<!---------Calendar Control------------>
	<link href="calendar/dhtmlgoodies_calendar.css" type="text/css" rel="stylesheet">
	<link href="calendar/CalendarControl.css" type="text/css" rel="stylesheet">
	<script language="JavaScript" type="text/javascript" src="calendar/dhtmlgoodies_calendar.js"></script>
	<script language="JavaScript" src="calendar/calendarcontrol.js"></script>
	<!---------Calendar Control end------------>
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		<div class="container-top"></div>
				<?php 
			if(isset($_POST['addfaq'])){
				$question = cleaninputfield($mysql,$_POST['question']);
				$ar_question = cleaninputfield($mysql,$_POST['ar_question']);

				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);
				$faqdate = $_POST['faqdate'];
				$answer = cleaninputfield($mysql,$_POST['answer']);
				$ar_answer = cleaninputfield($mysql,$_POST['ar_answer']);
				$status = ($_POST['status']) ? 1 : 0;
				
				$queryinsert = $mysql->record_insert("faqs_tbl",array('question' => $question,'ar_question' => $ar_question,'faqdate' => $faqdate,'sortorder' => $sortorder,'answer' => $answer,'ar_answer' => $ar_answer,'status' => $status),false);
				if($queryinsert){
					$msg= base64_encode('FAQ Added Successfully!');
					echo "<script> window.location='faqs_list.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='faqs_list.php?msge=$msg';</script>";
					exit();
				}			
			}
		
			if(isset($_POST['updatefaq'])){
				$question = cleaninputfield($mysql,$_POST['question']);
				$ar_question = cleaninputfield($mysql,$_POST['ar_question']);
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);
				$faqdate = $_POST['faqdate'];
				$answer = cleaninputfield($mysql,$_POST['answer']);
				$ar_answer = cleaninputfield($mysql,$_POST['ar_answer']);
				$status = ($_POST['status']) ? 1 : 0;
				$faqid = $_POST['faqid'];
				
				$queryupdate = $mysql->record_update("faqs_tbl",array('question' => $question,'ar_question' => $ar_question,'faqdate' => $faqdate,'sortorder' => $sortorder,'answer' => $answer,'ar_answer' => $ar_answer,'status' => $status),"id=$faqid");
				if($queryupdate){
					$msg= base64_encode('FAQ Updated Successfully!');
					echo "<script> window.location='faqs_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='faqs_list.php?msge=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['args1'])){
				$args1 =cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("faqs_tbl","id=$args1");
			}
			?>
		<form action="" method="post" name="news_form" id="news_form" >
		<div class="container">
			<h2>Add / Edit FAQ </h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="9%"><label for="question">Question</label></td>
					<td width="91%"><input name="question" id="question" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['question']); ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td width="9%"><label for="ar_question">Question in Arabic</label></td>
					<td width="91%"><input name="ar_question" id="ar_question" type="text" <?php if(isset($postrow)){?> value="<?php echo stripslashes($postrow['ar_question']); ?>"<?php } ?>/></td>
				  </tr>
				   <tr>
				     <td><label for="faqdate">Date</label></td>
				     <td><input name="faqdate" id="faqdate" readonly="readonly" type="text" value="<?php if(isset($postrow)){ echo $postrow['faqdate']; }else{ echo date('Y-m-d'); }?>" onfocus="displayCalendar(document.getElementById('faqdate'),'yyyy-mm-dd', document.getElementById('faqdate'));"> <img src="images/caldp.jpg" onClick="displayCalendar(document.getElementById('faqdate'),'yyyy-mm-dd', document.getElementById('faqdate'));" style="cursor:pointer;"></td>
		      </tr>
				   <tr>
				     <td><label for="sortorder">Sort Order</label></td>
				     <td><?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("faqs_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
				<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>"/></td>
		      </tr>
				   <tr>
					<td width="9%"><label for="status">Status</label></td>
					<td width="91%"><input name="status" id="status" type="checkbox" <?php if(isset($postrow) && $postrow['status']==1){ ?> checked="checked" <?php } ?>/></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="answer">Answer</label></td>
					<td><textarea name="answer" id="answer" style="width:97%" rows="12"><?php if(isset($postrow)){ echo stripslashes($postrow['answer']); } ?></textarea></td>
				  </tr>
                  <tr>
					<td valign="top"><label for="ar_answer">Answer in Arabic</label></td>
					<td><textarea name="ar_answer" id="ar_answer" style="width:97%" rows="12"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_answer']); } ?></textarea></td>
				  </tr>
			  </table>
		</div>
		<div class="addbtn-right">
	<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="faqid" id="faqid" value="<?php echo $postrow['id']; ?>" />
				<input type="hidden" name="updatefaq" id="updatefaq" value="updatefaq" />
				<input name="update" id="update" border="0" type="submit" value="Update FAQ" class="addpagebtn" />
	  <?php }else{ ?>
				<input type="hidden" name="addfaq" id="addfaq" value="addfaq" />
				<input name="add" id="add" border="0" type="submit" value="Add FAQ" class="addpagebtn" />
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
