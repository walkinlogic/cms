<?php 
if(isset($subpageid)){
	$pageid1 = str_replace('_',' ',$subpageid);
	$pageid2 = mysqli_real_escape_string($mysql->connection,$pageid1);	
	$where = "internal_link='$subpageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$subpageid' OR pagename='$pageid1' OR pagename='$pageid2'";
	
}elseif(isset($pageid)){
	$pageid1 = str_replace('_',' ',$pageid);
	$pageid2 = mysqli_real_escape_string($mysql->connection,$pageid1);	
	$where = "internal_link='$pageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$pageid' OR pagename='$pageid1' OR pagename='$pageid2'";
	
}else{
	$where = false;
}
$mailpostlist = $mysql->fetch_row("content_tbl",$where, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
$maintitle='';
if(!empty($mailpostlist)){
	if(strlen($mailpostlist['internal_link']) > '0'){
		$nav_link = str_replace(' ','_',$mailpostlist['internal_link']);
	}else{
		$nav_link = str_replace($mailpostlist);
	} 
	$maintitle=$nav_link.'/';
}


$postsnews = $mysql->list_table("news_tbl","status = '1'", array ('range' => '*','sortColumn'=>"newsdate",'sortType'=>'DESC'));
if($mysql->affected_rows>0){
?>
	<div id="design-blog" class="designlightgrey">
		<div class="container">
			<div class="row">
				<div class="col-md-4 animate-box design-heading animate-box">
					<span class="sm"><?php if($pre==''){?>Recent Blog<?php }else{ ?>مدونة حديثة<?php } ?></span>
					<h2><span class="thin"><?php if($pre==''){?>Read<?php }else{ ?>اقرأ<?php } ?></span> <span class="thick"><?php if($pre==''){?>Our Blog<?php }else{ ?>مدونتناأ<?php } ?></span></h2> 
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="wrap">
							<?php
							$counter=1;
							foreach($postsnews as $postnews){ 
								$news_title= urlencode(str_replace(' ','_',$postnews['heading'])); ?>
							
							<div class="blog-entry animate-box">
								<a href="<?php echo URL.$lang; ?>/News/<?php echo $news_title; ?>/" class="blog-img" style="background-image: url(<?php echo URL; ?>uploaded/<?php echo  $postnews[$pre."image"];?>);"></a>
								<div class="desc">
									<span>&mdash; <?php echo date('d m Y' , strtotime($postnews["newsdate"])); ?> </span>
									<h2>
										<a href="<?php echo URL.$lang; ?>/News/<?php echo $news_title; ?>/"><?php echo $postnews[$pre."heading"]; ?></a>
									</h2>
									<p><?php echo $postnews[$pre."summary"]; ?></p>
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