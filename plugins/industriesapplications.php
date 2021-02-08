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


$tbl_name="collections_tbl";
$postrows = $mysql->list_table("$tbl_name","status=1", array ('range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC'));

if($mysql->affected_rows>0){
	
?>

<div class="content clearfix"> <span class="print-link"></span>
  <div class="field field-name-body field-type-text-with-summary field-label-hidden">
    <div class="field-items">
      <div class="field-item even">
        <ul class="applikation">
		<?php foreach($postrows as $value => $postrow){?>
			<?php $indnav_link = str_replace(' ','_',$postrow['name']);
			
			if(strlen($mailpostlist['internal_link']) > '0'){
				$mainnavlink = str_replace(' ','_',$mailpostlist['internal_link']);
			}else{
				$mainnavlink = str_replace(' ','_',$mailpostlist['pagename']);
			}
			?>
          <li>
			<a href="<?php echo URL.$lang.'/collection/'.str_replace(' ','_',$mainnavlink)/* .'/'.str_replace('_',' ',$pageid) */;?>/<?php echo stripslashes($indnav_link); ?>/"><?php echo stripslashes($postrow[$pre.'name']); ?><span class="ext"><span class="element-invisible"> (link is external)</span></span></a><br>
            <a href="<?php echo URL.$lang.'/collection/'.str_replace(' ','_',$mainnavlink)/* .'/'.str_replace('_',' ',$pageid) */;?>/<?php echo stripslashes($indnav_link); ?>/"><img alt="<?php echo stripslashes($postrow[$pre.'name']); ?>" height="100" src="<?php echo URL;?>uploaded/<?php echo $postrow['image']; ?>" width="171"></a></li>
		<?php } ?>	
        </ul>
      </div>
    </div>
  </div>
</div>
<?php } ?>