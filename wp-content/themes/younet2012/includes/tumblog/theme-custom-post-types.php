<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- WooThemes WooTumblog Custom Post Type Class
- WooThemes WooTumblog Create Initial Taxonomy Terms
- WooThemes WooTumblog Custom Post Type Filters
- WooThemes WooTumblog Taxonomy Search Functions

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* WooThemes WooTumblog Custom Post Type Class */
/*-----------------------------------------------------------------------------------*/

class WooTumblog {
	
	function WooTumblog()
	{
		
		// Register custom taxonomy
		register_taxonomy(	"tumblog", 
							array(	"post"	), 
							array (	"hierarchical" 		=> true, 
									"label" 			=> "Tumblogs", 
									'labels' 			=> array(	'name' 				=> __('Tumblogs'),
																	'singular_name' 	=> __('Tumblog'),
																	'search_items' 		=> __('Search Tumblogs'),
																	'popular_items' 	=> __('Popular Tumblogs'),
																	'all_items' 		=> __('All Tumblogs'),
																	'parent_item' 		=> __('Parent Tumblog'),
																	'parent_item_colon' => __('Parent Tumblog:'),
																	'edit_item' 		=> __('Edit Tumblog'),
																	'update_item'		=> __('Update Tumblog'),
																	'add_new_item' 		=> __('Add New Tumblog'),
																	'new_item_name' 	=> __('New Tumblog Name')	), 
									'public' 			=> true,
									'show_ui' 			=> true,
									"rewrite" 			=> true	)
							);
		
	}
	
	//create initial taxonomy terms
	function woo_tumblog_create_initial_taxonomy_terms() {
		
		$tumblog_items = array(	'articles'	=> 'Articles',
								'images' 	=> 'Images',
								'audio' 	=> 'Audio',
								'video' 	=> 'Video',
								'quotes'	=> 'Quotes',
								'links' 	=> 'Links'
								);
		$taxonomy = 'tumblog';
		//loop and create terms
		foreach ($tumblog_items as $key => $value) {
			$id = term_exists($key, $taxonomy);
			if ($id > 0) {
		
			} else {
				$term = wp_insert_term($value, $taxonomy);
				update_option('woo_'.$key.'_term_id',$term['term_id']);
			}
		}
		
	}
	
}

//include taxonomies only if upgrade is complete
if (get_option('tumblog_woo_tumblog_upgraded') == 'true') {
	// Initiate the plugin
	add_action("init", "WooTumblogInit");
	function WooTumblogInit() { 
		global $woo_tumblog_cpt; 
		$woo_tumblog_cpt = new WooTumblog(); 
		$woo_tumblog_cpt->woo_tumblog_create_initial_taxonomy_terms(); 
		if (get_option('tumblog_woo_tumblog_upgraded_posts_done') != 'true') {
			if (function_exists('woo_upgrade_existing_tumblog_posts')) {
				$upgraded = woo_upgrade_existing_tumblog_posts();
			} else {
				$upgraded = false;
			}
		} else {
			$upgraded = false;
		}
		
		if ($upgraded) {
			update_option('tumblog_woo_tumblog_upgraded_posts_done', 'true');
		}
	}
		
	/*-----------------------------------------------------------------------------------*/
	/* WooThemes WooTumblog Custom Post Type Filters */
	/*-----------------------------------------------------------------------------------*/
	
	// Custom Taxonomy Filters
	if (is_admin()) {
		if ( isset($_GET['post_type']) ) {
			$post_type = $_GET['post_type'];
		}
		else {
			$post_type = 'post';
		}
	
		if ( $post_type == 'post' ) {
			add_action('restrict_manage_posts', 'woo_tumblog_restrict_manage_posts');
			add_filter('posts_where', 'woo_tumblog_posts_where');
		}
	}
}
// The drop down with filter
function woo_tumblog_restrict_manage_posts() {
    ?>
        
            <fieldset>
            <?php
				//Tumblogs
				$category_ID = $_GET['tumblog_names'];
            	if ($category_ID > 0) {
            		//Do nothing
            	} else {
            		$category_ID = 0;
            	}
            	$dropdown_options = array	(	
            								'show_option_all'	=> __('View all Tumblogs'), 
            								'hide_empty' 		=> 0, 
            								'hide_if_empty'		=> 1,
            								'hierarchical' 		=> 1,
											'show_count' 		=> 0, 
											'orderby' 			=> 'name',
											'name' 				=> 'tumblog_names',
											'id' 				=> 'tumblog_names',
											'taxonomy' 			=> 'tumblog', 
											'selected' 			=> $category_ID
											);
				wp_dropdown_categories($dropdown_options);
            ?>
            <input type="submit" name="submit" value="<?php _e('Filter') ?>" class="button" />
        </fieldset>
        
    <?php
}

// Custom Query to filter edit grid
function woo_tumblog_posts_where($where) {
    if( is_admin() ) {
        global $wpdb;
        $tumblog_ID = $_GET['tumblog_names'];
		if ( ($tumblog_ID > 0) ) {

			$tumblog_tax_names =  &get_term( $tumblog_ID, 'tumblog' );
			$string_post_ids = '';
 			//tumblogs
			if ($tumblog_ID > 0) {
				$tumblog_tax_name = $tumblog_tax_names->slug;
				$tumblog_myposts = get_posts('nopaging=true&tumblog='.$tumblog_tax_name);
				foreach($tumblog_myposts as $post) {
					$string_post_ids .= $post->ID.',';
				}
			}
			
 			$string_post_ids = chop($string_post_ids,',');
   			$where .= "AND ID IN (" . $string_post_ids . ")";
		}
    }
    return $where;
}

/*-----------------------------------------------------------------------------------*/
/* WooThemes WooTumblog Taxonomy Search Functions */
/*-----------------------------------------------------------------------------------*/

//search taxonomies for a match against a search term and returns array of success count
function woo_taxonomy_matches($term_name, $term_id, $post_id = 0, $keyword_to_search = '') {
	$return_array = array();
	$return_array['success'] = false;
	$return_array['keywordcount'] = 0;
	$terms = get_the_terms( $post_id , $term_name );
	$success = false;
	$keyword_count = 0;
	if ($term_id == 0) {
		$success = true;
	}
	$counter = 0;
	// Loop over each item
	if ($terms) {
		foreach( $terms as $term ) {

			if ($term->term_id == $term_id) {
				$success = true;
			}
			if ( $keyword_to_search != '' ) {
				$keyword_count = substr_count( strtolower( $term->name ) , strtolower( $keyword_to_search ) );
				if ( $keyword_count > 0 ) {
					$success = true;
					$counter++;
				}
			}
		}
	}
	$return_array['success'] = $success;
	if ($counter == 0) {
		$return_array['keywordcount'] = $keyword_count;
	} else { 
		$return_array['keywordcount'] = $counter;
	}
	
	return $return_array;
}

?>