<?php
	session_start();
	require( "../../../../wp-load.php");
	if(is_plugin_active('wpml-translation-management/plugin.php'))
		{
			global  $sitepress;
			$sitepress->switch_lang($_REQUEST['limitarr'][2]);
		}
	global $wpdb,$posts,$post,$query_string;

	$posthtml = '';	
	$start = $_REQUEST['limitarr'][0];
 	$end = $_REQUEST['limitarr'][1];
	$total = $_REQUEST['limitarr'][4];
	$num = $_REQUEST['limitarr'][3];
	if(isset($total))
		$_SESSION['total'] = $total;
	if(($start + $end) > $_SESSION['total'])
	  {
		$end =   ($_SESSION['total'] - $start );
	  }
	$ppost = get_option('widget_advanced_popularposts');
	$popular_per = $ppost[1]['popular_per'];
	$number = $ppost[1]['number'];
        $now = gmdate("Y-m-d H:i:s",time());
        $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
		global $post,$wp_query;
		
		if($popular_per == 'views'){		
		$args_popular=array(
					'post_type'=>'post',
					'post_status'=>'publish',
					'posts_per_page' => $end,
					'paged'=>$num,
					'meta_key'=>'viewed_count',
					'orderby' => 'meta_value_num',
					'meta_value_num'=>'viewed_count',
					'order' => 'DESC'
					);
	}elseif($popular_per == 'dailyviews'){
		$args_popular=array(
					'post_type'=>'post',
					'post_status'=>'publish',
					'posts_per_page' => $end,
					'paged'=>$num,
					'meta_key'=>'viewed_count_daily',
					'orderby' => 'meta_value_num',
					'meta_value_num'=>'viewed_count_daily',
					'order' => 'DESC'
					);
	}else{		
		$args_popular=array(
					'post_type'=>'post',
					'post_status'=>'publish',
					'posts_per_page' => $end,
					'paged'=>$num,					
					'orderby' => 'comment_count',					
					'order' => 'DESC'
					);
	}

$popular_post_query = new WP_Query($args_popular);

//print_r($popular_post_query->request);
if($popular_post_query){
	while ($popular_post_query->have_posts()) : $popular_post_query->the_post();
        $popular = '';

        
                $post_title = stripslashes($post->post_title);
                $guid = get_permalink($post->ID);
				$total_view = user_post_visit_count($post->ID);
				$views = $total_view.__(' View ','templatic');
				if($total_view > 1){
				$views = $total_view.__(' Views ','templatic');
				}
				$comments = $post->comment_count;
				if($post->comment_count > 1){
				$comments = $post->comment_count;
				}
                $guid = get_permalink($post->ID);
				$first_post_title=substr($post_title,0,26);
				
				$post_images =  bdw_get_images_with_info($post->ID,'popular-thumb');   
				$attachment_id = $post_images[0]['id'];
				$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
				$attach_data = get_post($attachment_id);
				$title = $attach_data->post_title;
				if($title ==''){ $title = $post->post_title; }
				if($alt ==''){ $alt = $post->post_title; }
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'popular-thumb' );
				if(isset($image[0]) && $image[0]!='')
					 $first_img = $image[0];
				elseif(isset($post_images[0]['file'])){
				$first_img = $post_images[0]['file'];
				}else{
				$first_img = get_stylesheet_directory_uri()."/images/img_not_available.png";
				}
				$posthtml .= '<li>';
			
					$posthtml .= '<div class="postimageview"><a href="'. $guid .'" class="postimg"><img src="'.$first_img.'" alt="'.$post_title.'" title="'.$post_title.'" /></a></div>';
				
				$posthtml .= '<div class="postcontentview">';
                //$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

				if(strtotime($post->comment_date) != 0) {
					$du = strtotime($post->comment_date);
				} else {
					$du = strtotime($post->post_date);
				}
				$fv = human_time_diff($du, current_time('timestamp')) . " " . __('ago','templatic');
				if($popular_per == 'views' || $popular_per == 'dailyviews'){
				$posthtml .= '<span class="byline"><i class="fa fa-clock-o"></i>'.$fv.'</span><span class="views">'.$views.'</span><a href="'.$guid.'" title="'.$post_title.'">'.$first_post_title.'</a></div<></li>';
				}else{
				$posthtml .= '<span class="byline"><i class="fa fa-clock-o"></i>'.$fv."</span><span class='byline'><i class='fa fa-comment'></i>".$comments.'</span><h2><a  href="'.$guid.'" title="'.$post_title.'">'.$first_post_title.'</a></h2></div></li>';
				}
        		endwhile;wp_reset_query();
			}
			 else
			 {
			 	$posthtml .= 'Apologies, but no results were found.';
			 }
?>

<?php echo sprintf(__('%s','templatic'), $posthtml); ?>