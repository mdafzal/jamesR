<?php
/**
 * Loop Author Template
 *
 * Displays information at the top of the page about author pages.  
 * This is not shown on the front page or singular views.
 *
 * @package supreme
 * @subpackage Template
 */

?>
<?php $user_id = get_query_var('author'); ?>
<?php global $displaytype;  ?>

<div class="author_box clearfix">
		<div class="author_avatar">
	<?php $desc = get_the_author_meta( 'description', $user_id ); ?>
	<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), '60', '', get_the_author_meta( 'display_name', $user_id ) ); ?>
	</div>
								<div class="author_desc">
																<h3><?php echo get_the_author_meta( 'display_name', $user_id ); ?></h3>
																<p> <?php echo $desc; ?></p>
								</div>
</div>

<div class="advancedlatestpost">
				<div class="viewsbox">
							<div class="listview"><a class="<?php if ($displaytype == 'list') { echo "active"; }   ?>"><i class="fa fa-th-list"></i><?php _e('List View','templatic'); ?></a></div>
							<div class="gridview"><a class="<?php if ($displaytype == 'grid') { echo "active"; }   ?>"><i class="fa fa-th"></i><?php _e('Grid View','templatic'); ?></a></div>
					</div>
</div>

<?php
$posts_per_page=get_option('posts_per_page');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args=array(
		'post_type'  =>'post',
		'author'=>$user_id,
		'post_status' => 'publish',
		'paged'=>$paged,
		'order_by'=>'date',
		'order' => 'DESC'
	);					
query_posts( $args );
?>