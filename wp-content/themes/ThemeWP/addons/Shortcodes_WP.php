<?php
/**
 * @package WordPress
 * @subpackage ProjectName
 **/
####################################################################################################

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Shortcodes_WP
 **/
$Shortcodes_WP = new Shortcodes_WP();
$Shortcodes_WP->init();
class Shortcodes_WP {

	/**
	 * __construct
	 **/
	function __construct() {}


	/**
	 * init
	 **/
	function init() {

		add_shortcode( 'button', [ $this, 'button' ] );

	} // end function init


	####################################################################################################
	/**
	 * Functionality
	 **/
	####################################################################################################


	/**
	 * button
	 * @since 1.0
	 * [button id="css-id" title="Title" class="white" link="http://example.com" href="http://example.com/things" target="_blank" text="Button Text" inline="false"]
	 * Note: if both link and href exist, href has priority.
	 **/
	function button( $atts ) {

		$atts = shortcode_atts( [
			'id' => '',
			'title' => 'Button title',
			'class' => '',
			'link' => false,
			'href' => false,
			'target' => '',
			'text' => 'Button Text',
			'inline' => ''
		], $atts, 'button' );

		$inline = false;
		if ( $atts['inline'] == "true" ) {
			$inline = true;
		}
		if ( ! empty( $atts['link'] ) ) {
			$href = $atts['link'];
		}
		if ( ! empty( $atts['href'] ) ) {
			$href = $atts['href'];
		}

		$output = '';
		if ( ! $inline ) {
			$output .= '<div class="btn-wrap">';
		}
		$output .= '<a id="' . $atts['id'] . '" title="' . esc_attr( $atts['title'] ) . '" class="button ' . $atts['class'] . '" href="' . $href . '" target="' . $atts['target'] . '">';
			$output .= $atts['text'];
		$output .= '</a>';
		if ( ! $inline ) {
			$output .= '</div>';
		}

		return $output;

	} // end function button

} // end class Shortcodes_WP
