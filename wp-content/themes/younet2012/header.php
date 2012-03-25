<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<?php global $woo_options; ?>

<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( $woo_options['woo_feed_url'] ) { echo $woo_options['woo_feed_url']; } else { echo get_bloginfo_rss( 'rss2_url' ); } ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
<?php woo_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php woo_top(); ?>

<div id="wrapper">

	<div id="strip"></div>

	<?php if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'top-menu' ) ) { ?>

	<div id="top">
		<div class="col-full">
			<?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'top-nav', 'menu_class' => 'nav fl', 'theme_location' => 'top-menu' ) ); ?>
		</div>
	</div><!-- /#top -->

    <?php } ?>

	<div id="header" class="col-full">

		<div id="logo" class="fl">
                    
                  

		<?php if ( $woo_options['woo_texttitle'] != 'true' ) : $logo = $woo_options['woo_logo']; ?>
			<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'description' ); ?>">
				<img src="<?php if ( $logo ) echo $logo; else { echo get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
        <?php endif; ?>

        <?php if( is_singular() && !is_front_page() ) : ?>
			<span class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></span>
        <?php else : ?>
			<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <?php endif; ?>
			<span class="site-description"><?php bloginfo( 'description' ); ?></span>

		</div><!-- /#logo -->
                
                
<?php if ( $woo_options['woo_about'] == 'true' && ! is_paged() ): ?>
    <div id="about" class="col-full">
        
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

    	<div class="bio">

    		<?php if ( $woo_options['woo_header_bio'] != '' ): ?>
   				<p><?php echo stripslashes( $woo_options['woo_header_bio'] ); ?></p>
    		<?php endif; ?>

    	</div><!-- /.bio -->

    	<div class="fix"></div>

    </div><!-- /#about -->
    <?php endif; ?>                  
                

		<?php if ( $woo_options['woo_ad_top'] == 'true' ) { ?>
        <div id="topad">
			<?php if ( $woo_options['woo_ad_top_adsense'] != '' ) { echo stripslashes( $woo_options['woo_ad_top_adsense'] );  } else { ?>
				<a href="<?php echo $woo_options['woo_ad_top_url']; ?>"><img src="<?php echo $woo_options['woo_ad_top_image']; ?>" width="468" height="60" alt="advert" /></a>
			<?php } ?>
		</div><!-- /#topad -->
        <?php } ?>

	</div><!-- /#header -->

	<div id="navigation" class="col-full">
		<?php
if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
	wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
} else {
?>
        <ul id="main-nav" class="nav fl">
			<?php
	if ( isset( $woo_options['woo_custom_nav_menu'] ) and $woo_options['woo_custom_nav_menu'] == 'true' ) {
		if ( function_exists( 'woo_custom_navigation_output' ) )
			woo_custom_navigation_output();
	} else { ?>
	            <?php if ( is_page() ) $highlight = "page_item"; else $highlight = "page_item current_page_item"; ?>
	            <li class="<?php echo $highlight; ?>"><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home', 'woothemes' ) ?></a></li>
	            <?php
		wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' );
	}
?>
        </ul><!-- /#nav -->
        <?php } ?>
        <div class="search_main fr">
    <form method="get" class="searchform" action="<?php echo home_url( '/' ); ?>" >
        <input type="text" class="field s" name="s" value="" onfocus="if (this.value == '') {this.value = '';}" onblur="if (this.value == '') {this.value = '';}" />
        <input type="image" src="<?php echo get_template_directory_uri(); ?>/images/ico-search.png" class="search-submit" name="submit" value="<?php esc_attr_e( 'Go', 'woothemes' ); ?>" />
    </form>
    <div class="fix"></div>
</div>


	</div><!-- /#navigation -->