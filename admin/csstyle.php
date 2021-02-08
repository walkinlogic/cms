<?php 
	include_once("includes/security.php");        /// security check
	if($_SESSION['MANAGE_STYLE']==0){
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
	<script type="text/javascript" src="js/validationscript.js"></script>
	<!-- Color picker -->
	<link rel="stylesheet" href="css/js_color_picker_v2.css" media="screen">
	<script src="js/color_functions.js"></script>		
	<script type="text/javascript" src="js/js_color_picker_v2.js"></script>  
</head>
<body>
	<div class="wrap">
		<?php 
			include_once("widgets/header.php"); /// end of header
			include_once("widgets/top_menu.php"); /// end of top menu
			?>
		
		<?php 
			if(isset($_REQUEST['updatestyle']) && strlen($_REQUEST['newtag'])>0){
				 if($_FILES['bgimage']['tmp_name']!=''){
						$bgimage=fileExists($_FILES['bgimage']['name'],"../style_pictures/");
						if(copy($_FILES['bgimage']['tmp_name'],"../style_pictures/".$bgimage)) {
							$bgimage= cleaninputfield($mysql,$bgimage);
						}
					 } // end of image1 uploading
					 
				$newtag = cleaninputfield($mysql,$_POST['newtag']);
				$font = isset($_POST['inhert_font'])? '' : cleaninputfield($mysql,$_POST['font']);
				$size = isset($_POST['inhert_size'])? '' : cleaninputfield($mysql,$_POST['size']); 
				$fontweight = isset($_POST['inhert_fontweight'])? '' : cleaninputfield($mysql,$_POST['fontweight']);
				$height = isset($_POST['inhert_height'])?  '' : cleaninputfield($mysql,$_POST['height']);
				$color = isset($_POST['inhert_color'])? '' : cleaninputfield($mysql,$_POST['color']); 
				$bgcolor = isset($_POST['inhert_bgcolor'])? '' : cleaninputfield($mysql,$_POST['bgcolor']); 
				$paddingleft =  isset($_POST['inhert_lfpadd'])? '' : cleaninputfield($mysql,$_POST['paddingleft']);
				$paddingright =  isset($_POST['inhert_rtpadd'])? '' : cleaninputfield($mysql,$_POST['paddingright']);
				$paddingtop =  isset($_POST['inhert_toppadd'])? '' : cleaninputfield($mysql,$_POST['paddingtop']);
				$paddingbottom = isset($_POST['inhert_btmpadd'])? '' : cleaninputfield($mysql,$_POST['paddingbottom']);
				$marginleft =  isset($_POST['inhert_mgleft'])? '' : cleaninputfield($mysql,$_POST['marginleft']); 
				$marginright =  isset($_POST['inhert_mgright'])? '' : cleaninputfield($mysql,$_POST['marginright']); 
				$margintop =  isset($_POST['inhert_mgtop'])? '' : cleaninputfield($mysql,$_POST['margintop']); 
				$marginbottom =  isset($_POST['inhert_mgbuttom'])? '' : cleaninputfield($mysql,$_POST['marginbottom']); 
				$decoration =  isset($_POST['inhert_decoration'])? '' : cleaninputfield($mysql,$_POST['decoration']); 
				$textfloat = isset($_POST['textfloat'])? '' : cleaninputfield($mysql,$_POST['textfloat']);
				$textalign = isset($_POST['inhert_align'])? '' : cleaninputfield($mysql,$_POST['textalign']); 
				$display = isset($_POST['inhert_display'])? '' : cleaninputfield($mysql,$_POST['display']); 
				$bgimage = isset($_POST['inhert_bgimage'])? '' : cleaninputfield($mysql,$bgimage); 
				$bgposition = isset($_POST['inhert_bgposition'])? '' : cleaninputfield($mysql,$_POST['bgposition']); 
				$bgrepeat = isset($_POST['inhert_bgrepeat'])? '' : cleaninputfield($mysql,$_POST['bgrepeat']); 
				$tag = cleaninputfield($mysql,$_POST['tag']); 
				$queryinsert = $mysql->record_insert("cssstyle_tbl",array('tag' => $newtag,'font' => $font,'fontweight' => $fontweight,'size' => $size, 'color' => $color, 'bgcolor' => $bgcolor,'height' => $height, 'decoration' => $decoration,'marginleft' => $marginleft, 'marginright' => $marginright,'margintop' => $margintop, 'marginbottom' => $marginbottom,'paddingleft' => $paddingleft, 'paddingright' => $paddingright,'paddingtop' => $paddingtop, 'paddingbottom' => $paddingbottom,'textfloat' => $textfloat,'textalign' => $textalign,'display' => $display,'bgimage' => $bgimage,'bgposition' => $bgposition,'bgrepeat' => $bgrepeat),false);
				if($queryinsert){
					$msg= base64_encode('Sytle Added Successfully!');
					echo "<script> window.location='csstyle.php?msg=$msg';</script>";
					exit();
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='csstyle.php?msge=$msg';</script>";
					exit();
				}		
			}
		
			if(isset($_REQUEST['updatestyle']) && strlen($_REQUEST['newtag'])==0){
				$bgimage=$_POST['oldimage'];
				if($_FILES['bgimage']['tmp_name']!=''){
					@unlink("../style_pictures/$bgimage");
					$bgimage=fileExists($_FILES['bgimage']['name'],"../style_pictures/");
					if(copy($_FILES['bgimage']['tmp_name'],"../style_pictures/".$bgimage)) {
						$bgimage= cleaninputfield($mysql,$bgimage);				
					}
				 } /// end of updating image
				$newtag = cleaninputfield($mysql,$_POST['newtag']);
				$font = isset($_POST['inhert_font'])? '' : cleaninputfield($mysql,$_POST['font']);
				$size = isset($_POST['inhert_size'])? '' : cleaninputfield($mysql,$_POST['size']); 
				$fontweight = isset($_POST['inhert_fontweight'])? '' : cleaninputfield($mysql,$_POST['fontweight']);
				$height = isset($_POST['inhert_height'])?  '' : cleaninputfield($mysql,$_POST['height']);
				$color = isset($_POST['inhert_color'])? '' : cleaninputfield($mysql,$_POST['color']); 
				$bgcolor = isset($_POST['inhert_bgcolor'])? '' : cleaninputfield($mysql,$_POST['bgcolor']); 
				$paddingleft =  isset($_POST['inhert_lfpadd'])? '' : cleaninputfield($mysql,$_POST['paddingleft']);
				$paddingright =  isset($_POST['inhert_rtpadd'])? '' : cleaninputfield($mysql,$_POST['paddingright']);
				$paddingtop =  isset($_POST['inhert_toppadd'])? '' : cleaninputfield($mysql,$_POST['paddingtop']);
				$paddingbottom = isset($_POST['inhert_btmpadd'])? '' : cleaninputfield($mysql,$_POST['paddingbottom']);
				$marginleft =  isset($_POST['inhert_mgleft'])? '' : cleaninputfield($mysql,$_POST['marginleft']); 
				$marginright =  isset($_POST['inhert_mgright'])? '' : cleaninputfield($mysql,$_POST['marginright']); 
				$margintop =  isset($_POST['inhert_mgtop'])? '' : cleaninputfield($mysql,$_POST['margintop']); 
				$marginbottom =  isset($_POST['inhert_mgbuttom'])? '' : cleaninputfield($mysql,$_POST['marginbottom']); 
				$decoration =  isset($_POST['inhert_decoration'])? '' : cleaninputfield($mysql,$_POST['decoration']); 
				$textfloat = isset($_POST['inhert_float'])? '' : cleaninputfield($mysql,$_POST['textfloat']);
				$textalign = isset($_POST['inhert_align'])? '' : cleaninputfield($mysql,$_POST['textalign']); 
				$display = isset($_POST['inhert_display'])? '' : cleaninputfield($mysql,$_POST['display']); 
				$bgposition = isset($_POST['inhert_bgposition'])? '' : cleaninputfield($mysql,$_POST['bgposition']); 
				$bgrepeat = isset($_POST['inhert_bgrepeat'])? '' : cleaninputfield($mysql,$_POST['bgrepeat']); 
				$tag = cleaninputfield($mysql,$_POST['tag']); 
				 if(isset($_POST['inhert_bgimage'])){
					@unlink("../style_pictures/$bgimage");
					$bgimage='';
				 }else{
				 	$bgimage = isset($_POST['inhert_bgimage'])? '' : cleaninputfield($mysql,$bgimage); 
				 }
				
				$queryupdate = $mysql->record_update("cssstyle_tbl",array('font' => $font,'fontweight' => $fontweight,'size' => $size, 'color' => $color, 'bgcolor' => $bgcolor,'height' => $height, 'decoration' => $decoration,'marginleft' => $marginleft, 'marginright' => $marginright,'margintop' => $margintop, 'marginbottom' => $marginbottom,'paddingleft' => $paddingleft, 'paddingright' => $paddingright,'paddingtop' => $paddingtop, 'paddingbottom' => $paddingbottom,'textfloat' => $textfloat,'textalign' => $textalign,'display' => $display,'bgimage' => $bgimage,'bgposition' => $bgposition,'bgrepeat' => $bgrepeat),"tag='$tag'");
				if($queryupdate){
					$msg= base64_encode('Sytle Updated Successfully!');
					echo "<script> window.location='csstyle.php?msg=$msg';</script>";
					exit();
				
				}else{
					$msg= base64_encode(mysqli_error($mysql->connection));
					echo "<script> window.location='csstyle.php?msge=$msg';</script>";
					exit();
				}
			}
		
			if(isset($_GET['del'])){
				$del = cleaninputfield($mysql,$_GET['del']);
				$mysql->record_delete("cssstyle_tbl","id = $del");
				$msg=base64_encode("Style Deleted Successfully!");
				echo "<script> window.location='csstyle.php?msg=$msg' </script>";
				exit();
			}
			include_once("generatecss.php");
			?>
		<div class="container-top"></div>
		<form action="" method="post" name="cssstyle_form" id="cssstyle_form" enctype="multipart/form-data" >
		<div class="container">
			<h2>Add / Edit CSS Style</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<?php  if(isset($_GET['msg'])){ ?><div class="validbar"><p> <?php  echo base64_decode($_GET['msg']); ?> </p></div><?php } ?>
			<?php  if(isset($_GET['msge'])){ ?><div class="invalidbar"><p> <?php  echo base64_decode($_GET['msge']); ?> </p></div><?php } ?>
			<div class="content">
			<div class="content-bar"></div>
			       <table width="633" border="0" cellpadding="0" cellspacing="0" class="addpage">
				   <tbody>
                        <tr>
							<td align="right" width="22%"><label for="tag">Select Tag to Edit</label></td>
							<td width="39%"><?php 
							if(isset($_REQUEST['tag'])){
								$tag = cleaninputfield($mysql,$_REQUEST['tag']);
							}
							$postrows2 = $mysql->list_table("cssstyle_tbl ",false,array('sortColumn' => 'id','sortType'=>'ASC'));
							?>
                                <select name="tag" id="tag" onchange="getstyle(this)">
                                  <option value="0" > Select Tag or Enter New One </option>
                                  <?php 
							if($mysql->affected_rows>0){
								foreach($postrows2 as $value => $postrows){ ?>
                                  <option value="<?php echo $postrows['tag']; ?>" <?php echo $tag==$postrows['tag']?'selected="selected"':''; ?> ><?php echo $postrows['tag']; ?></option>
                                  <?php
								}
							}
							?>
                                </select>                            </td>
							<td width="39%">&nbsp;</td>
						</tr>
                         <tr>
							<td align="right"><label for="newtag">Enter New CSS Tag</label></td>
							<td><input type="text" name="newtag" id="newtag" /> </td>
							<td><label>(Use .(DOT) for Class name and # for ID) </label></td>
						</tr>
                        <?php
						if(isset($tag) && strlen($tag)>0){
							$postrow = $mysql->fetch_row("cssstyle_tbl","tag='$tag'");
						}
						?> 
                        <tr>
							<td align="right"><label for="font">Font Name</label>	</td>
							<td><select name="font" id="font"  >
                                <option value="Arial" <?php echo isset($postrow) && $postrow['font']=='Arial'?'selected':''; ?> >Arial</option>
                                <option value="Comic Sans MS" <?php echo isset($postrow) && $postrow['font']=='Comic Sans MS'?'selected':''; ?> >Comic Sans MS</option>
                                <option value="Courier New" <?php echo isset($postrow) && $postrow['font']=='Courier New'?'selected':''; ?> >Courier New</option>
                                <option value="Tahoma" <?php echo isset($postrow) && $postrow['font']=='Tahoma'?'selected':''; ?> >Tahoma</option>
                                <option value="Times New Roman" <?php echo isset($postrow) && $postrow['font']=='Times New Roman'?'selected':''; ?> >Times New Roman</option>
                                <option value="Verdana" <?php echo isset($postrow) && $postrow['font']=='verdana'?'selected':''; ?> >Verdana</option>
                              </select>                            </td>
							<td><input type="checkbox" name="inhert_font" id="inhert_font" value="1" />  <label for="inhert_font"> Inherit </label></td>
						</tr>
                        <tr>
							<td align="right"><label for="size">Font Size</label>	</td>
							<td><input type="text" name="size"  id="size"  <?php if(isset($tag)){ ?>value="<?php echo $postrow['size'] ?>" <?php }?>  maxlength="3"  onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')" /><small>px </small> </td>
							<td><input type="checkbox" name="inhert_size" id="inhert_size" value="1" />
                            <label for="inhert_size"> Inherit </label> </td>
						</tr> 
                        
                       <tr>
							<td align="right"><label for="fontweight">Font Weight</label>	</td>
							<td><select name="fontweight" id="fontweight" >
                                <option value="normal" <?php echo isset($postrow) && $postrow['fontweight']=='normal'?'selected':''; ?> >Normal</option>
                                <option value="lighter" <?php echo isset($postrow) && $postrow['fontweight']=='lighter'?'selected':''; ?> >Light</option>
                                <option value="bold" <?php echo isset($postrow) && $postrow['fontweight']=='bold'?'selected':''; ?> >Bold</option>
                              </select>                         </td>
							<td><input type="checkbox" name="inhert_fontweight" id="inhert_fontweight" value="1" />
								<label for="inhert_fontweight"> Inherit </label> 
							</td>
						</tr>
                        <tr>
							<td align="right"><label for="height">Line Height	</label></td>
						    <td><input type="text" name="height"  id="height"    <?php if(isset($tag)){ ?>value="<?php echo $postrow['height'] ?>" <?php }?> maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')" /><small>px </small> </td>
						    <td><input type="checkbox" name="inhert_height" id="inhert_height" value="1" />
                            <label for="inhert_height"> Inherit </label></td>
			            </tr>
                        
                        <tr>
							<td align="right"> <label for="color"> Text Color</label></td>
						    <td><input type="text" name="color"  id="color"  <?php if(isset($tag)){ ?>value="<?php echo $postrow['color']; ?>" <?php }?>  maxlength="7" onfocus="showColorPicker(this,document.getElementById('color'))"></td>
						    <td><input type="checkbox" name="inhert_color" id="inhert_color" value="1" />
  <label for="inhert_color"> Inherit </label></td>
			            </tr> 
                        <tr>
                          <td align="right"> <label for="bgcolor"> Background Color</label></td>
                          <td><input type="text" name="bgcolor"  id="bgcolor" <?php if(isset($tag)){ ?>value="<?php echo $postrow['bgcolor']; ?>" <?php }?>  maxlength="7" onfocus="showColorPicker(this,document.getElementById('bgcolor'))" /> </td>
                          <td><input type="checkbox" name="inhert_bgcolor" id="inhert_bgcolor" value="1" />
							<label for="inhert_bgcolor"> Inherit </label>
						</td>
                        </tr>
                        <tr>
                          <td align="right"> <label for="bgimage"> Background Image</label></td>
                          <td><input type="file" name="bgimage" id="bgimage" /><?php  if(isset($tag)){?> <input type="hidden" name="oldimage"  id="oldimage" value="<?php echo $postrow['bgimage'] ?>" /> <?php echo "(   $postrow[bgimage]   )"; } // end of the file uploading updation ?></td>
                          <td><input type="checkbox" name="inhert_bgimage" id="inhert_bgimage" value="1" />
                            <label for="inhert_bgimage"> Inherit </label></td>
                        </tr>
                        <tr>
                          <td align="right"> <label for="bgposition"> Background Position</label></td>
                          <td><select name="bgposition" id="bgposition" >
                                <option value="bottom" <?php echo isset($postrow) && $postrow['bgposition']=='bottom'?'selected':''; ?> >Bottom</option>
                                <option value="center" <?php echo isset($postrow) && $postrow['bgposition']=='center'?'selected':''; ?> >Center</option>
                                <option value="left" <?php echo isset($postrow) && $postrow['bgposition']=='left'?'selected':''; ?> >Left</option>
								<option value="right" <?php echo isset($postrow) && $postrow['bgposition']=='right'?'selected':''; ?> >Right</option>
								<option value="top" <?php echo isset($postrow) && $postrow['bgposition']=='top'?'selected':''; ?> >Top</option>
                              </select></td>
                          <td><input type="checkbox" name="inhert_bgposition" id="inhert_bgposition" value="1" />
                            <label for="inhert_bgposition"> Inherit </label></td>
                        </tr>
                        <tr>
                          <td align="right"> <label for="bgrepeat"> Background Repeat</label></td>
                          <td><select name="bgrepeat" id="bgrepeat"  >
                                <option value="no-repeat" <?php echo isset($postrow) && $postrow['bgrepeat']=='no-repeat'?'selected':''; ?> >No Repeat</option>
                                <option value="repeat" <?php echo isset($postrow) && $postrow['bgrepeat']=='repeat'?'selected':''; ?> >Repeat</option>
                                <option value="repeat-x" <?php echo isset($postrow) && $postrow['bgrepeat']=='repeat-x'?'selected':''; ?> >Repeat-x</option>
								<option value="repeat-y" <?php echo isset($postrow) && $postrow['bgrepeat']=='repeat-y'?'selected':''; ?> >Repeat-y</option>
                              </select> </td>
                          <td><input type="checkbox" name="inhert_bgrepeat" id="inhert_bgrepeat" value="1" />
                            <label for="inhert_bgrepeat"> Inherit </label></td>
                        </tr>
                        <tr>
							<td align="right"><label for="paddingleft"> Padding-left</label>	</td>
						    <td><input type="text" name="paddingleft"  id="paddingleft"    <?php if(isset($tag)){ ?>value="<?php echo $postrow['paddingleft'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small></td>
						    <td><input type="checkbox" name="inhert_lfpadd" id="inhert_lfpadd" value="1" />
                            <label for="inhert_lfpadd"> Inherit </label></td>
			            </tr>
						<tr>
							<td align="right"><label for="paddingright">Padding-right</label> </td>
						    <td><input type="text" name="paddingright"  id="paddingright"    <?php if(isset($tag)){ ?>value="<?php echo $postrow['paddingright'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small>  </td>
						    <td><input type="checkbox" name="inhert_rtpadd" id="inhert_rtpadd" value="1" />
                            <label for="inhert_rtpadd"> Inherit </label></td>
			            </tr>
						<tr>
							<td align="right"><label for="paddingtop">Padding-top</label>  </td>
						    <td><input type="text" name="paddingtop"  id="paddingtop"    <?php if(isset($tag)){ ?>value="<?php echo $postrow['paddingtop'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small> </td>
						    <td> <input type="checkbox" name="inhert_toppadd" id="inhert_toppadd" value="1" />
                            <label for="inhert_toppadd"> Inherit </label></td>
			            </tr>
						<tr>
							<td align="right"> <label for="paddingbottom">Padding-bottom</label> </td>
						    <td><input type="text" name="paddingbottom"  id="paddingbottom"    <?php if(isset($tag)){ ?>value="<?php echo $postrow['paddingbottom'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small> </td>
						    <td> <input type="checkbox" name="inhert_btmpadd" id="inhert_btmpadd" value="1" />
                            <label for="inhert_btmpadd"> Inherit </label></td>
			            </tr>
						<tr>
							<td align="right"> <label for="marginleft"> Margin-left</label></td>
						    <td><input type="text" name="marginleft"  id="marginleft"    <?php if(isset($tag)){ ?>value="<?php echo $postrow['marginleft'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small> </td>
						    <td>  <input type="checkbox" name="inhert_mgleft" id="inhert_mgleft" value="1" />
                            <label for="inhert_mgleft"> Inherit </label> </td>
			            </tr> 
                        <tr>
							<td align="right"> <label for="marginright">Margin-right </label></td>
						    <td><input type="text" name="marginright"  id="marginright"  <?php if(isset($tag)){ ?>value="<?php echo $postrow['marginright'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small> </td>
						    <td> <input type="checkbox" name="inhert_mgright" id="inhert_mgright" value="1" />
                            <label for="inhert_mgright"> Inherit </label></td>
			            </tr>
						<tr>
							<td align="right"><label for="margintop">Margin-top	</label>	</td>
						    <td><input type="text" name="margintop"  id="margintop"  <?php if(isset($tag)){ ?>value="<?php echo $postrow['margintop'] ?>" <?php }?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small>  </td>
						    <td> <input type="checkbox" name="inhert_mgtop" id="inhert_mgtop" value="1" />
                            <label for="inhert_mgtop"> Inherit </label></td>
			            </tr>
						<tr>
							<td align="right"><label for="marginbottom">Margin-bottom	</label></td>
						    <td><input type="text" name="marginbottom" id="marginbottom"  <?php if(isset($tag)){ ?> value="<?php echo $postrow['marginbottom']; ?>" <?php } ?>  maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="this.value=this.value.replace(/\D/g,'')"><small>px </small> </td>
						    <td> <input type="checkbox" name="inhert_mgbuttom" id="inhert_mgbuttom" value="1" />
                            <label for="inhert_mgbuttom"> Inherit </label></td>
			            </tr>  
                        <tr>
							<td align="right"><label for="textalign">Text Align </label> </td>
							<td><select name="textalign" id="textalign"  >
                                <option value="left" <?php echo isset($postrow) && $postrow['textalign']=='left'?'selected':''; ?> >Left</option>
                                <option value="right" <?php echo isset($postrow) && $postrow['textalign']=='right'?'selected':''; ?> >Right</option>
                                <option value="center" <?php echo isset($postrow) && $postrow['textalign']=='center'?'selected':''; ?> >Center</option>
                                <option value="justify" <?php echo isset($postrow) && $postrow['textalign']=='justify'?'selected':''; ?> >Justify</option>
                              </select> </td>
							<td><input type="checkbox" name="inhert_align" id="inhert_align" value="1" />
								<label for="inhert_align"> Inherit </label> </td>
						</tr>
                         <tr>
							<td align="right"><label for="float">Text Float </label></td>
							<td><select name="textfloat" id="textfloat"  >
                                <option value="left" <?php echo isset($postrow) && $postrow['textfloat']=='left'?'selected':''; ?> >Left</option>
                                <option value="right" <?php echo isset($postrow) && $postrow['textfloat']=='right'?'selected':''; ?> >Right</option>
                                <option value="none" <?php echo isset($postrow) && $postrow['textfloat']=='none'?'selected':''; ?> >None</option>
                              </select>                           </td>
							<td> <input type="checkbox" name="inhert_float" id="inhert_float" value="1" />
  <label for="inhert_float"> Inherit </label></td>
						</tr>
                         
                        <tr>
							<td align="right"><label for="decoration">Text Decoration  </label> </td>
							<td><select name="decoration" id="decoration"  >
                                <option value="none" <?php echo isset($postrow) && $postrow['decoration']=='none'?'selected':''; ?> >None</option>
                                <option value="underline" <?php echo isset($postrow) && $postrow['decoration']=='underline'?'selected':''; ?> >Underline</option>
                                <option value="overline" <?php echo isset($postrow) && $postrow['decoration']=='overline'?'selected':''; ?> >Overline</option>
                                <option value="line-through" <?php echo isset($postrow) && $postrow['decoration']=='line-through'?'selected':''; ?> >Line Through</option>
                              </select>                          </td>
							<td> <input type="checkbox" name="inhert_decoration" id="inhert_decoration" value="1" />
  <label for="inhert_decoration"> Inherit </label></td>
						</tr>  
						<tr>
                           <td align="right"> Display </td>
                           <td><select name="display" id="display"  >
						  		<option value="">Select Display</option>
                                <option value="none" <?php echo isset($postrow) && $postrow['display']=='none'?'selected':''; ?> >None</option>
                                <option value="block" <?php echo isset($postrow) && $postrow['display']=='block'?'selected':''; ?> >Block</option>
                                <option value="inline" <?php echo isset($postrow) && $postrow['display']=='inline'?'selected':''; ?> >Inline</option>
                                <option value="compact" <?php echo isset($postrow) && $postrow['display']=='compact'?'selected':''; ?> >Compact</option>
                              </select> </td>
                           <td><input type="checkbox" name="inhert_display" id="inhert_display" value="1" />
  <label for="inhert_display"> Inherit </label></td>
                         </tr>                    
						<tr>
							<td colspan="3" align="center">
                            <?php
							if(isset($tag) && strlen($tag)>0){
								$id=$postrow['id'];
								echo '<input type="button" name="delbtn" onclick="window.location=\'csstyle.php?del='.$id.'\'" value="Delete this Tag" />'; ///class="loginbtns"
							}
							?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  </td>
						</tr>
						</tbody>
					</table>
		  </div>
			<div class="addbtn-right">
				<input name="updatestyle" id="updatestyle" type="submit" value="Update Style" class="addpagebtn" />
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