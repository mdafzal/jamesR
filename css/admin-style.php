<?php ob_start();
	$color1 = hybrid_get_setting( 'color_picker_color1' );
	$color2 = hybrid_get_setting( 'color_picker_color2' );
	$color3 = hybrid_get_setting( 'color_picker_color3' );
	$color4 = hybrid_get_setting( 'color_picker_color4' );
	$color5 = hybrid_get_setting( 'color_picker_color5' );
	$color6 = hybrid_get_setting( 'color_picker_color6' );


// Primary : Main headings, Titles, Links //
if($color1 != "#" || $color1 != ""){?>
				h1#site-title a,
				div#site-title a,
				.byline span.author a,
				.byline i.fa fa-user,
				.entry-meta span.category a,
				.post_pagination a span,
				.post_pagination a i,
				.after_single_entry .related_listing ul li a,
				.comment-reply-link,
				.comment-reply-login,
				.templatic_comment,
				div#menu-secondary .menu li.current-menu-item > a,
				div#menu-secondary .menu li.current_page_item > a,
				.mega-menu ul.mega li.current-menu-item > a,
				.mega-menu ul.mega li.current-page-item > a,
				.newsflash ul li a,
				.sidebar .popularpost ul li a,
				
				a:hover,
				div#menu-primary .menu li a:hover,
				#footer .column02 .widget ul li:hover a,
				#footer .footer-content p > a:hover,
				.term-cloud a:hover,
				#sidebar-subsidiary a.backtotop:hover,
				.comment-meta .published:hover,
				.comment-meta a:hover,
				
				.loop-nav span.previous:hover,
				.loop-nav span.next:hover,
				.pagination .page-numbers:hover,
				.comment-pagination .page-numbers:hover,
				.bbp-pagination .page-numbers:hover,
				.pagination .current,
				.comment-pagination .current,
				.bbp-pagination .current {
					color: <?php echo $color1; ?>;
				}
				
				button, a.button, button.button, input[type="reset"], input[type="submit"], input[type="button"],
				div#menu-secondary .menu li li a:hover, div#menu-secondary .menu li li.current-menu-item > a, div#menu-secondary .menu li li.current_page_item > a, div#menu-secondary .menu li li:hover > a,
				.flex-direction-nav a {
					background-color: <?php echo $color1; ?>;
				}
				
				.flexslider .slides > li {
					border-bottom-color: <?php echo $color1; ?>;
				}
				
				.sidebar .widget, .newsflash, div.arclist, #advancedsearch, .author_box, #respond {
					border-top-color: <?php echo $color1; ?>;
				}
				.flex-control-paging li a.flex-active {
					border-color: <?php echo $color1; ?>;
				}
<?php }


// Secondary : Navigation hover, Link hover, Headings hover, Selected //
if($color2 != "#" || $color2 != ""){?>

			a,
			div#menu-secondary .menu li a,
			div#menu-primary .menu li a,
			.advancedlatestpost h1,
			h2#site-description, div#site-description,
			.sidebar .widget h3,
			div.arclist .title-container h2,
			div.arclist .arclist_head h3,
			#advancedsearch h4,
			.widget h3.widget-title,
			.author_box h3,
			.after_single_entry .related_listing h3,
			#comments-number,
			#reply-title,
			.comment-author cite,
			#footer .footer-content p > a,
			a.read_more,
			.arclist ul li a {
				color: <?php echo $color2; ?>;
			}
			
			div#menu-secondary .menu *,
				div#menu-secondary .menu li:hover *,
    div#menu-secondary .menu li a:hover,
    div#menu-secondary .menu li:hover a,
    div#menu-secondary .menu li li a,
    div#menu-secondary .menu li li a:hover,
				div#menu-secondary .menu li.current-menu-item,
    div#menu-secondary .menu li.current_page_item,
				div#menu-secondary .menu li li.current-menu-item,
    div#menu-secondary .menu li li.current_page_item,
    div#menu-secondary .menu li li.current-menu-item > a,
    div#menu-secondary .menu li li.current_page_item > a,
    div#menu-secondary .menu li li:hover > a,
				div#menu-primary-title, div#menu-secondary-title, div#menu-subsidiary-title, div#menu-header-horizontal-title, div#menu-header-primary-title, div#menu-header-secondary-title,
				.mega-menu ul.mega * {
					color: <?php echo $color2; ?> !important;
				}
				
<?php }


// Content //
if($color3 != "#" || $color3 != ""){?>

				body,
				input[type="date"]:focus, 
				input[type="datetime"]:focus, 
				input[type="datetime-local"]:focus, 
				input[type="email"]:focus, 
				input[type="month"]:focus, 
				input[type="number"]:focus, 
				input[type="password"]:focus, 
				input[type="search"]:focus, 
				input[type="tel"]:focus, 
				input[type="text"]:focus, 
				input.input-text:focus,
				input[type="time"]:focus, 
				input[type="url"]:focus,
				input[type="week"]:focus, 
				select:focus, 
				.selectbox:focus,
				textarea:focus,
				.widget-search input[type="text"]:focus,
				#footer .footer-wrap, #footer p {
					color: <?php echo $color3; ?>;
				}
				
<?php }



// Subtexts //
if($color4 != "#" || $color4 != ""){?>

			input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="password"], input[type="search"], input[type="tel"], input[type="text"], input.input-text, input[type="time"], input[type="url"], input[type="week"], select, .selectbox, textarea, .widget-search input[type="text"],
			.byline, .byline a, .entry-meta, .loop-entries li .byline, .loop-entries li .entry-meta, .comment-meta, .comment-meta span.published, .comment-meta a.permalink,
			#footer .column02 .widget ul li a, .term-cloud a, #sidebar-subsidiary a.backtotop, .post_pagination a em, .after_single_entry .related_listing ul li .date,
			.comment-meta .published, .comment-meta a, form#commentform p.log-in-out,
			.byline, .byline a, .entry-meta, .loop-entries li .byline, .loop-entries li .entry-meta, .comment-meta, .comment-meta span.published, .comment-meta a.permalink, .bottom_line,
			.newsflash .newsright li a i, .arclist ul li, .arclist ul li span.arclist_comment {
				color: <?php echo $color4; ?>;
			}
				
<?php }


// Footer background & Navigation hover //
if($color5 != "#" || $color5 != ""){?>

			div#menu-secondary .menu li a:hover,
			div#menu-secondary .menu li:hover > a,
			div#menu-secondary .menu li li a,
			.mega-menu ul.mega li a:hover,
			.mega-menu ul.mega li:hover > a,
			.mega-menu ul.mega li li a,
			.mega-menu ul.mega li ul.sub-menu,
			.mega-menu ul.mega .sub li.mega-hdr li a,
			
			button:hover, a.button:hover, button.button:hover, input[type="reset"]:hover, input[type="submit"]:hover, input[type="button"]:hover,
			#sidebar-subsidiary,
			#footer {
				background-color: <?php echo $color5; ?>;
			}
			
<?php }


// Bodybackground //
if($color6 != "#" || $color6 != ""){?>
				body,
				div#menu-secondary .menu li.current-menu-item,
				div#menu-secondary .menu li.current_page_item,
				.mega-menu ul.mega li.current-menu-item > a,
				.mega-menu ul.mega li.current-page-item > a,
				div#menu-primary .menu li li a,
				div#menu-primary .menu li li a:hover,
				.mega-menu ul.mega li.current-menu-item, .mega-menu ul.mega li.current-page-item {
					background-color: <?php echo $color6; ?>;
				}
				div#menu-secondary .menu li.current-menu-item,
				div#menu-secondary .menu li.current_page_item,
				.mega-menu ul.mega li.current-menu-item > a,
				.mega-menu ul.mega li.current-page-item > a,
				.mega-menu ul.mega li.current-menu-item, .mega-menu ul.mega li.current-page-item {
					border-bottom-color: <?php echo $color6; ?>;
				}
				
				@media only screen and (max-width: 480px) {
				div#menu-secondary .menu li a:hover,
    div#menu-secondary .menu li:hover > a,
    div#menu-secondary .menu li li a,
    div#menu-secondary .menu li li a:hover,
    div#menu-secondary .menu li li.current-menu-item > a,
    div#menu-secondary .menu li li.current_page_item > a,
    div#menu-secondary .menu li li:hover > a {
					background-color: <?php echo $color6; ?>;
				}
			}
				
<?php }



$color_data = ob_get_contents();
ob_clean();
if(isset($color_data) && $color_data !=''){?>
	<style type="text/css">
		<?php echo $color_data;?>
	</style>
<?php 
}
?>