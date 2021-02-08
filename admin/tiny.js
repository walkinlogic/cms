		tinyMCE.init({
			mode : "textareas",
		theme : "advanced",
			theme : "advanced",
			plugins : "safari,pagebreak,style,layer,advimage,advlink,media,contextmenu,inlinepopups,fullscreen,preview,table,paste,xhtmlxtras,directionality,noneditable,visualchars,nonbreaking,template",
			theme_advanced_buttons1_add_before : "",
			theme_advanced_buttons2_add : "separator,liststyle",
			theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator",
			theme_advanced_buttons3_add_before : "",
			theme_advanced_buttons3_add : "media,tablecontrols",
			theme_advanced_disable : "hr,outdent,indent,help,removeformat,sub,sup",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			extended_valid_elements : "hr[class|width|size|noshade]",
			file_browser_callback : "ajaxfilemanager",
			paste_use_dialog : true,
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : true,
			apply_source_formatting : true,
			force_br_newlines : true,
			force_p_newlines : false,	
			relative_urls : false
			
		});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?editor=tinymce";
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?editor=tinymce",
                width: 782,
                height:440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
		}