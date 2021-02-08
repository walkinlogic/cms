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

if(strlen($mailpostlist['internal_link']) > '0'){
	$mainnavlink = str_replace(' ','_',$mailpostlist['internal_link']);
}else{
	$mainnavlink = str_replace(' ','_',$mailpostlist['pagename']);
}
$retaillocationlists = $mysql->list_table("retail_locations_tbl","status='1' ", array ('range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC')); if($mysql->affected_rows>0){ ?>
<div class="field-items">
  <div class="field-item even">
    <div class="view view-Kontakte-weltweit view-id-Kontakte_weltweit view-display-id-page_1 view-dom-id-aa6dff8ab7b49a9cf608f8f2085b1582 jquery-once-2-processed">
      <div class="view-content">
        <ul style="margin-top: 10px;">
          <?php foreach($retaillocationlists as $locationlist) {?>
          <li>
            <h5> <?php echo $locationlist[$pre."name"];?> </h5>
            <div class="address">
              <p><?php echo $locationlist[$pre."description"];?></p>
            </div>
            <?php if($locationlist["website"]!=''){?>
            <div class="website"> <a href="<?php echo $locationlist["website"];?>" target="_blank" class="ext"><?php echo $locationlist["website"];?></a> </div>
            <?php }?>
            <div class="email"> <a href="<?php echo URL.$lang.'/form/'.str_replace(' ','_',$mainnavlink).'/'.str_replace(' ','_',$locationlist["name"]).'/'.str_replace(' ','_',$locationlist["id"]);?>/">Send email</a> </div>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php } ?>