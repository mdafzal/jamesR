<?php
	$file = dirname(dirname(dirname(dirname( dirname( __FILE__ ) ))));

	require($file . "/wp-load.php");
	if(is_plugin_active('wpml-translation-management/plugin.php'))
	{
		global  $sitepress;
		$sitepress->switch_lang($_REQUEST['limitarr'][2]);
	}
	global $wpdb,$post,$query_string,$wp_query;

	$posthtml = '';
	$limitword = $_REQUEST['limitarr'][0];
	$number = $_REQUEST['limitarr'][1];
	//$languages = $_REQUEST['limitarr'][2];
	$args=
			array( 
			'post_type' => 'post',
			'posts_per_page' => $number,
			'post_status' => array('publish'),
			'order'=>'DESC'
		);	
				
	$latest_post2 = new WP_Query($args);
	$pcount=0;
	if($latest_post2){
		while ( $latest_post2->have_posts() ) : $latest_post2->the_post();
			setup_postdata($post);
			global $post;
			setup_postdata($post);
			$pcount++;
			$post_title = stripslashes($post->post_title);
			$author_name = get_userdata($post->post_author)->display_name; 
			$guid = get_permalink($post->ID);
			
		$posthtml .= '<div class="post_list">'; 
		$posthtml .= '<div class="postimageview">';

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
				elseif($post_images[0]['file'] !=''){
					$post_images = $post_images[0]['file'];
				}else{ 
					$post_images = get_stylesheet_directory_uri()."/images/img_not_available.png";
				}

		$posthtml .= '<a href="'.$guid.'"> <img class="alignleft" src="'.$post_images.'" alt="'.$post_title.'" title="'.$post_title.'" /></a>';

		$category = get_the_category($post->ID);
		$category_link = get_category_link( $category[0]->cat_ID );
		if($category[0]->cat_name != 'Uncategorized') {
			$posthtml .= '<div class="categoryName"><a href="'.$category_link.'"><span class="cat-flag">';
			$posthtml .= '<span>'.$category[0]->cat_name.'</span><span class="post_count">'.wt_get_category_count().'</span></span></a></div>';
		}

		$posthtml .= '</div><div class="postcontentview"><div class="byline">';

		$type = 'post';
		$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
		$fv = human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago','templatic');
		
		$posthtml .= '<span class="daysago">'.$fv.'</span> ';
		
		$posthtml .= '<span class="author vcard"><i class="fa fa-user"></i><a href="'.get_author_posts_url($post->post_author).'" title="Posts by '.$author_name.'">'.$author_name.'</a></span>';
		
		$posthtml .= ' <i class="fa fa-comment"></i>'.$post->comment_count; 
		
		$posthtml .='</div>';
		if($post->post_excerpt){
			$posthtml .= '<h2><a href="'.$guid.'">'.$post_title.'</a></h2><div class="post-content">'.get_the_excerpt($post->ID).read_more_link().'</div></div></div>';
		}
		else
			$posthtml .= '<h2><a href="'.$guid.'">'.$post_title.'</a></h2><div class="post-content">'.get_the_excerpt($post->ID).read_more_link().'</div></div></div>';
			if($pcount%3 ==0){
							if (function_exists('dynamic_sidebar')){
							$posthtml1 .= dynamic_sidebar('front_content_advt'); 
							$posthtml .= $posthtml1;
							}
							}

	  endwhile;wp_reset_query();
	} 
	else
	{
		$posthtml .= 'Apologies, but no results were found.';
	}
?>

<?php $posthtml .= '<a id="postcount" rel="'.count($latest_post2->posts).'" style="display:none;">&nbsp;</a>'; ?>

<?php echo sprintf(__('%s','templatic'), $posthtml);?>