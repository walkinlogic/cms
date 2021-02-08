<?php
	if($_SESSION['MANAGE_STYLE']==0){
		$msg= base64_encode("Please login to access this page content!");
		echo "<script> window.location='index.php?msg=$msg';</script>";
		exit();
	}
	$cssfile = "../innerstyle.css";
	$fh = fopen($cssfile, 'w');
	$fh2 = fopen("tinymce.css", 'w');
	$style='';
	$style2='';
	$stylelists = $mysql->list_table("cssstyle_tbl ",false,array('sortColumn' => 'id','sortType'=>'ASC'));
	if($mysql->affected_rows>0){
		foreach($stylelists as $value => $stylelist){ 
			// innerstyle css starts
			$style .= "#leftside ".$stylelist['tag']."{\n";
			$style .="font-family :".$stylelist['font'].";\n";
			$style .="font-weight :".$stylelist['fontweight'].";\n";
			$style .="font-size :".$stylelist['size']."px;\n";
			$style .="color :".$stylelist['color'].";\n";
			$style .="background-color :".$stylelist['bgcolor'].";\n";
			$style .="line-height :".$stylelist['height']."px;\n";
			$style .="margin-left :".$stylelist['marginleft']."px;\n";
			$style .="margin-right :".$stylelist['marginright']."px;\n";
			$style .="margin-top :".$stylelist['margintop']."px;\n";
			$style .="margin-bottom :".$stylelist['marginbottom']."px;\n";
			$style .="padding-right :".$stylelist['paddingright']."px;\n";
			$style .="padding-left :".$stylelist['paddingleft']."px;\n";
			$style .="padding-top :".$stylelist['paddingtop']."px;\n";
			$style .="padding-bottom :".$stylelist['paddingbottom']."px;\n";
			$style .="float :".$stylelist['textfloat'].";\n";
			$style .="text-align :".$stylelist['textalign'].";\n";
			$style .="text-decoration :".$stylelist['decoration'].";\n";
			$style .="display :".$stylelist['display'].";\n";
			$style .="background-image :style_pictures/".$stylelist['bgimage'].";\n";
			$style .="background-position :".$stylelist['bgposition'].";\n";
			$style .="background-repeat :".$stylelist['bgrepeat'].";\n";
			$style .="}\n";
			// innerstyle css ends
			// tinymce css starts
			$style2 .= $stylelist['tag']."{\n";
			$style2 .="font-family :".$stylelist['font'].";\n";
			$style2 .="font-size :".$stylelist['size']."px;\n";
			$style2 .="font-weight :".$stylelist['fontweight'].";\n";
			$style2 .="color :".$stylelist['color'].";\n";
			$style2 .="background-color :".$stylelist['bgcolor'].";\n";
			$style2 .="line-height :".$stylelist['height']."px;\n";
			$style2 .="margin-left :".$stylelist['marginleft']."px;\n";
			$style2 .="margin-right :".$stylelist['marginright']."px;\n";
			$style2 .="margin-top :".$stylelist['margintop']."px;\n";
			$style2 .="margin-bottom :".$stylelist['marginbottom']."px;\n";
			$style2 .="padding-right :".$stylelist['paddingright']."px;\n";
			$style2 .="padding-left :".$stylelist['paddingleft']."px;\n";
			$style2 .="padding-top :".$stylelist['paddingtop']."px;\n";
			$style2 .="padding-bottom :".$stylelist['paddingbottom']."px;\n";
			$style2 .="float :".$stylelist['textfloat'].";\n";
			$style2 .="text-align :".$stylelist['textalign'].";\n";
			$style2 .="text-decoration :".$stylelist['decoration'].";\n";
			$style2 .="display :".$stylelist['display'].";\n";
			$style2 .="background-image :../style_pictures/".$stylelist['bgimage'].";\n";
			$style2 .="background-position :".$stylelist['bgposition'].";\n";
			$style2 .="background-repeat :".$stylelist['bgrepeat'].";\n";
			$style2 .="}\n";
			// tinymce css end		
		}
	}
	fwrite($fh, $style);
	fclose($fh);
	
	fwrite($fh2, $style2);
	fclose($fh2);
	?>