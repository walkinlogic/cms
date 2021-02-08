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
	include_once("includes/thumbnail_images.class.php");      /// thumbnail class
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include_once("widgets/meta_tags.php"); /// end of header
	?>
	<script language="javascript">
	function Validate(){
		var page_name=document.getElementById('pagename').value;
		var internal_link=document.getElementById('internal_link').value;
		if(page_name==""){
			alert('Please enter page name!');
			return false;
		}
		if(internal_link==""){
			document.getElementById('internal_link').value=page_name;
		}
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
		
		
			if(isset($_POST['updatepage'])){
				$pagename = cleaninputfield($mysql,$_POST['pagename']);
				$ar_pagename = cleaninputfield($mysql,$_POST['ar_pagename']);
				$internal_link = cleaninputfield($mysql,$_POST['internal_link']);
				$external_link = cleaninputfield($mysql,$_POST['external_link']);
				$link_target = cleaninputfield($mysql,$_POST['link_target']);
				$parentpageid = cleaninputfield($mysql,$_POST['parentpageid']);
				$childpageid = cleaninputfield($mysql,$_POST['childpageid']);
				$metatitle = cleaninputfield($mysql,$_POST['metatitle']);
				$ar_metatitle = cleaninputfield($mysql,$_POST['ar_metatitle']);
				
				$metadescription = cleaninputfield($mysql,$_POST['metadescription']);
				$ar_metadescription = cleaninputfield($mysql,$_POST['ar_metadescription']);
				
				$metakeywords = cleaninputfield($mysql,$_POST['metakeywords']);
				$ar_metakeywords = cleaninputfield($mysql,$_POST['ar_metakeywords']);
				
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);
				$newsmodule = isset($_POST['newsmodule']) ? 1 : 0;
				$gallerymodule = isset($_POST['gallerymodule']) ? 1 : 0;
				$slideshowmodule = isset($_POST['slideshowmodule']) ? 1 : 0;
				$iscustomregion = isset($_POST['iscustomregion']) ? 1 : 0;
				$formmodule = isset($_POST['formmodule']) ? $_POST['formmodule'] : '';
				$expandablemodule = isset($_POST['expandablemodule']) ? 1 : 0;
				$custommodule = isset($_POST['custommodule']) ? 1 : 0;
				$downloadmodules = isset($_POST['downloadmodules']) ? 1 : 0;
				$clientreviews = isset($_POST['clientreviews']) ? 1 : 0;
				$pagestatus = isset($_POST['pagestatus']) ? 1 : 0;
				$issecure = isset($_POST['issecure']) ? 1 : 0;
				
				$ourstaff = isset($_POST['ourstaff']) ? 1 : 0;
				$quoteform = isset($_POST['quoteform']) ? 1 : 0;
				$downloadmoduleid = isset($_POST['downloadmoduleid']) ? 1 : 0;
				$contactdetailsmodules = isset($_POST['contactdetailsmodules']) ? 1 : 0;
				$tradeshowmodules = isset($_POST['tradeshowmodules']) ? 1 : 0;
				$industriesapplicationsmodules = isset($_POST['industriesapplicationsmodules']) ? 1 : 0;
				$howmanycontacts = isset($_POST['howmanycontacts']) ? $_POST['howmanycontacts'] : 1;
				$howmanydownloads = isset($_POST['howmanydownloads']) ? $_POST['howmanydownloads'] : 1;
				$servicesmodules = isset($_POST['servicesmodules']) ? $_POST['servicesmodules'] : 1;
				$pageid = $_POST['pageid'];	
				
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);
				$pdffile = cleaninputfield($mysql,$_POST['oldpdffile']);
				if($_FILES['image']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 141;
						$obj_img->NewHeight = 141;
						$obj_img->create_thumbnail_images();					
					}
				 }
				 if($_FILES['pdffile']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$pdffile=fileExists($_FILES['pdffile']['name'],"../uploaded/");
					copy($_FILES['pdffile']['tmp_name'],"../uploaded/".$pdffile);
				 }
				 
				 
				$queryupdate = $mysql->record_update("content_tbl",array('howmanydownloads' => $howmanydownloads,'howmanycontacts' => $howmanycontacts,'industriesapplicationsmodules' => $industriesapplicationsmodules,'tradeshowmodules' => $tradeshowmodules,'contactdetailsmodules' => $contactdetailsmodules,'downloadmoduleid' => $downloadmoduleid,'ourstaff' => $ourstaff,'quoteform' => $quoteform,'clientreviews' => $clientreviews,'downloadmodules' => $downloadmodules,'pdffile' => $pdffile,'image' => $imagename,'iscustomregion' => $iscustomregion,'pagename' => $pagename,'ar_pagename' => $ar_pagename, 'internal_link' => $internal_link,'external_link' => $external_link, 'link_target' => $link_target,'parentpageid' => $parentpageid, 'metatitle' => $metatitle,'ar_metatitle' => $ar_metatitle,'metakeywords' => $metakeywords,'ar_metakeywords' => $ar_metakeywords, 'metadescription' => $metadescription,'ar_metadescription' => $ar_metadescription,'sortorder' => $sortorder, 'newsmodule' => $newsmodule,'gallerymodule' => $gallerymodule, 'slideshowmodule' => $slideshowmodule,'formmodule' => $formmodule, 'expandablemodule' => $expandablemodule,'pagestatus' => $pagestatus,'issecure' => $issecure,'custommodule' => $custommodule,'servicesmodules' => $servicesmodules),"id=$pageid");
				if($queryupdate){
					$msg= base64_encode('Page Updated Successfully!');
					echo "<script> window.location='pages_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='pages_list.php?msge=$msg';</script>";
					exit();
				}
			}
		if(isset($_POST['addpage'])){
				$pagename = cleaninputfield($mysql,$_POST['pagename']);
				$ar_pagename = cleaninputfield($mysql,$_POST['ar_pagename']);
				$internal_link = cleaninputfield($mysql,$_POST['internal_link']);
				$external_link = cleaninputfield($mysql,$_POST['external_link']);
				$link_target = cleaninputfield($mysql,$_POST['link_target']);
				$parentpageid = cleaninputfield($mysql,$_POST['parentpageid']);
				$childpageid = cleaninputfield($mysql,$_POST['childpageid']);
				$metatitle = cleaninputfield($mysql,$_POST['metatitle']);
				$ar_metatitle = cleaninputfield($mysql,$_POST['ar_metatitle']);
				
				$metadescription = cleaninputfield($mysql,$_POST['metadescription']);
				$ar_metadescription = cleaninputfield($mysql,$_POST['ar_metadescription']);
				
				$metakeywords = cleaninputfield($mysql,$_POST['metakeywords']);
				$ar_metakeywords = cleaninputfield($mysql,$_POST['ar_metakeywords']);
				
				$sortorder = cleaninputfield($mysql,$_POST['sortorder']);
				$newsmodule = isset($_POST['newsmodule']) ? 1 : 0;
				$gallerymodule = isset($_POST['gallerymodule']) ? 1 : 0;
				$slideshowmodule = isset($_POST['slideshowmodule']) ? 1 : 0;
				$iscustomregion = isset($_POST['iscustomregion']) ? 1 : 0;
				$formmodule = isset($_POST['formmodule']) ? $_POST['formmodule'] : '';
				$expandablemodule = isset($_POST['expandablemodule']) ? 1 : 0;
				$custommodule = isset($_POST['custommodule']) ? 1 : 0;
				$pagestatus = isset($_POST['pagestatus']) ? 1 : 0;
				$issecure = isset($_POST['issecure']) ? 1 : 0;
				$ourstaff = isset($_POST['ourstaff']) ? 1 : 0;
				$quoteform = isset($_POST['quoteform']) ? 1 : 0;
				$downloadmoduleid = isset($_POST['downloadmoduleid']) ? 1 : 0;
				$tradeshowmodules = isset($_POST['tradeshowmodules']) ? 1 : 0;
				
				$pageid = $_POST['pageid'];	
				$downloadmodules = isset($_POST['downloadmodules']) ? 1 : 0;
				$contactdetailsmodules = isset($_POST['contactdetailsmodules']) ? 1 : 0;
				$howmanycontacts = isset($_POST['howmanycontacts']) ? $_POST['howmanycontacts'] : 1;
				$howmanydownloads = isset($_POST['howmanydownloads']) ? $_POST['howmanydownloads'] : 1;
				$clientreviews = isset($_POST['clientreviews']) ? 1 : 0;
				$servicesmodules = isset($_POST['servicesmodules']) ? 1 : 0;
				$industriesapplicationsmodules = isset($_POST['industriesapplicationsmodules']) ? 1 : 0;
				$imagename = cleaninputfield($mysql,$_POST['oldimage']);
				if($_FILES['image']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$imagename=fileExists($_FILES['image']['name'],"../uploaded/");
					if(copy($_FILES['image']['tmp_name'],"../uploaded/".$imagename)) {
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = "../uploaded/$imagename";
						$obj_img->PathImgNew = "../uploaded/thumbs/$imagename";
						$obj_img->NewWidth = 141;
						$obj_img->NewHeight = 141;
						$obj_img->create_thumbnail_images();					
					}
				 }
				 
				$pdffile = cleaninputfield($mysql,$_POST['oldpdffile']);
				if($_FILES['pdffile']['tmp_name']!=''){
					@unlink("../uploaded/$oldimage");
					@unlink("../uploaded/thumbs/$oldimage");
					$imagename=fileExists($_FILES['pdffile']['name'],"../uploaded/");
					if(copy($_FILES['pdffile']['tmp_name'],"../uploaded/".$pdffile)) {
						 					
					}
				 }
				 
				$queryupdate = $mysql->record_insert("content_tbl",array('howmanydownloads' => $howmanydownloads,'howmanycontacts' => $howmanycontacts,'industriesapplicationsmodules' => $industriesapplicationsmodules,'tradeshowmodules' => $tradeshowmodules,'contactdetailsmodules' => $contactdetailsmodules,'downloadmoduleid' => $downloadmoduleid,'ourstaff' => $ourstaff,'quoteform' => $quoteform,'clientreviews' => $clientreviews,'servicesmodules' => $servicesmodules,'downloadmodules' => $downloadmodules,'pdffile' => $pdffile,'image' => $imagename,'iscustomregion' => $iscustomregion,'pagename' => $pagename,'ar_pagename' => $ar_pagename, 'internal_link' => $internal_link,'external_link' => $external_link, 'link_target' => $link_target,'parentpageid' => $parentpageid, 'metatitle' => $metatitle,'ar_metatitle' => $ar_metatitle,'metakeywords' => $metakeywords,'ar_metakeywords' => $ar_metakeywords, 'metadescription' => $metadescription,'ar_metadescription' => $ar_metadescription,'sortorder' => $sortorder, 'newsmodule' => $newsmodule,'gallerymodule' => $gallerymodule, 'slideshowmodule' => $slideshowmodule,'formmodule' => $formmodule, 'expandablemodule' => $expandablemodule,'pagestatus' => $pagestatus,'issecure' => $issecure,'custommodule' => $custommodule));
				if($queryupdate){
					$msg= base64_encode('Page Updated Successfully!');
					echo "<script> window.location='pages_list.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='pages_list.php?msge=$msg';</script>";
					exit();
				}
			}
			if(isset($_GET['args1'])){
				$args1 = cleaninputfield($mysql,$_GET['args1']);
				$postrow = $mysql->fetch_row("content_tbl","id=$args1");
				
			}
			?>
		<form action="" method="post" name="page_form" id="page_form" enctype="multipart/form-data" onsubmit="return Validate()">
		<div class="container">
			<h2> Edit Page</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="content">
			<div class="content-bar"></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addpage">
				  <tr>
					<td width="26%"><label for="pagename">Page Name</label></td>
					<td width="74%"><input name="pagename" id="pagename" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['pagename']; ?>"<?php } ?> /></td>
				  </tr>
				  <tr>
					<td width="26%"><label for="ar_pagename">Page Name in Arabic</label></td>
					<td width="74%"><input name="ar_pagename" id="ar_pagename" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_pagename']; ?>"<?php } ?> /></td>
				  </tr>
				  <tr> 	 	
					<td><label for="internal_link">Page Navigation Link</label></td>
					<td><input name="internal_link" id="internal_link" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['internal_link']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td><label for="external_link">Page External Link</label></td>
					<td>
					<input name="external_link" id="external_link" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['external_link']; ?>"<?php } ?>/></td>
				  </tr>
				  
				  <tr>
					<td><label for="link_target">Link Target</label></td>
					<td><select name="link_target" id="link_target">
							<option value="0"> &laquo; Link Target &raquo;  </option>
							<option value="0">  Same Window   </option>
							<option value="1"<?php echo ($postrow['link_target']==1)? "seleced='selected'":""; ?>>  New Window  </option>
					</select>					</td>
				  </tr>
 	 	 	 	  
				  
				  <tr>
					<td><label for="parentpageid">Sub Page of</label></td>
					<td>
						<select name="parentpageid" id="parentpageid">
							<option value="0"> &laquo; Parent Page &raquo;  </option>
							<?php 
								$rows = $mysql->list_table("content_tbl","parentpageid=0");
								if($mysql->affected_rows>0){
									foreach($rows as $value => $row){ 
										$parent_id = $row['id'];
										  if(strlen($row['internal_link'])>0){
												$toplevel_page = stripslashes($row['internal_link']);
											}else{
												$toplevel_page = stripslashes($row['pagename']);
											} 

										$sel_1 = ($row['id'] == $postrow['parentpageid']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo $sel_1; ?>> <?php echo $toplevel_page; ?> </option>			
							<?php 
										$subrows = $mysql->list_table("content_tbl","parentpageid=$parent_id");
										if($mysql->affected_rows>0){
											foreach($subrows as $value => $subrow){ 
												$subpage_id= $subrow['id'];
												if(strlen($subrow['internal_link'])>0){
													$sel_2 = ($subrow['id'] == $postrow['parentpageid']) ? "selected='selected'" : "";
													$sublevel_page = stripslashes($subrow['internal_link']);
												}else{
													$sublevel_page = stripslashes($subrow['pagename']);
												} ?>
												<option value="<?php echo $subrow['id']; ?>" <?php echo $sel_2; ?>> &nbsp;  &nbsp; <?php echo $sublevel_page; ?> </option>			
												
											<?php 
											/* $childrows = $mysql->list_table("content_tbl","parentpageid=$subpage_id");
											if($mysql->affected_rows>0){
												foreach($childrows as $value => $childrow){ 
													if(strlen($childrow['internal_link'])>0){
														$sel_3 = ($childrow['id'] == $postrow['parentpageid']) ? "selected='selected'" : "";
														$childlevel_page = stripslashes($childrow['internal_link']);
													}else{
														$childlevel_page = stripslashes($childrow['pagename']);
													} ?>
													<option value="<?php echo $childrow['id']; ?>" <?php echo $sel_3; ?>> &nbsp;  &nbsp; &nbsp; &nbsp; <?php echo $childlevel_page; ?> </option>		
													<?php
													}
												} */	
											}
										}  
									}
								}
								?>
						</select>					</td>
				  </tr>
				  <tr>
					<td><label for="metatitle">Meta Page Title</label></td>
					<td><input name="metatitle" id="metatitle" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['metatitle']; ?>"<?php } ?>/></td>
				  </tr>
                  <tr>
					<td><label for="ar_metatitle">Meta Page Title in Arabic</label></td>
					<td><input name="ar_metatitle" id="ar_metatitle" type="text" <?php if(isset($postrow)){?> value="<?php echo $postrow['ar_metatitle']; ?>"<?php } ?>/></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="metakeywords">Meta Page Description</label></td>
					<td><textarea name="metakeywords" id="metakeywords" cols="10" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['metakeywords']); } ?></textarea></td>
				  </tr>
                  <tr>
					<td valign="top"><label for="ar_metakeywords">Meta Page Description in Arabic</label></td>
					<td><textarea name="ar_metakeywords" id="ar_metakeywords" cols="10" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_metakeywords']); } ?></textarea></td>
				  </tr>
				  <tr>
					<td valign="top"><label for="metadescription">Meta Page Keywords</label></td>
					<td><textarea name="metadescription" id="metadescription" cols="10" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['metadescription']); } ?></textarea></td>
				  </tr>
                  <tr>
					<td valign="top"><label for="metadescription">Meta Page Keywords in Arabic</label></td>
					<td><textarea name="ar_metadescription" id="ar_metadescription" cols="10" rows="3"><?php if(isset($postrow)){ echo stripslashes($postrow['ar_metadescription']); } ?></textarea></td>
				  </tr>
				  <tr>
					<td><label for="sortorder">Page Order</label></td>
					<td>
					<?php 
						if(isset($postrow)){
							$max_value = $postrow['sortorder'];
						}else{
							$max_value = $mysql->table_max_value("content_tbl","sortorder"); 
							$max_value += 1;
						}
						?>
				<input name="sortorder" id="sortorder" type="text" value="<?php echo $max_value; ?>"/></td>
				  </tr>
				  
				  <tr>
					<td><label for="image">Image </label></td>
					<td>&nbsp;<input type="file" name="image" id="image" />
						<?php  if(isset($postrow)){?> 
						<input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['image'] ?>" /> 
						<?php echo "(   $postrow[image]   )"; } /// end of the file uploading updation ?>
						
					</td>
				</tr>	
				  
				  <tr>
					<td><label for="pdffile">Downloadable File </label></td>
					<td>&nbsp;<input type="file" name="pdffile" id="pdffile" />
						<?php  if(isset($postrow)){?> 
						<input type="hidden" name="oldpdffile"  id="oldpdffile" value="<?php echo $postrow['pdffile'] ?>" /> 
						<?php echo "(   $postrow[pdffile]   )"; } /// end of the file uploading updation ?>
						
					</td>
				</tr>	
					
				  <tr>
					<td><label for="formmodule">Add Form module</label></td>
					<td>
					<select name="formmodule" id="formmodule">
							<option value="0"> &laquo; No Form &raquo;  </option>
							<?php 
								$rows2 = $mysql->list_table("formconfig_tbl","id > 0");
								if($mysql->affected_rows>0){
									foreach($rows2 as $value => $row2){
										$sel_2 = ($row2['id'] == $postrow['formmodule']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $row2['id']; ?>" <?php echo $sel_2; ?>> <?php echo $row2['title']; ?> </option>
							<?php 
									}
								}
								?>
						</select>						</td>
				  </tr>
				  
				  <tr>
					<td><label for="servicesmodules">Add Services module</label></td>
					<td><input name="servicesmodules" id="servicesmodules" type="checkbox" value="1" class="checkbox" <?php if(isset($postrow) && $postrow['servicesmodules']==1){?> checked="checked" <?php } ?>/> <label for="servicesmodules"> Active </label></td>
				  </tr>
				  <tr>
					<td><label for="newsmodule">Add News module</label></td>
					<td><input name="newsmodule" id="newsmodule" type="checkbox" value="1" class="checkbox" <?php if(isset($postrow) && $postrow['newsmodule']==1){?> checked="checked" <?php } ?>/> <label for="newsmodule"> Active </label></td>
				  </tr>
				  <tr>
					<td><label for="gallerymodule">Add Gallery module</label></td>
					<td><input name="gallerymodule" id="gallerymodule" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['gallerymodule']==1){?> checked="checked" <?php } ?>/> <label for="gallerymodule"> Active </label></td>
				  </tr>
				    	 	 	 	 	 	 
				  <tr>
					<td><label for="slideshowmodule">Add Image Slideshow module</label></td>
					<td><input name="slideshowmodule" id="slideshowmodule" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['slideshowmodule']==1){?> checked="checked" <?php } ?>/> <label for="slideshowmodule"> Active </label></td>
				  </tr>
				  
				  <tr>
					<td><label for="expandablemodule">Add Expandable Content module</label></td>
					<td><input name="expandablemodule" id="expandablemodule" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['expandablemodule']==1){?> checked="checked" <?php } ?>/> <label for="expandablemodule"> Active </label></td>
				  </tr>
				  
				  <tr>
					<td><label for="custommodule">Add Our Work</label></td>
					<td><input name="custommodule" id="custommodule" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['custommodule']==1){?> checked="checked" <?php } ?>/> <label for="custommodule"> Active </label></td>
				  </tr>	
				  <tr>
					<td><label for="clientreviews">Add Client Reviews Module</label></td>
					<td><input name="clientreviews" id="clientreviews" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['clientreviews']==1){?> checked="checked" <?php } ?>/> <label for="clientreviews"> Active </label></td>
				  </tr>
				  <tr>
					<td><label for="ourstaff">Our Staff</label></td>
					<td><input name="ourstaff" id="ourstaff" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['ourstaff']==1){?> checked="checked" <?php } ?>/> <label for="ourstaff"> Active </label></td>
				  </tr>
				  <tr>
					<td><label for="quoteform">Get A Quote</label></td>
					<td><input name="quoteform" id="quoteform" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['quoteform']==1){?> checked="checked" <?php } ?>/> <label for="quoteform"> Active </label></td>
				  </tr>	
				  <?php /* <tr>
					<td><label for="iscustomregion">Add Custom region</label></td>
					<td><input name="iscustomregion" id="iscustomregion" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['iscustomregion']==1){?> checked="checked" <?php } ?>/> <label for="iscustomregion"> Active </label></td>
				  </tr> */ ?>
				  <?php /* <tr>
					<td><label for="downloadmodules">Add Download Module</label></td>
					<td><input name="downloadmodules" id="downloadmodules" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['downloadmodules']==1){?> checked="checked" <?php } ?>/> <label for="downloadmodules"> Active </label></td>
				  </tr> */ ?>
				  
				 <?php /*  <tr>
					<td><label for="contactdetailsmodules">Add Contact World Module</label></td>
					<td><input name="contactdetailsmodules" id="contactdetailsmodules" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['contactdetailsmodules']==1){?> checked="checked" <?php } ?>/> <label for="contactdetailsmodules"> Active </label></td>
				  </tr> */ ?>
				  
				  
				  <?php /* <tr>
					<td><label for="howmanycontacts">How Many Contacts</label></td>
					<td>
					<select name="howmanycontacts" id="howmanycontacts">
							<option value="0"> &laquo; How Many Downloads &raquo;  </option>
							<?php 
								 
									for($x=1;$x<6;$x++){
										$sel_2 = (isset($postrow) && $x == $postrow['howmanycontacts']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $x; ?>" <?php echo $sel_2; ?>> <?php echo $x; ?> </option>
							<?php 
									}
							 
								?>
						</select>						</td>
				  </tr> 
				  <tr>
					<td><label for="downloadmoduleid">Add Download sidebar</label></td>
					<td><input name="downloadmoduleid" id="downloadmoduleid" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['downloadmoduleid']==1){?> checked="checked" <?php } ?>/> <label for="downloadmoduleid"> Active </label></td>
				  </tr>
				  <tr>
					<td><label for="howmanydownloads">How Many Downloads</label></td>
					<td>
					<select name="howmanydownloads" id="howmanydownloads">
							<option value="0"> &laquo; How Many Downloads &raquo;  </option>
							<?php 
								 
									for($x=1;$x<6;$x++){
										$sel_2 = (isset($postrow) && $x == $postrow['howmanydownloads']) ? "selected='selected'" : "";
									?>
									<option value="<?php echo $x; ?>" <?php echo $sel_2; ?>> <?php echo $x; ?> </option>
							<?php 
									}
							 
								?>
						</select>						</td>
				  </tr>  
				  <tr>
					<td><label for="tradeshowmodules">Add Trade Show Module</label></td>
					<td><input name="tradeshowmodules" id="tradeshowmodules" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['tradeshowmodules']==1){?> checked="checked" <?php } ?>/> <label for="tradeshowmodules"> Active </label></td>
				  </tr>
				  <tr>
					<td><label for="industriesapplicationsmodules">Add Industries Applications Module</label></td>
					<td><input name="industriesapplicationsmodules" id="industriesapplicationsmodules" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['industriesapplicationsmodules']==1){?> checked="checked" <?php } ?>/> <label for="industriesapplicationsmodules"> Active </label></td>
				  </tr> */ ?>
				  
				  
				  <tr>
					<td><label for="pagestatus">Page Status</label></td>
					<td><input name="pagestatus" id="pagestatus" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['pagestatus']==1){?> checked="checked" <?php } ?>/> <label for="pagestatus"> Active </label></td>
				 </tr>  
				  
			    <?php /*  <tr>
							<td><label for="issecure">Is Secure</label> </td>
							<td><input name="issecure" id="issecure" type="checkbox" value="1" <?php if(isset($postrow) && $postrow['issecure']==1){?> checked="checked" <?php } ?>/> <label for="issecure"> Active </label></td>
						</tr> */ ?>
			 </table>
		
		</div>
		<div class="addbtn-right">
		<?php 
			if(isset($_GET['args1'])){ ?>
				<input type="hidden" name="pageid" id="pageid" value="<?php echo $_GET['args1']; ?>" />
				<input type="hidden" name="updatepage" id="updatepage" value="updatepage" />
				<input name="update" id="update" border="0" type="submit" value="Update Page" class="addpagebtn"/>
	  <?php }else{ ?>
				<input type="hidden" name="addpage" id="addpage" value="addpage" />
				<input name="add" id="add" border="0" type="submit" value="Add Page" class="addpagebtn" />
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
