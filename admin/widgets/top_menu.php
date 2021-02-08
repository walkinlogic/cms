<div class="topmenu">
	<?php 
		$current_page=currentPage(); 
		if($current_page=="modules.php" || $current_page=="siteuser_list.php" || $current_page=="new_siteuser.php" || $current_page=="faqs_list.php" || $current_page=="new_faq.php" || $current_page=="form_list.php" || $current_page=="new_form.php" || $current_page=="edit_form.php" || $current_page=="gallery_image.php" || $current_page=="gallery.php" || $current_page=="album_list.php" || $current_page=="new_album.php"  || $current_page=="news_list.php" || $current_page=="new_news.php" || $current_page=="csstyle.php" ){
			$mud_sel = 'id="current"';
		}else{
			$mud_sel='';
		} ?>
	<ul>
	<?php if($_SESSION['MANAGE_PAGE']==1){ ?>
		<li class="overview" <?php echo ($current_page=="pages_list.php") ? 'id="current"':''; ?>><a href="pages_list.php" title="Manage Pages">Overview</a></li><?php } 
			if($_SESSION['MANAGE_PAGE']==1){ ?>
		<li class="unisetting" <?php echo ($current_page=="siteconfig.php") ? 'id="current"':''; ?>><a href="siteconfig.php" title="Manage Universal Settings">Universal Settings</a></li>
		<?php } ?>
		<li class="modules" <?php echo $mud_sel; ?>><a href="modules.php" title="Manage Modules">Modules</a></li>
		<?php if($_SESSION['MANAGE_USER']==1){ ?>
		<li class="user" <?php echo ($current_page=="user_list.php" || $current_page=="new_user.php"  ) ? 'id="current"':''; ?>><a href="user_list.php" title="Manage User">User</a></li>
		<?php }else if($_SESSION['MANAGE_USER']==0){  ?>
		<li class="user" <?php echo ($current_page=="user_list.php" || $current_page=="new_user.php"  ) ? 'id="current"':''; ?>><a href="manage_account.php" title="Manage Account">Account</a></li>
		<?php } ?> 
		<li class="Logout"><a href="logoff.php" title="Logoff">Logoff</a></li>
	</ul>
</div>