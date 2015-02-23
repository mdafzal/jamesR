<?php
/**
 * Post Template
 *
 * This is the default post template.  It is used when a more specific template can't be found to display
 * singular views of the 'post' post type.
 *
 * @package supreme
 * @subpackage Template
 */
/**---Single.php---**/
define('DAILY_VIEW_COUNT',__('Visits today','templatic'));
define('TOTAL_VIEW_COUNT',__('Visited %s times','templatic'));
get_header(); // Loads the header.php template. ?>
<?php do_atomic( 'before_content' ); // supreme_before_content ?>
<?php if ( current_theme_supports( 'breadcrumb-trail' ) && hybrid_get_setting('supreme_show_breadcrumb')) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>

<div id="content">
<?php do_atomic( 'open_content' ); // supreme_open_content ?>
<div class="hfeed">
<?php get_sidebar( 'before-content' ); // Loads the sidebar-before-content.php template. ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php do_atomic( 'before_entry' ); // supreme_before_entry ?>
								<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">
																<?php do_atomic( 'open_entry' ); // supreme_open_entry ?>
																<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __('<i class="fa fa-clock-o"></i> [entry-published] <i class="fa fa-user"></i> [entry-author] ', 'supreme' )); ?>
																<?php view_counter($post->ID); 
																		$sep =" , ";
																		echo sprintf(TOTAL_VIEW_COUNT,user_post_visit_count($post->ID));//page tilte filter ?>
																		<?php  echo $sep.user_post_visit_count_daily($post->ID)." ".DAILY_VIEW_COUNT;//page tilte filter  ?>
								</div>
								
								<?php get_sidebar( 'entry' ); // Loads the sidebar-entry.php template. ?>
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
                               
								<div class="entry-content">
                                         <div class="social_content">
  									<?php if(technews_hybrid_get_setting('fb_like_button') || technews_hybrid_get_setting('plusone_button') || technews_hybrid_get_setting('twitter_share_button') || technews_hybrid_get_setting('stumble_upon_button')) { floating_social_sharing_button(); }  ?>
                                </div>
								<?php
									if( $post->post_type != 'page' )
									{
										$post_images =  bdw_get_images_with_info($post->ID,'large');   
										$attachment_id = $post_images[0]['id'];
										$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
										$attach_data = get_post($attachment_id);
										$title = $attach_data->post_title;
										if($title ==''){ $title = $post->post_title; }
										if($alt ==''){ $alt = $post->post_title; } 
										
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
										if(isset($image[0]) && $image[0]!='')
											 $crop_image = $image[0];
											 
										elseif($post_images[0]['file']){
											$crop_image = $post_images[0]['file']; 
										}
										else
											$crop_image = get_stylesheet_directory_uri()."/images/img_not_available.jpg";
									}
										?>
									 <?php 
									 $category = get_the_category($post->ID);
									 if($category){ ?>
									 <div class="cat_cont">
									 <?php
									 for($ci = 0; $ci<= count($category); $ci ++){
									 if($category[$ci]->cat_name != 'Uncategorized' && $category[$ci]->cat_name) { ?>
						
									 <div class="categoryName">
																<div class="cat-flag"><a href="<?php echo $category_link; ?>"><span><?php echo $category[0]->cat_name; ?></span><span class="post_count"><?php echo wt_get_category_count(); ?></span></a></div>
								</div>
									<?php } } ?></div><?php } if( $post->post_type != 'page' )
									{?>
										<a href="<?php echo $crop_image; ?>"> <img src="<?php echo $crop_image; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" /> </a> 
									<?php 
									}
								?>
																<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'supreme' ) ); ?>
																<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'supreme' ), 'after' => '</p>' ) ); ?>
								</div>
								<!-- .entry-content -->
	
								<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( 'Filed under: [entry-terms taxonomy="category"] [entry-terms taxonomy="post_tag" before="and Tagged: "]', 'supreme' ) . '</div>' ); ?>
								<?php do_atomic( 'close_entry' ); // supreme_close_entry ?>
</div>
<!-- .hentry -->
<?php $user_id = get_query_var('author'); 
if ( hybrid_get_setting( 'supreme_author_bio_posts' ) ) {
?>

<div class="author_box clearfix">
		<div class="author_avatar">
	<?php $desc = get_the_author_meta( 'description', $user_id ); ?>
	<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), '60', '', get_the_author_meta( 'display_name', $user_id ) ); ?>
	</div>
	<div class="author_desc">
	<h3><?php the_author_posts_link(); ?></h3>
			<p> <?php echo $desc; ?></p>
	</div>
</div>
<?php } ?>
<?php do_atomic( 'after_entry' ); // supreme_after_entry ?>
<?php get_sidebar( 'after-singular' ); // Loads the sidebar-after-singular.php template. ?>
<?php do_atomic( 'after_singular' ); // supreme_after_singular ?>
<?php //get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>
<div class="post_pagination clearfix">
        <?php
            $prev_post = get_adjacent_post(false, '', true);
            $next_post = get_adjacent_post(false, '', false); ?>
        <?php if ($prev_post) : $prev_post_url = get_permalink($prev_post->ID); 
			  $prev_post_title = $prev_post->post_title; 
					$post_images =  bdw_get_images_with_info($prev_post->ID,'large');   
					$attachment_id = $post_images[0]['id'];
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					if($title ==''){ $title = $prev_post->post_title; }
					if($alt ==''){ $alt = $prev_post->post_title; }
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'large' );
					if(isset($image[0]) && $image[0]!='')
						 $prev_post_images = $image[0];
					elseif($post_images[0]['file']){
					$prev_post_images =$post_images[0]['file'];
					
					}else{
					$prev_post_images = get_stylesheet_directory_uri()."/images/img_not_available.png";
					}
		?>
        <a class="post_prev" href="<?php echo $prev_post_url; ?>">
								<i class="fa fa-chevron-left"></i>
								<img style="max-height:50px;max-width:75px;" src="<?php echo $prev_post_images; ?>" alt="<?php echo $prev_post_title; ?>" />
								<abbr>
																<em><?php _e('Previous post','templatic');?></em>
																<span><?php echo $prev_post_title; ?></span>
								</abbr>
								</a>
        <?php endif; ?>
        <?php if ($next_post) : $next_post_url = get_permalink($next_post->ID); 

			       $post_nimages =  bdw_get_images_with_info($next_post->ID,'large');   
					$attachment_id = $post_nimages[0]['id'];
					$altn = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$next_post_title = $attach_data->post_title;
					if($next_post_title ==''){ $next_post_title = $next_post->post_title; }
					if($altn ==''){ $altn = $next_post->post_title; }
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'large' );
					if(isset($image[0]) && $image[0]!='')
						 $next_post_images = $image[0];
					elseif($post_nimages[0]['file']){
							$next_post_images = $post_nimages[0]['file'];
					}else{
					$next_post_images = get_stylesheet_directory_uri()."/images/img_not_available.png";
					}
	
		?>
        <a class="post_next" href="<?php echo $next_post_url; ?>"><i class="fa fa-chevron-right"></i><img style="max-height:50px;max-width:75px;" src="<?php echo $next_post_images; ?>" alt="<?php echo $altn; ?>" />
								<abbr>
																<em><?php _e('Next post','templatic');?></em>
																<span><?php echo $next_post->post_title; ?></span>
								</abbr>
								</a>
        <?php endif; ?>
      </div>
 <div class="after_single_entry">
    <?php if (function_exists('dynamic_sidebar') && $post->post_type != 'page'){ dynamic_sidebar('single_post_below'); } ?>
    </div>
	<?php 
		if ( hybrid_get_setting( 'enable_comments' ) ) {
			comments_template( '/comments.php', true ); // Loads the comments.php template. 
		}
	?>
<?php endwhile; ?>
<?php endif; ?>

<?php get_sidebar( 'after-content' ); // Loads the sidebar-after-content.php template. ?>
</div>
<!-- .hfeed -->

<?php do_atomic( 'close_content' ); // supreme_close_content ?>
</div>
<!-- #content -->

<?php do_atomic( 'after_content' ); // supreme_after_content ?>
<?php get_footer(); // Loads the footer.php template. ?>
