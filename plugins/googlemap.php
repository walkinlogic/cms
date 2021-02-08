<div class="clear"></div>
<div style="width:97.5%;height:400px;margin:0 auto;" id="openlayers-map" class="openlayers-map openlayers-map-allgaier-preset openlayers-map-processed olMap openlayers-openlayers_behavior_attribution-processed openlayers-openlayers_behavior_keyboarddefaults-processed openlayers-openlayers_behavior_navigation-processed openlayers-openlayers_behavior_panzoombar-processed"></div>


<script>
      function initMap() {
        var mapDiv = document.getElementById('openlayers-map');
        var map = new google.maps.Map(mapDiv, {
          center: {lat: 21.7341, lng: 39.0829},
          zoom: 8
        });
		
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
		$retaillocationlists = $mysql->list_table("retail_locations_tbl","status='1' ", array ('range' => '*','sortColumn'=>"sort_order",'sortType'=>'ASC')); 
		if($mysql->affected_rows>0){ ?>

		<?php foreach($retaillocationlists as $locationlist) {?> 
		var myLatLng<?php echo $locationlist['id'];?> = {lat: <?php echo $locationlist['latitude'];?>, lng: <?php echo $locationlist['longitude'];?>};
		var iconBase = '<?php echo URL;?>images/';
		var contentString<?php echo $locationlist['id'];?>='<h1><?php echo $locationlist[$pre."name"];?></h1><?php echo $locationlist[$pre."description"];?>';
		var marker<?php echo $locationlist['id'];?> = new google.maps.Marker({
		  position: myLatLng<?php echo $locationlist['id'];?>,
		  map: map,
		  title: '<h1><?php echo $locationlist[$pre."name"];?></h1><?php echo $locationlist[$pre."description"];?>',
		  icon: '<?php echo URL;?>images/a.png'
		}); 
		marker<?php echo $locationlist['id'];?>.addListener('click', function() {
			infowindow<?php echo $locationlist['id'];?>.open(map, marker<?php echo $locationlist['id'];?>);
		  });
		var infowindow<?php echo $locationlist['id'];?> = new google.maps.InfoWindow({
			content: contentString<?php echo $locationlist['id'];?>
		  });
		<?php } ?>
		<?php } ?>
		 
      }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>		  
		 