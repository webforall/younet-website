<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>
<?php global $woo_options; ?>
<?php if ( $woo_options['woo_about'] == 'true' && ! is_paged() ): ?>
    <div id="about" class="col-full">

    	<div class="bio fl">

    		<?php if ( $woo_options['woo_header_bio'] != '' ): ?>
   				<p><?php echo stripslashes( $woo_options['woo_header_bio'] ); ?></p>
    		<?php endif; ?>

    	</div><!-- /.bio -->

    	<div id="icons" class="fr">
		<?php if ( $woo_options['woo_social_twitter'] ): ?>
			<a class="social-link ico-twitter" href="<?php echo $woo_options['woo_social_twitter']; ?>" title="Twitter">Twitter</a>
		<?php endif; ?>
    		<?php if ( $woo_options['woo_social_facebook'] ): ?>
    			<a class="social-link ico-facebook" href="<?php echo $woo_options['woo_social_facebook']; ?>" title="Facebook">Facebook</a>
    		<?php endif; ?>
        	<a class="social-link ico-rss" href="<?php if ( $woo_options['woo_feed_url'] ) { echo $woo_options['woo_feed_url']; } else { echo get_bloginfo_rss( 'rss2_url' ); } ?>" title="Subscribe">RSS Feed</a>
		<?php if ( $woo_options['woo_social_email'] ): ?>
			<a class="social-link ico-email" href="<?php echo $woo_options['woo_social_email']; ?>" title="Contact Me">Email</a>
		<?php endif; ?>

        </div><!-- /#icons -->
    	<div class="fix"></div>

    </div><!-- /#about -->
    <?php endif; ?>
       
    <div id="content" class="page col-full">
    	<?php
                        get_template_part( 'includes/featured' );
    			get_template_part( 'loop', 'portfolio' );
    	?>            
    	<?php
    		if ( $woo_options['woo_portfolio'] == 'true' ) {
    			get_template_part( 'loop', 'portfolio' );
    		}
    	?>        
		<div id="main" class="col-left home">
                    <div id="SezioneBlocchi">
                        <div id="BlocchiEvidenza">
                            <div id="InEvidenzaLabel">
                                <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/in_evidenza.png" />
                            </div>
                            <div id="InEvidenzaBlock">
                                <div class="fix"></div>
                                <p></p>
                                <div class="fix"></div>
                                <div class="shadow"></div>
                            </div>
                            <div id="ProgettiAttiviLabel">
                                <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/progetti_attivi.png" /></div>
                            </div>
                            <div id="ProgettiAttiviBlock">
                                <div class="fix"></div>
                                <p></p>
                                <div class="fix"></div>
                                <div class="shadow"></div>
                            </div>
                        <br style="clear: both;" />
                    </div>
		<?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
			<div id="breadcrumbs">
				<?php woo_breadcrumbs(); ?>
			</div>/#breadcrumbs 
		<?php } ?>  			

        <?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <div <?php post_class(); ?>>

			    <h1 class="title"><?php the_title(); ?></h1>

                <div class="entry">
                	<?php the_content(); ?>

					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
               	</div> /.entry 

				<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
                
            </div> /.post 
            
            <?php $comm = $woo_options[ 'woo_comments' ]; if ( ($comm == "page" || $comm == "both") ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
                                                
		<?php endwhile; else: ?>
			<div <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ) ?></p>
            </div> /.post 
        <?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>