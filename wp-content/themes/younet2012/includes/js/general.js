/*-----------------------------------------------------------------------------------*/
/* Add alt-row styling to tables */
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function(){
	jQuery( '.entry table tr:odd').addClass( 'alt-table-row' );
});


/*-----------------------------------------------------------------------------------*/
/* Superfish navigation dropdown */
/*-----------------------------------------------------------------------------------*/
if(jQuery().superfish) {
	jQuery(document).ready(function() {
		jQuery( 'ul.nav').superfish({
			delay: 200,
			animation: {opacity:'show', height:'show'},
			speed: 'fast',
			dropShadows: false
		});
	});
}


// Portfolio tag sorting
jQuery(document).ready(function(){
	
	if ( jQuery( 'ol.dribbbles' ).length ) {
		var container = jQuery( 'ol.dribbbles' );
		container.imagesLoaded( function(){
		  container.masonry();
		});
	}
		
	jQuery( '.port-cat a' ).click( function( evt ) {
		var clicked_cat = jQuery( this ).attr( 'rel' );
		if( clicked_cat == 'all' ){
			jQuery( '#portfolio li.group' ).css( 'opacity','1' );
			jQuery( '#portfolio li.group' ).hide().fadeIn( 200 );
			jQuery('ol.dribbbles').masonry();
		} else {
			jQuery( '#portfolio li.group' ).css( 'opacity', '0.2' );
			jQuery( '#portfolio .' + clicked_cat ).fadeIn( 400 );
			jQuery( '#portfolio .' + clicked_cat ).css( 'opacity','1' );
		}
		return false;
	});	

														
});