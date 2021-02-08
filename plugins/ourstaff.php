<?php 
$poststaff = $mysql->list_table("staff_tbl","status = '1'", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
if($mysql->affected_rows>0){
?>
<div id="design-testimony" class="designlightgrey">
	<div class="container">
		<div class="row">
			<div class="col-md-4 animate-box design-heading animate-box">
			  <h2><span class="thick"><?php if($pre==''){?>Our Staff<?php }else{ ?>موظفينا<?php } ?></span></h2> 
			</div>
			<div class="col-md-7 col-md-push-1">
				<div class="row animate-box"> 
					<div class="owl-carousel1">
						<?php foreach($poststaff as $staff){ ?>
						<div class="item">
							<div class="testimony-slide active">
								<div class="testimony-wrap">
									<?php if(!empty($staff["image"])){?><figure>
										<img class="img-rounded" src="<?php echo URL;?>uploaded/<?php echo $staff["image"];?>" alt="user">
									</figure><?php } ?>
									<blockquote>
										<span><?php echo stripslashes($staff[$pre.'title']); ?></span>
										<p><?php echo stripslashes($staff[$pre.'description']); ?> </p>
									</blockquote>
								</div>
							</div>
						</div> 
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?> 