<?php
/**
 * Returns a HTML for a callout
 *
 * @since 1.0.0
 *
 * @param array $args
 * @return string Callout html.
 */
add_shortcode( 'callout', 'centric_html_callout' );
function centric_html_callout( $atts ){
	extract( shortcode_atts( array(
		'link' => '#',
		'linktext' => 'Click Here',
		'message' => 'Your message goes here.',
		'cssclass' => '',
	), $atts ) );

	$format = '<div class="callout%4$s"><div class="one-third first"><a href="%1$s" class="button">%2$s</a></div><div class="two-thirds">%3$s</div></div>';

	return sprintf( $format, $link, $linktext, $message, ' ' . $cssclass );
}

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
		$html = do_shortcode( file_get_contents( $file ) );
		$search = array( '{stylesheetdir}' );
		$replace = array( get_stylesheet_directory_uri() );
		$html = str_replace( $search, $replace, $html );
	} else {
		$html = '<p><strong>ERROR:</strong> I could not locate <code>' . basename( $file ) . '</code>.</p>';
	}

	return $html;
}

?>