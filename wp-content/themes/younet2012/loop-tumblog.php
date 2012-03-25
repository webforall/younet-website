		<?php $tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
										'images' 	=> get_option('woo_images_term_id'),
										'audio' 	=> get_option('woo_audio_term_id'),
										'video' 	=> get_option('woo_video_term_id'),
										'quotes'	=> get_option('woo_quotes_term_id'),
										'links' 	=> get_option('woo_links_term_id')
										);
		?>   		
		
		<?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <?php $id = get_the_ID(); ?>
	   		
	   		<?php
	   		// Test for Post Formats
			if (get_option('woo_tumblog_content_method') == 'post_format') {
				
				if ( has_post_format( 'aside' , $id )) {
  					woo_tumblog_articles($id,$count);
				} elseif (has_post_format( 'image' , $id )) {
					woo_tumblog_images($id,$count);
				} elseif (has_post_format( 'audio' , $id )) {
					woo_tumblog_audio($id,$count);
				} elseif (has_post_format( 'video' , $id )) {
					woo_tumblog_videos($id,$count);
				} elseif (has_post_format( 'quote' , $id )) {
					woo_tumblog_quotes($id,$count);
				} elseif (has_post_format( 'link' , $id )) {
					woo_tumblog_links($id,$count);
				} else {
					woo_tumblog_default($id,$count);
				}
			
			} else { 
       			//switch between tumblog taxonomies
				$tumblog_list = get_the_term_list( $id, 'tumblog', '' , '|' , ''  );
				$tumblog_list = strip_tags($tumblog_list);
				$tumblog_array = explode('|', $tumblog_list);
				$tumblog_results = '';
				$sentinel = false;
				foreach ($tumblog_array as $location_item) {
    				$tumblog_id = get_term_by( 'name', $location_item, 'tumblog' );
    				if ( $tumblog_items['articles'] == $tumblog_id->term_id && !$sentinel ) {
    					$tumblog_results = 'article';
    					$sentinel = true;
    				} elseif ($tumblog_items['images'] == $tumblog_id->term_id && !$sentinel ) {
    					$tumblog_results = 'image';
    					$sentinel = true;
    				} elseif ($tumblog_items['audio'] == $tumblog_id->term_id && !$sentinel) {
    					$tumblog_results = 'audio';
    					$sentinel = true;
    				} elseif ($tumblog_items['video'] == $tumblog_id->term_id && !$sentinel) {
    					$tumblog_results = 'video';
    					$sentinel = true;
    				} elseif ($tumblog_items['quotes'] == $tumblog_id->term_id && !$sentinel) {
    					$tumblog_results = 'quote';
    					$sentinel = true;
    				} elseif ($tumblog_items['links'] == $tumblog_id->term_id && !$sentinel) {
    					$tumblog_results = 'link';
    					$sentinel = true;
    				} else {
    					$tumblog_results = 'default';
    					$sentinel = false;
    				}	    		
    			}    
    			?>
	    			
    			<?php if ($tumblog_results == 'article') { ?> 
				<!-- ARTICLE POST -->
   				<?php woo_tumblog_articles($id,$count); ?>
				<?php } elseif ($tumblog_results == 'image') { ?>
					<!-- IMAGE POST -->
   					<?php woo_tumblog_images($id,$count); ?>
   				<?php } elseif ($tumblog_results == 'video') { ?>
					<!-- VIDEO POST -->
   					<?php woo_tumblog_videos($id,$count); ?>
   				<?php } elseif ($tumblog_results == 'link') { ?>
					<!-- LINK POST -->
   					<?php woo_tumblog_links($id,$count); ?>
   				<?php } elseif ($tumblog_results == 'audio') { ?>
					<!-- AUDIO POST -->
   					<?php woo_tumblog_audio($id,$count); ?>
   				<?php } elseif ($tumblog_results == 'quote') { ?>
					<!-- QUOTE POST -->
   					<?php woo_tumblog_quotes($id,$count); ?>
				<?php } else { ?>
					<!-- DEFAULT POST -->
   					<?php woo_tumblog_default($id,$count); ?>
    			<?php } ?>
        	<?php } ?>
        	
        	<?php if ( is_single() ) { woo_subscribe_connect(); } ?>
        	
        	<?php $comm = get_option('woo_comments'); if ( ($comm == "post" || $comm == "both") ) : ?>
	        	<?php comments_template('', true); ?>
            <?php endif; ?>
                
	        <?php endwhile; ?>
	        <?php if ( ! is_singular() ) { woo_pagenav(); } ?>
	        <?php else: ?>
	            <div class="post">
	                <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
	            </div><!-- /.post -->
	        <?php endif; ?>