<?php
	include_once("includes/config.php");      /// db setting
	include_once("includes/db_wrapper.php"); /// db wrapper
	include_once("admin/includes/utility.php");      /// general functions
	include_once("admin/includes/thumbnail_images.class.php"); 
	if(isset($_GET['email_id']) && isset($_GET['email']) && !empty($_GET['email_id']) && !empty($_GET['email'])){ 
		$email_id=mysqli_real_escape_string($mysql->connection,$_GET['email_id']);
		$email=mysqli_real_escape_string($mysql->connection,$_GET['email']);
	}else{
		echo '<script>window.location.href="'.URL.'eng/home/"</script>';exit; 
	}
	$pageid = isset($pageid) ? $pageid :'Home';
	$pageid1 = str_replace('_',' ',$pageid);
	$pageid2 = mysqli_real_escape_string($mysql->connection,$pageid1);		
	$postpage = $mysql->fetch_row("content_tbl","internal_link='$pageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$pageid' OR pagename='$pageid1' OR pagename='$pageid2'",array ('range' => '*'));		
 
	if($mysql->affected_rows>0){
		if(trim($postpage["external_link"])==1){
			header("location:".$postpage["external_link"]);	
		}
		
		$page_id = $postpage["id"];
		$parent_id = $postpage["parentpageid"];
		
		$page_image = $postpage["image"];
		
		$metatitle = stripslashes($postpage[$pre."metatitle"]);
		$metadescription = stripslashes($postpage[$pre."metadescription"]);
		$metakeywords = stripslashes($postpage[$pre."metakeywords"]);
		$pagename = stripslashes($postpage[$pre."pagename"]);
		$pagecontent = stripslashes($postpage[$pre."pagecontent"]);

		$isform = $postpage["formmodule"];
		$isnews = $postpage["newsmodule"];
		$isgallery = $postpage["gallerymodule"];
		$isfaq = $postpage["expandablemodule"];
		$isslideshow = $postpage["slideshowmodule"];
		$iscustommodule = $postpage["custommodule"];				
		$iscustomregion = $postpage["iscustomregion"];
		$downloadmodules = $postpage["downloadmodules"];
		$certificatesmodules = $postpage["certificatesmodules"];
		$downloadmoduleid = $postpage["downloadmoduleid"];
		$contactmodulesid = $postpage["contactmodulesid"];
		$tradeshowmodules = $postpage["tradeshowmodules"];
		$contactdetailsmodules = $postpage["contactdetailsmodules"];
		$industriesapplicationsmodules = $postpage["industriesapplicationsmodules"];
		$servicesmodules = $postpage["servicesmodules"];
		
		$howmanydownloadsmodules = $postpage["howmanydownloads"];
		$isclientreviews = $postpage["clientreviews"];
		$isourstaff = $postpage["ourstaff"];
		$howmanycontactsmodules = $postpage["howmanycontacts"];
		$issecure = $postpage["issecure"];	
		$pdffile = $postpage["pdffile"];	
		$getquoteform = $postpage["quoteform"];	
	}
?>
<!DOCTYPE html> 
<!--[if lt IE 9 ]><html class="no-js oldie" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
	<head> 
		<meta charset="UTF-8" />
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" type="image/vnd.microsoft.icon" />
		<link rel="icon" href="<?php echo URL; ?>favicon.ico" type="image/x-icon">	
		<link rel="canonical" href="<?php echo $ACTUAL_LINK; ?>"> 
		<title><?php echo $metatitle; ?></title>
		<meta name="description" content="<?php echo stripslashes($metadescription); ?>" />
		<meta name="keywords" content="<?php echo stripslashes($metakeywords); ?>" />
		<meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="referrer" content="origin">
		<base href="<?php echo URL; ?>">

		<meta property="og:title" content="<?php echo stripslashes($metatitle); ?>"/>
		<meta property="og:image" content="<?php echo URL; ?>images/logo.png"/>
		<meta property="og:url" content="<?php echo $ACTUAL_LINK; ?>"/>
		<meta property="og:site_name" content="<?php echo stripslashes($metatitle); ?>"/>
		<meta property="og:description" content="<?php echo stripslashes($metadescription); ?>"/>
		<meta name="twitter:title" content="<?php echo stripslashes($metatitle); ?>" />
		<meta name="twitter:image" content="<?php echo URL; ?>images/logo.png" />
		<meta name="twitter:url" content="<?php echo $ACTUAL_LINK; ?>" />
		<meta name="twitter:card" content="<?php echo stripslashes($metadescription); ?>" />


		<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,700" rel="stylesheet">
			
		 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/animate.css"> 
		 <link rel="stylesheet" href="<?php echo URL; ?>assets/css/icomoon.css"> 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/bootstrap.css"> 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/magnific-popup.css"> 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/flexslider.css"> 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/owl.theme.default.min.css"> 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/fonts/flaticon/font/flaticon.css"> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		
		<link rel="stylesheet" href="<?php echo URL; ?>assets/fontello/css/fontello.css">
		
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/gallery_style.css"> 
		<link rel="stylesheet" href="<?php echo URL; ?>assets/css/style.css"> 
		<script src="<?php echo URL; ?>assets/js/modernizr-2.6.2.min.js"></script>  
		<!--[if lt IE 9]>
			<script src="<?php echo URL; ?>assets/js/respond.min.js"></script>
		<![endif]-->
		 
	</head>
	<body>
		<div class="design-loader"></div>
		<div id="page">
			 <?php 
				if(!is_numeric($email_id)){
					echo "Data Error";
					exit; 
			    }
				
			$queryupdate = $mysql->record_update("subscription_tbl",array('status'=>0),'id = '.$email_id.' AND email = "'.$email.'"');
			if($queryupdate){
			?>
			<p>Thanks , your email address is removed from our list</p>
			<?php }else{ ?>
			<p>No matching record, Please contact siteadmin</p>
			<?php } ?>
			</div>
		</div>	
	</body>
</html>  