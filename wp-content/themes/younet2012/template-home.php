<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>
<?php global $woo_options; ?>
       
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

	<div class="post">

        <div class="post-content">
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
			<?php if ( ( ( get_option( 'woo_home_content' ) == 'false' ) && ( is_home() ) ) || ( ( get_option( 'woo_archive_content' ) == 'false' ) && ( is_archive() || is_search() || is_tax() ) ) ) { the_excerpt(); } elseif ( ( $pagetype == 'archive' ) && ( get_option( 'woo_archive_content' ) == 'false' ) ) { the_excerpt(); } elseif ( ( $pagetype == 'home' ) && ( get_option( 'woo_home_content' ) == 'false' ) ) { the_excerpt(); } else { the_content(); } ?>
		</div>
        	<div class="post-meta">
        				<?php the_tags( '<span class="tags">', ', ', '</span>' ); ?>
        				<?php if ( $service != 'Off' ) { ?><span class="shorturl"><a href="<?php echo woo_short_url( get_permalink() ); ?>" title="<?php esc_attr_e( 'Short URL for', 'woothemes' ); ?> <?php the_title(); ?>"><?php _e( 'Short URL', 'woothemes' ) ?></a></span><?php } ?>
        	</div>

            <div class="post-shadow"></div>

	    </div>
	    <div class="post-more">
	    		<span class="like"><?php if( function_exists( 'getILikeThis' ) ) getILikeThis( 'get' ); ?></span>
	    		<span class="comments"><?php comments_popup_link( __( '0 Comments', 'woothemes' ), __( '1 Comments', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?></span>
	    </div>

	</div><!-- /.post -->

                    <?php endwhile;?>
                <?php else: ?>
                    <div <?php post_class(); ?>>
                        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ) ?></p>
                    </div> 
                <?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>