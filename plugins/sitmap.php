	<div id="sitemap">
		<ul>
			<?php 
			$pagelists = $mysql->list_table("content_tbl"," pagestatus='1' ", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
			if($mysql->affected_rows>0){ 	
				foreach($pagelists as $pagelist) {
					$pid=$pagelist['id']; 	
						if(strlen($pagelist['internal_link']) > '0'){
							$nav_link = str_replace(' ','_',$pagelist['internal_link']);
						}else{
							$nav_link = str_replace(' ','_',$pagelist['pagename']);
						}
					
					?>
				<li ><a href="<?php echo $nav_link; ?>" ><?php echo $pagelist['pagename'];?></a>
				<?php 
				$subpagelists = $mysql->list_table("content_tbl"," parentpageid=$pid AND pagestatus='1' ", array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
				if($mysql->affected_rows>0){ 
				?>
				<ul><?php
				foreach($subpagelists as $subpagelist) {  
					if(strlen($subpagelist['internal_link']) > '0'){
						$subnav_link = str_replace(' ','_',$subpagelist['internal_link']);
					}else{
						$subnav_link = str_replace(' ','_',$subpagelist['pagename']);
					}
				?>	
				
				<li ><a href="<?php echo $subnav_link; ?>.htm" ><?php echo $subpagelist['pagename'];?></a></li>
				
				<?php
				}
				?>
				</ul>
				<?php	
				}
				?>		
				</li>
			<?php 
				}
			}?> 
		</ul>
	</div>
