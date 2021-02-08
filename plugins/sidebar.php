<div id="servicebereich">
						<div class="region region-sidebar-first">
							<div id="block-views-downloads-block-1" class="block block-views"> 
								<div class="content">
									<div class="view view-Downloads view-id-Downloads view-display-id-block_1 download-page view-dom-id-36b1402a68b5a53d5cb6a7deb7fe364b">
									<?php 
									if($downloadmoduleid>0){
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
										
										
										
										$tbl_name="downloads_tbl";	
										$where="pageid = ".$mailpostlist['id'];
										$postrows = $mysql->list_table("$tbl_name",false, array ('limitOffset'=>0,'rowCount'=>($howmanydownloadsmodules>0?$howmanydownloadsmodules:1),'range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
										$counter=1;
										$totalnav = $mysql->affected_rows;
										if(is_array($postrows) && !empty($postrows)){
											?>
											  <div class="view-content">
												<ul>
												<?php foreach($postrows as $row){?> 
													<li class="<?php if($counter==$totalnav){?>last<?php }elseif($counter==1){?>first<?php }?> <?php if($counter%2==0){?>even<?php }else{?>odd<?php }?>"> 
														<img src="<?php echo URL;?>uploaded/<?php echo  $row[$pre."image"];?>" width="100" height="140" alt="<?php echo  $row[$pre."title"];?>"> 
														<div class="download-links">
															<h4><?php echo  $row[$pre."title"];?></h4>
															<ul> 
																<li class="download download-de"> 
																	<a href="<?php echo URL;?>uploaded/<?php echo  $row["ar_files"];?>" target="_blank">AR</a>
																</li>  
																<li class="download download-en"> 
																	<a href="<?php echo URL;?>uploaded/<?php echo  $row["files"];?>" target="_blank">EN</a>
																</li> 
															</ul>
														</div> 
													</li>
													<?php $counter++; }?>
												</ul>
												</div>
											<?php
												
										}
									}
									if($contactmodulesid>0){
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
										
										
										
										$tbl_name="retail_locations_tbl";	
										$where="pageid = ".$mailpostlist['id'];
										$postrows = $mysql->list_table("$tbl_name",false, array ('limitOffset'=>0,'rowCount'=>($howmanycontactsmodules>0?$howmanycontactsmodules:1),'range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC'));
										$counter=1;
										$totalnav = $mysql->affected_rows;
										if(is_array($postrows) && !empty($postrows)){
											?>
											  <div class="view-content">
												<ul>
												<?php foreach($postrows as $row){?> 
													<li class="<?php if($counter==$totalnav){?>last<?php }elseif($counter==1){?>first<?php }?> <?php if($counter%2==0){?>even<?php }else{?>odd<?php }?>"> 
														<div class="download-links">
															<h4><?php echo  $row[$pre."name"];?></h4> 
															 <?php echo  $row[$pre."description"];?>
															 <p><?php echo  $row[$pre."contact"];?></p>
														</div> 
													</li>
													<?php $counter++; }?>
												</ul>
												</div>
											<?php
												
										}
									}
									?>
										 
									</div>
								</div>
							</div>
						</div>
					</div>