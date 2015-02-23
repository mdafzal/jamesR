<?php /* Template Name: Template - Advanced Search */?>
<?php
/*tpl_advanced_search.php BOF*/
define('SEARCH_WEBSITE',__('Search this website','templatic'));
define('SEARCH',__('Search','templatic'));
define('CATEGORY',__('Category','templatic'));
define('SELECT_CATEGORY',__('select category','templatic'));
define('DATE_TEXT',__('Date','templatic'));
define('TO',__('<span>to</span>','templatic'));
define('AUTHOR_TEXT',__('Author','templatic'));
define('EXACT_AUTHOR_TEXT',__('Exact author','templatic'));
define('SEARCH_ALERT_MSG',__('Please enter word you want to search','templatic'));
/*tpl_advanced_search.php EOF*/
?>
<?php get_header(); ?>
<?php do_atomic( 'before_content' ); // supreme_before_content ?>
<?php if ( current_theme_supports( 'breadcrumb-trail' ) && hybrid_get_setting('supreme_show_breadcrumb')) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>
<div id="content" class="multiple">
  <?php do_atomic( 'open_content' ); // supreme_open_content ?>
  <div class="hfeed page-templage-advanced_search-php">
    <!--  CONTENT AREA START -->
    <div class="entry">
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
        <div class="post-content">
          <?php the_content(); ?>
        </div>
        <div id="advancedsearch" class="clearfix">
          <h4> <?php echo SEARCH_WEBSITE; ?></h4>
          <form method="get"  action="<?php echo home_url()."/"; ?>" name="searchform" onsubmit="return sformcheck();">
          <?php
		   if(is_plugin_active('wpml-translation-management/plugin.php')){
					global $sitepress;
					$current_lang_code= ICL_LANGUAGE_CODE;
					$language=$current_lang_code;
					?>
                    <input  name="lang" id="lang" type="hidden"  value="<?php echo $language; ?>" />
                    <?php 
				}
		  ?>
            <div class="advanced_left">
              <p class="form_row">
                <label><?php echo SEARCH;?></label>
                <input class="adv_input" name="s" id="adv_s" type="text" PLACEHOLDER="<?php echo SEARCH; ?>" value="" />
                <input class="adv_input" name="adv_search" id="adv_search" type="hidden" value="1"  />
				<span class="message_error2"  style="color:red;font-size:14px;display:block;" id="search_error"></span>
              </p>
              <p class="form_row">
                <label><?php echo CATEGORY;?></label>
                <?php wp_dropdown_categories( array('name' => 'catdrop','orderby'=> 'name','show_option_all' => __('select category','templatic'), 'taxonomy'=>array('category')) ); ?>
              </p>
              <p class="form_row">
		<?php	
		wp_enqueue_style('jQuery_datepicker_css',get_stylesheet_directory_uri().'/css/jquery.ui.all.css');	
//		wp_enqueue_script('jquery_ui_core',get_stylesheet_directory_uri().'js/jquery.ui.core.js');
		wp_enqueue_script('jquery-ui-datepicker'); ?>
              <script type="text/javascript">				
					jQuery(function(){
					var pickerOpts = {
						showOn: "both",
						buttonImage: "<?php echo get_stylesheet_directory_uri();?>/css/images/cal.gif",
						buttonText: "Show Datepicker"
					};	
					jQuery("#catelog_todate").datepicker(pickerOpts);
					jQuery("#catelog_frmdate").datepicker(pickerOpts);
				});
				</script>
                <label><?php echo DATE_TEXT;?></label>
                <input type="text" id="catelog_todate" name="catelog_todate" PLACEHOLDER="<?php _e('From','templatic'); ?>" class="textfield date-feild">
                <input type="text" id="catelog_frmdate" name="catelog_frmdate" PLACEHOLDER="<?php _e('To','templatic'); ?>" class="textfield date-feild">
                
              	<!--<input name="catelog_todate" type="text" class="textfield date-feild"/>
                <img src="<?php echo get_stylesheet_directory_uri();?>/images/cal.gif" alt="Calendar" class="adv_calendar" onclick="displayCalendar(document.searchform.catelog_todate,'yyyy-mm-dd',this)"  /> <?php echo TO;?>               
                <input name="catelog_frmdate" type="text" class="textfield date-feild"/>
                <img src="<?php echo get_stylesheet_directory_uri();?>/images/cal.gif" alt="Calendar"  class="adv_calendar" onclick="displayCalendar(document.searchform.catelog_frmdate,'yyyy-mm-dd',this)"  /> </p>-->
              <p class="form_row">
                <label><?php echo AUTHOR_TEXT;?> </label>
                <input name="articleauthor" type="text" class="textfield"  />
              </p>
              <p class="form_row adv-chk">
              	<input name="exactyes" type="checkbox" value="1" class="checkbox" />
                <span class="adv_author"> <?php echo EXACT_AUTHOR_TEXT;?> </span>
              </p>
              <p class="form_row"><input type="submit" value="<?php _e('Submit','templatic'); ?>" class="adv_submit b_submit" /></p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--  CONTENT AREA END -->
  </div>
  <?php get_template_part( 'loop-nav' ); ?>
  <?php do_atomic( 'close_content' ); // supreme_close_content ?>
</div>
<?php do_atomic( 'after_content' ); // supreme_after_content ?>
<script type="text/javascript" >
function sformcheck(){
	jQuery.noConflict();
	var search = jQuery('#adv_s').val();
	if(search==""){
		jQuery('#search_error').html('<?php echo SEARCH_ALERT_MSG; ?>');
		return false;
	}else{
		search.bind(change,function(){jQuery('#search_error').html('');});
		jQuery('#search_error').html('');
		return true;
	}
}
</script>
<?php get_footer(); ?>
