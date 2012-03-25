<?php

/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// Set path to WooFramework and theme specific functions
$functions_path = get_template_directory() . '/functions/';
$includes_path = get_template_directory() . '/includes/';

if (get_option('woo_woo_tumblog_switch') == 'true') {

	//Enable Tumblog Functionality and theme is upgraded
	if ( !get_option('woo_needs_tumblog_upgrade') ) 
		update_option('woo_needs_tumblog_upgrade', 'false');
	if ( !get_option('tumblog_woo_tumblog_upgraded') ) 
		update_option('tumblog_woo_tumblog_upgraded', 'true');
	if ( !get_option('tumblog_woo_tumblog_upgraded_posts_done') ) 
		update_option('tumblog_woo_tumblog_upgraded_posts_done', 'true');

}

// WooFramework
require_once ($functions_path . 'admin-init.php' );			// Framework Init
if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {
	require_once ( $functions_path . 'admin-tumblog-quickpress.php' );	// Tumblog Dashboard Functionality
}

// Theme specific functionality
require_once ($includes_path . 'theme-options.php' ); 		// Options panel settings and custom settings
require_once ($includes_path . 'theme-functions.php' ); 		// Custom theme functions
require_once ($includes_path . 'theme-plugins.php' );		// Theme specific plugins integrated in a theme
require_once ($includes_path . 'theme-actions.php' );		// Theme actions & user defined hooks
require_once ($includes_path . 'theme-comments.php' ); 		// Custom comments/pingback loop
require_once ($includes_path . 'theme-js.php' );				// Load javascript in wp_head
require_once ($includes_path . 'sidebar-init.php' );			// Initialize widgetized areas
require_once ($includes_path . 'theme-widgets.php' );		// Theme widgets

if (get_option('woo_woo_tumblog_switch') == 'true') {

	require_once ($includes_path . 'tumblog/theme-tumblog.php');		// Tumblog Output Functions
	// Test for Post Formats
	if (get_option('woo_tumblog_content_method') == 'post_format') {
		// Tumblog Post Format Class
		require_once( $includes_path . 'tumblog/wootumblog_postformat.class.php' );
	} else {
		// Tumblog Custom Taxonomy Class
		require_once ($includes_path . 'tumblog/theme-custom-post-types.php');	// Custom Post Types and Taxonomies
	}
	
	// Test for Post Formats
	if (get_option('woo_tumblog_content_method') == 'post_format') {
	    //Tumblog Post Formats
	    global $woo_tumblog_post_format; 
	    $woo_tumblog_post_format = new WooTumblogPostFormat(); 
	    if ( $woo_tumblog_post_format->woo_tumblog_upgrade_existing_taxonomy_posts_to_post_formats()) {
	    	update_option('woo_tumblog_post_formats_upgraded','true');
	    }
	    
	}

}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

function excerpt_read_more_link($output) {
 global $post;
 return string_limit_words($output, 15);
}
add_filter('get_the_excerpt', 'excerpt_read_more_link');

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');







/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>