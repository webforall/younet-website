<?php global $woo_options, $portfolio_exclude; $count = 0; ?>
<div id="slides" class="col-full hidden">
	<?php 
	$tag_array = array();
	$GLOBALS['feat_tags_array'] = explode(',',$woo_options['woo_featured_tags']); // Tags to be shown
	foreach ($GLOBALS['feat_tags_array'] as $tags){ 
		$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
		if ( $tag['term_id'] > 0 )
			$tag_array[] = $tag['term_id'];
	}
	?>
	<?php $slides = get_posts( array( 'suppress_filters' => 0 , 'post_type' => 'portfolio', 'numberposts' => $woo_options['woo_slider_entries'], 'tag__in' => $tag_array ) ); ?>
	<?php if ( ! empty( $slides ) ) { ?>
	<div class="slides_container" <?php if($woo_options[ 'woo_slider_entries' ] == 1) { echo 'style="display: block;overflow: hidden;position: relative;"'; }?>>
		
		<?php foreach($slides as $post) { setup_postdata($post); $count++; ?>
			<?php
				$post_thumb = get_option( 'woo_post_image_support' ) == 'true' && has_post_thumbnail();
				if ( $count == 0 ) { $portfolio_exclude = '' . $post->ID; } else { $portfolio_exclude .= ',' . $post->ID; }
			?>
			<div class="slide slide-<?php echo $count; ?>" <?php if( isset( $woo_options['woo_slider_entries'] ) && $woo_options['woo_slider_entries'] == 1 ) { echo 'style="display:block;"'; }?>>
    			<?php
    				if ( ( isset( $woo_options['woo_slider_title'] ) && $woo_options['woo_slider_title'] == 'true' ) || 
    					( isset( $woo_options['woo_slider_content'] ) && $woo_options['woo_slider_content'] == 'true' ) ) {
    			?>
    			<div class="content">
    				<?php if ( $woo_options['woo_slider_title'] == 'true' ) { ?><h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2><?php } ?>
    				<?php if ( $woo_options['woo_slider_content'] == 'true' ) { ?><span><?php the_excerpt(); ?></span><?php } ?>
    			</div><!-- /.content -->
    			<?php } ?>
    			<div class="image">
    				<?php woo_image( 'key=portfolio-image&width=930&height=305&class=slide-img&link=img' ); ?>
    			</div><!-- /.image -->
    		</div><!-- /.slide -->
		<?php } ?>
    </div><!-- /.slides_container -->
	<?php } ?>
</div><!-- /.slides -->