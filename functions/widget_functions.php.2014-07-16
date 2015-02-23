<?php
// Register widgetized areas
function technews_register_widget()
{
	if ( function_exists('register_sidebar') )
	{
		register_sidebars(1,array('id' => 'primary_menu_widget_area','name' => __('Above Header: Primary Menu Right Area','templatic'),'description' => 'The rightmost section alongside the primary menu. A search box  can go here.','before_widget'=>'<div class="widget widget-search">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
		register_sidebars(1,array('id' => 'header_logo_right_side','name' => __('Header: Right area','templatic'),'description' => 'The rightmost section alongside the logo. A search box or a login form can go here.','before_widget'=>'<div class="widget ">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
		register_sidebars(1,array('id' => 'front_content','name' => __('Front Content','templatic'), 'description' => 'This region is located in content area, You can put latest post code here.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
		register_sidebars(1,array('name' => __('Single post: Below Content','templatic'), 'description' => 'This region appears only on single posts, just after your content. You can put adsense code or social media button codes here.','id' => 'single_post_below','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
		register_sidebars(1,array('id'=>'footer1','name'=>'Footer 1','description'=>'Display wigets in the first column of the footer','before_widget'=>'<div class="widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
		register_sidebars(1,array('id'=>'footer2','name'=>'Footer 2','description'=>'Display wigets in 4 columns in footer after the footer 2 area','before_widget'=>'<div class="widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
	}
}
add_action( 'widgets_init', 'technews_register_widget', 13 );
/*
Name : templ_remove_widgetareas
Description : remove unnecessory widget areas
*/
function templ_remove_widgetareas(){
	// Unregsiter some of the TwentyTen sidebars
	unregister_sidebar( 'after-content' );
	unregister_sidebar( 'subsidiary-2c' );
	unregister_sidebar( 'subsidiary-3c' );
	unregister_sidebar( 'subsidiary-4c' );
	unregister_sidebar( 'subsidiary-5c' );
	unregister_sidebar( 'after-header-2c' );
	unregister_sidebar( 'after-header-3c' );
	unregister_sidebar( 'after-header-4c' );
	unregister_sidebar( 'widgets-template' );
	unregister_sidebar( 'after-header-5c' );
	unregister_sidebar( 'after-header' );
	unregister_sidebar( 'secondary' );
	unregister_sidebar( 'before-content' );
	unregister_sidebar( 'after-singular' );
	unregister_sidebar( 'entry' );
	unregister_widget('templatic_slider');
	unregister_widget('supreme_popular_post');
	unregister_widget('templatic_recent_post');
	
}
add_action( 'widgets_init', 'templ_remove_widgetareas', 11 );
// =============================== Header Advertisement ======================================
if(!class_exists('templ_header_ads')){
	class templ_header_ads extends WP_Widget{
		function templ_header_ads() {
			$widget_ops = array('classname' => 'widget header advertisement', 'description' => apply_filters('templ_ads_widget_desc_filter','Show advertisement banners, Google Adsense, Video embed code, etc.') );		
			$this->WP_Widget('widget_header_ads',apply_filters('templ_ads_widget_title_filter','T &rarr; Header Advertisement Widget'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$ads = empty($instance['header_ads']) ? '' : apply_filters('widget_ads', $instance['header_ads']);
			?>						
		<div class="widget advt_widget">
		<?php if ( $title <> "" ) { ?><h3><?php echo sprintf(__('%s','templatic'), $title);?></h3> <?php } ?>
		<?php echo $ads; ?> 
		</div>        
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['header_ads'] = ($new_instance['header_ads']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'header_ads' => '') );		
			$title = strip_tags($instance['title']);
			$ads = ($instance['header_ads']);
	?>
	<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>     
	<p><label for="<?php echo $this->get_field_id('header_ads'); ?>"><?php _e('Advertisement code <small>(ex.&lt;a href="#"&gt;&lt;img src="http://templatic.com/banner.png" /&gt;&lt;/a&gt; and google ads code here )</small>','templatic');?>: <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('header_ads'); ?>" name="<?php echo $this->get_field_name('header_ads'); ?>"><?php echo esc_attr($ads); ?></textarea></label></p>
	<?php
	}}
	register_widget('templ_header_ads');
}

// Portfolio List anything slider  -->  ///////////////////////////////////////////////////

 class templ_slider_portfolio extends WP_Widget {
		function templ_slider_portfolio() {

		//Constructor

		global $thumb_url;

			$widget_ops = array('classname' => 'widget special', 'description' => apply_filters('templ_slider_portfolio_widget_desc_filter',__('Latest Post with slider','templatic')) );
			$this->WP_Widget('templ_slider_portfolio',apply_filters('templ_slider_portfolio_filter',__('T &rarr; Homepage Slider','templatic')), $widget_ops);


		}
		function widget($args, $instance) {

		// prints the widget

		extract($args, EXTR_SKIP);

 		//echo $before_widget;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

			$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$post_per_slide = empty($instance['post_per_slide']) ? '1' : apply_filters('widget_post_per_slide', $instance['post_per_slide']);


			$number = empty($instance['number']) ? '16' : apply_filters('widget_number', $instance['number']);

			$desc = empty($instance['desc']) ? '' : apply_filters('widget_desc', $instance['desc']);

			$post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);

			$height = empty($instance['height']) ? '' : apply_filters('widget_height', $instance['height']);
			
			$autoplay = empty($instance['autoplay']) ? '' : apply_filters('widget_autoplay', $instance['autoplay']);

			$speed = $instance['speed'];

			if($autoplay==''){ $autoplay='false'; }

			if($speed==''){$speed='3000';}

			if($autoplay=='false'){ $speed='300000'; }

?>
<script type="text/javascript"> var autplay = <?php echo $autoplay; ?> </script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/js/jquery.flexslider.js"></script>
<script type="text/javascript">

            var $m = jQuery.noConflict();
			var speed = <?php echo $speed ?>;
			$m(document).load(function() {
			$m.flexslider.defaults = {
			animation: "fade",              //Select your animation type (fade/slide)
			slideshowSpeed: speed,           //Set the speed of the slideshow cycling, in milliseconds
			animationDuration: 600,         //Set the speed of animations, in milliseconds
			directionNav: true,             //Create navigation for previous/next navigation? (true/false)
			controlNav: true,               //Create navigation for paging control of each clide? (true/false)
			keyboardNav: true,              //Allow for keyboard navigation using left/right keys (true/false)
			touchSwipe: true,               //Touch swipe gestures for left/right slide navigation (true/false)
			prevText: "Previous",           //Set the text for the "previous" directionNav item
			nextText: "Next",               //Set the text for the "next" directionNav item
			pausePlay: false,               //Create pause/play dynamic element (true/false)
			randomize: false,               //Randomize slide order on page load? (true/false)
			slideToStart: 0,                //The slide that the slider should start on. Array notation (0 = first slide)
			animationLoop: true,            //Should the animation loop? If false, directionNav will received disabled classes when at either end (true/false)
			pauseOnAction: true,            //Pause the slideshow when interacting with control elements, highly recommended. (true/false)
			pauseOnHover: false,            //Pause the slideshow when hovering over slider, then resume when no longer hovering (true/false)
			controlsContainer: "",          //Advanced property: Can declare which container the navigation elements should be appended too. Default container is the flexSlider element. Example use would be ".flexslider-container", "#container", etc. If the given element is not found, the default action will be taken.
			manualControls: "",             //Advanced property: Can declare custom control navigation. Example would be ".flex-control-nav" or "#tabs-nav", etc. The number of elements in your controlNav should match the number of slides/tabs (obviously).
			start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
			before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
			after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
			end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
		  }
             $m('.flexslider').flexslider();

        });
		
		 //FlexSlider: Default Settings
  
</script>

<div class="flexslider">
  <ul class="slides">
    <?php if($title) { ?>
    <h3><?php echo sprintf(__('%s','templatic'), $title);?></h3>
    <?php } ?>
    <?php if($desc){?>
    <p><?php echo sprintf(__('%s','templatic'), $desc);?></p>
    <?php } ?>
    <?php 
		global $post,$wpdb;
		$arg = "";
		

  global $wpdb,$posts,$post,$query_string,$wp_query;
	//	query_posts($query_string. '&cat='.$categories.'&posts_per_page='.$number );
	//	$posts = get_posts(array('numberposts'=> $number,'category'=>$categories,'order'=>'DESC'));
		$category1 = array();
		$category1 = explode(',',$category);

		if($category)
		{
			$args=
				array( 
				'post_type' => 'post',
				'posts_per_page' => $number,
				'post_status' => array('publish'),
				'tax_query' => array(
					array(
							'taxonomy' => 'category',
							'field' => 'id',
							'terms' => $category1,
							'operator'  => 'IN'
						)
						
					 ),
				'order'=>'DESC'
				);
		}
		else
		{
			$args=
				array( 
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'post_status' => array('publish'),
				'order'=>'DESC'
				);	
		}
		$today_special = new WP_Query($args);
		if($today_special)
		{	
				   $counter=0;

				   $postperslide = $post_per_slide;		   



		  while($today_special->have_posts()): $today_special->the_post();
			setup_postdata($post);
		
		$post_images =  bdw_get_images_with_info($post->ID,'slider-thumb'); 

		if($counter=='0' || $counter%$postperslide==0){ echo "<li>";}?>

    <div class="post_list">
      <?php
			
				$attachment_id = $post_images[0]['id'];
				$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
				$attach_data = get_post($attachment_id);
				$title = $attach_data->post_title;
				if($title ==''){ $title = $post->post_title; }
				if($alt ==''){ $alt = $post->post_title; }
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider-thumb' );
				if(isset($image[0]) && $image[0]!='')
					 $post_images_crp = $image[0];
				elseif($post_images[0]['file']){
				$post_images_crp = $post_images[0]['file'];
				}else{
				$post_images_crp = get_stylesheet_directory_uri()."/images/img_not_available.jpg";
				}
	  ?>   
      <div class="post_img"> <a data-rel="gallery" href="<?php the_permalink(); ?>"> <img  src="<?php echo $post_images_crp;?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" /> </a> </div>
	  <div class="slider_post_content">
     <?php 
	 $category = get_the_category($post->ID);
	 if($category[0]->cat_name != 'Uncategorized') { ?>
      <div class="categoryName">
	  <?php  $category_link = get_category_link($category[0]->term_id); ?>
	  <a href="<?php  echo $category_link; ?>">
		<span class="cat-flag">
			<span><?php  echo $category[0]->cat_name; ?></span>
			<span class="post_count"><?php echo wt_get_category_count(); ?></span>
		</span>
		</a>
	  </div><?php } ?>
	
      <h4><a class="widget-title" href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h4>
    </div>
	 </div>
	<?php
		$counter++; 
		if($counter%$postperslide==0){ echo "</li>"; }
	endwhile; } ?>
  </ul>
	</div>
	<?php }
	function update($new_instance, $old_instance) {

		//save the widget

			$instance = $old_instance;

			$instance['title'] = strip_tags($new_instance['title']);

			$instance['desc'] = strip_tags($new_instance['desc']);

			$instance['speed'] = strip_tags($new_instance['speed']);

			$instance['autoplay'] = strip_tags($new_instance['autoplay']);

			$instance['post_per_slide'] = strip_tags($new_instance['post_per_slide']);

			$instance['category'] = strip_tags($new_instance['category']);

			$instance['number'] = strip_tags($new_instance['number']);

			$instance['post_type'] = strip_tags($new_instance['post_type']);

			return $instance;

		}
		function form($instance) {

		//widgetform in backend

			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );

			$title = strip_tags($instance['title']);

			$desc = strip_tags($instance['desc']);

			$category = strip_tags($instance['category']);

			$autoplay = strip_tags($instance['autoplay']);

			$post_per_slide = strip_tags($instance['post_per_slide']);

			$number = strip_tags($instance['number']);

			$speed = strip_tags($instance['speed']);

			$post_type = strip_tags($instance['post_type']);

	?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Title:','templatic');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc'); ?>">
    <?php _e('Category Short Description :','templatic');?>
    <input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo esc_attr($desc); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>">
    <?php _e('Number of posts:','templatic');?>
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">
    <?php _e('Categories (<code>IDs</code> separated by commas):','templatic');?>

    <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_per_slide'); ?>"><?php _e('Post Per Slide','templatic'); ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('post_per_slide'); ?>" name="<?php echo $this->get_field_name('post_per_slide'); ?>" type="text" value="<?php echo esc_attr($post_per_slide); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play','templatic'); ?>:
    <select class="widefat" name="<?php echo $this->get_field_name('autoplay'); ?>" id="<?php echo $this->get_field_id('autoplay'); ?>">
      <option <?php if(esc_attr($autoplay)=='true'){?> selected="selected"<?php }?> value="true">Yes</option>
      <option <?php if(esc_attr($autoplay)=='false'){?> selected="selected"<?php }?> value="false">No</option>
    </select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Sliding Speed','templatic'); ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" type="text" value="<?php echo esc_attr($speed); ?>" />
  </label>
</p>
<?php
		}
	}
	register_widget('templ_slider_portfolio');
// =============================== News Flash Widget ======================================
	class news_flash extends WP_Widget {
		function news_flash() {
		//Constructor
			$widget_ops = array('classname' => 'news_flash', 'description' => 'News Flash, Latest Posts Widget');
			$this->WP_Widget('news_flash', 'T &rarr; News Flash, Latest Posts Widget', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$categories = empty($instance['categories']) ? '' : apply_filters('widget_number', $instance['categories']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$morenewslink = empty($instance['morenewslink']) ? '5' : apply_filters('widget_morenewslink', $instance['morenewslink']);
			?>
		<div class="widget newsflash">
        <?php if($title){?> <h3 class="widget-title"><?php echo sprintf(__('%s','templatic'), $title);?></h3><?php } ?>

        <?php
        global $wpdb,$posts,$post,$query_string,$wp_query;
	//	query_posts($query_string. '&cat='.$categories.'&posts_per_page='.$number );
	//	$posts = get_posts(array('numberposts'=> $number,'category'=>$categories,'order'=>'DESC'));
		if($categories)
		{
			$args=
				array( 
				'post_type' => 'post',
				'posts_per_page' => $number,
				'post_status' => array('publish'),
				'tax_query' => array(
					array(
							'taxonomy' => 'category',
							'field' => 'id',
							'terms' => array($categories),
							'operator'  => 'IN'
						)
						
					 ),
				'order'=>'DESC'
				);
		}
		else
		{
			$args=
				array( 
				'post_type' => 'post',
				'posts_per_page' => $number,
				'post_status' => array('publish'),
				'order'=>'DESC'
				);	
		}
		$news_falsh = new WP_Query($args);
        if ( $news_falsh ) : ?>
            <?php
                $pcount=0;
			?>
            <div class="widget_inner_wrap">
                <ul class="newsleft">
            <?php
               while($news_falsh->have_posts()): $news_falsh->the_post();
							setup_postdata($post);
                $pcount++;
            ?>
          <li id="post_<?php the_ID(); ?>">
          		<div <?php if($pcount == 1) { ?> class="firstpost" <?php } ?>>
						<?php if($pcount <= 2) { ?>
                        <div class="postimageview">
                         <?php $post_images =  bdw_get_images_with_info($post->ID,'image-thumb');   
							$attachment_id = $post_images[0]['id'];
							$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
							$attach_data = get_post($attachment_id);
							$title = $attach_data->post_title;
							if($title ==''){ $title = $post->post_title; }
							if($alt ==''){ $alt = $post->post_title; }
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'image-thumb' );
							if(isset($image[0]) && $image[0]!='')
								 $post_images = $image[0];
							elseif($post_images[0]['file'])
							{
								$post_images = $post_images[0]['file'];
							}
							if($post_images == ''){
							$post_images = get_stylesheet_directory_uri()."/images/img_not_available.png";
							}
							?>
                          <a href="<?php the_permalink(); ?>"> <img class="alignleft" src="<?php echo $post_images; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a>
                        </div>
                    	<?php } ?>
						
                            <?php if($pcount <= 2) { ?>
                            <div class="postcontentview">
                               <?php
                                  $type = 'post';
                                  $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
                                  $fv = human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago','templatic');
                               ?>
                               <div class="byline"><abbr title="" class="published"><?php echo $fv; ?></abbr></div>
							   <h2 ><a href="<?php the_permalink() ?>"> <?php the_title(); ?> </a></h2>
                            </div>
                            <?php } ?>
                            <?php if($pcount > 2) { ?> <h2 ><a href="<?php the_permalink() ?>"><i class="fa fa-caret-right"></i> <?php the_title(); ?> </a></h2> <?php } ?>
						
                            <?php if($pcount >= $number) { ?><a class="morenews" href="<?php echo $morenewslink; ?>"><?php _e('More News','templatic'); ?><i class="fa fa-arrow-right"></i></a><?php } ?>

                        <div style="clear:both;"></div>
                </div>
          </li>
			<?php if($pcount == 2) { ?>
                </ul><!-- News Left Over -->
                <ul class="newsright">
            <?php } ?>

          <?php endwhile; ?>
          
                </ul><!-- News Right Over -->
                <div style="clear:both;"></div>
            </div>

        <?php endif; ?>
        </div>

		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = ($new_instance['number']);
			$instance['categories'] = ($new_instance['categories']);
			$instance['morenewslink'] = ($new_instance['morenewslink']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = strip_tags($instance['title']);
			$number = ($instance['number']);
			$categories = ($instance['categories']);
			$morenewslink = ($instance['morenewslink']);
		?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic'); ?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories id (comma seperated)','templatic'); ?>: <input class="widefat" id="<?php  echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo esc_attr($categories); ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Total Number of Posts','templatic'); ?> <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
        
		<p><label for="<?php echo $this->get_field_id('morenewslink'); ?>"><?php _e('More News Link','templatic'); ?> <input class="widefat" id="<?php echo $this->get_field_id('morenewslink'); ?>" name="<?php echo $this->get_field_name('morenewslink'); ?>" type="text" value="<?php echo esc_attr($morenewslink); ?>" /></label></p>

		<?php
	}}
	register_widget('news_flash');
	// =============================== Advanced Latest Posts Widget ======================================
	class advanced_latest_posts extends WP_Widget {
		function advanced_latest_posts() {
		//Constructor
			$widget_ops = array('classname' => 'advanced_latest_posts', 'description' => 'Advanced Latest Posts Widget');
			$this->WP_Widget('advanced_latest_posts', 'T &rarr; Advanced Latest Posts Widget', $widget_ops);
		}

		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			
			global $displaytype;
			if($displaytype == ''){ 
			$displaytype = empty($instance['displaytype']) ? 'grid' : apply_filters('widget_displaytype', $instance['displaytype']); 
			}
			$paginationtype = empty($instance['paginationtype']) ? 'default' : apply_filters('widget_paginationtype', $instance['paginationtype']);
			
		?>

<div class="content-title advancedlatestpost"> <h1><?php if($title) { echo sprintf(__('%s','templatic'), $title); } else { _e('Latest entries','templatic'); } ?></h1> 
			  	<div class="viewsbox">
							<div class="listview"><a class="<?php if ($displaytype == 'list') { echo "active"; }   ?>"><i class="fa fa-th-list"></i><?php _e('List View','templatic'); ?></a></div>
							<div class="gridview"><a class="<?php if ($displaytype == 'grid') { echo "active"; }   ?>"><i class="fa fa-th"></i><?php _e('Grid View','templatic'); ?></a></div>
					</div>
     <div style="clear:both;"></div>
</div>

		<?php $limitword = get_option('ptthemes_content_excerpt_count');  ?>
        <div id="latestpostloop" class="<?php if ($displaytype == 'grid') {  echo 'grid'; } else{ echo 'list clear'; } ?>">
        	<?php if ($paginationtype != 'ajax') 
			{ ?>
			
				 <?php
				  global $wp_query,$wp_query,$post;
				// query_posts($query_string.'&posts_per_page='.$number.'&supress_filter='.true);
				if(isset($_REQUEST['paged']))
				{
					$paged = $_REQUEST['paged'];
				}
				else
				{
					$paged = get_url_var('page');
				}
					$args=
						array( 
						'post_type' => 'post',
						'posts_per_page' => $number,
						'paged'=>$paged,
						'post_status' => array('publish'),
						'order'=>'DESC'
						);	
				
				$latest_post = new WP_Query($args);
				 $pcount =0;
                 if ( $latest_post ) : ?>
                    <?php global $post;
					$pc =0;
                        while ( $latest_post->have_posts() ) : $latest_post->the_post();
						setup_postdata($post);
						 $attachment_id ='';
						 $pcount++;
                         $post_images =  bdw_get_images_with_info($post->ID,'image-thumb');   
                                    $attachment_id = $post_images[0]['id'];
                                    $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                                    $attach_data = get_post($attachment_id);
                                    $title = $attach_data->post_title;
                                    if($title ==''){ $title = $post->post_title; }
                                    if($alt ==''){ $alt = $post->post_title; }
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'image-thumb' );
									if(isset($image[0]) && $image[0]!='')
										 $post_images = $image[0];
									elseif($post_images[0]['file']){
                                    $post_images = $post_images[0]['file'];
                                    }else{
                                    $post_images = get_stylesheet_directory_uri()."/images/img_not_available.png";
                                    }
									
                    ?>
					<div class="post_list">
                        <div class="postimageview">
                          <a href="<?php the_permalink(); ?>"> <img class="Thumbnail thumbnail event-home-thumb img" src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a>
                          <?php
                          $category = get_the_category($post->ID);
                          $category_link = get_category_link($category[0]->cat_ID );
                          if($category[0]->cat_name != 'Uncategorized' && get_post_type($post->ID) != 'page') {
                          ?>
                              <div class="categoryName">
                                <div class="cat-flag"><a href="<?php echo $category_link; ?>"><span><?php echo $category[0]->cat_name; ?></span><span class="post_count"><?php echo wt_get_category_count(); ?></span></a></div>
                              </div>
                          <?php } ?>
                        </div>
                        <div class="postcontentview">
                            <div class="byline">
								
                               <?php
                                  $type = 'post';
                                  $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
                                  $fv = human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago','templatic');
                               ?>
                               <abbr class="published"><i class="fa fa-clock-o"></i><?php echo $fv; ?></abbr>
							   <span class="author vcard"><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="url fn n" title="Posts by <?php the_author(); ?>"><?php the_author(); ?></a></span>
							  <?php comments_popup_link(__('No Comments','templatic'), __('<i class="fa fa-comment"></i> 1','templatic'), __(' <i class="fa fa-comment"></i> % ','templatic'), '', __('Comments Closed','templatic')); ?>
							
                            </div>
                            <h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                            <div class="post-content">
                              <?php  
                               /* $limitword = get_option('ptthemes_content_excerpt_count'); 
								echo string_limit_words(get_the_excerpt($post->ID),$limitword);*/
								the_excerpt();if(technews_hybrid_get_setting('content_excerpt_readmore')) { echo read_more_link(); }
                              ?>
                            </div>
                        </div>
                  </div>
					<?php	if($pcount%3 ==0){
							if (function_exists('dynamic_sidebar')){
							$posthtml .= dynamic_sidebar('front_content_advt'); }
							} ?>
                  <?php endwhile;wp_reset_query(); ?>
                 <?php endif; ?>
				
                <?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

        	<?php } ?>
        </div>
        <?php if (strtolower($paginationtype) == 'ajax') { 
		global $wpdb,$post,$query_string,$wp_query;
				$args=
					array( 
					'post_type' => 'post',
					'posts_per_page' =>-1,
					'post_status' => array('publish'),
					'order'=>'DESC'
				);	
						
			$latest_post1 = new WP_Query($args);
				?>
                <?php if(is_plugin_active('wpml-translation-management/plugin.php')){
					global $sitepress;
					$current_lang_code= ICL_LANGUAGE_CODE;
					$language=$current_lang_code;
				}?>
			<input type='hidden' id='post_count_ajax' name="post_count_ajax" value="<?php echo $number; ?>"/>
            <input type='hidden' id='total_post' name="total_post" value="<?php echo count($latest_post1->posts); ?>"/>
			<?php if(count($latest_post1->posts) >= $number) {  ?>
            <div id="pagination"><a class="loadmore" rel="<?php echo $number; ?>" style="cursor:pointer;"><?php echo __('Load More Articles','templatic'); ?></a></div>
		<?php } ?>
			<script type="text/javascript">
				jQuery('#pagination a').click(function(){				
					var nu = jQuery(this).attr('rel');
						var nu = parseInt(nu) + parseInt(jQuery('#post_count_ajax').val());
						jQuery(this).attr('rel',nu);
						jQuery('#latestpostloop').load('<?php echo get_stylesheet_directory_uri(); ?>/functions/loadpost.php', { "limitarr[]": [<?php echo '100'; ?>, nu,'<?php echo $language; ?>'] }, function(){});
				
						setTimeout(function(){
							var pc = parseInt(jQuery('#postcount').attr('rel'));
							var total_post = parseInt(jQuery('#total_post').val());
							//var pl = parseInt(jQuery('#pagination a.loadmore').attr('rel'));			
							if(pc >= total_post){ jQuery('#pagination').css('display','none'); }
						},800);
				});
				
                jQuery('#latestpostloop').load('<?php echo get_stylesheet_directory_uri(); ?>/functions/loadpost.php', { "limitarr[]": [<?php echo $limitword; ?>, <?php echo $number; ?>, '<?php echo $language; ?>'] }, function(){});
            </script>
		<?php
			}
		}

		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = ($new_instance['number']);
			$instance['categories'] = ($new_instance['categories']);
			$instance['displaytype'] = ($new_instance['displaytype']);
			$instance['paginationtype'] = ($new_instance['paginationtype']);
			return $instance;
		}

		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = strip_tags($instance['title']);
			$number = ($instance['number']);
			$categories = ($instance['categories']);
			$displaytype1 = ($instance['displaytype']);
			$paginationtype = ($instance['paginationtype']);
		?>

        <p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

		<p><label for="<?php  echo $this->get_field_id('number'); ?>"><?php _e('Total Number of Posts','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
		
   		<p><label for="<?php  echo $this->get_field_id('displaytype'); ?>"><?php _e('View Type','templatic');?><select class="widefat" id="<?php  echo $this->get_field_id('displaytype'); ?>" name="<?php echo $this->get_field_name('displaytype'); ?>" value="<?php echo esc_attr($instance['displaytype']); ?>"><option value="list" <?php if($displaytype1 == 'List') { ?>selected=selected <?php } ?>>List</option><option value="grid" <?php if($displaytype1 == 'grid') { ?>selected=selected <?php } ?>>Grid</option></select></label></p>

   		<p><label for="<?php  echo $this->get_field_id('paginationtype'); ?>"><?php _e('Pagination Type','templatic');?><select class="widefat" id="<?php  echo $this->get_field_id('paginationtype'); ?>" name="<?php echo $this->get_field_name('paginationtype'); ?>" value="<?php echo esc_attr($instance['paginationtype']); ?>"><option value="ajax" <?php if($paginationtype == 'ajax') { ?>selected=selected <?php } ?>>AJAX</option><option value="default" <?php if($paginationtype == 'default') { ?>selected=selected <?php } ?>>Default</option></select></label></p>

		<?php
	}}
	register_widget('advanced_latest_posts');
	
	// =============================== Advertisement ======================================
if(!class_exists('templ_ads')){
	class templ_ads extends WP_Widget {
		function templ_ads() {
		//Constructor
			$widget_ops = array('classname' => 'widget advertisement', 'description' => apply_filters('templ_ads_widget_desc_filter','Show advertisement banners, Google Adsense, Video embed code, etc.') );		
			$this->WP_Widget('widget_ads',apply_filters('templ_ads_widget_title_filter','T &rarr; Advertisement Widget'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$ads = empty($instance['ads']) ? '' : apply_filters('widget_ads', $instance['ads']);
			?>						
		<div class="widget advt_widget">
			<?php if ( $title <> "" ) { ?><h3><?php echo sprintf(__('%s','templatic'), $title);?></h3> <?php } ?>
			<?php echo $ads; ?> 
		</div>
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['ads'] = ($new_instance['ads']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'ads' => '') );		
			$title = strip_tags($instance['title']);
			$ads = ($instance['ads']);
	?>
	<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>     
	<p><label for="<?php echo $this->get_field_id('ads'); ?>"><?php _e('Advertisement code <small>(ex.&lt;a href="#"&gt;&lt;img src="http://templatic.com/banner.png" /&gt;&lt;/a&gt; and google ads code here )</small>','templatic');?>: <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('ads'); ?>" name="<?php echo $this->get_field_name('ads'); ?>"><?php echo esc_attr($ads); ?></textarea></label></p>
	<?php
	}}
	register_widget('templ_ads');
}
// =============================== Sidebar Advertisement ======================================
if(!class_exists('templ_sidebar_ads')){
	class templ_sidebar_ads extends WP_Widget{
		function templ_sidebar_ads() {
			$widget_ops = array('classname' => 'widget sidebar advertisement', 'description' => apply_filters('templ_ads_widget_desc_filter','Show advertisement banners, Google Adsense, Video embed code, etc.') );		
			$this->WP_Widget('widget_sidebar_ads',apply_filters('templ_ads_widget_title_filter','T &rarr; Sidebar Advertisement Widget'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$ads1 = empty($instance['sidebar_ads1']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads1']);
			$ads2 = empty($instance['sidebar_ads2']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads2']);
			$ads3 = empty($instance['sidebar_ads3']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads3']);
			$ads4 = empty($instance['sidebar_ads4']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads4']);
			$ads5 = empty($instance['sidebar_ads5']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads5']);
			$ads6 = empty($instance['sidebar_ads6']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads6']);
			$ads7 = empty($instance['sidebar_ads7']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads7']);
			$ads8 = empty($instance['sidebar_ads8']) ? '' : apply_filters('widget_ads', $instance['sidebar_ads8']);
		?>
		<div class="widget advt_widget">
           	<?php $c = 0; ?>
			<?php //if ( $title <> "" ) { ?> <!--<h3><?php //_e($title,'templatic');?></h3>--> <?php //} ?>
            <ul>
                	<?php if ( $ads1 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads1; ?></li><?php } ?>
                	<?php if ( $ads2 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads2; ?></li><?php } ?>
                	<?php if ( $ads3 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads3; ?></li><?php } ?>
                	<?php if ( $ads4 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads4; ?></li><?php } ?>
                	<?php if ( $ads5 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads5; ?></li><?php } ?>
                	<?php if ( $ads6 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads6; ?></li><?php } ?>
                	<?php if ( $ads7 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads7; ?></li><?php } ?>
                	<?php if ( $ads8 <> "" ) { ?><li <?php if (++$c % 2) { echo 'class="odd"'; } else { echo 'class="even"'; } ?>><?php echo $ads8; ?></li><?php } ?>
                </ul>
		<div style="clear:both;"></div>
		</div>
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['sidebar_ads1'] = ($new_instance['sidebar_ads1']);
			$instance['sidebar_ads2'] = ($new_instance['sidebar_ads2']);
			$instance['sidebar_ads3'] = ($new_instance['sidebar_ads3']);
			$instance['sidebar_ads4'] = ($new_instance['sidebar_ads4']);
			$instance['sidebar_ads5'] = ($new_instance['sidebar_ads5']);
			$instance['sidebar_ads6'] = ($new_instance['sidebar_ads6']);
			$instance['sidebar_ads7'] = ($new_instance['sidebar_ads7']);
			$instance['sidebar_ads8'] = ($new_instance['sidebar_ads8']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'sidebar_ads1' => '', 'sidebar_ads2' => '', 'sidebar_ads3' => '', 'sidebar_ads4' => '' ) );
			$title = strip_tags($instance['title']);
			$ads1 = ($instance['sidebar_ads1']);
			$ads2 = ($instance['sidebar_ads2']);
			$ads3 = ($instance['sidebar_ads3']);
			$ads4 = ($instance['sidebar_ads4']);
			$ads5 = ($instance['sidebar_ads5']);
			$ads6 = ($instance['sidebar_ads6']);
			$ads7 = ($instance['sidebar_ads7']);
			$ads8 = ($instance['sidebar_ads8']);
	?>

<p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

<p><label for="<?php echo $this->get_field_id('ads1'); ?>"><?php _e('Advertisement code <small>(ex.&lt;a href="#"&gt;&lt;img src="http://templatic.com/banner.png" /&gt;&lt;/a&gt; and google ads code here )</small>','templatic');?>:<p>

<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads1'); ?>" name="<?php echo $this->get_field_name('sidebar_ads1'); ?>"><?php echo esc_attr($ads1); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads2'); ?>" name="<?php echo $this->get_field_name('sidebar_ads2'); ?>"><?php echo esc_attr($ads2); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads3'); ?>" name="<?php echo $this->get_field_name('sidebar_ads3'); ?>"><?php echo esc_attr($ads3); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads4'); ?>" name="<?php echo $this->get_field_name('sidebar_ads4'); ?>"><?php echo esc_attr($ads4); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads5'); ?>" name="<?php echo $this->get_field_name('sidebar_ads5'); ?>"><?php echo esc_attr($ads5); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads6'); ?>" name="<?php echo $this->get_field_name('sidebar_ads6'); ?>"><?php echo esc_attr($ads6); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads7'); ?>" name="<?php echo $this->get_field_name('sidebar_ads7'); ?>"><?php echo esc_attr($ads7); ?></textarea></label></p>
<p><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('sidebar_ads8'); ?>" name="<?php echo $this->get_field_name('sidebar_ads8'); ?>"><?php echo esc_attr($ads8); ?></textarea></label></p>

	<?php
	}}
	register_widget('templ_sidebar_ads');
	}
	

// ===============================  Latest Posts - widget ======================================
if(!class_exists('templ_latest_posts_with_images')){
	class templ_latest_posts_with_images extends WP_Widget {
	
		function templ_latest_posts_with_images() {
		//Constructor
		global $thumb_url;
			$widget_ops = array('classname' => 'widget special', 'description' => apply_filters('templ_latestpost_with_img_widget_desc_filter',__('Post with image and date','templatic')) );
			$this->WP_Widget('latest_posts_with_images',apply_filters('templ_latestpost_with_img_widget_title_filter',__('T &rarr; Post with image and date','templatic')), $widget_ops);
		}
	 
		function widget($args, $instance) {
		// prints the widget
	
			extract($args, EXTR_SKIP);
	 
			echo $before_widget;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);

			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);
			 ?>
			
		 <?php if($title){?> <h3 class="i_publication"><?php echo sprintf(__('%s','templatic'), $title);?></h3> <?php }?>
					<ul class="latest_posts"> 
			 <?php 
					global $post;
					
					if($category)
					{
						$arg = "cat=>$category";	
					}
					global $wpdb,$posts,$post,$query_string,$wp_query;
					//	query_posts($query_string. '&cat='.$categories.'&posts_per_page='.$number );
					//	$posts = get_posts(array('numberposts'=> $number,'category'=>$categories,'order'=>'DESC'));
						if($category)
						{
							$args=
								array( 
								'post_type' => 'post',
								'posts_per_page' => $number,
								'post_status' => array('publish'),
								'tax_query' => array(
									array(
											'taxonomy' => 'category',
											'field' => 'id',
											'terms' => array($category),
											'operator'  => 'IN'
										)
										
									 ),
								'order'=>'DESC'
								);
						}
						else
						{
							$args=
								array( 
								'post_type' => 'post',
								'posts_per_page' => $number,
								'post_status' => array('publish'),
								'order'=>'DESC'
								);	
						}
						$post_with_image = new WP_Query($args);
					//$today_special = get_posts(array('numberposts'=>$number,'category'=>$category));
					if($post_with_image)
					{
						while ( $post_with_image->have_posts() ) : $post_with_image->the_post();
						setup_postdata($post);
						$post_images =  bdw_get_images_with_info($post->ID,'image-thumb');   
						$attachment_id = $post_images[0]['id'];
						$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
						$attach_data = get_post($attachment_id);
						$title = $attach_data->post_title;
						if($title ==''){ $title = $post->post_title; }
						if($alt ==''){ $alt = $post->post_title; }
	
						 ?>
				<li>
			 
					 
					 <?php get_the_image(array('image_class'=>'post_img','meta_key' => array('tiny-thumb', 'tiny-thumb'),'height'=> 50,'width'=> 50 ,'default_image'=>get_stylesheet_directory_uri()."/images/img_not_available.png")); ?>
				
							
					<h4> <a class="widget-title" href="<?php the_permalink(); ?>">
						  <?php the_title(); ?>
						  <?php
								$type = 'post';
								$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
								$fv = human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago','templatic');
							?>
						  </a> <br />  <span class="post_author"><?php _e('by','templatic');?> <?php the_author_posts_link(); ?> <?php _e('at','templatic');?> <?php echo $fv; ?>  <?php comments_popup_link(__('No Comments','templatic'), __('<i class="fa fa-comment"></i> 1','templatic'), __(' <i class="fa fa-comment"></i> % ','templatic'), '', __('Comments Closed','templatic')); ?> </span></h4> 
						  
						  <p> <?php the_excerpt(); ?> <a class="read_more" href="<?php the_permalink(); ?>"> <?php _e('more...','templatic');?> </a></p> 
				</li>
		<?php endwhile;
				}
			?>
				</ul>
		
	<?php
			echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['post_type'] = strip_tags($new_instance['post_type']);
			return $instance;
		}
	 
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
			$title = strip_tags($instance['title']);
			$category = strip_tags($instance['category']);
			$number = strip_tags($instance['number']);
			$post_type = strip_tags($instance['post_type']);
	?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	
	<p>
	  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
	  </label>
	</p>
    <p>
<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:','templatic')?>
<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
<?php
$custom_post_types_args = array();  
$custom_post_types = get_post_types($custom_post_types_args,'objects');   
foreach ($custom_post_types as $content_type) {
if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page'){
?>
<option value="<?php echo sprintf(__('%s','templatic'), $content_type->name);?>" <?php if(esc_attr($post_type)==$content_type->name){ echo 'selected="selected"';}?>><?php echo sprintf(__('%s','templatic'), $content_type->label);?></option>
<?php }}?>
</select>
</label>
</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas):','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
	  </label>
	</p>
	<?php
		}
	}
	register_widget('templ_latest_posts_with_images');
}
// =============================== Related listing Widget ======================================
	class related_listing_widget extends WP_Widget {
		function related_listing_widget() {
		//Constructor
			$widget_ops = array('classname' => 'related_listing_widget', 'description' => 'Related listing- this widget is for detail page it will show below the content.');
			$this->WP_Widget('related_listing_widget', 'T &rarr; Related listing - Detail page', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$morenewslink = empty($instance['morenewslink']) ? '5' : apply_filters('widget_morenewslink', $instance['morenewslink']);
			?>

		<div class="widget related_listing">       
			<?php 
			global $post;
			get_related_posts($post,$number,$title); ?> 
		</div>
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = ($new_instance['number']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = strip_tags($instance['title']);
			$number = ($instance['number']);
		?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic'); ?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Total Number of Posts','templatic'); ?> <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>
		<?php
	}}
	register_widget('related_listing_widget');

// =============================== Advanced Popular Posts Widget ======================================
	class advanced_popularposts extends WP_Widget {
		function advanced_popularposts() {
		//Constructor
			$widget_ops = array('classname' => 'advanced_popularposts', 'description' => 'Advanced Popular Posts Widget');
			$this->WP_Widget('advanced_popularposts', 'T &rarr; Advanced Popular Posts Widget', $widget_ops);
		}
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$slide = empty($instance['slide']) ? '5' : apply_filters('widget_slide', $instance['slide']);
			$popular_per = empty($instance['popular_per']) ? 'comments' : apply_filters('widget_popular_per', $instance['popular_per']);
			?>
        <div class="widget popularpost">
        <?php if($title){?> <h3><?php echo sprintf(__('%s','templatic'), $title); ?></h3><?php } ?>

        <?php
			global $wpdb,$posts,$post,$query_string,$wp_query;

			$now = gmdate("Y-m-d H:i:s",time());
			$lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
			if($popular_per == apply_filters('widget_popular_per',$popular_per)){
	        $args_popular=array(
					'post_type'=>'post',
					'post_status'=>'publish',
					'posts_per_page' => $number,
					'meta_key'=>'viewed_count',
					'orderby' => 'meta_value_num',
					'meta_value_num'=>'viewed_count',
					'order' => 'DESC'
					);
			}elseif($popular_per == 'dailyviews'){
			 $args_popular=array(
					'post_type'=>'post',
					'post_status'=>'publish',
					'posts_per_page' => $number,
					'meta_key'=>'viewed_count_daily',
					'orderby' => 'meta_value_num',
					'meta_value_num'=>'viewed_count_daily',
					'order' => 'DESC'
					);
			}else{
			$args_popular=array(
					'post_type'=>'post',
					'post_status'=>'publish',
					'posts_per_page' => $number,				
					'orderby' => 'comment_count',					
					'order' => 'DESC'
					);
			 }
			
			//$totalpost = $wpdb->get_results($popularposts);
			$popular_post_query = new WP_Query($args_popular);
			$countpost = count($popular_post_query->posts);
			$dot = ceil($countpost / $slide);
			
		?>
 <?php if(is_plugin_active('wpml-translation-management/plugin.php')){
					global $sitepress;
					$current_lang_code= ICL_LANGUAGE_CODE;
					$language=$current_lang_code;
				}?>
            <div class="postpagination">
            	<?php if($dot != 1) { ?>
                    <a rel="0" rev="<?php echo $slide; ?>" class="active">&nbsp;</a>
                    <?php
                        for($c = 1; $c < $dot; $c++) {
                            $start = ($c * $slide);
                            echo '<a num="'.($c+1).'" rel="'.$start.'" rev="'.$slide.'">&nbsp;</a>';
                        }
                    ?>
                    <div style="clear:both;"></div>
            	<?php } ?>
            </div>
				<div class="widget-wrap widget-inside">
					<ul class="list" id="list"> </ul>
				</div>
			<script type="text/javascript">
				jQuery('.postpagination a').click(function(){
				var start =  parseInt(jQuery(this).attr('rel'));
				var end =  parseInt(jQuery(this).attr('rev'));
				var num =parseInt(jQuery(this).attr('num'));
				jQuery('.postpagination a').attr('class','');
				jQuery(this).attr('class','active');		
				jQuery('#list').load('<?php echo get_stylesheet_directory_uri(); ?>/functions/loadpopularpost.php', { "limitarr[]": [start, end,'<?php echo $language; ?>',num] }, function(){});
		});
				jQuery('#list').load('<?php echo get_stylesheet_directory_uri(); ?>/functions/loadpopularpost.php', { "limitarr[]": [0, <?php echo $slide; ?>,'<?php echo $language; ?>',1,<?php echo $number; ?>] }, function(){});
            </script>
        </div>

		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = ($new_instance['number']);
			$instance['slide'] = ($new_instance['slide']);
			$instance['popular_per'] = ($new_instance['popular_per']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = strip_tags($instance['title']);
			$number = ($instance['number']);
			$slide = ($instance['slide']);
			$popular_per = ($instance['popular_per']);
		?>

        <p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

		<p><label for="<?php  echo $this->get_field_id('number'); ?>"><?php _e('Total Number of Posts','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" /></label></p>

   		<p><label for="<?php  echo $this->get_field_id('slide'); ?>"><?php _e('Number of Posts Per Slide','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('slide'); ?>" name="<?php echo $this->get_field_name('slide'); ?>" type="text" value="<?php echo esc_attr($slide); ?>" /></label></p>
		
		<p><label for="<?php  echo $this->get_field_id('popular_per'); ?>"><?php _e('Shows post as per view counting/comments','templatic');?> <select class="widefat" id="<?php  echo $this->get_field_id('popular_per'); ?>" name="<?php echo $this->get_field_name('popular_per'); ?>">
		<option value="views" <?php if($popular_per == 'views') { ?>selected='selected'<?php } ?>><?php _e('Total views','templatic'); ?></option>
		<option value="dailyviews" <?php if($popular_per == 'dailyviews') { ?>selected='selected'<?php } ?>><?php _e('Daily views','templatic'); ?></option>
		<option value="comments" <?php if($popular_per == 'comments') { ?>selected='selected'<?php } ?>><?php _e('Total comments','templatic'); ?></option>
		</select></label></p>

		<?php
	}}
	register_widget('advanced_popularposts');



?>
<?php
// =============================== Login Widget ======================================
if(!class_exists('contact_widget')){
class contact_widget extends WP_Widget {
	function contact_widget() {
	//Constructor
		$widget_ops = array('classname' => 'Contact Us', 'description' => apply_filters('templ_contact_widget_desc_filter',__('A simple contact form where site visitors can send you a message with their name and email address.','templatic')) );		
		$this->WP_Widget('widget_contact', apply_filters('templ_contact_widget_title_filter',__('T &rarr; Contact us','templatic')), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
    <div class="widget contact_widget" id="contact_widget">
    <?php if($title){?> <h3><?php echo sprintf(__('%s','templatic'), $title);?></h3><?php }?>
            
       		<?php
	if($_POST && $_POST['contact_widget'])
	{
	if($_POST['your-email'])
	{
		$toEmailName = get_option('blogname');
		$toEmail = get_bloginfo('admin_email');
		
		$subject = $_POST['your-subject'];
		$message = '';
		$message .= '<p>Dear '.$toEmailName.',</p>';
		$message .= '<p>Name : '.$_POST['your-name'].',</p>';
		$message .= '<p>Email : '.$_POST['your-email'].',</p>';
		$message .= '<p>Message : '.nl2br($_POST['your-message']).'</p>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
		$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
		$headers .= 'From: '.$_POST['your-name'].' <'.$_POST['your-email'].'>' . "\r\n";
		
		// Mail it
		templ_sendEmail($_POST['your-email'],$_POST['your-name'],$toEmail,$toEmailName,$subject,$message);
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&msg=success'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?msg=success'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."#contact_widget';</script>";
		
	}else
	{
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&err=empty'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?err=empty'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."#contact_widget';</script>";	
	}
	}
	?>
	<?php
	if($_REQUEST['msg'] == 'success')
	{
	?>
		<p class="success_msg"><?php echo apply_filters('templ_contact_widget_successmsg_filter',__('Thank you, your information is sent successfully.','templatic'));?></p>
	<?php
	}elseif($_REQUEST['err'] == 'empty')
	{
	?>
		<p class="error_msg"><?php echo apply_filters('templ_contact_widget_errormsg_filter',__('Please fill out all the fields before submitting.','templatic'));?></p>
	<?php
	}
	?>
	<script type="text/javascript">
	  var $cwidget = jQuery.noConflict();
	$cwidget(document).ready(function(){

		//global vars
		var contact_widget_frm = $cwidget("#contact_widget_frm");
		var your_name = $cwidget("#widget_your-name");
		var your_email = $cwidget("#widget_your-email");
		var your_subject = $cwidget("#widget_your-subject");
		var your_message = $cwidget("#widget_your-message");
		
		var your_name_Info = $cwidget("#widget_your_name_Info");
		var your_emailInfo = $cwidget("#widget_your_emailInfo");
		var your_subjectInfo = $cwidget("#widget_your_subjectInfo");
		var your_messageInfo = $cwidget("#widget_your_messageInfo");
		
		//On blur
		your_name.blur(validate_widget_your_name);
		your_email.blur(validate_widget_your_email);
		your_subject.blur(validate_widget_your_subject);
		your_message.blur(validate_widget_your_message);

		//On key press
		your_name.keyup(validate_widget_your_name);
		your_email.keyup(validate_widget_your_email);
		your_subject.keyup(validate_widget_your_subject);
		your_message.keyup(validate_widget_your_message);

		//On Submitting
		contact_widget_frm.submit(function(){
			if(validate_widget_your_name() & validate_widget_your_email() & validate_widget_your_subject() & validate_widget_your_message())
			{
				hideform();
				return true
			}
			else
			{
				return false;
			}
		});

		//validation functions
		function validate_widget_your_name()
		{
			if($cwidget("#widget_your-name").val() == '')
			{
				your_name.addClass("error");
				your_name_Info.text("<?php _e('Please Enter Name','templatic'); ?>");
				your_name_Info.addClass("message_error");
				return false;
			}
			else
			{
				your_name.removeClass("error");
				your_name_Info.text("");
				your_name_Info.removeClass("message_error");
				return true;
			}
		}

		function validate_widget_your_email()
		{
			var isvalidemailflag = 0;
			if($cwidget("#widget_your-email").val() == '')
			{
				isvalidemailflag = 1;
			}else
			if($cwidget("#widget_your-email").val() != '')
			{
				var a = $cwidget("#widget_your-email").val();
				var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
				//if it's valid email
				if(filter.test(a)){
					isvalidemailflag = 0;
				}else{
					isvalidemailflag = 1;	
				}
			}
			
			if(isvalidemailflag)
			{
				your_email.addClass("error");
				your_emailInfo.text("<?php _e('Please Enter valid Email','templatic'); ?>");
				your_emailInfo.addClass("message_error");
				return false;
			}else
			{
				your_email.removeClass("error");
				your_emailInfo.text("");
				your_emailInfo.removeClass("message_error");
				return true;
			}
		}

		

		function validate_widget_your_subject()
		{
			if($cwidget("#widget_your-subject").val() == '')
			{
				your_subject.addClass("error");
				your_subjectInfo.text("<?php _e('Please Enter Subject','templatic'); ?>");
				your_subjectInfo.addClass("message_error");
				return false;
			}
			else{
				your_subject.removeClass("error");
				your_subjectInfo.text("");
				your_subjectInfo.removeClass("message_error");
				return true;
			}
		}

		function validate_widget_your_message()
		{
			if($cwidget("#widget_your-message").val() == '')
			{
				your_message.addClass("error");
				your_messageInfo.text("<?php _e('Please Enter Message','templatic'); ?>");
				your_messageInfo.addClass("message_error");
				return false;
			}
			else{
				your_message.removeClass("error");
				your_messageInfo.text("");
				your_messageInfo.removeClass("message_error");
				return true;
			}
		}

	});
	</script>          
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="contact_widget_frm" name="contact_frm" class="wpcf7-form">
    <input type="hidden" name="contact_widget" value="1" />
    <input type="hidden" name="request_url" value="<?php echo $_SERVER['REQUEST_URI'];?>" />

    <div class="form_row "> <label> <?php _e('Name','templatic');?> <span class="indicates">*</span></label>
        <input type="text" name="your-name" id="widget_your-name" value="" class="textfield" size="40" />
        <span id="widget_your_name_Info" class="error"><?php _e('','templatic'); ?></span>
   </div>
   
    <div class="form_row "><label><?php _e('Email','templatic');?>  <span class="indicates">*</span></label>
        <input type="text" name="your-email" id="widget_your-email" value="" class="textfield" size="40" /> 
        <span id="widget_your_emailInfo"  class="error"></span>
  </div>
          
       <div class="form_row "><label><?php _e('Subject','templatic');?> <span class="indicates">*</span></label>
        <input type="text" name="your-subject" id="widget_your-subject" value="" size="40" class="textfield" />
        <span id="widget_your_subjectInfo"></span>
        </div>     
          
    <div class="form_row"><label><?php _e('Message','templatic');?> <span class="indicates">*</span></label>
     <textarea name="your-message" id="widget_your-message" cols="40" class="textarea textarea2" rows="10"></textarea> 
    <span id="widget_your_messageInfo"  class="error"></span>
    </div>
        <input type="submit" value="<?php _e('Send','templatic');?>" class="b_submit" />  
  </form> 

	</div>
			
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['desc1'] = ($new_instance['desc1']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array('title' => '') );		
			$title = strip_tags($instance['title']);
			$desc1 = ($instance['desc1']);
	?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	<?php
		}}
	register_widget('contact_widget');
}
?>