<?php
	$counter=1;
	$postalbums = $mysql->list_table("album_tbl a INNER JOIN images_tbl i ON a.id = i.album_id"," a.status = '1' AND  i.status = '1' ", array ('range' => 'i.*,a.title as albumtitle, a.ar_title, a.ar_title as ar_albumtitle','sortColumn'=>"sortorder",'sortType'=>'ASC'));
	 
	if($mysql->affected_rows>0){	
		?>
	<div class="design-gallery designlightgrey">  
		<div class="Scriptcontent"> 
			<div class="container py-3">
				<div class="gallery" style="display:none;">
					<?php 
					foreach ($postalbums as $postalbum) {
						$album_title = str_replace(' ','-',$postalbum['title']); ?>
						<?php if($postalbum['image']!=''){ ?>
						<img data-gallery-tag="<?php echo $postalbum[$pre.'albumtitle']; ?>" title="<?php echo $postalbum['title']; ?>" alt="<?php echo $postalbum['alttext']; ?>"  class="gallery-item img-rounded" src="<?php echo URL;?>uploaded/<?php echo $postalbum['image']; ?>" />
						<?php } ?>
						<?php if($postalbum['youtube']!=''){ ?>
							<iframe class="gallery-item img-rounded" data-gallery-tag="<?php echo $postalbum[$pre.'albumtitle']; ?>" title="<?php echo $postalbum['title']; ?>"  src="<?php echo $postalbum['youtube'];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						<?php }?>
					<?php 
						$counter++;
					}
					?>
				</div>
			</div>
		</div> 
	</div>
	<?php  
	} 
 ?>	