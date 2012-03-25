<?php
	get_header();
	global $woo_options, $portfolio_exclude;

	if ( isset($woo_options['woo_slider']) && $woo_options['woo_slider'] == 'true' ) {
		if ( is_home() && isset($woo_options['woo_featured_tags']) && $woo_options['woo_featured_tags'] != '' ) { get_template_part( 'includes/featured' ); } else { get_template_part( 'includes/featured-error' ); }
	}
?>  
    <div id="content" class="col-full">
    	<?php
    		if ( $woo_options['woo_portfolio'] == 'true' ) {
    			get_template_part( 'loop', 'portfolio' );
    		}
    	?>
    	<?php if ( $woo_options['woo_blog_panel'] == 'true' ) { ?>
	    	<div id="blog">
	    		<!-- #main Starts -->
	    		<div id="main" class="col-left">
				
					<?php if ( isset( $woo_options['woo_blog_panel_headers'] ) && $woo_options['woo_blog_panel_headers'] == 'true' ) { ?><h1 class="tumblog-title"><?php echo $woo_options['woo_blog_panel_header']; ?><span class="tumblog-tagline"><?php echo $woo_options['woo_blog_panel_description']; ?></span></h1><?php } ?>          
					<?php
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; query_posts( 'paged=' . $paged . '&post_type=post&posts_per_page=' . $woo_options['woo_blog_number_of_posts'] );
						
						if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {
							get_template_part( 'loop', 'tumblog' );
						} else {
							get_template_part( 'loop', 'default' );
						}
					?>
	    		   <?php if ( ( isset( $woo_options['woo_blog_page_template'] ) ) && ( $woo_options['woo_blog_page_template'] > 0 ) ) { ?><a class="fr" href="<?php echo get_permalink( $woo_options['woo_blog_page_template'] ); ?>" title="<?php esc_attr_e( 'Blog Archive', 'woothemes' ); ?>"><?php _e( 'Blog Archive', 'woothemes' ); ?> &rarr;</a><div class="fix"></div><?php } ?>
	    		   
	    		</div><!-- /#main -->
	    		<?php get_sidebar(); ?>
	    	</div>      
        <?php } ?>
    </div><!-- /#content -->		
<?php get_footer(); ?>