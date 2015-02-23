<?php
set_time_limit(0);
global  $wpdb;
if( false == get_option( 'hide_ajax_notification' ) ) {
				add_action("admin_head", "technews_autoinstall"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.
			}


//require_once (TEMPLATEPATH . '/delete_data.php');
function technews_autoinstall()
{
	global $wpdb;
	$wp_user_roles_arr = get_option($wpdb->prefix.'user_roles');
	global $wpdb;
	if((strstr($_SERVER['REQUEST_URI'],'themes.php') && !isset($_REQUEST['page'])) && @$_REQUEST['template']=='' || $_REQUEST['page']=="templatic_system_menu" ){
	
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
		if($post_counts>0){
			$theme_name = get_option('stylesheet');
			$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
			if($nav_menu['nav_menu_locations']['secondary'] == 0){
				$menu_msg = "<p><b>NAVIGATION MENU:</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a>  | <b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/technews-theme-guide'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums'> <b>Community Forum</b></a></p>";
			}else{
				$menu_msg="<p><b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/technews-theme-guide'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums'> <b>Community Forum</b></a></p>";
			}			
			$dummy_data_msg = 'Sample data has been <b>populated</b> on your site. Your sample portal website is ready, click <strong><a href='.site_url().'>here</a></strong> to see how its looks.'.$menu_msg.'<p> Wish to delete sample data?  <a class="button_delete button-primary" href="'.home_url().'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a></br><strong>Note: </strong>In case you modified the dummy content, pressing on the above button will undo all your changes.</p>';
		}else{
			$theme_name = get_option('stylesheet');
			$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
			if($nav_menu['nav_menu_locations']['secondary'] == 0){
				$menu_msg1 = "<p><b>NAVIGATION MENU:</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a>  | <b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/technews-theme-guide'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums'> <b>Community Forum</b></a></p>";
			}else{
				$menu_msg1="<p><b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/technews-theme-guide'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums'> <b>Community Forum</b></a></p>";
			}
			$dummy_data_msg = 'Install sample data: Would you like to <b>auto populate</b> sample data on your site?  <a class="button_insert button-primary" href="'.home_url().'/wp-admin/themes.php?dummy_insert=1">Yes, insert please</a>'.$menu_msg1;
		}
		
		if(isset($_REQUEST['dummy_insert']) && $_REQUEST['dummy_insert']){
			require_once (get_stylesheet_directory().'/functions/auto_install/auto_install_data.php');
			wp_redirect(admin_url().'themes.php');
		}
		if(isset($_REQUEST['dummy']) && $_REQUEST['dummy']=='del'){
			technews_delete_dummy_data();
			wp_redirect(admin_url().'themes.php');
		}
		
		define('THEME_ACTIVE_MESSAGE','<div id="ajax-notification" class="updated templatic_autoinstall"><p> '.$dummy_data_msg.'</p><span id="ajax-notification-nonce" class="hidden">' . wp_create_nonce( 'ajax-notification-nonce' ) . '</span><a href="javascript:;" id="dismiss-ajax-notification" class="templatic-dismiss" style="float:right">Dismiss</a></div>');
		echo THEME_ACTIVE_MESSAGE;
	}
}
function technews_delete_dummy_data()
{
	global $wpdb;
	delete_option('sidebars_widgets'); //delete widgets
	$productArray = array();
	$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')";
	$pids_info = $wpdb->get_results($pids_sql);
	foreach($pids_info as $pids_info_obj)
	{
		wp_delete_post($pids_info_obj->ID,true);
	}
}
/* Setting For dismiss auto install notification message from themes.php START */
register_activation_hook( __FILE__, 'activate'  );
register_deactivation_hook( __FILE__, 'deactivate'  );
add_action( 'admin_enqueue_scripts', 'register_admin_scripts'  );
add_action( 'wp_ajax_hide_admin_notification', 'hide_admin_notification' );
function activate() {
	add_option( 'hide_ajax_notification', false );
}
function deactivate() {
	delete_option( 'hide_ajax_notification' );
}
function register_admin_scripts() {
	wp_register_script( 'ajax-notification-admin', get_stylesheet_directory_uri().'/js/admin_notification.js'  );
	wp_enqueue_script( 'ajax-notification-admin' );
}
function hide_admin_notification() {
	if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax-notification-nonce' ) ) {
		if( update_option( 'hide_ajax_notification', true ) ) {
			die( '1' );
		} else {
			die( '0' );
		}
	}
}
/* Setting For dismiss auto install notification message from themes.php END */?>