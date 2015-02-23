<?php
/*
Name : bdw_get_images_with_info
decsc : return related image.
*/
function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =&get_children('order=DESC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
			elseif($img_size == 'popular-thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'popular-thumb'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
			elseif($img_size == 'slider-thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'slider-thumb'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
			elseif($img_size == 'image-thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'image-thumb'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}
/*
Name : wt_get_category_count
decsc : return number of post in particular category.
*/
function wt_get_category_count($input = '') {
	global $wpdb;
	if($input == '')
	{
		$category = get_the_category();
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
	}
}

/*
Name : read_more_link
decsc : return read more link.
*/
function read_more_link()
{
	global $post;
  	$read_more = technews_hybrid_get_setting('content_excerpt_readmore');
	if (function_exists('icl_register_string')) {
		icl_register_string('templatic', 'content_excerpt_readmore',$read_more );
		$read_more = icl_t('templatic', 'content_excerpt_readmore',$read_more);
	}
	

  	if(technews_hybrid_get_setting('content_excerpt_readmore')) { 
  		return " <a href='".get_permalink($post->ID)."' class='read_more'>". sprintf(__('%s','templatic'), $read_more)."</a>";
  	}
}


//FUNCTION NAME : Related post as per tags
//RETURNS : a search box wrapped in a div


function get_related_posts($postdata='',$number='5',$title)
{
		global $wpdb;
		$postCatArr = wp_get_post_categories($postdata->ID);
		$postCatArr_ = implode(',',$postCatArr);
		$number = $number;
		$category_posts = get_posts(array('category'=>$postCatArr_,'numberposts'=>$number+1));
		if($title && $category_posts){ ?><h3><?php echo sprintf(__('%s','templatic'), $title); ?></h3><?php }

		echo "<ul>";
			foreach($category_posts as $post) 
			{
				if($post->ID !=  $postdata->ID)
				{
					$posthtml .= '<td align="left" style="vertical-align: top;">';
					$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

					$du = strtotime($post->post_date);

					$fv = human_time_diff($du, current_time('timestamp')) . " " . __('ago','templatic');
					echo "<li>";
					echo "<span class='date'><i class='fa fa-clock-o'></i>".$fv."</span>";
					echo "<a href='".get_permalink($post->ID)."'>".$post->post_title."</a>";
					echo "</li>";
				}
			}
		echo "</ul>";
}

/**--- Function : Count/fetch the daily views and total views BOF--**/
function view_counter($pid){
	if($_SERVER['HTTP_REFERER'] == '' || !strstr($_SERVER['HTTP_REFERER'],$_SERVER['REQUEST_URI']))
	{
	$viewed_count = get_post_meta($pid,'viewed_count',true);
	$viewed_count_daily = get_post_meta($pid,'viewed_count_daily',true);
	$daily_date = get_post_meta($pid,'daily_date',true);

	update_post_meta($pid,'viewed_count',$viewed_count+1);

	if(get_post_meta($pid,'daily_date',true) == date('Y-m-d')){
		update_post_meta($pid,'viewed_count_daily',$viewed_count_daily+1);
	} else {
		update_post_meta($pid,'viewed_count_daily','1');
	}
	update_post_meta($pid,'daily_date',date('Y-m-d'));
	}
}
/*
Name : user_post_visit_count
decsc : return number of times the post is visited by any user.
*/
function user_post_visit_count($pid)
{
	if(get_post_meta($pid,'viewed_count',true))
	{
		return get_post_meta($pid,'viewed_count',true);
	}else
	{
		return '0';	
	}
}
/*
Name : user_post_visit_count
decsc : return number of times the post is visited by any user per day.
*/
function user_post_visit_count_daily($pid)
{
	if(get_post_meta($pid,'viewed_count_daily',true))
	{
		return get_post_meta($pid,'viewed_count_daily',true);
	}else
	{
		return '0';	
	}
}
/**--- Function : Count/fetch the daily views and total views EOF--**/


/* fetch education customier value */
function technews_hybrid_get_setting( $option = '' ) {
	global $hybrid;

	/* If no specific option was requested, return false. */
	if ( !$option )
		return false;

	/* If the settings array hasn't been set, call get_option() to get an array of theme settings. */
	$hybrid_settings = get_theme_mod('supreme_theme_settings');

	return $hybrid_settings[$option];

	}

/**
 * Description: Floating Social Sharing Button.
**/
function floating_social_widget_script() {
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	var $postShare = $('#side-bar');
	if($('#side-bar').length > 0){
	
		var descripY = parseInt($('#box').offset().top) - 0;
		var pullX = $postShare.css('margin-left');
	
		$(window).scroll(function () { 
		  
			var scrollY = $(window).scrollTop();
			var fixedShare = $postShare.css('position') == 'fixed';
			
			if($('#side-bar').length > 0){
			
				if ( scrollY > descripY && !fixedShare ) {
					$postShare.stop().css({
						position: 'fixed',
						top: 50
					});
				} else if ( scrollY < descripY && fixedShare ) {
					$postShare.css({
						position: 'absolute',
						top: 0,
						marginLeft: pullX
					});
				}
			}
		});
	}
});
</script>
<?php
}

add_action( 'wp_head', 'floating_social_widget_script' );
/*
Name : floating_social_sharing_button
decsc : show social button on single page.
*/
function floating_social_sharing_button()
{
?>
	<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
    <div id="side-bar">
    <div id="box" class="<?php if(get_option('ptthemes_page_layout') == 'Page 2 column - Left Sidebar') {  ?>box-right<?php } else { ?>box-left<?php } ?>">
        <ul>
		<?php 
		if(technews_hybrid_get_setting('fb_like_button'))
		{?>
            <li class="facebookbutton">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				appId = '<?php echo technews_hybrid_get_setting('fb_appId')?>';
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId="+appId;
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
			   <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/"  data-width="450"  data-layout="box_count" data-action="like" data-show-faces="true" data-send="false"></div>
            </li>
		<?php } 
		if(technews_hybrid_get_setting('plusone_button'))
		{?>
            <li>
               <g:plusone size="tall" href="<?php echo get_permalink(); ?>"></g:plusone>
            </li>
		<?php }
		if(technews_hybrid_get_setting('twitter_share_button'))
		{ ?>
            <li>			
				<a href="https://twitter.com/share" data-text="<?php the_title(); ?>" class="twitter-share-button" data-url="<?php echo get_permalink(); ?>" data-counturl="<?php echo get_permalink(); ?>" data-lang="en" data-count="vertical">Tweet</a>
				<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				<div style="clear:both;"></div>
            </li>
		<?php } 
		if(technews_hybrid_get_setting('stumble_upon_button'))
		{ ?>
            <li>
                <script src="http://www.stumbleupon.com/hostedbadge.php?s=5" type="text/javascript"></script>
				<div class="subscribe-share-box count">
				<?php $postid = $post->ID;?>
				<script type='text/javascript'>digg_url= '<?php echo get_permalink($postid); ?>';</script>

				</div>
            </li>
			<?php } ?>
        </ul>
        <div style="clear:both;"></div>
    </div>
    </div>
<?php
}

/*	Function to add theme color settings options in wordpress customizer START	*/
	function technews_register_customizer_settings($wp_customize){
		
		$wp_customize->add_section('technews_theme_settings', array(
			'title' => 'Technews Theme Settings',
			'priority'=>'39'
		));
				
		/*	Add Settings START */
			
			$wp_customize->add_setting('supreme_theme_settings[fb_like_button]',array(
				'default' => '',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_fb_like_button",
				'sanitize_js_callback' => 	"technews_customize_supreme_fb_like_button"
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[fb_appId]',array(
				'default' => '',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_fb_appId",
				'sanitize_js_callback' => 	"technews_customize_supreme_fb_appId"
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[plusone_button]',array(
				'default' => '',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_plusone_button",
				'sanitize_js_callback' => 	"technews_customize_supreme_plusone_button"
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[twitter_share_button]',array(
				'default' => '',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_twitter_share_button",
				'sanitize_js_callback' => 	"technews_customize_supreme_twitter_share_button"
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[stumble_upon_button]',array(
				'default' => '',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_stumble_upon_button",
				'sanitize_js_callback' => 	"technews_customize_supreme_stumble_upon_button"
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[content_excerpt_readmore]',array(
				'default' => '',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_content_excerpt_readmore",
				'sanitize_js_callback' => 	"technews_customize_supreme_content_excerpt_readmore"
				//'transport' => 'postMessage',
			));
			
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color1]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_color1",
				'sanitize_js_callback' => 	"technews_customize_supreme_color1",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color2]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_color2",
				'sanitize_js_callback' => 	"technews_customize_supreme_color2",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color3]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_color3",
				'sanitize_js_callback' => 	"technews_customize_supreme_color3",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color4]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_color4",
				'sanitize_js_callback' => 	"technews_customize_supreme_color4",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color5]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_color5",
				'sanitize_js_callback' => 	"technews_customize_supreme_color5",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color6]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"technews_customize_supreme_color6",
				'sanitize_js_callback' => 	"technews_customize_supreme_color6",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_control( 'fb_like_button', array(
				'label'   => __( 'FaceBook Like  buttons', T_DOMAIN),
				'section' => 'technews_theme_settings',
				'settings'   => 'supreme_theme_settings[fb_like_button]',
				'type' => 'checkbox'
			) ) ;
			
			$wp_customize->add_control( 'fb_appId', array(
				'label'   => __( 'FaceBook AppID', T_DOMAIN),
				'section' => 'technews_theme_settings',
				'settings'   => 'supreme_theme_settings[fb_appId]',
			) ) ;
			$wp_customize->add_control( 'plusone_button', array(
				'label'   => __( 'Google Plus buttons', T_DOMAIN),
				'section' => 'technews_theme_settings',
				'settings'   => 'supreme_theme_settings[plusone_button]',
				'type' => 'checkbox'
			) ) ;
			
			$wp_customize->add_control( 'twitter_share_button', array(
				'label'   => __( 'Twitter Share buttons', T_DOMAIN),
				'section' => 'technews_theme_settings',
				'settings'   => 'supreme_theme_settings[twitter_share_button]',
				'type' => 'checkbox'
			) ) ;
			
			$wp_customize->add_control( 'stumble_upon_button', array(
				'label'   => __( 'Stumble Upon buttons', T_DOMAIN),
				'section' => 'technews_theme_settings',
				'settings'   => 'supreme_theme_settings[stumble_upon_button]',
				'type' => 'checkbox'
			) ) ;
			
			$wp_customize->add_control( 'content_content_excerpt_readmore', array(
				'label'   => __( 'Content Excerpt "Read More" Link Text', T_DOMAIN),
				'section' => 'technews_theme_settings',
				'settings'   => 'supreme_theme_settings[content_excerpt_readmore]',
				'type' => 'text'
			) ) ;
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color1', array(
				'label'   => __( 'Primary : Main headings, Titles, Links', T_DOMAIN),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color1]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color2', array(
				'label'   => __( 'Secondary : Navigation hover, Link hover, Headings hover, Selected', T_DOMAIN ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color2]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color3', array(
				'label'   => __( 'Content', T_DOMAIN ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color3]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color4', array(
				'label'   => __( 'Subtexts', T_DOMAIN ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color4]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color5', array(
				'label'   => __( 'Footer background & Navigation hover', T_DOMAIN ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color5]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color6', array(
				'label'   => __( 'Change color of Body Background', T_DOMAIN ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color6]',
			) ) );
			$wp_customize->remove_control('background_color');
		
	}		

	function technews_customize_supreme_fb_like_button( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[fb_like_button]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_fb_like_button", $setting, $object );
	}
	function technews_customize_supreme_fb_appId( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[fb_appId]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_fb_appId", $setting, $object );
	}
	
	function technews_customize_supreme_plusone_button( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[plusone_button]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_plusone_button", $setting, $object );
	}	
	
	function technews_customize_supreme_twitter_share_button( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[twitter_share_button]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_twitter_share_button", $setting, $object );
	}	
	
	function technews_customize_supreme_stumble_upon_button( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[stumble_upon_button]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_stumble_upon_button", $setting, $object );
	}	
	
	function technews_customize_supreme_content_excerpt_readmore( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[content_excerpt_readmore]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_content_excerpt_readmore", $setting, $object );
	}
	
	function technews_customize_supreme_color1( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color1]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_color1", $setting, $object );
	}	
	function technews_customize_supreme_color2( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color2]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_color2", $setting, $object );
	}	
	function technews_customize_supreme_color3( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color3]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_color3", $setting, $object );
	}	
	function technews_customize_supreme_color4( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color4]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_color4", $setting, $object );
	}
	function technews_customize_supreme_color5( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color5]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_color5", $setting, $object );
	}
	function technews_customize_supreme_color6( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color6]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "technews_customize_supreme_color6", $setting, $object );
	}
	

/*	Function to add theme color settings options in wordpress customizer END	*/

/*
FUNCTION NAME : templ_sendEmail
ARGUMENTS : from email ID,From email Name, To email ID, To email name, Mail Subject, Mail Content, Mail Header.
RETURNS : Send Mail to the email address. */
function templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$fromEmail = apply_filters('templ_send_from_emailid', $fromEmail);
	$fromEmailName = apply_filters('templ_send_from_emailname', $fromEmailName);
	$toEmail = apply_filters('templ_send_to_emailid', $toEmail);
	$toEmailName = apply_filters('templ_send_to_emailname', $toEmailName);
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
	$subject = apply_filters('templ_send_email_subject', $subject);
	$message = apply_filters('templ_send_email_content', $message);
	$headers = apply_filters('templ_send_email_headers', $headers);
	
	// Mail it

		wp_mail($toEmail, $subject, $message, $headers);	
	
}
/* add script on header */
add_action('wp_head','technews_script');
function technews_script(){ ?>
		<script type="text/javascript">
		jQuery(window).load(function() {
		jQuery('.flexslider').flexslider();
		});
			jQuery(document).ready(function(){
				jQuery('#menu-secondary-title').click(function(){
					jQuery('#menu-secondary .menu').slideToggle('slow');
				});
				jQuery('#menu-primary-title').click(function(){
					jQuery('#menu-primary .menu').slideToggle('slow');
				});
			

				jQuery('.backtotop').click(function() {
					jQuery('html,body').animate({scrollTop: jQuery('#header').offset().top}, "slow");
				});
	});
	</script>
<?php }

/* 
Name : get_url_var
Desc : Fetch page number from url in pagination
*/

function get_url_var($name)
{
    $strURL = $_SERVER['REQUEST_URI'];
    $arrVals = split("/",$strURL);
    $found = 0;
    foreach ($arrVals as $index => $value) 
    {
        if($value == $name) $found = $index;
    }
    $place = $found + 1;
    return $arrVals[$place];
}


/* THEME UPDATE CODING START */
//Theme update templatic menu
function TechNews_tmpl_theme_update(){
	require_once(get_stylesheet_directory()."/templatic_login.php");
}


/* Theme update templatic menu*/
function TechNews_tmpl_support_theme(){
	echo "<h3>Need Help?</h3>";
	echo "<p>Here's how you can get help from templatic on any thing you need with regarding this theme. </p>";
	echo "<br/>";
	echo '<p><a href="http://templatic.com/docs/technews2/" target="blank">'."Take a look at theme guide".'</a></p>';
	echo '<p><a href="http://templatic.com/docs/" target="blank">'."Knowlegebase".'</a></p>';
	echo '<p><a href="http://templatic.com/forums/" target="blank">'."Explore our community forums".'</a></p>';
	echo '<p><a href="http://templatic.com/helpdesk/" target="blank">'."Create a support ticket in Helpdesk".'</a></p>';
}

/* Theme update templatic menu*/
function TechNews_tmpl_purchase_theme(){
	wp_redirect( 'http://templatic.com/wordpress-themes-store/' ); 
	exit;
}

add_action('admin_menu','TechNews_theme_menu',11); // add submenu page 
add_action('admin_menu','delete_TechNews_templatic_menu',11);
function TechNews_theme_menu(){
	
	add_submenu_page( 'templatic_menu', 'Theme Update','Theme Update', 'administrator', 'TechNews_tmpl_theme_update', 'TechNews_tmpl_theme_update',27 );
	
	add_submenu_page( 'templatic_menu', 'Framework Update','Framework Update', 'administrator', 'tmpl_framework_update', 'tmpl_framework_update',28 );
	
	add_submenu_page( 'templatic_menu', 'Get Support' ,'Get Support' , 'administrator', 'TechNews_tmpl_support_theme', 'TechNews_tmpl_support_theme',29 );
	
	add_submenu_page( 'templatic_menu', 'Purchase theme','Purchase theme', 'administrator', 'TechNews_tmpl_purchase_theme', 'TechNews_tmpl_purchase_theme',30 );
}


/*
	Realtr delete menu 
*/	
function delete_TechNews_templatic_menu(){
	remove_submenu_page('templatic_menu', 'templatic_menu'); 
}

/* THEME UPDATE CODING END */

?>