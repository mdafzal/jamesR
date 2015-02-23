<?php
/**
 * Author page Template
 *
 * This is the author template.  Technically, it is the "author page" template.  It is used when a visitor is on the 
 * page assigned to show a site's latest blog posts.
 *
 * @package supreme
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

<?php do_atomic( 'before_content' ); // supreme_before_content ?>

<?php if ( current_theme_supports( 'breadcrumb-trail' ) && hybrid_get_setting('supreme_show_breadcrumb')) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>

<div id="content">
	
	<?php do_atomic( 'open_content' ); // supreme_open_content ?>	
	<div class="hfeed author-php">
	
		<?php get_template_part( 'loop-author' ); // Loads the loop-author.php template. ?>
	
		<?php get_sidebar( 'before-content' ); // Loads the sidebar-before-content.php template. ?>
		<?php global $displaytype; ?>
		<div id="latestpostloop" class="<?php if ($displaytype == 'grid') {  echo 'grid'; } else{ echo 'list clear'; } ?>" >
			<div class="category_list_view" id="widget_index_upcomming_events_id">
		   <?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>			
				<?php do_atomic( 'before_entry' ); // supreme_before_entry ?>			
						<div id="post-<?php the_ID(); ?>" class="post_list">						
							<div class="postimageview author-php"><?php
							get_the_image(array('post_id'=> get_the_ID(),'link_to_post'=>'false','size'=>'image-thumb','image_class'=>'post_img img listimg','default_image'=>get_stylesheet_directory_uri()."/images/img_not_available.png"));
							?></div>
							<!-- List view image -->
							
							<?php get_sidebar( 'entry' ); // Loads the sidebar-entry.php template. ?>
							
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
							<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
							<?php get_sidebar( 'entry' ); // Loads the sidebar-entry.php template.?>
							<div class="entry-summary">
									<?php the_excerpt();if(technews_hybrid_get_setting('content_excerpt_readmore')) { echo read_more_link(); } ?>
								</div><!-- .entry-summary -->
						 
						
						<!-- .entry-content --> 
						
						<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( 'Filed under: [entry-terms taxonomy="category"] [entry-terms taxonomy="post_tag" before="and Tagged: "]', 'supreme' ) . '</div>' ); ?>
	
							</div><!-- .entry-content -->						
	
							<?php do_atomic( 'close_entry' ); // supreme_close_entry ?>
	
						</div><!-- .hentry -->
				
				<?php do_atomic( 'after_entry' ); // supreme_after_entry ?>
				
					<?php endwhile; ?>
				
			<?php endif; ?>
			<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>
			
			</div>
		</div>
		<?php get_sidebar( 'after-content' ); // Loads the sidebar-after-content.php template. ?>
		
	</div><!-- .hfeed -->
	
	<?php do_atomic( 'close_content' ); // supreme_close_content ?>
	
	

</div><!-- #content -->

<?php do_atomic( 'after_content' ); // supreme_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>