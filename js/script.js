jQuery(document).ready(function() {
   	
    jQuery('.viewsbox .listview a').click(function(){
		jQuery('#latestpostloop').attr('class','list clear');
		jQuery(this).attr('class','active');
		jQuery('.viewsbox .gridview a').attr('class','');
		jQuery.cookie("display_view", "list");
	});
    jQuery('.viewsbox .gridview a').click(function(){
		jQuery('#latestpostloop').attr('class','grid');
		jQuery(this).attr('class','active');
		jQuery('.viewsbox .listview a').attr('class','');
		jQuery.cookie("display_view", "grid");
	});

	
});
