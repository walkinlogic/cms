<?php 
	function cleaninputfield($mysql,$value){
		return mysqli_real_escape_string($mysql->connection,$value);	 
	}
	
	function formatedate($rawdate){
		return date('Y-m-d' , strtotime($rawdate));
	}
	
	//formate date for insert into Db
	function usaformate($rawdate){
		return date('d M Y' , strtotime($rawdate));
	}
	function currentPage() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
	//file upoading function                 
	function fileExists($file,$dir) {
		$i=1; $probeer=$file;
		while(file_exists($dir.$probeer)) {
			$punt=strrpos($file,".");
			if(substr($file,($punt-3),1)!==("[") && substr($file,($punt-1),1)!==("]")) {
				$probeer=substr($file,0,$punt)."[".$i."]".
				substr($file,($punt),strlen($file)-$punt);
			   } else {
					   $probeer=substr($file,0,($punt-3))."[".$i."]".
					   substr($file,($punt),strlen($file)-$punt);
					  }
					$i++;
		  }
		  return $probeer;
	}// end of the file uploading function 
	
	function getAlbumImage($args1,$obj){
		$rec = $obj->fetch_row("album_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return $rec['image'];
		else
			return '';	
	}
	function getGalleryImage($args1,$obj){
		$rec = $obj->fetch_row("images_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return $rec['image'];
		else
			return '';	
	}
	function getAdminName($args1,$obj){
		$rec = $obj->fetch_row("user_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return ucfirst($rec['full_name']);
		else
			return '';	
	}
	function getSlideName($args1,$obj){
		$rec = $obj->fetch_row("slide_show_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return ucfirst($rec['image']);
		else
			return '';	
	}
	function getCustomImage($args1,$obj){
		$rec = $obj->fetch_row("customimages_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return ucfirst($rec['image']);
		else
			return '';	
	}
	
	function getPageid($args1,$obj){
		$rec = $obj->fetch_row("content_history_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return $rec['page_id'];
		else
			return '';	
	}
	
	function getPageName($args1,$obj){
		$rec = $obj->fetch_row("content_tbl","id=$args1");
		if($obj->affected_rows>0)	
			return $rec['pagename']; 	
		else
			return '';	
	}
	?>