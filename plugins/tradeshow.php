<?php 
$tbl_name="tradeshows_tbl";
$postrows = $mysql->list_table("$tbl_name","status = 1", array ('range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC'));
if($mysql->affected_rows>0){
?>

<div class="content clearfix"> 
    <div class="field field-name-field-views field-type-viewfield field-label-hidden">
        <div class="field-items">
            <div class="field-item even">
                <div class="view view-messen3 view-id-messen3 view-display-id-page_1 bluetiles view-dom-id-4613abbab2ae998d9b67cf22e393b6e7"> 
                    <div class="view-content">
                        <ul>
						<?php foreach($postrows as $value => $postrow){?>
                            <li> 
                                <img src="<?php echo URL;?>uploaded/<?php echo  $postrow[$pre."image"];?>" width="106" height="86" alt="<?php echo $postrow[$pre.'name']; ?>" title="<?php echo $postrow[$pre.'name']; ?>"> 
                                <h3> <a href="<?php echo $postrow['weblink']; ?>" target="_blank" class="ext"><?php echo $postrow[$pre.'name']; ?><span class="ext"><span class="element-invisible"> (link is external)</span></span></a></h3>
                                 
								<div class="detail">
								<?php echo $postrow[$pre.'description']; ?>
								</div>
                                <div class="location">
                                    <p><?php echo $postrow[$pre.'address']; ?></p>
                                </div>
                            </li>
						<?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>