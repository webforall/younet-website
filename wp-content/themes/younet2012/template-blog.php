<?php
/*
Template Name: Blog
*/

get_header();
global $woo_options;

$blog_title = __( 'Tumblog', 'woothemes' );
$blog_tagline = __( 'Writings, musings and generally lighthearted bantee', 'woothemes' );

if ( isset( $woo_options['woo_blog_title'] ) && ( $woo_options['woo_blog_title'] != '' ) ) {
	$blog_title = stripslashes( $woo_options['woo_blog_title'] );
}

if ( isset( $woo_options['woo_blog_tagline'] ) && ( $woo_options['woo_blog_tagline'] != '' ) ) {
	$blog_tagline = stripslashes( $woo_options['woo_blog_tagline'] );
}
?>
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">

        <!-- #main Starts -->
        <div id="main" class="col-left">

			<h1 class="tumblog-title"><?php echo $blog_title; ?><span class="tumblog-tagline"><?php echo $blog_tagline; ?></span></h1>
<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
if ( is_front_page() ) {
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
}

query_posts( 'post_type=post&paged=' . $paged );

if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {
	get_template_part( 'loop', 'tumblog' );	
} else {
	get_template_part( 'loop', 'default' );
}

//woo_pagenav();
?>
        </div><!-- /#main -->

		<?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>