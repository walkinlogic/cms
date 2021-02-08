<?php
	$news_heading = isset($News) ? mysqli_real_escape_string($mysql->connection,$News) :'';
	$news_heading1 = urldecode(str_replace('_',' ',$news_heading));
	
	$news_heading2 = mysqli_real_escape_string($mysql->connection,$news_heading1);
	
	$postnewsid = $mysql->fetch_row("news_tbl",'heading="'.$news_heading.'" OR heading="'.$news_heading1.'" OR heading="'.$news_heading2.'" ',array ('range' => '*'));			
	if($mysql->affected_rows>0){
		$news_id = $postnewsid['id'];
	}
	
	$postnews = $mysql->fetch_row("news_tbl","id='$news_id' ",array ('range' => '*'));		
	if($mysql->affected_rows>0){ 	
	?>
	
	<div id="design-blog" <?php if(!empty($postnews[$pre."image"])){?>style="padding:0px;"<?php } ?>>
		<div class="container">
			<div class="row">
				<article class="animate-box">
					<?php if(!empty($postnews[$pre."image"])){?><div class="blog-img" style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $postnews[$pre."image"]; ?>);"></div><?php } ?>
					<div class="entry">
						<div class="meta text-center">
							<p>
								<span><?php echo date('M' , strtotime($postnews["newsdate"])); ?></span>
								<span><?php echo date('d Y' , strtotime($postnews["newsdate"])); ?></span>
							</p>
						</div>
						<h2><a href="#"><?php echo $postnews[$pre."heading"]; ?></a></h2>
						<?php /* <p class="meta-2"><span><i class="icon-user"></i> Admin</span> <span><i class="icon-dropbox"></i> Articles</span></p> */ ?>
						<p><?php echo stripslashes($postnews[$pre."description"]); ?></p>
					</div>
				</article>  
			</div>	
		</div>
	</div>
	 
	<?php }?> 
 