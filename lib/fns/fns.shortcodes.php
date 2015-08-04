<?php
/**
 * Returns HTML stored in lib/html/
 *
 * @since 1.0.0
 *
 * @return string Specify the HTML to retrieve.
 */
add_shortcode( 'htmlinc', 'html_include' );
function html_include( $atts ){
	extract( shortcode_atts( array(
		'html' => 'relationships',
	), $atts ) );

	$file = dirname( __FILE__ ) . '/../html/' . $html . '.html';
	if( file_exists( $file ) ){
		$html = file_get_contents( $file );
	} else {
		$html = '<p><strong>ERROR:</strong> I could not locate <code>' . basename( $file ) . '</code>.</p>';
	}

	return $html;
}

?>