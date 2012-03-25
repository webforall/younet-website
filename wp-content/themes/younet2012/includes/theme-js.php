<?php
if ( !is_admin() ) { add_action( 'wp_print_scripts', 'woothemes_add_javascript' ); }
if ( !function_exists( 'woothemes_add_javascript' ) ) {
	function woothemes_add_javascript( ) {
		$template_directory = get_template_directory_uri();

		wp_enqueue_script( 'superfish', $template_directory . '/includes/js/superfish.js', array( 'jquery' ) );
		wp_enqueue_script( 'masonry', $template_directory . '/includes/js/jquery.masonry.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'general', $template_directory . '/includes/js/general.js', array( 'jquery' ) );

		// Load the JavaScript for the slides on the homepage.
		if ( true||is_home() ) {
			wp_enqueue_script( 'slides', $template_directory . '/includes/js/slides.min.jquery.js', array( 'jquery' ) );
		}
		wp_enqueue_script( 'mp3', $template_directory . '/includes/tumblog/swfobject.js' );
	}
}
?>