<?php
/**
 * Loop Excerpt Template
 *
 * Displays the excerpts of posts.
 *
 * @package supreme
 * @subpackage Template
 */
?>

		<?php global $displaytype; ?>
<div id="latestpostloop" class="<?php if ($displaytype == 'grid') {  echo 'grid'; } else{ echo 'list clear'; } ?>" >
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php do_atomic( 'before_entry' ); // supreme_before_entry ?>

<div id="post-<?php the_ID(); ?>" class="post_list"> 

	<div class="postimageview">
		<?php 
			if ( current_theme_supports( 'get-the-image' ) ) : 	
			get_the_image(array('post_id'=> get_the_ID(),'size'=>'event-home-thumb','image_class'=>'img','default_image'=>get_stylesheet_directory_uri()."/images/img_not_available.png"));					
			endif; ?>
		
			
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
		
		<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
		<?php get_sidebar( 'entry' ); // Loads the sidebar-entry.php template.
			if( hybrid_get_setting( 'supreme_archive_display_excerpt' ) ) {?>
				<div class="entry-content">
				<?php the_excerpt();if(technews_hybrid_get_setting('content_excerpt_readmore')) { echo read_more_link(); } ?>
				</div>
		 <?php  } else {?>
				<div class="entry-summary">
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'supreme' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'supreme' ), 'after' => '</p>' ) ); ?>
				</div><!-- .entry-summary -->
		<?php }?>
		
		<!-- .entry-content --> 
		
		<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( 'Filed under: [entry-terms taxonomy="category"] [entry-terms taxonomy="post_tag" before="and Tagged: "]', 'supreme' ) . '</div>' ); ?>
		<?php do_atomic( 'close_entry' ); // supreme_close_entry ?>
	</div>
</div>
<!-- .hentry -->

<?php do_atomic( 'after_entry' ); // supreme_after_entry ?>
<?php endwhile; ?>
<?php else : ?>
<div class="<?php hybrid_entry_class(); ?>">
    <h2 class="entry-title">
        <?php _e( 'No Entries', 'supreme' ); ?>
    </h2>
    <div class="entry-content">
        <p>
            <?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'templatic' ); ?>
        </p>
    </div>
</div>
<!-- .hentry .error -->

<?php endif; ?>
</div>
<!-- .loop-content -->