<div class="content clearfix">
    <span class="print-link"></span>
    <div class="field field-name-field-views field-type-viewfield field-label-hidden">
        <div class="field-items">
            <div class="field-item even">
                <div class="view view-Downloads view-id-Downloads view-display-id-page_1 download-page view-dom-id-e5bd21728bab5f3c27c4507b7ae6a469"> 
                    <div class="view-filters">
                        <form action="/en/group/downloads-0" method="get" id="views-exposed-form-Downloads-page-1" accept-charset="UTF-8">
                            <div>
                                <div class="views-exposed-form">
                                    <div class="views-exposed-widgets clearfix">
                                        <div id="edit-field-download-art-value-i18n-wrapper" class="views-exposed-widget views-widget-filter-field_download_art_value_i18n">
                                            <div class="views-widget">
                                                <div class="form-item form-type-select form-item-field-download-art-value-i18n">
                                                    <select id="edit-field-download-art-value-i18n" name="field_download_art_value_i18n" class="form-select"><option value="All">- please choose -</option><option value="0">Image Brochure</option><option value="1">Screening Machines</option><option value="2">Dryer Systems</option><option value="3" selected="selected">Other</option></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="views-exposed-widget views-submit-button">
                                            <input type="submit" id="edit-submit-downloads" name="" value="Anwenden" class="form-submit"> </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> 
                    <div class="view-content">
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
						
						
						
						$tbl_name="downloads_tbl";	
						$where="pageid = ".$mailpostlist['id'];
						$postrows = $mysql->list_table("$tbl_name",false, array ('range' => '*','sortColumn'=>"sortorder",'sortType'=>'ASC'));
					 
						if($mysql->affected_rows>0){ 
						$totalnav = $mysql->affected_rows;
						?>
						
						<ul class="node-list">
						<?php $counter=1; foreach($postrows as $row){?>
						
						
                            <li class="<?php if($counter==$totalnav){?>last<?php }?> <?php if($counter==1){?>first<?php }?> <?php if($counter%2==0){?>even<?php }else{?>odd<?php }?>"> 
                                <img src="<?php echo URL;?>uploaded/<?php echo  $row[$pre."image"];?>" width="100" height="140" alt="<?php echo  $row[$pre."title"];?>"> 
                                <div class="download-links">
                                    <h4>Download</h4>
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
							<?php $counter++;}?>
                        </ul>
						<?php }?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>