<?php if ( have_posts() ) : $count = 0; ?>
<?php while ( have_posts() ) : the_post(); $count++; ?>
<?php
$service = get_option( 'woo_url_shorten' );
$category_link = get_permalink();
?>

	<div class="post">

        <div class="posttype">
        	<p class="date"><span class="month"><?php echo get_the_time( 'M', $post->ID ); ?></span><br/><br/>
        	<span class="day"><?php echo get_the_time( 'd', $post->ID ); ?></span></p>
            <span class="icon"><a href="<?php echo $category_link; ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/ico-text.png" alt="" /></a></span>
        </div><!-- /.posttype -->

        <div class="post-content">

	    <?php if ( is_singular() ) { ?>
	    <h1 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
	    <?php } else { ?>
	    <h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
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

	<?php if ( is_single() ) { woo_subscribe_connect(); } ?>

	<?php $comm = get_option( 'woo_comments' ); if ( ( $comm == "post" || $comm == "both" ) ) : ?>
		<?php comments_template( '', true ); ?>
    <?php endif; ?>
	        <div class="clear"></div>
<?php endwhile; ?>
<?php if ( ! is_singular() ) { woo_pagenav(); } ?>
<?php else: ?>
	<div class="post">
		<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
	</div><!-- /.post -->
<?php endif; ?>  