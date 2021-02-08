<?php 
$postfaqs = $mysql->list_table("clientreviews_tbl","status = '1'", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
if($mysql->affected_rows>0){
?>
<?php /* <section class="design-section">
  <div class="container text-center">
	<h2><?php if($pre==''){?>What Our<?php }else{ ?>ا لدينا<?php } ?> <?php if($pre==''){?>Client Says<?php }else{ ?>يقول العميل<?php } ?></h2>
	<hr style="margin-bottom: 46px;">
  </div>  
</section> */ ?>
<div id="design-testimony" class="designlightgrey">
	<div class="container">
		<div class="row">
			<div class="col-md-4 animate-box design-heading animate-box"> 
				<h2><span class="thin"><?php if($pre==''){?>What Our<?php }else{ ?>ا لدينا<?php } ?></span> <span class="thick"><?php if($pre==''){?>Client Says<?php }else{ ?>يقول العميل<?php } ?></span></h2>
			</div>
			<div class="col-md-7 col-md-push-1">
				<div class="row animate-box">
					<span class="icon"><i class="icon-quote-left-1"></i></span>
					<div class="owl-carousel4">
						<?php foreach($postfaqs as $faq){ ?>
						<div class="item">
							<div class="testimony-slide active">
								<div class="testimony-wrap">
									<?php if(!empty($faq["image"])){?><figure>
										<img class="img-rounded" src="<?php echo URL;?>uploaded/<?php echo $faq["image"];?>" alt="<?php echo stripslashes($faq[$pre.'title']); ?>">
									</figure><?php } ?>
									<blockquote>
										<span><?php echo stripslashes($faq[$pre.'title']); ?></span>
										 <?php echo $faq[$pre.'description']; ?> 
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