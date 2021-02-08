<?php 
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
	
}
?>


<?php /* ?>
<div class="">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h3>Ready to provice great services?</h3>
				</div>
				<div class="col-md-3"> <a href="<?php echo URL;?><?php echo $lang;?>contact" class="btn btn-primary btn-block">HIRE US</a>
				</div>
			</div>
		</div>
		<div class="path-1"></div>
		<div class="path-2"></div>
		<div class="path-3"></div>
	</div>
</div>
<?php */ ?>
<div id="design-subscribe">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-md-offset-0 design-heading animate-box">
				<h2><?php if($pre==''){?>Sign up for a Newsletter<?php }else{ ?>اشترك في النشرة الإخبارية<?php } ?></h2>
				<div class="row">
					<div class="col-md-7">
						<p><?php if($pre==''){?>Enter your email address to get the latest news, events and special offers delivered right to your inbox.<?php }else{ ?>أدخل عنوان بريدك الإلكتروني للحصول على آخر الأخبار والأحداث والعروض الخاصة التي يتم تسليمها مباشرة إلى صندوق الوارد الخاص بك.<?php } ?></p>
					</div>
					<div class="col-md-5">
						<form class="form-inline qbstp-header-subscribe" id="subscribeform" action="<?php echo URL;?>subscribe.php">
							<div class="row">
								<div class="col-md-12 col-md-offset-0">
									<div class="form-group">
										<input type="text" class="form-control" required id="email" name="email" placeholder="<?php if($pre==''){?>Enter your email<?php }else{ ?>أدخل بريدك الإلكتروني<?php } ?>">
										<button type="submit" class="btn btn-primary btn-border"><?php if($pre==''){?>Subscribe<?php }else{ ?>الإشتراك<?php } ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<footer id="design-footer" role="contentinfo">
	<div class="container">
		<div class="row row-pb-md">
			<div class="col-md-3 design-widget">
				<?php echo $footerabout;?> 
			</div>
			<div class="col-md-3">
				<?php 
					$postservices = $mysql->list_table("services_tbl","status = '1'", array ('limitOffset'=>0,'rowCount'=>15,'range' => '*','sortColumn'=>"rand()",'sortType'=>'ASC')); ?>
				<?php if($mysql->affected_rows>0){?>
					<div class="row">
						<div class="col-md-12"><h4><?php if($pre==''){?>Services We Provide<?php }else{ ?>الخدمات التي نقدمها<?php } ?></h4></div>
						 <ul class="design-footer-links">
						<?php
							$counter=1;
							foreach($postservices as $service){ 
								$service_title= urlencode(str_replace(' ','_',$service['heading'])); ?>
									<li><a class="services" href="<?php echo URL.$lang; ?>/Service/<?php echo $service_title; ?>/"><i class="icon-check"></i> <?php echo $service[$pre."heading"]; ?></a></li>
									<?php /*<div class="col-md-12"> 
										 <div class="blog-entry animate-box">
											<a href="<?php echo URL.$lang; ?>/Service/<?php echo $service_title; ?>/" class="blog-img" style="background-image: url(<?php echo URL; ?>uploaded/<?php echo  $service[$pre."image"];?>);"></a>
											<div class="desc"> 
												<h4>
													<a class="services" href="<?php echo URL.$lang; ?>/Service/<?php echo $service_title; ?>/"><?php echo $service[$pre."heading"]; ?></a>
												</h4> 
												<?php echo $service[$pre."summary"]; ?>
											</div>
										</div>
									</div> */ ?>
								
							<?php } ?>
							</ul>
					</div>
				<?php }else{ ?>
				
				<?php 
					$postsnews = $mysql->list_table("news_tbl","status = '1'", array ('limitOffset'=>0,'rowCount'=>5,'range' => '*','sortColumn'=>"newsdate",'sortType'=>'DESC'));
					if($mysql->affected_rows>0){
				?>
				<h4><?php if($pre==''){?>Recent Blog<?php }else{ ?>مدونة حديثة<?php } ?></h4>
				
				<ul class="design-footer-links">
					<?php foreach($postsnews as $postnews){ ?>
					<?php $news_title= urlencode(str_replace(' ','_',$postnews['heading'])); ?>
					<li>
						<span>&mdash; <?php echo date('d m Y' , strtotime($postnews["newsdate"])); ?></span>
						<a href="<?php echo URL.$lang; ?>/News/<?php echo $news_title; ?>/"><?php echo $postnews[$pre."heading"]; ?></a>
					</li>
					<?php } ?> 
				</ul>
				<?php } 
				}?>
			</div> 
		 
			<?php 
			$postlists = $mysql->list_table("content_tbl","pagestatus = '1' AND parentpageid = '0' ", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
			if($lang!='ar'){
				$pre='';
				$lang='eng';	
			}else{
				$pre='ar_';
			}
			?>
			
			<div class="col-md-3 col-md-push-1 design-widget">
				<h4><?php if($pre==''){?>Information<?php }else{ ?>معلومات<?php }?> </h4>
				 <ul class="design-footer-links">
					<li <?php if($pageid=='home'){?>class="active"<?php } ?>><a href="<?php echo URL.$lang;?>/home/"><i class="icon-check"></i>  <?php if($pre==''){?>Home<?php }else{ ?>الصفحة الرئيسية<?php }?></a></li>
						<?php if($mysql->affected_rows>0){  ?>
							<?php $counter=0;  foreach($postlists as $postlist){ ?>
							<?php 
								$current_page_id = $postlist['id'];
								$nav_class = ($current_page_id == $page_id)? 'class="active"': '';
								$navclass = ($current_page_id == $page_id)? 'active': '';
								$mainnavbar='';								
								if(strlen($postlist['internal_link']) > '0'){
									$nav_link = str_replace(' ','_',$postlist['internal_link']);
									
								}else{
									$nav_link = str_replace(' ','_',$postlist['pagename']);
								}
							?>
							<li><a href="<?php echo URL.$lang.'/'.$nav_link; ?>/" <?php  if(trim($postlist['external_link'])!="" && $postlist['link_target']==1){ echo "onclick=\"window.open('".$postlist['external_link']."'); return false;\""; }  echo $nav_class;?> ><i class="icon-check"></i>  <?php echo $postlist[$pre.'pagename']; ?></a></li>
							<?php } ?>
						<?php } ?>						
					</ul>
				 
			</div>
			 
			<div class="col-md-3 col-md-push-1">
				<?php echo $contacttext; ?> 
			</div>
		</div>
	</div>	
	<div class="row footer-copyright">
		<div class="container">
			<div class="col-md-6 text-left">
				<div class="copyright_footer"> 
					<?php if(!empty($copyright)){?><small class="block"><?php echo $copyright;?></small><?php } ?>
					<?php if(empty($copyright)){?><p><small class="block">Copyright &copy; <?php echo date('Y');?> All rights reserved. </small></p><?php } ?> 
				</div>	
				
			</div>
			<div class="col-sm-6">
				<div id="social_footer">
				  <ul>
					<li><a href="<?php echo $facebook;?>"><i class="icon-facebook"></i></a></li>
					<li><a href="<?php echo $twitter;?>"><i class="icon-twitter"></i></a></li> 
					<li><a href="<?php echo $youtube;?>"><i class="icon-youtube-play"></i></a></li>
					<li><a href="<?php echo $linkedin;?>"><i class="icon-linkedin"></i></a></li>
					<li><a href="<?php echo $instagram;?>"><i class="icon-instagram"></i></a></li>
					<li><a href="<?php echo $google;?>"><i class="icon-google"></i></a></li> 
					<li><a href="<?php echo $pinterest;?>"><i class="icon-pinterest"></i></a></li>
					<li><a href="<?php echo $vimeo;?>"><i class="icon-vimeo"></i></a></li>
				  </ul>
				</div>
				
				
				<?php /* <ul class="networks">
					<li><a href="<?php echo $twitter;?>"><span class="twitter">Twitter</span></a></li>
					<li><a href="<?php echo $facebook;?>"><span class="facebook">Facebook</span></a></li>
					<li><a href="<?php echo $instagram;?>"><span class="instagram">Instagram</span></a></li>
					<li><a href="<?php echo $linkedin;?>"><span class="linkedin">LinkedIn</span></a></li>
				</ul> */ ?>
			</div>
			<?php /* <div class="col-sm-12">
				<div id="social_footer">
				  <ul>
					<li><a href="#"><i class="icon-facebook"></i></a></li>
					<li><a href="#"><i class="icon-twitter"></i></a></li>
					<li><a href="#"><i class="icon-google"></i></a></li>
					<li><a href="#"><i class="icon-instagram"></i></a></li>
					<li><a href="#"><i class="icon-pinterest"></i></a></li>
					<li><a href="#"><i class="icon-vimeo"></i></a></li>
					<li><a href="#"><i class="icon-youtube-play"></i></a></li>
					<li><a href="#"><i class="icon-linkedin"></i></a></li>
				  </ul>
				</div>
			</div> */ ?>
		</div> 
	</div> 
</footer>
