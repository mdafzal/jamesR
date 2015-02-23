<?php
set_time_limit(0);
global $upload_folder_path,$wpdb,$blog_id;
$upload_folder_path = wp_upload_dir();
if(get_option('upload_path') && !strstr(get_option('upload_path'),WP_CONTENT_DIR.'/uploads')){
	$upload_folder_path = $upload_folder_path['path'];
}else{
	$upload_folder_path =  $upload_folder_path['path'];
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
$folderpath = $upload_folder_path . "dummy/";
$strpost = strpos(get_stylesheet_directory(),WP_CONTENT_DIR);
$dirinfo = wp_upload_dir();
$target =$dirinfo['basedir']."/dummy"; 

full_copy( get_stylesheet_directory()."/images/dummy/", $target );



function full_copy( $source, $target ) 
{
	global $upload_folder_path;
	$imagepatharr = explode('/',$upload_folder_path."dummy");
	$year_path = ABSPATH;
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path .= $imagepatharr[$i]."/";
		  //echo "<br />";
		  if (!file_exists($year_path)){
			  @mkdir($year_path, 0777);
		  }     
		}
	}
	@mkdir( $target );
		$d = dir( $source );
		
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		copy( $source, $target );
	}
}

$a = get_option('supreme_theme_settings');
$b = array(
		'supreme_logo_url' 					=> get_stylesheet_directory_uri()."/images/logo.png",
		'supreme_site_description'			=> 1,
		'footer_insert' 					=> '<p class="copyright">Copyright &copy; [the-year] [site-link].</p> <p class="themeby">Designed by <a href="http://templatic.com/" alt="wordpress themes" title="wordpress themes"><img src="'.get_stylesheet_directory_uri().'/images/templatic-wordpress-themes.png" alt="wordpress themes"></a></p>'
	);
update_option('supreme_theme_settings',$b);
$theme_name = basename(get_stylesheet_directory_uri());
$theme_setting = get_option('theme_mods_'.($theme_name));
$theme_settings_array = array(
								'fb_like_button'	=> 1,
								'fb_appId'			=> '529430923776880',
								'plusone_button'	=> 1,
								'twitter_share_button'	=> 1,
								'stumble_upon_button'	=> 1,
								'content_excerpt_readmore'			=> 'read more &rarr;'
						);

$theme_setting_array = array(
								'background_color'					=> $theme_setting['background_color'],
								'background_image'					=> $theme_setting['background_image'],
								'background_repeat'					=> $theme_setting['background_repeat'],
								'background_position_x'				=> $theme_setting['background_position_x'],
								'background_attachment'				=> $theme_setting['background_attachment'],
								'nav_menu_locations'				=> $theme_setting['nav_menu_locations'],
								'supreme_theme_settings'			=> $theme_settings_array
							);

//print_r($theme_setting);
/*
	$theme_setting_array = array(
		$theme_setting['supreme_theme_settings']['floating_social_sharing_button']	=> 1,
		$theme_setting['supreme_theme_settings']['search_facility']					=> 1
		);

*/		
update_option('theme_mods_'.strtolower($theme_name),$theme_setting_array);

$dummy_image_path = get_stylesheet_directory_uri().'/images/dummy/';


$user_data = array();
$user_meta = array(
				"description"			=>	'This is the author info box. You can enter short description of yourself in the Biographical Info field on Your Profile page in your WordPress Dashboard.'
				);
$user_data = array(
				"user_login"		=>	'vedran@templatic.com',
				"user_email"		=>	'vedran@templatic.com',
				"user_nicename"		=>	'jhon',
				"user_url"			=>	'http://www.californiamoves.com',
				"display_name"		=>	'jhon',
				"first_name"		=>	'Jhon',
				"last_name"			=>	'',
				);				
$user_info[] = array(
				'data'	=>	$user_data,
				'meta'	=>	$user_meta
				);
				
$user_data = array();
$user_meta = array(
				"description"			=>	'This is the author info box. You can enter short description of yourself in the Biographical Info field on Your Profile page in your WordPress Dashboard.'
				);
$user_data = array(
				"user_login"		=>	'vrunda.only@gmail.com',
				"user_email"		=>	'vrunda.only@gmail.com',
				"user_nicename"		=>	'jeniffer',
				"user_url"			=>	'http://www.californiamoves.com',
				"display_name"		=>	'jeniffer',
				"first_name"		=>	'Jeniffer',
				"last_name"			=>	'',
				);				
$user_info[] = array(
				'data'	=>	$user_data,
				'meta'	=>	$user_meta
				);
require_once(ABSPATH.'wp-includes/registration.php');
$agents_ids_array = insert_users($user_info);
function insert_users($user_info)
{
	global $wpdb;
	$user_ids_array = array();
	for($u=0;$u<count($user_info);$u++)
	{
		if(!username_exists($user_info[$u]['data']['user_login']))
		{
			$last_user_id = wp_insert_user($user_info[$u]['data']);
			$user_ids_array[] = $last_user_id;
			$user_meta = $user_info[$u]['meta'];
			foreach($user_meta as $key=>$val)
			{
				update_user_meta($last_user_id, $key, $val); // User mata Information Here
			}
		}
	}
	$cap = $wpdb->prefix.'capabilities';
	$user_ids = $wpdb->get_var("SELECT group_concat(user_id) FROM $wpdb->usermeta where meta_key like '".$cap."' and meta_value like \"%subscriber%\"");
	return explode(',',$user_ids);
}
/////////////// TERMS END ///////////////
$post_info = array();
$category_array = array('Blog','News','Facebook','Google','Mobile','Apple');
insert_taxonomy_category($category_array);
function insert_taxonomy_category($category_array)
{
	global $wpdb;
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
					$last_catid = wp_insert_term( $catname, 'category' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'category');
					}
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'category');
			}
		}
	}
	
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'category', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img1.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Eric Allam on Code School',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Eric Allam on Code School',
					"post_content" =>	'Code School runs courses that teach you how to code directly in the browser. We talked to Eric Allam, the brain behind the project and ruby developer at Envy Labs  net  What s the idea behind Code School 
Eric Allan: Most people know how to open up their browser and type into a text field. We think learning to program should be that easy. Most programmers think it s a right of passage to learn the command line and the underlying architecture of computing before ever writing a lick of code – but we don t agree. We believe that coding is fun and installing crap from source isn t. That s why we put coding in the browser, and we developed good content around progressively challenging lessons. .net: Why did you decide to include gamification elements in the concept? EA: To introduce positive reinforcement that will motivate people to continue learning. We ve found it s not hard to get someone to try coding. What is hard is to get people to try coding again and again. That is why we use gamification. It s just another nudge, a little person on your shoulder whispering keep going . There has been a lot of backlash against gamification  and we think it s mainly against social game developers, who ve taken advantage of user psychology to keep their users farming gold or whatever it is they do. We aren t shy about using the same techniques to keep our students learning. The trick is to make sure that we use gamification as a means to an end, and not an end to itself.


',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img5.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Create Monstrous Characters with illustrator CS5 s Bristle Brush',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Create Monstrous Characters with illustrator CS5 s Bristle Brush',
					"post_content" =>	'Unlike the dramatic interface overhaul that accompanied its predecessor, there s so little new to the look and feel of Photoshop CS5 that it s barely worth mentioning.

The Workspace switcher has been modified so that you can drag it out of the drop-down menu across the menubar. Doing so can push the menubar itself down to a second level, which might take up too much screen space for some people. Pre-existing workspaces can be deleted, custom ones added, and generally the workspace concept has gotten a bit more user-friendly.

Toolbox icons have been redrawn with a softer touch. This has the unfortunate effect of making them look mushy and out-of-focus against their gray background. At least the iconography is the same, so the spot healing brush tool still looks like a band-aid, but this was not a welcome change.

Photoshop CS5 greatly expands the toolset that Adobe offers in its flagship product, charting new ways to make image manipulation easier while making older tools work better than before. Don t worry about the lack of a new interface; the new ways to get your project done make this version a must.

Photoshop has been in the English lexicon as a term to edit images for a long time, but the latest version of Adobe s flagship program stretches the canvas of manipulation much further than ever before. The look of the program has changed so little from Photoshop CS4 that users of that version should be instantly comfortable with this major update, but Photoshop Creative Suite 5 Extended gives photographers, artists, designers, and LOLcats obsessives a stunning array of new tools. Among the new features in Adobe s flagship image-editing software are automatic lens corrections, High Dynamic Range toning  automated editing tools and significant improvements to creating 3D images.




',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Apple','Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Develop for as Many users as Possible',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Develop for as Many users as Possible',
					"post_content" =>	'John Allsopp, developer and organiser of the Web Directions conferences, responds to Aral Balkan s one version manifesto and argues we should embrace the web s universality and aim to make our sites available for everybody

The fine folks at .net magazine very graciously asked me to comment on Aral s piece, because of a response I recently wrote to the tweet that started the whole conversation, outlining Aral s oneversion manifesto oneversion #manifesto My websites will only support the latest versions of browsers. It s the browser makers  duty to get users to upgrade.

There s much I could say in reply to his piece. In fact I ve written a number of detailed responses, but I think it s particularly important to get to the essence of why I expressed, and continue to have, reservations about this.
',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img4.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'My Websites will only support the latest browser versions',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'My Websites will only support the latest browser versions',

					"post_content" =>	'Hopefully you ve found this report helpful, but let us give you some final advice. It s something you are hopefully already doing if you’re a web developer or designer, but a reminder couldn’t hurt.

If you re designing for an existing website, it s great to keep the above information above in mind, but don t forget your site-specific visitor profile. In other words, you should of course also look at your own website’s visitor stats to see which browsers they tend to use. That can differ significantly depending on your audience.

For example, the top browsers in June so far for this blog, Royal Pingdom, are Firefox  40.86%, Chrome 32.03%, IE 15.50%, Safari 7.23% and Opera 1.96%. So almost 4/5 of our blog s  visitors use Firefox, Chrome or Safari. A lot of techies read this blog, and they tend to prefer Firefox and Chrome, which explains that. A different site with a different demographic would show different results.

That said, as soon as you re designing something that you want accessible to as wide an audience as possible, the overall stats that we presented in this article becomes a very good thing to keep in mind..



',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Apple'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Apple to announce e-book creation tools',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Apple to announce e-book creation tools',
					"post_content" =>	'Ars Technica is reporting that Apple s media event in New York on Thursday won t just be about education partnerships to release textbooks, but that we might also see new tools that are described as GarageBand for e-books.
The new tools are said to make e-book creation much easier than currently available software tools so that writers can more easily write and distribute their books.
In addition to the new tools, the Wall Street Journal suggests that Apple will also unveil new textbooks that are specifically optimized for the iPad. There are also rumors that Apple will announce partnerships with textbook publishers McGraw and Pearson PLC.
If these reports are true, then Apple may intend to revolutionize the e-book market like they did the mobile app market. By including writer-friendly tools and giving those writers a store to distribute and sell their work, Apple could help cut out much of the work and marketing currently necessary to get a book to the masses. Of course, none of this is official, so we ll have to wait until Thursday to find out.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img6.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Mobile Social Learning',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Mobile Social Learning',
					"post_content" =>	'Study Hall is a new website and iOS app for sharing and studying with friends. Even though the service is still in a beta phase it seems promising. The basic idea behind Study Hall is to enable teachers and students to upload content to a common place and access it through an iPad, an iPhone, or an iPod Touch. When using the free iPad app students can communicate in real-time about the content that they are sharing. When using the free iPhone app students can post comments about the content but cannot see each other s comments in real-time.
 Applications for Education Study Hall is a promising application for moving course content into a collaborative mobile platform. Once Study Hall publishes their Android app I think there is very real potential for it to be the preferred place for teachers to upload content and for students to study together remotely Math Practice Flash Cards is a free Android App from TeachersParadise.com. The app designed for elementary school students. As the name implies, Math Practice Flash Cards is a set of flashcards for practicing addition, subtraction, multiplication, and division. The app allows you to use pre-made sets of flashcards or create your own set of flashcards. To create your own set of flashcards just choose the parameters of largest numbers and smallest numbers in the flashcard set. You also have the option to choose from  fun mode which is not timed or the timed mode.
I gave Math Practice Flash Cards a try on both my Samsung Galaxy Tablet and my Motorola Photon. The app does not appear to be optimized for tablets yet, but it does work very well on my phone.
',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Google'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'NY Times Announces a TV Show',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'NY Times Announces a TV Show',
					"post_content" =>	' In 1994, The New York Times bought a videojournalism business I had founded called VNI, Video News International.

I had equipped 100 journalists around the world with Hi-8  this was a long timea ago video cameras with the idea that they could create video for TV. This was before the Internet did video.. or really before anyone had ever heard of the web. I became the President of New York Time Television.

Without a web, the only destination for NY Times videos would be TV. So we set about trying to get The New York Times on the air. Joe Lelyveld, the Managing Editor the the newspaper said that we could not come into the newsroom. He also said that he did not even own a TV. This was off to a bad start.

We made a deal with PBS and NPR to create a TV version of NPR s All Things Considered, but with New York Times reporters doing the video stories.


',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Google','Apple'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'The International Business Collateral',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'The International Business Collateral',
					"post_content" =>	'Starting a business outside the geographical boundaries of a country requires assessing a number of factors. Drawing up a business plan, assessing demand and supply, applying for loans and grants, getting permits and licenses and deciding on the location of the business are important issues that preoccupy the entrepreneur. Very often, an entrepreneur focuses only on the technical aspects and ignores the cultural aspects of a business. A good business plan is useless, unless people believe in the success of the plan and are willing to do business with the entrepreneur. This is when cultural differences gain prominence. An entrepreneur who is unaware of the differences in intercultural communication will find it exceedingly difficult to communicate with potential suppliers and buyers and foster relations, that are necessary for any business.Students pursuing the International Business Collateral gain valuable competency and preparation for the global business market. International Business professionals must be more than aware of the world: they must be able to understand and function in a variety of countries and cultures. They must be able to analyze internationally events and concepts and apply them to the complex dynamics at play in realm of international business including political, economic, linguistic, environmental, and cultural considerations. The specialized training offered in the International Business Collateral prepares students to be business leaders and entrepreneurs in our increasingly complex world of multinational conglomerates, international subsidiaries, and emerging economies on a scale unlike anything we have seen before. 
					
',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Apple'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg" ;
$post_meta = array(
				   
				   "templ_seo_page_title" =>'Second Will Ferrell s CASA DE MI PADRE Trailer and Poster',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Second Will Ferrell s CASA DE MI PADRE Trailer and Poster.',
					"post_content" =>	'Diego Luna is one of the most exciting actors working today. He gained the attention of American audiences in Alfonso Cuarón s Y TU MAMÁ TAMBIÉN and has since given a number of fantastic performances. Along with his co-star and life-long friend Gael Garcia Bernal, the two have made a number of fine films  together since working with Cuarón in Y TU MAMÁ. This includes RUDO Y CURSI and of course, their latest, CASA DE MI PADRE, the Spanish language feature film which also stars stateside funnyman Will Ferrell.

Sitting across from Diego Luna was an extremely pleasant experience. He is an incredible talent, yet he is absolutely sincere and kind. He spoke about working with Ferrell and how excited he was to be a part of a film like CASA DE MI PADRE. In the film, he plays brother to Will and he is incredibly funny in the role. In fact, it would be hard to imagine this film working as well as it does without either Bernal or Luna… and of course, the lovely and talented Genesis Rodriguez.
As Armando Alvarez s Ferrell ranch encounters financial difficulties, Armando s younger brother Raul, an international businessman, shows up with his new fiancé, Sonia. It seems the ranch’s troubles are over as Raul pledges to settle all debts his father has incurred. But when Armando falls for Sonia & Raul s business dealings turn out to be less than legit, they find themselves in a war with Mexico s most feared drug lord.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
//====================================================================================//
////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Buy the market, not the rally',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Buy the market, not the rally',
					"post_content" =>	'SAN FRANCISCO MarketWatch  It s taken more than a decade for the Nasdaq Composite Index to trade back near the 3,000 level. Now that it has, are tech stocks a buy

If you look at price-to-earnings ratios and earnings-growth estimates for 2012, you could make a strong argument that the answer is yes.

Given that U.S. Treasury notes are paying historically low interest rates, and fourth-quarter U.S. economic growth was 3%, stocks look more attractive than bonds right now.

That s not to say you should hit the “buy” button this week, at the top of a four-month rally. Given this run-up US COMP, stocks will take a breather, as they always do. If the contagion from a possible Greek default crimps U.S. growth, we could see a genuine correction rather than a simple pullback.

But the U.S. economy has good momentum right now, and with earnings season for the technology component of the S&P 500 Index (US:SPX) essentially over, the numbers show that the tech sector offers higher earnings growth for the same price as the index as a whole.

In other words, if you believe in stocks right now, you should believe in tech.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Google'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 11///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img13.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Rhode Island School Prayer Plaqoe Debate Highlight Stupidity Of Left s Neutrality Of Religion Nonsense',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Rhode Island School Prayer Plaqoe Debate Highlight Stupidity Of Left s Neutrality Of Religion Nonsense',
					"post_content" =>	'The founders and framers of the US Constitution and the Republic should be spinning in their graves over the mindset on display in this situation. Well perhaps they have been spinning in their graves ever since 1947, when the Supreme Court ruled in the Everson v. Board of Education case. A Supreme Court Justice at the time, Hugo Black,an anti-Catholic KKK er  introduced a wrong interpretation of the framers original intention in his  brief about the case, falsely saying that a separation of church and state existed  in the constitution.

Though the ruling went in favor of the plaintiff, it set in stone the misguided notion that all religious expression, whatsoever, was expressly forbidden in public institutions by the framers of the constitution. Republican Tea Party candidate running for the state senate seat in Delaware Christine O Donnell, was widely ridiculed for her statement during a debate that there isn t a separation of church and state  clause written in the constitution.

She was absolutely correct to state that it s not there, because it isn t, what does however exist, are the following words in the 1st Amendment:.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Apple'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//

////post start 12///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img12.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'8 Amazing TV Shows To Watch & How To Start Watching Them ',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'8 Amazing TV Shows To Watch & How To Start Watching Them ',
					"post_content" =>	'Not only does Beijing offer breathtakingly beautiful scenery, but it also allows you to experience one of the most accessible and traditional forms of Chinese entertainment; acrobatics. China is highly regarded as having some of the most amazing acrobatic shows around the globe, so why not follow the bandwagon and visit one of these amazing shows today with The China Travel Depot.

The tradition of Chinese acrobatics has existed in the culture for over two thousand years and continues today at the country s main training school; Wu Qiao (located in Hebei province) where training begins for students at the age of 5. Some of the most common acts include lion dances or dragon dances (acrobats in hefty costumes dance, roll and jump like lions and dragons), sword swallowing, fire breathing, conjuring and juggling. You may even be treated with a costumed ostrich while the acts prepare their next act.

A personal recommendation is the ‘Flying Acrobatics Show  currently being performed at the Chaoyang Theatre  Beijing. Here you will be astounded, amazed, impressed, and possibly confused by some of the stunts on show. The one and a half hour long show features extraordinary displays of courage, bravery and sheer brilliance. Acrobatics, contortionists, tightrope walking, bicycle tricks, and even Chinese kung fu makes it a must-see performance on your visit to Beijing.Well it s mid-September, we all know what that means TELEVISION IS COMING BACK  Who s excited  Is it possibly the girl who is living alone with her cat  Hey now, that was harsh. You don t know me.

So I m sure there are shows that you ve been hearing about but you re unsure if it s the show for you. Or even where to start. Here s what I d like to do: I want to create a comprehensive list. A list of shows worth watching, and the episode you should watch first to get you hooked. A few shows start out amazing out of the gate  AHEMmodernfamilyAHEM  but some take a little while to get going AHEMparksandrecAHEM.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//

////post start 13///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img13.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Training in the 21st Century™ creates blended learning programs',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Training in the 21st Century creates blended learning programs',
					"post_content" =>	'Unlike traditional training programs that involve substantial travel expenses and lost work time, our blended programs are a combination of multiple training methods tailored to cost-effectively fit your needs. We teach vital new business skills, increase productivity, and create a more effective workforce.

Imagine … People are having a stimulating group discussion in a dynamic, interactive environment. They re participating in business training scenarios, simulations and activities serious game that catalyze use of new knowledge with the drive to win, learn and grow. They use our self-paced e-learning programs to conveniently practice and apply new information. And we reinforce the learning  and application of learning  through real-time, cost effective virtual meetings..

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','News'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//

////post start 14///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img12.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'The Irynsoft Tablet Code-Named VIRTUOSO',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'The Irynsoft Tablet Code-Named VIRTUOSO',
					"post_content" =>	'While we have made our reputation as being the mobile educational platform for the iPhone and Android phone, we ve always looked to push the bar in new ways.  Heavily influenced by our participation in the Kauffman Foundation s Education Ventures Program, we ve taken a dramatic step in the evolution of the company to not only extend our offering to higher fidelity devices, but actually offer these devices directly to our customers.  Irynsoft-branded and co-branded  tablets will be offered this fall direct to consumers.  We see the tablet form factor as one of the most significant innovations in education technology and by partnering with tablet manufacturers to create dedicated devices,  we are able to create an affordable alternative for learners to gain access to the wealth of education resources available on the web.  In the meantime, as you know, we ve been working on our low-cost educational tablet.  Well, I m pleased to say we went code complete at the end of October and are just doing some final testing.  We ve already shipped some beta units in September, but we ve improved based on feedback and are really excited with how it looks.  We re creating a software-only BYOD  Bring Your Own Device  version that anyone with an Android Gingerbread device and sufficient screen resolution--we require 800x480 or above) can install on their own.  That will be available on the Android Market and Amazon App Store.  In addition, we intent to be fully compatible with Kindle Fire, though that device will lack some of the hardware features required to use all of the software. We plan to offer a free version and an extended version for the additional features. Here is a 3+ minute demo of our tablet.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('News','Mobile'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//

////post start 15///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img13.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Social Networking Safety Tips',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Social Networking Safety Tips',
					"post_content" =>	'Using social networks only to send bulletins and promote your business is bad form. The first thing you want to do is create an engaging profile. It s often the first thing people notice. Taking the time set up a simple bio page is well worth the effort. If you re over thirty it may be difficult to grasp the personal nature of online networks.

When I went through on-campus recruiting for accounting firms in 1997 it was all about the navy suit and the ability to make vanilla small talk. We were taught to blend. Not anymore. Today’s networking is all about showing your true self. You also want to have a nice picture to add to your perceived professionalism and trustworthiness. A stock avatar says you have something to hide  The bottom line is that people want to do business with someone they feel like they know.

Even if the profile is for the business, not you the person make sure it has a personality and something to share not just something to sell!In a study called  Teens Surfing the Net: How Do They Learn To Protect Their Privacy researchers Deborah M Moscardelli and Catherine Liston-Heyes imply that “differences between adults and young people with regard to privacy may be due to lack of knowledge about privacy.Their study found that parents who monitor their child s Internet use, or those that surf the Internet with them, have teenagers with higher rates of concerns about privacy that those who do not.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Facebook','Google','Mobile'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 16///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img16.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'The Facebook :Timeline Now Available Worldwide',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'The Facebook :Timeline Now Available Worldwide',
					"post_content" =>	' Last year we introduced timeline a new kind of profile that lets you highlight the photos posts and life events that help you tell your story. Over the next few weeks, everyone will get timeline. When you get timeline, you ll have 7 days to preview what s there now. This gives you a chance to add or hide whatever you want before anyone else sees it. 
You can learn more about these new features by taking the quick tour available at the top of your timeline. If you want to get timeline now, go to the Introducing Timeline page and click "Get Timeline." Or you can wait until you see an announcement at the top of your home page When you upgrade to timeline, you ll have seven days to review everything that appears on your timeline before anyone else can see it. You can also choose to publish your timeline at any time during the review period. If you decide to wait, your timeline will go live automatically after seven days. Your new timeline will replace your profile, but all your stories and photos will still be there.
If you want to see how your timeline appears to other people, click the gear menu at the top of your timeline  and select View As.You can choose to see how your timeline appears to a specific friend or the public.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Facebook'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 17///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img12.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'New iphone & ipad Database Resources..on Facebook',
				   "templ_seo_page_kw" => '',
				   "tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'New iphone & ipad Database Resources..on Facebook',
					"post_content" =>	'Filemaker set up a handy new online resource for all of its iPad and iPhone database developers  pro and amateur alike. Instead of putting it on their own site though, they started up a Facebook page instead. Odd, but perhaps just a sign of the times. Handy probably come to think of it, since most people are checking their FB feeds more than anything else.

Anyhoo, it looks pretty useful. Packed with demos of how developers are creating Filemaker solutions for the iPhone/iPad combo, tips, videos, links, and of course, updates.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Mobile','Apple'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 18///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img16.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Google Gears: Upgrading from a 1950 s Chevy in Cuba',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Google Gears: Upgrading from a 1950 s Chevy in Cuba',
					"post_content" =>	'For obvious reasons, people are often assuming that Google Gears Offline. To me  this isn t the case. Gears happens to have three initial APIs LocalServer, Database, WorkerPool  that can lend themselves to offline work. However, some people are grokking that WorkerPool and even Database are very useful even if your application never goes offline.

Segue: I am really excited to have Brad Neuberg of Dojo, Rojo, and other non-ojo projects fame, working with me at Google. It is a real pleasure to see the group growing, with great new hires such as Joe Gregorio, and others that haven t made it official yet 

I was having a chat about Gears with Brad, and he was talking about how he saw it as a way to update the Web in place. He got it.

Let’s use a really corny analogy that breaks down. We get to drive a few makes of cars browsers  on the  information  highway. When we want new features, we have to wait for a new model to come out, and recently it feels like Cuba. The top selling car is a 1950 s Chevy. As drivers that are passionate about the driving experience, the Gears team is trying give everyone a foundation to replace the engine, even as you drive..

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Google'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 19///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img13.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Transforming Paper and Plastic into a 3D Interactive Experience',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Transforming Paper and Plastic into a 3D Interactive Experience',
					"post_content" =>	'The Google Earth API was used as a foundation for StrataLogica to make use of its sophisticated image rendering logic, satellite imagery and access to built-in tools and navigation controls. As an enterprise scale application, we faced some interesting challenges and gained many insights along the way that we d like to share.

Our first task was to prove we could wrap Nystrom s existing educationally focused maps and globes onto Google Earth while retaining the same high quality resolution delivered in their print products.

Achieving acceptable image resolution resulted in file sizes which were much too large. In addition, we needed to deliver an increased level of map content and granularity of images as the user zoomed into the earth. To address these two issues, we created a custom process that takes an Adobe Illustrator file and outputs Superoverlays in accordance with KML 2.1 standards. Using open source Python frameworks, we created a customized solution that outputs Superoverlays with various levels of content.

Our next challenge was to provide support for authoring and maintaining content, in the browser using the Google Earth plugin. All content is authored and maintained in a content management system CMS in much the same way as any dynamic website. One unique difference is that some of the content elements are geo-referenced coordinates that specify the location of content on earth. In the case of placemark balloons, the geo-referenced coordinates identify hotspots on the Nystrom maps which become clickable when the user turns on a setting. The placemark balloons provide supplementary audio, image, video and descriptive content such as the example shown above for the Appalachian Mountains. 

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Mobile'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 20///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img13.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Go Mobile with Master Accuracy ',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Go Mobile with Master Accuracy ',
					"post_content" =>	'Given the rise of Mobile Internet users in past few years  it has become quite important to have mobile or lite  version of your blog. Mobile users generally do not like to download relatively heavy blog that are made for normal internet connections and web browsers.

There are number of solutions for bloggers for both WordPress & Blogger platforms and I have personally tried a few of them, but I have not been too satisfied  Either they are too complex to setup or they are not exactly mobile-friendly.Here at trak.in, we had been using custom mobile blogger solution for past couple of months from Mobstac and were quite satisfied with what they had to offer. However, now Mobstac has gone ahead and launched a platform which allows bloggers to create mobile version of their blog. I got trak.in s mobile version up and running on the new platform in under 5 minutes.

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Mobile'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 21///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Google Trends Plus SEO Drive Traffic to Your Blog ',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Google Trends Plus SEO Drive Traffic to Your Blog ',
					"post_content" =>	'An organization has its own shuttle bus and provide free transportation for their employees is a very common service in China. Workers in schools, government agencies or private businesses all enjoy some sort of transportation tip free bus, taxi re reimbursement etc. on a monthly basis. However, it is quite rare here in North America. A recent article in New York Times exposed that Google is providing this service to the employees in the San Francisco region. I suppose it may be not as needed as in China since most people work in Google can afford cars but it is still a very thoughtful service due to high traffic in the cities. If you can hop onto a free ride and relax, surf on the Internet and get off right in front of your office, it s kinda nice isn t it Anyway, the article says, Google owns 32 buses, their routes cover over 10 cities and 6 counties around SF area. The buses provide free transportation to over 25% of the employees around 1200 people. They even have their own department of transportation I googled Google Bus, but only could find the Korean version of Google Bus, but I have to say this is a great idea to keep their employees and great advertisement

Beside free transportation, Google is doing the best to keep the employees: free cafeteria, free GYM, free rock climbing facilities, free swimming pool, free car wash, and free spa I need to forward this to my Microsoft friends

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Google'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 22///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/Templatic-Theme-Gallery.png" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Wordpress Themes Club ',
				   "templ_seo_page_kw" => '',
"tl_dummy_content"	=> '1',
				   "templ_seo_page_desc" => '',
				);
$post_info[] = array(
					"post_title" =>	'Wordpress Themes Club ',
					"post_content" =>	'The Templatic <a href="http://templatic.com/premium-themes-club/">Wordpress Themes Club</a> membership is ideal for any WordPress developer and freelancer that needs access to a wide variety of Wordpress themes. This themes collection saves you hundreds of dollars and also gives you the fantastic deal of allowing you to install any of our themes on unlimited domains.

You can see below just a few of our WordPress themes that are included in the club membership

&nbsp;
<img src="http://templatic.com/_data/images/Business-Directory-Theme-For-Wordpress_GeoPlaces.png" class="alignleft" /><strong>GeoPlaces</strong> - <a href="http://templatic.com/app-themes/geo-places-city-directory-wordpress-theme">Business Directory Theme</a>
The popular business directory theme that lets you have your very own local business listings directory or an international companies pages directory. This elegant and responsive design theme gives you powerful admin features to run a free or paid local business directory or both. GeoPlaces even has its own integrated events section so you not only get a business directory but an events directory too.


<img src="http://templatic.com/_data/images/Car-Classifieds-Wordpress-Theme_Automotive.png" class="alignleft"/><strong>Automotive</strong> - <a href="http://templatic.com/cms-themes/automotive-responsive-vehicle-directory">Car Classifieds Theme</a>
A responsive auto classifieds theme that gives you the ability of allowing vehicles submission on free or paid listing packages which you decide on the price and duration. This sleek auto classifieds and car directory theme is also WooCommerce compatible so you can even use part of your site to run as a car spares online store. Details


<img src="http://templatic.com/_data/images/Daily-Deal-Wordpress-Deals-Theme_DailyDeal.png" class="alignleft"/><strong>Daily Deal</strong> - <a href="http://templatic.com/app-themes/daily-deal-premium-wordpress-app-theme">Deals Theme</a>
A powerful Deals theme for WordPress which lets your visitors buy or sell deals on your deals website. Daily Deal is by far the easiest and cheapest way to create a deals site where you can earn money by creating different deals submission price packages but you can also allow free deal submissions. Details


<img src="http://templatic.com/_data/images/Events-Directory-Wordpress-Theme_Events.png" class="alignleft"/><strong>Events V2</strong> - <a href="http://templatic.com/app-themes/events">Events Directory Theme</a>
Launch a successful Events directory portal with this elegant responsive events theme. The theme has many powerful admin features including allowing event organizers to submit events on free or paid payment packages. This theme is simple to setup and you can get your events site up in no time.


<img src="http://templatic.com/_data/images/Events-Manager-Wordpress-Theme_NightLife.png" class="alignleft"/><strong>NightLife</strong> - <a href="http://templatic.com/cms-themes/nightlife-events-directory-wordpress-theme">Events Directory Theme</a>
A beautifully designed events management theme which is responsive and allows you to run an events website. Allow event organizers free or paid event listing submissions and offer online event registrations. Nightlife is feature-packed with all the features you can expect from an events directory theme.


<img src="http://templatic.com/_data/images/Hotel-Bookings-WordPress-Theme_5Star.png" class="alignleft"/><strong>5 Star</strong> - <a href="http://templatic.com/app-themes/5-star-responsive-hotel-theme">Online Hotel Booking and Reservations Theme</a>
A well designed hotel booking theme which is ideal for showcasing and promoting a hotel online in style. This responsive design hotel reservation Wordpress theme will surely impress your guests and is also a theme that gives you a lot of powerful features including an advanced online booking system and a booking calendar.


<img src="http://templatic.com/_data/images/Job-Classifieds-Wordpress-Theme_JobBoard.png" class="alignleft"/><strong>Job Board</strong> - <a href="http://templatic.com/app-themes/job-board">Job Classifieds Theme</a>
Start your job classifieds or job board site with this responsive premium jobs board theme. Allow employers to submit job listings for free, paid or both and also allow job seekers to apply for jobs or submit their resumes. Packed with great features you would expect from a premium jobs board theme. Details


<img src="http://templatic.com/_data/images/News-Magazine-Blog-WordPress-Theme_TechNews.png" class="alignleft"/><strong>TechNews</strong> - <a href="http://templatic.com/magazine-themes/technews-advanced-blog-theme">Blogging and News Theme</a>
A news theme that is an ideal solution for your a news blog. An elegant theme which is ideal for news blogs, magazine or newspaper sites. This mobile friendly theme is both responsive and WooCommerce compatible. Impress your visitors with the stylish layout and available color schemes. Details


<img src="http://templatic.com/_data/images/Property-Classifieds-Listings-WordPress-Theme_RealEstate.png" class="alignleft"/><strong>Real Estate V2</strong> - <a href="http://templatic.com/app-themes/real-estate-wordpress-theme-templatic">Property Classifieds Listings Theme</a>
This powerful IDX/MLS compatible real estate classifieds theme is both unique and powerful in the features it provides. With this real estate listings theme for WordPress, you can allow estate agencies and home sellers an opportunity to submit properties to your site. This real estate theme comes with many features including powerful search filter.


<img src="http://templatic.com/_data/images/Online-Store-Wordpress-Theme_ECommerce.png" class="alignleft"/><strong>e-Commerece</strong> - <a href="http://templatic.com/ecommerce-themes/e-commerce">Online Store Theme</a>
A powerful and elegant WooCoomerce compatible e-commerce WordPress theme with many features advanced features. This online store theme offers various modes of product display such as a shopping Cart, digital Shop or catalog mode. This theme for e-commerce offers multiple payment gateways, coupon codes. Details



See the full collection of the <a href="http://templatic.com/premium-themes-club/">WordPress Themes Club Membership</a>

',
					"post_author"	=> $agents_ids_array[array_rand($agents_ids_array)],
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Apple'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			$data = array(
				'comment_post_ID' => $last_postid,
				'comment_author' => 'admin',
				'comment_author_email' => get_option('admin_email'),
				'comment_author_url' => 'http://',
				'comment_content' => $post_info_arr['post_title'].'its amazing.',
				'comment_type' => '',
				'comment_parent' => 0,
				'user_id' => $current_user->ID,
				'comment_author_IP' => '127.0.0.1',
				'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date' => $time,
				'comment_approved' => 1,
			);

			wp_insert_comment($data);
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//=============================CUSTOM TAXONOMY=======================================================//
$post_info = array();

$pages_array = array(array('Page Templates','Advanced Search','Archives','Full Width','Left Sidebar Page','Sitemap','Contact Us'),
array('Dropdowns','Sub Page 1','Sub Page 2'));
$page_info_arr = array();
$page_info_arr['Page Templates'] = '
In WordPress, you can write either posts or pages. When you writing a regular blog entry, you write a post. Posts automatically appear in reverse chronological order on your blog home page. Pages, on the other hand, are for content such as "About Me," "Contact Me," etc. Pages live outside of the normal blog chronology, and are often used to present information about yourself or your site that is somehow timeless -- information that is always applicable. You can use Pages to organize and manage any amount of content. WordPress can be configured to use different Page Templates for different Pages. 

To create a new Page, log in to your WordPress admin with sufficient admin privileges to create new page. Select the Pages &gt; Add New option to begin writing a new Page.


Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.
';
$page_info_arr['Advanced Search'] = '
This is the Advanced Search page template. See how it looks. Just select this template from the page attributes section and you&rsquo;re good to go.
';
$page_info_arr['Archives'] = '
This is Archives page template. Just select it from page templates section and you&rsquo;re good to go.
';

$page_info_arr['Full Width'] = '
Do you know how easy it is to use Full Width page template ? Just add a new page and select full width page template and you are good to go. Here is a preview of this easy to use page template.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

See, there no sidebar in this template, and that why we call this a full page template. Yes, its this easy to use page templates. Just write any content as per your wish.
';
$page_info_arr['Left Sidebar Page'] = '
This is <strong>left sidebar page template</strong>. To use this page template, just select - page left sidebar template from Pages and publish the post. Its so easy using a page template.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus.

Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer  turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce  metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec  libero. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus  tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam  leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et  ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna  id quam.
<blockquote>Blockquote text looks like this</blockquote>
See, using left sidebar page template is so easy. Really.
';
$page_info_arr['Sitemap'] = '
See, how easy is to use page templates. Just add a new page and select <strong>Sitemap</strong> from the page templates section. Easy peasy, isn&rsquo;t it.
';
$page_info_arr['Contact Us'] = '
What do you think about this Contact page template ? Have anything to say, any suggestions or any queries ? Feel free to contact us, we&rsquo;re here to help you. You can write any text in this page and use the Contact Us page template. Its very easy to use page templates.
';
$page_info_arr['Dropdowns'] = '
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
';
$page_info_arr['Sub Page 1'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['Sub Page 2'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';

set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				$post_name = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					echo '';
				}else
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('siteurl')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}
//=====================================================================
$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Advanced Search' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_advanced_search.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Web Hosting Plan' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Shortcodes' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_archives.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Full Width' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Left Sidebar Page' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_left_sidebar_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sitemap' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_sitemap.php' );

if(get_user_meta(1,'description',true) == '')
	update_user_meta(1,'description','Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum');

///////////////////////////////////////////////////////////////////////////////////
//====================================================================================//

//echo "<pre>";
//print_r(get_option('sidebars_widgets'));
//print_r(get_option('widget_text'));
//exit; 


/////////////// WIDGET SETTINGS START ///////////////


$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();

/*---- Front content BOF ----*/

//////////////// Front Content //////////////////////
$templ_slider_portfolio = array();
$templ_slider_portfolio[1] = array(
					"title"			=>	'',
					"category"		=>	'',					
					"post_per_slide" =>	'1',					
					"post_type"		=>	'post',									
					);						
$templ_slider_portfolio['_multiwidget'] = '1';
update_option('widget_templ_slider_portfolio',$templ_slider_portfolio);
$templ_slider_portfolio = get_option('widget_templ_slider_portfolio');
krsort($templ_slider_portfolio);
foreach($templ_slider_portfolio as $key1=>$val1)
{
	$templ_slider_portfolio_key = $key1;
	if(is_int($templ_slider_portfolio_key))
	{
		break;
	}
}

$news_flash = array();
$news_flash[1] = array(
					"title"			=>	'',
					"category"		=>	'',					
					"post_per_slide" =>	'1',					
					"post_type"		=>	'post',									
					);						
$news_flash['_multiwidget'] = '1';
update_option('widget_news_flash',$news_flash);
$news_flash = get_option('widget_news_flash');
krsort($news_flash);
foreach($news_flash as $key1=>$val1)
{
	$templ_news_flash_key = $key1;
	if(is_int($templ_news_flash_key))
	{
		break;
	}
}

$advanced_latest_posts = array();
$advanced_latest_posts[1] = array(
					"title"			=>	'Latest Articles',					
					"displaytype"		=>	'list',									
					);						
$advanced_latest_posts['_multiwidget'] = '1';
update_option('widget_advanced_latest_posts',$advanced_latest_posts);
$advanced_latest_posts = get_option('widget_advanced_latest_posts');
krsort($advanced_latest_posts);
foreach($advanced_latest_posts as $key1=>$val1)
{
	$advanced_latest_posts_key = $key1;
	if(is_int($advanced_latest_posts_key))
	{
		break;
	}
}

$sidebars_widgets["front_content"] = array("templ_slider_portfolio-$templ_slider_portfolio_key","news_flash-$templ_news_flash_key","advanced_latest_posts-$advanced_latest_posts_key");

/*---- Front content EOF ----*/

/*-------Header right area BOF-------*/
$widget_ads6 = array();
$widget_ads6 = get_option('widget_widget_header_ads');
$widget_ads6[6] = array(
					"title"			=>	'',
					"header_ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'top-ad.jpg" alt="" /></a>',			
					);						
$widget_ads6['_multiwidget'] = '1';
update_option('widget_widget_header_ads',$widget_ads6);
$widget_ads6 = get_option('widget_widget_header_ads');
krsort($widget_ads6);
foreach($widget_ads6 as $key1=>$val1)
{
	$widget_ads6_key = $key1;
	if(is_int($widget_ads6_key))
	{
		break;
	}
}
$sidebars_widgets["header_logo_right_side"] = array("widget_header_ads-$widget_ads6_key");

/*-------Header right area EOF-------*/
////////////////Sidebar 1//////////////////////
$widget_ads5 = array();
$widget_ads5 = get_option('widget_widget_ads');
$widget_ads5[5] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',			
					);						
$widget_ads5['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads5);
$widget_ads5 = get_option('widget_widget_ads');
krsort($widget_ads5);
foreach($widget_ads5 as $key1=>$val1)
{
	$widget_ads5_key = $key1;
	if(is_int($widget_ads5_key))
	{
		break;
	}
}

$social_media[1] = array(
					"title"			=>	'',
					"twitter"		=>	'http://twitter.com/templatic/',								
					"facebook"		=>	'http://facebook.com/templatic/',								
					"linkedin"		=>	'http://linkedin.com/templatic/',								
					"gplus"		=>	'http://google.com/templatic/',								
					"digg"		=>	'http://templatic.com/',								
					"rss"		=>	'http://templatic.com/feeds/',								
					);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key1=>$val1)
{
	$social_media_key = $key1;
	if(is_int($social_media_key))
	{
		break;
	}
}
//  Subscribe  Widget
$subscribe = array();
$subscribe[1] = array(
					"title"				=>	'Join My Free Newsletter',
					"text"				=>	'Signup for a roundup of the day top news sent every morning',
					"id"				=>	'templatic/eKPs'
					);						
$subscribe['_multiwidget'] = '1';
update_option('widget_subscribewidget',$subscribe);
$subscribe = get_option('widget_subscribewidget');
krsort($subscribe);
foreach($subscribe as $key1=>$val1)
{
	$subscribe_key = $key1;
	if(is_int($subscribe_key))
	{
		break;
	}
}

$advanced_popularposts = array();
$advanced_popularposts[1] = array(
					"id"			=>	'',
					"title"			=>	'Popular Posts',
					"slide"			=>	'5',
					"number"			=>	'15',
					"text"			=>	'If you did like to stay updated with all our latest news please enter your e-mail address here ',							
					);						
$advanced_popularposts['_multiwidget'] = '1';
update_option('widget_advanced_popularposts',$advanced_popularposts);
$advanced_popularposts = get_option('widget_advanced_popularposts');
krsort($advanced_popularposts);
foreach($advanced_popularposts as $key1=>$val1)
{
	$advanced_popularposts_key = $key1;
	if(is_int($advanced_popularposts_key))
	{
		break;
	}
}

$widget_sidebar_ads = array();
$widget_sidebar_ads[6] = array(
					"title"			=>	'',
					"sidebar_ads1"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad1.jpg" alt="" /></a>',			
					"sidebar_ads2"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad2.jpg" alt="" /></a>',			
					"sidebar_ads3"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad3.jpg" alt="" /></a>',			
					"sidebar_ads4"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad4.jpg" alt="" /></a>',			
					"sidebar_ads5"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad5.jpg" alt="" /></a>',			
					"sidebar_ads6"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad6.jpg" alt="" /></a>',			
					"sidebar_ads7"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad7.jpg" alt="" /></a>',			
					"sidebar_ads8"			=>	'<a href="#"><img src="'.$dummy_image_path.'ad8.jpg" alt="" /></a>',			
					);						
$widget_sidebar_ads['_multiwidget'] = '1';
update_option('widget_widget_sidebar_ads',$widget_sidebar_ads);
$widget_sidebar_ads = get_option('widget_widget_sidebar_ads');
krsort($widget_sidebar_ads);
foreach($widget_sidebar_ads as $key1=>$val1)
{
	$widget_sidebar_ads_key = $key1;
	if(is_int($widget_sidebar_ads_key))
	{
		break;
	}
}
$sidebars_widgets["primary"] = array("widget_ads-$widget_ads5_key","social_media-$social_media_key","subscribewidget-$subscribe_key","advanced_popularposts-$advanced_popularposts_key","widget_sidebar_ads-$widget_sidebar_ads_key");
$sidebars_widgets["blog_detail_sidebar"] =  array("widget_ads-$widget_ads5_key","social_media-$social_media_key","widget_subscribe-$widget_subscribe_key","advanced_popularposts-$advanced_popularposts_key","widget_sidebar_ads-$widget_sidebar_ads_key");
$sidebars_widgets["blog_listing_sidebar"] =  array("widget_ads-$widget_ads5_key","social_media-$social_media_key","widget_subscribe-$widget_subscribe_key","advanced_popularposts-$advanced_popularposts_key","widget_sidebar_ads-$widget_sidebar_ads_key");

////////////////Sidebar 2////////////////////// 
$text = array();
$text[1] = array(
					"title"		  =>	'Why us?',					
					"text"		  =>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in </p>',
					);				
$text['_multiwidget'] = '1';
update_option('widget_text',$text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key1=>$val1)
{
	$text_key = $key1;
	if(is_int($text_key))
	{
		break;
	}
}

$links = array();
$links[1] = array(
					"title"		  =>	'Why us?',					
					"links"		  =>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in </p>',
					);				
$links['_multiwidget'] = '1';
update_option('widget_links',$links);
$links = get_option('widget_links');
krsort($links);
foreach($links as $key1=>$val1)
{
	$links_key = $key1;
	if(is_int($links_key))
	{
		break;
	}
}

$tag_cloud = array();
$tag_cloud[1] = array(
					"title"		  =>	'Tags',					
					);				
$tag_cloud['_multiwidget'] = '1';
update_option('widget_tag_cloud',$tag_cloud);
$tag_cloud = get_option('widget_tag_cloud');
krsort($tag_cloud);
foreach($tag_cloud as $key1=>$val1)
{
	$tag_cloud_key = $key1;
	if(is_int($tag_cloud_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar2"] = array("text-$text_key","links-$links_key","tag_cloud-$tag_cloud_key");

/*Single post below contetn BOF */

$widget_ads6 = array();
$widget_ads6 = get_option('widget_widget_ads');
$widget_ads6[6] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',			
					);						
$widget_ads6['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads6);
$widget_ads6 = get_option('widget_widget_ads');
krsort($widget_ads6);
foreach($widget_ads6 as $key1=>$val1)
{
	$widget_ads6_key = $key1;
	if(is_int($widget_ads6_key))
	{
		break;
	}
}
$related_listing_widget = array();
$related_listing_widget = get_option('widget_related_listing_widget');
$related_listing_widget[5] = array(
					"title"			=>	'Related Posts',
					"number"			=>	'5',			
					);						
$related_listing_widget['_multiwidget'] = '1';
update_option('widget_related_listing_widget',$related_listing_widget);
$related_listing_widget = get_option('widget_related_listing_widget');
krsort($related_listing_widget);
foreach($related_listing_widget as $key1=>$val1)
{
	$related_listing_widget_key = $key1;
	if(is_int($related_listing_widget_key))
	{
		break;
	}
}

$sidebars_widgets["single_post_below"] = array("widget_ads-$widget_ads6_key","related_listing_widget-$related_listing_widget_key");
/*Single post below contetn EOF */

$hybrid_search = array();
$hybrid_search[1] = array(
					"title"			=>	'',
					"search_text"			=>	'Search this blog',
					);
$hybrid_search['_multiwidget'] = '1';
update_option('widget_hybrid-search',$hybrid_search);
$hybrid_search = get_option('widget_hybrid-search');
krsort($hybrid_search);
foreach($hybrid_search as $key1=>$val1)
{
	$hybrid_search_key = $key1;
	if(is_int($hybrid_search_key))
	{
		break;
	}
}

$sidebars_widgets["subsidiary"] = array("hybrid-search-$hybrid_search_key");


/* footer widget 1 BOF*/

$social_media[1] = array(
					"title"			=>	'',
					"twitter"		=>	'http://twitter.com/templatic/',								
					"facebook"		=>	'http://facebook.com/templatic/',								
					"linkedin"		=>	'http://linkedin.com/templatic/',								
					"gplus"		=>	'http://google.com/templatic/',								
					"digg"		=>	'http://templatic.com/',								
					"rss"		=>	'http://templatic.com/feeds/',								
					);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key1=>$val1)
{
	$social_media_key = $key1;
	if(is_int($social_media_key))
	{
		break;
	}
}
//  Subscribe  Widget
$subscribe = array();
$subscribe[1] = array(
					"title"				=>	'Join My Free Newsletter',
					"text"				=>	'Signup for a roundup of the day top news sent every morning',
					"id"				=>	'templatic/eKPs'
					);						
$subscribe['_multiwidget'] = '1';
update_option('widget_subscribewidget',$subscribe);
$subscribe = get_option('widget_subscribewidget');
krsort($subscribe);
foreach($subscribe as $key1=>$val1)
{
	$subscribe_key = $key1;
	if(is_int($subscribe_key))
	{
		break;
	}
}
$sidebars_widgets["footer1"] = array("social_media-$social_media_key","subscribewidget-$subscribe_key");
//$wp_sidebar_widgets["footer1"] = array("widget_isocialize-$isocialize_key");

/* footer widget 1 EOF*/

/* footer widget 2 BOF*/

$archives_info = array();
$archives_info = get_option('widget_hybrid-archives');
$archives_info[5] = array(
					"title"				=>	'Archives',
					"format"			=>	'html'
					);
$archives_info['_multiwidget'] = '1';

update_option('widget_hybrid-archives',$archives_info);
$archives_info = get_option('widget_hybrid-archives');
krsort($archives_info);
foreach($archives_info as $key1=>$val1)
{
	$archives_info_key1 = $key1;
	if(is_int($archives_info_key1))
	{
		break;
	}
}

$category_info = array();
$category_info = get_option('widget_hybrid-categories');
$category_info[5] = array(
					"title"				=>	'Categories',
					"count"				=>	'0',
					"hierarchical"		=>	'0',
					"dropdown"			=>	'0',
					"style"			=>	'list'
					);
$category_info['_multiwidget'] = '1';

update_option('widget_hybrid-categories',$category_info);
$category_info = get_option('widget_hybrid-categories');
krsort($category_info);
foreach($category_info as $key1=>$val1)
{
	$category_info_key1 = $key1;
	if(is_int($category_info_key1))
	{
		break;
	}
}
$pages_info = array();
$pages_info = get_option('widget_hybrid-pages');
$pages_info[5] = array(
					"title"				=>	'Pages',

					);
$pages_info['_multiwidget'] = '1';

update_option('widget_hybrid-pages',$pages_info);
$pages_info = get_option('widget_hybrid-pages');
krsort($pages_info);
foreach($pages_info as $key1=>$val1)
{
	$pages_info_key1 = $key1;
	if(is_int($pages_info_key1))
	{
		break;
	}
}

$links_comments_info = array();
$links_comments_info = get_option('widget_meta');
$links_comments_info[1] = array('' => '');
$links_comments_info['_multiwidget'] = '1';
update_option('widget_meta',$links_comments_info);
$links_comments_info = get_option('widget_meta');
krsort($links_comments_info);
foreach($links_comments_info as $key1=>$val1)
{
	$links_info_key = $key1;
	if(is_int($links_info_key))
	{
		break;
	}
}

$sidebars_widgets["footer2"] = array("hybrid-archives-$archives_info_key1","hybrid-categories-$category_info_key1","hybrid-pages-$pages_info_key1","meta-$links_info_key");
/* footer widget2 EOF*/


//===============================================================================
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
update_option("ptthemes_bottom_options",'Two Column - Left(one third)'); 
update_option("ptthemes_listing_comment",'Yes'); 
update_option("ptthemes_listing_author",'Yes'); 
update_option("ptthemes_authorbox",'Show'); 
update_option("ptthemes_floating_social_sharing_button",'Yes'); 
update_option("ptthemes_breadcrumbs",'No'); 
update_option("ptthemes_main_pages_nav_enable",'Activate'); 
update_option("ptthemes_default_nav_enable",'Activate'); 
update_option("ptthemes_switchview",'list'); 
update_option("ptthemes_authorbox",'Hide'); 
/////////////// WIDGET SETTINGS END /////////////


if($_REQUEST['dump']==1){
echo "<script type='text/javascript'>";
echo "window.location.href='".get_option('siteurl')."/wp-admin/themes.php?dummy_insert=1'";
echo "</script>";
}
/////////////// Design Settings END ///////////////
/* ======================== CODE TO ADD RESIZED IMAGES ======================= */
regenerate_all_attachment_sizes();
 
function regenerate_all_attachment_sizes() {
	$args = array( 'post_type' => 'attachment', 'numberposts' => 100, 'post_status' => 'inherit'); 
	$attachments = get_posts( $args );
	if ($attachments) {
		foreach ( $attachments as $post ) {
			$file = get_attached_file( $post->ID );
			wp_update_attachment_metadata( $post->ID, wp_generate_attachment_metadata( $post->ID, $file ) );
		}
	}		
}

?>