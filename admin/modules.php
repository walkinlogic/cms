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
			<h2>Modules</h2>
			<div class="rightbtn">
				<a href="#"><img src="images/helpbtn.png" border="0" alt="help" /></a> 
			</div>
			<div class="modulelist">
				<ul>
					
					<?php /* <li class="cusmodule"><a href="d-collections_list.php">Decorative Collections</a></li>
					<li class="cusmodule"><a href="d-products_list.php">Decorative Products </a></li> */ ?>
					
					
					
					<li class="news"><a href="services_list.php">Services</a></li> 
					<li class="news"><a href="news_list.php">News</a></li> 
					<li class="news"><a href="subscriptions.php">Newsletter Subscriptions</a></li> 
					<li class="news"><a href="newsletter_list.php">Newsletter</a></li> 
					<li class="gallery"><a href="album_list.php">Gallery</a></li> 
					<li class="slideshow"><a href="slide_list.php">Image Slideshow</a></li> 
					<li class="forms"><a href="form_list.php">Forms</a></li> 
					<li class="expcontent"><a href="faqs_list.php">Expandable Content</a></li> 
					<li class="stylesheet"><a href="custom.php">Custom JS/CSS</a></li> 
					<li class="cusmodule"><a href="custom_images.php">Our Work</a></li>
								 
				 
					
					<?php /* 
						<li class="cusmodule"><a href="footer_tab_list.php">Footer Tabs</a></li> 
						<li class="cusmodule"><a href="collections_list.php">Industries & applications</a></li>
						<li class="cusmodule"><a href="products_list.php">Appliances & Procedures</a></li>
						<li class="cusmodule"><a href="retail_locations_list.php">Worldwide Locations</a></li>
						<li class="cusmodule"><a href="custom_regions.php">Custom Regions</a></li>
						<li class="cusmodule"><a href="downloads.php">Custom Downloads</a></li>
						
						<li class="cusmodule"><a href="tradeshows_list.php">Trade Shows</a></li> 
					*/ ?>
					
					<li class="cusmodule"><a href="sitemap.php">Sitemap</a></li> 
					<li class="cusmodule"><a href="staff.php">Our Staff</a></li> 
					<li class="cusmodule"><a href="client_reviews.php">Client Review</a></li>
				</ul>
				
			</div>
		</div>
		<div class="container-bottom"></div>
		<?php 
			include_once("widgets/footer.php"); /// end of header
			?>
	</div><!--wrap end here-->
</body>
</html>
