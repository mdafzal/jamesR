<?php
/**
 * This is your child theme functions file.  In general, most PHP customizations should be placed within this
 * file.  Sometimes, you may have to overwrite a template file.  However, you should consult the theme 
 * documentation and support forums before making a decision.  In most cases, what you want to accomplish
 * can be done from this file alone.  This isn't a foreign practice introduced by parent/child themes.  This is
 * how WordPress works.  By utilizing the functions.php file, you are both future-proofing your site and using
 * a general best practice for coding.
 *
 * All style/design changes should take place within your style.css file, not this one.
 *
 * The functions file can be your best friend or your worst enemy.  Always double-check your code to make
 * sure that you close everything that you open and that it works before uploading it to a live site.
 *
 * @package SupremeChild
 * @subpackage Functions
 */

/* Adds the child theme setup function to the 'after_setup_theme' hook. */
ini_set('display_errors', '0');
define('DOMAIN','templatic');
load_child_theme_textdomain(DOMAIN);
load_textdomain( DOMAIN, get_stylesheet_directory().'/languages/en_US.mo');

if(!function_exists('supreme_get_theme_data')){
	/*
	Name: supreme_get_theme_data
	Desc: return the theme data
	*/
	function supreme_get_theme_data( $theme_file ) {
		$theme = new WP_Theme( basename( dirname( $theme_file ) ), dirname( dirname( $theme_file ) ) );

		$theme_data = array(
			'Name' => $theme->get('Name'),
			'URI' => $theme->display('ThemeURI', true, false),
			'Description' => $theme->display('Description', true, false),
			'Author' => $theme->display('Author', true, false),
			'AuthorURI' => $theme->display('AuthorURI', true, false),
			'Version' => $theme->get('Version'),
			'Template' => $theme->get('Template'),
			'Status' => $theme->get('Status'),
			'Tags' => $theme->get('Tags'),
			'Title' => $theme->get('Name'),
			'AuthorName' => $theme->get('Author'),
		);

		foreach ( apply_filters( 'extra_theme_headers', array() ) as $extra_header ) {
			if ( ! isset( $theme_data[ $extra_header ] ) )
				$theme_data[ $extra_header ] = $theme->get( $extra_header );
		}

		return $theme_data;
	}
}

$theme_name ='';
global $extension_file, $pagenow, $theme_name;

//Theme Autoupdate Code start
if(is_admin() && ($pagenow =='themes.php' || $pagenow =='post.php' || $pagenow =='edit.php'|| $pagenow =='admin-ajax.php'  || @$_REQUEST['page'] == 'TechNews_tmpl_theme_update')){
	require_once('wp-updates-theme.php');
	$theme_data = supreme_get_theme_data(get_stylesheet_directory().'/style.css');
	new WPUpdatesTechNewsUpdater( 'http://templatic.com/updates/api/index.php',basename(get_stylesheet_directory()));
}
//Theme Autoupdate code end

add_action( 'after_setup_theme', 'supreme_child_theme_setup', 11 );
global $pagenow;
if(is_admin() && 'customize.php' == $pagenow){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this section.','templatic' ) );
	}
}
add_action( 'after_setup_theme', 'supreme_child_theme_setup', 11 );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since 0.1.0
 */
 
function supreme_child_theme_setup() {

	/* Get the theme prefix ("supreme"). */
	$prefix = hybrid_get_prefix();

	/* Example action. */
	// add_action( "{$prefix}_header", 'dotos_child_example_action' );

	/* Example filter. */
	// add_filter( "{$prefix}_site_title", 'dotos_child_example_filter' );
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	remove_action( 'init', 'supreme_register_menus' );
	
	add_theme_support( 'hybrid-core-menus', array( // Add core menus.
		'primary',
		'secondary'		
		) );
	add_theme_support( 'supreme-slider');
	global $displaytype;
	$displaytype = $_COOKIE['display_view'];
	
	/*  Add Action for Customizer Controls Settings Start */
			add_action( 'customize_register',  'technews_register_customizer_settings');
	/*  Add Action for Customizer Controls Settings End */
	
	add_action( 'init', 'setup' );
	function setup() {
			add_theme_support( 'post-thumbnails' ); // This feature enables post-thumbnail support for a theme  
			add_image_size( 'popular-thumb', 73, 51, true ); //(cropped)
			add_image_size( 'image-thumb', 190, 110, true ); //(cropped)
			add_image_size( 'slider-thumb', 642, 300, true ); //(cropped)
	}
	
	add_filter( 'image_size_names_choose', 'custom_image_sizes_crop' );
	function custom_image_sizes_crop( $sizes ) {
		$custom_sizes = array(
			'popular-thumb' => 'Popular Thumb',
			'image-thumb'	=> 'Image Thumb',
			'slider-thumb'	=> 'Slider Thumb'
		);
		return array_merge( $sizes, $custom_sizes );
	}
	$prefix = hybrid_get_prefix();
	add_filter( "{$prefix}_entry_meta", 'visual_entry_meta' );
	function visual_entry_meta()
	{ 
		global $post;
		echo "";		
	
	}

}
if(file_exists(get_stylesheet_directory()."/functions/widget_functions.php") ){
    include_once(get_stylesheet_directory()."/functions/widget_functions.php");
}
if(file_exists(get_stylesheet_directory()."/functions/custom_functions.php") ){
	include_once(get_stylesheet_directory()."/functions/custom_functions.php");
}
if(file_exists(get_stylesheet_directory()."/functions/auto_install/auto_install.php")){
		include_once(get_stylesheet_directory().'/functions/auto_install/auto_install.php');
	}
	
	
	
	add_action('wp_head', 'technews_templatic_load_theme_stylesheet');
	
	function technews_templatic_load_theme_stylesheet(){
		/*	Function to load the custom stylesheet. 
		from this if we select any color from 
		"Theme Color Settings" in backend and 
		save some color then then this file is called	*/
		include(get_stylesheet_directory().'/css/admin-style.php');
	}
	
//ADDED CODE FOR FAVICON ICON SETTINGS START.
add_action('wp_head', 'technewsfavocin_icon');
function technewsfavocin_icon() {
	$GetSupremeThemeOptions = get_option('supreme_theme_settings');
	$GetFaviconIcon = $GetSupremeThemeOptions['supreme_favicon_icon'];
	if($GetFaviconIcon!=""){
		echo '<link rel="shortcut icon" href="' . $GetFaviconIcon . '" />';
	}
}
//ADDED CODE FOR FAVICON ICON SETTINGS FINISH.	

if (is_admin()) 
{	
	/* Remove theme layout post meta box */
	function remove_theme_layout_meta_box()
	{		
		add_theme_support( 'theme-layouts', array( // Add theme layout options.
			'1c',
			'2c-l',
			'2c-r'
		) );
	}
	/*Add Meta Boxes for remove theme layout meta box */
	add_action( 'add_meta_boxes', 'remove_theme_layout_meta_box',11 );
}

/*	include font awesome css */
		add_action( 'init', 'theme_css_on_init' ); // include fonts awesome
		function theme_css_on_init() {
				if(is_ssl()){ $http = "https://"; }else{ $http ="http://"; }
				wp_register_style( 'fontawesomecss', $http.'cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css' );
				wp_enqueue_style( 'fontawesomecss' );
		}
		
?>