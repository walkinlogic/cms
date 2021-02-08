<?php 
$postlists = $mysql->list_table("content_tbl","pagestatus = '1' AND parentpageid = '0' ", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
if($lang!='ar'){
	$pre='';
	$lang='eng';	
}else{
	$pre='ar_';
}

?>
<nav class="design-nav  navbar-fixed-top" role="navigation">
	<div class="top-menu">
		<div class="container">
			<div class="row">
				<div class="col-xs-2">
					<div id="design-logo" class="brand"><a href="<?php echo URL;?>"><img src="images/logo.png" alt="<?php echo $pageid;?>"></a></div>
				</div>
				<div class="col-xs-10 text-right menu-1"> 
					
					<ul>
					<li <?php if($pageid=='home'){?>class="active"<?php } ?>><a href="<?php echo URL.$lang;?>/home/"><?php if($pre==''){?>Home<?php }else{ ?>الصفحة الرئيسية<?php }?></a></li>
					<?php 
					if($mysql->affected_rows>0){ 
						$totalnav = $mysql->affected_rows;
					?>
					<?php $counter=0;  foreach($postlists as $postlist){  ?>	
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
								$mainnavbar=$nav_link;
								
								$pid=$postlist['id'];
								$subpagelists = $mysql->list_table("content_tbl"," parentpageid=$pid AND pagestatus='1' ", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
							?>
							<li class="<?php if($mysql->affected_rows>0){ ?>has-dropdown <?php }  echo $navclass;?> ">
								<a href="<?php echo URL.$lang.'/'.$nav_link; ?>/" <?php  if(trim($postlist['external_link'])!="" && $postlist['link_target']==1){ echo "onclick=\"window.open('".$postlist['external_link']."'); return false;\""; }  echo $nav_class;?> title="<?php echo urlencode($postlist[$pre.'pagename']); ?>" ><?php echo $postlist[$pre.'pagename']; ?></a>
								
								<?php if($mysql->affected_rows>0){ ?>
								<ul class="dropdown">
									<?php foreach($subpagelists as $subpagelist) { ?>
										<?php 
											
										if(strlen($subpagelist['internal_link']) > '0'){ 
											$subnav_link = str_replace(' ','_',$subpagelist['internal_link']); 
										}else{ 
											$subnav_link = str_replace(' ','_',$subpagelist['pagename']); 
										}
										?>
										<li ><a href="<?php echo URL.$lang.'/'.$mainnavbar.'/'.$subnav_link; ?>/" <?php  if(trim($subpagelist['external_link'])!="" && $subpagelist['link_target']==1){ echo "onclick=\"window.open('".$subpagelist['external_link']."'); return false;\""; } ?> ><?php echo $subpagelist['pagename'];?></a></li>
										
									<?php } ?> 
								</ul>
								<?php } ?>
							</li>
							
							<?php $counter++; ?>
						<?php } ?>
					<?php }?>		
					 
					  <li class="<?php if(empty($pre)){echo 'active';}?>"><a class="lang eng" href="<?php echo URL.'eng/'.$pageid; ?>/" xml:lang="en" hreflang="eng">English</a></li>
					  <li class="<?php if($pre=='ar_'){echo 'active';}?>"><a class="lang ar" href="<?php echo URL.'ar/'.$pageid; ?>/" xml:lang="ar" hreflang="ar">Arabic</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>