<?php
namespace CentricPro\shortcodes;

/**
 * Returns a HTML for a callout
 *
 * @since 1.0.0
 *
 * @param array $args
 * @return string Callout html.
 */
function html_callout( $atts ){
	extract( \shortcode_atts( array(
		'link' => '#',
		'linktext' => 'Click Here',
		'message' => 'Your message goes here.',
		'cssclass' => '',
	), $atts ) );

	$format = '<div class="callout%4$s"><div class="one-third first"><a href="%1$s" class="button">%2$s</a></div><div class="two-thirds">%3$s</div></div>';

	return sprintf( $format, $link, $linktext, $message, ' ' . $cssclass );
}
\add_shortcode( 'callout', __NAMESPACE__ . '\\html_callout' );

/**
 * Returns HTML stored in lib/html/
 *
 * @since 1.0.0
 *
 * @return string Specify the HTML to retrieve.
 */
function html_include( $atts ){
	extract( \shortcode_atts( array(
		'html' => 'relationships',
	), $atts ) );

	$file = dirname( __FILE__ ) . '/../html/' . $html . '.html';
	if( file_exists( $file ) ){
		$html = \do_shortcode( file_get_contents( $file ) );
		$search = array( '{stylesheetdir}' );
		$replace = array( get_stylesheet_directory_uri() );
		$html = str_replace( $search, $replace, $html );
	} else {
		$html = '<p><strong>ERROR:</strong> I could not locate <code>' . basename( $file ) . '</code>.</p>';
	}

	return $html;
}
\add_shortcode( 'htmlinc', __NAMESPACE__ . '\\html_include' );

/**
 * Replaces [stylesheetdir] with the value of get_stylesheet_directory_uri.
 *
 * @return     string  The stylesheet directory URI
 */
function stylesheetdir(){
	return \get_stylesheet_directory_uri();
}
\add_shortcode( 'stylesheetdir', __NAMESPACE__ . '\\stylesheetdir' );

?>