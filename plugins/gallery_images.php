<?php 
$s=1; 
					
	$album_title = isset($Album) ? mysqli_real_escape_string($mysql->connection,$Album) :'';
	$album_title1 = str_replace('-',' ',$album_title);
	$album_title2 = str_replace('^','&',$album_title1);
	$postalbum = $mysql->fetch_row("album_tbl","LOWER(title)='$album_title1' OR LOWER(title)='$album_title2' OR LOWER(REPLACE(title,'-',' '))='$album_title2' ",array ('range' => '*'));	
	if($mysql->affected_rows>0){
		$album_id = $postalbum['id'];
	}
	
$totalimages = $mysql->count_records("images_tbl"," status=1 AND album_id=$album_id", array ('range' => "*",'sortColumn'=>"sortorder",'sortType'=>'ASC'));
$posts = $mysql->list_table("images_tbl"," status=1 AND album_id=$album_id ", array ('range' => "*",'sortColumn'=>"sortorder",'sortType'=>'ASC'));
$s=1;
if($mysql->affected_rows>0){
?>		
		<div id="design-project" class="designlightgrey">
			<div class="container">
				<div class="row">
					<div class="col-md-4 animate-box design-heading animate-box">
						<span class="sm"><?php if($pre==''){?>Works<?php }else{ ?>يعمل<?php } ?></span>
						<h2><span class="thik"><?php if($pre==''){?>Our Done<?php }else{ ?>عملنا<?php } ?></span></h2>
						<p><?php if($pre==''){?>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name<?php }else{ ?>حتى التأشير القوي لا يتحكم في النصوص العمياء ، فهي حياة غير تقليدية تقريبًا ذات يوم ولكن سطر صغير من النص الأعمى بالاسم<?php } ?></p> 
					</div>
					<div class="col-md-7 col-md-push-1">
						<div class="row">
							<div class="col-md-12 animate-box">
								<div class="owl-carousel owl-carousel3 project-wrap">
									<?php foreach($posts as $post){ ?>
									<div class="item">
										<a href="<?php if($post['youtube']==''){echo URL; ?>uploaded/<?php echo $post['image']; }else{echo $post['youtube'];}?>" class="project <?php if($post['youtube']==''){ ?>image-popup-link<?php }else{ ?>popup-youtube<?php }?>" style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $post['image']; ?>);"> 
											<div class="desc-t">
												<div class="desc-tc">
													<div class="desc">
														<h3><span><small><?php echo $s++;?></small></span> <?php echo stripslashes($post[$pre.'title']); ?></h3>
														<p><?php echo stripslashes($post[$pre.'description']); ?></p>
														<?php if($post['youtube']!=''){ ?>
														<iframe class="gallery-item img-rounded" data-gallery-tag="<?php echo $post[$pre.'albumtitle']; ?>" title="<?php echo $post['title']; ?>"  src="<?php echo $post['youtube'];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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