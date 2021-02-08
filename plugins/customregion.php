<?php 
$i=1;
$link_class="services-link";
$postcustoms = $mysql->list_table("customregion_tbl",false, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
$i=1;
if($mysql->affected_rows>0){
?>
<div id="design-project" class="designlightgrey">
	<div class="container">
		<div class="row">
			<div class="col-md-4 animate-box design-heading animate-box">
				<span class="sm">Works</span>
				<h2><span class="thin">Our Done</span> <span class="thick">Projects</span></h2>
				<?php /* <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
				<p><a href="project.html">View All Projects <i class="icon-arrow-right3"></i></a></p> */ ?>
			</div>
			<div class="col-md-7 col-md-push-1">
				<div class="row">
					<div class="col-md-12 animate-box">
						<div class="owl-carousel owl-carousel1 project-wrap">
						<?php foreach($postcustoms as $postcustom){   ?>
							<div class="item">
								<a href="<?php echo URL.$lang.stripslashes($postcustom['link']); ?>" class="project image-popup-link" <?php if($postcustom['image']!=''){?> style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $postcustom['image'];?>);"<?php } ?>>
									<div class="desc-t">
										<div class="desc-tc">
											<div class="desc">
												<h3><span><small><?php echo $i++;?></small></span><?php echo stripslashes($postcustom[$pre.'title']); ?></h3>
												<p><?php echo $postcustom[$pre.'description']; ?></p>
											</div>
										</div>
									</div>
								</a>
							</div> 
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>