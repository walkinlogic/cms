<?php 
$i=1;
$link_class="services-link";
$postcustoms = $mysql->list_table("customimages_tbl",false, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
$i=1;
if($mysql->affected_rows>0){
?>
<div id="design-project" class="designlightgrey">
	<div class="container">
		<div class="row">
			<div class="col-md-4 animate-box design-heading animate-box">
				<h2><span class="thin"><?php if($pre==''){?>Works<?php }else{ ?>يعمل<?php } ?></span></h2>
				<h2><span class="thick"><?php if($pre==''){?>Our Done<?php }else{ ?>عملنا<?php } ?></span></h2>
				<?php /* <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
				<p><a href="project.html">View All Projects <i class="icon-arrow-right3"></i></a></p> */ ?>
			</div>
			<div class="col-md-7 col-md-push-1">
				<div class="row">
					<div class="col-md-12 animate-box">
						<div class="owl-carousel owl-carousel2 project-wrap">
						<?php foreach($postcustoms as $postcustom){  ?>
							<div class="item">
								<a href="<?php  if($postcustom['image']!=''){echo URL; ?>uploaded/<?php echo $postcustom['image'];}else{echo $postcustom['link'];} ?>" class="project <?php if($postcustom['image']!=''){ ?>image-popup-link<?php }else{ ?>popup-youtube<?php }?>" <?php if($postcustom['image']!=''){?> style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $postcustom['image'];?>);"<?php } ?>>
									<div class="desc-t">
										<div class="desc-tc">
											<div class="desc">
												<h3><?php echo stripslashes($postcustom[$pre.'title']); ?></h3>
												<?php echo $postcustom[$pre.'description']; ?>
												<?php if($postcustom['link']!=''){ ?>
													<iframe class="gallery-item img-rounded" data-gallery-tag="<?php echo $postcustom[$pre.'title']; ?>" title="<?php echo $postcustom[$pre.'title']; ?>"  src="<?php echo $postcustom['link'];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
												<?php }?>
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