<?php 
/**
 * Woothemes Tumblog Functionality
 * FrontEnd
 *
 * @version 2.0.0
 *
 * @package WooFramework
 * @subpackage Tumblog
 */
 
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- ReTweet Button
- Tumblog - Category Link
- Tumblog Posts Output
-- Default
-- Articles
-- Videos
-- Images
-- Links
-- Quotes
-- Audio
- Tumblog Feed

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Retweet Counter */
/*-----------------------------------------------------------------------------------*/

function tweetButton($url, $title = 'Read this Post') {
	$maxTitleLength = 140 - (strlen($url)+1);
	if (strlen($title) > $maxTitleLength) {
		$title = substr($title, 0, ($maxTitleLength-3)).'...';
	}
	$url = woo_short_url($url);
	$output = $title.' '.$url;
	$tweet_link = 'http://twitter.com/home?status='.urlencode($output);
	//Output button
	echo '<a href="'.$tweet_link.'" title="'. __('On Twitter', 'woothemes') .'" target="_blank">'. __('On Twitter', 'woothemes') .'</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Tumblog - Category Link */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_category_link($post_id = 0, $type = 'articles') {

	$category_link = '';
	
	if (get_option('woo_tumblog_content_method') == 'post_format') {
		
		$post_format = get_post_format();
		if ($post_format == '') { 
			$category = get_the_category(); 
			$category_name = $category[0]->cat_name;
			// Get the ID of a given category
   			$category_id = get_cat_ID( $category_name );
    		// Get the URL of this category
    		$category_link = get_category_link( $category_id );
		} else {
			$category_link = get_post_format_link( $post_format );
    	}
    	
	} else {
		$tumblog_list = get_the_term_list( $post_id, 'tumblog', '' , '|' , ''  );
		$tumblog_array = explode('|', $tumblog_list);
		?>
		<?php $tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
										'images' 	=> get_option('woo_images_term_id'),
										'audio' 	=> get_option('woo_audio_term_id'),
										'video' 	=> get_option('woo_video_term_id'),
										'quotes'	=> get_option('woo_quotes_term_id'),
										'links' 	=> get_option('woo_links_term_id')
									);
		?>
		<?php
    	// Get the ID of Tumblog Taxonomy
    	$category_id = $tumblog_items[$type];
    	$term = &get_term($category_id, 'tumblog');
    	// Get the URL of Articles Tumblog Taxonomy
    	$category_link = get_term_link( $term, 'tumblog' );
    }

	return $category_link;
}

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Default */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_default( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'articles');
    ?>

	<div class="post">
	
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-text.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">
	    
	    <?php if (is_singular()) { ?>
	    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	    <?php } ?>
	    
	    <?php if ( ( ( is_single() ) && ( get_option( 'woo_thumb_single' ) == 'true' ) ) || ( is_home() || is_front_page() || is_archive() || is_search() ) ) { ?>
        <div class="media">
        	<?php $align_class = get_option( 'woo_thumb_align' ); ?>
    	    <?php if ( is_single() ) { $width = get_option( 'woo_single_w' ); $height = get_option( 'woo_single_h' ); } else { $width = get_option( 'woo_thumb_w' ); $height = get_option( 'woo_thumb_h' ); }   ?>
    	    <?php if ( get_option( 'woo_dynamic_img_height' ) != 'true' ) { $height = '&height='.$height; } else { $height = ''; } ?>
    	    <?php if ( get_option( 'woo_image_link_to' ) == 'image' ) {
		?><a href="<?php echo get_post_meta( $post_id, "image", true ); ?>" title="<?php echo esc_attr( $meta_data ); ?>" rel="lightbox"><?php woo_image( 'key=image&width='.$width.$height.'&link=img&class='.$align_class ); ?></a><?php
	} else { ?>
    	    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $meta_data ); ?>">
    	    <?php echo woo_image( 'key=image&width='.$width.$height.'&link=img&class='.$align_class ); ?>
    	    </a><?php } ?>
	   	</div><!-- /.media -->
	   	<?php } ?>
	   		    
	    <div class="entry">
			<?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
		</div>
        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
           	
           	<div class="post-shadow"></div>
           	
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div>   
	                         
	</div><!-- /.post -->
	
	        <div class="clear"></div>                                
	
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Articles */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_articles( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'articles');
    ?>
    
	<div class="post">
	
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-text.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">        
	    
	    <?php if (is_singular()) { ?>
	    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	    <?php } ?>
	    	    
	    <div class="entry">
			<?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
		</div>
	         
        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
        	
        	<div class="post-shadow"></div>
           	       
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div>  
	                         
	</div><!-- /.post -->
	
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Videos */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_videos( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'video');
    ?>
	<div class="post video-post">
				
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-video.png" alt="" /></a></span>
        </div><!-- /.posttype -->
        
        <div class="post-content">
                
	    <?php if (is_singular()) { ?>
	    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	    <?php } ?>
	    
        <div class="media">
       	    <?php echo woo_get_embed('video-embed', '580', ''); ?>	
    	</div><!-- /.media --> 
    	    	        
        <div class="entry">
        	<?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
        </div>
        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
        	
        	<div class="post-shadow"></div>
           	       
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div>  
	           
    </div><!-- /.post -->
    
        <div class="clear"></div>                                
	
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Images */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_images( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'images');
    ?>
	<div class="post image-post">
				
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-photo.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">
                
	    <?php if (is_singular()) { ?>
	    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	    <?php } ?>
	    
	    <?php 
    	    // Get Meta Data
    	    $attachments = get_children(array('post_parent' => $post_id,'numberposts' => 1,'post_type' => 'attachment','post_mime_type' => 'image','order' => 'DESC','orderby' => 'menu_order date'));
  			foreach ( $attachments as $att_id => $attachment ) { $meta_data = $attachment->post_title; }
  			if ($meta_data == '') {	$meta_data = get_the_title(); }
    	?>
	    <?php if ( ( ( is_single() ) && ( get_option('woo_thumb_single') == 'true' ) ) || ( is_home() || is_front_page() || is_archive() || is_search() ) ) {	?>
        <div class="media">
    	    <?php if (is_single()) { $width = get_option('woo_tumblog_single_w'); $height = get_option('woo_tumblog_single_h'); } else { $width = get_option('woo_tumblog_thumb_w'); $height = get_option('woo_tumblog_thumb_h'); }   ?>
    	    <?php if (get_option('woo_dynamic_img_height') != 'true') { $height = '&height='.$height; } else { $height = ''; } ?>
    	    <?php if (get_option('woo_image_link_to') == 'image') {
  			?><a href="<?php echo get_post_meta($post_id, "image", true); ?>" title="<?php echo $meta_data; ?>" rel="lightbox"><?php woo_image('key=image&width='.$width.$height.'&link=img'); ?></a><?php  
  			} else { ?>
    	    <a href="<?php the_permalink(); ?>" title="<?php echo $meta_data; ?>">
    	    <?php echo woo_image('key=image&width='.$width.$height.'&link=img'); ?>
    	    </a><?php } ?>
	   	</div><!-- /.media -->
	   	<?php } ?>	            
        <div class="entry">
        	<?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
        </div>
           	       
        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
        	
        	<div class="post-shadow"></div>
           	       
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div>  
                                    
    </div><!-- /.post -->
	
	<?php       
} 

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Links */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_links( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'links');
    ?>
	<div class="post">
				
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-link.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">
                
		<?php if (is_singular()) { ?>
	    <h1 class="title"><a href="<?php echo get_post_meta($post_id,'link-url',true); ?>" rel="bookmark" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php echo get_post_meta($post_id,'link-url',true); ?>" rel="bookmark" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></h2>
	    <?php } ?>	    
                
        <div class="entry">
        	<?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
        </div>
           	       
        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
        	
        	<div class="post-shadow"></div>
           	       
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div>  
                                    
    </div><!-- /.post -->
	
	<?php
} 

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Quotes */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_quotes( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'quotes');
    ?>
	<div class="post quote-post">
		
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-quote.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">
                        
        <div class="media">
        	<blockquote><?php echo get_post_meta($post_id,'quote-copy',true); ?> </blockquote><cite><a href="<?php echo get_post_meta($post_id,'quote-url',true); ?>" title="<?php the_title(); ?>">&#126; <?php echo get_post_meta($post_id,'quote-author',true); ?></a></cite>
        </div><!-- /.media -->
        
        <div class="entry">
            <?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
        </div>
           	       
        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
        	
        	<div class="post-shadow"></div>
           	       
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div>  
                                    
    </div><!-- /.post -->
	
	<?php
}   

/*-----------------------------------------------------------------------------------*/
/* Tumblog Posts - Audio */
/*-----------------------------------------------------------------------------------*/

function woo_tumblog_audio( $post_id = 0, $count = 0, $pagetype = '' ) {
	$service = get_option('woo_url_shorten');
	$category_link = woo_tumblog_category_link($post_id, 'audio');
    ?>
	<div class="post audio-post">
				
        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time('M',$post_id); ?></span><br/>
        	<span class="day"><?php echo get_the_time('d',$post_id); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_post_format_string( get_post_format() ) ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-audio.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">
                
	    <?php if (is_singular()) { ?>
	    <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	    <?php } ?>
	    	            
        <div class="media">
		    <div id='mediaspace<?php echo $post_id; ?>'></div>
		    <?php
		    //Post Args
		    $args = array(
		    	'post_type' => 'attachment',
		    	'numberposts' => -1,
		    	'post_status' => null,
		    	'post_parent' => $post_id
		    );
		    //Get attachements 
		    $attachments = get_posts($args);
		    if ($attachments) {
		    	foreach ($attachments as $attachment) {
		    		$link_url= $attachment->guid;
		    	}
		    }
		    else {
		    	$link_url = get_post_meta($post_id,'audio',true);
		    }
		    if(!empty($link_url)) {
		    ?>
		    <script type='text/javascript'>
		      var so = new SWFObject('<?php bloginfo('template_directory'); ?>/includes/tumblog/player.swf','mpl','440','32','9');
		      so.addParam('allowfullscreen','true');
		      so.addParam('allowscriptaccess','always');
		      so.addParam('wmode','opaque');
		      so.addParam('wmode','opaque');
		      so.addVariable('skin', '<?php bloginfo('template_directory'); ?>/includes/tumblog/stylish_slim.swf');
		      so.addVariable('file','<?php echo $link_url; ?>');
		      so.addVariable('backcolor','000000');
		      so.addVariable('frontcolor','FFFFFF');
		      so.write('mediaspace<?php echo $post_id; ?>');
		    </script>
		    <?php } ?>
		</div><!-- /.audioplayer -->
        
        <div class="entry">
        	<?php if (( ( get_option('woo_home_content') == 'false' ) && ( is_home() ) ) || (( get_option('woo_archive_content') == 'false' ) && ( is_archive() || is_search() || is_tax() ))) {	the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option('woo_archive_content') == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option('woo_home_content') == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
        </div>

        	<div class="post-meta">
        				<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
        				<?php if ($service != 'Off') { ?><span class="shorturl"><a href="<?php echo woo_short_url(get_permalink()); ?>" title="<?php _e('Short URL for', 'woothemes') ?> <?php the_title(); ?>"><?php _e('Short URL', 'woothemes') ?></a></span><?php } ?>
        	</div>
        	
        	<div class="post-shadow"></div>
           	       
	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if(function_exists('getILikeThis')) getILikeThis('get'); ?></span>      
	    		<span class="comments"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comments', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
	    </div> 
                                    
    </div><!-- /.post -->
	
	<?php
}   


/*-----------------------------------------------------------------------------------*/
/* Tumblog Feed */
/*-----------------------------------------------------------------------------------*/

//Rewrite rules for custom feed
function tumblog_feed_rewrite($wp_rewrite) {
	$feed_rules = array(
		'feed/(.+)' => 'index.php?feed=' . $wp_rewrite->preg_index(1)
	);
	$wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
}
//Add rewrite rules filter
add_filter('generate_rewrite_rules', 'tumblog_feed_rewrite');

//Loads Tumblog RSS feed template
function create_my_tumblogfeed() {
	load_template( TEMPLATEPATH . '/includes/tumblog/theme-tumblog-rss.php');
}
//Action hook
add_action('do_feed_tumblog', 'create_my_tumblogfeed', 10, 1); 

//Custom RSS permalink
function custom_rss_permalink($permalink) {
	global $wp_rewrite;
	
	$permalink = $wp_rewrite->get_feed_permastruct();
	if ( '' != $permalink ) {
		
		if ( get_default_feed() == $permalink )
			$feed = '';

		$permalink = str_replace('%feed%', $feed, $permalink);
		$permalink = preg_replace('#/+#', '/', "/$permalink/tumblog/");
		$output =  get_option('home') . user_trailingslashit($permalink, 'feed');
	} else {
		if ( empty($feed) )
			$feed = get_default_feed();

		$feed='tumblog';

		$output = trailingslashit(get_option('home')) . "?feed={$feed}";
	}

	
	
	return $output;
}
//Filter for RSS permalink
$custom_rss_url = get_option('woo_custom_rss');
if ( (isset($custom_rss_url)) && ($custom_rss_url == 'true') ) {
	add_filter('feed_link', 'custom_rss_permalink');
}

?>