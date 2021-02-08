<?php  
$postslides = $mysql->list_table("slide_show_tbl","status = '1'  AND pageid=$page_id ", array ('range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC'));
if($mysql->affected_rows>0){
	if($lang!='ar'){
		$pre='';
		$lang='eng';	
	}else{
		$pre='ar_';
	}
?>
<aside id="design-hero">
	<div class="flexslider">
		<ul class="slides">
			<?php  $counter=0;
				foreach($postslides as $postslide){ ?>
					<li style="background-image: url(<?php echo URL; ?>uploaded/<?php echo $postslide['image']; ?>);">
						<div class="overlay"></div>
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-8 col-sm-12 col-md-offset-2 slider-text">
									<div class="slider-text-inner text-center">
										<h2><?php echo $postslide[$pre.'title']; ?></h2>
										<h1><?php echo $postslide[$pre.'alt_text']; ?></h1>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php } ?> 
		</ul>
	</div>
</aside>
<?php } ?>