<?php
	$news_heading = isset($Service) ? mysqli_real_escape_string($mysql->connection,$Service) :'';
	$news_heading1 = urldecode(str_replace('_',' ',$news_heading));
	
	$news_heading2 = $news_heading1;
	
	$postnews = $mysql->fetch_row("services_tbl",'heading="'.$news_heading.'" OR heading="'.$news_heading1.'" OR heading="'.$news_heading2.'" ',array ('range' => '*'));			
 
	  
	if($mysql->affected_rows>0){ 	
	$service_id = $postnews['id'];
	?>
	
	<div id="design-blog" <?php if(!empty($page_image)){?>style="padding:0px;"<?php } ?>>
		<div class="container">
			<div class="row">
				<article class="animate-box">
					<?php if(!empty($postnews[$pre."image"])){?><div class="blog-img" style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $postnews[$pre."image"]; ?>);"></div><?php } ?>
					<div class="entry"> 
						<h2><a href="#"><?php echo $postnews[$pre."heading"]; ?></a></h2>
						<?php /* <p class="meta-2"><span><i class="icon-user"></i> Admin</span> <span><i class="icon-dropbox"></i> Articles</span></p> */ ?>
						<p><?php echo stripslashes($postnews[$pre."description"]); ?></p>
					</div>
				</article>  
			</div>	
		</div>
	</div>
	 
	<?php }?> 
 