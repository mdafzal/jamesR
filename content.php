<div class="postimageview content-php">
		<?php 
		if ( current_theme_supports( 'get-the-image' ) ) : 	
		get_the_image(array('post_id'=> get_the_ID(),'size'=>'event-home-thumb','image_class'=>'img','default_image'=>get_stylesheet_directory_uri()."/images/img_not_available.png"));					
		endif;
		?>
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
	<?php do_atomic( 'open_entry' ); // supreme_open_entry ?>
	<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __('<i class="fa fa-user"></i> [entry-author] <i class="fa fa-clock-o"></i> [entry-published] <i class="fa fa-comments"></i> [entry-comments-link zero="Respond" one="%1$s" more="%1$s"] [entry-edit-link] [entry-permalink]', 'supreme' ) . '</div>'); ?>
	<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
	<?php get_sidebar( 'entry' ); // Loads the sidebar-entry.php template. ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<!-- .entry-content --> 
	
</div>