<?php
/*
Template Name: Portfolio
*/
get_header();
global $woo_options;
?>
       
    <div id="content" class="col-full">

		<div id="main" class="col-left">
		           
		    <div id="portfolio" class="masonry">

			    <h1 class="portfolio-title"><?php echo $woo_options['woo_portfolio_title']; ?><span class="portfolio-tagline"><?php echo $woo_options['woo_portfolio_tagline']; ?></span></h1>
		    
			<!-- Tags -->
			<?php if ( isset( $woo_options['woo_portfolio_tags'] ) && $woo_options['woo_portfolio_tags'] ) { ?>
		    	<div id="port-tags">
		            <div class="fl">
		            	<?php
						$tags = explode( ',', $woo_options['woo_portfolio_tags']); // Tags to be shown
						foreach ( $tags as $tag ) {
							$tag = trim( $tag ); 
							$displaytag = $tag;
							$tag = str_replace ( ' ', '-', $tag );	
							$tag = str_replace ( '/', '-', $tag );
							$tag = strtolower ( $tag );
							$link_tags[] = '<a href="#" rel="' . $tag . '">' . $displaytag . '</a>'; 
						}
						$new_tags = implode( ' ', $link_tags );
						?>
		                <span class="port-cat"><?php _e( 'Select a category:', 'woothemes' ); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="all"><?php _e( 'All','woothemes' ); ?></a>&nbsp;<?php echo $new_tags; ?></span>
		            </div>
		      <div class="fix"></div>
		      </div>
		      
			<?php } ?>
			<!-- /Tags -->		    
		    
			    <?php //do_action('wp_dribbble'); ?>
		    
				<ol class="portfolio dribbbles">
		        <?php
		        	if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; }
		        	
		        	$args = array( 'post_type' => 'portfolio', 'paged' => $paged );
		        	
		        	if ( isset( $woo_options['woo_portfolio_only_tagged'] ) && ( $woo_options['woo_portfolio_only_tagged'] == 'true' ) && is_array( $tags ) && count( $tags ) ) {
		        		$args['tag_slug__in'] = $tags;
		        	}
		        	
		        	query_posts( $args );
		        	
		        	if ( have_posts() ) { $count = 0; while ( have_posts() ) { the_post(); $count++;
		        	
						// Portfolio tags class
						$porttag = ""; 
						$posttags = get_the_tags(); 
						if ($posttags) { 
							foreach($posttags as $tag) { 
								$tag = $tag->name;
								$tag = str_replace ( ' ', '-', $tag );	
								$tag = str_replace ( '/', '-', $tag );
								$tag = strtolower ( $tag );
								$porttag .= $tag . ' '; 
							} 
						} 
					?>  		        
		        
					<li class="group <?php echo $porttag; ?>">
						<div class="dribbble">
							<div class="dribbble-shot">
								<div class="portfolio-img dribbble-img">
									<a href="<?php the_permalink(); ?>" class="dribbble-link"><?php woo_image( 'key=portfolio-image&width=200&link=img' ); ?></a>
									<a href="<?php the_permalink(); ?>" class="dribbble-over"><?php the_title(); ?></a><br/>
										<!-- <span class="dim">Your Player Name</span>  -->
										<span><?php the_time( get_option( 'date_format' ) ); ?></span> 							
								</div>
							</div>
						</div>
					</li>
				<?php if ( $count == 4 ) { ?><div class="fix"></div><?php $count = 0; } ?>
		        <?php
		        		}
		        	} else {
		        ?>
	            <div class="post">
	                <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
	            </div><!-- /.post -->
		        <?php } ?>  
	    
				</ol>		        		        
			
		    </div><!-- /#portfolio -->
                               
            <?php woo_pagenav(); ?>
		</div><!-- /#main -->
        <?php get_sidebar(); ?>
    </div><!-- /#content -->	
<?php get_footer(); ?>