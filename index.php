<?php
	@session_start();
	include_once("includes/config.php");
	include_once("includes/db_wrapper.php");
	foreach($_GET as $key => $value) {
		$$key = $value;
	}
	foreach($_POST as $key => $value) {
		$$key = $value;
	}
	  
	if(!isset($lang)){
		if(!isset($pageid)){
			$pageid='home';
		}
		header('location: '.URL.'eng/'.$pageid.'/'); 
		exit; 
	}	
	if($lang!='ar'){
		$pre='';
		$lang='eng';	
	}else{
		$pre='ar_';
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
	$postconfig = $mysql->fetch_row("config_tbl","id='1' ",array ('range' => '*'));	
	if($mysql->affected_rows>0){
		$footerabout = stripslashes($postconfig[$pre."header"]);
		$contacttext = stripslashes($postconfig[$pre."footer"]);
		$copyright = stripslashes($postconfig[$pre."copyright"]);
		$whatsappnumber = stripslashes($postconfig["whatsapp"]);
		$whatsappMessage = stripslashes($postconfig["whatsappmessage"]);
		$facebook = stripslashes($postconfig["facebook"]);
		$linkedin = stripslashes($postconfig["linkedin"]);
		$instagram = stripslashes($postconfig["instagram"]);
		$twitter = stripslashes($postconfig["twitter"]);
		$youtube = stripslashes($postconfig["youtube"]);
		$vimeo = stripslashes($postconfig["vimeo"]);
		$pinterest = stripslashes($postconfig["pinterest"]);
		$google = stripslashes($postconfig["google"]);
		
		$custom_js = stripslashes($postconfig["custom_js"]);
		$header_css = stripslashes($postconfig["header_css"]);
	
	}
	?>
<?php 
 
	$folder=URL; 
	$ACTUAL_LINK = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 
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
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
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
		 <?php if(isset($header_css) && !empty($header_css)){ ?>
			 <?php echo $header_css;?> 
		 <?php }?>
		
	</head>
	<body>
		<div class="design-loader"></div>
		<div id="page">
			<?php 
				include_once('plugins/menu.php');
			?>
			<?php 
				include_once('plugins/slide_show.php');
			?>
			
			<?php if($pageid!='home'){?>
			<?php 
				$postslides = $mysql->list_table("slide_show_tbl","status = '1'  AND pageid=$page_id ", array ('range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC'));
				if($mysql->affected_rows==0){
			?>	
				<aside id="design-hero" <?php if(!empty($page_image)){?>style="padding:0px;"<?php } ?>>
					<div class="flexslider">
						<ul class="slides">
						<li <?php if(!empty($page_image)){?>style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $page_image; ?>);"<?php } ?>>
							<div class="overlay"></div>
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-8 col-sm-12 col-md-offset-2 slider-text">
										<div class="slider-text-inner text-center"> 
											<h1><?php echo $pagename;?></h1>
										</div>
									</div>
								</div>
							</div>
						</li>
						</ul>
					</div>
				</aside>
				<?php } ?>
			<?php } ?>
			<?php 
			if(isset($Album)){
				include_once("plugins/gallery_images.php");			
			}elseif(isset($News)){ 
					include_once("plugins/news_detail.php");
			}elseif(isset($Service)){ 
					include_once("plugins/service_detail.php");
			}else if(!(isset($Album)) || !(isset($News)) ){
					  if(!empty(stripcslashes($pagecontent))){ ?>	
				<div id="design-about">	
					<div class="container">
						<div class="row ">
							<div class="col-md-12">
								<div class="about animate-box fadeInUp animated-fast">
									<?php 
										echo $pagecontent;
									?>
								</div>
								<?php if(!empty($pdffile)){?>
								<div class="form-group about animate-box fadeInUp animated-fas">
									<a href="<?php echo URL; ?>uploaded/<?php echo $pdffile;?>" target="_blank" class="btn btn-primary"><?php if($pre==''){?>Download Document<?php }else{ ?> تنزيل المستند <?php } ?></a>
								</div>
								<?php } ?> 
							</div> 
						</div> 
					</div>
				</div>	
			<?php } ?>				
					<?php
					
					/* if($iscustomregion == 1){
						include_once("plugins/customregion.php");
					} */
					
					
					/* if($pageid =='Retail_Locations'){
						include_once("plugins/retail_locations.php");			
					} */
			  						
				} 
				if($pageid!='home'){
					if($isform >0){
						include_once("plugins/contact.php");
					}
				}
				if($servicesmodules > 0){
					include_once("plugins/services.php");
				}
				if($isnews==1){
					include_once("plugins/news.php");
				}
				if($isgallery > 0){
					include_once("plugins/gallery_albums.php");
				}
				if($isfaq==1){
					include_once("plugins/faq.php");
				} 	
				if($iscustommodule == 1){
					include_once("plugins/ourwork.php");
				}
				 
				if($isclientreviews > 0){
					include_once("plugins/clientreview.php");
				}
				if($isourstaff > 0){
					include_once("plugins/ourstaff.php");
				}
				if($pageid=='home'){
					if($isform >0){
						include_once("plugins/contact.php");
					}
				}
				if($getquoteform > 0){
					include_once("plugins/hireus.php");
				} 				
				if($getquoteform > 0){
					include_once("plugins/quote.php");
				} 
				
				
				/* if($downloadmodules > 0){
					include_once("plugins/downloads.php");
				} */
				
				
				/* if($tradeshowmodules > 0){ 
					include_once("plugins/tradeshow.php");
				}
				if($contactdetailsmodules > 0){ 
					include_once("plugins/retail_locations.php");
				}
				if($industriesapplicationsmodules > 0){ 
					include_once("plugins/industriesapplications.php");
				} */
				
				?>
		
			<?php 
				include_once('plugins/footer.php');
			?>
		</div> 
		
		
		

		<div class="gototop js-top">
			<a href="#" class="js-gotop"><i class="icon-up-big"></i></a>
		</div>
		<?php if(!empty($whatsappnumber)){?>
		<a href="https://api.whatsapp.com/send?phone=<?php echo $whatsappnumber;?>&text=<?php echo urlencode($whatsappMessage);?>" class="float" target="_blank">
			<i class="fa fa-whatsapp my-float"></i>
		</a>
		<?php } ?>
		<!-- ============== JavaScript ============== -->
		  
		<script src="<?php echo URL; ?>assets/js/jquery.min.js"></script> 
		<script src="<?php echo URL; ?>assets/js/jquery.easing.1.3.js"></script> 
		<script src="<?php echo URL; ?>assets/js/bootstrap.min.js"></script> 
		<script src="<?php echo URL; ?>assets/js/jquery.waypoints.min.js"></script> 
		<script src="<?php echo URL; ?>assets/js/jquery.stellar.min.js"></script> 
		<script src="<?php echo URL; ?>assets/js/jquery.flexslider-min.js"></script> 
		<script src="<?php echo URL; ?>assets/js/owl.carousel.min.js"></script> 
		<script src="<?php echo URL; ?>assets/js/jquery.magnific-popup.min.js"></script>
		<script src="<?php echo URL; ?>assets/js/magnific-popup-options.js"></script>  
		<script src="<?php echo URL; ?>assets/js/jquery.countTo.js"></script> 
		
		<script src="<?php echo URL; ?>assets/js/popper.min.js"></script> 
        <script src="<?php echo URL; ?>assets/js/mauGallery.min.js"></script>
        <script src="<?php echo URL; ?>assets/js/gallery_script.js"></script>
		
		<script src="<?php echo URL; ?>assets/js/jquery.validate.js "></script>
		<script src="<?php echo URL; ?>assets/js/additional-methods.js "></script>

		<script src="<?php echo URL; ?>assets/js/main.js"></script>
		
		
		 <?php if(isset($custom_js) && !empty($custom_js)){ ?>
			 <?php echo $custom_js;?> 
		 <?php }?>
		<script>
		$(document).ready(function() {
			$(document).scroll(function () {
				var scroll = $(this).scrollTop();
				var topDist = $("#page").position();
				if (scroll > topDist.top) {
					$('.design-nav').addClass('fixednav');
					$('.js-design-nav-toggle').addClass('mobilefixednav');
					$('.design-nav').css({"position":"fixed","top":"0"});
					$('.js-design-nav-toggle').css({"position":"fixed","top":"0"});
				} else {
					$('.design-nav').removeClass('fixednav');
					$('.js-design-nav-toggle').removeClass('mobilefixednav');
					$('.design-nav').css({"position":"absolute","top":"auto"});
					$('.js-design-nav-toggle').css({"position":"absolute","top":"auto"});
				}
			});
		});
		
		$( document ).ready( function () {
			
			$( '.wpcf7 label input[type=checkbox]' ).change( function () {
				if ( $( this ).is( ':checked' ) ) {
					$( this ).parent( 'label' ).addClass( 'label-selected' );
				} else {
					$( this ).parent( 'label' ).removeClass( 'label-selected' );
				}
			} );

			$( '.wpcf7 label input[type=radio]' ).click( function () {
				$( 'input:not(:checked)' ).parent().removeClass( "label-selected" );
				$( 'input:checked' ).parent().addClass( "label-selected" );
			} );
			
			if($("#hireusform").length  > 0){
				$("#hireusform").validate({
					rules: { 
						yourname: { required:true },
						youremail: { required:true,email:true },
						yournumber: { required:true },
						yourmessage: { required:true },
						yourfile: { extension:'docx|txt|doc|pdf|png|jpg|jpeg' }
					},
					messages:{
								yourname:{
									required: "<?php if($pre==''){?>Name field is required<?php }else{?>حقل الاسم مطلوب<?php }?>."
								},
								youremail:{
									required: "<?php if($pre==''){?>Name field is required<?php }else{?>حقل البريد الإلكتروني مطلوب<?php }?>.",
									email: "<?php if($pre==''){?>Email is not correct<?php }else{?>البريد الإلكتروني غير صحيح<?php }?>."
								},
								yournumber:{
									required: "<?php if($pre==''){?>Phone field is required<?php }else{?>قل الهاتف مطلوب<?php }?>."
								},
								yourmessage:{
									required: "<?php if($pre==''){?>Message field is required<?php }else{?>حقل الرسالة مطلوب<?php }?>."
								}
					},
					submitHandler: function(form) {
						//console.log('AAAAAA');
					   var formData = new FormData($("#hireusform")[0]);
					   var url = $(form).attr('action');
					   $.ajax({
						   url: url,
						   type: 'POST',
						   data: formData,
						   async: false,
						   cache: false,
						   contentType: false,
						   enctype: 'multipart/form-data',
						   processData: false,
						   success: function (response) {
							 alert(response);
						   }
					   });
					}
				});
			}
		});
		
		</script>
		
  </body>
</html> 