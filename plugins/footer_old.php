<div class="clearfix"></div>
<div id="sitemap">
    <div class="sitemapmenu">
        <section class="menu">
            <h4>Al-Rasheed</h4>
			<?php 
			if(isset($subpageid)){
				$pageid1 = str_replace('_',' ',$subpageid);
				$pageid2 = mysql_real_escape_string($pageid1);	
				$where = "internal_link='$subpageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$subpageid' OR pagename='$pageid1' OR pagename='$pageid2'";
				
			}elseif(isset($pageid) && strtolower($pageid)!='home'){
				$pageid1 = str_replace('_',' ',$pageid);
				$pageid2 = mysql_real_escape_string($pageid1);	
				$where = "internal_link='$pageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$pageid' OR pagename='$pageid1' OR pagename='$pageid2'";
				
			}else{
				$where = "pagestatus  =  1 and parentpageid = 0";
			}
			$mailpostlist = $mysql->fetch_row("content_tbl",$where, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
			
			
			$where = "pagestatus  =  1 and parentpageid = ".$mailpostlist['id'];
			
			$postlists = $mysql->list_table("content_tbl",$where, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
			 
			 
			 
			if($mysql->affected_rows>0){ 
			$totalnav = $mysql->affected_rows;
			$counter = 1;
			?><ul class="menu"><?php 			
			foreach($postlists as $postlist){ 
				$current_page_id = $postlist['id'];
				$nav_class = ($current_page_id == $page_id)? 'class="active"': '';
				$linav_class = ($current_page_id == $page_id)? 'expanded active-trail': '';	
				if(strlen($postlist['internal_link']) > '0'){
					$nav_link = str_replace(' ','_',$postlist['internal_link']);
				}else{
					$nav_link = str_replace(' ','_',$postlist['pagename']);
				}
				
				if(strlen($mailpostlist['internal_link']) > '0'){
					$mainnav_link = str_replace(' ','_',$mailpostlist['internal_link']);
				}else{
					$mainnav_link = str_replace(' ','_',$mailpostlist['pagename']);
				}
				
				
				 
				
				?>  
				
				<li class="<?php if($counter==$totalnav){?>last<?php }?> <?php if($counter==1){?>first<?php }?> <?php echo $linav_class;?>"><a href="<?php echo URL.$lang.'/'.$mainnav_link.'/'.$nav_link; ?>/" <?php  if(trim($postlist['external_link'])!="" && $postlist['link_target']==1){ echo "onclick=\"window.open('".$postlist['external_link']."'); return false;\""; }  echo $nav_class;?> ><?php echo $postlist[$pre.'pagename']; ?></a>
				 
				
				</li>
			<?php 
				$counter++;
			}
			?>
			</ul>
			<?php }?> 
            
                
			
        </section>

        <section class="teasers">
            <ul>
                <li>
                    <h5><a href="<?php echo URL.$lang.'/'.$mainnav_link.'/';?>press/">Press</a></h5>
					<?php 
					$where = "status = '1' and pageid = ".$mailpostlist['id'];
					$postsnews = $mysql->list_table("news_tbl","status = '1'", array ('limitOffset'=>0,'rowCount'=>1,'range' => '*','sortColumn'=>"newsdate",'sortType'=>'DESC'));

					if($mysql->affected_rows>0){ 	

						foreach($postsnews as $postnews){ 

						$news_title= str_replace(' ','_',$postnews['heading']); ?>
			
                    <a href="<?php echo URL.$lang; ?>/News/<?php echo $mainnav_link.'/'.$news_title; ?>/"><?php echo $postnews[$pre."heading"]; ?></a>
                    <?php echo $postnews[$pre."summary"]; ?>
						<?php }
					}?>	
                </li>
            </ul>
        </section>

		 <section class="contact">
		 
			<?php 
			if(isset($subpageid)){
					$pageid1 = str_replace('_',' ',$subpageid);
					$pageid2 = mysql_real_escape_string($pageid1);	
					$where = "internal_link='$subpageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$subpageid' OR pagename='$pageid1' OR pagename='$pageid2'";
					
				}elseif(isset($pageid) && strtolower($pageid)!='home'){
					$pageid1 = str_replace('_',' ',$pageid);
					$pageid2 = mysql_real_escape_string($pageid1);	
					$where = "internal_link='$pageid' OR internal_link='$pageid1' OR internal_link='$pageid2' OR pagename='$pageid' OR pagename='$pageid1' OR pagename='$pageid2'";
					
				}else{
					$where = "pagestatus  =  1 and parentpageid = 0";
				}
				$mailpostlist = $mysql->fetch_row("content_tbl",$where, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
				
				
				
				$tbl_name="retail_locations_tbl";	
				$where="pageid = ".$mailpostlist['id'];
				$postrows = $mysql->list_table("$tbl_name",false, array ('limitOffset'=>0,'rowCount'=>1,'range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC'));
				$counter=1;
				$totalnav = $mysql->affected_rows;
				if(is_array($postrows) && !empty($postrows)){
						?>
							   
								<?php foreach($postrows as $row){?> 
									 	 <img src="<?php echo URL;?>uploaded/<?php echo  $row["image"];?>" alt="<?php echo  $row[$pre."name"];?>">
										<h4><?php echo  $row[$pre."name"];?></h4> 
										 <?php echo  $row[$pre."description"];?>
										 <p><?php echo  $row[$pre."contact"];?></p>
										 
									<?php $counter++; }?>
								 
							<?php
					
				}	
			?>
			<?php /* echo $contacttext; */?>
          </section>
    </div>
</div>
<div class="clearfix"></div>