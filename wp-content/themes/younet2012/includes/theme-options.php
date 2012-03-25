<?php

if (!function_exists( 'woo_options')) {
function woo_options() {
	
// THEME VARIABLES
$themename = "Briefed";
$themeslug = "briefed";

// STANDARD VARIABLES
$manualurl = 'http://www.woothemes.com/support/theme-documentation/'.$themeslug.'/';
$shortname = "woo";

//Access the WordPress Categories via an Array
$woo_categories = array();  
$woo_categories_obj = get_categories( 'hide_empty=0' );
foreach ($woo_categories_obj as $woo_cat) {
    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
$categories_tmp = array_unshift($woo_categories, "Select a category:" );    
       
//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );    
$woo_pages[0] = "Select a page:";
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//URL Shorteners
if (_iscurlinstalled()) {
	$options_select = array("Off","TinyURL","Bit.ly");
	$short_url_msg = 'Select the URL shortening service you would like to use.'; 
} else {
	$options_select = array("Off");
	$short_url_msg = '<strong>cURL was not detected on your server, and is required in order to use the URL shortening services.</strong>'; 
}

//Stylesheets Reader
$alt_stylesheet_path = get_template_directory() . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$other_entries = array( "Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19" );

// THIS IS THE DIFFERENT FIELDS
$options = array();   

/* General */

$options[] = array( "name" => "General Settings",
					"type" => "heading",
					"icon" => "general" );
                        
	$options[] = array( "name" => "Theme Stylesheet",
						"desc" => "Select your themes alternative color scheme.",
						"id" => $shortname."_alt_stylesheet",
						"std" => "default.css",
						"type" => "select",
						"options" => $alt_stylesheets);
	
	$options[] = array( "name" => "Custom Logo",
						"desc" => "Upload a logo for your theme, or specify an image URL directly.",
						"id" => $shortname."_logo",
						"std" => "",
						"type" => "upload" );    
	                                                                                     
	$options[] = array( "name" => "Text Title",
						"desc" => "Enable text-based Site Title and Tagline. Setup title & tagline in <a href='".home_url()."/wp-admin/options-general.php'>General Settings</a>.",
						"id" => $shortname."_texttitle",
						"std" => "false",
						"class" => "collapsed",
						"type" => "checkbox" );
	
	$options[] = array( "name" => "Site Title",
						"desc" => "Change the site title typography.",
						"id" => $shortname."_font_site_title",
						"std" => array( 'size' => '30','unit' => 'px','face' => 'Tinos','style' => 'bold','color' => '#333333'),
						"class" => "hidden",
						"type" => "typography" );  
	
	$options[] = array( "name" => "Site Description",
						"desc" => "Enable the site description/tagline under site title.",
						"id" => $shortname."_tagline",
						"class" => "hidden",
						"std" => "false",
						"type" => "checkbox" );
	
	$options[] = array( "name" => "Site Description",
						"desc" => "Change the site description typography.",
						"id" => $shortname."_font_tagline",
						"std" => array( 'size' => '12','unit' => 'px','face' => 'Tinos','style' => '','color' => '#999999'),
						"class" => "hidden last",
						"type" => "typography" );  
						          
	$options[] = array( "name" => "Custom Favicon",
						"desc" => "Upload a 16px x 16px <a href='http://www.faviconr.com/'>ico image</a> that will represent your website's favicon.",
						"id" => $shortname."_custom_favicon",
						"std" => "",
						"type" => "upload" ); 
	                                               
	$options[] = array( "name" => "Tracking Code",
						"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
						"id" => $shortname."_google_analytics",
						"std" => "",
						"type" => "textarea" );        
	
	$options[] = array( "name" => "RSS URL",
						"desc" => "Enter your preferred RSS URL. (Feedburner or other)",
						"id" => $shortname."_feed_url",
						"std" => "",
						"type" => "text" );
	                    
	$options[] = array( "name" => "E-Mail Subscription URL",
						"desc" => "Enter your preferred E-mail subscription URL. (Feedburner or other)",
						"id" => $shortname."_subscribe_email",
						"std" => "",
						"type" => "text" );
	
	$options[] = array( "name" => "Contact Form E-Mail",
						"desc" => "Enter your E-mail address to use on the Contact Form Page Template. Add the contact form by adding a new page and selecting 'Contact Form' as page template.",
						"id" => $shortname."_contactform_email",
						"std" => "",
						"type" => "text" );
	
	$options[] = array( "name" => "Custom CSS",
	                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
	                    "id" => $shortname."_custom_css",
	                    "std" => "",
	                    "type" => "textarea" );
	
	$options[] = array( "name" => "Post/Page Comments",
						"desc" => "Select if you want to enable/disable comments on posts and/or pages. ",
						"id" => $shortname."_comments",
						"type" => "select2",
						"options" => array( "post" => "Posts Only", "page" => "Pages Only", "both" => "Pages / Posts", "none" => "None") );                                                          
	    
	$options[] = array( "name" => "Post Content",
						"desc" => "Select if you want to show the full content or the excerpt on posts. ",
						"id" => $shortname."_post_content",
						"type" => "select2",
						"options" => array( "excerpt" => "The Excerpt", "content" => "Full Content" ) );                                                          
	
	$options[] = array( "name" => "Display Breadcrumbs",
						"desc" => "Display dynamic breadcrumbs on each page of your website.",
						"id" => $shortname."_breadcrumbs_show",
						"std" => "false",
						"type" => "checkbox" );
					
	$options[] = array( "name" => "Pagination Style",
						"desc" => "Select the style of pagination you would like to use on the blog.",
						"id" => $shortname."_pagination_type",
						"type" => "select2",
						"options" => array( "paginated_links" => "Numbers", "simple" => "Next/Previous" ) );

/* Styling */

$options[] = array( "name" => "Styling Options",
					"type" => "heading",
					"icon" => "styling" );   
					
	$options[] = array( "name" =>  "Body Background Color",
						"desc" => "Pick a custom color for background color of the theme e.g. #697e09",
						"id" => "woo_body_color",
						"std" => "",
						"type" => "color" );
						
	$options[] = array( "name" => "Body background image",
						"desc" => "Upload an image for the theme's background",
						"id" => $shortname."_body_img",
						"std" => "",
						"type" => "upload" );
						
	$options[] = array( "name" => "Background image repeat",
	                    "desc" => "Select how you would like to repeat the background-image",
	                    "id" => $shortname."_body_repeat",
	                    "std" => "no-repeat",
	                    "type" => "select",
	                    "options" => array( "no-repeat","repeat-x","repeat-y","repeat"));
	
	$options[] = array( "name" => "Background image position",
	                    "desc" => "Select how you would like to position the background",
	                    "id" => $shortname."_body_pos",
	                    "std" => "top",
	                    "type" => "select",
	                    "options" => array( "top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right"));
	
	$options[] = array( "name" =>  "Link Color",
						"desc" => "Pick a custom color for links or add a hex color code e.g. #697e09",
						"id" => "woo_link_color",
						"std" => "",
						"type" => "color" );   
	
	$options[] = array( "name" =>  "Link Hover Color",
						"desc" => "Pick a custom color for links hover or add a hex color code e.g. #697e09",
						"id" => "woo_link_hover_color",
						"std" => "",
						"type" => "color" );                    
	
	$options[] = array( "name" =>  "Button Color",
						"desc" => "Pick a custom color for buttons or add a hex color code e.g. #697e09",
						"id" => "woo_button_color",
						"std" => "",
						"type" => "color" );          

/* Typography */	
				
$options[] = array( "name" => "Typography",
					"type" => "heading",
					"icon" => "typography" );   

	$options[] = array( "name" => "Enable Custom Typography",
						"desc" => "Enable the use of custom typography for your site. Custom styling will be output in your sites HEAD.",
						"id" => $shortname."_typography",
						"std" => "false",
						"type" => "checkbox" ); 									   
	
	$options[] = array( "name" => "General Typography",
						"desc" => "Change the general font.",
						"id" => $shortname."_font_body",
						"std" => array( 'size' => '12','unit' => 'px','face' => 'Palatino','style' => '','color' => '#888888'),
						"type" => "typography" );  
	
	$options[] = array( "name" => "Navigation",
						"desc" => "Change the navigation font.",
						"id" => $shortname."_font_nav",
						"std" => array( 'size' => '13','unit' => 'px','face' => 'Palatino','style' => '','color' => '#777777'),
						"type" => "typography" );  

	$options[] = array( "name" => "About Text",
						"desc" => "Change the about section font.",
						"id" => $shortname."_font_about",
						"std" => array( 'size' => '29','unit' => 'px','face' => 'Palatino','style' => '','color' => '#222222'),
						"type" => "typography" );						
	
	$options[] = array( "name" => "Post Title",
						"desc" => "Change the post title.",
						"id" => $shortname."_font_post_title",
						"std" => array( 'size' => '30','unit' => 'px','face' => 'Six Caps','style' => 'bold','color' => '#222222'),
						"type" => "typography" );
						
	$options[] = array( "name" => "Post Date",
						"desc" => "Change the post date.",
						"id" => $shortname."_font_post_date",
						"std" => array( 'size' => '50','unit' => 'px','face' => 'Six Caps','style' => '','color' => '#888888'),
						"type" => "typography" );						  
	
	$options[] = array( "name" => "Post Meta",
						"desc" => "Change the post meta.",
						"id" => $shortname."_font_post_meta",
						"std" => array( 'size' => '12','unit' => 'px','face' => 'Palatino','style' => '','color' => '#888888'),
						"type" => "typography" );  
						          
	$options[] = array( "name" => "Post Entry",
						"desc" => "Change the post entry.",
						"id" => $shortname."_font_post_entry",
						"std" => array( 'size' => '13','unit' => 'px','face' => 'Palatino','style' => '','color' => '#888888'),
						"type" => "typography" );  
	
	$options[] = array( "name" => "Widget Titles",
						"desc" => "Change the widget titles.",
						"id" => $shortname."_font_widget_titles",
						"std" => array( 'size' => '24','unit' => 'px','face' => 'Six Caps','style' => 'bold','color' => '#222222'),
						"type" => "typography" );  

/* Layout */ 

$options[] = array( "name" => "Layout Options",
					"type" => "heading",
					"icon" => "layout" );   
					 					                   
	$url =  get_template_directory_uri() . '/functions/images/';
	$options[] = array( "name" => "Main Layout",
						"desc" => "Select which layout you want for your site.",
						"id" => $shortname."_site_layout",
						"std" => "layout-left-content",
						"type" => "images",
						"options" => array(
							'layout-left-content' => $url . '2cl.png',
							'layout-right-content' => $url . '2cr.png')
						); 		   
/* Homepage */

$options[] = array( "name" => "Homepage",
					"type" => "heading",
					"icon" => "homepage");

	$options[] = array( "name" => "Enable About Section",
						"desc" => "Show a welcome message in your header and add social media icons.",
						"id" => $shortname."_about",
						"std" => "true",
						"type" => "checkbox");
						    
	$options[] = array( "name" => "About Message",
						"desc" => "Enter an about message that will show just below the logo",
						"id" => $shortname."_header_bio",
						"std" => "Edit this welcome message in your options panel",
						"type" => "textarea");
						
	$options[] = array( "name" => "Email",
						"desc" => "Enter the url of your contact form e.g. /contact",
						"id" => $shortname."_social_email",
						"std" => "",
						"type" => "text");
								
	$options[] = array( "name" => "Facebook",
						"desc" => "Enter your profile url",
						"id" => $shortname."_social_facebook",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Twitter",
						"desc" => "Enter your profile url",
						"id" => $shortname."_social_twitter",
						"std" => "",
						"type" => "text");														

/* Slider */

$options[] = array( "name" => "Homepage Slider",
					"icon" => "slider",
					"type" => "heading");
					
	$options[] = array( "name" => "Enable Slider",
	                    "desc" => "Enable the slider on the homepage.",
	                    "id" => $shortname."_slider",
	                    "std" => "true",
	                    "type" => "checkbox");
	
	$options[] = array(    "name" => "Slider Entries",
	                    "desc" => "Select the number of entries that should appear in the home page slider.",
	                    "id" => $shortname."_slider_entries",
	                    "std" => "3",
	                    "type" => "select",
	                    "options" => $other_entries);
	
	$options[] = array( "name" => "Slider Tag",
                   		"desc" => "Add comma separated list for the tags that you would like to have displayed in the slider section on your homepage. For example, if you add 'tag1, tag3' here, then all portfolio posts tagged with either 'tag1' or 'tag3' will be shown in the slider area.",
                    	"id" => $shortname."_featured_tags",
                    	"std" => "",
                    	"type" => "text");
                    
	$options[] = array( "name" => "Effect",
						"desc" => "Select the animation effect. ",
						"id" => $shortname."_slider_effect",
						"type" => "select2",
						"options" => array("slide" => "Slide", "fade" => "Fade") );     
	
	$options[] = array( "name" => "Hover Pause",
	                    "desc" => "Hovering over slideshow will pause it",
	                    "id" => $shortname."_slider_hover",
	                    "std" => "false",
	                    "type" => "checkbox"); 
	
	$options[] = array( "name" => "Randomize",
	                    "desc" => "Select to randomize slides.",
	                    "id" => $shortname."_slider_random",
	                    "std" => "false",
	                    "type" => "checkbox"); 
	                    
	$options[] = array( "name" => "Animation Speed",
	                    "desc" => "The time in <b>seconds</b> the animation between frames will take.",
	                    "id" => $shortname."_slider_speed",
	                    "std" => "0.6",
						"type" => "select",
						"options" => array( '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0' ) );
	                    
	$options[] = array( "name" => "Fade Speed",
	                    "desc" => "The time in <b>seconds</b> the fade between frames will take.",
	                    "id" => $shortname."_fade_speed",
	                    "std" => "0.3",
						"type" => "select",
						"options" => array( '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0' ) );
	
	$options[] = array(    "name" => "Auto Start",
	                    "desc" => "Set the slider to start sliding automatically.",
	                    "id" => $shortname."_slider_auto",
	                    "std" => "false",
	                    "type" => "checkbox");   
	                    
	$options[] = array(    "name" => "Auto Slide Interval",
	                    "desc" => "The time in <b>seconds</b> each slide pauses for, before sliding to the next.",
	                    "id" => $shortname."_slider_interval",
	                    "std" => "6",
						"type" => "select",
						"options" => array( '1', '2', '3', '4', '5', '6', '7', '8', '9', '10' ) );
	                    
	$options[] = array( "name" => "Featured Slider Title",
						"desc" => "Show the post title in slider.",
						"id" => $shortname."_slider_title",
						"std" => "true",
						"type" => "checkbox");  
						
	$options[] = array( "name" => "Featured Slider Content",
						"desc" => "Show the post content in slider.",
						"id" => $shortname."_slider_content",
						"std" => "true",
						"type" => "checkbox"); 
						
                    
/* Portfolio */

$options[] = array( "name" => "Portfolio",
                    "icon" => "portfolio",
					"type" => "heading");    
					
	$options[] = array( "name" => "Enable Portfolio",
						"desc" => "Enable the portfolio section below the about section. Add portfolio posts using the 'Portfolio' custom post type.",
						"id" => $shortname."_portfolio",
						"std" => "true",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Number of portfolio items",
						"id" => $shortname."_portfolio_number",
						"std" => "4",
						"type" => "select",
						"options" => $other_entries);
						
	$options[] = array( "name" => "Portfolio Tags",
						"desc" => "Enter comma seperated tags for portfolio sorting (e.g. web, print, icons). You must add these tags to the portfolio items you want to sort.",
						"id" => $shortname."_portfolio_tags",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Show Only Items With Specified Tags",
						"desc" => "Set the 'Portfolio' page template to display only items that have been tagged with the tags specified in the 'Portfolio Tags' option.",
						"id" => $shortname."_portfolio_only_tagged",
						"std" => "false",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Enable Portfolio Title and Tagline",
						"desc" => "Show the portfolio headers on the homepage.",
						"id" => $shortname."_portfolio_panel_headers",
						"std" => "true",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Portfolio Title",
	                    "desc" => "Specify the default text for the Portfolio template's title",
	                    "id" => $shortname."_portfolio_title",
	                    "std" => "Portfolio",
	                    "type" => "text");
	
	$options[] = array( "name" => "Portfolio Tagline",
	                    "desc" => "Specify the default text for the Portfolio template's tagline",
	                    "id" => $shortname."_portfolio_tagline",
	                    "std" => "Letterpress, web and whatever else satisfies a desire to create",
	                    "type" => "text");										

/* Blog Panel */

$options[] = array( "name" => "Blog Panel",
					"icon" => "misc",
				    "type" => "heading");   
				    
	$options[] = array( "name" => "Enable Blog Panel on the homepage",
						"desc" => "Show the blog panel on the homepage.",
						"id" => $shortname."_blog_panel",
						"std" => "true",
						"type" => "checkbox"); 
	
	$options[] = array(	"name" => "Number of Blog Posts to display",
						"desc" => "The number of posts that will be displayed on the homepage",
						"id" => $shortname."_blog_number_of_posts",
						"std" => "3",
						"type" => "text");
	
	$options[] = array( "name" => "Enable Blog Panel Header and Description",
						"desc" => "Show the blog panel headers on the homepage.",
						"id" => $shortname."_blog_panel_headers",
						"std" => "true",
						"type" => "checkbox");
																
	$options[] = array(	"name" => "Blog Panel Header",
						"desc" => "This is the text that will be displayed on the homepage for the panel.",
						"id" => $shortname."_blog_panel_header",
						"std" => "Tumblog",
						"type" => "text");
	
	$options[] = array(	"name" => "Blog Panel Description",
						"desc" => "This is the text that will be displayed under the header on the homepage for the panel.",
						"id" => $shortname."_blog_panel_description",
						"std" => "Writings, musings and generally lighthearted banter",
						"type" => "text");

	$options[] = array( "name" => "Blog Page Template",
						"desc" => "Select the page that has the blog page template applied to.",
						"id" => $shortname."_blog_page_template",
						"std" => "Select a page:",
						"type" => "select2",
						"options" => $woo_pages);
					
/* Tumblog */

$options[] = array( "name" => "Tumblog Setup",
                    "icon" => "tumblog",
				    "type" => "heading");  

	$options[] = array( "name" => __( 'Tumblog Functionality', 'woothemes' ),
						"desc" => "",
						"id" => $shortname."_woo_tumblog_notice",
						"std" => sprintf( __( 'Tumblog will allow you to publish content using the WooTumblog functionality, including the Express for WordPress iPhone App. If you would like to use the iPhone app, you will need to enable XML-RPC publishing under Settings->Writing. Find out more at %s.', 'woothemes' ), '<a href="http://express-app.com/" target="_blank">Express-App.com</a>' ),
						"type" => "info");

	$options[] = array( "name" => __( 'Enable Tumblog Functionality', 'woothemes' ),
						"desc" => __( 'Enable Tumblog functionality in this theme.' ),
						"id" => $shortname."_woo_tumblog_switch",
						"std" => "false",
						"type" => "checkbox");
						
	$content_option_array = array( 	'taxonomy' 	=> 'Taxonomy',
									'post_format' => 'Post Formats'			
										);
	
	$options[] = array( "name" => "Tumblog Content Method",
						"desc" => "Select if you would like to use a Taxonomy of Post Formats to categorize your Tumblog content.",
						"id" => $shortname."_tumblog_content_method",
						"std" => "post_format",
						"type" => "select2",
						"options" => $content_option_array); 
						
	$options[] = array( "name" => "Use Custom Tumblog RSS Feed",
						"desc" => "Replaces the default WordPress RSS feed output with Tumblog RSS output.",
						"id" => $shortname."_custom_rss",
						"std" => "true",
						"type" => "checkbox"); 
	
	$options[] = array( "name" => "Blog Title",
	                    "desc" => "Specify the default text for the blog title",
	                    "id" => $shortname."_blog_title",
	                    "std" => "Tumblog",
	                    "type" => "text");
	
	$options[] = array( "name" => "Blog Tagline",
	                    "desc" => "Specify the default text for the blog tagline",
	                    "id" => $shortname."_blog_tagline",
	                    "std" => "Writings, musings and generally lighthearted banter",
	                    "type" => "text");
						
	$options[] = array( "name" => "Full Content Home",
						"desc" => "Show the full content in posts on homepage instead of the excerpt.",
						"id" => $shortname."_home_content",
						"std" => "false",
						"type" => "checkbox");    
	
	$options[] = array( "name" => "Full Content Archive",
						"desc" => "Show the full content in posts on archive pages instead of the excerpt.",
						"id" => $shortname."_archive_content",
						"std" => "false",
						"type" => "checkbox");
	 				     					
	
	$options[] = array( "name" => "Images Link to",
						"desc" => "Select where your Tumblog Images will link to when clicked.",
						"id" => $shortname."_image_link_to",
						"std" => "post",
						"type" => "radio",
						"options" => $options_image_link_to); 	
	
	//Failsafe for image dimension settings
	if ( get_option($shortname.'_tumblog_thumb_w') == '' ) { update_option($shortname.'_tumblog_thumb_w', 580); }
	if ( get_option($shortname.'_tumblog_single_w') == '' ) { update_option($shortname.'_tumblog_single_w', 580); }
	
	$options[] = array( "name" => "Tumblog Thumbnail Image Dimensions",
						"desc" => "Enter an integer value i.e. 250 for the desired size which will be used when showing images in Tumblog Image Posts.",
						"id" => $shortname."_tumblog_image_dimensions",
						"std" => "",
						"type" => array( 
										array(  'id' => $shortname. '_tumblog_thumb_w',
												'type' => 'text',
												'std' => 580,
												'meta' => 'Width'),
										array(  'id' => $shortname. '_tumblog_thumb_h',
												'type' => 'text',
												'std' => '',
												'meta' => 'Height')
									  ));				
	
	$options[] = array( "name" => "Tumblog Single Image Dimensions",
						"desc" => "Enter an integer value i.e. 250 for the tumblog single post image size. Max width is 580.",
						"id" => $shortname."_tumblog_image_dimensions",
						"std" => "",
						"type" => array( 
										array(  'id' => $shortname. '_tumblog_single_w',
												'type' => 'text',
												'std' => 580,
												'meta' => 'Width'),
										array(  'id' => $shortname. '_tumblog_single_h',
												'type' => 'text',
												'std' => '',
												'meta' => 'Height')
									  ));
									  
	$options[] = array( "name" => "URL Shortening Service",
						"desc" => $short_url_msg,
						"id" => $shortname."_url_shorten",
						"std" => "Select a Service:",
						"type" => "select",
						"options" => $options_select);
	
	$options[] = array( "name" => "Bit.ly Login Name",
						"desc" => "Your Bit.ly login name - get this here <a href='http://bit.ly/account/' target='_blank'>http://bit.ly/account/</a>",
						"id" => $shortname."_bitly_api_login",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Bit.ly API Key",
						"desc" => "Your Bit.ly API Key - get this here <a href='http://bit.ly/account/' target='_blank'>http://bit.ly/account/</a>",
						"id" => $shortname."_bitly_api_key",
						"std" => "",
						"type" => "text");

/* Dynamic Images */

$options[] = array( "name" => "Dynamic Images",
					"type" => "heading",
					"icon" => "image" );    
				    				   
	$options[] = array( "name" => "WP Post Thumbnail",
						"desc" => "Use WordPress post thumbnail to assign a post thumbnail.",
						"id" => $shortname."_post_image_support",
						"std" => "true",
						"class" => "collapsed",
						"type" => "checkbox" ); 
	
	$options[] = array( "name" => "WP Post Thumbnail - Dynamically Resize",
						"desc" => "The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>",
						"id" => $shortname."_pis_resize",
						"std" => "true",
						"class" => "hidden",
						"type" => "checkbox" ); 									   
						
	$options[] = array( "name" => "WP Post Thumbnail - Hard Crop",
						"desc" => "The image will be cropped to match the target aspect ratio.",
						"id" => $shortname."_pis_hard_crop",
						"std" => "true",
						"class" => "hidden last",
						"type" => "checkbox" ); 									   
	
	$options[] = array( "name" => "Enable Dynamic Image Resizer",
						"desc" => "This will enable the thumb.php script which dynamically resizes images added through post custom field.",
						"id" => $shortname."_resize",
						"std" => "true",
						"type" => "checkbox" );    
	                    
	$options[] = array( "name" => "Automatic Image Thumbs",
						"desc" => "If no image is specified in the 'image' custom field or WP post thumbnail then the first uploaded post image is used.",
						"id" => $shortname."_auto_img",
						"std" => "false",
						"type" => "checkbox" );    
	
	$options[] = array( "name" => "Thumbnail Image Dimensions",
						"desc" => "Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.",
						"id" => $shortname."_image_dimensions",
						"std" => "",
						"type" => array( 
										array(  'id' => $shortname. '_thumb_w',
												'type' => 'text',
												'std' => 100,
												'meta' => 'Width'),
										array(  'id' => $shortname. '_thumb_h',
												'type' => 'text',
												'std' => 100,
												'meta' => 'Height')
									  ));
	                                                                                                
	$options[] = array( "name" => "Thumbnail Image alignment",
						"desc" => "Select how to align your thumbnails with posts.",
						"id" => $shortname."_thumb_align",
						"std" => "alignleft",
						"type" => "radio",
						"options" => array( "alignleft" => "Left","alignright" => "Right","aligncenter" => "Center")); 
	
	$options[] = array( "name" => "Show thumbnail in Single Posts",
						"desc" => "Show the attached image in the single post page.",
						"id" => $shortname."_thumb_single",
						"class" => "collapsed",
						"std" => "true",
						"type" => "checkbox" );    
	
	$options[] = array( "name" => "Single Image Dimensions",
						"desc" => "Enter an integer value i.e. 250 for the image size. Max width is 576.",
						"id" => $shortname."_image_dimensions",
						"std" => "",
						"class" => "hidden last",
						"type" => array( 
										array(  'id' => $shortname. '_single_w',
												'type' => 'text',
												'std' => 200,
												'meta' => 'Width'),
										array(  'id' => $shortname. '_single_h',
												'type' => 'text',
												'std' => 200,
												'meta' => 'Height')
									  ));
	
	$options[] = array( "name" => "Single Post Image alignment",
						"desc" => "Select how to align your thumbnail with single posts.",
						"id" => $shortname."_thumb_single_align",
						"std" => "alignright",
						"type" => "radio",
						"class" => "hidden",
						"options" => array( "alignleft" => "Left","alignright" => "Right","aligncenter" => "Center")); 
	
	$options[] = array( "name" => "Add thumbnail to RSS feed",
						"desc" => "Add the the image uploaded via your Custom Settings to your RSS feed",
						"id" => $shortname."_rss_thumb",
						"std" => "false",
						"type" => "checkbox" );  
					
/* Footer */

$options[] = array( "name" => "Footer Customization",
					"type" => "heading",
					"icon" => "footer" );    
					

	$url =  get_template_directory_uri() . '/functions/images/';
	$options[] = array( "name" => "Footer Widget Areas",
						"desc" => "Select how many footer widget areas you want to display.",
						"id" => $shortname."_footer_sidebars",
						"std" => "3",
						"type" => "images",
						"options" => array(
							'0' => $url . 'layout-off.png',
							'1' => $url . 'footer-widgets-1.png',
							'2' => $url . 'footer-widgets-2.png',
							'3' => $url . 'footer-widgets-3.png',
							'4' => $url . 'footer-widgets-4.png')
						); 		   
											
	$options[] = array( "name" => "Custom Affiliate Link",
						"desc" => "Add an affiliate link to the WooThemes logo in the footer of the theme.",
						"id" => $shortname."_footer_aff_link",
						"std" => "",
						"type" => "text" );	
										
	$options[] = array( "name" => "Enable Custom Footer (Left)",
						"desc" => "Activate to add the custom text below to the theme footer.",
						"id" => $shortname."_footer_left",
						"std" => "false",
						"type" => "checkbox" );    
	
	$options[] = array( "name" => "Custom Text (Left)",
						"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
						"id" => $shortname."_footer_left_text",
						"std" => "",
						"type" => "textarea" );
							
	$options[] = array( "name" => "Enable Custom Footer (Right)",
						"desc" => "Activate to add the custom text below to the theme footer.",
						"id" => $shortname."_footer_right",
						"std" => "false",
						"type" => "checkbox" );    
	
	$options[] = array( "name" => "Custom Text (Right)",
						"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
						"id" => $shortname."_footer_right_text",
						"std" => "",
						"type" => "textarea" );
			
/* Advertising */

$options[] = array( "name" => "Top Ad (468x60px)",
					"type" => "heading",
					"icon" => "ads" );    

	$options[] = array( "name" => "Enable Ad",
						"desc" => "Enable the ad space",
						"id" => $shortname."_ad_top",
						"std" => "false",
						"type" => "checkbox" );    
	
	$options[] = array( "name" => "Adsense code",
						"desc" => "Enter your adsense code (or other ad network code) here.",
						"id" => $shortname."_ad_top_adsense",
						"std" => "",
						"type" => "textarea" );
	
	$options[] = array( "name" => "Image Location",
						"desc" => "Enter the URL to the banner ad image location.",
						"id" => $shortname."_ad_top_image",
						"std" => "http://www.woothemes.com/ads/468x60b.jpg",
						"type" => "upload" );
						
	$options[] = array( "name" => "Destination URL",
						"desc" => "Enter the URL where this banner ad points to.",
						"id" => $shortname."_ad_top_url",
						"std" => "http://www.woothemes.com",
						"type" => "text" );                        

/* Subscribe & Connect */
$options[] = array( "name" => "Subscribe & Connect",
					"type" => "heading",
					"icon" => "connect" ); 

$options[] = array( "name" => "Enable Subscribe & Connect - Single Post",
					"desc" => "Enable the subscribe & connect area on single posts. You can also add this as a <a href='".home_url()."/wp-admin/widgets.php'>widget</a> in your sidebar.",
					"id" => $shortname."_connect",
					"std" => 'false',
					"type" => "checkbox" ); 

$options[] = array( "name" => "Subscribe Title",
					"desc" => "Enter the title to show in your subscribe & connect area.",
					"id" => $shortname."_connect_title",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => "Text",
					"desc" => "Change the default text in this area.",
					"id" => $shortname."_connect_content",
					"std" => '',
					"type" => "textarea" ); 

$options[] = array( "name" => "Subscribe By E-mail ID (Feedburner)",
					"desc" => "Enter your <a href='http://www.google.com/support/feedburner/bin/answer.py?hl=en&answer=78982'>Feedburner ID</a> for the e-mail subscription form.",
					"id" => $shortname."_connect_newsletter_id",
					"std" => '',
					"type" => "text" );

$options[] = array( "name" => 'Subscribe By E-mail to MailChimp', 'woothemes',
					"desc" => 'If you have a MailChimp account you can enter the <a href="http://woochimp.heroku.com" target="_blank">MailChimp List Subscribe URL</a> to allow your users to subscribe to a MailChimp List.',
					"id" => $shortname."_connect_mailchimp_list_url",
					"std" => '',
					"type" => "text");

$options[] = array( "name" => "Enable RSS",
					"desc" => "Enable the subscribe and RSS icon.",
					"id" => $shortname."_connect_rss",
					"std" => 'true',
					"type" => "checkbox" ); 

$options[] = array( "name" => "Twitter URL",
					"desc" => "Enter your  <a href='http://www.twitter.com/'>Twitter</a> URL e.g. http://www.twitter.com/woothemes",
					"id" => $shortname."_connect_twitter",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => "Facebook URL",
					"desc" => "Enter your  <a href='http://www.facebook.com/'>Facebook</a> URL e.g. http://www.facebook.com/woothemes",
					"id" => $shortname."_connect_facebook",
					"std" => '',
					"type" => "text" ); 
					
$options[] = array( "name" => "YouTube URL",
					"desc" => "Enter your  <a href='http://www.youtube.com/'>YouTube</a> URL e.g. http://www.youtube.com/woothemes",
					"id" => $shortname."_connect_youtube",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => "Flickr URL",
					"desc" => "Enter your  <a href='http://www.flickr.com/'>Flickr</a> URL e.g. http://www.flickr.com/woothemes",
					"id" => $shortname."_connect_flickr",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => "LinkedIn URL",
					"desc" => "Enter your  <a href='http://www.www.linkedin.com.com/'>LinkedIn</a> URL e.g. http://www.linkedin.com/in/woothemes",
					"id" => $shortname."_connect_linkedin",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => "Delicious URL",
					"desc" => "Enter your <a href='http://www.delicious.com/'>Delicious</a> URL e.g. http://www.delicious.com/woothemes",
					"id" => $shortname."_connect_delicious",
					"std" => '',
					"type" => "text" ); 

$options[] = array( "name" => "Google+ URL",
					"desc" => "Enter your <a href='http://plus.google.com/'>Google+</a> URL e.g. https://plus.google.com/104560124403688998123/",
					"id" => $shortname."_connect_googleplus",
					"std" => '',
					"type" => "text" );

$options[] = array( "name" => "Enable Related Posts",
					"desc" => "Enable related posts in the subscribe area. Uses posts with the same <strong>tags</strong> to find related posts. Note: Will not show in the Subscribe widget.",
					"id" => $shortname."_connect_related",
					"std" => 'true',
					"type" => "checkbox" ); 
					                                              
// Add extra options through function
if ( function_exists( "woo_options_add") )
	$options = woo_options_add($options);

if ( get_option( 'woo_template') != $options) update_option( 'woo_template',$options);      
if ( get_option( 'woo_themename') != $themename) update_option( 'woo_themename',$themename);   
if ( get_option( 'woo_shortname') != $shortname) update_option( 'woo_shortname',$shortname);
if ( get_option( 'woo_manual') != $manualurl) update_option( 'woo_manual',$manualurl);

// Woo Metabox Options
// Start name with underscore to hide custom key from the user
$woo_metaboxes = array();

global $post;

if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {

$woo_metaboxes[] = array (	
            "name" => "image",
            "label" => "Image",
            "type" => "upload",
            "desc" => "Upload file here..."
        );
$woo_metaboxes[] = array (	
            "name" => "video-embed",
            "label" => "Embed Code (Videos)",
            "type" => "textarea",
            "desc" => "Add embed code for video services like Youtube or Vimeo"
        );
$woo_metaboxes[] = array (	
            "name"  => "quote-author",
            "std"  => "Unknown",
            "label" => "Quote Author",
            "type" => "text",
            "desc" => "Enter the name of the Quote Author."
        );
$woo_metaboxes[] = array (	
            "name"  => "quote-url",
            "std"  => "http://",
            "label" => "Link to Quote",
            "type" => "text",
            "desc" => "Enter the url/web address of the Quote if available."
        );
$woo_metaboxes[] = array (	
            "name"  => "quote-copy",
            "std"  => "Unknown",
            "label" => "Quote",
            "type" => "textarea",
            "desc" => "Enter the Quote."
        );
$woo_metaboxes[] = array (	
            "name"  => "audio",
            "std"  => "http://",
            "label" => "Audio URL",
            "type" => "text",
            "desc" => "Enter the url/web address of the Audio file."
        );
$woo_metaboxes[] = array (	
            "name"  => "link-url",
            "std"  => "http://",
            "label" => "Link URL",
            "type" => "text",
            "desc" => "Enter the url/web address of the Link."
        );
					              
} // End post

if ( get_post_type() == 'portfolio' || !get_post_type() ) {

	$woo_metaboxes[] = array (	"name" => "portfolio-image",
								"label" => "Portfolio Image",
								"type" => "upload",
								"desc" => "Upload an image or enter an URL to your portfolio image");
								
	if ( get_option('woo_resize') == "true" ) {						
		$woo_metaboxes[] = array (	"name" => "_image_alignment",
									"std" => "Center",
									"label" => "Image Crop Alignment",
									"type" => "select2",
									"desc" => "Select crop alignment for resized image",
									"options" => array(	"c" => "Center",
														"t" => "Top",
														"b" => "Bottom",
														"l" => "Left",
														"r" => "Right"));
}

	$woo_metaboxes[] = array (  "name"  => "embed",
					            "std"  => "",
					            "label" => "Video Embed Code",
					            "type" => "textarea",
					            "desc" => "Enter the video embed code for your video (YouTube, Vimeo or similar). Will show instead of your image.");
}

// Add extra metaboxes through function
if ( function_exists( "woo_metaboxes_add") )
	$woo_metaboxes = woo_metaboxes_add($woo_metaboxes);
    
if ( get_option( 'woo_custom_template') != $woo_metaboxes) update_option( 'woo_custom_template',$woo_metaboxes);      

} // END woo_options()
} // END function_exists()

// Add options to admin_head
add_action( 'admin_head','woo_options' );  

//Enable WooSEO on these custom Post types
$seo_post_types = array( 'post','page' );
define( "SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action( 'init','woo_global_options' );
function woo_global_options(){
	// Populate WooThemes option in array for use in theme
	global $woo_options, $portfolio_exclude;
	$woo_options = get_option( 'woo_options' );
	$portfolio_exclude = '';
}

?>