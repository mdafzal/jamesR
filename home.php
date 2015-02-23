<?php
/**
 * Home Template
 *
 * This is the home template.  Technically, it is the "posts page" template.  It is used when a visitor is on the 
 * page assigned to show a site's latest blog posts.
 *
 * @package supreme
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>
<?php do_atomic( 'before_content' ); // supreme_before_content ?>
<?php //if ( current_theme_supports( 'breadcrumb-trail' ) && hybrid_get_setting('supreme_show_breadcrumb') ) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>

<div id="content">

	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('front_content'); }?>

<?php do_atomic( 'open_content' ); // supreme_open_content ?>


	
<div class="hfeed home-php">
	
<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>
<?php get_sidebar( 'before-content' ); // Loads the sidebar-before-content.php template. ?>
<?php get_sidebar( 'after-content' ); // Loads the sidebar-after-content.php template. ?>
</div>
<!-- .hfeed -->

<?php do_atomic( 'close_content' ); // supreme_close_content ?>

</div>
<!-- #content -->

<?php do_atomic( 'after_content' ); // supreme_after_content ?>
<?php get_footer(); // Loads the footer.php template. ?>
