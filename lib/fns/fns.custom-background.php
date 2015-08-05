<?php
//* Add support for custom background (home page only)
add_action( 'after_setup_theme', 'centric_custom_background_setup' );
function centric_custom_background_setup(){
	$bg_options = array(
		'wp-head-callback' => 'centric_custom_background_frontend',
	);
	add_theme_support( 'custom-background', $bg_options );
}

function centric_custom_background_frontend(){
	if( is_front_page() )
		_custom_background_cb();
}